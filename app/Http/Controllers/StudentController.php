<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Subject;
use App\Models\Session;
use App\Models\Review;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    /**
     * Show the student dashboard.
     */
    public function dashboard(Request $request)
    {
        $student = Auth::user();
        $upcomingSessions = Session::where('student_id', $student->id)
                                   ->where('status', 'scheduled')
                                   ->with('tutor', 'subject')
                                   ->orderBy('session_date', 'asc')
                                   ->get();

        $progressReports = Session::where('student_id', $student->id)
                                  ->where('status', 'completed')
                                  ->whereNotNull('tutor_notes')
                                  ->with('tutor', 'subject')
                                  ->get();

        return view('student.dashboard', compact('student', 'upcomingSessions', 'progressReports'));
    }

    /**
     * Show the tutor discovery page.
     */
    /**
     * Show the tutor discovery page with search and filters.
     */
    public function showTutorDiscovery(Request $request)
    {
        $query = User::whereHas('role', fn($q) => $q->where('name', 'tutor'))
                     ->where('is_verified', true)
                     ->with(['tutorProfile.location', 'subjects']);

        // Filter by Tutor Name
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        // Filter by Subject
        if ($request->filled('subject_id')) {
            $query->whereHas('subjects', fn($q) => $q->where('subject_id', $request->input('subject_id')));
        }

        // Filter by Location
        if ($request->filled('location_id')) {
            $query->whereHas('tutorProfile', fn($q) => $q->where('location_id', $request->input('location_id')));
        }
        
        // Filter by Rating
        if ($request->filled('min_rating')) {
            $query->whereHas('tutorProfile', fn($q) => $q->where('rating', '>=', $request->input('min_rating')));
        }

        // Filter by Experience
        if ($request->filled('min_experience')) {
            $query->whereHas('tutorProfile', fn($q) => $q->where('experience_years', '>=', $request->input('min_experience')));
        }

        // Filter by Hourly Rate (requires a join)
        if ($request->filled('min_rate')) {
            $query->whereHas('subjects', fn($q) => $q->where('subject_user.hourly_rate', '>=', $request->input('min_rate')));
        }
        if ($request->filled('max_rate')) {
            $query->whereHas('subjects', fn($q) => $q->where('subject_user.hourly_rate', '<=', $request->input('max_rate')));
        }

        $tutors = $query->paginate(10);
        
        $subjects = Subject::all();
        $locations = Location::all();

        return view('student.tutor-discovery', compact('tutors', 'subjects', 'locations'));
    }   

    /**
     * Show a single tutor's profile.
     */
    public function showTutorProfile(User $tutor)
    {
        // Ensure the user is a verified tutor
        if ($tutor->role->name !== 'tutor' || !$tutor->is_verified) {
            return redirect()->route('student.discovery')->with('error', 'Tutor not found.');
        }

        $tutor->load('tutorProfile', 'subjects', 'reviews.student');
        $reviews = $tutor->reviews;

        return view('student.tutor-profile', compact('tutor', 'reviews'));
    }

    /**
     * Book a session with a tutor.
     */
    public function bookSession(Request $request)
    {
        $validatedData = $request->validate([
            'tutor_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id',
            'session_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        // Check if the tutor is available at this time. (Simplified for MVP)
        // Check for conflicting sessions...

        Session::create([
            'student_id' => Auth::id(),
            'tutor_id' => $validatedData['tutor_id'],
            'subject_id' => $validatedData['subject_id'],
            'session_date' => $validatedData['session_date'],
            'start_time' => $validatedData['start_time'],
            'end_time' => $validatedData['end_time'],
            'status' => 'scheduled',
        ]);

        return back()->with('success', 'Session booked successfully!');
    }

    /**
     * Show the review form for a completed session.
     */
    public function showReviewForm(Session $session)
    {
        if ($session->student_id !== Auth::id() || $session->status !== 'completed' || $session->review) {
            return back()->with('error', 'This session cannot be reviewed.');
        }

        return view('student.review', compact('session'));
    }

    /**
     * Submit a review for a session.
     */
    public function submitReview(Request $request, Session $session)
    {
        if ($session->student_id !== Auth::id() || $session->status !== 'completed' || $session->review) {
            return back()->with('error', 'This session cannot be reviewed.');
        }

        $validatedData = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        Review::create([
            'session_id' => $session->id,
            'student_id' => Auth::id(),
            'tutor_id' => $session->tutor_id,
            'rating' => $validatedData['rating'],
            'comment' => $validatedData['comment'],
        ]);

        // Update the tutor's average rating (simple logic)
        $tutor = $session->tutor;
        $averageRating = $tutor->reviews()->avg('rating');
        $tutor->tutorProfile->rating = $averageRating;
        $tutor->tutorProfile->save();

        return redirect()->route('student.dashboard')->with('success', 'Review submitted successfully!');
    }
}