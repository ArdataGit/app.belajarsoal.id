<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

use App\Models\PaketKelas;
use App\Models\Kelas;
use App\Models\PaketMst;
use App\Models\Transaksi;
use App\Models\Presensi;
use App\Models\PaketDtl;
use App\Models\PaketMateri;
use App\Models\PaketZoom;
use App\Models\UMapelMst;
use App\Models\KategoriMateri;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;

use Carbon\Carbon;
use Auth;

class KategoriMateriController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $menu = 'master';
        $submenu='kategorimateri';
        $kategoris = KategoriMateri::kategoris();
        $data_param = [
            'menu','submenu','kategoris'
        ];
        return view('master/kategorimateri')->with(compact($data_param));
    }

    public function store(Request $request, $parent=0)
    {   
        $data['parent_id']  = $parent ? $parent : 0;
        $data['name'] = $request->name;
        $data['katerangan'] = $request->keterangan;
        $data['created_by'] = Auth::id();
        $data['created_at'] = Carbon::now()->toDateTimeString();
        $data['updated_by'] = Auth::id();
        $data['updated_at'] = Carbon::now()->toDateTimeString();
        $createdata = KategoriMateri::create($data);
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
        $data['name'] = $request->name;
        $data['keterangan'] = $request->keterangan;
        $data['updated_by'] = Auth::id();
        $data['updated_at'] = Carbon::now()->toDateTimeString();
        $updatedata = KategoriMateri::find($id)->update($data);
        if($updatedata){
            return response()->json([
                'status' => true,
                'message' => 'Berhasil update data'
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
        $updateData = KategoriMateri::find($id)->update($data);
        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }

}    