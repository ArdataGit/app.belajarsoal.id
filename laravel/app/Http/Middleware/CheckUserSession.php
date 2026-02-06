<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        $session = $request->session()->getId();
        

        if ($user->is_login_google) {
            $storedSession = $request->cookie('stored_session');
            // dd($user, $storedSession);
            if ($user->session_google_id !== $storedSession) {
                Auth::logout();
    
    
                return redirect()->route('login')->with('error', 'Your session has expired. Please log in again.');
            }
        }else if ($user->session_id !== $session) {
            Auth::logout();

            return redirect()->route('login')->with('error', 'Your session has expired. Please log in again.');
        }
       

        return $next($request);
    }
}
