<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Informasi;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Mengirim variabel $menu bersama dengan memanggil view
        $menu = 'faq';
        $submenu = '';
        $data = Faq::orderBy('created_at', 'desc')->get();
        $data_param = [
            'menu',
            'submenu',
            'data'
        ];
        return view('user.faq')->with(compact($data_param));
    }
    public function indexAdmin()
    {
        // Mengirim variabel $menu bersama dengan memanggil view
        $menu = 'faq-admin';
        $submenu = '';
        $data = Faq::orderBy('created_at', 'desc')->get();
        $data_param = [
            'menu',
            'submenu',
            'data'
        ];

        return view('master/faq')->with(compact($data_param));
    }
    public function informasi()
    {
        $informasi = Informasi::all();
        return view('user.informasi', ['menu' => 'informasi', 'informasi' => $informasi]);
    }
    public function store(Request $request)
    {
        $data['question'] = $request->question_add;
        $data['answer'] = $request->answer_add;
        $createdata = Faq::create($data);
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
    public function update(Request $request)
    {
        $id = $request->iddata[0];

        $data['question'] = $request->question[0];
        $data['answer'] = $request->answer[0];
        $updatedata = Faq::find($id)->update($data);

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
    public function destroy(Request $request)
    {
        $id = $request->iddata[0];
        Faq::find($id)->delete();
        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }
}
