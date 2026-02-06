<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use App\Models\User;

use App\Models\MasterProvinsi;

use App\Models\UMapelMst;

use App\Models\UPaketSoalKecermatanMst;

use App\Models\Transaksi;

use App\Models\UEventSyarat;

use Yajra\DataTables\Facades\DataTables;

use Carbon\Carbon;

use File;

use Auth;

use DB;

use Illuminate\Support\Facades\Crypt;
use App\Models\Role;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UserExport;




class UserListController extends Controller

{

    private $menubar;



    public function __construct()

    {

        $this->middleware('auth');

    }



    public function index(Request $request)

    {

        $caridata=$request->caridata;

        if($caridata){

            $data = User::where('user_level','<>',1)->where(function ($query) use ($caridata) {

                $query->where('username','LIKE','%'.$caridata.'%')

                      ->orWhere('name','LIKE','%'.$caridata.'%');

            })
            ->orWhere('role_id', '!=', null)
            ->where(function ($query) use ($caridata) {

                $query->where('username','LIKE','%'.$caridata.'%')

                      ->orWhere('name','LIKE','%'.$caridata.'%');

            })
            ->orderBy('user_level','asc')->paginate(20);

        }else{

            $data = User::where('user_level','<>',1)->orWhere('role_id', '!=', null)->orderBy('user_level','asc')->paginate(20);

        }

        $menu = "user";

        $submenu="user";

        $judul = "User";

        $provinsi = MasterProvinsi::all();
        $role = Role::all();
        // if($userlevel==1){

        // }else{

        //     $data = User::where('user_level','=',4)->where('fk_affiliate',$userid)->orderBy('created_at','desc')->get();

        // }

        $data_param = [

            'submenu','menu','data','provinsi','judul', 'role'

        ];



        return view('master/userlist')->with(compact($data_param));



    }



    public function indexjson()

    {

        // $menu = "user";

        // $submenu="user";

        // $judul = "User";

        // $provinsi = MasterProvinsi::all();

        // $userlevel = auth()->user()->user_level;

        // $userid = auth()->user()->id;

        $data = User::where('user_level','<>',1)->orderBy('user_level','asc')->limit(1)->get();

        return Datatables::of($data)

        ->addIndexColumn()

        ->addColumn('action', function($data){

            $id=$data->id;

            $data_param = [

                'id'

            ];

            $btn =  view('include/useraction')->with(compact($data_param))->render();

            return $btn;

        })

        ->rawColumns(['action'])

        ->make(true);

        // return DataTables::of(User::query())->toJson();

        // if($userlevel==1){

        // }else{

        //     $data = User::where('user_level','=',4)->where('fk_affiliate',$userid)->orderBy('created_at','desc')->get();

        // }

        // $data_param = [

        //     'submenu','menu','data','provinsi','judul'

        // ];



        // return view('master/userlist')->with(compact($data_param));



    }



    public function affiliate()

    {

        $menu = "affiliate";

        $submenu="affiliate";

        $judul = "User Affiliate";

        $provinsi = MasterProvinsi::all();

        $userlevel = auth()->user()->user_level;

        $userid = auth()->user()->id;

        if($userlevel==1){

            $data = User::where('user_level','=',3)->orderBy('user_level','asc')->orderBy('created_at','desc')->get();

        }else{

            $data = User::where('user_level','=',4)->where('fk_affiliate',$userid)->orderBy('created_at','desc')->get();

        }

        $data_param = [

            'submenu','menu','data','provinsi','judul'

        ];



        return view('master/userlist')->with(compact($data_param));



    }



    public function affiliatedtl($id)

    {

        $userid = Crypt::decrypt($id);

        $adminaffiliate = User::find($userid);

        $menu = "affiliate";

        $submenu="affiliatedtl";

        $judul = "Affiliate ".$adminaffiliate->name;

        $provinsi = MasterProvinsi::all();

        $data = User::where('user_level','=',4)->where('fk_affiliate',$userid)->orderBy('created_at','desc')->get();

        $data_param = [

            'submenu','menu','data','provinsi','judul'

        ];



        return view('master/userlist')->with(compact($data_param));



    }



    public function store(Request $request)

    {

        $cekemail = User::where('username',$request->email_add)->get();

        if (count($cekemail)>0) {

            return response()->json([

                'status' => false,

                'message' => 'Email sudah digunakan'

            ]);

            dd('Error');

        }

        $userlevel = auth()->user()->user_level;



        if($userlevel==1){

            if ($request->role_id) {
                $data['user_level'] = 1;
            }else{
                $data['user_level'] = $request->user_level_add;
            }

            $data['fk_affiliate'] = 0;

        }else{

            $data['user_level'] = 4;

            $data['fk_affiliate'] = Auth::id();

        }

        $data['username'] = $request->email_add;

        $data['name'] = $request->name_add;

        $data['email'] = $request->email_add;

        $data['no_wa'] = $request->no_wa_add;

        $data['jenis_kelamin'] = $request->jenis_kelamin_add;

        // $data['asal'] = $request->asal_add;

        // $data['jenjang'] = $request->jenjang_add;

        $data['alamat'] = $request->alamat_add;

        $data['provinsi'] = $request->provinsi_add;

        $data['kabupaten'] = $request->kabupaten_add;

        $data['kecamatan'] = $request->kecamatan_add;
        $data['role_id'] = $request->role_id;

        if ($files = $request->file("scan_add")) {

            $destinationPath = 'upload/user/scan/';

            $file = 'Scan_'.Carbon::now()->timestamp. "." .$files->getClientOriginalExtension();

            $files->move($destinationPath, $file);

            $namafile = $destinationPath.$file;

            $data['scan'] = $destinationPath.$file;

        }

        $data['password'] = bcrypt($request->email_add); 

        $data['is_active'] = 1;

        $data['created_at'] = Carbon::now()->toDateTimeString();

        $data['updated_at'] = Carbon::now()->toDateTimeString();

        $createdata = User::create($data);

        if($createdata){

            return response()->json([

                'status' => true,

                'message' => 'Berhasil tambah user'

            ]);

        }else{

            return response()->json([

                'status' => false,

                'message' => 'Gagal. Mohon coba kembali!'

            ]);

        }

    }



    public function update(Request $request, $id)

    {

        $data['name'] = $request->name[0];

        $data['no_wa'] = $request->no_wa[0];

        $data['jenis_kelamin'] = $request->jenis_kelamin[0];

        // $data['asal'] = $request->asal[0];

        // $data['jenjang'] = $request->jenjang[0];

        $data['alamat'] = $request->alamat[0];

        $data['provinsi'] = $request->provinsi[0];

        $data['kabupaten'] = $request->kabupaten[0];

        $data['kecamatan'] = $request->kecamatan[0];
           $data['role_id'] = $request->role_id;

        // $data['is_active'] = $request->is_active[0];

        if($request->file("scan")){

            if ($files = $request->file("scan")[0]) {

                $destinationPath = 'upload/user/scan/';

                $file = 'scan_'.Carbon::now()->timestamp. "." .$files->getClientOriginalExtension();

                $files->move($destinationPath, $file);

                $namafile = $destinationPath.$file;

                $data['scan'] = $destinationPath.$file;

            }

        }



        $data['updated_by'] = Auth::id();

        $data['updated_at'] = Carbon::now()->toDateTimeString();



        User::find($id)->update($data);



        return response()->json([

            'status' => true,

            'message' => 'Data berhasil diubah'

        ]);

    }



    public function destroy($id)

    {

        // $data['deleted_by'] = Auth::id();

        // $data['deleted_at'] = Carbon::now()->toDateTimeString();

        $updateData = User::find($id)->forceDelete();

        return response()->json([

            'status' => true,

            'message' => 'Data berhasil dihapus'

        ]);

    }



    public function reset(Request $request)

    {

        $user = User::find($request->iduser);

        $dataUpdate['password'] = bcrypt($user->username); 

        $updatePwdUser = User::find($request->iduser)->update($dataUpdate);

        if($updatePwdUser){

            return response()->json([

                'status' => true,

                'message' => 'Password '.$user->username.' berhasil direset'

            ]);

        }else{

            return response()->json([

                'status' => false,

                'message' => 'Password gagal direset, silahkan coba lagi!'

            ]);

        }



    }

    public function lihathasilujian($id)

    {

        $id = Crypt::decrypt($id);

        $menu = "user";

        $submenu="";

        $user = User::find($id);

        $data = UMapelMst::where('fk_user_id',$id)->where('is_mengerjakan',0)->orderBy('created_at','desc')->get();

        $datakecermatan = UPaketSoalKecermatanMst::where('fk_user_id',$id)->where('is_mengerjakan',2)->orderBy('created_at','desc')->get();

        $data_param = [

            'submenu','menu','data','user','datakecermatan'

        ];



        return view('master/lihathasilujian')->with(compact($data_param));

    }



    // public function lihatdetailhasil($id)

    // {

    //     $id = Crypt::decrypt($id);

    //     $menu = "user";

    //     $submenu="";

    //     $UMapelMst = UMapelMst::find($id);

    //     $user = User::find($UMapelMst->fk_user_id);

    //     $data_param = [

    //         'submenu','menu','UMapelMst','user'

    //     ];

    //     return view('master/detailhasil')->with(compact($data_param)); 

    // }



    // public function lihatdetailhasilkecermatan($id)

    // {

    //     $id = Crypt::decrypt($id);

    //     $menu = "hasilujian";

    //     $submenu="";

    //     $UMapelMst = UPaketSoalKecermatanMst::find($id);

    //     $soalmst = UPaketSoalKecermatanSoalMst::where('fk_u_paket_soal_kecermatan_mst',$id)->get();

        

    //     $cekbenar = UPaketSoalKecermatanSoalDtl::where('fk_u_paket_soal_kecermatan_mst',$UMapelMst->id)->where('benar_salah',1)->get();

    //     $ceksalah = UPaketSoalKecermatanSoalDtl::where('fk_u_paket_soal_kecermatan_mst',$UMapelMst->id)->where('benar_salah',0)->get();

    //     $hitungsoaldtl = UPaketSoalKecermatanSoalDtl::where('fk_u_paket_soal_kecermatan_mst',$UMapelMst->id)->get();



    //     $data_param = [

    //         'submenu','menu','UMapelMst','soalmst','cekbenar','ceksalah','hitungsoaldtl'

    //     ];

    //     return view('master/detailhasilkecermatan')->with(compact($data_param)); 

        

    // }



    public function lihattransaksi($id)

    {
        
        $id = Crypt::decrypt($id);

        $menu = "user";

        $submenu="";

        $user=User::find($id);

        $data = Transaksi::where('fk_user_id',$id)->orderBy('expired','desc')->get();

      

        $data_param = [

            'submenu','menu','data','user'

        ];

        return view('master/lihattransaksi')->with(compact($data_param)); 

    }



    public function listtransaksi(Request $request, $jenis)

    {
    
        $menu = "transaksi";

        $submenu=$jenis;

        if($jenis=="paket"){

            $caridata=$request->caridata;

            if($caridata){
    
                $data = Transaksi::whereHas('user_r', function ($query) use ($caridata) {
                    return $query->where('name', 'LIKE', "%{$caridata}%")
                        ->orWhere('email', 'LIKE', "%{$caridata}%");
                })->orWhere('merchant_order_id','LIKE','%'.$caridata.'%')->orderBy('created_at','desc')->paginate(20);
                
    
            }else{
    
                $data = Transaksi::orderBy('created_at','desc')->paginate(20);
    
            }

        

            $datahadiah = "";

        }else{

            $data="";

            $datahadiah = "";

        }

        $data_param = [

            'submenu','menu','data','datahadiah','jenis'

        ];

        return view('master/listtransaksi')->with(compact($data_param)); 

    }



    public function hapustransaksi($id)

    {

        $data['deleted_by'] = Auth::id();

        $data['deleted_at'] = Carbon::now()->toDateTimeString();

        $updateData = Transaksi::find($id)->update($data);

        return response()->json([

            'status' => true,

            'message' => 'Transaksi berhasil dihapus'

        ]);

    }



    public function lihatsyarat($userid,$id)

    {

        $userid = Crypt::decrypt($userid);

        $id = Crypt::decrypt($id);

        $transaksi = Transaksi::find($id);

        $user=User::find($userid);

        $data = UEventSyarat::where('fk_event_mst',$transaksi->fk_event_mst_id)->where('fk_users',$userid)->get();

        $menu = "user";

        $submenu="";

        $data_param = [

            'submenu','menu','data','user'

        ];

        return view('master/lihatsyarat')->with(compact($data_param)); 

    }



    public function updatestatuspembayaran(Request $request, $id)

    {

        $data['status'] = $request->status[0];

        $data['updated_by'] = Auth::id();

        $data['updated_at'] = Carbon::now()->toDateTimeString();



        Transaksi::find($id)->update($data);



        return response()->json([

            'status' => true,

            'message' => 'Status berhasil diperbarui'

        ]);

    }



    // public function updatestatushadiah(Request $request, $id)

    // {

    //     $data['no_resi'] = $request->no_resi[0];

    //     $data['status_kirim'] = $request->status_kirim[0];

    //     $data['status'] = $request->status[0];

    //     $data['updated_by'] = Auth::id();

    //     $data['updated_at'] = Carbon::now()->toDateTimeString();



    //     TransaksiHadiah::find($id)->update($data);



    //     return response()->json([

    //         'status' => true,

    //         'message' => 'Status berhasil diperbarui'

    //     ]);

    // }



    // public function rankingpaket($id){

    //     $id = Crypt::decrypt($id);

    //     $menu = "kerjakansoal";

    //     $submenu="";

    //     $datapaket = PaketSoalMst::find($id);



    //     $extend = "layouts.SkydashAdmin";



    //     $udatapaket =UMapelMst::select('*', DB::raw('AVG(nilai) as totalnilai'))->where('fk_paket_soal_mst',$id)->where('is_mengerjakan',0)->groupBy('fk_user_id')->orderBy('totalnilai','desc')->get();

                 

    //     $data_param = [

    //         'submenu','menu','datapaket','udatapaket','extend'

    //     ];

    //     return view('user/rankingpaket')->with(compact($data_param)); 

    // }

    // public function rankingpaketkec($id){

    //     $id = Crypt::decrypt($id);

    //     $menu = "kerjakansoal";

    //     $submenu="";

    //     $datapaket = PaketSoalKecermatanMst::find($id);

    //     $extend = "layouts.SkydashAdmin";



    //     $udatapaket =UPaketSoalKecermatanMst::select('*', DB::raw('AVG(nilai) as totalnilai'))->where('fk_paket_soal_kecermatan_mst',$id)->where('is_mengerjakan',2)->groupBy('fk_user_id')->orderBy('totalnilai','desc')->get();

                 

    //     $data_param = [

    //         'submenu','menu','datapaket','udatapaket','extend'

    //     ];

    //     return view('user/rankingpaketkec')->with(compact($data_param)); 

    // }

    public function export()
    {
        $users      = User::where('user_level', '!=', 1)->get();

        return Excel::download(new UserExport($users), 'users.xlsx');
    }
}

