<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use App\Models\RoleMenu;
use Illuminate\Support\Str;

class IsAdminOrAff
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
        if(Auth::check() && (auth()->user()->user_level == 1 || auth()->user()->user_level == 3) ){
            $url = $request->url();
            $role_menu = RoleMenu::where('role_id', auth()->user()->role_id)->get();
            $is_allow = false;

            foreach ($role_menu as $key => $value) {
                if (Str::contains($url, 'user') && $value->menu == 'User') {
                    $is_allow = true;
                }
            }
            
            if ($is_allow) {
                return $next($request);
            }else{
                if (!Str::contains($url, 'user')){
                    return $next($request);
                }else{
                    if (auth()->user()->role_id !== null) {
                        return redirect('home');
                    }else{
                        return $next($request);
                    }
                };
              
            }
        }else{
            return redirect('home');
        }
    }
}
