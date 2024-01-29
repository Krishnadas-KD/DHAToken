<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $user = Auth::user();
        if ($user) {
            switch ($user->type) {
                case 'Admin':
                    return redirect('/home');
                    break;
                case 'Counter':
                    return redirect('/counter-home');
                    break;
                case 'Token':
                    return redirect('/token-home');
                    break;
                default:
                    return redirect('/logout');
                    break;
            }
        }
        return $next($request);
    }
}
