<?php
namespace App\Http\Controllers\Admin;

use DB;
use Hash;
use Auth;
use Session;
use Validator;
use Carbon\Carbon;
use App\Models\City;
use App\Models\File;
use App\Models\User;
use App\Models\Stock;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Category;
use App\Models\SmsRecord;
use App\Models\Customergroup;
use App\Http\Start\Helpers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class SmsController extends Controller
{
    protected $helper; // Global variable for instance of Helpers
    protected $key='9isdhr0rx3riobjyljafy58x6l3i91vr';
    protected $user_id='7stockshare';
    protected $sender='02-529-1001';

    public function __construct(){
        $this->helper = new Helpers;
    }

    public function index(Request $request) {
        
        if (request()->ajax()) {
            $customer = Customer::leftjoin('cities', 'cities.id', '=', 'customers.city_id')
            ->select(['customers.id','customers.name','cities.cityName', 'customers.phonenumber1','customers.customerGroupID']);

            if (request()->has('group_filter')) {
                $group_filter = request()->get('group_filter');
                if (!empty($group_filter)) {
                    $customer->where('customers.customerGroupID', $group_filter);
                }
            }
            if (request()->has('company_filter')) {
                $company_filter = request()->get('company_filter');
                if (!empty($company_filter)) {
                    $stocks = Stock::where('companyId', $company_filter)->select('userId')->distinct()->get();
                    $companyid = array();
                    foreach ($stocks as $key => $value) {
                        array_push($companyid, $value['userId']);
                    }
                    $customer->whereIn('customers.id', $companyid);
                }
            }
            if (request()->has('city_filter')) {
                $city_filter = request()->get('city_filter');
                if (!empty($city_filter)) {
                    $customer->where('customers.city_id', $city_filter);
                }
            }
            $customer_id = request()->get('customer_id');
            return Datatables::of($customer)
                ->addColumn('mass_delete', function($row) use($customer_id){
                    $checked =  $customer_id > 0 && $customer_id==$row->id ? 'checked' : '';
                    return '<input type="checkbox" name="customer_ids" data-name="'.$row->name.'" data-phone="'.$row->phonenumber1.'" value="'.$row->id.'" id="name_'.$row->id.'" class="form-check-input selectCheckbox" '.$checked.'>';
                })
                 
                ->editColumn('customerGroupID', function ($row) {
                    return $row->customerGroup ? $row->customerGroup->groupName : '';
                })
                ->rawColumns(['mass_delete','name','cityName','phonenumber1', 'customerGroupID'])
                ->make(true);   
        }

        $companies      = Company::get();
        $categories     = Category::get();

        $cities         = City::pluck('cityName','id');
        $cities->prepend('지역','');

        $customerGroups = Customergroup::pluck('groupName','id');
        $customerGroups->prepend('담당자','');

        $titles          = File::orderBy('id','DESC')->get();
        $smsRecords     = $request->get('period') ? SmsRecord::whereDate('date', date('Y-m-d', strtotime(str_replace('.','-',$request->get('period')))))->orderBy('id','DESC')->get() : SmsRecord::orderBy('id','DESC')->get();
        $smsRemain      = $this->getRemain();
        return view('admin.sms.index',compact('categories','companies','cities','customerGroups','titles','smsRecords','smsRemain'));
    }

    public function getTitlesByCategory(Request $request){
        if($request->ajax()){
            $category_id = $request->category_id;
            if($category_id==null){
                $titles = File::orderBy('id','DESC')->get();
            }else{
                $titles = File::whereHas('categories', function($query){
                    $query->where('category_id', request()->category_id);
                })->get();
                // Category::find($request->category_id);
                // $titles = $category->titles;
            }
            $view = view('admin.sms.categoryTitles',compact('titles'))->render();
            return response()->json([
                'success'   => true,
                'html'      => $view
            ],200);
        }
    }
    
    /*public function index() {
        $collection  = Customer::select('customers.*');

        if (request()->has('group_id')) {
            $group_id = request()->get('group_id');
            if (!empty($group_id)) {
                $collection->where('customerGroupID', $group_id);
            }
        }
        
        if (request()->has('company_id')) {
            $company_id = request()->get('company_id');
            if (!empty($company_id)) {
                $stocks = Stock::where('companyId', $company_id)->select('userId')->distinct()->get();
                $companyid = array();
                foreach ($stocks as $key => $value) {
                    array_push($companyid, $value['userId']);
                }
                $collection->whereIn('customers.id', $companyid);
            }
        }
         
        if (request()->has('city_id')) {
            $city_id = request()->get('city_id');
            if (!empty($city_id)) {
                $collection->where('customers.city_id', $city_id);
            }
        }
        
        if(isset(request()->start_date) && request()->start_date !='' && isset(request()->end_date) && request()->end_date !=''){
            $form = Carbon::parse(request()->start_date)->format('Y-m-d');
            $to = Carbon::parse(request()->end_date)->format('Y-m-d');
            $collection->whereBetween('date', [$form, $to]);

        }else if(isset(request()->start_date) && request()->start_date !=''){  
            $form = Carbon::parse(request()->start_date)->format('Y-m-d');
            $collection->whereDate('date',$form);

        }else if(isset(request()->end_date) && request()->end_date !=''){
            $to = Carbon::parse(request()->end_date)->format('Y-m-d');
            $collection->whereDate('date',$to);
        }
        
        $customers = $collection->get();

        $companies  = Company::get();
        $categories  = Category::get();
        $cities  = City::pluck('cityName','id');
        $cities->prepend('City','');
        $customerGroups  = Customergroup::pluck('groupName','id');
        $customerGroups->prepend('Group','');
        $files      = File::orderBy('id','DESC')->get();
        $smsRecords = SmsRecord::orderBy('id','DESC')->get();
        $smsRemain = $this->getRemain();
        return view('admin.sms.index',compact('customers','categories','companies','cities','customerGroups','files','smsRecords','smsRemain'));
    }*/

    //title create and update with assign category
    public function fileStore(Request $request) {
        if($request->isMethod('post') && $request->ajax()){

            //Start Validation
            $messages = [
                'description.required'  => 'Contant field is required.',
                'name.required'         => 'Title field is required.',
                //'category_id.required'  => 'Please first select category.',
            ];
            $validator = Validator::make($request->all(), [
                'description'   => 'required',
                'name'          => 'required',
                //'category_id'   => 'required',
            ],$messages);
            if ($validator->fails()) {
                return response()->json(['error'=>$validator->errors()], 401);            
            } 
            //end Validation

            $file               = new File;
            $file               = $request->title_id > 0 ? File::find($request->title_id) : new File;
            $file->name         = $request->name;
            $file->description  = $request->description;
            $file->save();
            //$file->categories()->attach($request->category_id);
            
            return response()->json([
                'success'       => true,
                'message'       => $request->title_id > 0 ? 'Title has been updated.' : 'Title has been created.',
                'redirect_url'  => url("admin/messages"),
                'reload'        => false
            ],200);
        }
    }

    //title record delete with assign category
    public function fileDelete(Request $request, $id){
        if(File::find($id)){
            $file = File::find($id);
            $file->delete();
            return redirect()->back()->with('success','File has been deleted successfully.');
        }
    }

    //category create and update
    public function categoryStore(Request $request) {
        if($request->isMethod('post') && $request->ajax()){

            //Start Validation
            $messages = [
                'name.required'   => 'Category name field is required.',
            ];
            $validator = Validator::make($request->all(), [
                'name'    => 'required',
            ],$messages);
            if ($validator->fails()) {
                return response()->json(['error'=>$validator->errors()], 401);            
            } 

            $category       = $request->categoryId > 0 ? Category::find($request->categoryId) : new Category;
            $category->name = $request->name;
            $category->save();
            return response()->json([
                'success'       => true,
                'message'       => $request->categoryId > 0 ? 'Category has been updated.' : 'Category has been created.',
                'redirect_url'  => url("admin/messages"),
                'reload'        => false
            ],200);
        }
    }

    //category delete
    public function categoryDelete(Request $request, $id){
        if(Category::find($id)){
            $category = Category::find($id);
            $category->delete();
            return redirect()->back()->with('success','Category has been deleted successfully.');
        }
    }

    public function sendSms(Request $request){
        if($request->ajax()){
            $customers = json_decode($request->customer);
            if(count($customers) > 0){
                $phones = implode(',',array_column($customers, 'phone'));
                $output = $this->sendBulkMessage($phones, $request->message, $request->picture, $request);
                if(isset($output['result_code']) && $output['result_code']==1){
                    $smsRecord              = new SmsRecord;
                    $smsRecord->date        = date("Y-m-d");
                    $smsRecord->type        = $output['msg_type'];
                    $smsRecord->sender      = $this->sender;
                    $smsRecord->sms_count   = $output['success_cnt'];
                    $smsRecord->status      = $output['message'];
                    $smsRecord->fail_count  = $output['error_cnt'];
                    $smsRecord->save();
                    return response()->json([
                        'success'       => true,
                        'message'       => 'Message sent',
                        'redirect_url'  => url("admin/messages"),
                        'reload'        => false
                    ],200);
                }else{
                    return response()->json(['error'=>[[$output['message']]]],400);
                }
            }else{
                return response()->json(['error'=>[['Please first select customer']]],400);
            }
        }
    }

    public function sendBulkMessage($phones, $message, $picture, $request){

        if($picture){
            $msg_type = 'MMS';
        }else if(strlen($message) > 90){
            $msg_type = 'LMS';
        }else{
            $msg_type = 'SMS';
        }

        $picture = '';
        $oCurl = curl_init();
        $sms['user_id'] = $this->user_id;
        $sms['key'] = $this->key;
        $sms['msg'] = stripslashes($message);
        $sms['receiver'] = $phones;
        //$sms['receiver'] = '010-7207-5522';
        //$sms['destination'] = $_POST['destination'];
        $sms['sender'] = $this->sender;
        if($request->is_scheduled == 'on'){
            if($request->date != ''){
                $sms['rdate'] = date('Ymd',strtotime($request->date));
            }

            if($request->time != ''){
                $sms['rtime'] = date('Hi',strtotime($request->time));
            }
        }
        $sms['testmode_yn'] = empty($request->testmode_yn) ? '' : $request->testmode_yn;
        //$sms['title'] = $_POST['subject'];
        $sms['msg_type'] = $msg_type;
        if($request->hasFile('picture')) {
            $file = $request->file('picture');
            $tmp_filetype = mime_content_type($file->getPathName());
            if($tmp_filetype != 'image/png' && $tmp_filetype != 'image/jpg' && $tmp_filetype != 'image/jpeg') $picture = '';
            else {
                $destinationPath = public_path('/assets/images/sms');
                if (! File::exists($destinationPath)){
                    File::makeDirectory( $destinationPath );
                }
                $filename = $file->getClientOriginalName();
                if($file->move($destinationPath, $filename)) {
                    $picture  = $destinationPath.'/'.$filename;
                    if ((version_compare(PHP_VERSION, '5.5') >= 0)) { // PHP 5.5버전 이상부터 적용
                        $sms['image'] = new \CURLFile($picture, $tmp_filetype, $filename);
                        curl_setopt($oCurl, CURLOPT_SAFE_UPLOAD, true);
                    } else {
                        $sms['image'] = '@'.$picture.';filename='.$filename. ';type='.$tmp_filetype;
                    }                    
                }
            }
        }

        /*****/
        $sms_url = "https://apis.aligo.in/send/";
        $host_info = explode("/", $sms_url);
        $port = $host_info[0] == 'https:' ? 443 : 80;

        curl_setopt($oCurl, CURLOPT_PORT, $port);
        curl_setopt($oCurl, CURLOPT_URL, $sms_url);
        curl_setopt($oCurl, CURLOPT_POST, 1);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($oCurl, CURLOPT_POSTFIELDS, $sms);
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
        $ret = curl_exec($oCurl);
        curl_close($oCurl);
        $output = json_decode($ret, JSON_UNESCAPED_UNICODE);
        return $output;
    }

    public function send($url, $params){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close ($ch);
        $output = json_decode($server_output,JSON_UNESCAPED_UNICODE);
        return $output;
    }

    public function getRemain(){
        $params = "key=".$this->key."&user_id=".$this->user_id;
        $output = $this->send("https://apis.aligo.in/remain/", $params);
        return $output;
    }
}