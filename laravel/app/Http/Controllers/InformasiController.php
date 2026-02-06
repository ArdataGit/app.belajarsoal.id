<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Informasi;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use Auth;

class InformasiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $menu = 'informasi';
        $submenu='';
        $data = Informasi::orderBy('created_at','desc')->get();
        $data_param = [
            'menu','submenu','data'
        ];
        return view('master/informasi')->with(compact($data_param));
    }

    public function store(Request $request)
    {
      
        if ($files = $request->file("gambar_add")) {
            $destinationPath = 'upload/informasi/';
            $file = 'Gambar_'.Carbon::now()->timestamp. "." .$files->getClientOriginalExtension();
            $files->move($destinationPath, $file);
            $namafile = $destinationPath.$file;
            $data['gambar'] = $destinationPath.$file;
        }
        $data['judul'] = $request->judul_add;
        $data['link'] = $request->link_add;
        $data['ket'] = $request->ket_add;
        $data['isi'] = $request->isi_add;
        $data['created_by'] = Auth::id();
        $data['created_at'] = Carbon::now()->toDateTimeString();
        $data['updated_by'] = Auth::id();
        $data['updated_at'] = Carbon::now()->toDateTimeString();
        $createdata = Informasi::create($data);
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

        if($request->file("gambar")){
            if ($files = $request->file("gambar")[0]) {
                $destinationPath = 'upload/informasi/';
                $file = 'Gambar_'.Carbon::now()->timestamp. "." .$files->getClientOriginalExtension();
                $files->move($destinationPath, $file);
                $namafile = $destinationPath.$file;
                $data['gambar'] = $destinationPath.$file;
            }
        }
        $data['judul'] = $request->judul[0];
        $data['link'] = $request->link[0];
        $data['ket'] = $request->ket[0];
        $data['isi'] = $request->isi[0];
        $data['updated_by'] = Auth::id();
        $data['updated_at'] = Carbon::now()->toDateTimeString();
        $updatedata = Informasi::find($id)->update($data);

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
        $data['deleted_by'] = Auth::id();
        $data['deleted_at'] = Carbon::now()->toDateTimeString();
        $updateData = Informasi::find($id)->update($data);
        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }
}
