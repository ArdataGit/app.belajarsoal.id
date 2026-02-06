<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\KodePotongan;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use Auth;

class KodePotonganController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $menu = 'master';
        $submenu='kodepotongan';
        $datauser = User::where('user_level','=',2)->where('is_active',1)->orderBy('name','asc')->get();
        $data = KodePotongan::orderBy('status','desc')->orderBy('jenis','desc')->orderBy('created_at','desc')->get();
        $data_param = [
            'menu','submenu','data','datauser'
        ];
        return view('master/kodepotongan')->with(compact($data_param));
    }

    public function store(Request $request)
    {
        $cekkode = KodePotongan::where('kode',$request->kode_add)->first();
        if($cekkode){
            return response()->json([
                'status' => false,
                'message' => 'Kode sudah ada, silahkan gunakan kode lainnya!'
            ]);
            dd('Error');
        }
        if($request->jenis_add==1){
            $data['fk_user'] = null;
        }else{
            $cekuser = KodePotongan::where('fk_user',$request->fk_user_add)->first();
            if($cekuser){
                return response()->json([
                    'status' => false,
                    'message' => 'Kode potongan user sudah ada!'
                ]);
                dd('Error');
            }
            $data['fk_user'] = $request->fk_user_add;
        }
        if ($files = $request->file("gambar_add")) {
            $destinationPath = 'upload/voucher/';
            $file = 'Voucher_'.Carbon::now()->timestamp. "." .$files->getClientOriginalExtension();
            $files->move($destinationPath, $file);
            $namafile = $destinationPath.$file;
            $data['gambar'] = $destinationPath.$file;
        }
        $data['jenis'] = $request->jenis_add;
        $data['kode'] = $request->kode_add;
        $data['tipe'] = $request->tipe_add;
        if($request->tipe_add==1){
            $data['jumlah'] = $request->harga_add;
        }else{
            $data['jumlah'] = $request->persen_add;
        }
        $data['ket'] = $request->ket_add;
        $data['created_by'] = Auth::id();
        $data['created_at'] = Carbon::now()->toDateTimeString();
        $data['updated_by'] = Auth::id();
        $data['updated_at'] = Carbon::now()->toDateTimeString();
        $createdata = KodePotongan::create($data);
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
    public function update(Request $request)
    {
        $id = $request->iddata[0];

        $cekkode = KodePotongan::where('id','<>',$id)->where('kode',$request->kode[0])->first();
        if($cekkode){
            return response()->json([
                'status' => false,
                'message' => 'Kode sudah ada, silahkan gunakan kode lainnya!'
            ]);
            dd('Error');
        }
     
        // if($request->jenis[0]==1){
        //     $data['fk_user'] = null;
        // }else{
        //     $cekuser = KodePotongan::where('id','<>',$id)->where('fk_user',$request->fk_user[0])->first();
        //     if($cekuser){
        //         return response()->json([
        //             'status' => false,
        //             'message' => 'Kode potongan user sudah ada!'
        //         ]);
        //     }
        //     $data['fk_user'] = $request->fk_user[0];
        // }
        // $data['jenis'] = $request->jenis[0];
        if($request->file("gambar")){
            if ($files = $request->file("gambar")[0]) {
                $destinationPath = 'upload/voucher/';
                $file = 'Voucher_'.Carbon::now()->timestamp. "." .$files->getClientOriginalExtension();
                $files->move($destinationPath, $file);
                $namafile = $destinationPath.$file;
                $data['gambar'] = $destinationPath.$file;
            }
        }
        $data['kode'] = $request->kode[0];
        $data['tipe'] = $request->tipe[0];
        $data['status'] = $request->status[0];
        if($request->tipe[0]==1){
            $data['jumlah'] = $request->harga[0];
        }else{
            $data['jumlah'] = $request->persen[0];
        }
        $data['ket'] = $request->ket[0];
        $data['updated_by'] = Auth::id();
        $data['updated_at'] = Carbon::now()->toDateTimeString();
        $updatedata = KodePotongan::find($id)->update($data);

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
    public function destroy(Request $request)
    {
        $id = $request->iddata[0];
        $cektransaksi = Transaksi::where('fk_promo_id',$id)->first();
        if($cektransaksi){
            return response()->json([
                'status' => false,
                'message' => 'Data tidak dapat dihapus karena sudah digunakan'
            ]);
        }else{
            $data['deleted_by'] = Auth::id();
            $data['deleted_at'] = Carbon::now()->toDateTimeString();
            $updateData = KodePotongan::find($id)->update($data);
            return response()->json([
                'status' => true,
                'message' => 'Data berhasil dihapus'
            ]);
        }
    }
}
