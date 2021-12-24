<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use DB;
use Validator;
use Session;
use App\Models\Inquery;
use App\Models\Customer;
use App\Models\Adminmemo;
use Carbon\Carbon;

class NotificationController extends Controller
{
    public function userlist(Request $request) {
        if(request()->ajax()) {
            $notifies = Customer::all();
            
            $html = view('admin.notify.notify-user-list')->with(compact('notifies'))->render();
            
            $output = ['html' => $html, 'success' => true, 'msg' => '' ];

            return $output;
        }
    }

    public function usersearchlist(Request $request) {
        if(request()->ajax()) {
            $notifies = Customer::where('phonenumber1', 'like', '%' . $request->searchval . '%')
                ->orWhere('name', 'like', '%' . $request->searchval . '%')->get();
            
            $html = view('admin.notify.notify-user-list')->with(compact('notifies'))->render();
            
            $output = ['html' => $html, 'success' => true, 'msg' => '' ];

            return $output;
        }
    }
    public function usermemolist(Request $request) {
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
            if(!empty($request->pin)) {
                $pin = true;
            } else {
                $pin = false;
            }
            $customer = Customer::find($request->customer_id);
            $html = view('admin.notify.usermemolist')->with(compact('memoes', 'customer', 'pin'))->render();
            
            $output = ['html' => $html, 'success' => true, 'msg' => '' ];

            return $output;
        }
    }

    public function usermemoadd(Request $request) {
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
                $inquery->customerId = $request->customer;
                $inquery->companyId = $request->company;
                $inquery->createdBy = Auth::guard('admin')->user()->id;
                $inquery->save();

                return response()->json(['status' => 'success'],200);
            }
        }
    }

    public function usermemoupdate(Request $request) {
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
                $inquery->customerId = $request->customer;
                $inquery->companyId = $request->company;
                $inquery->createdBy = Auth::guard('admin')->user()->id;
                $inquery->save();

                return response()->json(['status' => 'success'],200);
            }
        }
    }

    public function usermemodelete(Request $request) {
        if(request()->ajax()) {
            $inquery = Inquery::find($request->memo_id);
            $inquery->delete();
            return response()->json(['status' => 'success'],200);
        }
    }

    public function usergetmemo(Request $request) {
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
    public function userpinmemo(Request $request) {
        if (request()->ajax()) {
            $inquery = Inquery::find($request->memoid);
            $inquery->created_at = date('Y-m-d H:i:s');
            $inquery->save();
            return response()->json(['status' => 'success'],200);
        }
    }
    public function adminpinmemo(Request $request) {
        if (request()->ajax()) {
            $inquery = Inquery::find($request->memoid);
            $inquery->created_at = date('Y-m-d H:i:s');
            $inquery->save();
            return response()->json(['status' => 'success'],200);
        }
    }
    public function adminmemoadd(Request $request) {
        if(request()->ajax()) {
            $rules = array(
                'note'  => 'required',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } 
            else {
                
                $adminmemo = new Adminmemo;
                $adminmemo->note = $request->note;
                if (!empty($request->admin)) {
                    $adminmemo->isRead = "N";
                }
                else {
                    $adminmemo->isRead = "Y";
                }
                $adminmemo->userId = $request->admin;
                $adminmemo->createdBy = Auth::guard('admin')->user()->id;
                $adminmemo->save();

                return response()->json(['status' => 'success'],200);
            }
        }
    }
    public function admimtypememolist(Request $request) {
        if(request()->ajax()) {
            $memoes = Adminmemo::join('users', 'users.id', '=', 'adminmemos.createdBy')
                ->where('adminmemos.userId', '=', null)
                ->where('adminmemos.createdBy', '=', Auth::guard('admin')->user()->id)
                ->select(['adminmemos.id',
                    DB::raw("DATE_FORMAT(adminmemos.created_at, '%Y.%m.%d %h:%i %p') as date"),
                    'adminmemos.note',
                    'users.name',
                ])->get();
            if(!empty($request->pin)) {
                $pin = true;
            } else {
                $pin = false;
            }
            $html = view('admin.notify.adminmemotypelist')->with(compact('memoes', 'pin'))->render();
            
            $output = ['html' => $html, 'success' => true, 'msg' => '' ];

            return $output;
        }
    }
    public function admimtypememosentlist(Request $request) {
        if(request()->ajax()) {
            $memoes = Adminmemo::join('users', 'users.id', '=', 'adminmemos.createdBy')
                ->where('adminmemos.userId', '!=', null)
                ->where('adminmemos.createdBy', '=', Auth::guard('admin')->user()->id)
                ->select(['adminmemos.id',
                    DB::raw("DATE_FORMAT(adminmemos.created_at, '%Y.%m.%d %h:%i %p') as date"),
                    'adminmemos.note',
                    'users.name',
                ])->get();
            $html = view('admin.notify.adminmemotypelist')->with(compact('memoes'))->render();
            
            $output = ['html' => $html, 'success' => true, 'msg' => '' ];

            return $output;
        }
    }
    public function admimtypememoreceivelist(Request $request) {
        if(request()->ajax()) {
            $memoes = Adminmemo::join('users', 'users.id', '=', 'adminmemos.createdBy')
                ->where('adminmemos.userId', '=', Auth::guard('admin')->user()->id)
                ->where('adminmemos.createdBy', '!=', Auth::guard('admin')->user()->id)
                ->select(['adminmemos.id',
                    DB::raw("DATE_FORMAT(adminmemos.created_at, '%Y.%m.%d %h:%i %p') as date"),
                    'adminmemos.note',
                    'users.name',
                ])->get();
            $html = view('admin.notify.adminmemotypelist')->with(compact('memoes'))->render();
            
            $output = ['html' => $html, 'success' => true, 'msg' => '' ];

            return $output;
        }
    }
}
