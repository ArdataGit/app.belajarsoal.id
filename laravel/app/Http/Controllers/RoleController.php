<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $menu = 'role';
        $submenu='';
        $data = Role::orderBy('created_at','desc')->get();
        $data_param = [
            'menu','submenu','data'
        ];
        
        return view('role/index')->with(compact($data_param));
    }

    public function store(Request $request)
    {
        $createdata = Role::create([
            'name'  => $request->name
        ]);

        if($createdata){
            return response()->json([
                'status' => true,
                'message' => 'Berhasil tambah data'
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
        $data = Role::find($id);
        $data->update([
            'name'  => $request->name[0]
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Berhasil ubah data'
        ]);
    }

    public function destroy($id)
    {
        $data = Role::find($id);
        $data->delete();

        return response()->json([
            'status' => true,
            'message' => 'Berhasil hapus data'
        ]);
    }
}
