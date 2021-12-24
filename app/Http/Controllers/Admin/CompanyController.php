<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use DB;
use App\Http\Start\Helpers;
use App\Models\Company;
use Yajra\DataTables\Facades\DataTables;
use Validator;
use Session;

class CompanyController extends Controller
{
    protected $helper; // Global variable for instance of Helpers
    public function __construct() {
        $this->helper = new Helpers;
    }

    public function index() {
        if (request()->ajax()) {
            $companies = Company::where('isApproved', '=', 'Y')
                ->where('isActive', '=', 'Y')
                ->where('isDelete', '=', 'N')
                //->orderBy('created_at', 'DESC')
                ->select([
                'id', 
                'companyName', 
                'ownerName',
                DB::raw("DATE_FORMAT(created_at, '%Y.%m.%d') as date"), 
                DB::raw("DATE_FORMAT(consultdate, '%Y.%m.%d') as consultdate"),
                DB::raw("DATE_FORMAT(reviewdate, '%Y.%m.%d') as reviewdate"),
                DB::raw("DATE_FORMAT(enddate, '%Y.%m.%d') as enddate"),
                'createdBy'
            ]);

            return Datatables::of($companies)
                ->addColumn(
                    'action', function($row) {
                        return '<a href="'.url('admin/edit_companies/'.$row->id).'" class="btn btn-sm btn-primary" data-id="'.$row->id.'"><i class="mdi mdi-pencil-box-multiple"></i>  수정</a>';
                    }
                )
                ->addColumn('mass_delete', function($row) {
                    
                    return '<input type="checkbox" class="form-check-input" value="'.$row->id.'" />';
                })
                ->rawColumns(['action', 'mass_delete'])
                ->make(true); 
        }
        return view('admin.company.index');
    }

    public function add(Request $request) {
        if(!$_POST) {
            return view('admin.company.add');
        }
        else if($request->submit) {
            $rules = array(
                'companyName' => 'required|unique:companies',
                //'ownerName' => 'required',
                // 'consultdate' => 'required',
                // 'reviewdate' => 'required',
                //'companylogo' => 'mimes:jpg,jpeg,png,gif|required',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput(); 
            }
            $company = new Company;
            $company->companyName = $request->companyName;
            $company->ownerName = $request->ownerName;
            $company->consultdate = $request->consultdate;
            $company->reviewdate = $request->reviewdate;
            $company->enddate = $request->enddate;
            $company->isActive = "Y";
            $company->createdBy = Auth::guard('admin')->user()->id;
            $company->save();
            $companylogo = $request->file('companylogo');
            //IMAGEN LOGO
            if($companylogo)
            { 
                $companylogo_extension = $companylogo->getClientOriginalExtension();
                $companylogo_filename = 'companylogo' . time() .  '.' . $companylogo_extension;

                $success = $companylogo->move('images/companies/'.$company->id, $companylogo_filename);
                if(!$success)
                    return back()->withError("error");
                $company->companylogo =url('images/companies').'/'.$company->id.'/'.$companylogo_filename;
                $company->save();
            }
            $output = ['success' => 1,
                            'msg' => "Added Company Successfully!"
                            ];
            return redirect('admin/companies')->with('status', $output);
        }
    }

    public function update(Request $request) {
        if(!$_POST) {
            $company = Company::find($request->id);
            return view('admin.company.edit')->with(compact('company'));
        }
        else if($request->submit) {
            $rules = array(
                'companyName' => 'required|unique:companies,companyName,'.$request->id,
                //'ownerName' => 'required',
                // 'consultdate' => 'required',
                // 'reviewdate' => 'required',
                //'companylogo' => 'mimes:jpg,jpeg,png,gif',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput(); 
            }
            $company = Company::find($request->id);
            $company->companyName = $request->companyName;
            $company->ownerName = $request->ownerName;
            $company->consultdate = $request->consultdate;
            $company->reviewdate = $request->reviewdate;
            $company->enddate = $request->enddate;
            $company->isActive = "Y";
            $company->createdBy = Auth::guard('admin')->user()->id;
            $company->save();
            $companylogo = $request->file('companylogo');
            if($companylogo)
            { 
                $companylogo_extension = $companylogo->getClientOriginalExtension();
                $companylogo_filename = 'companylogo' . time() .  '.' . $companylogo_extension;

                $success = $companylogo->move('images/companies/'.$company->id, $companylogo_filename);
                if(!$success)
                    return back()->withError("error");
                $company->companylogo =url('images/companies').'/'.$company->id.'/'.$companylogo_filename;
                $company->save();
            }
            $output = ['success' => 1,
                            'msg' => "Updated Company Successfully!"
                            ];
            return redirect('admin/companies')->with('status', $output);
        }
    }

    public function massDestroy(Request $request) {
        
        if (!empty($request->input('selected_rows'))) {
            $selected_rows = explode(',', $request->input('selected_rows'));
            
            $stocks = Company::whereIn('id', $selected_rows)->delete();
        }
        

        return redirect()->back();
    }

    public function companyenddelete(Request $request) {
        if (request()->ajax()) {
            $company = Company::find($request->comid);
            $company->enddate = null;
            $company->save();
            $output = ['success' => 1,
                            'msg' => "Consult End Date Deleted Successfully!"
                            ];
            return response()->json($output);
        }
    }
}
