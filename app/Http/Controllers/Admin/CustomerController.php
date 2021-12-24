<?php

namespace App\Http\Controllers\Admin;

use DB;
use Auth;
use Session;
use Validator;
use Carbon\Carbon;
use App\Models\City;
use App\Models\Level;
use App\Models\User;
use App\Models\Stock;
use App\Models\Company;
use App\Models\Inquery;
use App\Models\Customer;
use App\Models\Routeknown;
use App\Http\Start\Helpers;
use App\Models\Visitrecord;
use App\Models\Stockbroker;
use App\Models\Postdelivery;
use App\Models\Filetransfer;
use App\Models\Customergroup;
use App\Models\Visitcustomer;
use App\Models\CustomerStatus;
use App\Imports\CustomerImport;
use App\Exports\CustomerExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller
{
    protected $helper; // Global variable for instance of Helpers
    
    public function __construct()
    {
        $this->helper = new Helpers;
    }

    public function cutomerImport(Request $request){
        if(request()->isMethod('post') && $request->ajax()){
            $validator = Validator::make($request->all(), [
                'file' => 'required',
                //'file' => 'required|mimes:csv',
            ],[
                'required'=>'Please choose import file',
                'mimes'=>'Please choose only Excel Files'
            ]);
            if ($validator->fails()) {
                return response()->json(['error'=>$validator->errors()], 401);
            }
            Excel::import(new CustomerImport,request()->file('file'));
            return response()->json([
                'success' => true,
                'message'   =>'customer excel sheet import successfully.'
            ]);
        }else{
            return view('admin.customers');
        }
    }

    public function cutomerExport(Request $request){
        $collection = Customer::select('customers.*');
        $collection->orderBy('id','DESC');
        $customers = $collection->get();
        return Excel::download(new CustomerExport($customers), 'customers_.'.time().'.xlsx');
    }

    public function index(Request $request) {
        if (request()->ajax()) {
            $customer = Customer::leftjoin('cities', 'cities.id', '=', 'customers.city_id')
            ->leftjoin('customer_statuses', 'customer_statuses.id', '=', 'customers.status_id')
            ->orderBy('customers.id', 'DESC')
            ->select(['customers.id',
            DB::raw("DATE_FORMAT(customers.date, '%Y.%m.%d') as date"),'customers.name','customers.phonenumber1',
            /*DB::raw('(CASE 
                WHEN customers.gender = "M" THEN "Male" 
                WHEN customers.gender = "F" THEN "Female" 
                ELSE "Other" 
                END) AS gender'),*/
            'customers.city_id','customers.age', 'cities.cityName', 'customers.customerGroupID', 'customers.email', 'customers.routesOfKnownID', 'customers.level', 'customer_statuses.statusName as status_id']);

            if (request()->has('desksearch')) {
                $desksearch = request()->get('desksearch');
                if (!empty($desksearch)) {
                    $emailcheck = strpos($desksearch, '@');
                    if($emailcheck !== false) {
                        $customer->where('customers.email', $desksearch);
                    } else if ($desksearch){
                        $customer->where('customers.phonenumber1', 'like', '%' . $desksearch . '%');
                        $customer->orWhere('customers.name', 'like', '%' . $desksearch . '%');
                    } 
                }
            }

            if (request()->has('mobilesearch')) {
                $mobilesearch = request()->get('mobilesearch');
                if (!empty($mobilesearch)) {
                    $emailcheck = strpos($mobilesearch, '@');
                    if($emailcheck !== false) {
                        $customer->where('customers.email', $mobilesearch);
                    } else if ($mobilesearch) {
                        $customer->where('customers.phonenumber1', 'like', '%'. $mobilesearch . '%');
                        $customer->orWhere('customers.name', 'like', '%' . $mobilesearch . '%');
                    } 
                }
            }
            
            if (!empty(request()->start_date1) && !empty(request()->end_date1)) {
                $start  = request()->start_date1;
                $end    =  request()->end_date1;
                $stocks = Stock::whereDate('date', '>=', $start)->whereDate('date', '<=', $end)->get();

                $userId = array();
                foreach ($stocks as $key => $value) {
                    array_push($userId, $value['userId']);
                }
                $customer->whereIn('customers.id', $userId);

            }

            if (request()->has('year_of_investment')) {
                $year_of_investment = request()->get('year_of_investment');
                if (!empty($year_of_investment)) {
                    $stocks = Stock::whereYear('created_at', $year_of_investment)->get();
                    $userId = array();
                    foreach ($stocks as $key => $value) {
                        array_push($userId, $value['userId']);
                    }
                    $customer->whereIn('customers.id', $userId);
                }
            }
            
            if (request()->has('stock_investment_experience')) {
                $stock_investment_experience = request()->get('stock_investment_experience');
                if (!empty($stock_investment_experience)) {
                    $customer->where('customers.stock_investment_experience', $stock_investment_experience);
                }
            }
            
            if (request()->has('investment_liquid_funds')) {
                $investment_liquid_funds = request()->get('investment_liquid_funds');
                if (!empty($investment_liquid_funds)) {
                    $customer->where('customers.investable_liquid_funds', $investment_liquid_funds);
                }
            }
            
            if (request()->has('age_group')) {
                $age_group = request()->get('age_group');
                if (!empty($age_group)) {
                    $customer->where('customers.age', $age_group);
                }
            }
            
            if (request()->has('group_filter')) {
                $group_filter = request()->get('group_filter');
                if (!empty($group_filter)) {
                    $customer->whereIn('customers.customerGroupID', $group_filter);
                }
            }
            
            if (request()->has('company_filter') || request()->has('single_company_filter')) {
                if(request()->filled('company_filter')){
                    $company_filter = request()->get('company_filter');
                }else{
                    $company_filter =  (request()->get('single_company_filter') != 'all' ? [request()->get('single_company_filter')] : []);
                }
                if (!empty($company_filter)) {
                    $stocks = Stock::whereIn('companyId', $company_filter)->select('userId')->distinct()->get();
                    $companyid = array();
                    foreach ($stocks as $key => $value) {
                        array_push($companyid, $value['userId']);
                    }
                    $customer->whereIn('customers.id', $companyid);
                }
            }
            if(request()->get('onload') == 'no') {
                if (request()->has('from_range') && request()->has('to_range')) {
                    $from_range = request()->get('from_range')*1000000;
                    $to_range   = request()->get('to_range')*1000000;
                    if(!empty($from_range) && !empty($to_range)){
                        $customer->whereHas('stocks', function($query) use($from_range, $to_range){
                            
                            $query->select( \DB::raw('SUM(stocks.invested) as amount_sum') )->havingRaw('amount_sum >= '.$from_range.' && amount_sum <= '.$to_range);
                        });
                    }
                }
            }
            if (request()->has('route_filter')) {
                $route_filter = request()->get('route_filter');
                if (!empty($route_filter)) {
                    $customer->whereIn('customers.routesOfKnownID', $route_filter);
                }
            }

            if (request()->has('city_filter')) {
                $city_filter = request()->get('city_filter');
                if (!empty($city_filter)) {
                    $customer->whereIn('customers.city_id', $city_filter);
                }
            }
            if (!empty(request()->start_date) && !empty(request()->end_date)) {
                $start = request()->start_date;
                $end =  request()->end_date;
                $customer->whereDate('first_visited_date', '>=', $start)
                        ->whereDate('first_visited_date', '<=', $end);
            }
            //dd($customer->get());
            return Datatables::of($customer)
                ->addColumn('mass_delete', function($row) {
                    return '<input name="customer_ids" type="checkbox" class="form-check-input selectCheckbox" value="'.$row->id.'" />';
                })
                ->editColumn('level', function ($row) {  
                    return $row->levelExp ? $row->levelExp->levelName : '';
                })
                ->editColumn('status_id', function ($row) {  
                    return $row->status_id;
                })
                ->editColumn('name', function ($row) {
                    $name = $row->name;
                    return '<a href="'.url('admin/edit_customer/'.$row->id).'">'.$name.'</a>';
                })
                ->editColumn('phonenumber1', function ($row) {
                    $phonenumber1 = $row->phonenumber1 ? $row->phonenumber1 : 0 ;
                    return $this->helper->formatPhoneNum($phonenumber1);
                })
                // ->editColumn('gender', function ($row) {
                //     $gender = $row->gender=='Male' ? '남' : ($row->gender=='Female' ? '여' : '기타');
                //     return $gender;
                // })
                ->editColumn('customerGroupID', function ($row) {
                    return $row->customerGroup ? $row->customerGroup->groupName : '';
                })
                ->editColumn('numberOfInvertedCompany', function ($row) {
                    return $row->stocks ? $row->stocks->count() : 0;
                })
                ->editColumn('totalInvested', function ($row) {
                    $collection = Stock::query();
                    if(request()->get('single_company_filter') != 'all'){
                        $collection->where('companyId', request()->get('single_company_filter'));
                    }
                    $total_companies_investment  = $collection->sum('invested');
                    return $row->stocks ? number_format($row->stocks->sum('invested')) : '';
                })
                ->addColumn(
                    'action', function($row) {
                        $action   = '<a href="'.route("admin.messages").'?customer_id='.$row->id.'" class="btn btn-outline-primary email_box">
                                        <i class="mdi mdi-email-outline"></i>
                                    </a>
                                    <a href="javascript:void(0);" class="btn btn-primary btn_customer_memo" data-id="'.$row->id.'">
                                        <i class="mdi mdi-pencil-box-multiple"></i>  메모
                                    </a>';
                        return $action;
                    }
                )
                ->rawColumns(['mass_delete','level','name', 'phonenumber1', 'customerGroupID','action',])
                ->make(true);   
        }

        $cities = City::where('isActive','Y')->where('isDelete','N')->where('isApproved','Y')->pluck('cityName','id');
        $groups = Customergroup::where('isActive','Y')->where('isDelete','N')->where('isApproved','Y')->get();
        
        $companies = Company::with('stocks')->where('isActive','Y')->where('isDelete','N')->where('isApproved','Y')->get();
        $stocks    = Stock::whereIn('companyId',$companies->pluck('id'))->get();

        $routeknowns = RouteKnown::where('isActive','Y')->where('isDelete', 'N')->where('isApproved','Y')->pluck('routeName','id');
        $customers = Customer::get();

        return view('admin.customers.index')->with(compact('groups', 'companies', 'routeknowns', 'cities','stocks','customers'));
    }

    public function delete(Request $request, $id) {
        if(Customer::find($id)) {
            $customer = Customer::find($id);
            $customer->delete();
            $this->helper->flash_message('success', 'Customer has been deleted auccessfully'); 
            return redirect('admin/customers');
        }else{
            abort(403, 'Unauthorized action.');
        }
    }
    
    public function deleteAllStockTransfer(Request $request) {
        $ids = $request->stock_transfer_id;
        foreach($ids as $id){
            $stock = Stock::find($id);
            $stock->delete();
        }
        $this->helper->flash_message('success', 'Stock transfer has been deleted auccessfully'); 
        return redirect()->back();
    }
    
    public function deleteAllFileTransfer(Request $request) {
        $ids = $request->file_transfer_id;
        foreach($ids as $id){
            $filetransfer = Filetransfer::find($id);
            $filetransfer->delete();
        }
        $this->helper->flash_message('success', 'File transfer has been deleted auccessfully'); 
        return redirect()->back();
    }
    
    public function deleteAllPostDelivery(Request $request) {
        $ids = $request->post_delivery_id;
        foreach($ids as $id){
            $postdelivery = Postdelivery::find($id);
            $postdelivery->delete();
        }
        $this->helper->flash_message('success', 'Post delivery has been deleted auccessfully'); 
        return redirect()->back();
    }
    
    public function deleteAllVisitRecords(Request $request) {
        $ids = $request->visit_record_id;
        foreach($ids as $id){
            $visitcustomer = Visitrecord::find($id);
            Visitcustomer::where('visitId',$id)->delete();
            $visitcustomer->delete();
        }
        $this->helper->flash_message('success', 'Visit records has been deleted auccessfully'); 
        return redirect()->back();
    }
    
    public function deleteAllInqueries(Request $request) {
        $ids = $request->inqueries_id;
        foreach($ids as $id){
            $inquery = Inquery::find($id);
            $inquery->delete();
        }
        $this->helper->flash_message('success', 'Inqueries has been deleted auccessfully'); 
        return redirect()->back();
    }

    public function getModalView(Request $request){
        if($request->ajax()){
            if($request->type=='city'){
                $cities = City::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
                $view = view('admin.customers.ajax.cityView',compact('cities'))->render();
            }
            if($request->type=='level'){
                $levels = Level::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
                $view = view('admin.customers.ajax.levelView',compact('levels'))->render();
            }
            if($request->type=='status'){
                $customerStatus = CustomerStatus::get();
                $view = view('admin.customers.ajax.statusView',compact('customerStatus'))->render();
            }
            if($request->type=='agent'){
                $agents = Customergroup::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
                $view = view('admin.customers.ajax.agentView',compact('agents'))->render();
            }
            if($request->type=='stockbroker'){
                $stockbrokers = Stockbroker::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
                $view = view('admin.customers.ajax.stockbrokerView',compact('stockbrokers'))->render();
            }
            if($request->type=='routeknown'){
                $routeknowns = RouteKnown::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
                $view = view('admin.customers.ajax.routeknownView',compact('routeknowns'))->render();
            }
            return response()->json([
                'success'   => true,
                'html'      => $view 
            ],201);
        }
    }

    public function getCompanyFilterView(Request $request){
        if($request->ajax()){
            if($request->company_id=='all'){
                $stocks = Stock::where('userId',$request->customer_id)->get();
            }else{
                $stocks = Stock::where('userId',$request->customer_id)->where('companyId',$request->company_id)->get();
            }
            $view = view('admin.customers.ajax.companyFilterView',compact('stocks'))->render();
            return response()->json([
                'success'   => true,
                'html'      => $view 
            ],201);
        }
    }
    
    public function add(Request $request) {
        if(!$_POST) {
            $customerStatus = CustomerStatus::get();
            $levels = Level::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
            $groups = Customergroup::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
            $companies = Company::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
            $routeknowns = RouteKnown::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
            $cities = City::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
            $stockbrokers = Stockbroker::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
            $admins = User::all();
            return view('admin.customers.add')->with(compact('groups', 'companies', 'routeknowns', 'cities', 'stockbrokers', 'admins','customerStatus','levels'));  
        
        }else if($request->submit) {

            //Validation start
            $messages = [
                'phonenumber1.unique' => 'The phone number has already been taken.',
            ];
            $validator = Validator::make($request->all(),[
                'phonenumber1' => 'required|string|unique:customers,phonenumber1',
            ],$messages);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
            //Validation end

            //Add customer
            $customer                               = new Customer;
            $customer->name                         = $request->name ? $request->name : 'no name';
            $customer->age                          = $request->age;
            $customer->phonenumber1                 = $request->phonenumber1;
            $customer->phonenumber2                 = $request->phonenumber2;
            $customer->email                        = $request->email;
            $customer->city_id                      = $request->cities;
            $customer->address                      = $request->address;
            $customer->level                        = $request->level;
            $customer->status_id                    = $request->status_id;
            $customer->customerGroupID              = $request->group;
            $customer->accountNumber                = $request->accountNumber;
            $customer->note                         = $request->customer_note;
            $customer->routesOfKnownID              = $request->routsofknown;
            $customer->investable_liquid_funds      = $request->investable_liquid_funds;
            $customer->finance                      = $request->finance;
            $customer->stock_investment_experience  = $request->stock_investment_experience;
            $customer->return_on_investment         = $request->return_on_investment;
            $customer->profit_lose                  = $request->profit_lose;
            $customer->investment_path              = $request->investment_path;
            $customer->first_visited_date           = $request->first_visited_date;
            $customer->stockBroker                  = $request->stock_firm;
            $customer->createdBy        = Auth::guard('admin')->user()->id;
            $customer->updatedBy        = Auth::guard('admin')->user()->id;
            $customer->date             = isset($request->edited_date) ? Carbon::createFromFormat('Y.m.d', $request->edited_date)->format('Y-m-d') : date('Y.m.d');
            $customer->save();
            
             
            //Add stock transfer
            if($request->stockdate!=''){
                $stock              = new Stock;
                $stock->date        = isset($request->stockdate) ? Carbon::createFromFormat('Y.m.d', $request->stockdate)->format('Y-m-d') : null;
                $stock->companyId   = $request->company;
                $stock->status      = $request->stock_status;
                $stock->stockPrice  = $request->stockPrice;
                $stock->quantity    = $request->quantity;
                $stock->invested    = $request->invested;
                $stock->userId      = $customer->id;
                $stock->createdBy   = Auth::guard('admin')->user()->id;
                $stock->save();
            }

            //Add file transfer
            if($request->filedate!=''){
                $filetransfer               = new Filetransfer;
                $filetransfer->date         = isset($request->filedate) ? Carbon::createFromFormat('Y.m.d', $request->filedate)->format('Y-m-d'): null;
                $filetransfer->companyId    = $request->filecompany;
                $filetransfer->method       = $request->filemethod;
                $filetransfer->fileName     = $request->fileName;
                $filetransfer->userId       = $customer->id;
                $filetransfer->createdBy    = Auth::guard('admin')->user()->id;
                $filetransfer->save();
            }

            //Add post delivery
            if($request->postdate!=''){
                $postdelivery               = new Postdelivery;
                $postdelivery->date         = isset($request->postdate) ? Carbon::createFromFormat('Y.m.d', $request->postdate)->format('Y-m-d') : null;
                $postdelivery->companyId    = $request->postcompany;
                $postdelivery->cityId       = $request->postcity;
                $postdelivery->address      = $request->postaddress;
                $postdelivery->status       = $request->post_status;
                $postdelivery->userId       = $customer->id;
                $postdelivery->createdBy    = Auth::guard('admin')->user()->id;
                $postdelivery->save();
            }

            //Add visit record
            if($request->title!=''){
                $visitrecord = new Visitrecord;
                if ($request->type == "E" || $request->type == "T") {
                    $enddate = null;
                }else{
                    $enddate = isset($request->enddate) ? Carbon::createFromFormat('Y.m.d', $request->enddate)->format('Y-m-d') : null;
                }
                $visitrecord->title             = $request->title;
                $visitrecord->type              = $request->visittype;
                $visitrecord->startdate         = isset($request->startdate) ? Carbon::createFromFormat('Y.m.d', $request->startdate)->format('Y-m-d') : null;
                $visitrecord->starttime         = $request->starttime;
                $visitrecord->enddate           = $enddate;
                $visitrecord->endtime           = $request->endtime;
                $visitrecord->note              = $request->visitnote;
                $visitrecord->backgroundColor   = $request->backgroundColor;
                $visitrecord->borderColor       = $request->backgroundColor;
                $visitrecord->createdBy         = Auth::guard('admin')->user()->id;
                $visitrecord->save();

                if($visitrecord){
                    $visitcustomer              = new Visitcustomer;
                    $visitcustomer->visitId     = $visitrecord->id;
                    $visitcustomer->customerId  = $customer->id;
                    $visitcustomer->status      = $request->visit_status;
                    $visitcustomer->save();
                }
            }

            //Add inquery
            if($request->note!=''){
                $inquery        = new Inquery;
                $inquery->note  = $request->note;
                if(request()->has('keyword')) {
                    $keyword = request()->get('keyword');
                    if(!empty($keyword)) {
                        $inquery->keyword = $keyword;
                    }else {
                        $inquery->keyword = '';
                    }
                }
                $inquery->customerId    = $customer->id;
                $inquery->createdBy     = Auth::guard('admin')->user()->id;
                $inquery->save();
            }
            

            $output = ['success' => true,
                'msg' => "Customer has been added Successfully"
            ];

            // Call flash message function
            // $this->helper->flash_message('success', 'Customer has been added Successfully'); 
            return redirect('admin/add_customer')->with(['status' => $output]);
            
        }
        else {
            return redirect('admin/add_customer');
        }
    }

    public function update(Request $request) {
        if(!$_POST) {
            $customerStatus = CustomerStatus::get();
            $levels = Level::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
            $groups = Customergroup::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
            $companies = Company::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
            $routeknowns = RouteKnown::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
            $cities = City::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
            $stockbrokers = Stockbroker::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();

            $admins = User::all();

            $stocks = Stock::join('companies', 'stocks.companyId', '=', 'companies.id')
                ->join('customers', 'customers.id', '=', 'stocks.userId')
                ->join('users', 'users.id', '=', 'stocks.createdBy')
                ->where('customers.id', '=', $request->id)
                ->orderBy('stocks.date', 'DESC')
                ->select(['stocks.id',
                DB::raw("DATE_FORMAT(stocks.date, '%Y.%m.%d') as date"),
                'customers.name',
                'companies.companyName',
                'users.name as adminname',
                'stocks.stockPrice','stocks.quantity',
                'stocks.invested', 'stocks.picture', 'customers.stockBroker', 'customers.accountNumber', 'stocks.status','stocks.is_sent', 'stocks.userId', 'stocks.createdBy'])
                ->get();
            $stocksCount = $stocks->count();

            $filetransfers = Filetransfer::join('companies', 'filetransfers.companyId', '=', 'companies.id')
                ->join('customers', 'customers.id', '=', 'filetransfers.userId')
                ->join('users', 'users.id', '=', 'filetransfers.createdBy')
                ->where('customers.id', '=', $request->id)
                ->orderBy('filetransfers.date', 'DESC')
                ->select([
                    'filetransfers.id',
                    DB::raw("DATE_FORMAT(filetransfers.date, '%Y.%m.%d') as date"),
                    'customers.name',
                    'users.name as adminname',
                    'companies.companyName',
                    'filetransfers.fileName',
                    'filetransfers.method',
                    'filetransfers.createdBy',
                    'filetransfers.userId',
                ])->get();
            $filetransfersCount = $filetransfers->count();

            $postdeliveries = Postdelivery::join('companies', 'postdeliveries.companyId', '=', 'companies.id')
                ->join('customers', 'customers.id', '=', 'postdeliveries.userId')
                ->join('users', 'users.id', '=', 'postdeliveries.createdBy')
                ->where('customers.id', '=', $request->id)
                ->orderBy('postdeliveries.date', 'DESC')
                ->select(['postdeliveries.id',
                    DB::raw("DATE_FORMAT(postdeliveries.date, '%Y.%m.%d') as date"),
                    'customers.name',
                    'users.name as adminname',
                    'companies.companyName',
                    'postdeliveries.cityId',
                    'postdeliveries.status',
                    'postdeliveries.address', 
                    'postdeliveries.userId', 
                    'postdeliveries.createdBy'
                ])->get();
            $postdeliveriesCount = $postdeliveries->count();

            $visitrecords = Visitcustomer::query()
                ->join('customers', 'customers.id', '=', 'visitcustomers.customerId')
                ->join('visitrecords', 'visitrecords.id', '=', 'visitcustomers.visitId')
                ->join('users', 'users.id', '=', 'visitrecords.createdBy')
                ->where('customers.id', '=', $request->id)
                ->orderBy('visitrecords.startdate', 'DESC')
                ->select(['visitrecords.id',
                    DB::raw("DATE_FORMAT(visitrecords.startdate, '%Y.%m.%d') as startdate"),
                    DB::raw("DATE_FORMAT(visitrecords.enddate, '%Y.%m.%d') as enddate"),
                    'customers.name',
                    'visitrecords.title',
                    'users.name as adminname',
                    'visitrecords.starttime',
                    'visitrecords.endtime',
                    'visitcustomers.status',
                    'visitrecords.type',
                    'visitrecords.createdBy',
                    'visitrecords.note',
                ])->get();
            $visitrecordsCount = $visitrecords->count();

            $inqueries = Inquery::join('customers', 'inqueries.customerId', '=', 'customers.id')
                        ->join('users', 'users.id', '=', 'inqueries.createdBy')
                        ->where('customers.id', '=', $request->id)
                        ->orderBy('inqueries.created_at', 'DESC')
                        ->select(['inqueries.id',
                            DB::raw("DATE_FORMAT(inqueries.created_at, '%Y.%m.%d') as date"),
                            'customers.name',
                            'inqueries.note',
                            'users.name as adminname',
                            'customers.customerGroupID',
                            'customers.routesOfKnownID',
                            'inqueries.keyword',
                            'inqueries.customerId', 
                            'inqueries.createdBy'
                        ])->get();

            $inqueriesCount = $inqueries->count();

            $customer = Customer::find($request->id);

            
            if($customer) {
                return view('admin.customers.edit')->with(compact('groups', 'companies', 'routeknowns', 'cities', 'stockbrokers', 'admins', 'customer', 'stocks', 'filetransfers', 'postdeliveries', 'visitrecords', 'inqueries', 'inqueriesCount', 'visitrecordsCount', 'postdeliveriesCount', 'filetransfersCount', 'stocksCount','levels','customerStatus')); 
            }
            else {
                $this->helper->flash_message('danger', 'Invalid ID'); // Call flash message function
                return redirect('admin/customers');
            }
        }else if ($request->submit) {
            // Add Admin User Validation Rules
            $messages = [
                'phonenumber1.unique' => 'The phone number has already been taken.',
            ];
            $validator = Validator::make($request->all(),[
                'phonenumber1' => 'required|string|unique:customers,phonenumber1,'.$request->id,
            ],$messages);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput(); // Form calling with Errors and Input values
            }
            
            $customer                               = Customer::find($request->id);
            $customer->name                         = $request->name ? $request->name : 'no name';
            $customer->age                          = $request->age;
            $customer->phonenumber1                 = $request->phonenumber1;
            $customer->phonenumber2                 = $request->phonenumber2;
            $customer->email                        = $request->email;
            $customer->city_id                      = $request->cities;
            $customer->address                      = $request->address;
            $customer->level                        = $request->level;
            $customer->status_id                    = $request->status_id;
            $customer->customerGroupID              = $request->group;
            $customer->accountNumber                = $request->accountNumber;
            $customer->note                         = $request->note;
            $customer->routesOfKnownID              = $request->routsofknown;
            $customer->investable_liquid_funds      = $request->investable_liquid_funds;
            $customer->finance                      = $request->finance;
            $customer->stock_investment_experience  = $request->stock_investment_experience;
            $customer->return_on_investment         = $request->return_on_investment;
            $customer->profit_lose                  = $request->profit_lose;
            $customer->investment_path              = $request->investment_path;
            $customer->first_visited_date           = $request->first_visited_date;
            $customer->stockBroker                  = $request->stock_firm;
            $customer->updatedBy                    = Auth::guard('admin')->user()->id;
            $customer->date                         = isset($request->edited_date) ? Carbon::createFromFormat('Y.m.d', $request->edited_date)->format('Y-m-d') : date('Y.m.d');
            $customer->save();
            $output = ['success' => true,
                        'msg' => "Customer has been updated successfully"
                    ];
            // $this->helper->flash_message('success', 'Customer has been updated successfully');

            return redirect('admin/edit_customer/'.$request->id)->with(['status' => $output]);
        }
    }

    public function excelupload(Request $request){
        if (request()->ajax()) {
            $rules = array(
                'excel_file' => 'required'
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput(); // Form calling with Errors and Input values
            }
            $path = $request->file('excel_file')->getRealPath();
            $data = Excel::load($path)->get();
            if($data->count() > 0) {
                foreach($data->toArray() as $key => $value) {
                    try {
                        $city = City::where('cityName', $value['city'])->first()->id;
                        $group = Customergroup::where('groupName', $value['group'])->first()->id;
                        if($value['gender'] == "Male") {
                            $gender = "M";
                        } else if ($value['gender'] == "Female") {
                            $gender = "F";
                        } else {
                            $gender = "O";
                        }
                        $insert_data[] = array(
                            'created_at'  => Carbon::createFromFormat('Y.m.d', $value['date'])->format('Y-m-d H:i:s'),
                            'name'=> $value['name'],
                            'phonenumber1'   => $value['number'],
                            'gender'=> $gender,
                            'age'  => $value['age'],
                            'city_id'   => $city,
                            'customerGroupID'   => $group,
                            'email'   => $value['email'],
                            'routesOfKnownID' => '1',
                            'createdBy' => '1',
                            'updatedBy' => '1'
                        );
                    } catch (\Exception $e) {
                        $this->helper->flash_message('error', $e->getMessage());
                    }
                    
                }
                if(!empty($insert_data)) {
                    //DB::table('customers')->insert($insert_data);
                    return response()->json(['status' => 'Success'],201);
                }
            }
            return response()->json(['status' => 'File empty or bad file'],401);
        }
    }

    public function massDestroy(Request $request) {
        if (request()->ajax()) {
            if (!empty($request->ids)) {
                $customers = Customer::whereIn('id', $request->ids);
                Stock::whereIn('userId', $request->ids)->delete();
                Filetransfer::whereIn('userId', $request->ids)->delete();
                Postdelivery::whereIn('userId', $request->ids)->delete();
                $visitrecordIds = Visitcustomer::whereIn('customerId', $request->ids)->pluck('visitId')->toArray();
                Visitrecord::whereIn('id', $visitrecordIds)->delete();
                Visitcustomer::whereIn('customerId', $request->ids)->delete();
                Inquery::whereIn('customerId', $request->ids)->delete();
                $customers->delete();
                return response()->json([
                    'success'       => true,
                    'data'          => [],
                    'message'       => 'Customers deleted successfully.',
                    'redirect_url'  => url('admin/customers'),
                    'reload'        => false,
                ]);
            }
        }
    }

    
    public function stockformadd(Request $request){
        if (request()->ajax()) {
            $rules = array(
                'date' => 'required',
                'company'  => 'required',
                'status' => 'required',
                'stockPrice'  => 'required',
                'quantity' => 'required',
                'invested'  => 'required',
                'customerId'  => 'required',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } 
            else {
                $stock = new Stock;
                $stock->date = Carbon::createFromFormat('Y.m.d', $request->date)->format('Y-m-d');
                $stock->companyId = $request->company;
                $stock->status = $request->status;
                $stock->stockPrice = $request->stockPrice;
                $stock->quantity = $request->quantity;
                $stock->invested = $request->invested;
                $stock->userId = $request->customerId;
                $stock->createdBy = Auth::guard('admin')->user()->id;
                $stock->save();
                $this->helper->flash_message('success', 'Added Successfully'); 

                return response()->json(['status' => 'Success'],201);
            }
        }
    }

    public function stockformupdate(Request $request){
        if (request()->ajax()) {
            $rules = array(
                'date'          => 'required',
                'company'       => 'required',
                'status'        => 'required',
                'stockPrice'    => 'required',
                'quantity'      => 'required',
                'invested'      => 'required',
                'customerId'    => 'required',
                'upstockid'     => 'required',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } 
            else {
                $stock              = Stock::find($request->upstockid);
                $stock->date        = Carbon::createFromFormat('Y.m.d', $request->date)->format('Y-m-d');
                $stock->companyId   = $request->company;
                $stock->status      = $request->status;
                $stock->stockPrice  = $request->stockPrice;
                $stock->quantity    = $request->quantity;
                $stock->invested    = $request->invested;
                $stock->userId      = $request->customerId;
                $stock->createdBy   = Auth::guard('admin')->user()->id;
                $stock->save();
                $this->helper->flash_message('success', 'Added Successfully'); 

                return response()->json(['status' => 'Success'],201);
            }
        }
    }

    public function getstockform(Request $request) {
        if (request()->ajax()) {
            $stock = Stock::find($request->upstock);
            $data = [
                'quantity'      => $stock->quantity,
                'stockPrice'    => $stock->stockPrice,
                'invested'      => $stock->invested,
                'company'       => $stock->companyId,
                'stock_status'  => $stock->status,
                'stockdate'     => date('Y.m.d', strtotime($stock->date))
            ];
            return response()->json($data,200);
        }
    }
    public function transferformadd(Request $request){
        if (request()->ajax()) {
            $rules = array(
                'date'          => 'required',
                'company'       => 'required',
                'method'        => 'required',
                'fileName'      => 'required',
                'customerId'    => 'required',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } 
            else {
                $filetransfer               = new Filetransfer;
                $filetransfer->date         = Carbon::createFromFormat('Y.m.d', $request->date)->format('Y-m-d');
                $filetransfer->companyId    = $request->company;
                $filetransfer->method       = $request->method;
                $filetransfer->fileName     = $request->fileName;
                $filetransfer->userId       = $request->customerId;
                $filetransfer->createdBy    = Auth::guard('admin')->user()->id;
                $filetransfer->save();
                $this->helper->flash_message('success', 'Added Successfully'); 

                return response()->json(['status' => 'Success'],201);
            }
        }
    }
    public function gettransferform(Request $request) {
        if (request()->ajax()) {
            $filetransfer = Filetransfer::find($request->fileid);
            $data = [
                'fileName'  => $filetransfer->fileName,
                'company'   => $filetransfer->companyId,
                'method'    => $filetransfer->method,
                'date'      => date('Y.m.d', strtotime($filetransfer->date))
            ];
            return response()->json($data,200);
        }
    }
    public function transferformupdate(Request $request){
        if (request()->ajax()) {
            $rules = array(
                'date'          => 'required',
                'company'       => 'required',
                'method'        => 'required',
                'fileName'      => 'required',
                'customerId'    => 'required',
                'fileid'        => 'required',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } 
            else {
                $filetransfer               = Filetransfer::find($request->fileid);
                $filetransfer->date         = Carbon::createFromFormat('Y.m.d', $request->date)->format('Y-m-d');
                $filetransfer->companyId    = $request->company;
                $filetransfer->method       = $request->method;
                $filetransfer->fileName     = $request->fileName;
                $filetransfer->userId       = $request->customerId;
                $filetransfer->createdBy    = Auth::guard('admin')->user()->id;
                $filetransfer->save();
                $this->helper->flash_message('success', 'Added Successfully'); 

                return response()->json(['status' => 'Success'],201);
            }
        }
    }
    public function posterformadd(Request $request){
        if (request()->ajax()) {
            $rules = array(
                'date'      => 'required',
                'company'   => 'required',
                'city'      => 'required',
                'status'    => 'required',
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
                $postdelivery->address = $request->address;
                $postdelivery->status = $request->status;
                $postdelivery->userId = $request->customer;
                $postdelivery->createdBy = Auth::guard('admin')->user()->id;
                $postdelivery->save();
                $this->helper->flash_message('success', 'Post has been created successfully'); 

                return response()->json(['status' => 'Success'],201);
            }
        }
    }

    public function posterformupdate(Request $request){
        if (request()->ajax()) {
            $rules = array(
                'date' => 'required',
                'company'  => 'required',
                'city' => 'required',
                'status' => 'required',
                'customer'  => 'required',
                'postid'  => 'required',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } 
            else {
                $postdelivery = Postdelivery::find($request->postid);
                $postdelivery->date = Carbon::createFromFormat('Y.m.d', $request->date)->format('Y-m-d');
                $postdelivery->companyId = $request->company;
                $postdelivery->cityId = $request->city;
                $postdelivery->address = $request->address;
                $postdelivery->status = $request->status;
                $postdelivery->userId = $request->customer;
                $postdelivery->createdBy = Auth::guard('admin')->user()->id;
                $postdelivery->save();
                $this->helper->flash_message('success', 'Post has been updated successfully'); 

                return response()->json(['status' => 'Success'],201);
            }
        }
    }

    public function getposterform(Request $request) {
        if (request()->ajax()) {
            $poster = Postdelivery::find($request->postid);
            $data = [
                'city' => $poster->cityId,
                'company' => $poster->companyId,
                'address' => $poster->address,
                'status' => $poster->status,
                'date' => date('Y.m.d', strtotime($poster->date))
            ];
            return response()->json($data,200);
        }
    }

    public function visitformadd(Request $request) {
        if (request()->ajax()) {
            $rules = array(
                'startdate' => 'required',
                'title'  => 'required',
                'status' => 'required',
                'customer'  => 'required',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } 
            else {
                $visitrecord = new Visitrecord;
                $visitrecord->startdate = Carbon::createFromFormat('Y.m.d', $request->startdate)->format('Y-m-d');
                if ($request->type == "E" || $request->type == "T") {
                    $visitrecord->enddate = null;
                } else {
                    $visitrecord->enddate = Carbon::createFromFormat('Y.m.d', $request->enddate)->format('Y-m-d');
                }
                 
                $visitrecord->title     = $request->title;
                $visitrecord->note      = $request->note;
                $visitrecord->starttime = $request->starttime;
                $visitrecord->endtime   = $request->endtime;
                $visitrecord->backgroundColor   = $request->backgroundColor;
                $visitrecord->borderColor       = $request->backgroundColor;
                $visitrecord->type              = $request->type;
                $visitrecord->createdBy         = Auth::guard('admin')->user()->id;
                $visitrecord->save();

                if($visitrecord){
                    $visitcustomer              = new Visitcustomer;
                    $visitcustomer->visitId     = $visitrecord->id;
                    $visitcustomer->customerId  = $request['customer'];
                    $visitcustomer->status      = $request->status;
                    $visitcustomer->save();
                }

                $this->helper->flash_message('success', 'Added Successfully'); 

                return response()->json(['status' => 'Success'],201);
            }
        }
    }
    public function visitformupdate(Request $request) {
        if (request()->ajax()) {
            $rules = array(
                'startdate' => 'required',
                'title'     => 'required',
                'status'    => 'required',
                'customer'  => 'required',
                'visitid'   => 'required'
            );
            $validator = Validator::make($request->all(), $rules);
            
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }else {
                $visitrecord = Visitrecord::find($request->visitid);
                $visitrecord->startdate = Carbon::createFromFormat('Y.m.d', $request->startdate)->format('Y-m-d');
                if ( $request->type == "E" || $request->type == "T") {
                    $visitrecord->enddate = null;
                } else {
                    $visitrecord->enddate = Carbon::createFromFormat('Y.m.d', $request->enddate)->format('Y-m-d');
                }
                //dd($request['status']);
                $visitrecord->title             = $request->title;
                $visitrecord->note              = $request->note;
                $visitrecord->starttime         = $request->starttime;
                $visitrecord->endtime           = $request->endtime;
                $visitrecord->backgroundColor   = $request->backgroundColor;
                $visitrecord->borderColor       = $request->backgroundColor;
                $visitrecord->type              = $request->type;
                $visitrecord->createdBy         = Auth::guard('admin')->user()->id;
                $visitrecord->save();

                if($visitrecord){
                    $visitcustomer = Visitcustomer::where('visitId', $request['visitid'])->where('customerId', $request['customer']);
                    $visitcustomer->delete();

                    $visitcustomer = new Visitcustomer;
                    $visitcustomer->visitId = $visitrecord->id;
                    $visitcustomer->customerId = $request['customer'];
                    $visitcustomer->status = $request->status;
                    $visitcustomer->save();
                }

                $this->helper->flash_message('success', 'Updated Successfully'); 

                return response()->json(['status' => 'Success'],201);
            }
        }
    }
    public function getvisitform(Request $request) {
        if (request()->ajax()) {
            $visit = Visitrecord::find($request->visitid);
            $status = $visit->customer[0] ? $visit->customer[0]['status'] : '';
            if ($visit->type == "T") {
                $data = [
                    'title'             => $visit->title,
                    'note'              => $visit->note,
                    'starttime'         => $visit->starttime,
                    'endtime'           => $visit->endtime,
                    'status'            => $status,
                    'type'              => $visit->type,
                    'backgroundColor'   => $visit->backgroundColor,
                    'startdate'         => date('Y.m.d', strtotime($visit->startdate)),
                    'enddate'           => date('Y.m.d', strtotime($visit->enddate))
                ];
            } else if($visit->type == "A") {
                $data = [
                    'title'             => $visit->title,
                    'note'              => $visit->note,
                    'status'            => $status,
                    'type'              => $visit->type,
                    'backgroundColor'   => $visit->backgroundColor,
                    'startdate'         => date('Y.m.d', strtotime($visit->startdate)),
                    'enddate'           => date('Y.m.d', strtotime($visit->enddate))
                ];
            } else if($visit->type == "E") {
                $data = [
                    'title'             => $visit->title,
                    'note'              => $visit->note,
                    'status'            => $status,
                    'type'              => $visit->type,
                    'starttime'         => $visit->starttime,
                    'backgroundColor'   => $visit->backgroundColor,
                    'startdate'         => date('Y.m.d', strtotime($visit->startdate))
                ];
            }
            
            return response()->json($data,200);
        }
    }

    public function inqueryformadd(Request $request) {
        $rules = array(
            'note'  => 'required',
            'customer'  => 'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }else {
            
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
            $this->helper->flash_message('success', 'Added Successfully'); 

            return response()->json(['status' => 'Success'],201);
        }
    }
    public function inqueryformupdate(Request $request) {
        $rules = array(
            'note'  => 'required',
            'customer'  => 'required',
            'inqueryid' => 'required'
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } 
        else {
            $inquery = Inquery::find($request->inqueryid);
            $inquery->note = $request->note;
            $inquery->keyword = $request->keyword;
            $inquery->customerId = $request->customer;
            $inquery->createdBy = Auth::guard('admin')->user()->id;
            $inquery->save();
            $this->helper->flash_message('success', 'Added Successfully'); 

            return response()->json(['status' => 'Success'],201);
        }
    }

    public function getinqueryform(Request $request) {
        if (request()->ajax()) {
            $inquery = Inquery::find($request->inqueryid);
            $data = [
                'note' => $inquery->note,
                'keyword' => $inquery->keyword
            ];
            return response()->json($data,200);
        }
    }
}