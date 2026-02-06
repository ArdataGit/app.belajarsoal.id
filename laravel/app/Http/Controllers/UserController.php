<?php

namespace App\Http\Controllers;

use App\Models\ChannelTripay;
use App\Models\DtlSoalKecermatan;
use App\Models\EventSyarat;
use App\Models\Informasi;
use App\Models\KategoriMateri;
use App\Models\KategoriSoal;
use App\Models\KategoriSoalKecermatan;
use App\Models\KodePotongan;
use App\Models\MasterProvinsi;
use App\Models\MasterSoal;
use App\Models\MasterSoalKecermatan;
use App\Models\PaketDtl;
use App\Models\PaketKategori;
use App\Models\PaketMateri;
use App\Models\PaketMst;
use App\Models\PaketSoalDtl;
use App\Models\PaketSoalKecermatanDtl;
use App\Models\PaketSoalKecermatanMst;
use App\Models\PaketSoalKtg;
use App\Models\PaketSoalMst;
use App\Models\PaketSubkategori;
use App\Models\PaketZoom;
use App\Models\Template;
use App\Models\Transaksi;
use App\Models\UEventSyarat;
use App\Models\UMapelMst;
use App\Models\UPaketSoalDtl;
use App\Models\UPaketSoalKecermatanMst;
use App\Models\UPaketSoalKecermatanSoalDtl;
use App\Models\UPaketSoalKecermatanSoalMst;
use App\Models\UPaketSoalKtg;
use App\Models\User;
use App\Models\UserAlamat;
use Carbon\Carbon;
use DB;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use Kavist\RajaOngkir\Facades\RajaOngkir;

class UserController extends Controller
{

    private $daftar_rekening = [
        ['atas_nama' => 'Viny Apriani', 'no_rek' => '0138655792100', 'bank' => 'BANK BJB'],
    ];
    private $no_whatsapp = '085692765608';

    public function __construct()
    {

        $this->middleware('auth');
    }
    public function index($id)
    {
        $id                 = Crypt::decrypt($id);
        $menu               = "belipaketktg";
        $submenu            = "";
        $paket              = PaketMst::findOrFail($id);
        $paketdtl           = PaketDtl::where('jenis', 1)->where('fk_paket_mst', $id)->get();
        $paketdtlkecermatan = PaketDtl::where('jenis', 2)->where('fk_paket_mst', $id)->get();
        $ceksudahbeli       = Transaksi::where('fk_paket_mst', $id)->where('status', 1)->where('aktif_sampai', '>=', Carbon::now())->where('fk_user_id', Auth::id())->first();
        $data_param         = [
            'submenu',
            'menu',
            'paket',
            'paketdtl',
            'ceksudahbeli',
            'paketdtlkecermatan',
        ];
        return view('user/belipaketdetail')->with(compact($data_param));
    }

    public function checkout($id)
    {
        $id           = Crypt::decrypt($id);
        $menu         = "belipaketktg";
        $submenu      = "";
        $paket        = PaketMst::findOrFail($id);
        $channel      = ChannelTripay::where('status', 1)->get();
        $paketdtl     = PaketDtl::where('fk_paket_mst', $id)->get();
        $ceksudahbeli = Transaksi::where('fk_paket_mst', $id)->where('status', 1)->where('aktif_sampai', '>=', Carbon::now())->where('fk_user_id', Auth::id())->first();
        $angkaunik    = rand(100, 999);
        $data_param   = [
            'submenu',
            'menu',
            'paket',
            'paketdtl',
            'ceksudahbeli',
            'channel',
            'angkaunik',
        ];


        if ($ceksudahbeli) {
            return redirect('paketsayadetail/' . Crypt::encrypt($id));
        } else {
            return view('user/checkout')->with(compact($data_param));
        }
    }

    public function cekkode(Request $request)
    {
        $idpaket = Crypt::decrypt($request->idpaket);
        $paket   = PaketMst::findOrFail($idpaket);
        $kode    = $request->kode;
        $cekkode = KodePotongan::where('kode', $kode)->where('status', 1)->first();
        if ($cekkode) {
            if ($cekkode->tipe == 2) {
                $potongan = $paket->harga * $cekkode->jumlah / 100;
            } else {
                $potongan = $cekkode->jumlah;
            }
            $total = $paket->harga - $potongan;
            if ($total < 20000) {
                $total = 20000;
            } else {
                $total = $total;
            }
            $promo = $paket->harga - $total;
            return response()->json([
                'idpromo' => Crypt::encrypt($cekkode->id),
                'promo'   => $promo,
                'total'   => $total,
                'cekkode' => $cekkode,
                'status'  => true,
                'message' => 'Kode voucher berhasil digunakan',
            ]);
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Kode voucher tidak ditemukan',
            ]);
        }
    }

    public function belipaketktg()
    {
        $menu       = "belipaketktg";
        $submenu    = "";
        $kategori   = PaketKategori::orderBy('judul', 'asc')->get();
        $data_param = [
            'submenu',
            'menu',
            'kategori',
        ];
        return view('user/belipaketktg')->with(compact($data_param));
    }

    public function paketsayaktg()
    {
        $menu       = "paketsayaktg";
        $submenu    = "";
        $paket      = Transaksi::where('fk_user_id', Auth::id())->where('status', 1)->where('aktif_sampai', '>=', Carbon::now())->pluck('fk_paket_mst')->all();
        $kategori   = PaketMst::whereIn('id', $paket)->orderBy('judul', 'asc')->get();
        $data_param = [
            'submenu',
            'menu',
            'kategori',
        ];
        return view('user/paketsayaktg')->with(compact($data_param));
    }

    public function paketsayadtl(Request $request, $idpaketdtl)
    {

        $tab = $request->tab;

        $id   = Crypt::decrypt($idpaketdtl);
        $data = PaketMst::find($id);
        if ($data->is_gratis != 1) {
            $cekpaket = Transaksi::where('fk_user_id', Auth::id())->where('status', 1)->where('aktif_sampai', '>=', Carbon::now())->where('fk_paket_mst', $id)->first();
            if (! $cekpaket) {
                return Redirect::to(url('paketsayaktg'));
            }
        }

        $menu    = "paketsayaktg";
        $submenu = "";

        $paketdtl           = PaketDtl::where('jenis', 1)->where('fk_paket_mst', $id)->get();
        $paketdtlkecermatan = PaketDtl::where('jenis', 2)->where('fk_paket_mst', $id)->get();
        $paketvideo         = PaketMateri::where('fk_paket_mst', $id)->where('jenis', 1)->get();
        $paketpdf           = PaketMateri::where('fk_paket_mst', $id)->where('jenis', 2)->get();
        $paketzoom          = PaketZoom::where('fk_paket_mst', $id)->get();

        //        $hasilujian = UMapelMst::where('fk_user_id', Auth::user()->id)->where('fk_paket_mst', $id)->where('is_mengerjakan', 0)->groupBy('fk_paket_dtl')->orderBy('created_at', 'desc')->get();
        //        $hasilujiankecermatan = UPaketSoalKecermatanMst::where('fk_user_id', Auth::user()->id)->where('fk_paket_mst', $id)->where('is_mengerjakan', 2)->groupBy('fk_paket_dtl')->orderBy('created_at', 'desc')->get();
        $hasilujian           = UMapelMst::where('fk_user_id', Auth::user()->id)->where('fk_paket_mst', $id)->where('is_mengerjakan', 0)->orderBy('created_at', 'desc')->get();
        $hasilujiankecermatan = UPaketSoalKecermatanMst::where('fk_user_id', Auth::user()->id)->where('fk_paket_mst', $id)->where('is_mengerjakan', 2)->orderBy('created_at', 'desc')->get();

        $kategoris = KategoriMateri::kategori_tree();

        foreach ($paketdtlkecermatan as $p) {
            $paketdtl->push($p);
        }

        $detail_kats = KategoriMateri::materi_kategoris($paketdtl, $kategoris, 'Detail');
        $cermat_kats = [];
        //$cermat_kats = KategoriMateri::materi_kategoris($paketdtlkecermatan, $kategoris, 'Detail');

        $materi_kats = KategoriMateri::materi_array($paketvideo, $paketpdf);
        $materi_kats = KategoriMateri::materi_kategoris($materi_kats, $kategoris, 'Materi');

        $zoom_kats = KategoriMateri::materi_kategoris($paketzoom, $kategoris, 'Zoom');

        $data_param = [
            'submenu',
            'menu',
            'data',
            'paketdtl',
            'paketvideo',
            'paketpdf',
            'hasilujian',
            'idpaketdtl',
            'paketzoom',
            'paketdtlkecermatan',
            'hasilujiankecermatan',
            'kategoris',
            'detail_kats',
            'cermat_kats',
            'materi_kats',
            'zoom_kats',
            'tab',
        ];

        return view('user/paketsayadtl')->with(compact($data_param));
    }

    public function belipaketsubktg()
    {
        $menu        = "belipaketktg";
        $submenu     = "";
        $subkategori = PaketSubkategori::all();
        $data_param  = [
            'submenu',
            'menu',
            'subkategori',
        ];
        return view('user/belipaketsubktg')->with(compact($data_param));
    }
    // public function belipaketsubktg($id)
    // {
    //     $id          = Crypt::decrypt($id);
    //     $menu        = "belipaketktg";
    //     $submenu     = "";
    //     $kategori    = PaketKategori::findOrFail($id);
    //     $subkategori = PaketSubkategori::where('fk_paket_kategori', $id)->get();
    //     $data_param  = [
    //         'submenu',
    //         'menu',
    //         'kategori',
    //         'subkategori',
    //     ];
    //     return view('user/belipaketsubktg')->with(compact($data_param));
    // }

    public function caripaketsubktg(Request $request)
    {
        $datacari    = $request->datacari;
        $subkategori = PaketSubkategori::where('judul', 'LIKE', '%' . $datacari . '%')->get();
        $data_param  = [
            'subkategori',
            'datacari',
        ];
        $data = view('include/belipaketsubktg')->with(compact($data_param))->render();
        return response()->json([
            'status' => true,
            'data'   => $data,
        ]);
    }

    public function belipaket()
    {
        $menu       = "belipaketktg";
        $submenu    = "";
        $paket      = PaketMst::all();
        $data_param = [
            'submenu',
            'menu',
            'paket',
        ];
        return view('user/belipaket')->with(compact($data_param));
    }
    public function paketsayasubktg($id, $gratis = 0)
    {
        $id      = Crypt::decrypt($id);
        $menu    = "paketsayaktg";
        $submenu = "";

        if ($gratis) {

            $kategori    = PaketKategori::findOrFail($id);
            $paket       = PaketMst::where('is_gratis', 1)->where('fk_paket_kategori', $id)->pluck('fk_paket_subkategori')->all();
            $subkategori = PaketSubkategori::whereIn('id', $paket)->where('fk_paket_kategori', $id)->get();
        } else {
            $kategori    = PaketKategori::findOrFail($id);
            $paket       = Transaksi::where('fk_user_id', Auth::id())->where('status', 1)->where('aktif_sampai', '>=', Carbon::now())->pluck('fk_paket_subkategori')->all();
            $subkategori = PaketSubkategori::whereIn('id', $paket)->where('fk_paket_kategori', $id)->get();
        }
        $data_param = [
            'submenu',
            'menu',
            'kategori',
            'subkategori',
            'gratis',
        ];

        return view('user/paketsayasubktg')->with(compact($data_param));
    }

    public function paketsayakategori($id, $kid = '0', $gratis = 0)
    {
        $id      = Crypt::decrypt($id);
        $menu    = "paketsayaktg";
        $submenu = "";

        if ($gratis) {

            $paket       = PaketMst::where('is_gratis', 1)->pluck('id')->all();
            $subkategori = PaketSubkategori::find($id);
            $paket       = PaketMst::whereIn('id', $paket)->where('fk_paket_subkategori', $id)->get();
        } else {
            $paket       = Transaksi::where('fk_user_id', Auth::id())->where('status', 1)->where('aktif_sampai', '>=', Carbon::now())->pluck('fk_paket_mst')->all();
            $subkategori = PaketSubkategori::find($id);
            $paket       = PaketMst::whereIn('id', $paket)->where('fk_paket_subkategori', $id)->get();
        }

        $parents   = [];
        $kategoris = KategoriMateri::kategoris_by_pakets($paket, $kid, $parents);

        $data_param = [
            'submenu',
            'menu',
            'paket',
            'subkategori',
            'kategoris',
            'parents',
            'gratis',
        ];

        return view('user/paketsayakategori')->with(compact($data_param));
    }

    public function paketsaya($id, $gratis = 0)
    {
        $id      = Crypt::decrypt($id);
        $menu    = "paketsayaktg";
        $submenu = "";
        if ($gratis) {

            $subkategori = PaketSubkategori::find($id);
            $paket       = PaketMst::where('is_gratis', 1)->where('fk_paket_subkategori', $id)->get();
        } else {
            $paket       = Transaksi::where('fk_user_id', Auth::id())->where('status', 1)->where('aktif_sampai', '>=', Carbon::now())->pluck('fk_paket_mst')->all();
            $subkategori = PaketSubkategori::find($id);
            // $paket       = PaketMst::whereIn('id', $paket)->where('fk_paket_subkategori', $id)->get();
            $paket       = PaketMst::where('fk_paket_subkategori', $id)->get();
        }
        $data_param = [
            'submenu',
            'menu',
            'paket',
            'subkategori',
            'gratis',
        ];
        return view('user/paketsaya')->with(compact($data_param));
    }

    public function paketgratis()
    {
        $menu = "paketsayaktg";

        $submenu = "";
        $gratiskat   = PaketMst::where('is_gratis', 1)->get();


        $data_param = [
            'submenu',
            'menu',
            'gratiskat',
        ];

        return view('user/paketisgratis')->with(compact($data_param));

        //return view('user/paketgratis')->with(compact($data_param));
    }

    public function profileuser()
    {
        $voucher    = KodePotongan::where('status', 1)->get();
        $provinsi   = MasterProvinsi::all();
        $menu       = "profiluser";
        $submenu    = "";
        $data_param = [
            'submenu',
            'menu',
            'provinsi',
            'voucher',
        ];
        return view('user/profileuser')->with(compact($data_param));
    }

    public function tambahalamat()
    {
        $provinsi   = RajaOngkir::provinsi()->all();
        $menu       = "";
        $submenu    = "";
        $data_param = [
            'submenu',
            'menu',
            'provinsi',
        ];
        return view('user/tambahalamat')->with(compact($data_param));
    }

    public function ubahalamat($id)
    {
        $id         = Crypt::decrypt($id);
        $alamat     = UserAlamat::find($id);
        $provinsi   = RajaOngkir::provinsi()->all();
        $kabupaten  = RajaOngkir::kota()->dariProvinsi($alamat->fk_provinsi)->get();
        $menu       = "";
        $submenu    = "";
        $data_param = [
            'submenu',
            'menu',
            'alamat',
            'provinsi',
            'kabupaten',
        ];
        return view('user/ubahalamat')->with(compact($data_param));
    }

    public function simpanalamat(Request $request)
    {
        $data['fk_user_id']     = Auth::id();
        $data['nama_penerima']  = $request->nama_penerima;
        $data['no_hp_penerima'] = $request->no_hp_penerima;
        $data['fk_provinsi']    = $request->provinsi;
        $data['fk_kabupaten']   = $request->kabupaten;
        $data['kode_pos']       = $request->kode_pos;
        $data['alamat_lengkap'] = $request->alamat_lengkap;
        $data['created_by']     = Auth::id();
        $data['created_at']     = Carbon::now()->toDateTimeString();
        $data['updated_by']     = Auth::id();
        $data['updated_at']     = Carbon::now()->toDateTimeString();
        $usoaldtl               = UserAlamat::create($data);

        return response()->json([
            'status'  => true,
            'message' => 'Alamat berhasil ditambahkan',
        ]);
    }

    public function updatealamat(Request $request)
    {
        $id                     = Crypt::decrypt($request->id_data);
        $data['nama_penerima']  = $request->nama_penerima;
        $data['no_hp_penerima'] = $request->no_hp_penerima;
        $data['fk_provinsi']    = $request->provinsi;
        $data['fk_kabupaten']   = $request->kabupaten;
        $data['kode_pos']       = $request->kode_pos;
        $data['alamat_lengkap'] = $request->alamat_lengkap;
        $data['created_by']     = Auth::id();
        $data['created_at']     = Carbon::now()->toDateTimeString();
        $data['updated_by']     = Auth::id();
        $data['updated_at']     = Carbon::now()->toDateTimeString();
        $usoaldtl               = UserAlamat::find($id)->update($data);

        return response()->json([
            'status'  => true,
            'message' => 'Alamat berhasil diubah',
        ]);
    }

    public function hapusalamat(Request $request)
    {
        $id             = Crypt::decrypt($request->id_data[0]);
        $data['status'] = 0;
        $usoaldtl       = UserAlamat::find($id)->update($data);

        return response()->json([
            'status'  => true,
            'message' => 'Alamat berhasil dihapus',
        ]);
    }

    public function pembelian()
    {
        $template = Template::where('id', '<>', '~')->first();
        $menu     = "pembelian";
        $submenu  = "";
        $data     = Transaksi::where('fk_user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();

        $data_param = [
            'submenu',
            'menu',
            'data',
            'template',
        ];
        return view('user/pembelian')->with(compact($data_param));
    }

    public function panduanpembayaran($id)
    {
        $template        = Template::where('id', '<>', '~')->first();
        $menu            = "pembelian";
        $submenu         = "";
        $data            = Transaksi::where('merchant_order_id', $id)->first();
        $daftar_rekening = $this->daftar_rekening;
        $no_whatsapp     = $this->no_whatsapp;

        $data_param = [
            'submenu',
            'menu',
            'data',
            'template',
            'daftar_rekening',
            'no_whatsapp',
        ];
        return view('user/panduanpembayaran')->with(compact($data_param));
    }

    public function updatebuktibayar(Request $request)
    {
        $id = Crypt::decrypt($request->id_transaksi);

        if ($files = $request->file("photo")) {
            $destinationPath = 'upload/user/bukti/';
            $file            = 'Bukti_' . Carbon::now()->timestamp . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $file);
            $namafile      = $destinationPath . $file;
            $data['bukti'] = $destinationPath . $file;
        }
        Transaksi::find($id)->update($data);

        return response()->json([
            'status'  => true,
            'message' => 'Terima kasih. Bukti bayar akan dicek terlebih dahulu. Jika ada kendala hubungin admin untuk informasi lebih lanjut',
        ]);
    }
    public function daftar(Request $request, $id)
    {
        $id           = Crypt::decrypt($id);
        $mastermember = PaketMst::find($id);
        $now          = Carbon::now()->toDateTimeString();
        if ($now < $mastermember->mulai_daftar) {
            return response()->json([
                'status'  => false,
                'message' => 'Pendaftaran belum dimulai!',
            ]);
            dd('Error');
        } else {
            if ($now > $mastermember->selesai_daftar) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Pendaftaran sudah berakhir!',
                ]);
                dd('Error');
            }
        }

        $cek = Transaksi::where('fk_user_id', Auth::id())->where('fk_event_mst_id', $id)->first();

        if ($cek) {
            return response()->json([
                'status'  => false,
                'message' => 'Anda sudah mendaftar event ini, hubungi admin untuk konfirmasi!',
            ]);
            dd('Error');
        }

        $merchantOrderId = time();

        $responcreate['merchant_order_id'] = $merchantOrderId;
        $responcreate['fk_user_id']        = Auth::id();
        $responcreate['fk_event_mst_id']   = $mastermember->id;
        $responcreate['fk_mapel_mst']      = json_encode($request->id_active);
        $responcreate['harga']             = $mastermember->harga;
        $responcreate['status']            = 0;
        $responcreate['expired']           = Carbon::now()->addMinutes(180)->toDateTimeString();
        $responcreate['created_by']        = Auth::id();
        $responcreate['created_at']        = Carbon::now()->toDateTimeString();
        $responcreate['updated_by']        = Auth::id();
        $responcreate['updated_at']        = Carbon::now()->toDateTimeString();
        $createdata                        = Transaksi::create($responcreate);
        if ($createdata) {

            $jumlah_syarat = $request->jumlah_syarat;
            if ($jumlah_syarat > 0) {
                for ($i = 1; $i <= $jumlah_syarat; $i++) {
                    $data['created_by']      = Auth::id();
                    $data['created_at']      = Carbon::now()->toDateTimeString();
                    $data['updated_by']      = Auth::id();
                    $data['updated_at']      = Carbon::now()->toDateTimeString();
                    $data['fk_users']        = Auth::user()->id;
                    $data['fk_event_mst']    = $id;
                    $x                       = "id_syarat_" . $i;
                    $data['fk_event_syarat'] = $request->$x;
                    $eventsyarat             = EventSyarat::find($data['fk_event_syarat']);
                    $data['judul']           = $eventsyarat->judul;
                    $data['ket']             = $eventsyarat->ket;
                    $x                       = "photo_" . $i;

                    if ($files = $request->file($x)) {
                        $destinationPath = 'upload/' . $id . '/syaratuser/' . Auth::id() . '/';
                        $file            = 'Syarat_' . Carbon::now()->timestamp . "." . $files->getClientOriginalExtension();
                        $files->move($destinationPath, $file);
                        $namafile     = $destinationPath . $file;
                        $data['foto'] = $destinationPath . $file;
                    }

                    UEventSyarat::create($data);
                }
            }

            return response()->json([
                'status'  => true,
                'message' => 'Halaman akan diarahakan otomatis. Mohon Tunggu...',
                'id'      => Crypt::encrypt($createdata->id),
            ]);
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Gagal, mohon coba kembali !',
            ]);
        }
    }
    public function rankingtryout($id)
    {
        $id        = Crypt::decrypt($id);
        $menu      = "tryout";
        $submenu   = "";
        $datapaket = PaketSoalMst::find($id);

        if (Auth::user()->user_level == 1) {
            $extend = "layouts.SkydashAdmin";
        } else {
            $extend = "layouts.Skydash";
        }

        $udatapaket = UMapelMst::where('fk_mapel_mst', $id)->where('is_mengerjakan', 0)->orderBy('set_nilai', 'desc')->get();

        // $udatapaket = UMapelMst::where('fk_paket_soal_mst',$id)->get();
        $data_param = [
            'submenu',
            'menu',
            'datapaket',
            'udatapaket',
            'extend',
        ];
        return view('user/rankingtryout')->with(compact($data_param));
    }

    public function rankingpaket($id)
    {
        $id        = Crypt::decrypt($id);
        $menu      = "paketsayaktg";
        $submenu   = "";
        $datapaket = PaketSoalMst::find($id);

        if (Auth::user()->user_level == 1) {
            $extend = "layouts.SkydashAdmin";
        } else {
            $extend = "layouts.Skydash";
        }

        $udatapaket = UMapelMst::where('fk_mapel_mst', $id)->where('is_mengerjakan', 0)->orderBy('created_at', 'desc')->get()->unique('fk_user_id');

        // $udatapaket = UMapelMst::where('fk_paket_soal_mst',$id)->get();
        $data_param = [
            'submenu',
            'menu',
            'datapaket',
            'udatapaket',
            'extend',
        ];
        return view('user/rankingpaket')->with(compact($data_param));
    }

    public function rankingpaketkec($id)
    {
        $id        = Crypt::decrypt($id);
        $menu      = "kerjakansoal";
        $submenu   = "";
        $datapaket = PaketSoalKecermatanMst::find($id);

        $udatapaket = UPaketSoalKecermatanMst::select('*', DB::raw('AVG(nilai) as totalnilai'))->where('fk_paket_soal_kecermatan_mst', $id)->where('is_mengerjakan', 2)->groupBy('fk_user_id')->orderBy('totalnilai', 'desc')->get();

        if (Auth::user()->user_level == 1) {
            $extend = "layouts.SkydashAdmin";
        } else {
            $extend = "layouts.Skydash";
        }

        // $udatapaket = UMapelMst::where('fk_paket_soal_mst',$id)->get();
        $data_param = [
            'submenu',
            'menu',
            'datapaket',
            'udatapaket',
            'extend',
        ];
        return view('user/rankingpaketkec')->with(compact($data_param));
    }

    public function klaimhadiah($id)
    {
        $id      = Crypt::decrypt($id);
        $menu    = "klaimkadiah";
        $submenu = "";
        $cekdata = UMapelMst::where('fk_mapel_mst', $id)->where('fk_user_id', Auth::id())->where('is_mengerjakan', 0)->get();
        if ($cekdata) {
            $paket      = PaketHadiah::where('fk_mapel_mst', $id)->get();
            $data_param = [
                'submenu',
                'menu',
                'paket',
            ];
            return view('user/klaimhadiah')->with(compact($data_param));
            dd('Error');
        } else {
            return Redirect::to(url('jadwal'));
        }
    }

    public function batalkanpesanan(Request $request)
    {
        $id             = Crypt::decrypt($request->idtransaksi[0]);
        $data['status'] = 2;

        $cek = Transaksi::find($id)->update($data);
        if ($cek) {
            return response()->json([
                'status'  => true,
                'message' => 'Transaksi berhasil dibatalkan!',
            ]);
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Gagal!',
            ]);
        }
    }

    public function hapuskeranjang(Request $request)
    {
        $id = Crypt::decrypt($request->id_data[0]);

        $data['deleted_by'] = Auth::id();
        $data['deleted_at'] = Carbon::now()->toDateTimeString();
        $updateData         = Keranjang::find($id)->update($data);
        return response()->json([
            'status'  => true,
            'message' => 'Data berhasil dihapus',
        ]);
    }

    public function keranjangku()
    {
        $menu    = "klaimkadiah";
        $submenu = "";

        $template = Template::where('id', '<>', '~')->first();
        $data     = Keranjang::where('fk_user_id', Auth::id())->where('status', 0)->get();

        $data_param = [
            'submenu',
            'menu',
            'data',
            'template',
        ];
        return view('user/keranjang')->with(compact($data_param));
    }

    public function cekongkir(Request $request)
    {
        $template = Template::where('id', '<>', '~')->first();
        $idpaket  = $request->id_paket;
        $idkurir  = $request->id_kurir;
        $idalamat = $request->id_alamat;

        if (! $idkurir) {
            return response()->json([
                'status' => false,
                'data'   => "",
            ]);
            dd('Error');
        }

        if (! $idalamat) {
            return response()->json([
                'status' => false,
                'data'   => "",
            ]);
            dd('Error');
        }

        if (! $template->fk_kabupaten) {
            return response()->json([
                'status' => false,
                'data'   => "",
            ]);
            dd('Error');
        }

        $berat = 0;
        foreach ($idpaket as $key) {
            $id   = Crypt::decrypt($key);
            $data = PaketHadiah::find($id);
            $berat += $data ? $data->berat : 0;
        }

        $dataalamat = UserAlamat::find($request->id_alamat);

        $dataongkir = RajaOngkir::ongkosKirim([
            'origin'      => $template->fk_kabupaten,   // ID kota/kabupaten asal
            'destination' => $dataalamat->fk_kabupaten, // ID kota/kabupaten tujuan
            'weight'      => $berat,                    // berat barang dalam gram
            'courier'     => $idkurir,                  // kode kurir pengiriman: ['jne', 'tiki', 'pos'] untuk starter
        ])->get();

        return response()->json([
            'status' => true,
            'data'   => $dataongkir,
        ]);
    }

    public function cekujian()
    {
        $ceksedangmengerjakan = UMapelMst::where('fk_user_id', Auth::id())->where('is_mengerjakan', 1)->first();
        if ($ceksedangmengerjakan) {

            return response()->json([

                'idpaket' => Crypt::encrypt($ceksedangmengerjakan->id),

                'status'  => false,

                'message' => 'Ada ujian yang sedang dikerjakan! <b>' . $ceksedangmengerjakan->judul . '.</b><br>Apakah anda ingin melanjutkan ujiannya?',

            ]);
        } else {

            return response()->json([

                'status'  => true,

                'message' => 'Tidak ada ujian yang sedang dikerjakan',

            ]);
        }
    }

    public function listalamat()
    {

        $menu = "listalamat";

        $submenu = "";

        $data = UserAlamat::where('fk_user_id', Auth::id())->where('status', 1)->get();

        $data_param = [

            'submenu',
            'menu',
            'data',

        ];

        return view('user/listalamat')->with(compact($data_param));
    }

    public function jadwal()
    {

        $menu = "jadwal";

        $submenu = "";

        $paket = PaketSoalMst::all();

        $paketkecermatan = PaketSoalKecermatanMst::all();

        $ceksedangmengerjakan = UMapelMst::where('fk_user_id', Auth::id())->where('is_mengerjakan', 1)->first();

        if ($ceksedangmengerjakan) {

            $upaketsoalmst = UMapelMst::find($ceksedangmengerjakan->id);

            $now = Carbon::now()->toDateTimeString();

            $data_param = [

                'submenu',
                'menu',
                'upaketsoalmst',
                'now',

            ];

            return view('user/ujian')->with(compact($data_param));

            dd('Error');
        }

        $ceksedangmengerjakan = UPaketSoalKecermatanMst::where('fk_user_id', Auth::id())->where('is_mengerjakan', 1)->first();

        if ($ceksedangmengerjakan) {

            $upaketsoalmst = UPaketSoalKecermatanMst::find($ceksedangmengerjakan->id);

            $upaketsoaldtl = UPaketSoalKecermatanSoalDtl::where('fk_u_paket_soal_kecermatan_mst', $ceksedangmengerjakan->id)->get();

            $soalmst = UPaketSoalKecermatanSoalMst::where('fk_u_paket_soal_kecermatan_mst', $ceksedangmengerjakan->id)->where('is_mengerjakan', 1)->first();

            if (! $soalmst) {

                $soalmst = UPaketSoalKecermatanSoalMst::where('fk_u_paket_soal_kecermatan_mst', $ceksedangmengerjakan->id)->where('is_mengerjakan', 0)->first();

                if ($soalmst) {

                    $dataupdate['mulai'] = Carbon::now()->toDateTimeString();

                    $dataupdate['selesai'] = Carbon::now()->addSeconds($soalmst->waktu)->toDateTimeString();

                    $dataupdate['is_mengerjakan'] = 1;

                    UPaketSoalKecermatanSoalMst::find($soalmst->id)->update($dataupdate);

                    $soalmst = UPaketSoalKecermatanSoalMst::find($soalmst->id);
                } else {

                    $data_param = [

                        'submenu',
                        'menu',
                        'paket',
                        'paketkecermatan',

                    ];

                    if (Auth::user()->user_level == 4) {

                        return view('user/kerjakansoaluser')->with(compact($data_param));
                    } else {

                        return view('user/kerjakansoal')->with(compact($data_param));
                    }

                    dd('Error');
                }
            }

            $now = Carbon::now()->toDateTimeString();

            $data_param = [

                'submenu',
                'menu',
                'upaketsoalmst',
                'soalmst',
                'upaketsoaldtl',
                'now',

            ];

            return view('user/ujiankecermatan')->with(compact($data_param));

            dd('Error');
        }

        $data_param = [

            'submenu',
            'menu',
            'paket',
            'paketkecermatan',

        ];

        if (Auth::user()->user_level == 4) {

            return view('user/kerjakansoal')->with(compact($data_param));
        } else {

            return view('user/kerjakansoal')->with(compact($data_param));
        }
    }

    public function mulaiujian(Request $request, $id)
    {

        $ceksedangmengerjakan = UMapelMst::where('fk_user_id', Auth::id())->where('is_mengerjakan', 1)->first();
        if ($ceksedangmengerjakan) {
            return response()->json([
                'idpaket' => Crypt::encrypt($ceksedangmengerjakan->id),
                'status'  => false,
                'cek'     => 'ada',
                'message' => 'Ada ujian yang sedang dikerjakan! <b>' . $ceksedangmengerjakan->judul . '.</b><br>Apakah anda ingin melanjutkan ujiannya?',
            ]);
            dd('Error');
        }

        $idpaketdtl     = $request->idpaketdtl;
        $idpaketsoalmst = Crypt::decrypt($request->id_paket_soal_mst[0]);

        $paketsoalmst = PaketSoalMst::find($idpaketsoalmst);
        if ($paketsoalmst->tryout == 1) {
            $ceksudahmengerjakan = UMapelMst::where('fk_user_id', Auth::id())->where('fk_mapel_mst', $idpaketsoalmst)->first();
            if ($ceksudahmengerjakan) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Anda sudah mengerjakan ujian ini!',
                ]);
                dd('Error');
            }
            $now = Carbon::now()->toDateTimeString();
            if ($now < $paketsoalmst->mulai) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Ujian belum dimulai!',
                ]);
                dd('Error');
            } else {
                if ($now > $paketsoalmst->selesai) {
                    return response()->json([
                        'status'  => false,
                        'message' => 'Ujian sudah berakhir!',
                    ]);
                    dd('Error');
                }
            }
        }

        $paketdtl = PaketDtl::find($id);

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

            $data1['fk_user_id']       = Auth::id();
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
            $data1['created_by']     = Auth::id();
            $data1['created_at']     = Carbon::now()->toDateTimeString();
            $data1['updated_by']     = Auth::id();
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
                $data2['fk_user_id']          = Auth::id();
                $data2['fk_u_paket_soal_mst'] = $upaketsoalmst->id;
                $data2['nilai']               = 0;
                if (! $key->fk_paket_soal_kecermatan_mst) {
                    $ktgsoal = KategoriSoal::find($key->fk_kategori_soal);
                } else {
                    $ktgsoal = KategoriSoalkecermatan::find($key->fk_kategori_soal);
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

                $data2['created_by'] = Auth::id();
                $data2['created_at'] = Carbon::now()->toDateTimeString();
                $data2['updated_by'] = Auth::id();
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
                        $data3['created_by']          = Auth::id();
                        $data3['created_at']          = Carbon::now()->toDateTimeString();
                        $data3['updated_by']          = Auth::id();
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

                    $data1['fk_user_id'] = Auth::id();

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

                            $data3['created_by'] = Auth::id();

                            $data3['created_at'] = Carbon::now()->toDateTimeString();

                            $data3['updated_by'] = Auth::id();

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
    public function mulaibelajar(Request $request, $id)
    {

        $ceksedangmengerjakan = UMapelMst::where('fk_user_id', Auth::id())->where('is_mengerjakan', 1)->first();
        if ($ceksedangmengerjakan) {
            return response()->json([
                'idpaket' => Crypt::encrypt($ceksedangmengerjakan->id),
                'status'  => false,
                'cek'     => 'ada',
                'message' => 'Ada ujian yang sedang dikerjakan! <b>' . $ceksedangmengerjakan->judul . '.</b><br>Apakah anda ingin melanjutkan ujiannya?',
            ]);
            dd('Error');
        }

        $idpaketdtl     = $request->idpaketdtl;
        $idpaketsoalmst = Crypt::decrypt($request->id_paket_soal_mst[0]);

        $paketsoalmst = PaketSoalMst::find($idpaketsoalmst);
        if ($paketsoalmst->tryout == 1) {
            $ceksudahmengerjakan = UMapelMst::where('fk_user_id', Auth::id())->where('fk_mapel_mst', $idpaketsoalmst)->first();
            if ($ceksudahmengerjakan) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Anda sudah mengerjakan ujian ini!',
                ]);
                dd('Error');
            }
            $now = Carbon::now()->toDateTimeString();
            if ($now < $paketsoalmst->mulai) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Ujian belum dimulai!',
                ]);
                dd('Error');
            } else {
                if ($now > $paketsoalmst->selesai) {
                    return response()->json([
                        'status'  => false,
                        'message' => 'Ujian sudah berakhir!',
                    ]);
                    dd('Error');
                }
            }
        }

        $paketdtl = PaketDtl::find($id);

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

            $data1['fk_user_id']       = Auth::id();
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
            $data1['created_by']     = Auth::id();
            $data1['created_at']     = Carbon::now()->toDateTimeString();
            $data1['updated_by']     = Auth::id();
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
                $data2['fk_user_id']          = Auth::id();
                $data2['fk_u_paket_soal_mst'] = $upaketsoalmst->id;
                $data2['nilai']               = 0;
                if (! $key->fk_paket_soal_kecermatan_mst) {
                    $ktgsoal = KategoriSoal::find($key->fk_kategori_soal);
                } else {
                    $ktgsoal = KategoriSoalkecermatan::find($key->fk_kategori_soal);
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

                $data2['created_by'] = Auth::id();
                $data2['created_at'] = Carbon::now()->toDateTimeString();
                $data2['updated_by'] = Auth::id();
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
                        $data3['created_by']          = Auth::id();
                        $data3['created_at']          = Carbon::now()->toDateTimeString();
                        $data3['updated_by']          = Auth::id();
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

                    $data1['fk_user_id'] = Auth::id();

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

                            $data3['created_by'] = Auth::id();

                            $data3['created_at'] = Carbon::now()->toDateTimeString();

                            $data3['updated_by'] = Auth::id();

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

    public function mulaiujiankecermatan(Request $request, $id)
    {
        $ceksedangmengerjakan = UPaketSoalKecermatanMst::where('fk_user_id', Auth::id())->where('fk_u_mapel_mst', 0)->where('is_mengerjakan', 1)->first();
        if ($ceksedangmengerjakan) {
            return response()->json([

                'idpaket' => Crypt::encrypt($ceksedangmengerjakan->id),

                'status'  => false,

                'cek'     => 'ada',

                'message' => 'Ada ujian kecermatan yang sedang dikerjakan! <b>(' . $ceksedangmengerjakan->judul . ').</b><br>Apakah anda ingin melanjutkan ujiannya?',
            ]);

            dd('Error');
        }

        $idpaketsoalmst = Crypt::decrypt($request->id_paket_soal_mst[0]);

        $paketsoalmst = PaketSoalKecermatanMst::find($idpaketsoalmst);

        $paketsoaldtl = PaketSoalKecermatanDtl::where('fk_paket_soal_kecermatan_mst', $idpaketsoalmst)->inRandomOrder()->get();

        $paketdtl = PaketDtl::find($id);

        if ($paketsoalmst) {

            $data1['fk_paket_mst'] = $paketdtl->fk_paket_mst;

            $data1['fk_paket_dtl'] = $paketdtl->id;

            $data1['fk_user_id'] = Auth::id();

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

                    $data3['created_by'] = Auth::id();

                    $data3['created_at'] = Carbon::now()->toDateTimeString();

                    $data3['updated_by'] = Auth::id();

                    $data3['updated_at'] = Carbon::now()->toDateTimeString();

                    $usoaldtl = UPaketSoalKecermatanSoalDtl::create($data3);
                }
            }

            return response()->json([

                'status'  => true,

                'id'      => Crypt::encrypt($upaketsoalmst->id),

                'message' => 'Halaman akan diarahkan otomatis, mohon tunggu...',

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
                ];

                return view('user/ujianpersesi_kecermatan')->with(compact($data_param));
            } else {

                $data_param = [

                    'submenu',
                    'menu',
                    'upaketsoalmst',
                    'now',
                    'dataloop',
                ];

                if ($upaketsoalmst->jenis_waktu != 2) {

                    return view('user/ujian')->with(compact($data_param));
                } else {

                    return view('user/ujianpersesi')->with(compact($data_param));
                }
            }
        }
    }
    public function belajar($id)
    {
        $idupaketsoalmst = Crypt::decrypt($id);

        $upaketsoalmst = UMapelMst::find($idupaketsoalmst);

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
                ];

                return view('user/ujianpersesi_kecermatan')->with(compact($data_param));
            } else {

                $data_param = [

                    'submenu',
                    'menu',
                    'upaketsoalmst',
                    'now',
                    'dataloop',
                ];

                if ($upaketsoalmst->jenis_waktu != 2) {

                 return view('user/belajarall')->with(compact($data_param));

                } else {

                return view('user/belajar')->with(compact($data_param));
                }

            }
        }
    }

    public function ujiankecermatan(Request $request, $id)
    {
        $idupaketsoalmst = Crypt::decrypt($id);

        $menu = "kerjakansoal";

        $submenu = "";

        // $upaketsoalmst = UPaketSoalKecermatanMst::find($idupaketsoalmst);

        $upaketsoalmst = UPaketSoalKecermatanMst::find($idupaketsoalmst);
        if ($upaketsoalmst->is_mengerjakan == 2) {
            return Redirect::to(url('detailhasilkecermatan/' . Crypt::encrypt($idupaketsoalmst)));
            return Redirect::to(url('home'));
        }

        $soalmst = UPaketSoalKecermatanSoalMst::where('fk_u_paket_soal_kecermatan_mst', $idupaketsoalmst)->where('is_mengerjakan', 1)->first();

        if (! $soalmst) {
            $soalmst = UPaketSoalKecermatanSoalMst::where('fk_u_paket_soal_kecermatan_mst', $idupaketsoalmst)->where('is_mengerjakan', 0)->first();
            if ($soalmst) {
                $dataupdate['mulai'] = Carbon::now()->toDateTimeString();
                if ($soalmst->waktu_total) {
                    $dataupdate['selesai'] = Carbon::createFromFormat('Y-m-d H:i:s', $dataupdate['mulai'])->addSeconds($soalmst->waktu_total * 60)->toDateTimeString();
                } else {
                    $dataupdate['selesai'] = Carbon::now()->addSeconds($soalmst->waktu)->toDateTimeString();
                }
                $dataupdate['is_mengerjakan'] = 1;
                UPaketSoalKecermatanSoalMst::find($soalmst->id)->update($dataupdate);
                $soalmst = UPaketSoalKecermatanSoalMst::find($soalmst->id);
            } else {
                $this->selesaiujiankecermatan($request, $idupaketsoalmst);

                return Redirect::to(url('detailhasilkecermatan/' . Crypt::encrypt($idupaketsoalmst)));

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

        $soals = UPaketSoalKecermatanSoalDtl::where('fk_u_paket_soal_kecermatan_mst', $idupaketsoalmst)->where('jawaban_user', '')->pluck('id')->all();

        $now = Carbon::now()->toDateTimeString();

        $data_param = [
            'submenu',
            'menu',
            'upaketsoalmst',
            'soalmst',
            'now',
            'soals',
        ];

        return view('user/ujiankecermatan')->with(compact($data_param));

        if ($upaketsoalmst->is_mengerjakan == 0) {

            return Redirect::to(url('hasilujian'));
        } else {

            $data_param = [

                'submenu',
                'menu',
                'upaketsoalmst',
            ];

            return view('user/ujiankecermatan')->with(compact($data_param));
        }
    }

    public function selesaiujiankecermatan(Request $request, $id = null)
    {
        $ret = ! $id;

        if ($ret) {
            $id = $request->idpaketmst;
            if (! $id) {
                $id = $request->idsoalmst;
            }
        }

        if (is_string($id) && ! ctype_digit($id)) {
            $id = Crypt::decrypt($id);
        }

        $now = Carbon::now()->toDateTimeString();

        $data['is_mengerjakan'] = 2;

        $paket = UPaketSoalKecermatanMst::find($id);

        $updateselesai = UPaketSoalKecermatanSoalMst::where('fk_u_paket_soal_kecermatan_mst', $paket->id)->where('is_mengerjakan', 1)->update($data);

        $cekdataterakhir = UPaketSoalKecermatanSoalMst::where('fk_u_paket_soal_kecermatan_mst', $paket->id)->where('is_mengerjakan', 0)->get();

        $jumlah = count($cekdataterakhir);

        if ($jumlah > 0) {

            $isterakhir = 'tidak';
        } else {

            $isterakhir = 'ya';

            $data['selesai'] = $now;

            $paket->update($data);
        }
        if (! $ret) {
            return;
        }

        if ($updateselesai) {

            return response()->json([

                'status'     => true,

                'isterakhir' => $isterakhir,

                'message'    => 'Jawaban telah tersimpan. Ujian selesai!',

            ]);
        } else {

            return response()->json([

                'status'  => false,

                'message' => 'Gagal memuat soal, harap coba lagi!',

            ]);
        }
    }

    public function selesaiujiankecermatanfix(Request $request)
    {
        $id = $request->idpaketmst;
        if (is_string($id) && ! ctype_digit($id)) {
            $id = Crypt::decrypt($id);
        }

        $datamst['is_mengerjakan'] = 2;
        $datamst['selesai']        = Carbon::now()->toDateTimeString();

        $upaketsoalmst = UPaketSoalKecermatanMst::find($id)->update($datamst);

        $datasoal['is_mengerjakan'] = 2;

        $upaketsoalmstsoal = UPaketSoalKecermatanSoalMst::where('fk_u_paket_soal_kecermatan_mst', $id)->update($datasoal);

        if ($upaketsoalmst) {

            return response()->json([

                'status'  => true,

                'message' => 'Jawaban telah tersimpan. Ujian selesai!',

            ]);
        } else {

            return response()->json([

                'status'  => false,

                'message' => 'Gagal, harap coba lagi!',

            ]);
        }
    }

    public function updatejawabankecermatan(Request $request)
    {
        $upaketsoaldtl = UPaketSoalKecermatanSoalDtl::find($request->idpaketdl);

        $cekismengerjakan = UPaketSoalKecermatanMst::find($upaketsoaldtl->fk_u_paket_soal_kecermatan_mst);

        if ($cekismengerjakan->is_mengerjakan != 1) {

            return response()->json([

                'status'  => false,

                'message' => 'Tidak dapat menyimpan jawaban karena ujian telah selesai',

            ]);

            dd('Error');
        }

        $data['jawaban_user'] = $request->jawaban;

        if ($upaketsoaldtl->jawaban == $request->jawaban) {

            $data['benar_salah'] = 1;
        } else {

            $data['benar_salah'] = 0;
        }

        $updateJawaban = UPaketSoalKecermatanSoalDtl::find($request->idpaketdl)->update($data);

        $jumlahsoal = UPaketSoalKecermatanSoalDtl::where('fk_u_paket_soal_kecermatan_mst', $upaketsoaldtl->fk_u_paket_soal_kecermatan_mst)->get();

        $jumlahsoal = count($jumlahsoal);

        $jumlahbenar = UPaketSoalKecermatanSoalDtl::where('fk_u_paket_soal_kecermatan_mst', $upaketsoaldtl->fk_u_paket_soal_kecermatan_mst)->where('benar_salah', 1)->get();

        $jumlahbenar = count($jumlahbenar);

        if ($jumlahsoal > 0) {

            // $nilai = $jumlahbenar / $jumlahsoal * 100;
            $nilai = $jumlahbenar;
        } else {

            $nilai = 0;
        }

        $datanilai['nilai'] = $nilai;

        UPaketSoalKecermatanMst::find($upaketsoaldtl->fk_u_paket_soal_kecermatan_mst)->update($datanilai);

        // $upaketsoalktg = UPaketSoalKtg::where('fk_u_paket_soal_mst',$upaketsoaldtl->fk_u_paket_soal_mst)->get();

        // foreach ($upaketsoalktg as $key) {

        //     $jumlahbenar = UPaketSoalDtl::where('fk_u_paket_soal_ktg',$key->id)->where('fk_u_paket_soal_mst',$upaketsoaldtl->fk_u_paket_soal_mst)->where('benar_salah',1)->get();

        //     if($key->jumlah_soal==0){

        //         $nilai = 0;

        //     }else{

        //         $nilai = (count($jumlahbenar)/$key->jumlah_soal)*100;

        //     }

        //     $datanilai['nilai'] = (int)$nilai;

        //     if($datanilai['nilai']>100){

        //         $datanilai['nilai']=100;

        //     }

        //     UPaketSoalKtg::find($key->id)->update($datanilai);

        // }

        // $totalsoal = UPaketSoalDtl::where('fk_u_paket_soal_mst',$upaketsoaldtl->fk_u_paket_soal_mst)->get();

        // $totalbenar = UPaketSoalDtl::where('fk_u_paket_soal_mst',$upaketsoaldtl->fk_u_paket_soal_mst)->where('benar_salah',1)->get();

        // $nilaiakhir = count($totalbenar) / count($totalsoal) * 100;

        // $datanilaiakhir['nilai'] = (int) $nilaiakhir;

        // UMapelMst::find($upaketsoaldtl->fk_u_paket_soal_mst)->update($datanilaiakhir);

        if ($updateJawaban) {

            return response()->json([

                'status'  => true,

                'message' => 'Berhasil simpan jawaban',

            ]);
        } else {

            return response()->json([

                'status'  => false,

                'message' => 'Gagal simpan, harap coba lagi',
            ]);
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
    public function updatejawabanbelajar(Request $request)
    {

        $upaketsoaldtl = UPaketSoalDtl::find($request->idpaketdl);

        $cekismengerjakan = UMapelMst::find($upaketsoaldtl->fk_u_paket_soal_mst);

        if ($cekismengerjakan->is_mengerjakan == 0) {

            return response()->json([

                'status'  => false,

                'message' => 'Tidak dapat menyimpan jawaban karena ujian telah selesai',

            ]);

            dd('Error');
        }

        if ($cekismengerjakan->jenis_penilaian == 1) {

            $data['jawaban_user'] = $request->jawaban;

            $getpoint = UPaketSoalDtl::find($request->idpaketdl);

            $datapoint = "point_" . $request->jawaban;

            $data['benar_salah'] = $getpoint->$datapoint;

            $updateJawaban = UPaketSoalDtl::find($request->idpaketdl)->update($data);
        } elseif ($cekismengerjakan->jenis_penilaian == 2) {

            $data['jawaban_user'] = $request->jawaban;

            $tingkat = (int) $upaketsoaldtl->tingkat;

            if ($upaketsoaldtl->jawaban == $request->jawaban) {

                $data['benar_salah'] = $tingkat;
            } else {

                $data['benar_salah'] = 0;
            }

            $updateJawaban = UPaketSoalDtl::find($request->idpaketdl)->update($data);
        }

        if ($updateJawaban) {

            return response()->json([

                'status'  => true,

                'message' => 'Berhasil simpan jawaban',

            ]);
        } else {

            return response()->json([

                'status'  => false,

                'message' => 'Gagal simpan, harap coba lagi',

            ]);
        }
    }

    public function hasilujian()
    {

        // return Redirect::to(url('jadwal'));

        $menu = "hasilujian";

        $submenu = "";

        $data = UMapelMst::where('fk_user_id', Auth::user()->id)->where('is_mengerjakan', 0)->orderBy('created_at', 'desc')->get();

        $datakecermatan = UPaketSoalKecermatanMst::where('fk_user_id', Auth::user()->id)->where('is_mengerjakan', 2)->orderBy('created_at', 'desc')->get();

        $data_param = [

            'submenu',
            'menu',
            'data',
            'datakecermatan',

        ];

        return view('user/hasilujian')->with(compact($data_param));
    }

    public function selesaiujian(Request $request, $id = null)
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

            $menu = "detailhasil/" . $request->idpaketmst;
        }

        if ($dataupaketsoalmst->jenis_penilaian == 1) {

            $upaketsoalktg = UPaketSoalKtg::where('fk_u_paket_soal_mst', $id)->get();

            // $usebobot = false;

            foreach ($upaketsoalktg as $key) {

                // if($key->bobot)$usebobot = true;

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

                        // $jumlahpoint = $jumlahbenar->sum("benar_salah");
                        $jumlahpoint = 0;
                        foreach ($jumlahbenar as $jwbn) {
                            $jumlahpoint += $jwbn->{'point_' . $jwbn->jawaban_user};
                        }

                        $maxhpoint = $jumlahbenar->sum("max_point");

                        // if ($maxhpoint == 0) {

                        //     $nilaipoint = 0;
                        // } else {

                        //     $nilaipoint = $jumlahpoint / $maxhpoint * 100;
                        // }

                        //$nilaipoint = (int)$nilaipoint;
                        $nilaipoint = $jumlahpoint;

                        // if ($nilaipoint < 0) {
                        //     $nilaipoint = 0;
                        // }

                        $datanilai['nilai'] = $nilaipoint;

                        $datanilai['point'] = $jumlahbenar->sum('benar_salah');

                        UPaketSoalKtg::find($key->id)->update($datanilai);
                    }
                }
            }

            $totalbenar = UPaketSoalDtl::where('fk_u_paket_soal_mst', $id)->get();

            // $pointtotalbenar = $totalbenar->sum('benar_salah');
            $pointtotalbenar = 0;
            foreach ($totalbenar as $jwbn) {
                $pointtotalbenar += $jwbn->{'point_' . $jwbn->jawaban_user};
            }

            // $pointmax = $totalbenar->sum('max_point');

            // if ($pointmax == 0) {

            //     $nilai_point = 0;
            // } else {

            //     $nilai_point = $pointtotalbenar / $pointmax * 100;
            // }

            // $nilai_point = (int) $nilai_point;
            $nilai_point = $pointtotalbenar;

            // if ($nilai_point < 0) {
            //     $nilai_point = 0;
            // }

            // if($usebobot){
            //     $upaketsoalktg = UPaketSoalKtg::where('fk_u_paket_soal_mst', $id)->get();

            //     $nilai_point = 0;
            //     foreach ($upaketsoalktg as $key){
            //         $nilai_point += (float)($key->nilai * (float)($key->bobot / 100.0));

            //     }

            // }

            // $datanilaiakhir['use_bobot'] = $usebobot ? 1 : 0;

            $datanilaiakhir['nilai'] = $nilai_point;

            $datanilaiakhir['set_nilai'] = $totalbenar->sum('benar_salah');

            $datanilaiakhir['point'] = $totalbenar->sum('benar_salah');

            UMapelMst::find($id)->update($datanilaiakhir);

            // $upaketsoalktg = UPaketSoalKtg::where('fk_u_paket_soal_mst',$id)->get();

            // foreach ($upaketsoalktg as $key) {

            //     $jumlahbenar = UPaketSoalDtl::where('fk_u_paket_soal_ktg',$key->id)->where('fk_u_paket_soal_mst',$id)->where('benar_salah',1)->get();

            //     if($key->jumlah_soal==0){

            //         $nilai = 0;

            //     }else{
            //         $nilai = (count($jumlahbenar)/$key->jumlah_soal)*100;

            //     }

            //     $datanilai['nilai'] = (int)$nilai;

            //     if($datanilai['nilai']>100){

            //         $datanilai['nilai']=100;

            //     }

            //     UPaketSoalKtg::find($key->id)->update($datanilai);
            // }

            // $totalsoal = UPaketSoalDtl::where('fk_u_paket_soal_mst',$id)->get();

            // $totalbenar = UPaketSoalDtl::where('fk_u_paket_soal_mst',$id)->where('benar_salah',1)->get();

            // $nilaiakhir = count($totalbenar) / count($totalsoal) * 100;

            // $datanilaiakhir['nilai'] = (int) $nilaiakhir;
            // UMapelMst::find($id)->update($datanilaiakhir);

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

    public function lanjutsesi(Request $request)
    {

        $id = Crypt::decrypt($request->idpaketmst);

        $idktg = Crypt::decrypt($request->idupaketsoalktg);

        $dataupaketsoalmst = UMapelMst::find($id);

        // $dataupaketsoalktg = UPaketSoalKtg::find($idktg);

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

    public function detailhasil($id)
    {

        $id = Crypt::decrypt($id);

        $menu = "paketsayaktg";

        $submenu = "";

        $upaketsoalmst = UMapelMst::find($id);

        // $cekbenar = UPaketSoalDtl::where('fk_u_paket_soal_mst',$upaketsoalmst->id)->where('benar_salah',1)->get();

        // $ceksalah = UPaketSoalDtl::where('fk_u_paket_soal_mst',$upaketsoalmst->id)->where('benar_salah',0)->get();

        if (Auth::user()->user_level == 1) {
            $extend = "layouts.SkydashAdmin";
        } else {

            $extend = "layouts.Skydash";
        }

        if ($upaketsoalmst->is_mengerjakan == 1) {

            return Redirect::to(url('hasilujian'));
        } else {

            $data_param = [

                'submenu',
                'menu',
                'upaketsoalmst',
                'extend',
            ];

            //if ($upaketsoalmst->jenis_waktu != 2) {

            //  return view('user/detailhasil')->with(compact($data_param));

            //} else{

            return view('user/detailhasilpersesi')->with(compact($data_param));
            //}
        }
    }

    public function detailhasilkecermatan($id)
    {
        $id = Crypt::decrypt($id);

        $menu = "paketsayaktg";

        $submenu = "";

        $upaketsoalmst = UPaketSoalKecermatanMst::find($id);

        $soalmst = UPaketSoalKecermatanSoalMst::where('fk_u_paket_soal_kecermatan_mst', $id)->get();

        if (Auth::user()->user_level == 1) {

            $extend = "layouts.SkydashAdmin";
        } else {

            $extend = "layouts.Skydash";
        }

        $cekbenar = UPaketSoalKecermatanSoalDtl::where('fk_u_paket_soal_kecermatan_mst', $upaketsoalmst->id)->where('benar_salah', 1)->get();

        $ceksalah = UPaketSoalKecermatanSoalDtl::where('fk_u_paket_soal_kecermatan_mst', $upaketsoalmst->id)->where('benar_salah', 0)->get();

        $hitungsoaldtl = UPaketSoalKecermatanSoalDtl::where('fk_u_paket_soal_kecermatan_mst', $upaketsoalmst->id)->get();

        if ($upaketsoalmst->is_mengerjakan == 1) {

            return Redirect::to(url('home'));
        } else {

            $data_param = [

                'submenu',
                'menu',
                'upaketsoalmst',
                'soalmst',
                'cekbenar',
                'ceksalah',
                'hitungsoaldtl',
                'extend',
            ];

            return view('user/detailhasilkecermatan')->with(compact($data_param));
        }
    }

    public function tryout()
    {

        $menu = "tryout";

        $submenu = "";

        $now = Carbon::now()->toDateTimeString();

        $paket = PaketSoalMst::where('tryout', 1)->get();

        $data_param = [

            'submenu',
            'menu',
            'paket',
            'now',

        ];

        return view('user/tryout')->with(compact($data_param));
    }

    public function informasidtl($id)
    {

        $id = Crypt::decrypt($id);

        $menu = "home";

        $submenu = "";

        $data = Informasi::find($id);

        $data_param = [

            'submenu',
            'menu',
            'data',

        ];

        return view('user/informasidtl')->with(compact($data_param));
    }

    public function cekPasswordPaket(Request $request)
    {
        $paket         = PaketMst::find($request->paket_id);
        $inputPassword = trim($request->password);

        if ($paket && $paket->password === $inputPassword) {
            return response()->json(['status' => true]);
        } else {
            return response()->json(['status' => false]);
        }
    }

    public function voucherdtl($id)
    {

        $id = Crypt::decrypt($id);

        $menu = "home";

        $submenu = "";

        $data = KodePotongan::find($id);

        $data_param = [

            'submenu',
            'menu',
            'data',

        ];

        return view('user/voucherdtl')->with(compact($data_param));
    }
}
