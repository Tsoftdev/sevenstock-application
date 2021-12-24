<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Validator;
use Session;
use App\Models\Routeknown;
use App\Models\Customergroup;
use App\Models\Company;
use App\Http\Start\Helpers;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Inquery;
use App\Models\Customer;
use App\Models\User;
use App\Models\Stock;
use Carbon\Carbon;
use App\Models\Feedhistory;


class InqueryController extends Controller
{
    protected $helper; // Global variable for instance of Helpers
    
    public function __construct()
    {
        $this->helper = new Helpers;
    }
    public function index() {
        if (request()->ajax()) {
            $inqueries = Inquery::join('customers', 'inqueries.customerId', '=', 'customers.id')
            ->orderBy('inqueries.created_at', 'DESC')
            ->select(['inqueries.id',
                DB::raw("DATE_FORMAT(inqueries.created_at, '%Y.%m.%d') as date"),
                'customers.name',
                'customers.email',
                'customers.phonenumber1',
                'inqueries.note',
                'customers.customerGroupID',
                'customers.routesOfKnownID',
                'inqueries.keyword',
                'inqueries.customerId', 
                'inqueries.createdBy'
            ]);
            if (request()->has('group_filter')) {
                $group_filter = request()->get('group_filter');
                if (!empty($group_filter)) {
                    $inqueries->where('customers.customerGroupID', $group_filter);
                }
            }
            
            if (request()->has('company_filter')) {
                $company_filter = request()->get('company_filter');
                if (!empty($company_filter)) {
                    $stocks = Stock::where('companyId', "=", $company_filter)->select('userId')->distinct()->get();
                    $companyid = array();
                    foreach ($stocks as $key => $value) {
                        array_push($companyid, $value['userId']);
                    }
                    $inqueries->whereIn('customerId', $companyid);
                    
                }
            }
            if (request()->has('route_filter')) {
                $route_filter = request()->get('route_filter');
                if (!empty($route_filter)) {
                    $inqueries->where('customers.routesOfKnownID', $route_filter);
                }
            }
            if (request()->has('desksearch')) {
                $desksearch = request()->get('desksearch');
                if (!empty($desksearch)) {
                    $emailcheck = strpos($desksearch, '@');
                    if($emailcheck !== false) {
                        $inqueries->where('customers.email', $desksearch);
                    } else if ($desksearch){
                        $inqueries->where('customers.phonenumber1', 'like', '%' . $desksearch . '%');
                        $inqueries->orWhere('customers.name', 'like', '%' . $desksearch . '%');
                    } 
                }
            }

            if (request()->has('mobilesearch')) {
                $mobilesearch = request()->get('mobilesearch');
                if (!empty($mobilesearch)) {
                    $emailcheck = strpos($mobilesearch, '@');
                    if($emailcheck !== false) {
                        $inqueries->where('customers.email', $mobilesearch);
                    } else if ($mobilesearch) {
                        $inqueries->where('customers.phonenumber1', 'like', '%'. $mobilesearch . '%');
                        $inqueries->orWhere('customers.name', 'like', '%' . $mobilesearch . '%');
                    } 
                }
            }
            return Datatables::of($inqueries)
                ->addColumn('action', function($row) {
                    return '<a href="'.url('admin/edit_customer/'.$row->customerId).'" class="btn btn-sm btn-primary"><i class="mdi mdi-eye-circle-outline"></i></a>';
                })
                ->addColumn('mass_delete', function($row) {
                
                    return '<input type="checkbox" class="form-check-input" value="'.$row->id.'" />';
                })
                ->editColumn('name', function ($row) {
                    $name = $row->name;
                    return '<a href="'.url('admin/user-record/edit_inquery/'.$row->id).'">'.$name.'</a>';
                })
                ->editColumn('keyword', function ($row) {
                    $keyword = $row->keyword;
                    $keyword_name = "";
                    if (!empty($keyword)) {
                        $keyword_arr = explode(',', $keyword);
                        foreach($keyword_arr as $item) {
                            $keyword_name.='<span class="tag badge bg-info p-1 me-1">'.$item.'</span>';
                        }  
                    } else {
                        $keyword_name = '';
                    }
                    return $keyword_name;
                })
                ->addColumn('admin', function($row) {
                    $admin = User::where('id', $row->createdBy)->first();
                    return $admin->name;
                })
                ->rawColumns(['action','name', 'admin', 'mass_delete', 'keyword'])
                ->make(true);
        }
        $groups = Customergroup::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
        $companies = Company::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
        $routeknowns = RouteKnown::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
        return view('admin.user-records.inquery.index')->with(compact('groups', 'companies', 'routeknowns'));
    }
    public function add(Request $request) {
        if(!$_POST) {
            $customers = Customer::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
            return view('admin.user-records.inquery.add')->with(compact('customers'));
        } 
        else if ($request->submit) {
            $rules = array(
                'note'  => 'required',
                'customer'  => 'required',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } 
            else {
                
                $inquery = new Inquery;
                $inquery->note = $request->note;
                if (request()->has('keyword')) {
                    $keyword = request()->get('keyword');
                    if (!empty($keyword)) {
                        $inquery->keyword = $keyword;
                    }
                    else {
                        $inquery->keyword = '';
                    }
                }
                $inquery->customerId = $request->customer;
                $inquery->createdBy = Auth::guard('admin')->user()->id;
                $inquery->save();

                //feed history add
                $feedhistory = new Feedhistory;
                $feedhistory->feedname = "Inquery";
                $feedhistory->customerId = $request->customer;
                $feedhistory->createdBy = Auth::guard('admin')->user()->id;
                $feedhistory->save();

                $this->helper->flash_message('success', 'Added Successfully'); 

                return redirect('admin/user-record/inquery');
            }
        }
        else {
            return redirect('admin/user-record/inquery');
        }
    }
    public function update(Request $request) {
        if(!$_POST) {
            $customers = Customer::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
            $inquery = Inquery::find($request->id);
            return view('admin.user-records.inquery.edit')->with(compact('customers', 'inquery'));
        } 
        else if ($request->submit) {
            $rules = array(
                'note'  => 'required',
                'customer'  => 'required',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } 
            else {
                $inquery = Inquery::find($request->id);
                $inquery->note = $request->note;
                $inquery->keyword = $request->keyword;
                $inquery->customerId = $request->customer;
                $inquery->createdBy = Auth::guard('admin')->user()->id;
                $inquery->save();
                $this->helper->flash_message('success', 'Added Successfully'); 

                return redirect('admin/user-record/inquery');
            }
        }
        else {
            return redirect('admin/user-record/inquery');
        }
    }

    public function massDestroy(Request $request) {
        
        if (!empty($request->input('selected_rows'))) {
            $selected_rows = explode(',', $request->input('selected_rows'));
            $inquery = Inquery::whereIn('id', $selected_rows)->delete();
        }
        

        return redirect()->back();
    }

    public function memolist(Request $request) {
        if(request()->ajax()) {
            $memoes = Inquery::join('customers', 'inqueries.customerId', '=', 'customers.id')
            ->join('users', 'users.id', '=', 'inqueries.createdBy')
            ->orderBy('inqueries.created_at', 'DESC')
            ->where('inqueries.customerId', '=', $request->customer_id)
            ->select(['inqueries.id',
                DB::raw("DATE_FORMAT(inqueries.created_at, '%Y.%m.%d %h:%i %p') as date"),
                'customers.name',
                'inqueries.note',
                'inqueries.keyword',
                'inqueries.createdBy',
                'users.name as username',
                'inqueries.companyId'
            ])->get();
            foreach ($memoes as $memo) {
                $keyword = $memo->keyword;
                $keyword_name = "";
                if (!empty($keyword)) {
                    $keyword_arr = explode(',', $keyword);
                    foreach($keyword_arr as $item) {
                        $keyword_name.='<span class="tag badge bg-secondary memo-keyword me-1">'.$item.'</span>';
                    }  
                } else {
                    $keyword_name = 'No Keyword added!';
                }
                $memo->keyword_name = $keyword_name;
            }
            if (!empty($request->pinned)) {
                $pinned = true;
            } else {
                $pinned = false;
            }
            $html = view('admin.user-records.inquery.memoindex')->with(compact('memoes', 'pinned'))->render();
            
            $output = ['html' => $html, 'success' => true, 'msg' => '' ];

            return $output;
        }
    }

    public function memoadminlist(Request $request) {
        if(request()->ajax()) {
            $memoes = Inquery::join('users', 'users.id', '=', 'inqueries.createdBy')
            ->orderBy('inqueries.created_at', 'DESC')
            ->where('inqueries.createdBy', '=', $request->admin_id)
            ->where('inqueries.customerId', '=', null)
            ->select(['inqueries.id',
                DB::raw("DATE_FORMAT(inqueries.created_at, '%Y.%m.%d %h:%i %p') as date"),
                'inqueries.note',
                'inqueries.keyword',
                'inqueries.createdBy',
                'users.name as username'
            ])->get();
            foreach ($memoes as $memo) {
                $keyword = $memo->keyword;
                $keyword_name = "";
                if (!empty($keyword)) {
                    $keyword_arr = explode(',', $keyword);
                    foreach($keyword_arr as $item) {
                        $keyword_name.='<span class="tag badge bg-secondary p-2 me-1">'.$item.'</span>';
                    }  
                } else {
                    $keyword_name = 'No Keyword added!';
                }
                $memo->keyword_name = $keyword_name;
            }
            if (!empty($request->pinned)) {
                $pinned = true;
            } else {
                $pinned = false;
            }
            

            $html = view('admin.user-records.inquery.adminmemoindex')->with(compact('memoes','pinned'))->render();
            
            $output = ['html' => $html, 'success' => true, 'msg' => '' ];

            return $output;
        }
    }

    public function memoadd(Request $request) {
        if(request()->ajax()) {
            $rules = array(
                'note'  => 'required',
                'customer'  => 'required',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } 
            else {
                
                $inquery = new Inquery;
                $inquery->note = $request->note;
                if (request()->has('keyword')) {
                    $keyword = request()->get('keyword');
                    if (!empty($keyword)) {
                        $inquery->keyword = $keyword;
                    }
                    else {
                        $inquery->keyword = '';
                    }
                }
                $inquery->companyId = $request->company;
                $inquery->customerId = $request->customer;
                $inquery->createdBy = Auth::guard('admin')->user()->id;
                $inquery->save();

                return response()->json(['status' => 'success'],200);
            }
        }
    }

    public function memoadminadd(Request $request) {
        if(request()->ajax()) {
            $rules = array(
                'note'  => 'required',
                'admin'  => 'required',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } 
            else {
                
                $inquery = new Inquery;
                $inquery->note = $request->note;
                if (request()->has('keyword')) {
                    $keyword = request()->get('keyword');
                    if (!empty($keyword)) {
                        $inquery->keyword = $keyword;
                    }
                    else {
                        $inquery->keyword = '';
                    }
                }
                $inquery->companyId = $request->company;
                $inquery->createdBy = Auth::guard('admin')->user()->id;
                $inquery->save();

                return response()->json(['status' => 'success'],200);
            }
        }
    }

    public function memoupdate(Request $request) {
        if(request()->ajax()) {
            $rules = array(
                'note'  => 'required',
                'customer'  => 'required',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } 
            else {
                
                $inquery = Inquery::find($request->memoid);
                $inquery->note = $request->note;
                if (request()->has('keyword')) {
                    $keyword = request()->get('keyword');
                    if (!empty($keyword)) {
                        $inquery->keyword = $keyword;
                    }
                    else {
                        $inquery->keyword = '';
                    }
                }
                $inquery->companyId = $request->company;
                $inquery->customerId = $request->customer;
                $inquery->createdBy = Auth::guard('admin')->user()->id;
                $inquery->save();

                return response()->json(['status' => 'success'],200);
            }
        }
    }

    public function memoadminupdate(Request $request) {
        if(request()->ajax()) {
            $rules = array(
                'note'  => 'required',
                'admin'  => 'required',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } 
            else {
                
                $inquery = Inquery::find($request->memoid);
                $inquery->note = $request->note;
                if (request()->has('keyword')) {
                    $keyword = request()->get('keyword');
                    if (!empty($keyword)) {
                        $inquery->keyword = $keyword;
                    }
                    else {
                        $inquery->keyword = '';
                    }
                }
                $inquery->createdBy = Auth::guard('admin')->user()->id;
                $inquery->save();

                return response()->json(['status' => 'success'],200);
            }
        }
    }


    public function memodelete(Request $request) {
        if(request()->ajax()) {
            $inquery = Inquery::find($request->memo_id);
            $inquery->delete();
            return response()->json(['status' => 'success'],200);
        }
    }

    public function getmemo(Request $request) {
        if (request()->ajax()) {
            $inquery = Inquery::find($request->memoid);
            $data = [
                'note' => $inquery->note,
                'keyword' => trim($inquery->keyword),
                'company' => $inquery->companyId
            ];
            return response()->json($data,200);
        }
    }
    public function pinmemo(Request $request) {
        if (request()->ajax()) {
            $inquery = Inquery::find($request->memoid);
            $inquery->created_at = date('Y-m-d H:i:s');
            $inquery->save();
            return response()->json(['status' => 'success'],200);
        }
    }
}
