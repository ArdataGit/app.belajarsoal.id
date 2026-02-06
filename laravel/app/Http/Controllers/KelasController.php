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

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;

use Carbon\Carbon;
use Auth;

class KelasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function userclass(Request $request, $idpaketdtl=0)
    {
        $id = Crypt::decrypt($idpaketdtl);
        $idmst = $id;

        $data = PaketMst::find($id);
        if ($data->is_gratis != 1) {
            $cekpaket = Transaksi::where('fk_user_id', Auth::id())->where('status', 1)->where('aktif_sampai', '>=', Carbon::now())->where('fk_paket_mst', $id)->first();
            if (!$cekpaket) {
                return Redirect::to(url('paketsayaktg'));
            }
        }
        $menu = "paketsayaktg";
        $submenu = "";
        $paketdtl = PaketDtl::where('fk_paket_mst', $id)->get();

        $today = $request->today;

        $todaydate = Carbon::now()->format('d/m/Y');
        $nowtimestamp = Carbon::now()->timestamp;
        $todaytimestamp = Carbon::today()->timestamp;
        $tomorrowtimestamp = Carbon::tomorrow()->timestamp;

        $roles = Role::whereRaw("SUBSTR(`name`,1,6) = 'Mentor'")->orderBy('created_at','desc')->get();
        $roleids = [];
        foreach($roles as $role)$roleids[] = $role->id;
        $mentors = [];
        if($roleids){
            $rows = User::WhereIn('role_id',$roleids)->orderBy('created_at','desc')->get();
            if($rows){
                foreach($rows as $row)$mentors[$row->id] = $row;
            }
        }
        
        $kelasids = PaketKelas::where('fk_paket_mst',$idmst)->pluck('fk_kelas')->all();

        $kelass = [];
        $rows   = Kelas::whereIn('id',$kelasids)->orderBy('created_at','desc')->get();
        foreach($rows as &$row){
            $tanggal = explode('-',substr($row->tanggal,0,10),3);
            $row->tanggal_mulai = $tanggal[2].'/'.$tanggal[1].'/'.$tanggal[0];
            $row->jam_mulai = substr($row->tanggal,11,2);
            $row->menit_mulai = substr($row->tanggal,14,2);
            $timestamp = Carbon::create($tanggal[0], $tanggal[1], $tanggal[2], $row->jam_mulai, $row->menit_mulai, 0)->timestamp;

            if(!$today || (($timestamp>=$todaytimestamp) && ($timestamp<=$todaytimestamp))){
                $row->mentor_name = isset($mentors[$row->mentor_id]) ? $mentors[$row->mentor_id]->name : '<i>not set</i>';

                $row->time_status = 'later';
                if($nowtimestamp>=$timestamp){
                    $row->time_status = 'end';
                    $seconds = $row->waktu * 60;
                    if($nowtimestamp<$timestamp+$seconds){
                        $row->time_status = 'now';
                    }
                }

                $kelass[] = $row;
            }
        }

        $data_param = [
            'submenu', 'menu', 'data', 'paketdtl', 'idpaketdtl','mentors','kelass','today'
        ];
        return view('kelas/userclass')->with(compact($data_param));
    }

    public function userclass_room(Request $request, $idpaketdtl=0,$cid=0)
    {
        $id = Crypt::decrypt($idpaketdtl);
        $idmst = $id;

        $data = PaketMst::find($id);
        if ($data->is_gratis != 1) {
            $cekpaket = Transaksi::where('fk_user_id', Auth::id())->where('status', 1)->where('aktif_sampai', '>=', Carbon::now())->where('fk_paket_mst', $id)->first();
            if (!$cekpaket) {
                return Redirect::to(url('paketsayaktg'));
            }
        }
        $menu = "paketsayaktg";
        $submenu = "";
        $paketdtl = PaketDtl::where('fk_paket_mst', $id)->get();

        $nowtimestamp = Carbon::now()->timestamp;
        $todaytimestamp = Carbon::today()->timestamp;

        $roles = Role::whereRaw("SUBSTR(`name`,1,6) = 'Mentor'")->orderBy('created_at','desc')->get();
        $roleids = [];
        foreach($roles as $role)$roleids[] = $role->id;
        $mentors = [];
        if($roleids){
            $rows = User::WhereIn('role_id',$roleids)->orderBy('created_at','desc')->get();
            if($rows){
                foreach($rows as $row)$mentors[$row->id] = $row;
            }
        }
        
        $kelasids = PaketKelas::where('fk_paket_mst',$idmst)->pluck('fk_kelas')->all();
        if($kelasids && !in_array($cid, $kelasids))$kelasids = [];
        if($kelasids){
            $row = Kelas::where('id', $cid)->get()->first();

            $tanggal = explode('-',substr($row->tanggal,0,10),3);
            $row->tanggal_mulai = $tanggal[2].'/'.$tanggal[1].'/'.$tanggal[0];
            $row->jam_mulai = substr($row->tanggal,11,2);
            $row->menit_mulai = substr($row->tanggal,14,2);
            $timestamp = Carbon::create($tanggal[0], $tanggal[1], $tanggal[2], $row->jam_mulai, $row->menit_mulai, 0)->timestamp;

            $row->mentor_name = isset($mentors[$row->mentor_id]) ? $mentors[$row->mentor_id]->name : '<i>not set</i>';
            
            $row->time_status = 'later';
            if($nowtimestamp>=$timestamp){
                $row->time_status = 'end';
                $seconds = $row->waktu * 60;
                if($nowtimestamp<$timestamp+$seconds){
                    $row->time_status = 'now';
                }
            }
            $kelas = $row;
        }else{
            $kelas = null;
        }

        $peserta  = $this->peserta_kelas($cid);
        $presensi = $this->peserta_presensi($cid, $peserta);
        $sudah_presensi = ($presensi && isset($presensi[Auth::id()]) && $presensi[Auth::id()]['hadir']);

        $data_param = [
            'submenu', 'menu', 'data', 'paketdtl', 'idpaketdtl','mentors','kelas','sudah_presensi'
        ];
        return view('kelas/userclass_room')->with(compact($data_param));
    }


    public function userclass_presensi(Request $request, $idpaketdtl=0, $cid=0)
    {
        $id = Crypt::decrypt($idpaketdtl);
        $idmst = $id;

        $data = PaketMst::find($id);
        if ($data->is_gratis != 1) {
            $cekpaket = Transaksi::where('fk_user_id', Auth::id())->where('status', 1)->where('aktif_sampai', '>=', Carbon::now())->where('fk_paket_mst', $id)->first();
            if (!$cekpaket) {
                return Redirect::to(url('paketsayaktg'));
            }
        }

        $peserta  = $this->peserta_kelas($cid);
        $presensi = $this->peserta_presensi($cid, $peserta);
        $sudah_presensi = ($presensi && isset($presensi[Auth::id()]) && $presensi[Auth::id()]['hadir']);

        $menu = "paketsayaktg";
        $submenu = "";
        $paketdtl = PaketDtl::where('fk_paket_mst', $id)->get();

        $nowtimestamp = Carbon::now()->timestamp;
        $todaytimestamp = Carbon::today()->timestamp;

        $roles = Role::whereRaw("SUBSTR(`name`,1,6) = 'Mentor'")->orderBy('created_at','desc')->get();
        $roleids = [];
        foreach($roles as $role)$roleids[] = $role->id;
        $mentors = [];
        if($roleids){
            $rows = User::WhereIn('role_id',$roleids)->orderBy('created_at','desc')->get();
            if($rows){
                foreach($rows as $row)$mentors[$row->id] = $row;
            }
        }
        
        $kelasids = PaketKelas::where('fk_paket_mst',$idmst)->pluck('fk_kelas')->all();
        if($kelasids && !in_array($cid, $kelasids))$kelasids = [];
        if($kelasids){
            $row = Kelas::where('id', $cid)->get()->first();

            $tanggal = explode('-',substr($row->tanggal,0,10),3);
            $row->tanggal_mulai = $tanggal[2].'/'.$tanggal[1].'/'.$tanggal[0];
            $row->jam_mulai = substr($row->tanggal,11,2);
            $row->menit_mulai = substr($row->tanggal,14,2);
            $timestamp = Carbon::create($tanggal[0], $tanggal[1], $tanggal[2], $row->jam_mulai, $row->menit_mulai, 0)->timestamp;

            $row->mentor_name = isset($mentors[$row->mentor_id]) ? $mentors[$row->mentor_id]->name : '<i>not set</i>';
            
            $row->time_status = 'later';
            if($nowtimestamp>=$timestamp){
                $row->time_status = 'end';
                $seconds = $row->waktu * 60;
                if($nowtimestamp<$timestamp+$seconds){
                    $row->time_status = 'now';
                }
            }
            $kelas = $row;
        }else{
            $kelas = null;
        }

        $data_param = [
            'submenu', 'menu', 'data', 'paketdtl', 'idpaketdtl','mentors','kelas','presensi','sudah_presensi'
        ];
        return view('kelas/userclass_presensi')->with(compact($data_param));
    }

    public function userclass_hadir(Request $request, $idpaketdtl=0, $cid=0)
    {
        $createdata = false;
        $row = Kelas::where('id', $cid)->get()->first();
        if($row){
            $tanggal = explode('-',substr($row->tanggal,0,10),3);
            $row->tanggal_mulai = $tanggal[2].'/'.$tanggal[1].'/'.$tanggal[0];
            $row->jam_mulai = substr($row->tanggal,11,2);
            $row->menit_mulai = substr($row->tanggal,14,2);
            $timestamp = Carbon::create($tanggal[0], $tanggal[1], $tanggal[2], $row->jam_mulai, $row->menit_mulai, 0)->timestamp;

            $nowtimestamp = Carbon::now()->timestamp;
            if($nowtimestamp>=$timestamp){
                $seconds = $row->waktu * 60;
                if($nowtimestamp<$timestamp+$seconds){
                    $createdata = true;
                }
            }
        }
        if($createdata){
            $data['fk_user'] = Auth::id();
            $data['fk_kelas'] = $cid;
            $data['hadir'] = Carbon::now()->format('H:i');
            $data['created_at'] = Carbon::now()->toDateTimeString();
            $createdata = Presensi::create($data);
        }
        if($createdata){
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

    public function mentor(Request $request)
    {
        $menu = 'mentor';
        $submenu = 'mentor';
        
        $today = $request->today;
        
        $todaydate = Carbon::now()->format('d/m/Y');
        $nowtimestamp = Carbon::now()->timestamp;
        $todaytimestamp = Carbon::today()->timestamp;
        $tomorrowtimestamp = Carbon::tomorrow()->timestamp;

        $mentors = [Auth::id() => User::where('id',Auth::id())->get()->first()];
        
        $kelass = [];
        $rows = Kelas::where('mentor_id',Auth::id())->orderBy('created_at','desc')->get();
        foreach($rows as &$row){
            $tanggal = explode('-',substr($row->tanggal,0,10),3);
            $row->tanggal_mulai = $tanggal[2].'/'.$tanggal[1].'/'.$tanggal[0];
            $row->jam_mulai = substr($row->tanggal,11,2);
            $row->menit_mulai = substr($row->tanggal,14,2);
            $timestamp = Carbon::create($tanggal[0], $tanggal[1], $tanggal[2], $row->jam_mulai, $row->menit_mulai, 0)->timestamp;

            if(!$today || (($timestamp>=$todaytimestamp) && ($timestamp<=$tomorrowtimestamp))){
                $row->mentor_name = isset($mentors[$row->mentor_id]) ? $mentors[$row->mentor_id]->name : '<i>not set</i>';

                $row->time_status = 'later';
                if($nowtimestamp>=$timestamp){
                    $row->time_status = 'end';
                    $seconds = $row->waktu * 60;
                    if($nowtimestamp<$timestamp+$seconds){
                        $row->time_status = 'now';
                    }
                }

                $kelass[] = $row;
            }
        }

        $data_param = [
            'menu','submenu','mentors','kelass','today'
        ];

        return view('kelas/mentor')->with(compact($data_param));
    }

    public function mentorroom(Request $request, $id=0){
        $menu = 'mentor';
        $submenu = 'mentor';
        
        $nowtimestamp = Carbon::now()->timestamp;
        $todaytimestamp = Carbon::today()->timestamp;
        
        $mentors = [Auth::id() => User::where('id',Auth::id())->get()->first()];

        $row = Kelas::where('id', $id)->get()->first();

        $tanggal = explode('-',substr($row->tanggal,0,10),3);
        $row->tanggal_mulai = $tanggal[2].'/'.$tanggal[1].'/'.$tanggal[0];
        $row->jam_mulai = substr($row->tanggal,11,2);
        $row->menit_mulai = substr($row->tanggal,14,2);
        $timestamp = Carbon::create($tanggal[0], $tanggal[1], $tanggal[2], $row->jam_mulai, $row->menit_mulai, 0)->timestamp;

        $row->mentor_name = isset($mentors[$row->mentor_id]) ? $mentors[$row->mentor_id]->name : '<i>not set</i>';
        
        $row->time_status = 'later';
        if($nowtimestamp>=$timestamp){
            $row->time_status = 'end';
            $seconds = $row->waktu * 60;
            if($nowtimestamp<$timestamp+$seconds){
                $row->time_status = 'now';
            }
        }
        $kelas = $row;

        $data_param = [
            'menu','submenu','mentors','kelas'
        ];

        return view('kelas/mentorroom')->with(compact($data_param));
    }

    public function mentorroom_presensi(Request $request, $id=0){
        $menu = 'kelas';
        $submenu = 'kelas';

        $peserta  = $this->peserta_kelas($id);
        $presensi = $this->peserta_presensi($id, $peserta);

        $nowtimestamp = Carbon::now()->timestamp;
        $todaytimestamp = Carbon::today()->timestamp;
        
        $mentors = [Auth::id() => User::where('id',Auth::id())->get()->first()];

        $row = Kelas::where('id', $id)->get()->first();

        $tanggal = explode('-',substr($row->tanggal,0,10),3);
        $row->tanggal_mulai = $tanggal[2].'/'.$tanggal[1].'/'.$tanggal[0];
        $row->jam_mulai = substr($row->tanggal,11,2);
        $row->menit_mulai = substr($row->tanggal,14,2);
        $timestamp = Carbon::create($tanggal[0], $tanggal[1], $tanggal[2], $row->jam_mulai, $row->menit_mulai, 0)->timestamp;

        $row->mentor_name = isset($mentors[$row->mentor_id]) ? $mentors[$row->mentor_id]->name : '<i>not set</i>';
        
        $row->time_status = 'later';
        if($nowtimestamp>=$timestamp){
            $row->time_status = 'end';
            $seconds = $row->waktu * 60;
            if($nowtimestamp<$timestamp+$seconds){
                $row->time_status = 'now';
            }
        }
        $kelas = $row;

        $data_param = [
            'menu','submenu','mentors','kelas','presensi'
        ];

        return view('kelas/mentorpresensi')->with(compact($data_param));
    }

    public function mentorroom_hadir(Request $request, $id=0)
    {
        $updatedata = false;
        $row = Kelas::where('id', $id)->get()->first();
        if($row){
            $tanggal = explode('-',substr($row->tanggal,0,10),3);
            $row->tanggal_mulai = $tanggal[2].'/'.$tanggal[1].'/'.$tanggal[0];
            $row->jam_mulai = substr($row->tanggal,11,2);
            $row->menit_mulai = substr($row->tanggal,14,2);
            $timestamp = Carbon::create($tanggal[0], $tanggal[1], $tanggal[2], $row->jam_mulai, $row->menit_mulai, 0)->timestamp;

            $nowtimestamp = Carbon::now()->timestamp;
            if($nowtimestamp>=$timestamp){
                $seconds = $row->waktu * 60;
                if($nowtimestamp<$timestamp+$seconds){
                    $updatedata = true;
                }
            }
        }
        if($updatedata){
            $data['mentor_hadir'] = Carbon::now()->format('H:i');
            $data['updated_by'] = Auth::id();
            $data['updated_at'] = Carbon::now()->toDateTimeString();
            $updatedata = Kelas::find($id)->update($data);
        }
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

    public function mentorroom_buka(Request $request, $id=0)
    {
        $updatedata = false;
        $row = Kelas::where('id', $id)->get()->first();
        if($row && $row->mentor_hadir){
            $tanggal = explode('-',substr($row->tanggal,0,10),3);
            $row->tanggal_mulai = $tanggal[2].'/'.$tanggal[1].'/'.$tanggal[0];
            $row->jam_mulai = substr($row->tanggal,11,2);
            $row->menit_mulai = substr($row->tanggal,14,2);
            $timestamp = Carbon::create($tanggal[0], $tanggal[1], $tanggal[2], $row->jam_mulai, $row->menit_mulai, 0)->timestamp;

            $nowtimestamp = Carbon::now()->timestamp;
            if($nowtimestamp>=$timestamp){
                $seconds = $row->waktu * 60;
                if($nowtimestamp<$timestamp+$seconds){
                    $updatedata = true;
                }
            }
        }
        if($updatedata){
            $data['mentor_open'] = Carbon::now()->format('H:i');
            $data['updated_by'] = Auth::id();
            $data['updated_at'] = Carbon::now()->toDateTimeString();
            $updatedata = Kelas::find($id)->update($data);
        }
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

    public function mentorroom_edit(Request $request, $id=0)
    {
        $data['link'] = $request->link_live;
        $data['keterangan'] = $request->keterangan;
        $data['updated_by'] = Auth::id();
        $data['updated_at'] = Carbon::now()->toDateTimeString();
        $updatedata = Kelas::find($id)->update($data);
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

    public function kelas(Request $request)
    {
        $menu = 'kelas';
        $submenu = 'kelas';
        
        $today = $request->today;
        $todaydate = Carbon::now()->format('d/m/Y');
        $nowtimestamp = Carbon::now()->timestamp;
        $todaytimestamp = Carbon::today()->timestamp;
        $tomorrowtimestamp = Carbon::tomorrow()->timestamp;
        
        $roles = Role::whereRaw("SUBSTR(`name`,1,6) = 'Mentor'")->orderBy('created_at','desc')->get();
        $roleids = [];
        foreach($roles as $role)$roleids[] = $role->id;
        $mentors = [];
        if($roleids){
            $rows = User::WhereIn('role_id',$roleids)->orderBy('created_at','desc')->get();
            if($rows){
                foreach($rows as $row)$mentors[$row->id] = $row;
            }
        }

        $kelass = [];
        $rows = Kelas::orderBy('created_at','desc')->get();
        foreach($rows as &$row){
            $tanggal = explode('-',substr($row->tanggal,0,10),3);
            $row->tanggal_mulai = $tanggal[2].'/'.$tanggal[1].'/'.$tanggal[0];
            $row->jam_mulai = substr($row->tanggal,11,2);
            $row->menit_mulai = substr($row->tanggal,14,2);
            
            $timestamp = Carbon::create($tanggal[0], $tanggal[1], $tanggal[2], $row->jam_mulai, $row->menit_mulai, 0)->timestamp;

            if(!$today || (($timestamp>=$todaytimestamp) && ($timestamp<=$tomorrowtimestamp))){
                $row->mentor_name = isset($mentors[$row->mentor_id]) ? $mentors[$row->mentor_id]->name : '<i>not set</i>';
                
                $row->time_status = 'later';
                if($nowtimestamp>=$timestamp){
                    $row->time_status = 'end';
                    $seconds = $row->waktu * 60;
                    if($nowtimestamp<$timestamp+$seconds){
                        $row->time_status = 'now';
                    }
                }

                $kelass[] = $row;
            }
        }

        $data_param = [
            'menu','submenu','mentors','kelass','today'
        ];

        return view('kelas/kelas')->with(compact($data_param));
    }

    public function kelasroom(Request $request, $id=0){
        $menu = 'kelas';
        $submenu = 'kelas';
        
        $nowtimestamp = Carbon::now()->timestamp;
        $todaytimestamp = Carbon::today()->timestamp;
        
        $roles = Role::whereRaw("SUBSTR(`name`,1,6) = 'Mentor'")->orderBy('created_at','desc')->get();
        $roleids = [];
        foreach($roles as $role)$roleids[] = $role->id;
        $mentors = [];
        if($roleids){
            $rows = User::WhereIn('role_id',$roleids)->orderBy('created_at','desc')->get();
            if($rows){
                foreach($rows as $row)$mentors[$row->id] = $row;
            }
        }

        $row = Kelas::where('id', $id)->get()->first();

        $tanggal = explode('-',substr($row->tanggal,0,10),3);
        $row->tanggal_mulai = $tanggal[2].'/'.$tanggal[1].'/'.$tanggal[0];
        $row->jam_mulai = substr($row->tanggal,11,2);
        $row->menit_mulai = substr($row->tanggal,14,2);

        $timestamp = Carbon::create($tanggal[0], $tanggal[1], $tanggal[2], $row->jam_mulai, $row->menit_mulai, 0)->timestamp;

        $row->mentor_name = isset($mentors[$row->mentor_id]) ? $mentors[$row->mentor_id]->name : '<i>not set</i>';
        
        $row->time_status = 'later';
        if($nowtimestamp>=$timestamp){
            $row->time_status = 'end';
            $seconds = $row->waktu * 60;
            if($nowtimestamp<$timestamp+$seconds){
                $row->time_status = 'now';
            }
        }
        $kelas = $row;

        $data_param = [
            'menu','submenu','mentors','kelas'
        ];

        return view('kelas/kelasroom')->with(compact($data_param));
    }

    private function peserta_kelas($id=0){
        $pakets = PaketKelas::where('fk_kelas',$id)->pluck('fk_paket_mst')->all();
        if(!$pakets)return [];
        $pakets = PaketMst::whereIn('id',$pakets)->orderBy('created_at','desc')->pluck('is_gratis','id')->all();
        if(!$pakets)return [];
        $gratis = false;
        foreach($pakets as $id=>$isgratis){
            if($isgratis){
                $gratis = true;
                break;
            }
        }
        if($gratis)return User::where('user_level',2)->where('is_active',1)->pluck('name','id')->all();
        $pakets = array_keys($pakets);
        $users  = Transaksi::whereIn('fk_paket_mst',$pakets)->where('status', 1)->where('aktif_sampai', '>=', Carbon::now())->pluck('fk_user_id')->all();
        if(!$users)return [];
        return User::whereIn('id',$users)->where('user_level',2)->where('is_active',1)->pluck('name','id')->all();
    }
    

    private function peserta_presensi($id, $peserta){        
        $rows = Presensi::groupBy('fk_user')->where('fk_kelas',$id)->pluck('hadir','fk_user')->all();
        $presensi = [];
        foreach($rows as $uid=>$hadir){
            if(isset($peserta[$uid]))$presensi[$uid] = ['nama'=>$peserta[$uid], 'hadir'=>$hadir];
        }
        foreach($peserta as $uid=>$nama){
            if(!isset($presensi[$uid]))$presensi[$uid] = ['nama'=>$nama, 'hadir'=>''];
        }
        return $presensi;
    }
    

    public function kelasroom_presensi(Request $request, $id=0){
        $menu = 'kelas';
        $submenu = 'kelas';

        $peserta  = $this->peserta_kelas($id);
        $presensi = $this->peserta_presensi($id, $peserta);

        $nowtimestamp = Carbon::now()->timestamp;
        $todaytimestamp = Carbon::today()->timestamp;
        
        $roles = Role::whereRaw("SUBSTR(`name`,1,6) = 'Mentor'")->orderBy('created_at','desc')->get();
        $roleids = [];
        foreach($roles as $role)$roleids[] = $role->id;
        $mentors = [];
        if($roleids){
            $rows = User::WhereIn('role_id',$roleids)->orderBy('created_at','desc')->get();
            if($rows){
                foreach($rows as $row)$mentors[$row->id] = $row;
            }
        }

        $row = Kelas::where('id', $id)->get()->first();

        $tanggal = explode('-',substr($row->tanggal,0,10),3);
        $row->tanggal_mulai = $tanggal[2].'/'.$tanggal[1].'/'.$tanggal[0];
        $row->jam_mulai = substr($row->tanggal,11,2);
        $row->menit_mulai = substr($row->tanggal,14,2);
        $timestamp = Carbon::create($tanggal[0], $tanggal[1], $tanggal[2], $row->jam_mulai, $row->menit_mulai, 0)->timestamp;

        $row->mentor_name = isset($mentors[$row->mentor_id]) ? $mentors[$row->mentor_id]->name : '<i>not set</i>';
        
        $row->time_status = 'later';
        if($nowtimestamp>=$timestamp){
            $row->time_status = 'end';
            $seconds = $row->waktu * 60;
            if($nowtimestamp<$timestamp+$seconds){
                $row->time_status = 'now';
            }
        }
        $kelas = $row;

        $data_param = [
            'menu','submenu','mentors','kelas','presensi'
        ];

        return view('kelas/kelaspresensi')->with(compact($data_param));
    }

    public function add_kelas(Request $request)
    {
        $data['mentor_id'] = $request->mentor;
        $data['link'] = '';
        $data['keterangan'] = '';
        $data['name'] = $request->nama_kelas;
        $data['judul'] = $request->judul_kelas;
        $data['materi'] = $request->materi_kelas;
        $tanggal = explode('/', $request->tanggal_mulai,3);
        $data['tanggal'] = $tanggal[2].'-'.$tanggal[1].'-'.$tanggal[0].' '.$request->jam_mulai.':'.$request->menit_mulai;
        $data['waktu'] = $request->lama_kelas;
        $data['created_by'] = Auth::id();
        $data['created_at'] = Carbon::now()->toDateTimeString();
        $data['updated_by'] = Auth::id();
        $data['updated_at'] = Carbon::now()->toDateTimeString();
        $createdata = Kelas::create($data);
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

    public function update_kelas(Request $request, $id=0)
    {

        if($request->submit=='reactivate'){
            $data['deleted_at'] = Carbon::now()->toDateTimeString();
            Presensi::where('fk_kelas',$id)->where('deleted_at','0000-00-00 00:00:00')->update($data);
            $data = [];
            $data['mentor_open']  = '';
            $data['mentor_hadir'] = '';
        }

        $data['mentor_id'] = $request->mentor;
        $data['name'] = $request->nama_kelas;
        $data['judul'] = $request->judul_kelas;
        $data['materi'] = $request->materi_kelas;
        $tanggal = explode('/', $request->tanggal_mulai,3);
        $data['tanggal'] = $tanggal[2].'-'.$tanggal[1].'-'.$tanggal[0].' '.$request->jam_mulai.':'.$request->menit_mulai;
        $data['waktu'] = $request->lama_kelas;
        $data['updated_by'] = Auth::id();
        $data['updated_at'] = Carbon::now()->toDateTimeString();
        $updatedata = Kelas::find($id)->update($data);
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

    public function hapus_kelas($id)
    {
        $data['deleted_by'] = Auth::id();
        $data['deleted_at'] = Carbon::now()->toDateTimeString();
        $updateData = Kelas::find($id)->update($data);
        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }

    public function paket($idmst)
    {
        $menu = 'master';
        $submenu='paketmst';
        $datamst = PaketMst::find($idmst);
        
        $kelass = [];        
        $rows   = Kelas::orderBy('created_at','desc')->get();
        foreach($rows as $row){
            $tanggal = explode('-',substr($row->tanggal,0,10),3);
            $row->tanggal_mulai = $tanggal[2].'/'.$tanggal[1].'/'.$tanggal[0];
            $row->jam_mulai = substr($row->tanggal,11,2);
            $row->menit_mulai = substr($row->tanggal,14,2);
            $kelass[$row->id] = $row;
        }

        $data = PaketKelas::where('fk_paket_mst',$idmst)->get();
        foreach($data as &$key){
            $key->nama_kelas = isset($kelass[$key->fk_kelas]) ? $kelass[$key->fk_kelas]->name : '<i>not set</i>';
            $key->tanggal_kelas = isset($kelass[$key->fk_kelas]) ? $kelass[$key->fk_kelas]->tanggal_mulai : '<i>not set</i>';
            $key->jam_kelas = isset($kelass[$key->fk_kelas]) ? $kelass[$key->fk_kelas]->jam_mulai : '<i>not set</i>';
            $key->menit_kelas = isset($kelass[$key->fk_kelas]) ? $kelass[$key->fk_kelas]->menit_mulai : '<i>not set</i>';
        }

        $data_param = [
            'menu','submenu','data','idmst','datamst','kelass'
        ];
        return view('kelas/paket')->with(compact($data_param));
    }

    public function paketstore(Request $request)
    {
        $data['fk_paket_mst'] = $request->fk_paket_mst;
        $data['fk_kelas'] = $request->kelas_add;
        $data['ket'] = $request->ket_add;
        $data['created_by'] = Auth::id();
        $data['created_at'] = Carbon::now()->toDateTimeString();
        $data['updated_by'] = Auth::id();
        $data['updated_at'] = Carbon::now()->toDateTimeString();
        $createdata = PaketKelas::create($data);
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

    public function paketupdate(Request $request, $id)
    {
        $data['fk_kelas'] = $request->kelas[0];
        $data['ket'] = $request->ket[0];
        $data['updated_by'] = Auth::id();
        $data['updated_at'] = Carbon::now()->toDateTimeString();

        $updatedata = PaketKelas::find($id)->update($data);

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

    public function paketdestroy($id)
    {
        $data['deleted_by'] = Auth::id();
        $data['deleted_at'] = Carbon::now()->toDateTimeString();
        $updateData = PaketKelas::find($id)->update($data);
        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }

}    