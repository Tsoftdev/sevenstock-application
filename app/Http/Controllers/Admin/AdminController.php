<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use App\Models\User;
use App\Models\Stock;
use App\Http\Start\Helpers;
use Validator;
use Session;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Feedhistory;
use App\Models\ContactInquiries;

class AdminController extends Controller
{

    protected $helper; // Global variable for instance of Helpers
    
    public function __construct()
    {
        $this->helper = new Helpers;
    }

    public function index() {
        $periods = range(Carbon::now()->year - 1, Carbon::now()->year);
        //$periods = new CarbonPeriod(Carbon::now()->subYear(), '1 month', Carbon::now());
        return view('admin.index')->with(compact('periods'));
    }

    public function feedhistorylist(Request $request){
        if (request()->ajax()) {
            $feedhistories = Feedhistory::join('users', 'feedhistories.createdBy', '=', 'users.id')
                ->join('customers', 'customers.id', '=', 'feedhistories.customerId')
                ->orderBy('feedhistories.created_at', 'DESC')
                ->select([
                    'feedhistories.id',
                    'feedhistories.feedname',
                    'customers.name',
                    'customers.email',
                    'customers.phonenumber1',
                    'users.name as UserName',
                    DB::raw("DATE_FORMAT(feedhistories.created_at, '%Y.%m.%d %h:%i %p') as date"),
                ]);

            if (request()->has('desksearch')) {
                $desksearch = request()->get('desksearch');
                if (!empty($desksearch)) {
                    $emailcheck = strpos($desksearch, '@');
                    if($emailcheck !== false) {
                        $feedhistories->where('customers.email', $desksearch);
                    } else if ($desksearch){
                        $feedhistories->where('customers.phonenumber1', 'like', '%' . $desksearch . '%');
                        $feedhistories->orWhere('customers.name', 'like', '%' . $desksearch . '%');
                    } 
                }
            }
    
            if (request()->has('mobilesearch')) {
                $mobilesearch = request()->get('mobilesearch');
                if (!empty($mobilesearch)) {
                    $emailcheck = strpos($mobilesearch, '@');
                    if($emailcheck !== false) {
                        $feedhistories->where('customers.email', $mobilesearch);
                    } else if ($mobilesearch) {
                        $feedhistories->where('customers.phonenumber1', 'like', '%'. $mobilesearch . '%');
                        $feedhistories->orWhere('customers.name', 'like', '%' . $mobilesearch . '%');
                    } 
                }
            }
            $feedhistories = $feedhistories->limit(10)->get();

            $html = view('admin.dashboards.ajax-feedhistory')->with(compact('feedhistories'))->render();
        
            $output = ['html' => $html, 'success' => true, 'msg' => '' ];

            return $output;
        }
    }

    public function contactlist(Request $request) {
        if (request()->ajax()) {

            $contacts = ContactInquiries::orderBy('created_at', 'DESC')
                ->select([
                'id',
                'name',
                'company_name',
                'phone_number',
                'inquiry',
                'inquiry_type',
                DB::raw("DATE_FORMAT(created_at, '%Y.%m.%d %h:%i %p') as date"),
            ]);

            if (request()->has('contact_type')) {
                $contact_type = request()->get('contact_type');
                if (!empty($contact_type)) {
                    if($contact_type != "all") {
                        $contacts->where('inquiry_type', $contact_type);
                    }
                    
                }
            }
            $contacts = $contacts->get();
            $html = view('admin.dashboards.ajax-contact')->with(compact('contacts'))->render();
        
            $output = ['html' => $html, 'success' => true, 'msg' => '' ];

            return $output;
        }
    }

    public function login()
        {
            return view('admin.auth.login');
        }

    public function authenticate(Request $request) {
        if($request->getmethod() == 'GET') {
            return redirect()->route('admin_login');
        }
        
        $admin = User::where('email', $request->email)->first();
        if(isset($admin)) {
            if(Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
                return redirect()->intended('admin/dashboard'); // Redirect to dashboard page
            }
            $this->helper->flash_message('danger', 'Log In Failed. Please Check Your Email/Password'); // Call flash message function
            request()->flashExcept('password');
            return redirect('admin/login')->withInput(request()->except('password')); // Redirect to login page
        }
        $this->helper->flash_message('danger', 'Log In Failed. You are Blocked by Admin.'); // Call flash message function
        request()->flashExcept('password');
        return redirect('admin/login')->withInput(request()->except('password')); // Redirect to login page
    }

    public function logout() {
        Auth::guard('admin')->logout();

        return redirect('admin/login');
    }

    public function exportDB()
    {
        $targetTables = [];
        $newLine = "\r\n";

        $targetTables  = array_map('reset', \DB::select('SHOW TABLES'));

        foreach($targetTables as $table){
            $tableData = DB::select(DB::raw('SELECT * FROM '.$table));
            $res = DB::select(DB::raw('SHOW CREATE TABLE '.$table));

            $cnt = 0;
            $temp_result = (json_decode(json_encode($res[0]), true));
            $content = (!isset($content) ?  '' : $content) . $temp_result["Create Table"].";" . $newLine . $newLine;

            foreach($tableData as $row){
                $subContent = "";
                $firstQueryPart = "";
                if($cnt == 0 || $cnt % 100 == 0){
                    $firstQueryPart .= "INSERT INTO {$table} VALUES ";
                    if(count($tableData) > 1)
                        $firstQueryPart .= $newLine;
                }

                $valuesQuery = "(";
                foreach($row as $key => $value){
                    $valuesQuery .= $value . ", ";
                }

                $subContent = $firstQueryPart . rtrim($valuesQuery, ", ") . ")";

                if( (($cnt+1) % 100 == 0 && $cnt != 0) || $cnt+1 == count($tableData))
                    $subContent .= ";" . $newLine;
                else
                    $subContent .= ",";

                $content .= $subContent;
                $cnt++;
            }
            $content .= $newLine;
        }

        $content = trim($content);

        $backup_name = env('DB_DATABASE').".sql";
        header('Content-Type: application/octet-stream');   
        header("Content-Transfer-Encoding: Binary"); 
        header("Content-disposition: attachment; filename=\"".$backup_name."\"");  
        echo $content; exit;
    }
}
