<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PaketUser;
use App\Models\PaketSoalMst;
use App\Models\PaketSoalKecermatanMst;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Crypt;

class PaketUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id)
    {
        $id = Crypt::decrypt($id);
        $menu = 'user';
        $submenu='';
        $user = User::find($id);
        $data = PaketUser::where('fk_user',$id)->orderBy('jenis','asc')->get();
        $data_param = [
            'menu','submenu','data','user'
        ];

        return view('master/paketuser')->with(compact($data_param));
    }

    public function store(Request $request)
    {
        $cek = PaketUser::where('fk_user',$request->fk_user_add)->where('fk_paket_soal_mst',$request->fk_paket_soal_mst_add)->where('jenis',$request->jenis_soal_add)->get();
        if(count($cek)>0){
            return response()->json([
                'status' => false,
                'message' => 'Gagal. Mohon coba kembali!'
            ]);
            dd('Error');
        }
        $data['fk_paket_soal_mst'] = $request->fk_paket_soal_mst_add;
        $data['fk_user'] = $request->fk_user_add;
        $data['jenis'] = $request->jenis_soal_add;
        $data['created_by'] = Auth::id();
        $data['created_at'] = Carbon::now()->toDateTimeString();
        $data['updated_by'] = Auth::id();
        $data['updated_at'] = Carbon::now()->toDateTimeString();
        $createdata = PaketUser::create($data);
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

    public function destroy($id)
    {
        $data['deleted_by'] = Auth::id();
        $data['deleted_at'] = Carbon::now()->toDateTimeString();
        $updateData = PaketUser::find($id)->update($data);
        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }

    public function getPaketSoalUser(Request $request)
    {
        $iduser = $request->iduser;
        $user = User::find($iduser);
        $arr = PaketUser::where('fk_user',$iduser)->where('jenis',$request->val)->pluck('fk_paket_soal_mst')->all(); 
        if($request->val==1){
            $datapaket = PaketSoalMst::whereNotIn('id',$arr)->get(['id AS id', 'judul as text'])->toArray();
        }elseif($request->val==2){
            $datapaket = PaketSoalKecermatanMst::whereNotIn('id',$arr)->get(['id AS id', 'judul as text'])->toArray();
        }

        return response()->json([
            'status' => true,
            'datapaket' => $datapaket
        ]);
    }

}
