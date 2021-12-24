<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Validator;
use Session;
use Carbon\Carbon;
use App\Models\Routeknown;
use App\Models\Customergroup;
use App\Models\Company;
use App\Models\Customer;
use App\Http\Start\Helpers;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Visitrecord;
use App\Models\Feedhistory;
use App\Models\Visitcustomer;
use App\Models\User;
use App\Models\Stock;

class VisitrecordController extends Controller
{
    protected $helper; // Global variable for instance of Helpers
    
    public function __construct()
    {
        $this->helper = new Helpers;
    }

    public function index() {
        if (request()->ajax()) {
            $visitrecords = Visitrecord::join('visitcustomers', 'visitrecords.id', '=', 'visitcustomers.visitId')
            ->join('customers', 'visitcustomers.customerId', '=', 'customers.id')
            ->orderBy('visitrecords.startdate', 'DESC')
            ->select(['visitrecords.id',
                DB::raw("DATE_FORMAT(visitrecords.startdate, '%Y.%m.%d') as startdate"),
                DB::raw("DATE_FORMAT(visitrecords.enddate, '%Y.%m.%d') as enddate"),
                'customers.name',
                'customers.email',
                'customers.phonenumber1',
                'customers.customerGroupID',
                'customers.routesOfKnownID',
                'customers.id as customersID',
                'visitrecords.title',
                'visitrecords.starttime',
                'visitrecords.endtime',
                'visitcustomers.status',
                'visitrecords.createdBy',
                'visitrecords.type',
                'visitrecords.note',
            ]);
            if (request()->has('group_filter')) {
                $group_filter = request()->get('group_filter');
                if (!empty($group_filter)) {
                    $visitrecords->where('customers.customerGroupID', $group_filter);
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
                    $visitrecords->whereIn('customers.id', $companyid);
                    
                }
            }
            if (request()->has('route_filter')) {
                $route_filter = request()->get('route_filter');
                if (!empty($route_filter)) {
                    $visitrecords->where('customers.routesOfKnownID', $route_filter);
                }
            }
            if (request()->has('desksearch')) {
                $desksearch = request()->get('desksearch');
                if (!empty($desksearch)) {
                    $emailcheck = strpos($desksearch, '@');
                    if($emailcheck !== false) {
                        $visitrecords->where('customers.email', $desksearch);
                    } else if ($desksearch){
                        $visitrecords->where('customers.phonenumber1', 'like', '%' . $desksearch . '%');
                        $visitrecords->orWhere('customers.name', 'like', '%' . $desksearch . '%');
                    } 
                }
            }

            if (request()->has('mobilesearch')) {
                $mobilesearch = request()->get('mobilesearch');
                if (!empty($mobilesearch)) {
                    $emailcheck = strpos($mobilesearch, '@');
                    if($emailcheck !== false) {
                        $visitrecords->where('customers.email', $mobilesearch);
                    } else if ($mobilesearch) {
                        $visitrecords->where('customers.phonenumber1', 'like', '%'. $mobilesearch . '%');
                        $visitrecords->orWhere('customers.name', 'like', '%' . $mobilesearch . '%');
                    } 
                }
            }

            return Datatables::of($visitrecords)
                ->addColumn('action', function($row) {
                    return '<a href="'.url('admin/edit_customer/'.$row->userId).'" class="btn btn-sm btn-primary"><i class="mdi mdi-eye-circle-outline"></i></a>';
                })
                ->addColumn('mass_delete', function($row) {
                
                    return '<input type="checkbox" class="form-check-input" value="'.$row->id.'" />';
                })
                ->editColumn('name', function ($row) {
                    $name = $row->name;
                    return '<a href="'.url('admin/user-record/edit_visit_record/'.$row->id).'">'.$name.'</a>';
                })
                ->editColumn('type', function ($row) {
                    $type_name = $row->type;
                    if($type_name == "T") {
                        $type = "Time";
                    } else if ($type_name == "A") {
                        $type = "All Day";
                    } else if ($type_name == "E") {
                        $type = "Exact";
                    } 
                    return $type;
                })
                ->editColumn('status', function ($row) {
                    $status = $row->status;
                    $status_name = '';
                    if ($status == "Active") {
                        $status_name = '<a href="javascript:void(0);" class="btn btn-success waves-effect waves-light btn_status" data-status="'.$row->status.'" data-id="'.$row->id.'">완료</a>';
                    } else if ($status == "Pending") {
                        $status_name = '<a href="javascript:void(0);" class="btn btn-primary waves-effect waves-light btn_status" data-id="'.$row->id.'" data-status="'.$row->status.'">진행중</a>';
                    } else if ($status == "Canceled") {
                        $status_name = '<a href="javascript:void(0);" class="btn btn-danger waves-effect waves-light btn_status" data-id="'.$row->id.'" data-status="'.$row->status.'">취소</a>';
                    }
                    return $status_name;
                })
                ->addColumn('admin', function($row) {
                    $admin = User::where('id', $row->createdBy)->first();
                    return $admin->name;
                })
                ->rawColumns(['action','name', 'admin', 'mass_delete', 'status'])
                ->make(true);
        }
        $groups = Customergroup::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
        $companies = Company::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
        $routeknowns = RouteKnown::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
        return view('admin.user-records.visit-record.index')->with(compact('groups', 'companies', 'routeknowns'));
    }
    public function add(Request $request) {

        if(!$_POST) {
            $customers = Customer::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
            return view('admin.user-records.visit-record.add')->with(compact('customers'));

        }else if ($request->submit) {
            $rules = array(
                'startdate' => 'required',
                'title'  => 'required',
                'visit_status' => 'required',
                'customer'  => 'required',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'error' => $validator->errors()->all()],201);
            } 
            else {
                //dd($request->all());
                $visitrecord = new Visitrecord;
                $visitrecord->startdate = Carbon::createFromFormat('Y.m.d', $request['startdate'])->format('Y-m-d');
                if ($request->type == "E") {
                    $visitrecord->enddate = null;
                } else {
                    $visitrecord->enddate = Carbon::createFromFormat('Y.m.d', $request['enddate'])->format('Y-m-d');
                }
                
                $visitrecord->title     = $request['title'];
                $visitrecord->note      = $request['note'];
                $visitrecord->starttime = $request['starttime'];
                $visitrecord->endtime   = $request['endtime'];
                $visitrecord->backgroundColor   = $request['backgroundColor'];
                $visitrecord->borderColor       = $request['backgroundColor'];
                $visitrecord->type              = $request['type'];
                    
                $visitrecord->createdBy = Auth::guard('admin')->user()->id;
                $visitrecord->save();

                if($request->customer != null){
                    $finalArray = array();
                    foreach($request->customer as $key=>$value) {
                        array_push($finalArray, array(
                            'visitId'    => $visitrecord->id,
                            'customerId' => $value,
                            'status'     => $request->visit_status
                        ));
                        //dd($finalArray);
                    };
                    Visitcustomer::insert($finalArray);
                }

                //feed history add
                /*$feedhistory                = new Feedhistory;
                $feedhistory->feedname      = "Visit Record";
                $feedhistory->customerId    = $request->customer;
                $feedhistory->createdBy     = Auth::guard('admin')->user()->id;
                $feedhistory->save();*/

                $this->helper->flash_message('success', 'Added Successfully'); 

                return redirect('admin/user-record/visit-record');
            }
        }
        else {
            return redirect('admin/user-record/visit-record')->with(compact('customers'));
        }
    }
    public function update(Request $request) {
        if(!$_POST) {
            $customers = Customer::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
            $visitrecord = Visitrecord::find($request->id);
            $finalArray = array();
            if($visitrecord->customer->count() > 0){
                foreach($visitrecord->customer as $key=>$value) {
                    $finalArray[] = $value->customerId;
                };
            }
            return view('admin.user-records.visit-record.edit')->with(compact('customers', 'visitrecord', 'finalArray'));
        
        }else if ($request->submit) {
            $rules = array(
                'startdate' => 'required',
                'title'  => 'required',
                'visit_status' => 'required',
                'customer'  => 'required',
            );
            
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }else {
                $visitrecord = Visitrecord::find($request->id);
                $visitrecord->startdate = Carbon::createFromFormat('Y.m.d', $request->startdate)->format('Y-m-d');
                if ( $request->type == "E") {
                    $visitrecord->enddate = null;
                } else {
                    $visitrecord->enddate = Carbon::createFromFormat('Y.m.d', $request->enddate)->format('Y-m-d');
                }
                
                $visitrecord->title             = $request->title;
                $visitrecord->note              = $request->note;
                $visitrecord->starttime         = $request->starttime;
                $visitrecord->endtime           = $request->endtime;
                $visitrecord->backgroundColor   = $request->backgroundColor;
                $visitrecord->borderColor       = $request->backgroundColor;
                $visitrecord->type              = $request->type;
                $visitrecord->createdBy         = Auth::guard('admin')->user()->id;
                $visitrecord->save();
                if($request->customer != null){
                    foreach($request->customer as $key=>$value) {
                        $visitstatus = Visitcustomer::where('visitId','=', $request->id)->where('customerId','=', $value)->first();
                        $visitstatus->visitId = $visitrecord->id;
                        $visitstatus->customerId = $value;
                        $visitstatus->status = $request->visit_status;
                        $visitstatus->save();
                    };
                } 
                $this->helper->flash_message('success', 'Updated Successfully'); 

                return redirect('admin/user-record/visit-record');
            }
        }
        else {
            return redirect('admin/user-record/visit-record')->with(compact('customers'));
        }
    }

    public function statuschange(Request $request) {
        if (request()->ajax()) {
            $rules = array(
                'visitid'=>'required',
                'status'=>'required'
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput(); // Form calling with Errors and Input values
            } else {
                $visit = Visitrecord::find($request->visitid);
                $visit->status = $request->status;
                $visit->save();
                return response()->json(['status' => 'Success'],201);
            }

        }
    }
    public function massDestroy(Request $request) {
        
        if (!empty($request->input('selected_rows'))) {
            $selected_rows = explode(',', $request->input('selected_rows'));
            $visits = Visitrecord::whereIn('id', $selected_rows)->delete();
        }
        

        return redirect()->back();
    }
}
