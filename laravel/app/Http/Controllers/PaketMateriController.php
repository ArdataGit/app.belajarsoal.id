<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PaketMateri;
use App\Models\PaketMst;
use App\Models\KategoriMateri;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use Auth;

class PaketMateriController extends Controller
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
        $data = PaketMateri::where('fk_paket_mst',$idmst)->get();

        $kategoris = KategoriMateri::kategoris_by_name('Materi');

        $data_param = [
            'menu','submenu','data','idmst','datamst','kategoris'
        ];
        return view('master/paketmateri')->with(compact($data_param));
    }

    public function store(Request $request)
    {
        $kats  = $request->kategori;
        if(!$kats || !is_array($kats))$kats = [];
        $katid = $kats ? end($kats) : 0;
        $data['kategori_id'] = $katid;

        $data['fk_paket_mst'] = $request->fk_paket_mst;
        $data['judul'] = $request->judul_add;
        $data['jenis'] = $request->jenis_add;
        // dd($request->jenis_add);
        if($request->jenis_add==1){
            $data['link'] = $request->link_add;
        }else{
            if ($files = $request->file("materi_add")) {
                $destinationPath = 'upload/materi/'.$request->fk_paket_mst.'/';
                $file = 'Materi_'.Carbon::now()->timestamp. "." .$files->getClientOriginalExtension();
                $files->move($destinationPath, $file);
                $namafile = $destinationPath.$file;
                $data['link'] = $destinationPath.$file;
            }
        }
        $data['ket'] = $request->ket_add;
        $data['created_by'] = Auth::id();
        $data['created_at'] = Carbon::now()->toDateTimeString();
        $data['updated_by'] = Auth::id();
        $data['updated_at'] = Carbon::now()->toDateTimeString();
        $createdata = PaketMateri::create($data);
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
        $data['jenis'] = $request->jenis[0];

        if($request->jenis[0]==1){
            $data['link'] = $request->link[0];
        }else{
            if($request->file("materi")){
                if ($files = $request->file("materi")[0]) {
                    $destinationPath = 'upload/materi/'.$request->fk_paket_mst.'/';
                    $file = 'Banner_'.Carbon::now()->timestamp. "." .$files->getClientOriginalExtension();
                    $files->move($destinationPath, $file);
                    $namafile = $destinationPath.$file;
                    $data['link'] = $destinationPath.$file;
                }
            }
        }
        
        $data['ket'] = $request->ket[0];
        $data['updated_by'] = Auth::id();
        $data['updated_at'] = Carbon::now()->toDateTimeString();

        $updatedata = PaketMateri::find($id)->update($data);

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
        $updateData = PaketMateri::find($id)->update($data);
        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }
}
