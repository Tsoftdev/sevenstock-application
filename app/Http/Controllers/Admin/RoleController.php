<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use Auth;
use Session;
use Validator;
use App\Models\Role;
use App\Models\Permission;
use App\Http\Start\Helpers;

class RoleController extends Controller
{
    protected $helper; // Global variable for instance of Helpers
    
    public function __construct(){
        $this->helper = new Helpers;
    }
    
    public function index() {
        $roles = Role::orderBy('id', 'ASC')->get();
        return view('admin.roles.index')->with(compact('roles'));
    }

    public function add(Request $request) {
        if(!$_POST) {
            $permissions = Permission::get();
            return view('admin.roles.add')->with(compact('permissions'));
        }
        else if($request->submit) {
            $rules = array(
                'name'         => 'required|unique:roles',
                'display_name' => 'required',
                'description'  => 'required',
            );

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput(); 
            }

            $request->permission = is_array($request->permission) ? $request->permission : [];
            $permission = [];
            $permission = $request->permission;
            $role = new Role;
            $role->name = $request->name;
            $role->display_name = $request->display_name;
            $role->description = $request->description;
            $role->save();

            if($request->permission){
                $role->perms()->sync($permission);
            }

            $output = ['success' => 1,
                            'msg' => "Add Successfully!"
                            ];

            return redirect('admin/roles')->with('status', $output);
        }
        else {
            return redirect('admin/roles');
        }
    }

    public function update(Request $request) {
        if(!$_POST) {
            
            $role = Role::find($request->id);
            $stored_permissions = Role::permission_role($request->id);
            $permissions = Permission::get();
            return view('admin.roles.edit')->with(compact('permissions', 'stored_permissions', 'role'));
        }
        else if($request->submit) {
            $rules = array(
                'name'         => 'required|unique:roles,name,'.$request->id,
                'display_name' => 'required',
                'description'  => 'required',
            );

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput(); 
            }

            $request->permission = is_array($request->permission) ? $request->permission : [];
            $permission = [];
            $permission = $request->permission;
            $role = Role::find($request->id);
            $role->name = $request->name;
            $role->display_name = $request->display_name;
            $role->description = $request->description;
            $role->save();

            $role->perms()->sync($permission);

            $output = ['success' => 1,
                            'msg' => "Updated Successfully!"
                            ];

            return redirect('admin/roles')->with('status', $output);
        }
        else {
            return redirect('admin/roles');
        }
    }

    public function delete(Request $request) {
        if (DB::table('role_user')->where('role_id', $request->roleid)->exists()) {
            $output = ['success' => 0,
                            'msg' => "Sorry this role is already in use. So canont delete.!"
                            ];
            return redirect('admin/roles')->with('status', $output);
        }
        Role::where('id', $request->roleid)->delete();
        $output = ['success' => 1,
                            'msg' => "Deleted Successfully!"
                            ];
        return response()->json($output);
    }
    
}
