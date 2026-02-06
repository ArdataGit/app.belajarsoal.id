<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use App\Models\MasterProvinsi;

use App\Models\MasterKabupaten;

use App\Models\MasterKecamatan;

use App\Models\User;

use Laravel\Socialite\Facades\Socialite;

use App\Models\Template;

use Carbon\Carbon;

use Illuminate\Support\Facades\Redirect;

use Auth;

use DB;

use Illuminate\Support\Facades\Cookie;


class GoogleController extends Controller

{

    public function index()

    { 

        return Socialite::driver('google')->redirect();

        

    }



    public function callback()

    { 

        try{

            $user = Socialite::driver('google')->user();

            $cekuser = User::where('username',$user->getEmail())->first();

 

            

            if($cekuser){
                $cekuser->update([
                    'session_google_id' => session()->getId(),
                    'is_login_google'   => true
                ]);

                Cookie::queue(Cookie::forever('stored_session', session()->getId()));

                Auth::login($cekuser);

                return Redirect::to(url('home')); 

            }else{

                

                $data['username'] = $user->getEmail();

                $data['name'] = $user->getName();

                $data['email'] = $user->getEmail();

                $data['photo'] = $user->getAvatar();

                // $data['jenis_kelamin'] = $request->jenis_kelamin;

                // $data['alamat'] = $request->alamat;

                // $data['provinsi'] = $request->provinsi;

                // $data['kabupaten'] = $request->kabupaten;

                // $data['kecamatan'] = $request->kecamatan;

                // $data['referrer'] = $request->referrer;

                // $data['jenjang'] = $request->jenjang;

                $data['user_level'] = 2;

                $data['is_active'] = 1;

                

                // if ($files = $request->file("photo")) {

                //     $destinationPath = 'upload/user/scan/';

                //     $file = 'Scan_'.Carbon::now()->timestamp. "." .$files->getClientOriginalExtension();

                //     $files->move($destinationPath, $file);

                //     $namafile = $destinationPath.$file;

                //     $data['scan'] = $destinationPath.$file;

                // }

                // $data['password'] = bcrypt($request->password);

                $data['created_at'] = Carbon::now()->toDateTimeString();

                $data['updated_at'] = Carbon::now()->toDateTimeString();

                $createdata = User::create($data);

                if($createdata){

                    Auth::login($createdata);

                    return Redirect::to(url('home')); 

                }else{

                    return Redirect::to(url('login'))->withErrors(['msg' => 'Gagal, harap coba lagi']);

                }

            }

        } catch (\Throwable $th){

            return Redirect::to(url('login'))->withErrors(['msg' => 'Error, harap coba lagi']);

        }

    }

  

    

}

