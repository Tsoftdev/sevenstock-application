<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Validator;
use Session;
use Carbon\Carbon;
use App\Models\Stock;
use App\Models\Customer;
use App\Models\Schedule;
use App\Models\Visitrecord;
use App\Models\Visitcustomer;
use App\Models\Pinned;
use App\Http\Start\Helpers;
use Yajra\DataTables\Facades\DataTables;

class ScheduleController extends Controller
{
    protected $helper; // Global variable for instance of Helpers
    
    public function __construct()
    {
        $this->helper = new Helpers;
    }

    public function index() {
        $customers = Customer::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->get();
        return view('admin.schedules.index')->with(compact('customers'));
    }
    public function getschedule(Request $request) {
        $schedules = Visitrecord::join('users', 'users.id', '=', 'visitrecords.createdBy')
            ->orderBy('visitrecords.startdate', 'DESC')
            ->select([
                'visitrecords.id',
                'visitrecords.title',
                'visitrecords.note',
                'visitrecords.backgroundColor',
                'visitrecords.borderColor',
                'visitrecords.startdate',
                'visitrecords.enddate',
                'visitrecords.starttime',
                'visitrecords.endtime',
                'visitrecords.type',
                'users.name as UserName'
            ])->get();
        
        $events = [];
        foreach ($schedules as $schedule) {
            if($schedule->type == "T") {
                $events[] = [
                    'id' => $schedule->id,
                    'title' => $schedule->title,
                    'start' => $schedule->startdate." " .date("H:i", strtotime($schedule->starttime)),
                    'end' => $schedule->enddate." " .date("H:i", strtotime($schedule->endtime)),
                    'backgroundColor' => $schedule->backgroundColor,
                    'borderColor' => $schedule->borderColor,
                    'createdBy' => $schedule->UserName,
                    'time_type' => $schedule->type,
                    'allDay' => false,
                    'note' => $schedule->note,
                    'customer' => $schedule->customer,
                ]; 
            } else if ($schedule->type == "A") {
                $events[] = [
                    'id' => $schedule->id,
                    'title' => $schedule->title,
                    'start' => $schedule->startdate,
                    'end' => date('Y-m-d', strtotime($schedule->enddate . ' +1 day')),
                    'backgroundColor' => $schedule->backgroundColor,
                    'borderColor' => $schedule->borderColor,
                    'createdBy' => $schedule->UserName,
                    'time_type' => $schedule->type,
                    'allDay' => true,
                    'note' => $schedule->note,
                    'customer' => $schedule->customer,
                ]; 
            } else if ($schedule->type == "E") {
                $events[] = [
                    'id' => $schedule->id,
                    'title' => $schedule->title,
                    'start' => $schedule->startdate." ".date("H:i", strtotime($schedule->starttime)),
                    'backgroundColor' => $schedule->backgroundColor,
                    'borderColor' => $schedule->borderColor,
                    'createdBy' => $schedule->UserName,
                    'time_type' => $schedule->type,
                    'allDay' => false,
                    'note' => $schedule->note,
                    'customer' => $schedule->customer,
                ]; 
            }
        }
        return response()->json($events);
    }
    public function getfilterschedule(Request $request) {

        $schedules = Visitrecord::join('users', 'users.id', '=', 'visitrecords.createdBy')
            ->leftjoin('visitcustomers', 'visitrecords.id', '=', 'visitcustomers.visitId')
            ->leftjoin('customers', 'visitcustomers.customerId', '=', 'customers.id')
            ->orderBy('visitrecords.startdate', 'DESC')
            ->select([
                'visitrecords.id',
                'visitrecords.title',
                'visitrecords.note',
                'visitrecords.backgroundColor',
                'visitrecords.borderColor',
                'visitrecords.startdate',
                'visitrecords.enddate',
                'visitrecords.starttime',
                'visitrecords.endtime',
                'visitrecords.type',
                'users.name as UserName',
                'customers.name',
                'customers.email',
                'customers.phonenumber1',
            ]);
        if (request()->has('desksearch')) {
            $desksearch = request()->get('desksearch');
            if (!empty($desksearch)) {
                $emailcheck = strpos($desksearch, '@');
                if($emailcheck !== false) {
                    $schedules->where('customers.email', $desksearch);
                } else if ($desksearch){
                    $schedules->where('customers.phonenumber1', 'like', '%' . $desksearch . '%');
                    $schedules->orWhere('customers.name', 'like', '%' . $desksearch . '%');
                } 
            }
        }

        if (request()->has('mobilesearch')) {
            $mobilesearch = request()->get('mobilesearch');
            if (!empty($mobilesearch)) {
                $emailcheck = strpos($mobilesearch, '@');
                if($emailcheck !== false) {
                    $schedules->where('customers.email', $mobilesearch);
                } else if ($mobilesearch) {
                    $schedules->where('customers.phonenumber1', 'like', '%'. $mobilesearch . '%');
                    $schedules->orWhere('customers.name', 'like', '%' . $mobilesearch . '%');
                } 
            }
        }
        $schedules = $schedules->get();
        
        $events = [];
        foreach ($schedules as $schedule) {
            if($schedule->type == "T") {
                $events[] = [
                    'id' => $schedule->id,
                    'title' => $schedule->title,
                    'start' => $schedule->startdate." " .date("H:i", strtotime($schedule->starttime)),
                    'end' => $schedule->enddate." " .date("H:i", strtotime($schedule->endtime)),
                    'backgroundColor' => $schedule->backgroundColor,
                    'borderColor' => $schedule->borderColor,
                    'createdBy' => $schedule->UserName,
                    'time_type' => $schedule->type,
                    'allDay' => false,
                    'note' => $schedule->note,
                    'customer' => $schedule->customer,
                ]; 
            } else if ($schedule->type == "A") {
                $events[] = [
                    'id' => $schedule->id,
                    'title' => $schedule->title,
                    'start' => $schedule->startdate,
                    'end' => date('Y-m-d', strtotime($schedule->enddate . ' +1 day')),
                    'backgroundColor' => $schedule->backgroundColor,
                    'borderColor' => $schedule->borderColor,
                    'createdBy' => $schedule->UserName,
                    'time_type' => $schedule->type,
                    'allDay' => true,
                    'note' => $schedule->note,
                    'customer' => $schedule->customer,
                ]; 
            } else if ($schedule->type == "E") {
                $events[] = [
                    'id' => $schedule->id,
                    'title' => $schedule->title,
                    'start' => $schedule->startdate." ".date("H:i", strtotime($schedule->starttime)),
                    'backgroundColor' => $schedule->backgroundColor,
                    'borderColor' => $schedule->borderColor,
                    'createdBy' => $schedule->UserName,
                    'time_type' => $schedule->type,
                    'allDay' => false,
                    'note' => $schedule->note,
                    'customer' => $schedule->customer,
                ]; 
            }
        }
        return response()->json($events);
    }
    public function add(Request $request) {
        if (request()->ajax()) {
            $rules = array(
                'title' => 'required',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } 
            else {
                $schedule = new Visitrecord;
                $schedule->starttime = $request->starttime;
                $schedule->endtime = $request->endtime;
                $schedule->startdate = $request->startdate;
                $schedule->enddate = $request->enddate;
                if($request->type == "1") {
                    $schedule->type = "A";
                } else if ($request->type == "0") {
                    if(!empty($request->enddate)) {
                        $schedule->type = "T";
                    } else {
                        $schedule->type = "E";
                    }
                      
                }
                $schedule->backgroundColor = $request->backgroundColor;
                $schedule->borderColor = $request->borderColor;
                $schedule->title = $request->title;
                $schedule->note = $request->note;
                //$schedule->status = "Pending";
                
                $schedule->createdBy = Auth::guard('admin')->user()->id;

                $schedule->save();
                if($request->customer != null){
                    $finalArray = array();
                    foreach($request->customer as $key=>$value) {
                        array_push($finalArray, array(
                                        'visitId'=>$schedule->id,
                                        'customerId'=>$value,
                                        'status'=>"Pending"
                                        )
                        );
                    };
                    Visitcustomer::insert($finalArray);
                }
                
                $output = ['success' => 1,
                            'msg' => "Added Successfully!"
                            ];
                return response()->json($output);
            }
        }
    }

    public function update(Request $request) {
        if (request()->ajax()) {
            $rules = array(
                'title' => 'required',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } 
            else {
                $schedule = Visitrecord::find($request->schedule_id);
                $schedule->starttime = $request->starttime;
                $schedule->endtime = $request->endtime;
                $schedule->startdate = $request->startdate;
                $schedule->enddate = $request->enddate;
                if($request->type == "1") {
                    $schedule->type = "A";
                    
                } else if ($request->type == "0") {
                    if(!empty($request->enddate)) {
                        $schedule->type = "T";
                    } else {
                        $schedule->type = "E";
                    } 
                }
                $schedule->backgroundColor = $request->backgroundColor;
                $schedule->borderColor = $request->borderColor;
                $schedule->title = $request->title;
                $schedule->note = $request->note;
                $schedule->createdBy = Auth::guard('admin')->user()->id;
                $schedule->save();
               
                // if($request->customer != null){
                //     $visitcustomer = Visitcustomer::where('visitId', $request->schedule_id);
                //     $visitcustomer->delete();
                //     $finalArray = array();
                //     foreach($request->customer as $key=>$value) {
                //         array_push($finalArray, array(
                //                         'visitId'=>$schedule->id,
                //                         'customerId'=>$value,
                //                         'status'=>"Pending"
                //                         )
                //         );
                //     };
                //     Visitcustomer::insert($finalArray);
                // } else {
                //     $visitcustomer = Visitcustomer::where('visitId', $request->schedule_id);
                //     $visitcustomer->delete();
                // }
                $output = ['success' => 1,
                            'msg' => "Updated Successfully!"
                            ];
                return response()->json($output);
            }
        }
    }

    public function scheduleupdate(Request $request) {
        if (request()->ajax()) {
            $rules = array(
                'schedule_id' => 'required',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } 
            else {
                $schedule = Visitrecord::find($request->schedule_id);
                if($request->time_type == "A") {
                    $schedule->startdate = $request->start;
                    $schedule->enddate = $request->end;
                    $schedule->createdBy = Auth::guard('admin')->user()->id; 
                } else if ($request->time_type == "T") {
                    $schedule->startdate = $request->start;
                    $schedule->enddate = $request->end;
                    $schedule->starttime = $request->starttime;
                    $schedule->endtime = $request->endtime;
                    $schedule->createdBy = Auth::guard('admin')->user()->id; 
                } else if ($request->time_type == "E") {
                    $schedule->startdate = $request->start;
                    $schedule->starttime = Carbon::parse("$request->starttime")->format('g:i A');
                    $schedule->createdBy = Auth::guard('admin')->user()->id;
                }
                
                $schedule->save();
                $output = ['success' => 1,
                        'msg' => "Updated Successfully!"
                        ];
                return response()->json($output);
            }
        }
    }
    public function scheduledelete(Request $request) {
        if (request()->ajax()) {
            $schedule = Visitrecord::find($request->schedule_id);
            $schedule->delete();
            $output = ['success' => 1,
                            'msg' => "Deleted Successfully!"
                            ];
            return response()->json($output);
        }
    }

    public function scheduledaylist(Request $request) {
        if ($request->ajax()) {
            $start_date = Carbon::parse("$request->date")->format('Y-m-d');
            $end_date = Carbon::parse("$request->date")->format('Y-m-d');
            $schedules = Visitrecord::join('users', 'users.id', '=', 'visitrecords.createdBy')
                ->where(function($query) use($start_date){
                    $query->where([['visitrecords.startdate','<=',$start_date],['visitrecords.enddate','>=',$start_date]]);
                    $query->orwhere('visitrecords.startdate','=',$start_date);
                })
                ->where('visitrecords.type', '!=', "A")
                ->orderBy('visitrecords.startdate', 'DESC')
                ->select([
                    'visitrecords.id',
                    'visitrecords.title',
                    'visitrecords.note',
                    'visitrecords.backgroundColor',
                    'visitrecords.borderColor',
                    'visitrecords.startdate',
                    'visitrecords.enddate',
                    'users.name as UserName',
                    'visitrecords.starttime',
                    'visitrecords.endtime',
                    'visitrecords.type',
                    'visitrecords.createdBy',
                ])
                ->get();
            
            $allday = Visitrecord::join('users', 'users.id', '=', 'visitrecords.createdBy')
                ->where('visitrecords.type', '=', "A")
                ->where([['visitrecords.startdate','<=',$start_date],['visitrecords.enddate','>=',$start_date]])
                ->orderBy('visitrecords.startdate', 'DESC')
                ->select([
                    'visitrecords.id',
                    'visitrecords.title',
                    'visitrecords.note',
                    'visitrecords.startdate',
                    'visitrecords.enddate',
                    'visitrecords.backgroundColor',
                    'users.name as UserName',
                    DB::raw("DATE_FORMAT(visitrecords.startdate, '%m.%d') as start"),
                    DB::raw("DATE_FORMAT(visitrecords.enddate, '%m.%d') as end"),
                    DB::raw("DATEDIFF(visitrecords.enddate,visitrecords.startdate) + 1 as days"),
                    'visitrecords.createdBy',
                ])
                ->get();
            $html = view('admin.schedules.ajax-schedule.ajax-schedulelist')
                    ->with(compact('schedules', 'allday'))->render();

            $output = ['html' => $html, 'success' => true, 'msg' => '' ];

            return $output;
        }
    }
    public function schedulealllist(Request $request) {
        if ($request->ajax()) {
            $schedules = Visitrecord::join('users', 'users.id', '=', 'visitrecords.createdBy')
            ->where('visitrecords.type', '!=', "A")
            ->orderBy('visitrecords.startdate', 'DESC')
            ->select([
                'visitrecords.id',
                'visitrecords.title',
                'visitrecords.note',
                'visitrecords.backgroundColor',
                'visitrecords.borderColor',
                'visitrecords.startdate',
                'visitrecords.enddate',
                'users.name as UserName',
                'visitrecords.starttime',
                'visitrecords.endtime',
                'visitrecords.type',
                'visitrecords.createdBy',
            ])
            ->get();
            
            $allday = Visitrecord::join('users', 'users.id', '=', 'visitrecords.createdBy')
                ->where('visitrecords.type', '=', "A")
                ->orderBy('visitrecords.startdate', 'DESC')
                ->select([
                    'visitrecords.id',
                    'visitrecords.title',
                    'visitrecords.note',
                    'visitrecords.startdate',
                    'visitrecords.enddate',
                    'users.name as UserName',
                    DB::raw("DATE_FORMAT(visitrecords.startdate, '%m.%d') as start"),
                    DB::raw("DATE_FORMAT(visitrecords.enddate, '%m.%d') as end"),
                    DB::raw("(DATEDIFF(visitrecords.enddate,visitrecords.startdate) + 1) as days"),
                    'visitrecords.createdBy',
                ])
                ->get();
            
            $html = view('admin.schedules.ajax-schedule.ajax-schedulelist')
                    ->with(compact('schedules', 'allday'))->render();

            $output = ['html' => $html, 'success' => true, 'msg' => '' ];

            return $output;
        }
    }
    public function selectscheduleday(Request $request) {
        if ($request->ajax()) {
            $selected = $request->select_date;
            $start_date = Carbon::parse("$selected")->format('Y-m-d');
            $schedules = Visitrecord::join('users', 'users.id', '=', 'visitrecords.createdBy')
            ->where(function($query) use($start_date){
                $query->where([['visitrecords.startdate','<=',$start_date],['visitrecords.enddate','>=',$start_date]]);
                $query->orwhere('visitrecords.startdate','=',$start_date);
            })
            ->where('visitrecords.type', '!=', "A")
            ->orderBy('visitrecords.startdate', 'DESC')
            ->select([
                'visitrecords.id',
                'visitrecords.title',
                'visitrecords.note',
                'visitrecords.backgroundColor',
                'visitrecords.borderColor',
                'visitrecords.startdate',
                'visitrecords.enddate',
                'users.name as UserName',
                'visitrecords.starttime',
                'visitrecords.endtime',
                'visitrecords.type',
                'visitrecords.createdBy',
            ])
            ->get();
            $allday = Visitrecord::join('users', 'users.id', '=', 'visitrecords.createdBy')
                ->where('visitrecords.type', '=', "A")
                ->where([['visitrecords.startdate','<=',$start_date],['visitrecords.enddate','>=',$start_date]])
                ->orderBy('visitrecords.startdate', 'DESC')
                ->select([
                    'visitrecords.id',
                    'visitrecords.title',
                    'visitrecords.note',
                    'visitrecords.startdate',
                    'visitrecords.enddate',
                    'users.name as UserName',
                    'visitrecords.backgroundColor',
                    DB::raw("DATE_FORMAT(visitrecords.startdate, '%m.%d') as start"),
                    DB::raw("DATE_FORMAT(visitrecords.enddate, '%m.%d') as end"),
                    DB::raw("DATEDIFF(visitrecords.enddate,visitrecords.startdate) + 1 as days"),
                    'visitrecords.createdBy',
                ])
                ->get();
            $html = view('admin.schedules.ajax-schedule.ajax-schedulelist')
                    ->with(compact('schedules', 'allday'))->render();

            $output = ['html' => $html, 'success' => true, 'msg' => '' ];

            return $output;
        }
    }

    public function schedulechangestatus(Request $request) {
        if (request()->ajax()) {
            $schedule = Visitcustomer::find($request->schedule_id);
            $schedule->status = $request->status;
            $schedule->save();
            $output = ['success' => 1,
                            'msg' => "Updated Successfully!"
                            ];
            return response()->json($output);
        }
    }

    public function getitem(Request $request) {
        $schedules = Visitrecord::join('users', 'users.id', '=', 'visitrecords.createdBy')
            ->orderBy('visitrecords.startdate', 'DESC')
            ->where('visitrecords.id', '=', $request->schedule_id)
            ->select([
                'visitrecords.id',
                'visitrecords.title',
                'visitrecords.note',
                'visitrecords.backgroundColor',
                'visitrecords.borderColor',
                'visitrecords.type',
                'users.name as UserName',
                DB::raw("DATE_FORMAT(visitrecords.startdate, '%Y.%m.%d') as start_t"),
                DB::raw("DATE_FORMAT(visitrecords.enddate, '%Y.%m.%d') as end_t"),
                DB::raw("visitrecords.starttime as STIME"),
                DB::raw("visitrecords.endtime as ETIME"),
            ])->get();

        foreach ($schedules as $schedule) {
            $finalArray = array();
            if($schedule->customer->count() > 0){
                foreach($schedule->customer as $key=>$value) {
                    $finalArray[] = $value->customerId;
                };
            }
            $data = [
                'id' => $schedule->id,
                'title' => $schedule->title,
                'start' => $schedule->start_t,
                'end' => $schedule->end_t,
                'starttime' => $schedule->STIME,
                'endtime' => $schedule->ETIME,
                'backgroundColor' => $schedule->backgroundColor,
                'borderColor' => $schedule->borderColor,
                'createdBy' => $schedule->UserName,
                'type' => $schedule->type,
                'customer'=>  $finalArray,
                'note'=> $schedule->note,
            ]; 
        }
        return response()->json($data);
    }

    public function pinnedadd(Request $request) {
        if (request()->ajax()) {
            $rules = array(
                'message' => 'required',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } 
            else {
                $pinned = new Pinned;
                $pinned->message = $request->message;
                $pinned->createdBy = Auth::guard('admin')->user()->id;
                $pinned->save();
                $output = ['success' => 1,
                            'msg' => "Added Successfully!"
                            ];
                return response()->json($output);
            }
        }
    }

    public function pinnedupdate(Request $request) {
        if (request()->ajax()) {
            $rules = array(
                'message' => 'required',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } 
            else {
                $pinned = Pinned::find($request->messageid);
                $pinned->message = $request->message;
                $pinned->createdBy = Auth::guard('admin')->user()->id;
                $pinned->save();
                $output = ['success' => 1,
                            'msg' => "Updated Successfully!"
                            ];
                return response()->json($output);
            }
        }
    }

    public function pinnedlist(Request $request) {
        if (request()->ajax()) {
            $start_date = Carbon::parse("$request->date 00:00:00")->format('Y-m-d H:i:s');
            $end_date = Carbon::parse("$request->date 23:59:59")->format('Y-m-d H:i:s');
            $pinneds = Pinned::join('users', 'users.id', '=', 'pinneds.createdBy')
            ->whereBetween('pinneds.created_at', [$start_date, $end_date])
            ->orderBy('pinneds.created_at', 'DESC')
            ->select([
                'pinneds.id',
                'pinneds.message',
                'users.name as UserName',
                DB::raw("DATE_FORMAT(pinneds.created_at, '%e %M') as created_at_date"),
                DB::raw("DATE_FORMAT(pinneds.created_at, '%h.%i %p') as created_at_time"),
            ])->paginate(10);
            if(!empty($request->ped)) {
                $ped = true;
            } else {
                $ped = false;
            }
            
            $html = view('admin.schedules.ajax-schedule.ajax-pinlist')
                    ->with(compact('pinneds', 'ped'))->render();

            $output = ['html' => $html, 'success' => true, 'msg' => '' ];

            return $output;
        }
    }

    function pinnedfetch(Request $request) {
        if($request->ajax()) {
            $pinneds = Pinned::join('users', 'users.id', '=', 'pinneds.createdBy')
            ->orderBy('pinneds.created_at', 'DESC')
            ->select([
                'pinneds.id',
                'pinneds.message',
                'users.name as UserName',
                DB::raw("DATE_FORMAT(pinneds.created_at, '%e %M') as created_at_date"),
                DB::raw("DATE_FORMAT(pinneds.created_at, '%h.%i %p') as created_at_time"),
            ])->paginate(10);
            $ped = false;
            return view('admin.schedules.ajax-schedule.ajax-pinlist')->with(compact('pinneds', 'ped'))->render();
        }
    }
    
    public function pinnedalllist(Request $request) {
        if (request()->ajax()) {
            $pinneds = Pinned::join('users', 'users.id', '=', 'pinneds.createdBy')
            ->orderBy('pinneds.created_at', 'DESC')
            ->select([
                'pinneds.id',
                'pinneds.message',
                'users.name as UserName',
                DB::raw("DATE_FORMAT(pinneds.created_at, '%e %M') as created_at_date"),
                DB::raw("DATE_FORMAT(pinneds.created_at, '%h.%i %p') as created_at_time"),
            ])->paginate(10);
            if(!empty($request->ped)) {
                $ped = true;
            } else {
                $ped = false;
            }
            $html = view('admin.schedules.ajax-schedule.ajax-pinlist')
                    ->with(compact('pinneds', 'ped'))->render();

            $output = ['html' => $html, 'success' => true, 'msg' => '' ];

            return $output;
        }
    }

    public function pinnedmessagedelete(Request $request) {
        if (request()->ajax()) {
            $pinnedmes = Pinned::find($request->messageid);
            $pinnedmes->delete();
            $output = ['success' => 1,
                            'msg' => "Deleted Successfully!"
                            ];
            return response()->json($output);
        }
    }

    public function pinnedmessageget(Request $request) {
        if (request()->ajax()) {
            $pinnedmes = Pinned::find($request->messageid);
            $data = [
                'message' => $pinnedmes->message,
            ];
            return response()->json($data,200);
        }
    }

    public function pinmessage(Request $request) {
        if (request()->ajax()) {
            $pinned = Pinned::find($request->messageid);
            $pinned->created_at = date('Y-m-d H:i:s');
            $pinned->save();
            return response()->json(['status' => 'success'],200);
        }
    }

    public function scheduledetail(Request $request) {
        if (request()->ajax()) {
            $schedule = Visitrecord::join('users', 'users.id', '=', 'visitrecords.createdBy')
            ->where('visitrecords.id', '=', $request->schedule_id)
            
            ->select([
                'visitrecords.id',
                'visitrecords.title',
                'visitrecords.note',
                'visitrecords.backgroundColor',
                'visitrecords.borderColor',
                DB::raw("DATE_FORMAT(visitrecords.startdate, '%Y.%m.%d') as startdate"),
                DB::raw("DATE_FORMAT(visitrecords.enddate, '%Y.%m.%d') as enddate"),
                'visitrecords.starttime',
                'visitrecords.endtime',
                'visitrecords.type',
                'users.name as UserName',
            ])->first();
            $isbn = "";
            if($schedule->customer->count() > 0) {
                $isbnList = [];
                foreach ($schedule->customer as $item) {
                    if (isset($item->subcustomer->name)) {
                        $isbnList[] = $item->subcustomer->name . ":" . $item->status . ":" . $item->id;
                    }
                }
                $isbn = implode(",", $isbnList);
                
            }
            $data = [
                'id' => $schedule->id,
                'title' => $schedule->title,
                'startdate' => $schedule->startdate,
                'enddate' => $schedule->enddate,
                'starttime' => $schedule->starttime,
                'endtime' => $schedule->endtime,
                'backgroundColor' => $schedule->backgroundColor,
                'borderColor' => $schedule->borderColor,
                'UserName' => $schedule->UserName,
                'type' => $schedule->type,
                'note' => $schedule->note,
                'customer' => $isbn,
            ]; 
            return response()->json($data);
        }
    }

}
