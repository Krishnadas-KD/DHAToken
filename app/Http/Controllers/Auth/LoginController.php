<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\Counter;
use App\Models\UserCounter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected function authenticated(Request $request, $user)
    {
        if ($user->type==='Admin') {
            // Authentication passed for admin user
            return redirect('/home');
        }
        if ($user->type==='Report') {
            // Authentication passed for admin user
            return redirect('/report-home');
        }
        if ($user->type==='Counter') {
            // Authentication passed for counter user
            return redirect('/counter-home');
        }

        if ($user->type==='Token') {
            // Authentication passed for token user
            return redirect('/token-home');
        }
        
        
       
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            if($user->type==='Counter')
            {
                DB::table('user_counters')
                    ->where('user_id', $user->id)
                    ->update(['counter_id' => null]);
            }
        }
        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/');
    }

    public function __construct()
    {
      //  $this->middleware('guest')->except('logout');
    }
}
