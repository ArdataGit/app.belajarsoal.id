<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use Illuminate\Support\Facades\Crypt;

use PDF;

use QrCode;

use Carbon\Carbon;

use App\Models\UMapelMst;

use App\Models\PaketSoalMst;

use App\Models\PaketMst;

use App\Models\PaketDtl;

use App\Models\PaketSoalDtl;

use App\Models\PaketSoalKtg;

use App\Models\PaketSoalKecermatanMst;

use App\Models\PaketSoalKecermatanDtl;

use App\Models\DtlSoalKecermatan;

use Auth;

use App\Models\User;



class PDFController extends Controller

{

        /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

    */



    public function __construct()

    {

        $this->middleware('auth');

    }



    public function sertifikat($idmapel,$iduser)

    {

        $idmapel = base64_decode($idmapel);

        $iduser = base64_decode($iduser);

        

        $umapel = UMapelMst::find($idmapel);

        $nosertifikat = "S".sprintf("%06d", $umapel->id);

        $mapel = PaketSoalMst::find($umapel->fk_mapel_mst);

        $eventdtl = PaketDtl::where('fk_mapel_mst',$umapel->fk_mapel_mst)->first();

        $eventmst = PaketMst::find($eventdtl->fk_event_mst)->first();

        $user = User::find($iduser);



        $url = url('sertifikat')."/".base64_encode($idmapel)."/".base64_encode($iduser);

        

        $qrcode = base64_encode(QrCode::format('svg')->size(200)->errorCorrection('H')->generate($url));



        $data = [

            'user' => $user,

            'mapel' => $mapel,

            'eventmst' => $eventmst,

            'qrcode' => $qrcode,

            'nosertifikat'=>$nosertifikat

        ];

        $pdf = PDF::loadView('pdf/Sertifikat', $data);

        $pdf->setPaper('A4','landscape');

        return $pdf->stream('Sertifikat.pdf'); 

    }



    public function piagam($idmapel,$iduser)

    {

        $idmapel = base64_decode($idmapel);

        $iduser = base64_decode($iduser);

        

        $umapel = UMapelMst::find($idmapel);

        $nopiagam = "P".sprintf("%06d", $umapel->id);

        $mapel = PaketSoalMst::find($umapel->fk_mapel_mst);

        $eventdtl = PaketDtl::where('fk_mapel_mst',$umapel->fk_mapel_mst)->first();

        $eventmst = PaketMst::find($eventdtl->fk_event_mst)->first();

        $user = User::find($iduser);



        $url = url('piagam')."/".base64_encode($idmapel)."/".base64_encode($iduser);

        

        $qrcode = base64_encode(QrCode::format('svg')->size(200)->errorCorrection('H')->generate($url));



        $data = [

            'user' => $user,

            'mapel' => $mapel,

            'eventmst' => $eventmst,

            'qrcode' => $qrcode,

            'nopiagam'=>$nopiagam,

            'nilai'=>$umapel->set_predikat

        ];

        $pdf = PDF::loadView('pdf/Piagam', $data);

        $pdf->setPaper('A4','landscape');

        return $pdf->stream('Piagam.pdf'); 

    }



    public function exportsoal($jns , $id){

        $id = Crypt::decrypt($id);

        

        if ($jns=="pilgan") {

            $paketsoalmst = PaketSoalMst::find($id);

            if($paketsoalmst->is_acak==1){
                $paketsoalktg = PaketSoalKtg::where('fk_paket_soal_mst',$id)->inRandomOrder()->get();
            }else{
                $paketsoalktg = PaketSoalKtg::where('fk_paket_soal_mst',$id)->get();
            }

            $paketsoaldtl = PaketSoalDtl::where('fk_paket_soal_mst',$id)->get();

            $data = [

                'paketsoalktg'=> $paketsoalktg,

                'paketsoalmst'=>$paketsoalmst,

                'paketsoaldtl'=>$paketsoaldtl

            ];

            $pdf = PDF::loadView('pdf/SoalPilGan', $data);

            $pdf->setPaper('A4','potrait');

            return $pdf->stream('Soal_Pilihan_Ganda.pdf'); 

        }elseif($jns=="kec"){

            $paketsoalmst = PaketSoalKecermatanMst::find($id);

            $paketsoaldtl = PaketSoalKecermatanDtl::where('fk_paket_soal_kecermatan_mst',$id)->inRandomOrder()->get();

            $arr = PaketSoalKecermatanDtl::where('fk_paket_soal_kecermatan_mst',$id)->pluck('fk_master_soal_kecermatan')->all(); 

            $dtlsoal = DtlSoalKecermatan::whereIn('fk_master_soal_kecermatan',$arr)->get();

            $data = [

                'paketsoaldtl'=> $paketsoaldtl,

                'paketsoalmst'=>$paketsoalmst,

                'dtlsoal'=>$dtlsoal

            ];

            $pdf = PDF::loadView('pdf/SoalKecermatan', $data);

            $pdf->setPaper('A4','potrait');

            return $pdf->stream('Soal_Kecermatan.pdf'); 

        }

    }
    
    public function exportsoalpembahasan($jns , $id){

        $id = Crypt::decrypt($id);

        

        if ($jns=="pilgan") {

            $paketsoalmst = PaketSoalMst::find($id);

            if($paketsoalmst->is_acak==1){
                $paketsoalktg = PaketSoalKtg::where('fk_paket_soal_mst',$id)->inRandomOrder()->get();
            }else{
                $paketsoalktg = PaketSoalKtg::where('fk_paket_soal_mst',$id)->get();
            }

            $paketsoaldtl = PaketSoalDtl::where('fk_paket_soal_mst',$id)->get();

            $data = [

                'paketsoalktg'=> $paketsoalktg,

                'paketsoalmst'=>$paketsoalmst,

                'paketsoaldtl'=>$paketsoaldtl

            ];

            $pdf = PDF::loadView('pdf/SoalPilGanPembahasan', $data);

            $pdf->setPaper('A4','potrait');

            return $pdf->stream('Soal_Pilihan_Ganda.pdf'); 

        }elseif($jns=="kec"){

            $paketsoalmst = PaketSoalKecermatanMst::find($id);

            $paketsoaldtl = PaketSoalKecermatanDtl::where('fk_paket_soal_kecermatan_mst',$id)->inRandomOrder()->get();

            $arr = PaketSoalKecermatanDtl::where('fk_paket_soal_kecermatan_mst',$id)->pluck('fk_master_soal_kecermatan')->all(); 

            $dtlsoal = DtlSoalKecermatan::whereIn('fk_master_soal_kecermatan',$arr)->get();

            $data = [

                'paketsoaldtl'=> $paketsoaldtl,

                'paketsoalmst'=>$paketsoalmst,

                'dtlsoal'=>$dtlsoal

            ];

            $pdf = PDF::loadView('pdf/SoalKecermatan', $data);

            $pdf->setPaper('A4','potrait');

            return $pdf->stream('Soal_Kecermatan.pdf'); 

        }

    }

}

