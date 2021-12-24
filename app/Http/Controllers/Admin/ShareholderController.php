<?php

namespace App\Http\Controllers\Admin;
use Excel;
use DB;
use Auth;
use Session;
use Validator;
use Carbon\Carbon;
use App\Models\Stock;
use App\Models\City;
use App\Models\Company;
use App\Models\Routeknown;
use App\Models\Customergroup;
use App\Exports\ShareholderExport;
use App\Http\Start\Helpers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class ShareholderController extends Controller
{
    protected $helper; // Global variable for instance of Helpers
    
    public function __construct() {
        $this->helper = new Helpers;
    }

    public function index() {
        if (request()->ajax() || request()->filled('export')) {
            $shareholders = Stock::join('companies', 'stocks.companyId', '=', 'companies.id')
                ->join('customers', 'customers.id', '=', 'stocks.userId')
                ->orderBy('stocks.date', 'DESC')
                ->select(['stocks.id',
                DB::raw("DATE_FORMAT(stocks.date, '%Y.%m.%d') AS date"),
                'customers.name AS name',
                'customers.gender',
                'customers.email',
                'customers.phonenumber1',
                'customers.age',
                'customers.city_id',
                'customers.customerGroupID',
                'stocks.companyId',
                'stocks.userId',
                'stocks.stockPrice',
                'stocks.quantity',
                'stocks.invested', 
                'stocks.createdBy']);

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
                    $shareholders->whereIn('customers.id', $companyid);
                }
            }

            if (request()->has('group_filter')) {
                $group_filter = request()->get('group_filter');
                if (!empty($group_filter)) {
                    $shareholders->whereIn('customers.customerGroupID', $group_filter);
                }
            }

            if(request()->get('onload') == 'no') {
                if (request()->has('from_range') && request()->has('to_range')) {
                    $from_range = request()->get('from_range');
                    $to_range   = request()->get('to_range');
                    if(!empty($from_range) && !empty($to_range)){
                        $shareholders->whereBetween('stocks.invested', [$from_range * 1000000, $to_range * 1000000]);
                    }
                }
            }
            if (request()->has('route_filter')) {
                $route_filter = request()->get('route_filter');
                if (!empty($route_filter)) {
                    $shareholders->where('customers.routesOfKnownID', $route_filter);
                }
            }

            if (request()->has('city_filter')) {
                $city_filter = request()->get('city_filter');
                if (!empty($city_filter)) {
                    $shareholders->where('customers.city_id', $city_filter);
                }
            }
            if (!empty(request()->start_date) && !empty(request()->end_date)) {
                $start = request()->start_date;
                $end =  request()->end_date;
                $shareholders->whereDate('stocks.date', '>=', $start)
                        ->whereDate('stocks.date', '<=', $end);
            }
            if (request()->has('desksearch')) {
                $desksearch = request()->get('desksearch');
                if (!empty($desksearch)) {
                    $emailcheck = strpos($desksearch, '@');
                    if($emailcheck !== false) {
                        $shareholders->where('customers.email', $desksearch);
                    } else if ($desksearch){
                        $shareholders->where('customers.phonenumber1', 'like', '%' . $desksearch . '%');
                        $shareholders->orWhere('customers.name', 'like', '%' . $desksearch . '%');
                    } 
                }
            }

            if (request()->has('mobilesearch')) {
                $mobilesearch = request()->get('mobilesearch');
                if (!empty($mobilesearch)) {
                    $emailcheck = strpos($mobilesearch, '@');
                    if($emailcheck !== false) {
                        $shareholders->where('customers.email', $mobilesearch);
                    } else if ($mobilesearch) {
                        $shareholders->where('customers.phonenumber1', 'like', '%'. $mobilesearch . '%');
                        $shareholders->orWhere('customers.name', 'like', '%' . $mobilesearch . '%');
                    } 
                }
            }

            
            $shareholders->groupBy('stocks.userId')
                ->select(['stocks.id',
                'customers.name AS name',
                'customers.gender',
                'customers.phonenumber1',
                'customers.age',
                'customers.city_id',
                'customers.customerGroupID',
                'stocks.companyId',
                'stocks.userId',
                DB::raw('avg(stocks.stockPrice) as stockPrice'),
                DB::raw('sum(stocks.quantity) as quantity'),
                DB::raw('sum(stocks.invested) as invested'),
                'stocks.createdBy']);

            if(request()->has('export')){
                $shareholders = $shareholders->get();
                $filename = 'shareholders_.'.time().'.xlsx';
                Excel::store(new ShareholderExport($shareholders),$filename,'uploads');

                return response()->json(['file'=>$filename, 'url'=> url('uploads/'.$filename)]);
            }

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
                ->rawColumns(['action', 'name','gender','mass_delete', 'invested', 'quantity', 'stockPrice'])
                ->make(true);
        }
        $total_shareholders = number_format(Stock::join('companies', 'stocks.companyId', '=', 'companies.id')
            ->select('stocks.userId')
            ->distinct()
            ->count('stocks.userId'));

        $cities = City::where('isActive','Y')->where('isDelete','N')->where('isApproved','Y')->pluck('cityName','id');
        $groups = Customergroup::where('isActive','Y')->where('isDelete','N')->where('isApproved','Y')->get();
        $companies = Company::with('stocks')->where('isActive','Y')->where('isDelete','N')->where('isApproved','Y')->get();
        $stocks = Stock::whereIn('companyId',$companies->pluck('id'))->get();
        $routeknowns = Routeknown::where('isActive','Y')->where('isDelete', 'N')->where('isApproved','Y')->pluck('routeName','id');
        return view('admin.shareholder.index')->with(compact('total_shareholders', 'stocks', 'companies', 'groups', 'cities', 'routeknowns'));
    }
}
