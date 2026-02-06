<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use App\Models\RoleMenu;
use Illuminate\Support\Str;

class IsAdmin
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
        // dd('yes');
        if(Auth::check() && auth()->user()->user_level == 1){
            $url = $request->url();
            $role_menu = RoleMenu::where('role_id', auth()->user()->role_id)->get();
            
            if (count($role_menu) > 0) {
                foreach ($role_menu as $key => $value) {
                    if (Str::contains($url, 'user') && $value->menu == 'User') {
                        return $next($request);
                    }else if(Str::contains($url, 'template') && $value->menu == 'Website Setting'){
                        return $next($request);
                    }else if(Str::contains($url, 'informasi') && $value->menu == 'Informasi'){
                        return $next($request);
                    }else if(Str::contains($url, 'kategorisoal') && $value->menu == 'Bank Soal'){
                        return $next($request);
                    }else if(Str::contains($url, 'paketkategori') && $value->menu == 'Kategori Paket'){
                        return $next($request);
                    }else if(Str::contains($url, 'paketsoalmst') && $value->menu == 'Paket Latihan'){
                        return $next($request);
                    }else if(Str::contains($url, 'kecermatan') && $value->menu == 'Kecermatan'){
                        return $next($request);
                    }else if(Str::contains($url, 'paketmst') && $value->menu == 'Paket Pembelian'){
                        return $next($request);
                    }else if(Str::contains($url, 'kodepotongan') && $value->menu == 'Voucher'){
                        return $next($request);
                    }else if(Str::contains($url, 'role') && $value->menu == 'Role'){
                        return $next($request);
                    }else if(Str::contains($url, 'role-menu') && $value->menu == 'Role Menu'){
                        return $next($request);
                    }else if(Str::contains($url, 'listtransaksi/paket') && $value->menu == 'Paket'){
                        return $next($request);
                    }
                }
                
                $array = [
                    'template', 'informasi', 'kategorisoal', 'paketkategori', 'paketsoalmst', 
                    'paketmst', 'kodepotongan', 'role', 'role-menu', 'listtransaksi/paket'
                ];
                
                $found = false;
    
                foreach ($array as $word) {
                    // Check if the word exists in the URL
                    if (strpos($url, $word) !== false) {
                        // If found, set $found to true and break out of the loop
                        $found = true;
                        break;
                    }
                }
    
                // Check if any word was found in the URL
                if ($found) {
                    return redirect('home');
                } else {
                    return $next($request);
                }
            }
          
            return $next($request);
            // return redirect('home');
            // if (auth()->user()->role_id !== null) {
            //     return redirect('home');
            // }else{
            //     return $next($request);
            // }
          
        }else{
            return redirect('home');
        }
    }
}
