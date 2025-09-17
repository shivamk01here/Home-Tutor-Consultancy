<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TutorProfile;
use App\Models\Location;
use App\Models\Subject;
use App\Models\Session;
use App\Models\Payment;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;


class AdminController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function dashboard()
    {
        $pendingTutors = User::whereHas('role', function ($query) {
            $query->where('name', 'tutor');
        })->where('is_verified', false)->with('tutorProfile')->get();

        $totalStudents = User::whereHas('role', function ($query) {
            $query->where('name', 'student');
        })->count();

        $totalTutors = User::whereHas('role', function ($query) {
            $query->where('name', 'tutor');
        })->count();

        return view('admin.dashboard', compact('pendingTutors', 'totalStudents', 'totalTutors'));
    }

    /**
     * Verify a tutor's account.
     */
    public function verifyTutor(Request $request, User $tutor)
    {
        if ($tutor->role->name !== 'tutor') {
            return back()->with('error', 'User is not a tutor.');
        }

        $tutor->is_verified = true;
        $tutor->save();

        // Update the police verification status in the tutor profile
        $tutor->tutorProfile->police_verification_status = 'verified';
        $tutor->tutorProfile->save();

        return back()->with('success', 'Tutor account verified successfully.');
    }

    /**
     * Delete a tutor's account.
     */
    public function deleteTutor(User $tutor)
    {
        if ($tutor->role->name !== 'tutor') {
            return back()->with('error', 'User is not a tutor.');
        }

        $tutor->delete();

        return back()->with('success', 'Tutor account deleted successfully.');
    }


    public function showPayments()
    {
        $sessions = Session::with(['student', 'tutor', 'subject', 'payment'])
                           ->where('status', 'completed')
                           ->orderBy('session_date', 'desc')
                           ->get();
        return view('admin.payments', compact('sessions'));
    }
    
    /**
     * Mark a session as paid.
     */
    public function markPayment(Request $request, Session $session)
    {
        // Calculate the amount (simple for now: just based on tutor's hourly rate)
        $tutorHourlyRate = $session->tutor->subjects->where('id', $session->subject_id)->first()->pivot->hourly_rate ?? 0;
        $sessionDurationHours = (\Carbon\Carbon::parse($session->end_time)->diffInMinutes(\Carbon\Carbon::parse($session->start_time))) / 60;
        $amount = $tutorHourlyRate * $sessionDurationHours;

        Payment::updateOrCreate(
            ['session_id' => $session->id],
            [
                'student_id' => $session->student_id,
                'tutor_id' => $session->tutor_id,
                'amount' => $amount,
                'status' => 'paid',
            ]
        );

        return back()->with('success', 'Payment marked as paid.');
    }


    // ===================================
    // SUBJECT MANAGEMENT
    // ===================================
    public function showSubjectManagement()
    {
        $subjects = Subject::all();
        return view('admin.subjects.index', compact('subjects'));
    }

    public function createSubject(Request $request)
    {
        $request->validate(['name' => 'required|string|unique:subjects']);
        Subject::create(['name' => $request->name]);
        return back()->with('success', 'Subject created successfully.');
    }

    // ===================================
    // TUTOR MANAGEMENT
    // ===================================
    public function showTutors(Request $request)
    {
        $query = User::whereHas('role', fn($q) => $q->where('name', 'tutor'))
                     ->with(['tutorProfile.location', 'subjects']);

        if ($request->filled('location_id')) {
            $query->whereHas('tutorProfile', fn($q) => $q->where('location_id', $request->location_id));
        }
        if ($request->filled('subject_id')) {
            $query->whereHas('subjects', fn($q) => $q->where('subject_id', $request->subject_id));
        }
        if ($request->filled('rating')) {
            $query->whereHas('tutorProfile', fn($q) => $q->where('rating', '>=', $request->rating));
        }
        if ($request->filled('experience')) {
            $query->whereHas('tutorProfile', fn($q) => $q->where('experience_years', '>=', $request->experience));
        }

        $tutors = $query->paginate(10);
        $locations = Location::all();
        $subjects = Subject::all();

        return view('admin.tutors.index', compact('tutors', 'locations', 'subjects'));
    }

    public function showTutorCreateForm()
    {
        $subjects = Subject::all();
        $locations = Location::all();
        return view('admin.tutors.create', compact('subjects', 'locations'));
    }
    
    public function createTutor(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'profile_photo' => 'nullable|image|max:2048',
            'identity_proof' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'current_designation' => 'nullable|string',
            'qualification' => 'required|string',
            'experience_years' => 'required|integer|min:0',
            'location_id' => 'required|exists:locations,id',
            'subject_ids' => 'required|array',
            'rating' => 'nullable|numeric|min:0|max:5',
            'hourly_rates' => 'nullable|array',
            'packages' => 'nullable|array',
            'is_verified' => 'boolean',
        ]);
        
        $tutorRole = \App\Models\Role::where('name', 'tutor')->first();
        if (!$tutorRole) return back()->with('error', 'Tutor role not found.');

        $profilePhotoPath = $request->hasFile('profile_photo') 
            ? $request->file('profile_photo')->store('public/profile-photos') 
            : null;

        $identityProofPath = $request->hasFile('identity_proof')
            ? $request->file('identity_proof')->store('private/tutor-documents')
            : null;

        $user = User::create([
            'role_id' => $tutorRole->id,
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'profile_photo_path' => $profilePhotoPath,
            'is_verified' => $request->has('is_verified') ? true : false,
        ]);

        $profile = TutorProfile::create([
            'user_id' => $user->id,
            'qualification' => $validatedData['qualification'],
            'experience_years' => $validatedData['experience_years'],
            'current_designation' => $validatedData['current_designation'],
            'identity_proof_path' => $identityProofPath,
            'rating' => $validatedData['rating'] ?? 0,
            'location_id' => $validatedData['location_id'],
            'packages' => $validatedData['packages'] ?? [],
        ]);

        $syncData = collect($validatedData['subject_ids'])->mapWithKeys(function ($subjectId) use ($validatedData) {
            return [$subjectId => ['hourly_rate' => $validatedData['hourly_rates'][$subjectId] ?? 0]];
        })->toArray();
        $user->subjects()->sync($syncData);

        return back()->with('success', 'Tutor added successfully.');
    }

    public function showTutorDetails(User $tutor)
    {
        $tutor->load('tutorProfile.location', 'subjects');
        return view('admin.tutors.show', compact('tutor'));
    }

    // ===================================
    // STUDENT MANAGEMENT
    // ===================================
    public function showStudents()
    {
        $students = User::whereHas('role', fn($q) => $q->where('name', 'student'))
                        ->with(['studentProfile.location', 'subjectsOfInterest'])
                        ->paginate(10);
        return view('admin.students.index', compact('students'));
    }

    public function showStudentCreateForm()
    {
        $subjects = Subject::all();
        $locations = Location::all();
        return view('admin.students.create', compact('subjects', 'locations'));
    }

    public function createStudent(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'nullable|string|max:255',
            'parent_name' => 'required|string|max:255',
            'parent_contact' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'profile_photo' => 'nullable|image|max:2048',
            'location_id' => 'required|exists:locations,id',
            'subjects_of_interest' => 'required|array|max:5',
        ]);
        
        $studentRole = \App\Models\Role::where('name', 'student')->first();
        if (!$studentRole) return back()->with('error', 'Student role not found.');

        $profilePhotoPath = $request->hasFile('profile_photo')
            ? $request->file('profile_photo')->store('public/profile-photos')
            : null;

        $user = User::create([
            'role_id' => $studentRole->id,
            'name' => $validatedData['name'] . ' ' . $validatedData['surname'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'profile_photo_path' => $profilePhotoPath,
            'is_verified' => true,
        ]);
        
        \App\Models\StudentProfile::create([
            'user_id' => $user->id,
            'parent_name' => $validatedData['parent_name'],
            'parent_contact' => $validatedData['parent_contact'],
            'profile_photo_path' => $profilePhotoPath,
            'location_id' => $validatedData['location_id'],
        ]);

        $user->subjectsOfInterest()->sync($validatedData['subjects_of_interest']);

        return back()->with('success', 'Student enrolled successfully.');
    }
    
    public function showStudentDetails(User $student)
    {
        // Eager load the studentProfile and subjectsOfInterest relationships
        $student->load(['studentProfile.location', 'subjectsOfInterest']);
        
        $payments = Payment::where('student_id', $student->id)->orderBy('created_at', 'desc')->get();
        
        return view('admin.students.show', compact('student', 'payments'));
    }

    // ===================================
    // TOPIC MANAGEMENT
    // ===================================
    public function showTopics(Request $request)
    {
        $subjects = Subject::all();
        $topics = \App\Models\Topic::with('subject')
                        ->when($request->subject_id, fn($q) => $q->where('subject_id', $request->subject_id))
                        ->get();
        return view('admin.topics.index', compact('topics', 'subjects'));
    }

    public function createTopic(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
        ]);
        \App\Models\Topic::create($request->all());
        return back()->with('success', 'Topic created successfully.');
    }

    // ===================================
    // MOCK TEST MANAGEMENT
    // ===================================
    public function showMockTests(Request $request)
    {
        $subjects = Subject::all();
        $topics = \App\Models\Topic::all();

        $query = \App\Models\MockTest::with(['subject', 'topic']);
        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }
        if ($request->filled('topic_id')) {
            $query->where('topic_id', $request->topic_id);
        }
        $mockTests = $query->get();

        return view('admin.mock-tests.index', compact('mockTests', 'subjects', 'topics'));
    }

    public function showMockTestCreateForm()
    {
        $subjects = Subject::all();
        $topics = \App\Models\Topic::all(); // We will use JavaScript to filter this on the form
        return view('admin.mock-tests.create', compact('subjects', 'topics'));
    }

    public function createMockTest(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'subject_id' => 'required|exists:subjects,id',
            'topic_id' => 'required|exists:topics,id',
            'questions' => 'required|array',
            'questions.*.question_text' => 'required|string',
            'questions.*.options.A' => 'required|string',
            'questions.*.options.B' => 'required|string',
            'questions.*.options.C' => 'required|string',
            'questions.*.options.D' => 'required|string',
            'questions.*.options.E' => 'nullable|string',
            'questions.*.correct_answer' => 'required|in:A,B,C,D,E',
        ]);

        $mockTest = \App\Models\MockTest::create([
            'title' => $validated['title'],
            'subject_id' => $validated['subject_id'],
            'topic_id' => $validated['topic_id'],
        ]);

        foreach ($validated['questions'] as $questionData) {
            $mockTest->questions()->create([
                'question_text' => $questionData['question_text'],
                'option_a' => $questionData['options']['A'],
                'option_b' => $questionData['options']['B'],
                'option_c' => $questionData['options']['C'],
                'option_d' => $questionData['options']['D'],
                'option_e' => $questionData['options']['E'] ?? null,
                'correct_answer' => $questionData['correct_answer'],
            ]);
        }

        return redirect()->route('admin.mock-tests.index')->with('success', 'Mock test created successfully.');
    }
}