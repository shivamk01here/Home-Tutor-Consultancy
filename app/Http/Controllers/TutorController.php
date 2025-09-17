<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Subject;
use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TutorController extends Controller
{
    /**
     * Show the tutor dashboard.
     */
    public function dashboard()
    {
        $tutor = Auth::user();
        $sessions = Session::where('tutor_id', $tutor->id)
                           ->with('student', 'subject')
                           ->orderBy('session_date', 'asc')
                           ->get();

        $totalEarnings = 0; // We'll calculate this later with payments
        $pendingPayments = 0;

        return view('tutor.dashboard', compact('tutor', 'sessions', 'totalEarnings', 'pendingPayments'));
    }

    /**
     * Show the form to manage a tutor's profile.
     */
    public function showProfileForm()
    {
        $tutor = Auth::user();
        $allSubjects = Subject::all();

        // Get subjects the tutor already teaches
        $tutorSubjects = $tutor->subjects->pluck('id')->toArray();

        return view('tutor.profile', compact('tutor', 'allSubjects', 'tutorSubjects'));
    }

    /**
     * Update a tutor's profile.
     */
    public function updateProfile(Request $request)
    {
        $tutor = Auth::user();
        $validatedData = $request->validate([
            'bio' => 'nullable|string',
            'hourly_rate' => 'nullable|numeric|min:0',
            'subject_ids' => 'nullable|array',
        ]);

        $tutor->tutorProfile->bio = $validatedData['bio'];
        $tutor->tutorProfile->save();
        
        // Sync subjects with the hourly rate from the pivot table
        $syncData = [];
        if ($request->has('subject_ids')) {
            foreach ($request->subject_ids as $subjectId) {
                $syncData[$subjectId] = ['hourly_rate' => $validatedData['hourly_rate'] ?? 0];
            }
        }
        $tutor->subjects()->sync($syncData);

        return back()->with('success', 'Profile updated successfully.');
    }

    public function showSessionManagement(Session $session)
    {
        if ($session->tutor_id !== Auth::id()) {
            return back()->with('error', 'You are not authorized to manage this session.');
        }

        return view('tutor.session-management', compact('session'));
    }

    /**
     * Complete a session and submit a progress report.
     */
    public function completeSession(Request $request, Session $session)
    {
        if ($session->tutor_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        $validatedData = $request->validate([
            'tutor_notes' => 'required|string',
            'session_status' => 'required|in:completed,canceled',
        ]);

        $session->update([
            'status' => $validatedData['session_status'],
            'tutor_notes' => $validatedData['tutor_notes'],
        ]);

        return redirect()->route('tutor.dashboard')->with('success', 'Session updated successfully.');
    }
    public function showHybridLearning()
    {
        $resources = \App\Models\LearningResource::where('tutor_id', Auth::id())->get();
        return view('tutor.hybrid-learning', compact('resources'));
    }

    /**
     * Upload a new learning resource.
     */
    public function uploadResource(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,zip,rar|max:50000', // 50MB max
        ]);

        $filePath = $request->file('file')->store('public/resources');
        
        LearningResource::create([
            'tutor_id' => Auth::id(),
            'title' => $validatedData['title'],
            'file_path' => $filePath,
        ]);

        return back()->with('success', 'Resource uploaded successfully.');
    }
}