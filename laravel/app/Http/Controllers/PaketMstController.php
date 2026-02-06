<?php

namespace App\Http\Controllers;

use App\Mail\IngatkanPeserta;
use App\Models\KategoriMateri;
use App\Models\PaketDtl;
use App\Models\PaketFitur;
use App\Models\PaketKategori;
use App\Models\PaketMst;
use App\Models\PaketSoalKecermatanMst;
use App\Models\PaketSoalKoranMst;
use App\Models\PaketSoalMst;
use App\Models\PaketSubkategori;
use App\Models\Transaksi;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PaketMstController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
    }

    public function index()
    {

        $menu = 'master';

        $submenu = 'paketmst';

        $data = PaketMst::orderBy('created_at', 'desc')->get();
        // dd($data);

        $kategori = PaketKategori::all();

        $subkategori = PaketSubkategori::all();

        $data_param = [

            'menu',
            'submenu',
            'data',
            'subkategori',
            'kategori',

        ];

        return view('master/paketmst')->with(compact($data_param));
    }

    public function pesertaevent($idevent)
    {

        $menu = 'master';

        $submenu = 'paketmst';

        $data = Transaksi::where('fk_paket_mst_id', $idevent)->where('status', 1)->get();

        $data_param = [

            'menu',
            'submenu',
            'data',
            'idevent',

        ];

        return view('master/pesertaevent')->with(compact($data_param));
    }

    public function ingatkanpeserta(Request $request)
    {

        $transaksi = Transaksi::where('fk_paket_mst_id', $request->id_event)->where('status', 1)->pluck('fk_user_id')->all();

        foreach ($transaksi as $data) {

            $peserta = User::find($data);

            $dataemailawal = [

                'idpeserta' => $data,

                'idevent'   => $request->id_event,

            ];

            $mail = new IngatkanPeserta($dataemailawal);

            Mail::to($peserta->email)->send($mail);
        }

        return response()->json([

            'status'  => true,

            'message' => 'Berhasil kirim pengingat',

            // 'message' => 'Berhasil daftar. Silahkan cek email inbox/spam untuk aktivasi akun'

        ]);
    }

    public function store(Request $request)
    {

        $data['judul'] = $request->judul_add;

        $data['is_gratis'] = $request->is_gratis_add;

        if ($request->is_gratis_add == 1) {

            $data['harga']    = 0;
            // $data['password'] = $request->password_add; // Menyimpan password
            $data['password'] = null; // Menyimpan password

        } else {

            $data['harga']    = $request->harga_add;
            $data['password'] = null; // Kosongkan password jika paket tidak gratis

        }

        $data['jumlah_gratis_ujian'] = $request->jumlah_gratis_ujian_add;

        $data['jumlah_gratis_belajar'] = $request->jumlah_gratis_belajar_add;

        $paketsubkategori = PaketSubkategori::find($request->fk_paket_subkategori_add);

        $data['fk_paket_kategori'] = $paketsubkategori->fk_paket_kategori;

        $data['fk_paket_subkategori'] = $request->fk_paket_subkategori_add;

        if ($files = $request->file("banner_add")) {

            $destinationPath = 'upload/paket/banner/';

            $file = 'Banner_' . Carbon::now()->timestamp . "." . $files->getClientOriginalExtension();

            $files->move($destinationPath, $file);

            $namafile = $destinationPath . $file;

            $data['banner'] = $destinationPath . $file;
        }

        if ($files = $request->file("juknis_add")) {

            $destinationPath = 'upload/paket/juknis/';

            $file = 'Juknis_' . Carbon::now()->timestamp . "." . $files->getClientOriginalExtension();

            $files->move($destinationPath, $file);

            $namafile = $destinationPath . $file;

            $data['juknis'] = $destinationPath . $file;
        }

        $data['ket'] = $request->ket_add;

        $data['status'] = 1;

        $data['created_by'] = Auth::id();

        $data['created_at'] = Carbon::now()->toDateTimeString();

        $data['updated_by'] = Auth::id();

        $data['updated_at'] = Carbon::now()->toDateTimeString();

        $createdata = PaketMst::create($data);

        if ($createdata) {

            return response()->json([

                'status'  => true,

                'message' => 'Berhasil menambahkan data',

            ]);
        } else {

            return response()->json([

                'status'  => false,

                'message' => 'Gagal. Mohon coba kembali!',

            ]);
        }
    }
    public function update(Request $request, $id)
    {
        // Initialize an array to hold error messages
        $errors = [];
    
        // Check if each expected field is present
        if (!isset($request->judul[0])) {
            $errors[] = 'Judul tidak boleh kosong.';
        }
        if (!isset($request->is_gratis[0])) {
            $errors[] = 'Is gratis tidak boleh kosong.';
        }
        if (!isset($request->harga[0])) {
            $errors[] = 'Harga tidak boleh kosong.';
        }
        if (!isset($request->jumlah_gratis_ujian[0])) {
            $errors[] = 'Jumlah gratis ujian tidak boleh kosong.';
        }
        if (!isset($request->jumlah_gratis_belajar[0])) {
            $errors[] = 'Jumlah gratis belajar tidak boleh kosong.';
        }
        if (!isset($request->fk_paket_subkategori[0])) {
            $errors[] = 'Subkategori paket tidak boleh kosong.';
        }
        if (!isset($request->ket[0])) {
            $errors[] = 'Keterangan tidak boleh kosong.';
        }
    
        // If there are errors, return them
        if (!empty($errors)) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal. Mohon periksa input: ' . implode(' ', $errors),
            ]);
        }
    
        // Prepare data array
        $data = [
            'judul' => $request->judul[0],
            'is_gratis' => $request->is_gratis[0],
            'harga' => $request->is_gratis[0] == 1 ? 0 : $request->harga[0],
            'password' => null, // Assuming you want to keep it null
            'jumlah_gratis_ujian' => $request->jumlah_gratis_ujian[0],
            'jumlah_gratis_belajar' => $request->jumlah_gratis_belajar[0],
            'fk_paket_subkategori' => $request->fk_paket_subkategori[0],
            'ket' => $request->ket[0],
            'updated_by' => Auth::id(),
            'updated_at' => Carbon::now()->toDateTimeString(),
        ];
    
        // Find the subcategory
        $paketsubkategori = PaketSubkategori::find($request->fk_paket_subkategori[0]);
        if ($paketsubkategori) {
            $data['fk_paket_kategori'] = $paketsubkategori->fk_paket_kategori;
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Subkategori tidak ditemukan.',
            ]);
        }
    
        // Handle file uploads
        if ($request->hasFile('banner')) {
            $file = $request->file('banner')[0];
            $fileName = 'Banner_' . Carbon::now()->timestamp . "." . $file->getClientOriginalExtension();
            $file->move('upload/paket/banner/', $fileName);
            $data['banner'] = 'upload/paket/banner/' . $fileName;
        }
    
        if ($request->hasFile('juknis')) {
            $file = $request->file('juknis')[0];
            $fileName = 'Juknis_' . Carbon::now()->timestamp . "." . $file->getClientOriginalExtension();
            $file->move('upload/paket/juknis/', $fileName);
            $data['juknis'] = 'upload/paket/juknis/' . $fileName;
        }
    
        // Update the record
        $updatedata = PaketMst::find($id)->update($data);
    
        if ($updatedata) {
            return response()->json([
                'status' => true,
                'message' => 'Data berhasil diubah',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Gagal. Mohon coba kembali!',
            ]);
        }
    }
    public function destroy($id)
    {
        $paket = PaketMst::find($id);

        if (! $paket) {
            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan',
            ]);
        }

        // Soft delete paket
        if ($paket->delete()) {
            // Soft delete detail paket
            PaketDtl::where('fk_paket_mst', $id)->delete();

            return response()->json([
                'status'  => true,
                'message' => 'Data berhasil dihapus',
            ]);
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Gagal menghapus data',
            ]);
        }
    }

    public function indexdtl($idmst)
    {

        $menu = 'master';

        $submenu = 'paketmst';

        $datamst = PaketMst::find($idmst);

        // Pilihan Ganda

        $arr = PaketDtl::where('jenis', 1)->where('fk_paket_mst', $idmst)->pluck('fk_mapel_mst')->all();

        $datamapel = PaketSoalMst::whereNotIn('id', $arr)->where('tryout', 0)->get();

        // Kecermatan

        $arr = PaketDtl::where('jenis', 2)->where('fk_paket_mst', $idmst)->pluck('fk_mapel_mst')->all();

        $datamapelkecermatan = PaketSoalKecermatanMst::whereNotIn('id', $arr)->get();

        $data = PaketDtl::where('fk_paket_mst', $idmst)->orderBy('jenis', 'asc')->get();

        $kategoris = KategoriMateri::kategoris_by_name('Detail');

        $data_param = [

            'menu',
            'submenu',
            'data',
            'idmst',
            'datamst',
            'datamapel',
            'datamapelkecermatan',
            'kategoris',

        ];

        return view('master/paketdtl')->with(compact($data_param));
    }

    public function storedtl(Request $request)
    {

        $jenis = $request->jenis_soal_add;

        $cekdata = PaketDtl::where('jenis', $jenis)->where('fk_paket_mst', $request->fk_paket_mst)->where('fk_mapel_mst', $request->fk_mapel_mst_add)->first(); // Bisa double mapel pada event

        // $cekdata = PaketDtl::where('fk_mapel_mst',$request->fk_mapel_mst_add)->first(); // 1 Event 1 Mapel

        if ($cekdata) {

            return response()->json([

                'status'  => false,

                'message' => 'Soal sudah digunakan pada paket lain, silahkan tambah soal baru!',

            ]);

            dd('Error');
        }

        $kats = $request->kategori;
        if (! $kats || ! is_array($kats)) {
            $kats = [];
        }

        $katid               = $kats ? end($kats) : 0;
        $data['kategori_id'] = $katid;

        $data['fk_mapel_mst'] = $request->fk_mapel_mst_add;

        $data['fk_paket_mst'] = $request->fk_paket_mst;

        $data['jenis'] = $jenis;

        $data['created_by'] = Auth::id();

        $data['created_at'] = Carbon::now()->toDateTimeString();

        $data['updated_by'] = Auth::id();

        $data['updated_at'] = Carbon::now()->toDateTimeString();

        $createdata = PaketDtl::create($data);

        if ($createdata) {

            return response()->json([

                'status'  => true,

                'message' => 'Berhasil menambahkan data',

            ]);
        } else {

            return response()->json([

                'status'  => false,

                'message' => 'Gagal. Mohon coba kembali!',

            ]);
        }
    }

    public function updatedtl(Request $request, $id)
    {
        $kats = $request->kategori;
        if (! $kats || ! is_array($kats)) {
            $kats = [];
        }

        $katid = $kats ? end($kats) : 0;

        $data['kategori_id'] = $katid;

        $data['updated_by'] = Auth::id();
        $data['updated_at'] = Carbon::now()->toDateTimeString();
        $updatedata         = PaketDtl::find($id)->update($data);
        if ($updatedata) {
            return response()->json([
                'status'  => true,
                'message' => 'Data berhasil diubah',
            ]);
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Gagal. Mohon coba kembali!',
            ]);
        }
    }

    public function destroydtl($id)
    {

        $data['deleted_by'] = Auth::id();

        $data['deleted_at'] = Carbon::now()->toDateTimeString();

        $updateData = PaketDtl::find($id)->update($data);

        return response()->json([

            'status'  => true,

            'message' => 'Data berhasil dihapus',

        ]);
    }

    public function getPaketSoal(Request $request, $idmst)
    {

        if ($request->val == 1) {

            // Pilihan Ganda

            $arr = PaketDtl::where('jenis', 1)->where('fk_paket_mst', $idmst)->pluck('fk_mapel_mst')->all();

            $datapaket = PaketSoalMst::whereNotIn('id', $arr)->where('tryout', 0)->get(['id AS id', 'judul as text'])->toArray();
        } elseif ($request->val == 2) {

            // Kecermatan

            $arr = PaketDtl::where('jenis', 2)->where('fk_paket_mst', $idmst)->pluck('fk_mapel_mst')->all();

            $datapaket = PaketSoalKecermatanMst::whereNotIn('id', $arr)->where('fk_paket_soal_mst', 0)->get(['id AS id', 'judul as text'])->toArray();
        } elseif ($request->val == 3) {

            // Kecermatan

            $arr = PaketDtl::where('jenis', 3)->where('fk_paket_mst', $idmst)->pluck('fk_mapel_mst')->all();

            $datapaket = PaketSoalKoranMst::whereNotIn('id', $arr)->get(['id AS id', 'judul as text'])->toArray();
        }

        return response()->json([

            'status'    => true,

            'datapaket' => $datapaket,

        ]);
    }

    public function indexfitur($idmst)
    {

        $menu = 'master';

        $submenu = 'paketmst';

        $datamst = PaketMst::find($idmst);

        $data = PaketFitur::where('fk_paket_mst', $idmst)->orderBy('created_at', 'desc')->get();

        $data_param = [

            'menu',
            'submenu',
            'data',
            'idmst',
            'datamst',

        ];

        return view('master/paketfitur')->with(compact($data_param));
    }

    public function storefitur(Request $request)
    {

        $data['fk_paket_mst'] = $request->fk_paket_mst;

        $data['judul'] = $request->judul_add;

        $data['ket'] = $request->ket_add;

        $data['created_by'] = Auth::id();

        $data['created_at'] = Carbon::now()->toDateTimeString();

        $data['updated_by'] = Auth::id();

        $data['updated_at'] = Carbon::now()->toDateTimeString();

        $createdata = PaketFitur::create($data);

        if ($createdata) {

            return response()->json([

                'status'  => true,

                'message' => 'Berhasil menambahkan data',

            ]);
        } else {

            return response()->json([

                'status'  => false,

                'message' => 'Gagal. Mohon coba kembali!',

            ]);
        }
    }

    public function updatefitur(Request $request, $id)
    {

        $data['judul'] = $request->judul[0];

        $data['ket'] = $request->ket[0];

        $data['updated_by'] = Auth::id();

        $data['updated_at'] = Carbon::now()->toDateTimeString();

        $updatedata = PaketFitur::find($id)->update($data);

        if ($updatedata) {

            return response()->json([

                'status'  => true,

                'message' => 'Data berhasil diubah',

            ]);
        } else {

            return response()->json([

                'status'  => false,

                'message' => 'Gagal. Mohon coba kembali!',

            ]);
        }
    }

    public function destroyfitur($id)
    {

        $data['deleted_by'] = Auth::id();

        $data['deleted_at'] = Carbon::now()->toDateTimeString();

        $updateData = PaketFitur::find($id)->update($data);

        return response()->json([

            'status'  => true,

            'message' => 'Data berhasil dihapus',

        ]);
    }
}
