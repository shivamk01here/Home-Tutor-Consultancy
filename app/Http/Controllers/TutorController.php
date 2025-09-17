<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Subject;
use App\Models\Session;
use App\Models\LearningResource;
use App\Models\TutorProfile; 
use App\Models\MockTest;
use App\Models\MockTestResult;
use App\Models\Feedback;
use App\Models\TutorPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\tutorPackages;

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
            'packages_online_title' => 'nullable|string',
            'packages_online_description' => 'nullable|string',
            'packages_offline_title' => 'nullable|string',
            'packages_offline_description' => 'nullable|string',
            'packages_one_on_one_title' => 'nullable|string',
            'packages_one_on_one_description' => 'nullable|string',
        ]);

        // Sync subjects with hourly rate on pivot table
        $syncData = [];
        if (!empty($validatedData['subject_ids'])) {
            foreach ($validatedData['subject_ids'] as $subjectId) {
                $syncData[$subjectId] = ['hourly_rate' => $validatedData['hourly_rate'] ?? 0];
            }
        }
        // Check if tutor has subjects relationship defined in User model
        if (method_exists($tutor, 'subjects')) {
            $tutor->subjects()->sync($syncData);
        } else {
            // Log error or handle the case where subjects relationship is not defined
            Log::error('Subjects relationship not defined for User model');
            return back()->with('error', 'Unable to update subjects. Please contact support.');
        }

        // Build packages array
        $packages = [];
        if (!empty($validatedData['packages_offline_title'])) {
            $packages['offline'] = [
                'title' => $validatedData['packages_offline_title'],
                'description' => $validatedData['packages_offline_description'] ?? null,
            ];
        }
        if (!empty($validatedData['packages_online_title'])) {
            $packages['online'] = [
                'title' => $validatedData['packages_online_title'],
                'description' => $validatedData['packages_online_description'] ?? null,
            ];
        }
        if (!empty($validatedData['packages_one_on_one_title'])) {
            $packages['one_on_one'] = [
                'title' => $validatedData['packages_one_on_one_title'],
                'description' => $validatedData['packages_one_on_one_description'] ?? null,
            ];
        }

        // Update or create TutorProfile
        TutorProfile::updateOrCreate(
            ['user_id' => $tutor->id],
            [
                'bio' => $validatedData['bio'] ?? null,
                'packages' => $packages,
            ]
        );

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
    // public function completeSession(Request $request, Session $session)
    // {
    //     if ($session->tutor_id !== Auth::id()) {
    //         return back()->with('error', 'Unauthorized action.');
    //     }

    //     $validatedData = $request->validate([
    //         'tutor_notes' => 'required|string',
    //         'session_status' => 'required|in:completed,canceled',
    //     ]);

    //     $session->update([
    //         'status' => $validatedData['session_status'],
    //         'tutor_notes' => $validatedData['tutor_notes'],
    //     ]);

    //     return redirect()->route('tutor.dashboard')->with('success', 'Session updated successfully.');
    // }
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

    public function showFeedbackForm()
    {
        return view('tutor.feedback.create');
    }

    public function submitFeedback(Request $request)
    {
        $validated = $request->validate([
            'likes' => 'nullable|string|max:2000',
            'dislikes' => 'nullable|string|max:2000',
            'suggestions' => 'nullable|string|max:2000',
            'rating' => 'required|integer|min:1|max:5',
        ]);
        
        Feedback::create([
            'user_id' => Auth::id(),
            'likes' => $validated['likes'],
            'dislikes' => $validated['dislikes'],
            'suggestions' => $validated['suggestions'],
            'rating' => $validated['rating'],
        ]);
        
        return back()->with('success', 'Thank you for your valuable feedback!');
    }


    // ===================================
    // NEW PACKAGE MANAGEMENT
    // ===================================
    public function showPackageManagement()
    {
        $tutor = Auth::user();
        $packages = $tutor->tutorPackages()->with('subject')->get();
        $subjects = $tutor->subjects; // Get subjects tutor teaches
        return view('tutor.packages.index', compact('packages', 'subjects'));
    }
    public function createPackage(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'package_type' => 'required|in:one_on_one,online_batch,offline',
            'rate' => 'required|numeric|min:0',
            'rate_unit' => 'required|in:per_hour,per_month',
            'description' => 'nullable|string',
        ]);
        Auth::user()->tutorPackages()->create($request->all());
        return back()->with('success', 'Package created successfully!');
    }
    // ===================================
    // NEW SESSIONS & EARNINGS
    // ===================================
    public function showSessions()
    {
        $sessions = Session::where('tutor_id', Auth::id())
            ->with(['student', 'tutorPackage.subject'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('tutor.sessions.index', compact('sessions'));
    }
    public function completeSession(Session $session)
    {
        if ($session->tutor_id !== Auth::id()) {
            abort(403);
        }
        $session->update(['status' => 'completed', 'payment_status' => 'paid']);
        return back()->with('success', 'Session marked as completed and payment received!');
    }
    public function showEarnings()
    {
        $completedSessions = Session::where('tutor_id', Auth::id())
            ->where('status', 'completed')
            ->with('tutorPackage')
            ->get();
        $totalEarnings = $completedSessions->sum(fn($session) => $session->tutorPackage->rate);
        return view('tutor.earnings.index', compact('totalEarnings', 'completedSessions'));
    }
}