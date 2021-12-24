<?php

namespace App\Http\Controllers\Admin;

use DB;
use Auth;
use File;
use Session;
use Validator;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\User;
use App\Models\Stock;
use App\Models\Inquery;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Routeknown;
use App\Models\Stockbroker;
use App\Models\Feedhistory;
use App\Http\Start\Helpers;
use App\Models\Customergroup;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class StockTransactionController extends Controller
{
    protected $helper; // Global variable for instance of Helpers
    
    public function __construct()
    {
        $this->helper = new Helpers;
    }

    public function index() {
        if (request()->ajax()) {
            $stocks = Stock::select(['stocks.id',DB::raw("DATE_FORMAT(stocks.date, '%Y.%m.%d') as date"),'customers.name','customers.email','customers.phonenumber1','customers.customerGroupID','customers.routesOfKnownID','stocks.companyId',DB::raw('customers.id as customersID'),'companies.companyName','stocks.stockPrice','stocks.quantity','stocks.invested', 'customers.stockBroker', 'customers.accountNumber', 'stocks.status', 'stocks.userId', 'stocks.createdBy','stocks.is_sent','stocks.picture'])
            ->join('companies', 'stocks.companyId', '=', 'companies.id')
            ->join('customers', 'customers.id', '=', 'stocks.userId')
            ->orderBy('stocks.date', 'DESC');
            
            if (request()->has('group_filter')) {
                $group_filter = request()->get('group_filter');
                if (!empty($group_filter)) {
                    $stocks->where('customers.customerGroupID', $group_filter);
                }
            }
            
            if (request()->has('company_filter')) {
                $company_filter = request()->get('company_filter');
                if (!empty($company_filter)) {
                    $stocks->where('stocks.companyId', $company_filter);
                }
            }
            if (request()->has('route_filter')) {
                $route_filter = request()->get('route_filter');
                if (!empty($route_filter)) {
                    $stocks->where('customers.routesOfKnownID', $route_filter);
                }
            }
            if (request()->has('status_filter')) {
                $status_filter = request()->get('status_filter');
                if (!empty($status_filter)) {
                    $stocks->where('stocks.status', $status_filter);
                }
            }
            if (request()->has('desksearch')) {
                $desksearch = request()->get('desksearch');
                if (!empty($desksearch)) {
                    $emailcheck = strpos($desksearch, '@');
                    if($emailcheck !== false) {
                        $stocks->where('customers.email', $desksearch);
                    } else if ($desksearch){
                        $stocks->where('customers.phonenumber1', 'like', '%' . $desksearch . '%');
                        $stocks->orWhere('customers.name', 'like', '%' . $desksearch . '%');
                    } 
                }
            }

            if (request()->has('mobilesearch')) {
                $mobilesearch = request()->get('mobilesearch');
                if (!empty($mobilesearch)) {
                    $emailcheck = strpos($mobilesearch, '@');
                    if($emailcheck !== false) {
                        $stocks->where('customers.email', $mobilesearch);
                    } else if ($mobilesearch) {
                        $stocks->where('customers.phonenumber1', 'like', '%'. $mobilesearch . '%');
                        $stocks->orWhere('customers.name', 'like', '%' . $mobilesearch . '%');
                    } 
                }
            }

            return Datatables::of($stocks)
                ->addColumn('mass_delete', function($row) {
                    return '<input type="checkbox" class="form-check-input" value="'.$row->id.'" />';
                })
                ->editColumn('name', function ($row) {
                    $name = $row->name;
                    return '<a href="'.url('admin/user-record/edit_stock/'.$row->id).'">'.$name.'</a>';
                })
                ->editColumn('stockPrice', function ($row) {
                    return isset($row->stockPrice) ? number_format($row->stockPrice) : 0;
                })
                ->editColumn('quantity', function ($row) {
                    return isset($row->quantity) ? number_format($row->quantity)  : 0;
                })
                ->editColumn('invested', function ($row) {
                    return isset($row->invested) ? number_format($row->invested)  : 0;
                })
                ->editColumn('proof', function ($row) {
                    return isset($row->picture) ? '<a data-lightbox="image-1" href="'.$row->picture.'">
                                <img src="'.$row->picture.'" width="40">
                            </a>' : '';
                })
                ->editColumn('agent', function ($row) {
                    $customergroup = Customergroup::find($row->customerGroupID);
                    return isset($customergroup) ? $customergroup['groupName'] : '';
                })
                ->editColumn('noOfTr', function ($row) {
                    $count = Stock::where('userId',$row->userId)->count();
                    return ($count > 0) ? $count : 0;
                })
                ->addColumn('registeredBy', function($row) {
                    $admin = User::where('id', $row->createdBy)->first();
                    return isset($admin) ? $admin->name : '';
                })
                ->editColumn('status', function ($row) {
                    $status = $row->status;
                    $status_name = '';
                    if ($status == "Active") {
                        $status_name = '<a href="javascript:void(0);" class="btn btn-success waves-effect waves-light btn_status w-100" data-status="'.$row->status.'" data-id="'.$row->id.'">이체완료</a>';
                    } else if ($status == "Pending") {
                        $status_name = '<a href="javascript:void(0);" class="btn btn-primary waves-effect waves-light btn_status w-100" data-id="'.$row->id.'" data-status="'.$row->status.'">진행중</a>';
                    } else if ($status == "Canceled") {
                        $status_name = '<a href="javascript:void(0);" class="btn btn-danger waves-effect waves-light btn_status w-100" data-id="'.$row->id.'" data-status="'.$row->status.'">취소</a>';
                    }else if ($status == "Exit") {
                        $status_name = '<a href="javascript:void(0);" class="btn btn-success waves-effect waves-light btn_status w-100" data-id="'.$row->id.'" data-status="'.$row->status.'">취소</a>';
                    }
                    return $status_name;
                })
                ->editColumn('sms', function ($row) {
                    $checked = $row->is_sent==1 ? 'checked' : '';
                    return '<input type="checkbox"  class="form-check-input1 isMessageSent" data-id="'.$row->id.'" value="'.$row->is_sent.'" '.$checked.'/>';
                })
                ->addColumn('action', function($row) {
                    return '<a href="'.url('admin/edit_customer/'.$row->userId).'" class=""><i class="mdi mdi-eye-outline" style="font-size: 26px;"></i></a>';
                })
                ->rawColumns(['mass_delete','name','stockPrice','quantity','invested','proof','noOfTr','agent','registeredBy','status','sms','action'])
                ->make(true);
        }

        $groups = Customergroup::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
        $companies = Company::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
        $routeknowns = RouteKnown::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
        return view('admin.user-records.stocks.index')->with(compact('groups', 'companies', 'routeknowns'));
    }

    public function add(Request $request) {
        if(!$_POST) {
            $companies = Company::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
            $customers = Customer::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
            return view('admin.user-records.stocks.add')->with(compact('companies', 'customers'));
        }else if ($request->submit) {
            
            $rules = array(
                'date'          => 'required',
                'company'       => 'required',
                'stock_status'  => 'required',
                'stockPrice'    => 'required',
                'quantity'      => 'required',
                'invested'      => 'required',
                'customer'      => 'required',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }else {
                $stock              = new Stock;
                $stock->date        = Carbon::createFromFormat('Y.m.d', $request->date)->format('Y-m-d');
                $stock->companyId   = $request->company;
                $stock->status      = $request->stock_status;
                $stock->stockPrice  = $request->stockPrice;
                $stock->quantity    = $request->quantity;
                $stock->invested    = $request->invested;
                $stock->userId      = $request->customer;
                $stock->createdBy   = Auth::guard('admin')->user()->id;

                if ($request->hasFile('picture')) {
                    $image  = $request->file('picture');
                    $name   = 'gallery_item_'.rand(4444,5555).time().'.'.$image->getClientOriginalExtension();
                    $destinationPath = public_path('/images/userRecords/stocks');
                    if(! File::exists($destinationPath)){
                        File::makeDirectory( $destinationPath );
                    }
                    $image->move( $destinationPath, $name );
                    $stock->picture = '/images/userRecords/stocks/'.$name;
                }
                $stock->save();

                //feed history add
                $feedhistory = new Feedhistory;
                $feedhistory->feedname = "Stock Transaction";
                $feedhistory->customerId = $request->customer;
                $feedhistory->createdBy = Auth::guard('admin')->user()->id;
                $feedhistory->save();

                $this->helper->flash_message('success', 'Added Successfully'); 
                return redirect('admin/user-record/stocks');
            }
        }
        else {
            return redirect('admin/user-record/stocks');
        }
    }

    public function update(Request $request) {
        if(!$_POST) {
            $companies = Company::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
            $customers = Customer::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
            $stock = Stock::find($request->id);
            return view('admin.user-records.stocks.edit')->with(compact('stock', 'companies', 'customers'));
        } 
        else if ($request->submit){
            $rules = array(
                'date' => 'required',
                'company'  => 'required',
                'stock_status' => 'required',
                'stockPrice'  => 'required',
                'quantity' => 'required',
                'invested'  => 'required',
                'customer'  => 'required',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } 
            else {
                $stock = Stock::find($request->id);
                $stock->date = Carbon::createFromFormat('Y.m.d', $request->date)->format('Y-m-d');
                $stock->companyId = $request->company;
                $stock->status = $request->stock_status;
                $stock->stockPrice = $request->stockPrice;
                $stock->quantity = $request->quantity;
                $stock->invested = $request->invested;
                $stock->userId = $request->customer;
                $stock->createdBy = Auth::guard('admin')->user()->id;

                if($request->hasFile('picture')) {
                    $image = $request->file('picture');
                    $name = 'gallery_item_'.rand(4444,5555).time().'.'.$image->getClientOriginalExtension();
                    $destinationPath = public_path('/images/userRecords/stocks');
                    if (! File::exists( $destinationPath ) ) {
                        File::makeDirectory( $destinationPath );
                    }
                    $image->move( $destinationPath, $name );
                    $stock->picture = '/images/userRecords/stocks/'.$name;
                }

                $stock->save();
                $this->helper->flash_message('success', 'Updated Successfully'); 

                return redirect('admin/user-record/stocks');
            }
        }
        return redirect('admin/user-record/stocks');
    }

    public function massDestroy(Request $request) {
        
        if (!empty($request->input('selected_rows'))) {
            $selected_rows = explode(',', $request->input('selected_rows'));
            
            $stocks = Stock::whereIn('id', $selected_rows)->delete();
        }
        

        return redirect()->back();
    }

    public function statistics(Request $request) {
        $groups = Customergroup::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
        $companies = Company::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->with('owner')->get();
        $routeknowns = RouteKnown::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
        
        return view('admin.user-records.stocks.statistics')->with(compact('groups', 'companies', 'routeknowns'));
    }
    
    public function statistics_chart(Request $request) {
        if (request()->ajax()) {
            $rules = array(
                'company_id'=>'required',
                'view_type'=> ['required', Rule::in(['day', 'week', 'month']) ],
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'error' => $validator->errors()->all()],201);
            } else {
                $company = Company::find($request->company_id);
                if(!$company) 
                    return response()->json(['success' => false, 'error' => 'Invalid Company'],201);

                switch ($request->view_type) {
                    case 'day':
                        $defaultSubDays = Carbon::today()->subDays(10);
                        $groupBy = "DATE(date)";
                        $format = "Y.m.d";
                        break;
                    case 'month':
                        $defaultSubDays = Carbon::today()->subMonths(10);
                        $groupBy = "DATE_FORMAT(date, \"%Y-%m-01\")";
                        $format = "F Y";
                        break;
                    case 'week':
                        $defaultSubDays = Carbon::today()->subWeeks(10);
                        $groupBy = "CONCAT(YEAR(date), '/', WEEK(date))";
                        $format = "m.d";
                        break;
                }
                $start_date = !empty($request->start_date) ? new Carbon($request->start_date) : $defaultSubDays;
                $end_date = !empty($request->end_date) ? new Carbon($request->end_date) : Carbon::today();
                $investmentsResult = $company->stocks()
                    ->whereBetween('date', [$start_date->format('Y-m-d')." 00:00:00", $end_date->format('Y-m-d')." 23:59:59"])
                    ->where('status', 'Active')
                    ->select([
                        DB::raw('sum(invested) as amount'),
                        DB::raw('COUNT(DISTINCT userId) as investors'),
                        DB::raw($groupBy.' as date'),
                    ])
                    ->groupBy(DB::raw($groupBy))
                    ->get()
                    ->keyBy('date');
                $investmentsResult = $investmentsResult->values()->toArray();
                $investments = [];
                foreach($investmentsResult as $investment) {
                    $date = ($request->view_type != 'week') ? new Carbon($investment['date']) : Carbon::now();
                    if($request->view_type == 'week') {
                        $d = explode('/', $investment['date']);
                        $date->setISODate($d[0],$d[1]);
                        $date = $date->startOfWeek();
                    }
                    $date = $date->format($format);
                    $investment['date'] = $date;
                    $investments[$date] = $investment;
                }              
                $period = new CarbonPeriod($start_date, '1 '. $request->view_type, $end_date);
                foreach ($period as $index => $date) {
                    $dateString = $date->format($format);
                    if (!array_key_exists($dateString, $investments)) {
                        $investments[$dateString] = ['date' => $dateString, 'amount' => 0, 'investors' => 0];
                    }
                }
                ksort($investments);
                usort($investments, function($a, $b) {
                    return strtotime($a['date']) - strtotime($b['date']);
                });
                $investments = array_values($investments);
                
                $total_investment_scope = 0;
                
                foreach($investments as $investment) {
                    $total_investment_scope += $investment['amount'];
                } 

                $investors = $company->stocks()
                ->select('userId')
                ->whereBetween('created_at', [$start_date->format('Y-m-d')." 00:00:00", $end_date->format('Y-m-d')." 23:59:59"])
                ->distinct()
                ->count('userId');

                $total_investment = $company->stocks()
                    ->sum('invested');

                $total_inqueries = $company->inquery()
                    ->whereBetween('inqueries.created_at', [$start_date->format('Y-m-d')." 00:00:00", $end_date->format('Y-m-d')." 23:59:59"])
                    ->count();
                return response()->json(['status' => 'Success', 'investments' => $investments, 'total_investment' => number_format($total_investment, 0) ,'total_investment_scope' => number_format($total_investment_scope,0),'total_inqueries'=>number_format($total_inqueries, 0), 'investors' => $investors, 'company' => $company, 'owner' => $company->ownerName],200);
            }

        }
    }

    public function statuschange(Request $request) {
        if (request()->ajax()) {
            $rules = array(
                'stockid'=>'required',
                'status'=>'required'
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput(); // Form calling with Errors and Input values
            } else {
                $stock = Stock::find($request->stockid);
                $stock->status = $request->status;
                $stock->save();
                return response()->json(['status' => 'Success'],201);
            }

        }
    }

    public function isSentCheck(Request $request) {
        if (request()->ajax()) {
            $stock = Stock::find($request->stock_id);
            $stock->is_sent = $request->is_sent==0 ? 1 : 0;
            $stock->save();
            return response()->json([
                'status' => 'Success',
                'message'=> 'Sent Request'
            ],201);
        }
    }

    public function statistic_shareholder(Request $request) {
        if (request()->ajax()) {
            $shareholders = Stock::join('companies', 'stocks.companyId', '=', 'companies.id')
            ->join('customers', 'customers.id', '=', 'stocks.userId')
            ->orderBy('stocks.date', 'DESC')
            ->select(['stocks.id',
            DB::raw("DATE_FORMAT(stocks.date, '%Y.%m.%d') AS date"),
            'customers.name AS name',
            'customers.gender',
            'customers.phonenumber1',
            'customers.age',
            'customers.customerGroupID',
            'stocks.companyId',
            'stocks.userId',
            'stocks.stockPrice',
            'stocks.quantity',
            'stocks.invested', 
            'stocks.createdBy']);
            if (request()->has('company_filter')) {
                $company_filter = request()->get('company_filter');
                if (!empty($company_filter)) {
                    $shareholders->where('stocks.companyId', $company_filter);
                }
            }
            if (!empty(request()->start_date) && !empty(request()->end_date)) {
                $start = request()->start_date;
                $end =  request()->end_date;
                $shareholders->whereDate('stocks.date', '>=', $start)
                    ->whereDate('stocks.date', '<=', $end);
            }
            $shareholders->groupBy('stocks.userId')
                ->select(['stocks.id',
                DB::raw("DATE_FORMAT(stocks.date, '%Y.%m.%d') AS date"),
                'customers.name AS name',
                'customers.gender',
                'customers.phonenumber1',
                'customers.age',
                'customers.customerGroupID',
                'stocks.companyId',
                'stocks.userId',
                DB::raw('avg(stocks.stockPrice) as stockPrice'),
                DB::raw('sum(stocks.quantity) as quantity'),
                DB::raw('sum(stocks.invested) as invested'), 
                'stocks.createdBy']);
            
            return Datatables::of($shareholders)
                ->addColumn(
                    'action', function($row) {
                        $action   = '<a href="'.route("admin.messages").'?customer_id='.$row->userId.'" class="btn btn-outline-primary email_box">
                                        <i class="mdi mdi-email-outline"></i>
                                    </a>
                                    <a href="javascript:void(0);" class="btn btn-primary btn_customer_memo" data-id="'.$row->userId.'">
                                        <i class="mdi mdi-pencil-box-multiple"></i>  메모
                                    </a>';
                        return $action;
                    }
                )
                ->addColumn('mass_delete', function($row) {
                    
                    return '<input type="checkbox" class="form-check-input" value="'.$row->id.'" />';
                })
                ->editColumn('gender', function ($row) {
                    $gender = $row->gender=='Male' ? '남' : ($row->gender=='Female' ? '여' : '기타');
                    return $gender;
                })
                ->editColumn('name', function ($row) {
                    $name = $row->name;
                    return '<a href="'.url('admin/edit_customer/'.$row->userId).'">'.$name.'</a>';
                })
                
                ->editColumn('invested', function ($row) {
                    return number_format($row->invested);
                })
                ->editColumn('stockPrice', function ($row) {
                    return number_format($row->stockPrice);
                })
                ->editColumn('quantity', function ($row) {
                    return number_format($row->quantity);
                })
                ->editColumn('phonenumber1', function ($row) {
                    $phonenumber1 = $row->phonenumber1 ? $row->phonenumber1 : 0 ;
                    return $this->helper->formatPhoneNum($phonenumber1);
                })
                ->editColumn('customerGroupID', function ($row) {
                    $customergroup = $row->customerGroupID ? Customergroup::find($row->customerGroupID) : "";
                    return $customergroup ? $customergroup->groupName : '';
                })
                
                ->filterColumn('name', function ($query, $keyword) {
                    $query->whereRaw("CONCAT(COALESCE(name, '')) like ?", ["%{$keyword}%"]);
                })
                ->filterColumn('gender', function ($query, $keyword) {
                    $query->whereRaw("CONCAT(COALESCE(gender, '')) like ?", ["%{$keyword}%"]);
                })
                ->filterColumn('age', function ($query, $keyword) {
                    $query->whereRaw("CONCAT(COALESCE(age, '')) like ?", ["%{$keyword}%"]);
                })
                ->filterColumn('phonenumber1', function ($query, $keyword) {
                    $query->whereRaw("CONCAT(COALESCE(phonenumber1, '')) like ?", ["%{$keyword}%"]);
                })
                ->filterColumn('customerGroupID', function ($query, $keyword) {
                    $query->whereRaw("CONCAT(COALESCE(customerGroupID, '')) like ?", ["%{$keyword}%"]);
                })
                ->rawColumns(['action', 'name','gender','mass_delete', 'invested', 'quantity', 'stockPrice'])
                ->make(true);
        }
    }

    public function statistics_shareholder_chart(Request $request) {
        if (request()->ajax()) {
            $rules = array(
                'view_type'=> ['required', Rule::in(['day', 'week', 'month']) ],
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'error' => $validator->errors()->all()],201);
            } else {
                switch ($request->view_type) {
                    case 'day':
                        $defaultSubDays = Carbon::today()->subDays(10);
                        $groupBy = "DATE(date)";
                        $format = "Y.m.d";
                        break;
                    case 'month':
                        $defaultSubDays = Carbon::today()->subMonths(10);
                        $groupBy = "DATE_FORMAT(date, \"%Y-%m-01\")";
                        $format = "F Y";
                        break;
                    case 'week':
                        $defaultSubDays = Carbon::today()->subWeeks(10);
                        $groupBy = "CONCAT(YEAR(date), '/', WEEK(date))";
                        $format = "m.d";
                        break;
                }
                $start_date = !empty($request->start_date) ? new Carbon($request->start_date) : $defaultSubDays;
                $end_date = !empty($request->end_date) ? new Carbon($request->end_date) : Carbon::today();
                $investmentsResult = Stock::join('companies', 'stocks.companyId', '=', 'companies.id')
                    ->whereBetween('stocks.date', [$start_date->format('Y-m-d')." 00:00:00", $end_date->format('Y-m-d')." 23:59:59"])
                    ->select([
                        DB::raw('sum(stocks.invested) as amount'),
                        DB::raw('COUNT(DISTINCT stocks.userId) as investors'),
                        DB::raw($groupBy.' as date'),
                    ])
                    ->groupBy(DB::raw($groupBy))
                    ->get()
                    ->keyBy('date');
                $investmentsResult = $investmentsResult->values()->toArray();
                $investments = [];
                foreach($investmentsResult as $investment) {
                    $date = ($request->view_type != 'week') ? new Carbon($investment['date']) : Carbon::now();
                    if($request->view_type == 'week') {
                        $d = explode('/', $investment['date']);
                        $date->setISODate($d[0],$d[1]);
                        $date = $date->startOfWeek();
                    }

                    $date = $date->format($format);
                    $investment['date'] = $date;
                    $investments[$date] = $investment;
                }

                $period = new CarbonPeriod($start_date, '1 '. $request->view_type, $end_date);
                foreach ($period as $index => $date) {
                    $dateString = $date->format($format);
                    if (!array_key_exists($dateString, $investments)) {
                        $investments[$dateString] = ['date' => $dateString, 'amount' => 0, 'investors' => 0];
                    }
                }

                ksort($investments);
                usort($investments, function($a, $b) {
                    return strtotime($a['date']) - strtotime($b['date']);
                });
                $investments = array_values($investments);
                
                $total_investment_scope = 0;
                
                foreach($investments as $investment) {
                    $total_investment_scope += $investment['amount'];
                } 
                $total_statistis = Stock::join('companies', 'stocks.companyId', '=', 'companies.id')
                    //->whereBetween('stocks.date', [$start_date->format('Y-m-d')." 00:00:00", $end_date->format('Y-m-d')." 23:59:59"])
                    ->select([
                        'companies.companyName',
                        DB::raw('sum(stocks.invested) as amount'),
                    ])
                    ->groupBy('stocks.companyId')
                    ->orderBy('amount', 'DESC')
                    ->get();
                $total_statistis_scope = 0;
                foreach($total_statistis as $total_s) {
                    $total_statistis_scope += $total_s->amount;
                    $total_s->backgroundColor = 'rgb(' . rand(0, 255) . ',' . rand(0, 255) . ',' . rand(0, 255) . ')';
                }
                foreach($total_statistis as $total_s) {
                    $total_s->percent = round(($total_s->amount / $total_statistis_scope) * 100, 1);
                }

                $html = view('admin.user-records.stocks.ajax-all-statistic')
                    ->with(compact('total_statistis'))->render();

                $total_investor = Stock::join('companies', 'stocks.companyId', '=', 'companies.id')
                ->select('stocks.userId')
                ->whereBetween('stocks.date', [$start_date->format('Y-m-d')." 00:00:00", $end_date->format('Y-m-d')." 23:59:59"])
                ->distinct()
                ->count('stocks.userId');
                $total_all_investor = Stock::join('companies', 'stocks.companyId', '=', 'companies.id')
                ->select('stocks.userId')
                ->distinct()
                ->count('stocks.userId');
                $total_inqueries = Inquery::join('companies', 'inqueries.companyId', '=', 'companies.id')
                ->whereBetween('inqueries.created_at', [$start_date->format('Y-m-d')." 00:00:00", $end_date->format('Y-m-d')." 23:59:59"])
                ->count();
                
                return response()->json(['status' => 'success', 'investments' => $investments,'total_invested'=> $total_investment_scope, 'total_investor'=> $total_investor, 'total_all_investor'=> $total_all_investor, 'total_inqueries'=>number_format($total_inqueries, 0), 'html' => $html],200);

            }
        }
    }

    public function statisticsevenstock(Request $request) {
        if (request()->ajax()) {
            $stocks = Stock::join('companies', 'stocks.companyId', '=', 'companies.id')
            ->join('customers', 'customers.id', '=', 'stocks.userId')
            ->orderBy('stocks.date', 'DESC')
            ->groupBy('stocks.userId')
            ->select([
            'customers.name AS name',
            'customers.gender',
            'customers.phonenumber1',
            'customers.city_id',
            'stocks.companyId',
            'stocks.userId',
            DB::raw('avg(stocks.stockPrice) as stockPrice'),
            DB::raw('sum(stocks.quantity) as quantity'),
            DB::raw('sum(stocks.invested) as invested'), 
            'stocks.createdBy']);
            if (request()->has('searchval')) {
                $searchval = request()->get('searchval');
                if (!empty($searchval)) {
                    if ($searchval){
                        $stocks->where('customers.phonenumber1', 'like', '%' . $searchval . '%');
                        $stocks->orWhere('customers.name', 'like', '%' . $searchval . '%');
                    } 
                }
            }
            if (request()->has('pagelen')) {
                $pagelen = request()->get('pagelen');
                if (!empty($pagelen)) {
                    $stocks = $stocks->paginate($pagelen);
                }
            } else {
                $stocks = $stocks->paginate(100);
            }
            
            $companies = Company::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
            $html = view('admin.user-records.stocks.ajax-seven-statistic')
                    ->with(compact('stocks','companies'))->render();

            $output = ['html' => $html, 'success' => true, 'msg' => '' ];

            return $output;

        }
    }
}
