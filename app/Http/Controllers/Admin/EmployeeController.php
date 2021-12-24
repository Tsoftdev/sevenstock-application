<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Hash;
use DB;
use Validator;
use Session;
use App\Models\Employee;
use App\Models\Company;
use App\Http\Start\Helpers;
use Yajra\DataTables\Facades\DataTables;

class EmployeeController extends Controller
{
    protected $helper; // Global variable for instance of Helpers
    
    public function __construct()
    {
        $this->helper = new Helpers;
    }

    public function index() {
        if (request()->ajax()) {
            $employees = Employee::orderBy('created_at', 'DESC')
            ->select([
                'id',
                'name',
                'email',
                'passencrypt',
                'companyId',
                'position',
                DB::raw("DATE_FORMAT(created_at, '%Y.%m.%d') as date"),
            ]);

            return Datatables::of($employees)
                ->addColumn('mass_delete', function($row) {
                    return '<input name="employee_ids" type="checkbox" class="form-check-input selectCheckbox" value="'.$row->id.'" />';
                })
                ->editColumn('name', function ($row) {
                    $name = $row->name;
                    return '<a href="'.url('admin/employees/update/'.$row->id).'">'.$name.'</a>';
                })
                ->editColumn('company', function ($row) {
                    $company = $row->company->companyName;
                    return $company;
                })
                ->addColumn(
                    'action', function($row) {
                        $action   = '<a href="'.url('admin/employees/update/'.$row->id).'" class="btn btn-outline-primary">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>
                                    <a href="javascript:void(0);" class="btn btn-outline-danger btn_employ_delete" data-id="'.$row->id.'">
                                        <i class="mdi mdi-delete"></i> 
                                    </a>';
                        return $action;
                    }
                )
                ->rawColumns(['mass_delete','name','company', 'action'])
                ->make(true);
        }

        return view('admin.employees.index');
    }

    public function add(Request $request) {
        if(!$_POST) {
            $companies = Company::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
            return view('admin.employees.add')->with(compact('companies'));
        } 
        else if($request->submit){

			//Start Validation
            $rules = [
                'name' => 'required',
                'email' => 'required',
                'passencrypt' => 'required',
                'position' => 'required',
                'company' => 'required'
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'error' => $validator->errors()->all()],201);
            } 
            //end Validation
            else {
                $employee = new Employee();
                $employee->name = $request->name;
                $employee->email = $request->email;
                $employee->passencrypt = $request->passencrypt;
                $employee->password = Hash::make($request->passencrypt);
                $employee->position = $request->position;
                $employee->companyId = $request->company;
                $employee->save();

                // Insert Role Id to role_user table
                //$employee->attachRole($request->role); 

                $output = ['success' => 1,
                            'msg' => "Add Successfully!"
                            ];
                return redirect('admin/employees')->with('status', $output);
            }
			
		}
        else {
            return redirect('admin/employees');
        }
        
    }
    public function update(Request $request, $id) {

        if(!$_POST) {
            $employee = Employee::find($request->id);
            return view('admin.employees.update')->with(compact('employee'));
        } 
        else if($request->submit){

			//Start Validation
            $rules = [
                'name' => 'required',
                'email' => 'required',
                'passencrypt' => 'required',
                'position' => 'required',
                'company' => 'required'
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'error' => $validator->errors()->all()],201);
            } 
            //end Validation
            else {
                $employee = Employee::find($request->id);;
                $employee->name = $request->name;
                $employee->email = $request->email;
                $employee->passencrypt = $request->passencrypt;
                $employee->password = Hash::make($request->passencrypt);
                $employee->position = $request->position;
                $employee->companyId = $request->company;
                $employee->save();

                //User::update_role($request->id, $request->role);
                
                $output = ['success' => 1,
                            'msg' => "Updated Successfully!"
                            ];
                return redirect('admin/employees')->with('status', $output);
            }
			
		}
        else {
            return redirect('admin/employees');
        }
    }
    public function delete(Request $request) {
        $employee = Employee::find($request->emid);
        $employee->delete();
        $output = ['success' => 1,
                        'msg' => "Deleted Successfully!"
                        ];
        return response()->json($output);
    }
}
