<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\KategoriSoalKecermatan;
use App\Models\PaketSoalKecermatanMst;
use App\Models\PaketSoalKecermatanDtl;
use App\Models\PaketSoalKtg;
use App\Models\PaketSoalMst;
use App\Models\PaketSoalDtl;
use App\Models\MasterSoalKecermatan;
use App\Models\DtlSoalKecermatan;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Crypt;

class PaketSoalKecermatanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $menu = 'master';
        $submenu ='paketsoalkecermatan';
        $data = PaketSoalKecermatanMst::where('fk_paket_soal_mst', 0)->orderBy('created_at','desc')->get();
        $data_param = [
            'menu','submenu','data'
        ];

        return view('master/paketsoalkecermatan')->with(compact($data_param));
    }

    public function store(Request $request)
    {
        $data['judul'] = $request->judul_add;
        $data['kkm'] = $request->kkm_add;
        $data['ket'] = $request->ket_add;
        $data['created_by'] = Auth::id();
        $data['created_at'] = Carbon::now()->toDateTimeString();
        $data['updated_by'] = Auth::id();
        $data['updated_at'] = Carbon::now()->toDateTimeString();
        $createdata = PaketSoalKecermatanMst::create($data);
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
        $data['kkm'] = $request->kkm[0];
        $data['ket'] = $request->ket[0];
        $data['updated_by'] = Auth::id();
        $data['updated_at'] = Carbon::now()->toDateTimeString();

        $updatedata = PaketSoalKecermatanMst::find($id)->update($data);

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
        $updateData = PaketSoalKecermatanMst::find($id)->update($data);
        $updateData = PaketSoalKecermatanDtl::where('fk_paket_soal_kecermatan_mst',$id)->update($data);
        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }

    public function indexdtl($idpaketsoal, $ktg='0')
    {
        $menu = 'master';
        $data = PaketSoalKecermatanMst::find($idpaketsoal); 
        if($ktg){
            $submenu    = 'paketsoalmst';
            $mastersoal = MasterSoalKecermatan::where('fk_kategori_soal_kecermatan', $ktg)->get();
        }else{
            $ktg        = 0;
            $submenu    = 'paketsoalkecermatan';
            $mastersoal = MasterSoalKecermatan::orderBy('fk_kategori_soal_kecermatan','asc')->get();
        }
        
        $dtlsoal = DtlSoalKecermatan::get();

        $data_param = [
            'menu','submenu','data','mastersoal','dtlsoal','ktg'
        ];
        return view('master/paketsoalkecermatandtl')->with(compact($data_param));
    }

    public function storedtl(Request $request ,$idmst, $ktg='0')
    {
        if($request->id_master_soal){

            if(!$ktg)$ktg = 0;

            PaketSoalKecermatanDtl::where('fk_paket_soal_kecermatan_mst',$idmst)->where('fk_kategori_soal_kecermatan',$ktg)->forceDelete();

            foreach ($request->id_master_soal as $key) {
                $data['fk_master_soal_kecermatan'] = $key;
                $cekktg = MasterSoalKecermatan::find($key);

                $data['fk_kategori_soal_kecermatan'] = $cekktg->fk_kategori_soal_kecermatan;

                $data['fk_paket_soal_kecermatan_mst'] = $idmst;
                $data['created_by'] = Auth::id();
                $data['created_at'] = Carbon::now()->toDateTimeString();
                $data['updated_by'] = Auth::id();
                $data['updated_at'] = Carbon::now()->toDateTimeString();
                PaketSoalKecermatanDtl::create($data);
            }

            $datamst = PaketSoalKecermatanMst::find($idmst);
            if($datamst->fk_paket_soal_mst){

                $updatedatamst['total_soal'] = 0;

                $kats = PaketSoalKtg::where('fk_paket_soal_kecermatan_mst',$idmst)->get();
                foreach($kats as $kat){                    
                    $updatedataktg['jumlah_soal'] = count(PaketSoalKecermatanDtl::where('fk_paket_soal_kecermatan_mst', $idmst)->where('fk_kategori_soal_kecermatan', $kat->fk_kategori_soal)->get());
                    $updatedatamst['total_soal'] += $updatedataktg['jumlah_soal'];
                    PaketSoalKtg::find($kat->id)->update($updatedataktg);    
                }

                PaketSoalKecermatanMst::find($idmst)->update($updatedatamst);

                $updatedatamst['total_soal']+= count(PaketSoalDtl::where('fk_paket_soal_mst', $datamst->fk_paket_soal_mst)->get());
                PaketSoalMst::find($datamst->fk_paket_soal_mst)->update($updatedatamst);
                
            }else{

                $updatedatamst['total_soal'] = count(PaketSoalKecermatanDtl::where('fk_paket_soal_kecermatan_mst', $idmst)->get());
                PaketSoalKecermatanMst::find($idmst)->update($updatedatamst);
                    
            }

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil disimpan'
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Soal belum dipilih'
            ]);
        }
    }
}
