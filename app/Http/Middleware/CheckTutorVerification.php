<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckTutorVerification
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->is_verified) {
            return $next($request);
        }

        Auth::logout();
        return redirect()->route('login')->withErrors(['email' => 'Your account is pending verification. Please wait for an admin to approve your profile.']);
    }
}