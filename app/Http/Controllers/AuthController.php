<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\TutorProfile;
use App\Models\StudentProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // Show registration choice form
    public function showRegistrationChoiceForm()
    {
        return view('auth.register-choice');
    }

    // Show student registration form
    public function showStudentRegistrationForm()
    {
        return view('auth.register-student');
    }

    // Handle student registration
    public function registerStudent(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'parent_name' => 'required|string|max:255',
        ]);

        $studentRole = Role::where('name', 'student')->first();
        if (!$studentRole) {
            return back()->withErrors(['role' => 'Student role not found.']);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $studentRole->id,
            'is_verified' => true,
        ]);

        StudentProfile::create([
            'user_id' => $user->id,
            'parent_name' => $request->parent_name,
        ]);

        Auth::login($user);

        return redirect()->route('student.dashboard')->with('success', 'Registration successful!');
    }

    // Show tutor registration form
    public function showTutorRegistrationForm()
    {
        return view('auth.register-tutor');
    }

    // Handle tutor registration
    public function registerTutor(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'qualification' => 'required|string|max:255',
            'experience_years' => 'required|integer|min:0',
        ]);

        $tutorRole = Role::where('name', 'tutor')->first();
        if (!$tutorRole) {
            return back()->withErrors(['role' => 'Tutor role not found.']);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $tutorRole->id,
            'is_verified' => false, // Requires admin verification
        ]);

        TutorProfile::create([
            'user_id' => $user->id,
            'qualification' => $request->qualification,
            'experience_years' => $request->experience_years,
        ]);

        return redirect()->route('login')->with('success', 'Tutor application submitted! Your account is pending verification by an admin.');
    }

    // Show login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            $user = Auth::user();

            if ($user->role->name === 'admin') {
                return redirect()->intended(route('admin.dashboard'));
            } elseif ($user->role->name === 'tutor') {
                // Check if tutor is verified before redirecting to dashboard
                if ($user->is_verified) {
                    return redirect()->intended(route('tutor.dashboard'));
                } else {
                    Auth::logout();
                    return back()->withErrors(['email' => 'Your account is pending verification. Please wait for an admin to approve your profile.']);
                }
            } elseif ($user->role->name === 'student') {
                return redirect()->intended(route('student.dashboard'));
            }
        }

        return back()->withErrors(['email' => 'The provided credentials do not match our records.']);
    }

    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}