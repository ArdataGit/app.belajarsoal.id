<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PaketZoom;
use App\Models\PaketMst;
use App\Models\KategoriMateri;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use Auth;

class PaketZoomController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($idmst)
    {
        $menu = 'master';
        $submenu='paketmst';
        $datamst = PaketMst::find($idmst);
        $data = PaketZoom::where('fk_paket_mst',$idmst)->get();        

        $kategoris = KategoriMateri::kategoris_by_name('Zoom');

        $data_param = [
            'menu','submenu','data','idmst','datamst','kategoris'
        ];
        return view('master/paketzoom')->with(compact($data_param));
    }

    public function store(Request $request)
    {
        $kats  = $request->kategori;
        if(!$kats || !is_array($kats))$kats = [];
        $katid = $kats ? end($kats) : 0;
        $data['kategori_id'] = $katid;
        $data['fk_paket_mst'] = $request->fk_paket_mst;
        $data['judul'] = $request->judul_add;
        $data['link'] = $request->link_add;
        $data['ket'] = $request->ket_add;
        $data['created_by'] = Auth::id();
        $data['created_at'] = Carbon::now()->toDateTimeString();
        $data['updated_by'] = Auth::id();
        $data['updated_at'] = Carbon::now()->toDateTimeString();
        $createdata = PaketZoom::create($data);
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
        $kats  = $request->kategori;
        if(!$kats || !is_array($kats))$kats = [];
        $katid = $kats ? end($kats) : 0;        
        $data['kategori_id'] = $katid;
        
        $data['judul'] = $request->judul[0];
        $data['link'] = $request->link[0];
        $data['ket'] = $request->ket[0];
        $data['updated_by'] = Auth::id();
        $data['updated_at'] = Carbon::now()->toDateTimeString();

        $updatedata = PaketZoom::find($id)->update($data);

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
        $updateData = PaketZoom::find($id)->update($data);
        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }
}
