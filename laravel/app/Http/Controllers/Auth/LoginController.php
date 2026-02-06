<?php



namespace App\Http\Controllers\Auth;



use App\Http\Controllers\Controller;

use App\Providers\RouteServiceProvider;

use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;

use App\Models\User;

use Auth;

use Illuminate\Support\Facades\Crypt;





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

    $user->session_id = session()->getId();

    $user->save();

}



    public function __construct()

    {

        $this->middleware('guest')->except('logout');

    }



    public function login(Request $request){



        $input = $request->all();

 

        $cekusername = User::where('username',$input['username'])->first();

        if ($cekusername) {

            if($cekusername->is_active!=1){

                return response()->json([

                    'status' => false,

                    'message' => 'Akun belum aktif, harap cek inbox/spam email untuk aktivasi akun!'

                ]);

                dd('Error');

            }

            if(auth()->attempt(array('username'=>$input['username'],'password'=>$input['password']))){
                $cekusername->update([
                    'session_id'        => session()->getId(),
                    'is_login_google'   => false
                ]);
        

                return response()->json([

                    'status' => true,

                    'message' => 'Login berhasil!'

                ]);

            }else{

                return response()->json([

                    'status' => false,

                    'message' => 'Password salah!'

                ]);

            }

        }else{

            return response()->json([

                'status' => false,

                'message' => 'User belum terdaftar!'

            ]);

        }



    }



    public function logout(Request $request) {
        $user = Auth::user();

        if ($user) {
            $user->update([
                'is_login_google'   => false
            ]);
        }

        Auth::logout();

        return redirect('https://belajarsoal.id/');

      }

}

