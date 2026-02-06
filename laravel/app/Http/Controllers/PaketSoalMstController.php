<?php















namespace App\Http\Controllers;















use Illuminate\Http\Request;







use App\Models\User;







use App\Models\KategoriSoal;




use App\Models\KategoriSoalKecermatan;

use App\Models\PaketSoalKecermatanMst;

use App\Models\PaketSoalKecermatanDtl;


use App\Models\PaketSoalMst;







use App\Models\UMapelMst;







use App\Models\PaketHadiah;







use App\Models\PaketSoalDtl;







use App\Models\PaketSoalKtg;







use App\Models\MasterSoal;







use App\Models\Keranjang;







use Carbon\Carbon;







use Auth;







use DB;







use Illuminate\Support\Facades\Crypt;















class PaketSoalMstController extends Controller







{







    public function __construct()







    {







        $this->middleware('auth');
    }















    public function index()







    {







        $menu = 'master';







        $submenu = 'paketsoalmst';







        $data = PaketSoalMst::orderBy('created_at', 'desc')->get();







        $data_param = [







            'menu', 'submenu', 'data'







        ];















        return view('master/paketsoalmst')->with(compact($data_param));
    }















    public function store(Request $request)







    {







        $data['judul'] = $request->judul_add;







        // $data['pengumuman'] = $request->pengumuman_add;







        $data['bagi_jawaban'] = $request->bagi_jawaban_add;





        $data['jenis_pembahasan'] = $request->jenis_pembahasan_add;



        $data['pembahasan'] = $request->pembahasan_add;



        // $data['sertifikat'] = $request->sertifikat_add;















        if ($request->tryout_add == 1) {







            $data['mulai'] = datetimestore($request->mulai_add);







            $data['selesai'] = datetimestore($request->selesai_add);











            if ($data['mulai'] >= $data['selesai']) {







                return response()->json([







                    'status' => false,







                    'message' => 'Waktu salah, harap cek kembali!'







                ]);







                dd('Error');
            }







            $start  = new Carbon($data['mulai']);







            $end    = new Carbon($data['selesai']);







            $diff = $start->diffInMinutes($end);



            $data['jenis_waktu'] = 1;





            $data['waktu'] = $diff;
        } else {





            $data['jenis_waktu'] = $request->jenis_waktu_add;

            if ($request->jenis_waktu_add == 1) {

                $data['waktu'] = $request->waktu_add;
            } else {

                $data['waktu'] = 0;
            }
        }























        if ($files = $request->file("banner_add")) {







            $destinationPath = 'upload/mapel/banner/';







            $file = 'Banner_' . Carbon::now()->timestamp . "." . $files->getClientOriginalExtension();







            $files->move($destinationPath, $file);







            $namafile = $destinationPath . $file;







            $data['banner'] = $destinationPath . $file;
        }















        $data['jenis_penilaian'] = 1;











        $data['kkm'] = $request->kkm_add;







        $data['is_kkm'] = $request->is_kkm_add;


        $data['is_acak'] = $request->is_acak_add;




        $data['ket'] = $request->ket_add;







        $data['tryout'] = $request->tryout_add;







        $data['created_by'] = Auth::id();







        $data['created_at'] = Carbon::now()->toDateTimeString();







        $data['updated_by'] = Auth::id();







        $data['updated_at'] = Carbon::now()->toDateTimeString();







        $createdata = PaketSoalMst::create($data);







        if ($createdata) {







            return response()->json([







                'status' => true,







                'message' => 'Berhasil menambahkan data'







            ]);
        } else {







            return response()->json([







                'status' => false,







                'message' => 'Gagal. Mohon coba kembali!'







            ]);
        }
    }















    public function update(Request $request, $id)







    {







        $data['judul'] = $request->judul[0];







        // $data['pengumuman'] = $request->pengumuman[0];







        $data['bagi_jawaban'] = $request->bagi_jawaban[0];


        // dd($request);
        $data['jenis_pembahasan'] = isset($request->jenis_pembahasan[0]) ? $request->jenis_pembahasan[0] : null;



        $data['pembahasan'] = $request->pembahasan[0];







        // $data['sertifikat'] = $request->sertifikat[0];















        if ($request->tryout[0] == 1) {







            $data['mulai'] = datetimestore($request->mulai[0]);







            $data['selesai'] = datetimestore($request->selesai[0]);







            if ($data['mulai'] >= $data['selesai']) {







                return response()->json([







                    'status' => false,







                    'message' => 'Waktu salah, harap cek kembali!'







                ]);







                dd('Error');
            }







            $start  = new Carbon($data['mulai']);







            $end    = new Carbon($data['selesai']);







            $diff = $start->diffInMinutes($end);



            $data['jenis_waktu'] = 1;





            $data['waktu'] = $diff;
        } else {



            $data['jenis_waktu'] = $request->jenis_waktu[0];

            if ($request->jenis_waktu[0] == 1) {

                $data['waktu'] = $request->waktu[0];
            } else {

                $waktupaketsoalktg = PaketSoalKtg::where('fk_paket_soal_mst', $id)->sum('waktu');

                $data['waktu'] = $waktupaketsoalktg;
            }
        }















        if ($request->file("banner")) {







            if ($files = $request->file("banner")[0]) {







                $destinationPath = 'upload/mapel/banner/';







                $file = 'Banner_' . Carbon::now()->timestamp . "." . $files->getClientOriginalExtension();







                $files->move($destinationPath, $file);







                $namafile = $destinationPath . $file;







                $data['banner'] = $destinationPath . $file;
            }
        }







        $data['kkm'] = $request->kkm[0];







        $data['is_kkm'] = $request->is_kkm[0];
        $data['is_acak'] = $request->is_acak[0];







        $data['ket'] = $request->ket[0];







        $data['tryout'] = $request->tryout[0];







        $data['updated_by'] = Auth::id();







        $data['updated_at'] = Carbon::now()->toDateTimeString();















        $updatedata = PaketSoalMst::find($id)->update($data);















        if ($updatedata) {







            return response()->json([







                'status' => true,







                'message' => 'Data berhasil diubah'







            ]);
        } else {







            return response()->json([







                'status' => false,







                'message' => 'Gagal. Mohon coba kembali!'







            ]);
        }
    }















    public function destroy($id)







    {



        $getdata = PaketSoalMst::find($id);



        $data['deleted_by'] = Auth::id();







        $data['deleted_at'] = Carbon::now()->toDateTimeString();



        $updateData = PaketSoalMst::find($id)->update($data);



        $updateData = PaketSoalKtg::where('fk_paket_soal_mst', $id)->update($data);



        $updateData = PaketSoalDtl::where('fk_paket_soal_mst', $id)->update($data);



        if($getdata->fk_paket_soal_kecermatan_mst){

            $updateData = PaketSoalKecermatanMst::where('fk_paket_soal_mst', $id)->update($data);

            $updateData = PaketSoalKecermatanDtl::where('fk_paket_soal_kecermatan_mst', $getdata->fk_paket_soal_kecermatan_mst)->update($data);

        }


        return response()->json([







            'status' => true,







            'message' => 'Data berhasil dihapus'







        ]);
    }















    public function indexktg($idpaketmst)







    {







        $menu = 'master';







        $submenu = 'paketsoalmst';







        $datamst = PaketSoalMst::find($idpaketmst);







        $arr = PaketSoalKtg::where('fk_paket_soal_mst', $idpaketmst)->where('fk_paket_soal_kecermatan_mst', 0)->pluck('fk_kategori_soal')->all();
        $ktgsoal = KategoriSoal::whereNotIn('id', $arr)->get();

        $arr = PaketSoalKtg::where('fk_paket_soal_mst', $idpaketmst)->where('fk_paket_soal_kecermatan_mst', '<>' , 0)->pluck('fk_kategori_soal')->all();
        $cermatsoal = KategoriSoalKecermatan::whereNotIn('id', $arr)->get();

        $data = PaketSoalKtg::where('fk_paket_soal_mst', $idpaketmst)->get();

        $data_param = [


            'menu', 'submenu', 'data', 'ktgsoal', 'idpaketmst', 'datamst', 'cermatsoal'

        ];

        return view('master/paketsoalktg')->with(compact($data_param));
    }















    public function storektg(Request $request)

    {







        $data['fk_paket_soal_mst'] = $request->fk_paket_soal_mst;



        $katsoal  = substr($request->fk_kategori_soal_add,2);

        $kecermatan = substr($request->fk_kategori_soal_add, 0, 2) === 'pg' ? 0 : 1;

        $data['fk_kategori_soal'] = $katsoal;


        $datamst = PaketSoalMst::find($request->fk_paket_soal_mst);

        $idkecermatan = 0;

        if($kecermatan){

            $idkecermatan = $datamst->fk_paket_soal_kecermatan_mst;

            if(!$idkecermatan){
            
                $datakecermatan['fk_paket_soal_mst'] = $datamst->id;
                $datakecermatan['judul'] = $datamst->judul;
                $datakecermatan['kkm'] = $request->kkm_add;
                $datakecermatan['ket'] = '';
                $datakecermatan['created_by'] = Auth::id();
                $datakecermatan['created_at'] = Carbon::now()->toDateTimeString();
                $datakecermatan['updated_by'] = Auth::id();
                $datakecermatan['updated_at'] = Carbon::now()->toDateTimeString();
                $createdata = PaketSoalKecermatanMst::create($datakecermatan);
                
                $idkecermatan = $createdata->id;            

                PaketSoalMst::find($datamst->id)->update(['fk_paket_soal_kecermatan_mst' => $idkecermatan]);

            }
        }

        $data['fk_paket_soal_kecermatan_mst'] = $idkecermatan;

        $cekdata = PaketSoalKtg::where('fk_paket_soal_mst', $request->fk_paket_soal_mst)->where('fk_kategori_soal', $katsoal)->where('fk_paket_soal_kecermatan_mst', $idkecermatan)->first();

        if ($cekdata) {



            return response()->json([







                'status' => false,







                'message' => 'Kategori soal sudah ada pada paket ini, silahkan isi kategori lainnya!'







            ]);







            dd('Error');
        }



            


        $data['bobot'] = $request->bobot_add;


        $data['kkm'] = $request->kkm_add;



        $data['waktu'] = $request->waktu_add;



        $data['created_by'] = Auth::id();







        $data['created_at'] = Carbon::now()->toDateTimeString();







        $data['updated_by'] = Auth::id();







        $data['updated_at'] = Carbon::now()->toDateTimeString();















        $createdata = PaketSoalKtg::create($data);







        if ($createdata) {

            if ($datamst->jenis_waktu == 2) {

                $waktupaketsoalktg = PaketSoalKtg::where('fk_paket_soal_mst', $request->fk_paket_soal_mst)->sum('waktu');

                $updatedatamst['waktu'] = $waktupaketsoalktg;

                PaketSoalMst::find($request->fk_paket_soal_mst)->update($updatedatamst);
            }



            return response()->json([







                'status' => true,







                'message' => 'Berhasil menambahkan data'







            ]);
        } else {







            return response()->json([







                'status' => false,







                'message' => 'Gagal. Mohon coba kembali!'







            ]);
        }
    }







    public function updatektg(Request $request, $id)
    {


$data['bobot'] = $request->bobot[0] ?? null;

        $data['kkm'] = $request->kkm[0];


        $data['waktu'] = $request->waktu[0];



        $data['updated_by'] = Auth::id();







        $data['updated_at'] = Carbon::now()->toDateTimeString();















        $updatedata = PaketSoalKtg::find($id)->update($data);















        if ($updatedata) {

            $dataktg = PaketSoalKtg::find($id);

            $datamst = PaketSoalMst::find($dataktg->fk_paket_soal_mst);

            if ($datamst->jenis_waktu == 2) {

                $waktupaketsoalktg = PaketSoalKtg::where('fk_paket_soal_mst', $dataktg->fk_paket_soal_mst)->sum('waktu');

                $updatedatamst['waktu'] = $waktupaketsoalktg;

                PaketSoalMst::find($dataktg->fk_paket_soal_mst)->update($updatedatamst);
            }



            return response()->json([







                'status' => true,







                'message' => 'Data berhasil diubah'







            ]);
        } else {







            return response()->json([







                'status' => false,







                'message' => 'Gagal. Mohon coba kembali!'







            ]);
        }
    }







    public function destroyktg($id)







    {







        $getdata = PaketSoalKtg::find($id);

        $data['deleted_by'] = Auth::id();

        $data['deleted_at'] = Carbon::now()->toDateTimeString();

        $updateData = PaketSoalKtg::find($id)->update($data);

        $updateData = PaketSoalDtl::where('fk_paket_soal_ktg', $id)->update($data);

        $updatedatamst['total_soal'] = 0;

        if($getdata->fk_paket_soal_kecermatan_mst){

            PaketSoalKecermatanDtl::where('fk_paket_soal_kecermatan_mst', $getdata->fk_paket_soal_kecermatan_mst)->where('fk_kategori_soal_kecermatan', $getdata->fk_kategori_soal)->update($data);

            $kats = PaketSoalKtg::where('fk_paket_soal_kecermatan_mst',$getdata->fk_paket_soal_kecermatan_mst)->get();
            foreach($kats as $kat){                    
                $updatedatamst['total_soal'] += count(PaketSoalKecermatanDtl::where('fk_paket_soal_kecermatan_mst', $getdata->fk_paket_soal_kecermatan_mst)->where('fk_kategori_soal_kecermatan', $kat->fk_kategori_soal)->get());
            }

            PaketSoalKecermatanMst::find($getdata->fk_paket_soal_kecermatan_mst)->update($updatedatamst);
        }

        $datamst = PaketSoalMst::find($getdata->fk_paket_soal_mst);

        $updatedatamst['total_soal']+= count(PaketSoalDtl::where('fk_paket_soal_mst', $getdata->fk_paket_soal_mst)->get());

        if ($datamst->jenis_waktu == 2) {

            $waktupaketsoalktg = PaketSoalKtg::where('fk_paket_soal_mst', $getdata->fk_paket_soal_mst)->sum('waktu');

            $updatedatamst['waktu'] = $waktupaketsoalktg;

            PaketSoalMst::find($getdata->fk_paket_soal_mst)->update($updatedatamst);
        }


        PaketSoalMst::find($getdata->fk_paket_soal_mst)->update($updatedatamst);


        return response()->json([







            'status' => true,







            'message' => 'Data berhasil dihapus'







        ]);
    }















    public function indexdtl($idpaketsoalktg)







    {







        $menu = 'master';







        $submenu = 'paketsoalmst';







        $data = PaketSoalKtg::find($idpaketsoalktg);







        $mastersoal = MasterSoal::where('fk_kategori_soal', $data->fk_kategori_soal)->get();







        $data_param = [







            'menu', 'submenu', 'data', 'mastersoal', 'idpaketsoalktg'







        ];







        return view('master/paketsoaldtl')->with(compact($data_param));
    }















    public function storedtl(Request $request, $idmst, $idktg)







    {















        if ($request->id_master_soal) {







            PaketSoalDtl::where('fk_paket_soal_mst', $idmst)->where('fk_paket_soal_ktg', $idktg)->forceDelete();







            foreach ($request->id_master_soal as $key) {







                $data['fk_master_soal'] = $key;







                $data['fk_paket_soal_mst'] = $idmst;







                $data['fk_paket_soal_ktg'] = $idktg;







                $data['created_by'] = Auth::id();







                $data['created_at'] = Carbon::now()->toDateTimeString();







                $data['updated_by'] = Auth::id();







                $data['updated_at'] = Carbon::now()->toDateTimeString();







                PaketSoalDtl::create($data);
            }


            $updatedataktg['jumlah_soal'] = count(PaketSoalDtl::where('fk_paket_soal_ktg', $idktg)->get());

            PaketSoalKtg::find($idktg)->update($updatedataktg);

            $updatedatamst['total_soal'] = count(PaketSoalDtl::where('fk_paket_soal_mst', $idmst)->get());

            $datamst = PaketSoalMst::find($idmst);

            if($datamst->fk_paket_soal_kecermatan_mst){

                $kats = PaketSoalKtg::where('fk_paket_soal_kecermatan_mst',$datamst->fk_paket_soal_kecermatan_mst)->get();
                foreach($kats as $kat){                    
                    $updatedatamst['total_soal'] += count(PaketSoalKecermatanDtl::where('fk_paket_soal_kecermatan_mst', $datamst->fk_paket_soal_kecermatan_mst)->where('fk_kategori_soal_kecermatan', $kat->fk_kategori_soal)->get());
                }

            }

            PaketSoalMst::find($idmst)->update($updatedatamst);



            return response()->json([







                'status' => true,







                'message' => 'Data berhasil disimpan'







            ]);
        } else {







            return response()->json([







                'status' => false,







                'message' => 'Soal belum dipilih'







            ]);
        }
    }















    public function rankingpeserta($id)



    {







        $id = Crypt::decrypt($id);















        $menu = "master";







        $submenu = "paketsoalmst";







        $datapaket = PaketSoalMst::find($id);















        $udatapaket = UMapelMst::where('fk_mapel_mst', $id)->where('is_mengerjakan', 0)->orderBy('set_nilai', 'desc')->get();















        // $udatapaket = UMapelMst::where('fk_paket_soal_mst',$id)->get();


        if (Auth::user()->user_level == 1) {







            $extend = "layouts.SkydashAdmin";
        } else {







            $extend = "layouts.Skydash";
        }






        $data_param = [







            'submenu', 'menu', 'datapaket', 'udatapaket', 'extend'







        ];







        return view('master/rankingpeserta')->with(compact($data_param));
    }















    public function updateranking(Request $request)







    {







        $id = $request->id_data[0];







        $data['set_nilai'] = $request->set_nilai[0];







        $data['set_predikat'] = $request->set_predikat[0];







        $data['status'] = $request->status[0];







        $data['updated_by'] = Auth::id();







        $data['updated_at'] = Carbon::now()->toDateTimeString();







        $updatedata = UMapelMst::find($id)->update($data);















        if ($updatedata) {







            return response()->json([







                'status' => true,







                'message' => 'Data berhasil diubah'







            ]);
        } else {







            return response()->json([







                'status' => false,







                'message' => 'Gagal. Mohon coba kembali!'







            ]);
        }
    }















    public function pakethadiah($id)



    {







        $idmapel = Crypt::decrypt($id);







        $menu = "master";







        $submenu = "paketsoalmst";







        $data = PaketHadiah::where('fk_mapel_mst', $idmapel)->get();







        $data_param = [







            'submenu', 'menu', 'data', 'idmapel'







        ];















        return view('master/hadiah')->with(compact($data_param));
    }















    public function storehadiah(Request $request)







    {







        $data['fk_mapel_mst'] = Crypt::decrypt($request->fk_mapel_mst);







        $data['judul'] = $request->judul_add;







        $data['harga'] = $request->harga_add;







        $data['berat'] = $request->berat_add;







        $data['ket'] = $request->ket_add;







        if ($files = $request->file("gambar_add")) {







            $destinationPath = 'upload/pakethadiah/gambar/';







            $file = 'gambar_' . Carbon::now()->timestamp . "." . $files->getClientOriginalExtension();







            $files->move($destinationPath, $file);







            $namafile = $destinationPath . $file;







            $data['foto'] = $destinationPath . $file;
        }







        $data['created_by'] = Auth::id();







        $data['created_at'] = Carbon::now()->toDateTimeString();







        $data['updated_by'] = Auth::id();







        $data['updated_at'] = Carbon::now()->toDateTimeString();







        $createdata = PaketHadiah::create($data);







        if ($createdata) {







            return response()->json([







                'status' => true,







                'message' => 'Berhasil menambahkan data'







            ]);
        } else {







            return response()->json([







                'status' => false,







                'message' => 'Gagal. Mohon coba kembali!'







            ]);
        }
    }















    public function updatehadiah(Request $request)







    {







        $id = Crypt::decrypt($request->iddata[0]);







        $data['judul'] = $request->judul[0];







        $data['harga'] = $request->harga[0];







        $data['berat'] = $request->berat[0];







        $data['ket'] = $request->ket[0];







        if ($request->file("gambar")) {







            if ($files = $request->file("gambar")[0]) {







                $destinationPath = 'upload/pakethadiah/gambar/';







                $file = 'gambar_' . Carbon::now()->timestamp . "." . $files->getClientOriginalExtension();







                $files->move($destinationPath, $file);







                $namafile = $destinationPath . $file;







                $data['foto'] = $destinationPath . $file;
            }
        }







        $data['updated_by'] = Auth::id();







        $data['updated_at'] = Carbon::now()->toDateTimeString();















        $updatedata = PaketHadiah::find($id)->update($data);















        if ($updatedata) {







            return response()->json([







                'status' => true,







                'message' => 'Data berhasil diubah'







            ]);
        } else {







            return response()->json([







                'status' => false,







                'message' => 'Gagal. Mohon coba kembali!'







            ]);
        }
    }















    public function destroyhadiah(Request $request)







    {







        $id = Crypt::decrypt($request->iddata[0]);















        $cekdata = Keranjang::where('fk_paket_hadiah_id', $id)->first();







        if ($cekdata) {







            return response()->json([







                'status' => false,







                'message' => 'Data tidak dapat dihapus'







            ]);







            dd('Error');
        }







        $data['deleted_by'] = Auth::id();







        $data['deleted_at'] = Carbon::now()->toDateTimeString();







        $updateData = PaketHadiah::find($id)->update($data);







        return response()->json([







            'status' => true,







            'message' => 'Data berhasil dihapus'







        ]);
    }
}