<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TutorProfile;
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
}