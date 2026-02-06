<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use App\Models\User;

use App\Models\PaketUser;

use App\Models\PaketMst;

use App\Models\PaketDtl;

use App\Models\Transaksi;

use App\Models\PaketFitur;

use App\Models\PaketSoalMst;

use App\Models\PaketSubkategori;

use App\Models\PaketKategori;

use App\Models\PaketSoalKecermatanMst;

use App\Mail\IngatkanPeserta;

use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Crypt;

use Carbon\Carbon;

use Auth;



class PaketMstController extends Controller

{

    public function __construct()

    {

        $this->middleware('auth');

    }



    public function index()

    {

        $menu = 'master';

        $submenu='paketmst';

        $data = PaketMst::orderBy('created_at','desc')->get();

        $kategori = PaketKategori::all();

        $subkategori = PaketSubkategori::all();

        $data_param = [

            'menu','submenu','data','subkategori','kategori'

        ];



        return view('master/paketmst')->with(compact($data_param));

    }



    public function pesertaevent($idevent)

    {

        $menu = 'master';

        $submenu='paketmst';

        $data = Transaksi::where('fk_paket_mst_id',$idevent)->where('status',1)->get();

       

        $data_param = [

            'menu','submenu','data','idevent'

        ];



        return view('master/pesertaevent')->with(compact($data_param));

    }



    public function ingatkanpeserta(Request $request)

    {

        $transaksi =  Transaksi::where('fk_paket_mst_id',$request->id_event)->where('status',1)->pluck('fk_user_id')->all();

        foreach($transaksi as $data){

            $peserta = User::find($data);

            $dataemailawal = [

                'idpeserta' => $data,

                'idevent' => $request->id_event

            ];

            $mail = new IngatkanPeserta($dataemailawal);

            Mail::to($peserta->email)->send($mail);

        }

        return response()->json([

            'status' => true,

            'message' => 'Berhasil kirim pengingat'

            // 'message' => 'Berhasil daftar. Silahkan cek email inbox/spam untuk aktivasi akun'

        ]);

    }



    public function store(Request $request)

    {

        $data['judul'] = $request->judul_add;

        // if($request->syarat_add){

        //     $data['syarat'] = 1;

        // }else{

        //     $data['syarat'] = 0;

        // }

        $data['is_gratis'] = $request->is_gratis_add;
        
        if($request->is_gratis_add==1){
            $data['harga'] = 20000;
        }else{
            $data['harga'] = $request->harga_add;
        }

        $paketsubkategori = PaketSubkategori::find($request->fk_paket_subkategori_add);

        $data['fk_paket_kategori'] = $paketsubkategori->fk_paket_kategori;

        $data['fk_paket_subkategori'] = $request->fk_paket_subkategori_add;

        // $data['mulai'] = datestore($request->mulai_add);

        // $data['selesai'] = datestore($request->selesai_add);

        // $data['mulai_daftar'] = datetimestore($request->mulai_daftar_add);

        // $data['selesai_daftar'] = datetimestore($request->selesai_daftar_add);



        // if($data['mulai']>$data['selesai']){

        //     return response()->json([

        //         'status' => false,

        //         'message' => 'Tanggal paket salah, harap dicek kembali!'

        //     ]);

        //     dd('Error');

        // }



        // if($data['mulai_daftar']>=$data['selesai_daftar']){

        //     return response()->json([

        //         'status' => false,

        //         'message' => 'Tanggal pendaftaran salah, harap dicek kembali!'

        //     ]);

        //     dd('Error');

        // }





        if ($files = $request->file("banner_add")) {

            $destinationPath = 'upload/paket/banner/';

            $file = 'Banner_'.Carbon::now()->timestamp. "." .$files->getClientOriginalExtension();

            $files->move($destinationPath, $file);

            $namafile = $destinationPath.$file;

            $data['banner'] = $destinationPath.$file;

        }



        if ($files = $request->file("juknis_add")) {

            $destinationPath = 'upload/paket/juknis/';

            $file = 'Juknis_'.Carbon::now()->timestamp. "." .$files->getClientOriginalExtension();

            $files->move($destinationPath, $file);

            $namafile = $destinationPath.$file;

            $data['juknis'] = $destinationPath.$file;

        }



        $data['ket'] = $request->ket_add;

        $data['status'] = 1;

        $data['created_by'] = Auth::id();

        $data['created_at'] = Carbon::now()->toDateTimeString();

        $data['updated_by'] = Auth::id();

        $data['updated_at'] = Carbon::now()->toDateTimeString();

        $createdata = PaketMst::create($data);

        if($createdata){

            return response()->json([

                'status' => true,

                'message' => 'Berhasil menambahkan data'

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

        $data['judul'] = $request->judul[0];

        $data['is_gratis'] = $request->is_gratis[0];

        if($request->is_gratis[0]==1){
            $data['harga'] = 20000;
        }else{
            $data['harga'] = $request->harga[0];
        }

        $paketsubkategori = PaketSubkategori::find($request->fk_paket_subkategori[0]);

        $data['fk_paket_kategori'] = $paketsubkategori->fk_paket_kategori;

        $data['fk_paket_subkategori'] = $request->fk_paket_subkategori[0];

        $data['status'] = $request->status[0];

        // $data['mulai_daftar'] = datetimestore($request->mulai_daftar[0]);

        // $data['selesai_daftar'] = datetimestore($request->selesai_daftar[0]);

        // $data['mulai'] = datestore($request->mulai[0]);

        // $data['selesai'] = datestore($request->selesai[0]);

        // if($data['mulai']>$data['selesai']){

        //     return response()->json([

        //         'status' => false,

        //         'message' => 'Tanggal paket salah, harap dicek kembali!'

        //     ]);

        //     dd('Error');

        // }



        // if($data['mulai_daftar']>=$data['selesai_daftar']){

        //     return response()->json([

        //         'status' => false,

        //         'message' => 'Tanggal pendaftaran salah, harap dicek kembali!'

        //     ]);

        //     dd('Error');

        // }



        if($request->file("banner")){

            if ($files = $request->file("banner")[0]) {

                $destinationPath = 'upload/paket/banner/';

                $file = 'Banner_'.Carbon::now()->timestamp. "." .$files->getClientOriginalExtension();

                $files->move($destinationPath, $file);

                $namafile = $destinationPath.$file;

                $data['banner'] = $destinationPath.$file;

            }

        }



        if($request->file("juknis")){

            if ($files = $request->file("juknis")[0]) {

                $destinationPath = 'upload/paket/juknis/';

                $file = 'Juknis_'.Carbon::now()->timestamp. "." .$files->getClientOriginalExtension();

                $files->move($destinationPath, $file);

                $namafile = $destinationPath.$file;

                $data['juknis'] = $destinationPath.$file;

            }

        }

        // if($request->syarat){

        //     $data['syarat'] = 1;

        // }else{

        //     $data['syarat'] = 0;

        // }

       

        $data['ket'] = $request->ket[0];

        $data['updated_by'] = Auth::id();

        $data['updated_at'] = Carbon::now()->toDateTimeString();



        $updatedata = PaketMst::find($id)->update($data);



        if($updatedata){

            return response()->json([

                'status' => true,

                'message' => 'Data berhasil diubah'

            ]);

        }else{

            return response()->json([

                'status' => false,

                'message' => 'Gagal. Mohon coba kembali!'

            ]);

        }

    }



    public function destroy($id)

    {

        $data['deleted_by'] = Auth::id();

        $data['deleted_at'] = Carbon::now()->toDateTimeString();

        $updateData = PaketMst::find($id)->update($data);

        return response()->json([

            'status' => true,

            'message' => 'Data berhasil dihapus'

        ]);

    }



    public function indexdtl($idmst)

    {

        $menu = 'master';

        $submenu='paketmst';

        $datamst = PaketMst::find($idmst);

        $arr = PaketDtl::where('fk_paket_mst',$idmst)->pluck('fk_mapel_mst')->all(); 

        $datamapel = PaketSoalMst::whereNotIn('id',$arr)->where('tryout',0)->get();

        $data = PaketDtl::where('fk_paket_mst',$idmst)->orderBy('jenis','asc')->get();

        $data_param = [

            'menu','submenu','data','idmst','datamst','datamapel'

        ];

        return view('master/paketdtl')->with(compact($data_param));

    }



    public function storedtl(Request $request)

    {

        $cekdata = PaketDtl::where('fk_paket_mst',$request->fk_paket_mst)->where('fk_mapel_mst',$request->fk_mapel_mst_add)->first(); // Bisa double mapel pada event

        // $cekdata = PaketDtl::where('fk_mapel_mst',$request->fk_mapel_mst_add)->first(); // 1 Event 1 Mapel

        if($cekdata){

            return response()->json([

                'status' => false,

                'message' => 'Soal sudah digunakan pada paket lain, silahkan tambah soal baru!'

            ]);

            dd('Error');

        }

        $data['fk_mapel_mst'] = $request->fk_mapel_mst_add;

        $data['fk_paket_mst'] = $request->fk_paket_mst;

        $data['jenis'] = 1;

        $data['created_by'] = Auth::id();

        $data['created_at'] = Carbon::now()->toDateTimeString();

        $data['updated_by'] = Auth::id();

        $data['updated_at'] = Carbon::now()->toDateTimeString();

        $createdata = PaketDtl::create($data);

        if($createdata){

            return response()->json([

                'status' => true,

                'message' => 'Berhasil menambahkan data'

            ]);

        }else{

            return response()->json([

                'status' => false,

                'message' => 'Gagal. Mohon coba kembali!'

            ]);

        }

    }

    // public function updatemapel(Request $request, $id)

    // {

 

    //     $data['updated_by'] = Auth::id();

    //     $data['updated_at'] = Carbon::now()->toDateTimeString();



    //     $updatedata = MemberDtl::find($id)->update($data);



    //     if($updatedata){

    //         return response()->json([

    //             'status' => true,

    //             'message' => 'Data berhasil diubah'

    //         ]);

    //     }else{

    //         return response()->json([

    //             'status' => false,

    //             'message' => 'Gagal. Mohon coba kembali!'

    //         ]);

    //     }

    // }

    public function destroydtl($id)

    {

        $data['deleted_by'] = Auth::id();

        $data['deleted_at'] = Carbon::now()->toDateTimeString();

        $updateData = PaketDtl::find($id)->update($data);

        return response()->json([

            'status' => true,

            'message' => 'Data berhasil dihapus'

        ]);

    }



    // public function getPaketSoal(Request $request , $idmst)

    // {

    //     $datamst = PaketMst::find($idmst);

    //     $arr = MemberDtl::where('fk_master_member',$idmst)->where('jenis',$request->val)->pluck('fk_paket_soal_mst')->all(); 

    //     if($request->val==1){

    //         $datapaket = PaketSoalMst::whereNotIn('id',$arr)->get(['id AS id', 'judul as text'])->toArray();

    //     }elseif($request->val==2){

    //         $datapaket = PaketSoalKecermatanMst::whereNotIn('id',$arr)->get(['id AS id', 'judul as text'])->toArray();

    //     }



    //     return response()->json([

    //         'status' => true,

    //         'datapaket' => $datapaket

    //     ]);

    // }



    public function indexfitur($idmst)

    {

        $menu = 'master';

        $submenu='paketmst';

        $datamst = PaketMst::find($idmst);

        $data = PaketFitur::where('fk_paket_mst',$idmst)->orderBy('created_at','desc')->get();

        $data_param = [

            'menu','submenu','data','idmst','datamst'

        ];

        return view('master/paketfitur')->with(compact($data_param));

    }



    public function storefitur(Request $request)

    {

        $data['fk_paket_mst'] = $request->fk_paket_mst;

        $data['judul'] = $request->judul_add;

        $data['ket'] = $request->ket_add;

        $data['created_by'] = Auth::id();

        $data['created_at'] = Carbon::now()->toDateTimeString();

        $data['updated_by'] = Auth::id();

        $data['updated_at'] = Carbon::now()->toDateTimeString();

        $createdata = PaketFitur::create($data);

        if($createdata){

            return response()->json([

                'status' => true,

                'message' => 'Berhasil menambahkan data'

            ]);

        }else{

            return response()->json([

                'status' => false,

                'message' => 'Gagal. Mohon coba kembali!'

            ]);

        }

    }

    public function updatefitur(Request $request, $id)

    {

        $data['judul'] = $request->judul[0];

        $data['ket'] = $request->ket[0];

        $data['updated_by'] = Auth::id();

        $data['updated_at'] = Carbon::now()->toDateTimeString();



        $updatedata = PaketFitur::find($id)->update($data);



        if($updatedata){

            return response()->json([

                'status' => true,

                'message' => 'Data berhasil diubah'

            ]);

        }else{

            return response()->json([

                'status' => false,

                'message' => 'Gagal. Mohon coba kembali!'

            ]);

        }

    }

    public function destroyfitur($id)

    {

        $data['deleted_by'] = Auth::id();

        $data['deleted_at'] = Carbon::now()->toDateTimeString();

        $updateData = PaketFitur::find($id)->update($data);

        return response()->json([

            'status' => true,

            'message' => 'Data berhasil dihapus'

        ]);

    }

}

