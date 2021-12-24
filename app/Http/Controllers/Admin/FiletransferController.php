<?php

namespace App\Http\Controllers\Admin;

use DB;
use Auth;
use Session;
use Validator;
use Carbon\Carbon;
use App\Models\City;
use App\Models\User;
use App\Models\Level;
use App\Models\Stock;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Routeknown;
use App\Http\Start\Helpers;
use App\Models\Stockbroker;
use App\Models\Filetransfer;
use App\Models\Customergroup;
use App\Models\CustomerStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Feedhistory;


class FiletransferController extends Controller
{
    protected $helper; // Global variable for instance of Helpers
    
    public function __construct()
    {
        $this->helper = new Helpers;
    }

    public function index(){
        if (request()->ajax()) {
            $filetransfers = Filetransfer::join('companies', 'filetransfers.companyId', '=', 'companies.id')
            ->join('customers', 'customers.id', '=', 'filetransfers.userId')
            ->orderBy('filetransfers.date', 'DESC')
            ->select([
                'filetransfers.id',
                DB::raw("DATE_FORMAT(filetransfers.date, '%Y.%m.%d') as date"),
                'customers.name',
                'customers.email',
                'customers.phonenumber1',
                'companies.companyName',
                'filetransfers.companyId',
                'filetransfers.fileName',
                'customers.customerGroupID',
                'customers.routesOfKnownID',
                'customers.id as customersID',
                'filetransfers.method',
                'filetransfers.createdBy',
                'filetransfers.userId',
            ]);
            if (request()->has('group_filter')) {
                $group_filter = request()->get('group_filter');
                if (!empty($group_filter)) {
                    $filetransfers->where('customers.customerGroupID', $group_filter);
                }
            }
            
            if (request()->has('company_filter')) {
                $company_filter = request()->get('company_filter');
                if (!empty($company_filter)) {

                    $filetransfers->where('filetransfers.companyId', $company_filter);
                    
                }
            }
            if (request()->has('route_filter')) {
                $route_filter = request()->get('route_filter');
                if (!empty($route_filter)) {
                    $filetransfers->where('customers.routesOfKnownID', $route_filter);
                }
            }

            if (request()->has('desksearch')) {
                $desksearch = request()->get('desksearch');
                if (!empty($desksearch)) {
                    $emailcheck = strpos($desksearch, '@');
                    if($emailcheck !== false) {
                        $filetransfers->where('customers.email', $desksearch);
                    } else if ($desksearch){
                        $filetransfers->where('customers.phonenumber1', 'like', '%' . $desksearch . '%');
                        $filetransfers->orWhere('customers.name', 'like', '%' . $desksearch . '%');
                    } 
                }
            }

            if (request()->has('mobilesearch')) {
                $mobilesearch = request()->get('mobilesearch');
                if (!empty($mobilesearch)) {
                    $emailcheck = strpos($mobilesearch, '@');
                    if($emailcheck !== false) {
                        $filetransfers->where('customers.email', $mobilesearch);
                    } else if ($mobilesearch) {
                        $filetransfers->where('customers.phonenumber1', 'like', '%'. $mobilesearch . '%');
                        $filetransfers->orWhere('customers.name', 'like', '%' . $mobilesearch . '%');
                    } 
                }
            }
            return Datatables::of($filetransfers)
                ->addColumn('action', function($row) {
                    return '<a href="'.url('admin/edit_customer/'.$row->userId).'" class="btn btn-sm btn-primary"><i class="mdi mdi-eye-circle-outline"></i></a>';
                })
                ->addColumn('mass_delete', function($row) {
                    
                    return '<input type="checkbox" class="form-check-input" value="'.$row->id.'" />';
                })
                ->editColumn('method', function ($row) {
                    $method = $row->method;
                    if ($method == "Email") {
                        $method_name = '<a href="javascript:void(0);" class="btn btn-success waves-effect waves-light btn_method" data-id="'.$row->id.'" data-method="'.$row->method.'">이메일</a>';
                    } else if ($method == "Post") {
                        $method_name = '<a href="javascript:void(0);" class="btn btn-primary waves-effect waves-light btn_method" data-id="'.$row->id.'" data-method="'.$row->method.'">우편</a>';
                    } else if ($method == "SMS") {
                        $method_name = '<a href="javascript:void(0);" class="btn btn-info waves-effect waves-light btn_method" data-id="'.$row->id.'" data-method="'.$row->method.'">SMS</a>';
                    } else if ($method == "Messenger") {
                        $method_name = '<a href="javascript:void(0);" class="btn btn-secondary waves-effect waves-light btn_method" data-id="'.$row->id.'" data-method="'.$row->method.'">카카오톡</a>';
                    }
                    return $method_name;
                })
                ->editColumn('name', function ($row) {
                    $name = $row->name;
                    return '<a href="'.url('admin/user-record/edit_file_transfer/'.$row->id).'">'.$name.'</a>';
                })
                ->addColumn('admin', function($row) {
                    $admin = User::where('id', $row->createdBy)->first();
                    return $admin->name;
                })
                ->rawColumns(['action','name', 'admin', 'mass_delete', 'method'])
                ->make(true);
        }
        $groups = Customergroup::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
        $companies = Company::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
        $routeknowns = RouteKnown::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
        return view('admin.user-records.file-transfers.index')->with(compact('groups', 'companies', 'routeknowns'));
    }

    public function add(Request $request) {
        if(!$_POST) {
            $companies = Company::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
            $customers = Customer::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
            return view('admin.user-records.file-transfers.add')->with(compact('companies', 'customers'));
        } 
        else if ($request->submit) {
            $rules = array(
                'date' => 'required',
                'company'  => 'required',
                'method' => 'required',
                'fileName'  => 'required',
                'customer'  => 'required',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } 
            else {
                $filetransfer = new Filetransfer;
                $filetransfer->date = Carbon::createFromFormat('Y.m.d', $request->date)->format('Y-m-d');
                $filetransfer->companyId = $request->company;
                $filetransfer->method = $request->method;
                $filetransfer->fileName = $request->fileName;
                $filetransfer->userId = $request->customer;
                $filetransfer->createdBy = Auth::guard('admin')->user()->id;
                $filetransfer->save();

                //feed history add
                $feedhistory = new Feedhistory;
                $feedhistory->feedname = "File Transfer";
                $feedhistory->customerId = $request->customer;
                $feedhistory->createdBy = Auth::guard('admin')->user()->id;
                $feedhistory->save();

                $this->helper->flash_message('success', 'Added Successfully'); 

                return redirect('admin/user-record/file-transfers');
            }
        }
        else {
            return redirect('admin/user-record/file-transfers');
        }
    }

    public function update(Request $request) {
        if(!$_POST) {
            $companies = Company::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
            $customers = Customer::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
            $filetrans = Filetransfer::find($request->id);
            return view('admin.user-records.file-transfers.edit')->with(compact('companies', 'customers', 'filetrans'));
        } 
        else if ($request->submit) {
            $rules = array(
                'date' => 'required',
                'company'  => 'required',
                'method' => 'required',
                'fileName'  => 'required',
                'customer'  => 'required',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } 
            else {
                $filetransfer = Filetransfer::find($request->id);
                $filetransfer->date = Carbon::createFromFormat('Y.m.d', $request->date)->format('Y-m-d');
                $filetransfer->companyId = $request->company;
                $filetransfer->method = $request->method;
                $filetransfer->fileName = $request->fileName;
                $filetransfer->userId = $request->customer;
                $filetransfer->createdBy = Auth::guard('admin')->user()->id;
                $filetransfer->save();
                $this->helper->flash_message('success', 'Added Successfully'); 

                return redirect('admin/user-record/file-transfers');
            }
        }
        return redirect('admin/user-record/file-transfers');
    }
    public function methodchange(Request $request) {
        if (request()->ajax()) {
            $rules = array(
                'fileid'=>'required',
                'method'=>'required'
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput(); // Form calling with Errors and Input values
            } else {
                $filetransfer = Filetransfer::find($request->fileid);
                $filetransfer->method = $request->method;
                $filetransfer->save();
                return response()->json(['status' => 'Success'],201);
            }
        }
    }

    public function newcompany(Request $request) {
        if (request()->ajax()) {
            $rules = array(
                'company'=>'required'
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput(); // Form calling with Errors and Input values
            } else {
                $company = new Company;
                $company->companyName = $request->company;
                $company->isActive = "Y";
                $company->createdBy = Auth::guard('admin')->user()->id;
                $company->save();
                return response()->json(['status' => 'Success', 'id'=> $company->id, 'companyName'=>$company->companyName],201);
            }
        }
    }

    public function newcity(Request $request) {
        if(request()->ajax()){
            //Start Validation
            $messages = [
                'cityName.required'  => 'City name field is required.',
            ];
            $validator = Validator::make($request->all(), [
                'cityName'   => 'required',
            ],$messages);
            if ($validator->fails()) {
                return response()->json(['error'=>$validator->errors()], 401);            
            } 
            //end Validation

            $city               = $request->type_id > 0 ? City::find($request->type_id) : new City;
            $city->cityName     = $request->cityName;
            $city->isDelete     = "N";
            $city->createdBy    = Auth::guard('admin')->user()->id;
            $city->save();
            return response()->json([
                'success'   => true,
                'message'   => $request->type_id > 0 ? 'City has been updated.' : 'City has been created.' 
                //'id'        => $city->id, 
                //'cityName'  => $city->cityName
            ],201);
        }
    }

    public function newgroup(Request $request) {
        if (request()->ajax()) {
            //Start Validation
            $messages = [
                'groupName.required'  => 'Agent name field is required.',
            ];
            $validator = Validator::make($request->all(), [
                'groupName'   => 'required',
            ],$messages);
            if ($validator->fails()) {
                return response()->json(['error'=>$validator->errors()], 401);            
            } 
            //end Validation

            $group = $request->type_id > 0 ? Customergroup::find($request->type_id) : new Customergroup;
            $group->groupName = $request->groupName;
            $group->isActive = "Y";
            $group->createdBy = Auth::guard('admin')->user()->id;
            $group->save();
            return response()->json([
                'success'   => true,
                'message'   => $request->type_id > 0 ? 'Agent has been updated.' : 'Agent has been created.' 
            ],201);
        }
    }

    public function newLevel(Request $request) {
        if (request()->ajax()) {
            //Start Validation
            $messages = [
                'levelName.required'  => 'Level field is required.',
            ];
            $validator = Validator::make($request->all(), [
                'levelName'   => 'required',
            ],$messages);
            if ($validator->fails()) {
                return response()->json(['error'=>$validator->errors()], 401);            
            } 
            //end Validation

            $level = $request->type_id > 0 ? Level::find($request->type_id) : new Level;
            $level->levelName = $request->levelName;
            $level->isActive = "Y";
            $level->createdBy = Auth::guard('admin')->user()->id;
            $level->save();
            return response()->json([
                'success'   => true,
                'message'   => $request->type_id > 0 ? 'Level has been updated.' : 'Level has been created.' 
            ],201);
        }
    }

    public function newCustomerStatus(Request $request) {
        if (request()->ajax()) {
            //Start Validation
            $messages = [
                'statusName.required'  => 'Status field is required.',
            ];
            $validator = Validator::make($request->all(), [
                'statusName'   => 'required',
            ],$messages);
            if ($validator->fails()) {
                return response()->json(['error'=>$validator->errors()], 401);            
            } 
            //end Validation

            $customerStatus = $request->type_id > 0 ? CustomerStatus::find($request->type_id) : new CustomerStatus;
            $customerStatus->statusName = $request->statusName;
            $customerStatus->save();
            return response()->json([
                'success'   => true,
                'message'   => $request->type_id > 0 ? 'Status has been updated.' : 'Status has been created.' 
            ],201);
        }
    }

    public function newstock(Request $request) {
        if (request()->ajax()) {
           //Start Validation
            $messages = [
                'brokerName.required'  => 'Stock broker name field is required.',
            ];
            $validator = Validator::make($request->all(), [
                'brokerName'   => 'required',
            ],$messages);
            if ($validator->fails()) {
                return response()->json(['error'=>$validator->errors()], 401);            
            } 
            //end Validation

            $broker = $request->type_id > 0 ? Stockbroker::find($request->type_id) : new Stockbroker;
            $broker->brokerName = $request->brokerName;
            $broker->isDelete = "N";
            $broker->createdBy = Auth::guard('admin')->user()->id;
            $broker->save();
            return response()->json([
                'success'   => true,
                'message'   => $request->type_id > 0 ? 'Stock broker has been updated.' : 'Stock broker has been created.' 
            ],201);
        }
    }

    public function newroute(Request $request) {
        if (request()->ajax()) {
            //Start Validation
            $messages = [
                'routeName.required'  => 'Route name field is required.',
            ];
            $validator = Validator::make($request->all(), [
                'routeName'   => 'required',
            ],$messages);
            if ($validator->fails()) {
                return response()->json(['error'=>$validator->errors()], 401);            
            } 
            //end Validation

            $route = $request->type_id > 0 ? Routeknown::find($request->type_id) : new Routeknown;
            $route->routeName = $request->routeName;
            $route->isActive = "Y";
            $route->createdBy = Auth::guard('admin')->user()->id;
            $route->save();
            return response()->json([
                'success'   => true,
                'message'   => $request->type_id > 0 ? 'Route has been updated.' : 'Route has been created.' 
            ],201);
        }
    }


    public function cityDelete(Request $request, $id) {
        if (request()->ajax()) {
            $city = City::find($request->id);
            $city->delete();
            return response()->json([
                'success'   => true,
                'message'   => 'City has been deleted.' 
            ],201);
        }
    }

    public function groupDelete(Request $request, $id) {
        if (request()->ajax()) {
            $group = Customergroup::find($request->id);
            $group->delete();
            return response()->json([
                'success'   => true,
                'message'   => 'Agent has been deleted.' 
            ],201);
        }
    }

    public function brokerDelete(Request $request, $id) {
        if (request()->ajax()) {
            $broker = Stockbroker::find($request->id);
            $broker->delete();
            return response()->json([
                'success'   => true,
                'message'   => 'Stock broker has been deleted.' 
            ],201);
        }
    }

    public function routeDelete(Request $request, $id) {
        if (request()->ajax()) {
            $route = Routeknown::find($request->id);
            $route->delete();
            return response()->json([
                'success'   => true,
                'message'   => 'Route known has been deleted.' 
            ],201);
        }
    }

    public function levelDelete(Request $request, $id) {
        if (request()->ajax()) {
            $route = Level::find($request->id);
            $route->delete();
            return response()->json([
                'success'   => true,
                'message'   => 'Level has been deleted.' 
            ],201);
        }
    }

    public function statusDelete(Request $request, $id) {
        if (request()->ajax()) {
            $customerStatus = CustomerStatus::find($request->id);
            $customerStatus->delete();
            return response()->json([
                'success'   => true,
                'message'   => 'Status has been deleted.' 
            ],201);
        }
    }

    public function deleteAllCity(Request $request) {
        $ids = $request->city_id;
        foreach($ids as $id){
            $city = City::find($id);
            $city->delete();
        }
        $this->helper->flash_message('success', 'Cities has been deleted auccessfully'); 
        return redirect()->back();
    }

    public function deleteAllLevel(Request $request) {
        $ids = $request->level_id;
        foreach($ids as $id){
            $level = Level::find($id);
            $level->delete();
        }
        $this->helper->flash_message('success', 'Levels has been deleted auccessfully'); 
        return redirect()->back();
    }

    public function deleteAllStatus(Request $request) {
        $ids = $request->status_id;
        foreach($ids as $id){
            $customerStatus = CustomerStatus::find($id);
            $customerStatus->delete();
        }
        $this->helper->flash_message('success', 'Statuses has been deleted auccessfully'); 
        return redirect()->back();
    }

    public function deleteAllAgent(Request $request) {
        $ids = $request->agent_id;
        foreach($ids as $id){
            $customergroup = Customergroup::find($id);
            $customergroup->delete();
        }
        $this->helper->flash_message('success', 'Agents has been deleted auccessfully'); 
        return redirect()->back();
    }

    public function deleteAllStock(Request $request) {
        $ids = $request->stockbroker_id;
        foreach($ids as $id){
            $stockbroker = Stockbroker::find($id);
            $stockbroker->delete();
        }
        $this->helper->flash_message('success', 'Stock brokers has been deleted auccessfully'); 
        return redirect()->back();
    }

    public function deleteAllRouteknown(Request $request) {
        $ids = $request->routeknown_id;
        foreach($ids as $id){
            $routeknown = Routeknown::find($id);
            $routeknown->delete();
        }
        $this->helper->flash_message('success', 'Routes known has been deleted auccessfully'); 
        return redirect()->back();
    }

    public function massDestroy(Request $request) {
        if (!empty($request->input('selected_rows'))) {
            $selected_rows = explode(',', $request->input('selected_rows'));
            $files = Filetransfer::whereIn('id', $selected_rows)->delete();
        }
        return redirect()->back();
    }
}
