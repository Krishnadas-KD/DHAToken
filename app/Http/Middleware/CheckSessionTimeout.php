<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckSessionTimeout
{
    public function handle($request, Closure $next)
    {
        // Check if user is authenticated and if session has expired
        if (Auth::check() && $this->sessionHasExpired()) {
            // Perform actions like logout or session cleanup
            Auth::logout();
            // Redirect or perform any other action you wish
            return redirect()->route('login')->with('message', 'Session expired. Please log in again.');
        }

        return $next($request);
    }

    protected function sessionHasExpired()
    {
        $lastActivity = session('last_activity_time');

        if ($lastActivity && (time() - $lastActivity) > (config('session.lifetime') * 60)) {
            // If the time difference exceeds the session lifetime, it's expired
            return true;
        }

        session(['last_activity_time' => time()]); // Update last activity time
        return false;
    }
}
