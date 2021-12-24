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
use App\Models\City;
use App\Models\User;
use App\Models\Customer;
use App\Models\Postdelivery;
use App\Http\Start\Helpers;
use App\Models\Feedhistory;
use App\Models\Stock;
use Yajra\DataTables\Facades\DataTables;

class PostdeliveryController extends Controller
{
    protected $helper; // Global variable for instance of Helpers
    
    public function __construct()
    {
        $this->helper = new Helpers;
    }

    public function index() {
        if (request()->ajax()) {
            $postdeliveries = Postdelivery::join('companies', 'postdeliveries.companyId', '=', 'companies.id')
            ->join('customers', 'customers.id', '=', 'postdeliveries.userId')
            ->orderBy('postdeliveries.date', 'DESC')
            ->select(['postdeliveries.id',
                DB::raw("DATE_FORMAT(postdeliveries.date, '%Y.%m.%d') as date"),
                'customers.name',
                'customers.email',
                'customers.phonenumber1',
                'companies.companyName',
                'postdeliveries.cityId',
                'postdeliveries.companyId',
                'customers.customerGroupID',
                'customers.routesOfKnownID',
                'customers.id as customersID',
                'postdeliveries.status',
                'postdeliveries.address', 
                'postdeliveries.userId', 
                'postdeliveries.createdBy'
            ]);
            if (request()->has('group_filter')) {
                $group_filter = request()->get('group_filter');
                if (!empty($group_filter)) {
                    $postdeliveries->where('customers.customerGroupID', $group_filter);
                }
            }
            
            if (request()->has('company_filter')) {
                $company_filter = request()->get('company_filter');
                if (!empty($company_filter)) {
                    
                    $postdeliveries->where('postdeliveries.companyId', $company_filter);
                    
                }
            }
            if (request()->has('route_filter')) {
                $route_filter = request()->get('route_filter');
                if (!empty($route_filter)) {
                    $postdeliveries->where('customers.routesOfKnownID', $route_filter);
                }
            }
            if (request()->has('desksearch')) {
                $desksearch = request()->get('desksearch');
                if (!empty($desksearch)) {
                    $emailcheck = strpos($desksearch, '@');
                    if($emailcheck !== false) {
                        $postdeliveries->where('customers.email', $desksearch);
                    } else if ($desksearch){
                        $postdeliveries->where('customers.phonenumber1', 'like', '%' . $desksearch . '%');
                        $postdeliveries->orWhere('customers.name', 'like', '%' . $desksearch . '%');
                    } 
                }
            }

            if (request()->has('mobilesearch')) {
                $mobilesearch = request()->get('mobilesearch');
                if (!empty($mobilesearch)) {
                    $emailcheck = strpos($mobilesearch, '@');
                    if($emailcheck !== false) {
                        $postdeliveries->where('customers.email', $mobilesearch);
                    } else if ($mobilesearch) {
                        $postdeliveries->where('customers.phonenumber1', 'like', '%'. $mobilesearch . '%');
                        $postdeliveries->orWhere('customers.name', 'like', '%' . $mobilesearch . '%');
                    } 
                }
            }
            return Datatables::of($postdeliveries)
                ->addColumn('action', function($row) {
                    return '<a href="'.url('admin/edit_customer/'.$row->userId).'" class="btn btn-sm btn-primary"><i class="mdi mdi-eye-circle-outline"></i></a>';
                })
                ->addColumn('mass_delete', function($row) {
                
                    return '<input type="checkbox" class="form-check-input" value="'.$row->id.'" />';
                })
                ->editColumn('city', function ($row) {
                    $city = City::where('id', $row->cityId)->first();
                    return $city->cityName;
                })
                ->editColumn('status', function ($row) {
                    $status = $row->status;
                    if ($status == "Delivered") {
                        $status_name = '<a href="javascript:void(0);" class="btn btn-success waves-effect waves-light btn_status" data-status="'.$row->status.'" data-id="'.$row->id.'">발송완료</a>';
                    } else if ($status == "Pending") {
                        $status_name = '<a href="javascript:void(0);" class="btn btn-primary waves-effect waves-light btn_status" data-status="'.$row->status.'" data-id="'.$row->id.'">발송중</a>';
                    } else if ($status == "Returned") {
                        $status_name = '<a href="javascript:void(0);" class="btn btn-secondary waves-effect waves-light btn_status" data-status="'.$row->status.'" data-id="'.$row->id.'">반송됨</a>';
                    } else if ($status == "Canceled") {
                        $status_name = '<a href="javascript:void(0);" class="btn btn-danger waves-effect waves-light btn_status" data-status="'.$row->status.'" data-id="'.$row->id.'">취소</a>';
                    }
                    return $status_name;
                })
                ->editColumn('name', function ($row) {
                    $name = $row->name;
                    return '<a href="'.url('admin/user-record/edit_post_delivery/'.$row->id).'">'.$name.'</a>';
                })
                ->addColumn('admin', function($row) {
                    $admin = User::where('id', $row->createdBy)->first();
                    return $admin->name;
                })
                ->rawColumns(['action','name', 'admin', 'mass_delete', 'city', 'status'])
                ->make(true);
        }
        $groups = Customergroup::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
        $companies = Company::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
        $routeknowns = RouteKnown::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
        return view('admin.user-records.post-delivery.index')->with(compact('groups', 'companies', 'routeknowns'));
    }

    public function add(Request $request) {
        if(!$_POST) {
            $companies = Company::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
            $cities = City::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
            $customers = Customer::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
            return view('admin.user-records.post-delivery.add')->with(compact('companies', 'customers', 'cities'));
        } 
        else if ($request->submit) {
            $rules = array(
                'date' => 'required',
                'company'  => 'required',
                'city' => 'required',
                'post_status' => 'required',
                'customer'  => 'required',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } 
            else {
                $postdelivery = new Postdelivery;
                $postdelivery->date = Carbon::createFromFormat('Y.m.d', $request->date)->format('Y-m-d');
                $postdelivery->companyId = $request->company;
                $postdelivery->cityId = $request->city;
                $postdelivery->address = $request->upostaddress;
                $postdelivery->status = $request->post_status;
                $postdelivery->userId = $request->customer;
                $postdelivery->createdBy = Auth::guard('admin')->user()->id;
                $postdelivery->save();

                //feed history add
                $feedhistory = new Feedhistory;
                $feedhistory->feedname = "Post Delivery";
                $feedhistory->customerId = $request->customer;
                $feedhistory->createdBy = Auth::guard('admin')->user()->id;
                $feedhistory->save();

                $this->helper->flash_message('success', 'Added Successfully'); 

                return redirect('admin/user-record/post-delivery');
            }
        }
        else {
            return redirect('admin/user-record/post-delivery');
        }
    }
    public function update(Request $request) {
        if(!$_POST) {
            $companies = Company::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
            $cities = City::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
            $customers = Customer::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
            $postdelivery = Postdelivery::find($request->id);
            return view('admin.user-records.post-delivery.edit')->with(compact('companies', 'customers', 'cities', 'postdelivery'));
        } 
        else if ($request->submit) {
            $rules = array(
                'date' => 'required',
                'company'  => 'required',
                'city' => 'required',
                'post_status' => 'required',
                'customer'  => 'required',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } 
            else {
                $postdelivery = Postdelivery::find($request->id);
                $postdelivery->date = Carbon::createFromFormat('Y.m.d', $request->date)->format('Y-m-d');
                $postdelivery->companyId = $request->company;
                $postdelivery->cityId = $request->city;
                $postdelivery->address = $request->upostaddress;
                $postdelivery->status = $request->post_status;
                $postdelivery->userId = $request->customer;
                $postdelivery->createdBy = Auth::guard('admin')->user()->id;
                $postdelivery->save();
                $this->helper->flash_message('success', 'Post delivery has been updated'); 

                return redirect('admin/user-record/post-delivery');
            }
        }
        else {
            return redirect('admin/user-record/post-delivery');
        }
    }

    public function statuschange(Request $request) {
        if (request()->ajax()) {
            $rules = array(
                'postid'=>'required',
                'status'=>'required'
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput(); // Form calling with Errors and Input values
            } else {
                $post = Postdelivery::find($request->postid);
                $post->status = $request->status;
                $post->save();
                return response()->json(['status' => 'Success'],201);
            }

        }
    }
    public function massDestroy(Request $request) {
        
        if (!empty($request->input('selected_rows'))) {
            $selected_rows = explode(',', $request->input('selected_rows'));
            $postdelivery = Postdelivery::whereIn('id', $selected_rows)->delete();
        }
        

        return redirect()->back();
    }
}
