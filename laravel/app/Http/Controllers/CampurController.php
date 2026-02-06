<?php

namespace App\Http\Controllers;

use App\Mail\RegisterEmail;
use App\Mail\ResetPassword;
use App\Models\DtlSoalKecermatan;
use App\Models\Informasi;
use App\Models\KategoriMateri;
use App\Models\KategoriSoal;
use App\Models\KategoriSoalKecermatan;
use App\Models\MasterKabupaten;
use App\Models\MasterKecamatan;
use App\Models\MasterSoal;
use App\Models\MasterSoalKecermatan;
use App\Models\PaketDtl;
use App\Models\PaketMateri;
use App\Models\PaketMst;
use App\Models\PaketSoalDtl;
use App\Models\PaketSoalKecermatanDtl;
use App\Models\PaketSoalKecermatanMst;
use App\Models\PaketSoalKtg;
use App\Models\PaketSoalMst;
use App\Models\PaketSubkategori;
use App\Models\Template;
use App\Models\UMapelMst;
use App\Models\UPaketSoalDtl;
use App\Models\UPaketSoalKecermatanMst;
use App\Models\UPaketSoalKecermatanSoalDtl;
use App\Models\UPaketSoalKecermatanSoalMst;
use App\Models\UPaketSoalKtg;
use App\Models\User;
use App\Models\UserAlamat;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Kavist\RajaOngkir\Facades\RajaOngkir;
use Redirect;

class CampurController extends Controller
{
    public function index()
    {
        $menu    = "paketsayaktg";
        $submenu = "";

        $subkategori = PaketMst::orderBy('created_at', 'desc')->get();

        $data_param = [
            'submenu',
            'menu',
            'subkategori',
        ];

        return view('public/index')->with(compact($data_param));
    }
    public function paketsayadtl(Request $request, $idpaketdtl)
    {
        $tab = $request->tab;

        $id   = Crypt::decrypt($idpaketdtl);
        $data = PaketMst::find($id);

        $menu    = "paketsayaktg";
        $submenu = "";

        $paketdtl           = PaketDtl::where('jenis', 1)->where('fk_paket_mst', $id)->get();
        $paketdtlkecermatan = PaketDtl::where('jenis', 2)->where('fk_paket_mst', $id)->get();
        $paketvideo         = PaketMateri::where('fk_paket_mst', $id)->where('jenis', 1)->get();
        $paketpdf           = PaketMateri::where('fk_paket_mst', $id)->where('jenis', 2)->get();

        $kategoris = KategoriMateri::kategori_tree();

        foreach ($paketdtlkecermatan as $p) {
            $paketdtl->push($p);
        }

        $detail_kats = KategoriMateri::materi_kategoris($paketdtl, $kategoris, 'Detail');
        $cermat_kats = [];
        //$cermat_kats = KategoriMateri::materi_kategoris($paketdtlkecermatan, $kategoris, 'Detail');


        $materi_kats = KategoriMateri::materi_array($paketvideo, $paketpdf);
        $materi_kats = KategoriMateri::materi_kategoris($materi_kats, $kategoris, 'Materi');

        $data_param = [
            'submenu',
            'menu',
            'data',
            'paketdtl',
            'idpaketdtl',
            'kategoris',
            'detail_kats',
            'paketvideo',
            'paketpdf',
            'paketdtlkecermatan',
            'kategoris',
            'detail_kats',
            'cermat_kats',
            'materi_kats',
            'tab',
        ];

        return view('public/listpaket')->with(compact($data_param));
    }
    public function mulaiujianpublic(Request $request, $id)
    {
        $idpaketdtl     = $request->idpaketdtl;
        $idpaketsoalmst = Crypt::decrypt($request->id_paket_soal_mst[0]);

        $paketsoalmst = PaketSoalMst::find($idpaketsoalmst);
        $paketdtl     = PaketDtl::find($id);

        session(['idpaketmst' => Crypt::encrypt($paketdtl->fk_paket_mst)]);

        if ($paketsoalmst) {

            $tryout = $paketsoalmst->tryout;

            $kecermatan_ktg  = [];
            $ukecermatan_ktg = [];

            $data1 = [];

            if ($tryout) {
                $data1['fk_paket_mst'] = 0;
                $data1['fk_paket_dtl'] = 0;
            } else {
                $data1['fk_paket_mst'] = $paketdtl->fk_paket_mst;
                $data1['fk_paket_dtl'] = $paketdtl->id;
            }

            $data1['fk_mapel_mst']     = $paketsoalmst->id;
            $data1['tryout']           = $tryout;
            $data1['judul']            = $paketsoalmst->judul;
            $data1['nilai']            = 0;
            $data1['set_nilai']        = 0;
            $data1['kkm']              = $paketsoalmst->kkm;
            $data1['jenis_waktu']      = $paketsoalmst->jenis_waktu;
            $data1['is_kkm']           = $paketsoalmst->is_kkm;
            $data1['is_acak']          = $paketsoalmst->is_acak;
            $data1['bagi_jawaban']     = $paketsoalmst->bagi_jawaban;
            $data1['jenis_pembahasan'] = $paketsoalmst->jenis_pembahasan;
            $data1['pembahasan']       = $paketsoalmst->pembahasan;
            $data1['sertifikat']       = $paketsoalmst->sertifikat;
            $data1['jenis_penilaian']  = $paketsoalmst->jenis_penilaian;
            $data1['waktu']            = $paketsoalmst->waktu;
            $data1['mulai']            = Carbon::now()->toDateTimeString();
            if ($tryout) {
                $data1['selesai'] = $paketsoalmst->selesai;
            } else {
                $data1['selesai'] = Carbon::now()->addMinutes($paketsoalmst->waktu)->toDateTimeString();
            }
            $data1['is_mengerjakan'] = 1;
            $data1['status']         = 0;
            $data1['total_soal']     = $paketsoalmst->total_soal;
            $data1['ket']            = $paketsoalmst->ket;
            $data1['created_at']     = Carbon::now()->toDateTimeString();
            $data1['updated_at']     = Carbon::now()->toDateTimeString();
            $upaketsoalmst           = UMapelMst::create($data1);

            $idupaketsoalmst = $upaketsoalmst->id;

            if ($paketsoalmst->is_acak == 1) {
                $paketsoalktg = PaketSoalKtg::where('fk_paket_soal_mst', $idpaketsoalmst)->inRandomOrder()->get();
            } else {
                $paketsoalktg = PaketSoalKtg::where('fk_paket_soal_mst', $idpaketsoalmst)->get();
            }
            $nomor       = 1;
            $hitungwaktu = 0;

            foreach ($paketsoalktg as $key) {
                $data2 = [];

                // $data2['bobot'] = $key->bobot;
                $data2['fk_u_paket_soal_mst'] = $upaketsoalmst->id;
                $data2['nilai']               = 0;
                if (! $key->fk_paket_soal_kecermatan_mst) {
                    $ktgsoal = KategoriSoal::find($key->fk_kategori_soal);
                } else {
                    $ktgsoal = KategoriSoalKecermatan::find($key->fk_kategori_soal);
                }
                $data2['judul']       = $ktgsoal->judul ?? 'Judul tidak tersedia, silahkan edit di admin';
                $data2['ket']         = $ktgsoal ? $ktgsoal->ket : 'Keterangan tidak tersedia, silahkan edit di admin';
                $data2['kkm']         = $key ? $key->kkm : 0;
                $data2['jumlah_soal'] = $key ? $key->jumlah_soal : 0;

                if ($nomor == 1) {
                    $data2['is_mengerjakan'] = 1;
                } else {
                    $data2['is_mengerjakan'] = 0;
                }

                if ($paketsoalmst->jenis_waktu != 2) {

                    $data2['waktu'] = $paketsoalmst->waktu;

                    $data2['mulai'] = Carbon::now()->addMinutes(0)->toDateTimeString();

                    $data2['selesai'] = Carbon::now()->addMinutes($paketsoalmst->waktu)->toDateTimeString();
                } elseif ($paketsoalmst->jenis_waktu == 2) {

                    $data2['waktu'] = $key->waktu;

                    // $data2['mulai'] = Carbon::now()->addSeconds($hitungselesaicountdown)->addMinutes($hitungwaktu)->toDateTimeString();

                    $data2['mulai'] = Carbon::now()->addMinutes($hitungwaktu)->toDateTimeString();

                    $hitungwaktu = $hitungwaktu + $key->waktu;

                    $data2['selesai'] = Carbon::now()->addMinutes($hitungwaktu)->toDateTimeString();
                }

                $data2['created_at'] = Carbon::now()->toDateTimeString();
                $data2['updated_at'] = Carbon::now()->toDateTimeString();
                $upaketsoalktg       = UPaketSoalKtg::create($data2);

                if ($key->fk_paket_soal_kecermatan_mst) {

                    $ukecermatan_ktg[$ktgsoal->id] = $upaketsoalktg->id;
                    $kecermatan_ktg[]              = $upaketsoalktg->id;
                } else {

                    if ($paketsoalmst->is_acak == 1) {
                        $paketsoaldtl = PaketSoalDtl::where('fk_paket_soal_mst', $idpaketsoalmst)->where('fk_paket_soal_ktg', $key->id)->inRandomOrder()->get();
                    } else {
                        $paketsoaldtl = PaketSoalDtl::where('fk_paket_soal_mst', $idpaketsoalmst)->where('fk_paket_soal_ktg', $key->id)->get();
                    }

                    foreach ($paketsoaldtl as $key2) {
                        $data3 = [];

                        $data3['fk_user_id']          = Auth::id();
                        $data3['fk_u_paket_soal_ktg'] = $upaketsoalktg->id;
                        $data3['fk_u_paket_soal_mst'] = $upaketsoalmst->id;
                        $mastersoal                   = MasterSoal::find($key2->fk_master_soal);
                        $data3['no_soal']             = $nomor;
                        $data3['soal']                = $mastersoal->soal;
                        $data3['a']                   = $mastersoal->a;
                        $data3['b']                   = $mastersoal->b;
                        $data3['c']                   = $mastersoal->c;
                        $data3['d']                   = $mastersoal->d;
                        $data3['e']                   = $mastersoal->e;
                        $data3['f']                   = $mastersoal->f;
                        $data3['g']                   = $mastersoal->g;
                        $data3['h']                   = $mastersoal->h;
                        $data3['point_a']             = $mastersoal->point_a;
                        $data3['point_b']             = $mastersoal->point_b;
                        $data3['point_c']             = $mastersoal->point_c;
                        $data3['point_d']             = $mastersoal->point_d;
                        $data3['point_e']             = $mastersoal->point_e;
                        $data3['point_f']             = $mastersoal->point_f;
                        $data3['point_g']             = $mastersoal->point_g;
                        $data3['point_h']             = $mastersoal->point_h;
                        $maxpoint                     = max($mastersoal->point_a, $mastersoal->point_b, $mastersoal->point_c, $mastersoal->point_d, $mastersoal->point_e, $mastersoal->point_f, $mastersoal->point_g, $mastersoal->point_h);
                        $data3['max_point']           = $maxpoint;
                        $data3['jawaban']             = $mastersoal->jawaban;
                        $data3['pembahasan']          = $mastersoal->pembahasan;
                        $data3['created_at']          = Carbon::now()->toDateTimeString();
                        $data3['updated_at']          = Carbon::now()->toDateTimeString();
                        $upaketsoaldtl                = UPaketSoalDtl::create($data3);
                        $nomor++;
                    }
                }
            }

            if ($paketsoalmst->fk_paket_soal_kecermatan_mst) {

                $data1 = [];
                $data2 = [];
                $data3 = [];

                $idupaketsoalmst = $upaketsoalmst->id;

                $idpaketsoalmst = $paketsoalmst->fk_paket_soal_kecermatan_mst;

                $paketsoalmst = PaketSoalKecermatanMst::find($idpaketsoalmst);

                $paketsoaldtl = PaketSoalKecermatanDtl::where('fk_paket_soal_kecermatan_mst', $idpaketsoalmst)->inRandomOrder()->get();

                if ($paketsoalmst) {

                    $data1['fk_u_mapel_mst'] = $idupaketsoalmst;

                    if ($tryout) {
                        $data1['fk_paket_mst'] = 0;

                        $data1['fk_paket_dtl'] = 0;
                    } else {
                        $data1['fk_paket_mst'] = $paketdtl->fk_paket_mst;

                        $data1['fk_paket_dtl'] = $paketdtl->id;
                    }

                    $data1['fk_paket_soal_kecermatan_mst'] = $paketsoalmst->id;

                    $data1['judul'] = $paketsoalmst->judul;

                    $data1['kkm'] = $paketsoalmst->kkm;

                    $data1['nilai'] = 0;

                    $data1['mulai'] = Carbon::now()->toDateTimeString();

                    $data1['is_mengerjakan'] = 1;

                    $data1['total_soal'] = $paketsoalmst->total_soal;

                    $data1['ket'] = $paketsoalmst->ket;

                    $data1['created_by'] = Auth::id();

                    $data1['created_at'] = Carbon::now()->toDateTimeString();

                    $data1['updated_by'] = Auth::id();

                    $data1['updated_at'] = Carbon::now()->toDateTimeString();

                    $upaketsoalmst = UPaketSoalKecermatanMst::create($data1);

                    if ($kecermatan_ktg) {
                        UPaketSoalKtg::whereIn('id', $kecermatan_ktg)->update(['fk_u_paket_soal_kecermatan_mst' => $upaketsoalmst->id]);
                    }

                    UMapelMst::find($idupaketsoalmst)->update(['fk_u_paket_soal_kecermatan_mst' => $upaketsoalmst->id]);

                    foreach ($paketsoaldtl as $key) {

                        $mastersoal = MasterSoalKecermatan::find($key->fk_master_soal_kecermatan);

                        $dtlsoal = DtlSoalKecermatan::where('fk_master_soal_kecermatan', $key->fk_master_soal_kecermatan)->inRandomOrder()->get();

                        $ktgsoal = KategoriSoalKecermatan::find($mastersoal->fk_kategori_soal_kecermatan);

                        $data2['fk_u_paket_soal_kecermatan_mst'] = $upaketsoalmst->id;

                        $data2['fk_kategori_soal_kecermatan'] = $key->fk_kategori_soal_kecermatan;

                        $data2['judul_kategori'] = $ktgsoal->judul;

                        $data2['karakter'] = $mastersoal->karakter;

                        $data2['kiasan'] = $mastersoal->kiasan;

                        $data2['waktu'] = $mastersoal->waktu;

                        $data2['waktu_total'] = $mastersoal->waktu_total;

                        $data2['created_by'] = Auth::id();

                        $data2['created_at'] = Carbon::now()->toDateTimeString();

                        $data2['updated_by'] = Auth::id();

                        $data2['updated_at'] = Carbon::now()->toDateTimeString();

                        $usoalmst = UPaketSoalKecermatanSoalMst::create($data2);

                        if ($mastersoal->waktu_total) {
                            $detik_mulai = $mastersoal->waktu_total * 60;
                        } else {
                            $detik_mulai = $mastersoal->waktu;
                        }

                        foreach ($dtlsoal as $key2) {

                            $data3['fk_u_paket_soal_kecermatan_mst'] = $upaketsoalmst->id;

                            $data3['fk_u_paket_soal_kecermatan_soal_mst'] = $usoalmst->id;

                            $data3['fk_u_paket_soal_ktg'] = isset($ukecermatan_ktg[$ktgsoal->id]) ? $ukecermatan_ktg[$ktgsoal->id] : 0;

                            $data3['soal'] = $key2->soal;

                            $data3['jawaban'] = $key2->jawaban;

                            $data3['waktu'] = $key2->waktu;

                            $data3['waktu_total'] = $key2->waktu_total;

                            if ($mastersoal->waktu_total) {

                                $data3['detik_mulai'] = $detik_mulai;

                                $data3['detik_akhir'] = $mastersoal->waktu_total * 60;
                            } else {

                                $data3['detik_mulai'] = $detik_mulai;

                                $detik_mulai = $detik_mulai - $key2->waktu;

                                $data3['detik_akhir'] = $detik_mulai + 1;
                            }

                            $data3['created_at'] = Carbon::now()->toDateTimeString();

                            $data3['updated_at'] = Carbon::now()->toDateTimeString();

                            $usoaldtl = UPaketSoalKecermatanSoalDtl::create($data3);
                        }
                    }
                }
            }

            return response()->json([
                'status'     => true,
                'idpaketdtl' => $idpaketdtl,
                'id'         => Crypt::encrypt($idupaketsoalmst),
                'message'    => 'Halaman akan diarahkan otomatis',
            ]);
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan',
            ]);
        }
    }
    public function ujian($id)
    {
        $idupaketsoalmst = Crypt::decrypt($id);

        $upaketsoalmst = UMapelMst::find($idupaketsoalmst);

        $gratis_ujian = PaketMst::find($upaketsoalmst->fk_paket_mst)->jumlah_gratis_ujian;

        $paketmst = PaketMst::find($upaketsoalmst->fk_paket_mst);

        $idpaket = Crypt::encrypt($paketmst->id);

        if ($upaketsoalmst->tryout == 1) {

            $menu = "tryout";
        } else {

            $menu = "paketsayaktg";
        }

        $submenu = "";

        $now = Carbon::now()->toDateTimeString();

        if ($upaketsoalmst->is_mengerjakan == 0) {

            return Redirect::to(url('hasilujian'));
        } else {

            // dd($upaketsoalmst->jenis_waktu);

            $dataloop = $upaketsoalmst->u_paket_soal_ktg_aktif_r; //always one item
            if (! $dataloop) {
                return Redirect::to(url('hasilujian'));
            }

            if ($dataloop[0]->fk_u_paket_soal_kecermatan_mst) {

                $idupaketsoalmst = $dataloop[0]->fk_u_paket_soal_kecermatan_mst;

                $umapelmst = $upaketsoalmst;

                $upaketsoalmst = UPaketSoalKecermatanMst::find($idupaketsoalmst);

                $soalmst = UPaketSoalKecermatanSoalMst::where('fk_u_paket_soal_kecermatan_mst', $idupaketsoalmst)->where('is_mengerjakan', 1)->first();

                if (! $soalmst) {
                    $soalmst = UPaketSoalKecermatanSoalMst::where('fk_u_paket_soal_kecermatan_mst', $idupaketsoalmst)->where('is_mengerjakan', 0)->first();
                    if ($soalmst) {
                        $dataupdate['mulai'] = Carbon::now()->toDateTimeString();
                        if ($soalmst->waktu_total) {
                            $dataupdate['selesai'] = Carbon::createFromFormat('Y-m-d H:i:s', $dataupdate['mulai'])->addSeconds($soalmst->waktu_total * 60)->toDateTimeString();
                            //$dataupdate['selesai'] = Carbon::now()->addSeconds($soalmst->waktu_total * 60)->toDateTimeString();
                        } else {
                            $dataupdate['selesai'] = Carbon::now()->addSeconds($soalmst->waktu)->toDateTimeString();
                        }
                        $dataupdate['is_mengerjakan'] = 1;
                        UPaketSoalKecermatanSoalMst::find($soalmst->id)->update($dataupdate);
                        $soalmst = UPaketSoalKecermatanSoalMst::find($soalmst->id);
                    } else {

                        $this->selesaiujian($request, $idupaketsoalmst);

                        return Redirect::to(url('detailhasil/' . Crypt::encrypt($idupaketsoalmst)));

                        return Redirect::to(url('hasilujian'));

                        $data_param = [
                            'submenu',
                            'menu',
                            'paket',
                            'paketkecermatan',
                        ];
                        return view('user/kerjakansoal')->with(compact($data_param));
                        dd('Error');
                    }
                }

                $soals = $soalmst->u_paket_soal_kecermatan_soal_dtl_a();

                $data_param = [
                    'submenu',
                    'menu',
                    'upaketsoalmst',
                    'soalmst',
                    'now',
                    'umapelmst',
                    'dataloop',
                    'soals',
                    'gratis_ujian',
                ];

                return view('user/ujianpersesi_kecermatan')->with(compact($data_param));
            } else {

                $data_param = [

                    'submenu',
                    'menu',
                    'upaketsoalmst',
                    'now',
                    'dataloop',
                    'gratis_ujian',
                    'idpaket',
                    'paketmst'
                ];
                if ($upaketsoalmst->jenis_waktu != 2) {

                    return view('public/ujianumum')->with(compact($data_param));
                } else {

                    return view('public/ujianumumpersesi')->with(compact($data_param));
                }
            }
        }
    }
    public function belajar($id)
    {
        $idupaketsoalmst = Crypt::decrypt($id);

        $upaketsoalmst = UMapelMst::find($idupaketsoalmst);

        $gratis_belajar = PaketMst::find($upaketsoalmst->fk_paket_mst)->jumlah_gratis_belajar;

        $paketmst = PaketMst::find($upaketsoalmst->fk_paket_mst);

        $idpaket = Crypt::encrypt($paketmst->id);

        if ($upaketsoalmst->tryout == 1) {

            $menu = "tryout";
        } else {

            $menu = "paketsayaktg";
        }

        $submenu = "";

        $now = Carbon::now()->toDateTimeString();

        if ($upaketsoalmst->is_mengerjakan == 0) {

            return Redirect::to(url('hasilujian'));
        } else {

            // dd($upaketsoalmst->jenis_waktu);

            $dataloop = $upaketsoalmst->u_paket_soal_ktg_aktif_r; //always one item
            if (! $dataloop) {
                return Redirect::to(url('hasilujian'));
            }

            if ($dataloop[0]->fk_u_paket_soal_kecermatan_mst) {

                $idupaketsoalmst = $dataloop[0]->fk_u_paket_soal_kecermatan_mst;

                $umapelmst = $upaketsoalmst;

                $upaketsoalmst = UPaketSoalKecermatanMst::find($idupaketsoalmst);

                $soalmst = UPaketSoalKecermatanSoalMst::where('fk_u_paket_soal_kecermatan_mst', $idupaketsoalmst)->where('is_mengerjakan', 1)->first();

                if (! $soalmst) {
                    $soalmst = UPaketSoalKecermatanSoalMst::where('fk_u_paket_soal_kecermatan_mst', $idupaketsoalmst)->where('is_mengerjakan', 0)->first();
                    if ($soalmst) {
                        $dataupdate['mulai'] = Carbon::now()->toDateTimeString();
                        if ($soalmst->waktu_total) {
                            $dataupdate['selesai'] = Carbon::createFromFormat('Y-m-d H:i:s', $dataupdate['mulai'])->addSeconds($soalmst->waktu_total * 60)->toDateTimeString();
                            //$dataupdate['selesai'] = Carbon::now()->addSeconds($soalmst->waktu_total * 60)->toDateTimeString();
                        } else {
                            $dataupdate['selesai'] = Carbon::now()->addSeconds($soalmst->waktu)->toDateTimeString();
                        }
                        $dataupdate['is_mengerjakan'] = 1;
                        UPaketSoalKecermatanSoalMst::find($soalmst->id)->update($dataupdate);
                        $soalmst = UPaketSoalKecermatanSoalMst::find($soalmst->id);
                    } else {

                        $this->selesaiujian($request, $idupaketsoalmst);

                        return Redirect::to(url('detailhasil/' . Crypt::encrypt($idupaketsoalmst)));

                        return Redirect::to(url('hasilujian'));

                        $data_param = [
                            'submenu',
                            'menu',
                            'paket',
                            'paketkecermatan',
                        ];
                        return view('user/kerjakansoal')->with(compact($data_param));
                        dd('Error');
                    }
                }

                $soals = $soalmst->u_paket_soal_kecermatan_soal_dtl_a();

                $data_param = [
                    'submenu',
                    'menu',
                    'upaketsoalmst',
                    'soalmst',
                    'now',
                    'umapelmst',
                    'dataloop',
                    'soals',
                    'gratis_belajar',
                ];

                return view('user/ujianpersesi_kecermatan')->with(compact($data_param));
            } else {

                $data_param = [

                    'submenu',
                    'menu',
                    'upaketsoalmst',
                    'now',
                    'dataloop',
                    'gratis_belajar',
                    'idpaket',
                    'paketmst'
                ];

                if ($upaketsoalmst->jenis_waktu != 2) {

                    return view('public/belajarumum')->with(compact($data_param));
                } else {

                    return view('public/belajarumumpersesi')->with(compact($data_param));
                }
            }
        }
    }
    public function updatejawaban(Request $request)
    {
        $upaketsoaldtl = UPaketSoalDtl::find($request->idpaketdl);

        // Contoh: Ambil UMapelMst utk cek status
        $cekismengerjakan = UMapelMst::find($upaketsoaldtl->fk_u_paket_soal_mst);

        if ($cekismengerjakan->is_mengerjakan == 0) {
            return response()->json([
                'status'  => false,
                'message' => 'Tidak dapat menyimpan jawaban karena ujian telah selesai',
            ]);
            // dd('Error');
        }

        // Jenis penilaian 1 => point_a, point_b, dsb
        // Jenis penilaian 2 => langsung bandingkan jawaban user
        if ($cekismengerjakan->jenis_penilaian == 1) {
            $data['jawaban_user'] = $request->jawaban;
            $getpoint             = UPaketSoalDtl::find($request->idpaketdl);
            $datapoint            = "point_" . $request->jawaban; // misal point_a, point_b, ...
            $data['benar_salah']  = $getpoint->$datapoint;
            $updateJawaban        = UPaketSoalDtl::find($request->idpaketdl)->update($data);
        } elseif ($cekismengerjakan->jenis_penilaian == 2) {
            $data['jawaban_user'] = $request->jawaban;
            $tingkat              = (int) $upaketsoaldtl->tingkat;

            if ($upaketsoaldtl->jawaban == $request->jawaban) {
                $data['benar_salah'] = $tingkat;
            } else {
                $data['benar_salah'] = 0;
            }
            $updateJawaban = UPaketSoalDtl::find($request->idpaketdl)->update($data);
        }

        if ($updateJawaban) {
            // Setelah berhasil update, siapkan data untuk ditampilkan di front-end
            $isCorrect        = false;
            $correctOption    = $upaketsoaldtl->jawaban; // misal 'a', 'b', 'c', ...
            $htmlJawabanBenar = $upaketsoaldtl->$correctOption ?? '';
            $pembahasan       = $upaketsoaldtl->pembahasan ?? '';
            // Apakah jawaban user benar?
            if ($upaketsoaldtl->jawaban == $request->jawaban) {
                $isCorrect = true;
            }

            return response()->json([
                'status'  => true,
                'message' => 'Berhasil simpan jawaban',
                'data'    => [
                    'isCorrect'        => $isCorrect,
                    'jawabanUser'      => $request->jawaban,       // misal 'a'/'b'
                    'jawabanBenar'     => $upaketsoaldtl->jawaban, // misal 'c'
                    'htmlJawabanBenar' => $htmlJawabanBenar,       // isi kolom text jawaban benar
                    'pembahasan'       => $pembahasan,             // isi kolom pembahasan
                ],
            ]);
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Gagal simpan, harap coba lagi',
            ]);
        }
    }

    public function selesaiujianpublic(Request $request, $id = null)
    {
        $ret = ! $id;

        if ($ret) {
            $id = $request->idpaketmst;
        }

        if (is_string($id) && ! ctype_digit($id)) {
            $id = Crypt::decrypt($id);
        }

        $dataupaketsoalmst = UMapelMst::find($id);

        if ($dataupaketsoalmst->tryout == 1) {

            $menu = "tryout";
        } else {

            $menu = "detailhasilpublic/" . $request->idpaketmst;
        }

        if ($dataupaketsoalmst->jenis_penilaian == 1) {

            $upaketsoalktg = UPaketSoalKtg::where('fk_u_paket_soal_mst', $id)->get();

            foreach ($upaketsoalktg as $key) {

                if ($key->fk_u_paket_soal_kecermatan_mst) {

                    $jumlahsoal = UPaketSoalKecermatanSoalDtl::where('fk_u_paket_soal_kecermatan_mst', $key->fk_u_paket_soal_kecermatan_mst)->where('fk_u_paket_soal_ktg', $key->id)->get();

                    $jumlahsoal = count($jumlahsoal);

                    $jumlahbenar = UPaketSoalKecermatanSoalDtl::where('fk_u_paket_soal_kecermatan_mst', $key->fk_u_paket_soal_kecermatan_mst)->where('fk_u_paket_soal_ktg', $key->id)->where('benar_salah', 1)->get();

                    $jumlahbenar = count($jumlahbenar);

                    if ($jumlahsoal > 0) {

                        $nilai = $jumlahbenar / $jumlahsoal * 100;
                    } else {

                        $nilai = 0;
                    }

                    $datanilai['nilai'] = $nilai;

                    $datanilai['point'] = $jumlahbenar;

                    UPaketSoalKtg::find($key->id)->update($datanilai);
                } else {

                    $jumlahbenar = UPaketSoalDtl::where('fk_u_paket_soal_ktg', $key->id)->where('fk_u_paket_soal_mst', $id)->get();

                    if (count($jumlahbenar) > 0) {

                        $jumlahpoint = 0;
                        foreach ($jumlahbenar as $jwbn) {
                            $jumlahpoint += $jwbn->{'point_' . $jwbn->jawaban_user};
                        }

                        $maxhpoint = $jumlahbenar->sum("max_point");

                        $nilaipoint = $jumlahpoint;

                        $datanilai['nilai'] = $nilaipoint;

                        $datanilai['point'] = $jumlahbenar->sum('benar_salah');

                        UPaketSoalKtg::find($key->id)->update($datanilai);
                    }
                }
            }

            $totalbenar = UPaketSoalDtl::where('fk_u_paket_soal_mst', $id)->get();

            $pointtotalbenar = 0;
            foreach ($totalbenar as $jwbn) {
                $pointtotalbenar += $jwbn->{'point_' . $jwbn->jawaban_user};
            }

            $nilai_point = $pointtotalbenar;

            $datanilaiakhir['nilai'] = $nilai_point;

            $datanilaiakhir['set_nilai'] = $totalbenar->sum('benar_salah');

            $datanilaiakhir['point'] = $totalbenar->sum('benar_salah');

            UMapelMst::find($id)->update($datanilaiakhir);
        } elseif ($dataupaketsoalmst->jenis_penilaian == 2) {

            if (! $ret) {
                return;
            }

            return response()->json([

                'status'  => false,

                'message' => 'Gagal simpan, harap coba lagi',

            ]);
        }

        $data['is_mengerjakan'] = 0;

        $updateselesai = UMapelMst::find($id)->update($data);

        if (! $ret) {
            return;
        }

        if ($updateselesai) {

            return response()->json([

                'menu'    => url($menu),

                'status'  => true,

                'message' => 'Jawaban telah tersimpan. Ujian selesai!',

            ]);
        } else {

            return response()->json([

                'status'  => false,

                'message' => 'Gagal simpan, harap coba lagi',

            ]);
        }
    }
    public function informasi()
    {
        $informasi = Informasi::all();
        return view('public/informasi', ['menu' => 'informasi', 'informasi' => $informasi]);
    }
    public function detailhasil($id)
    {

        $id = Crypt::decrypt($id);

        $upaketsoalmst = UMapelMst::find($id);

        $paketmst = PaketMst::find($upaketsoalmst->fk_paket_mst);

        $idpaket = Crypt::encrypt($paketmst->id);

        // $cekbenar = UPaketSoalDtl::where('fk_u_paket_soal_mst',$upaketsoalmst->id)->where('benar_salah',1)->get();

        // $ceksalah = UPaketSoalDtl::where('fk_u_paket_soal_mst',$upaketsoalmst->id)->where('benar_salah',0)->get();

        $data_param = [
            'upaketsoalmst',
            'idpaket',
            'paketmst'
        ];

        //if ($upaketsoalmst->jenis_waktu != 2) {

        //  return view('user/detailhasil')->with(compact($data_param));

        //} else{

        return view('public/detailhasil')->with(compact($data_param));
        //}
    }
    public function lanjutsesi(Request $request)
    {

        $id = Crypt::decrypt($request->idpaketmst);

        $idktg = Crypt::decrypt($request->idupaketsoalktg);

        $dataupaketsoalmst = UMapelMst::find($id);

        $updateselesai['is_mengerjakan'] = 2;

        UPaketSoalKtg::find($idktg)->update($updateselesai);

        $cekkategori = UPaketSoalKtg::where('fk_u_paket_soal_mst', $id)->where('is_mengerjakan', 0)->orderBy('id', 'asc')->first();

        $selesai = Carbon::now()->addMinutes($cekkategori->waktu);

        if ($selesai < $cekkategori->selesai) {

            $updatemulai['mulai'] = Carbon::now()->toDateTimeString();

            $updatemulai['selesai'] = Carbon::now()->addMinutes($cekkategori->waktu)->toDateTimeString();
        }

        $updatemulai['is_mengerjakan'] = 1;

        $update = UPaketSoalKtg::find($cekkategori->id)->update($updatemulai);

        if ($update) {

            return response()->json([

                'status'  => true,

                'message' => 'Silahkan Mempersiapkan Diri Untuk Sesi Selanjutnya',

            ]);
        } else {

            return response()->json([

                'status'  => false,

                'message' => 'Gagal, harap coba lagi',

            ]);
        }
    }
    public function storeregister(Request $request)
    {
        $template = Template::where('id', '<>', '~')->first();
        $cekemail = User::where('username', $request->email)->get();
        // $ceknowa = User::where('no_wa',$request->no_wa)->get();
        if (count($cekemail) > 0) {
            return response()->json([
                'status'  => false,
                'message' => 'Email sudah digunakan',
            ]);
            dd('Error');
        }

        $dataemailawal = [
            'nama'     => $request->name,
            'email'    => $request->email,
            'namaweb'  => $template->nama,
            'emailweb' => $template->email,
            'notlp'    => $template->no_hp,
        ];
        // $mail = new RegisterEmailAwal($dataemailawal);
        //    Mail::to($request->email)->send($mail);

        $data['username'] = $request->email;
        $data['name']     = $request->name;
        $data['email']    = $request->email;
        $data['no_wa']    = $request->no_wa;
        // $data['jenis_kelamin'] = $request->jenis_kelamin;
        // $data['alamat'] = $request->alamat;
        $data['provinsi']  = $request->provinsi;
        $data['kabupaten'] = $request->kabupaten;
        // $data['kecamatan'] = $request->kecamatan;
        $data['referrer'] = $request->referrer;
        $data['nik']      = $request->nik;
        // $data['jenjang'] = $request->jenjang;
        $data['user_level'] = 2;
        $data['is_active']  = 1;

        // if ($files = $request->file("photo")) {
        //     $destinationPath = 'upload/user/scan/';
        //     $file = 'Scan_'.Carbon::now()->timestamp. "." .$files->getClientOriginalExtension();
        //     $files->move($destinationPath, $file);
        //     $namafile = $destinationPath.$file;
        //     $data['scan'] = $destinationPath.$file;
        // }
        $data['password']   = bcrypt($request->password);
        $data['created_at'] = Carbon::now()->toDateTimeString();
        $data['updated_at'] = Carbon::now()->toDateTimeString();
        $createdata         = User::create($data);
        if ($createdata) {
            $dataemail = [
                'id'       => Crypt::encrypt($createdata->id),
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => $request->password,
                'namaweb'  => $template->nama,
                'emailweb' => $template->email,
                'notlp'    => $template->no_hp,
            ];
            $mail = new RegisterEmail($dataemail);
            Mail::to($request->email)->send($mail);

            $cekusername = User::where('username', $createdata->email)->first();

            if (auth()->attempt(array('username' => $createdata->email, 'password' => $request->password))) {
                $cekusername->update([
                    'session_id'        => session()->getId(),
                    'is_login_google'   => false
                ]);


                return response()->json([

                    'status' => true,

                    'message' => 'Login berhasil!'

                ]);
            } else {

                return response()->json([

                    'status' => false,

                    'message' => 'Password salah!'

                ]);
            }

            return response()->json([
                'status'  => true,
                'message' => 'Berhasil daftar. Silahkan masuk untuk melanjutkan',
                // 'message' => 'Berhasil daftar. Silahkan cek email inbox/spam untuk aktivasi akun'
            ]);
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Gagal. Mohon coba kembali!',
            ]);
        }
    }
    public function lupapassword()
    {
        $user       = "";
        $data_param = [
            'user',
        ];
        return view('auth/lupapassword')->with(compact($data_param));
    }
    public function aktivasi($id)
    {
        $iduser                    = Crypt::decrypt($id);
        $data['is_active']         = 1;
        $data['email_verified_at'] = Carbon::now()->toDateTimeString();
        $data['updated_by']        = $iduser;
        $data['updated_at']        = Carbon::now()->toDateTimeString();

        User::find($iduser)->update($data);

        return view('utama/Aktivasi');
    }

    public function getsubkategori(Request $request)
    {
        $datasub = PaketSubkategori::where('fk_paket_kategori', $request->val)->get(['id AS id', 'judul as text'])->toArray();
        return response()->json([
            'status'  => true,
            'datasub' => $datasub,
        ]);
    }

    public function getKabupaten(Request $request)
    {
        $kabupaten = MasterKabupaten::where('id_prov', $request->valProvinsi)->get(['id_kab AS id', 'nama as text'])->toArray();

        return response()->json([
            'status'    => true,
            'kabupaten' => $kabupaten,
        ]);
    }
    public function getKecamatan(Request $request)
    {
        $kecamatan = MasterKecamatan::where('id_kab', $request->valKab)->get(['id_kec AS id', 'nama as text'])->toArray();

        return response()->json([
            'status'    => true,
            'kecamatan' => $kecamatan,
        ]);
    }
    public function cekusername(Request $request)
    {
        $cekUsername = User::where('username', '=', $request->username)->get();
        $jumlah      = count($cekUsername);
        if ($jumlah > 0) {
            return response()->json([
                'status' => false,
            ]);
        } else {
            return response()->json([
                'status' => true,
            ]);
        }
    }
    public function resetpassword(Request $request)
    {
        $template = Template::where('id', '<>', '~')->first();
        $random   = Str::random(6);
        $user     = User::where('username', $request->username)->first();
        if ($user) {
            if ($user->is_active != 1) {
                return response()->json([
                    'status'  => false,
                    'message' => 'User belum aktif!',
                ]);
                dd('Error');
            }
            $data['password']   = bcrypt($random);
            $data['updated_by'] = Auth::id();
            $data['updated_at'] = Carbon::now()->toDateTimeString();
            $updatedata         = User::find($user->id)->update($data);
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'User tidak ditemukan!',
            ]);
            dd('Error');
        }

        if ($updatedata) {
            $dataemail = [
                'nama'     => $user->name,
                'email'    => $request->username,
                'password' => $random,
                'namaweb'  => $template->nama,
                'emailweb' => $template->email,
                'notlp'    => $template->no_hp,
            ];
            $mail = new ResetPassword($dataemail);
            Mail::to($request->username)->send($mail);

            return response()->json([
                'status'  => true,
                'message' => 'Berhasil reset password. Silahkan cek email inbox/spam',
            ]);
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Gagal. Mohon coba kembali!',
            ]);
        }
    }

    public function getalamat(Request $request)
    {
        $search = $request->search;

        if ($search == '') {
            $data = UserAlamat::select('id', DB::raw('CONCAT(alamat_lengkap, " [", nama_penerima,"-",no_hp_penerima,"]") AS text'))->where('fk_user_id', Auth::id())->where('status', 1)->orderBy('created_at', 'desc')->get()->toArray();
        } else {
            $data = UserAlamat::where('fk_user_id', Auth::id())->where('status', 1)->where('alamat_lengkap', 'like', '%' . $search . '%')->orderBy('alamat_lengkap', 'asc')->get(['id AS id', 'alamat_lengkap as text'])->toArray();
        }

        return response()->json([
            'status' => true,
            'data'   => $data,
        ]);
    }

    public function getprovinsiro(Request $request)
    {
        $search = $request->search;

        if ($search == '') {
            $provinsi = RajaOngkir::provinsi()->all();
        } else {
            $provinsi = RajaOngkir::provinsi()->search($search)->get();
        }

        return response()->json([
            'status' => true,
            'data'   => $provinsi,
        ]);
    }

    public function getkabupatenro(Request $request)
    {
        if ($request->provid) {

            $search = $request->search;

            if ($search == '') {
                $kabupaten = RajaOngkir::kota()->dariProvinsi($request->provid)->get();
            } else {
                $kabupaten = RajaOngkir::kota()->dariProvinsi($request->provid)->search($search)->get();
            }
        } else {
            $kabupaten = "";
        }

        return response()->json([
            'status' => true,
            'data'   => $kabupaten,
        ]);
    }
}
