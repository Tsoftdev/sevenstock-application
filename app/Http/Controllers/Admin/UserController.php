<?php
namespace App\Http\Controllers\Admin;

use DB;
use Hash;
use Auth;
use Session;
use Validator;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Role;
use App\Http\Start\Helpers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    protected $helper; // Global variable for instance of Helpers
    
    public function __construct(){
        $this->helper = new Helpers;
    }
    
    public function index() {
        $users = User::orderBy('created_at','DESC')->get();
        //dd($users);
        return view('admin.users.index')->with(compact('users'));
    }
    
    public function store(Request $request) {
        if(!$_POST) {
            $roles = Role::all();
            return view('admin.users.store')->with(compact('roles'));
        } 
        else if($request->submit){

			//Start Validation
            $rules = [
                'name' => 'required',
                'email' => 'required',
                'password' => 'required',
                'role' => 'required'
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'error' => $validator->errors()->all()],201);
            } 
            //end Validation
            else {
                $user = new User();
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = Hash::make($request->password);
                $user->save();

                // Insert Role Id to role_user table
                $user->attachRole($request->role); 

                $output = ['success' => 1,
                            'msg' => "Add Successfully!"
                            ];
                return redirect('admin/users')->with('status', $output);
            }
			
		}
        else {
            return redirect('admin/users');
        }
        
    }
    
    public function edit(Request $request, $id) {

        if(!$_POST) {
            $roles = Role::all();
            $user = User::find($request->id);
            return view('admin.users.edit')->with(compact('roles', 'user'));
        } 
        else if($request->submit){

			//Start Validation
            $rules = [
                'name' => 'required',
                'email' => 'required',
                'role' => 'required'
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'error' => $validator->errors()->all()],201);
            } 
            //end Validation
            else {
                $user = User::find($request->id);
                $user->name = $request->name;
                $user->email = $request->email;
                if(trim($request->get ('password')) !=''){
                    $user->password = Hash::make($request->password);
                }

                User::update_role($request->id, $request->role);
                $user->save();

                $output = ['success' => 1,
                            'msg' => "Updated Successfully!"
                            ];
                return redirect('admin/users')->with('status', $output);
            }
			
		}
        else {
            return redirect('admin/users');
        }
    }
    
    public function delete(Request $request, $id) {
        if(User::find($id)){
            $user = User::find($id);
            $user->delete();
            $this->helper->flash_message('success', 'Account has been deleted successfully.'); 
            return redirect('admin/users');
        }
    }
}
