<?php

namespace App\Http\Controllers;

use App\Models\RoleMenu;
use Illuminate\Http\Request;
use App\Models\Role;

class RoleMenuController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $menu = 'role_menu';
        $submenu='';
        $role = Role::all();
        $data = RoleMenu::orderBy('created_at','desc')->groupBy('role_id')->get();
        $data_param = [
            'menu','submenu','data', 'role'
        ];
        
        return view('role/menu_index')->with(compact($data_param));
    }

    public function store(Request $request)
    {
        foreach ($request->menu as $key => $value) {
            $insert = RoleMenu::create([
                'role_id'   => $request->role_id,
                'menu'      => $value
            ]);
        }
      
        return response()->json([
            'status' => true,
            'message' => 'Berhasil tambah data'
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = RoleMenu::find($id);
        $data_menu = RoleMenu::where('role_id', $data->role_id)->get();


        foreach ($request->menu as $key => $value) {
            $new_data = RoleMenu::create([
                'role_id'   => $data->role_id,
                'menu'      => $value
            ]);
        }
        
        foreach ($data_menu as $key => $value) {
            $value->delete();
        }
     

        return response()->json([
            'status' => true,
            'message' => 'Berhasil ubah data'
        ]);
    }

    public function destroy($id)
    {
        $data = RoleMenu::find($id);
        $data_menu = RoleMenu::where('role_id', $data->role_id)->get();

        foreach ($data_menu as $key => $value) {
            $value->delete();
        }
  
        return response()->json([
            'status' => true,
            'message' => 'Berhasil hapus data'
        ]);
    }
}
