<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Transaksi;
use App\Models\MasterMember;
// use App\Models\PaketSoalMst;
// use App\Models\PaketSoalKecermatanMst;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Crypt;

class MemberUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id)
    {
        $id = Crypt::decrypt($id);
        $menu = "user";
        $submenu="";
        $user=User::find($id);
        $data = Transaksi::where('fk_user_id',$id)->orderBy('expired','desc')->get();

        $arr = Transaksi::where('fk_user_id',$id)->pluck('fk_master_member_id')->all(); 
        $master_member = MasterMember::whereNotIn('id',$arr)->get();

        $data_param = [
            'submenu','menu','data','user','master_member'
        ];
        return view('master/memberuser')->with(compact($data_param));
    }

    public function store(Request $request)
    {
        $mstmember = MasterMember::find($request->fk_master_member_id_add);
        $cek = Transaksi::where('fk_user_id',$request->fk_user_add)->where('fk_master_member_id',$request->fk_master_member_id_add)->get();
        if(count($cek)>0){
            return response()->json([
                'status' => false,
                'message' => 'Gagal, paket '.$mstmember->judul.' sudah ada!'
            ]);
            dd('Error');
        }

        $mastermember = MasterMember::find($request->fk_master_member_id_add);
        $merchantOrderId    = time();

        $datacreate['merchant_order_id'] = $merchantOrderId;
        $datacreate['fk_user_id'] = $request->fk_user_add;
        $datacreate['fk_master_member_id'] = $request->fk_master_member_id_add;
        $datacreate['harga'] = $mastermember->harga;
        $datacreate['status'] = 1;
        $datacreate['expired'] = Carbon::now()->addMinutes(180)->toDateTimeString();
        $datacreate['created_by'] = Auth::id();
        $datacreate['created_at'] = Carbon::now()->toDateTimeString();
        $datacreate['updated_by'] = Auth::id();
        $datacreate['updated_at'] = Carbon::now()->toDateTimeString();
        $createdata = Transaksi::create($datacreate);

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
        $updateData = Transaksi::find($id)->update($data);
        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }

    // public function getPaketSoalUser(Request $request)
    // {
    //     $iduser = $request->iduser;
    //     $user = User::find($iduser);
    //     $arr = PaketUser::where('fk_user',$iduser)->where('jenis',$request->val)->pluck('fk_paket_soal_mst')->all(); 
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

}
