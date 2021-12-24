<?php

namespace App\Http\Controllers\Admin;

use Auth;
use DB;
use Validator;
use Session;
use Carbon\Carbon;
use App\Models\Company;
use App\Models\Receipt;
use App\Models\Receiptitem;
use App\Models\Invoicephoto;
use App\Models\Employee;
use App\Http\Start\Helpers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReceiptController extends Controller
{
    protected $helper; // Global variable for instance of Helpers
    
    public function __construct()
    {
        $this->helper = new Helpers;
    }

    public function index() {
        $employees = Employee::get();
        $companies = Company::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->with('owner')->get();
        $currentDay = Carbon::now(); 
        $start_date = $currentDay->firstOfMonth();
        $lastDay = Carbon::now(); 
        $end_date = $lastDay->endOfMonth();
        // DB::enableQueryLog();
        $analysis = Receipt::select([
            DB::raw("SUM(IF(receipts.payment='CD',receiptitems.total, 0)) AS card"),
            DB::raw("SUM(IF(receipts.payment='CH',receiptitems.total, 0)) AS cash"),
            DB::raw('SUM(receiptitems.total) as totalamount'),
        ])
        ->join('receiptitems', 'receipts.id', '=','receiptitems.receiptId')
            ->where('receipts.status', '=', 'A')
            ->whereBetween('receipts.issueddate', [date($start_date->format('Y-m-d')), date($end_date->format('Y-m-d'))])
            ->get();
        return view('admin.receipt.index')->with(compact('companies','employees', 'analysis'));
    }
    public function employeeList(Request $request) {
        if ($request->ajax()){
            $employees = Receipt::orderBy('issueddate', 'DESC')->get();
            $html = view('admin.receipt.ajax-receipt-employee')
                ->with(compact('employees'))->render();
            $output = ['html' => $html, 'success' => true, 'msg' => '' ];
            return $output;
        }
    }
    public function employeePendingList(Request $request) {
        if ($request->ajax()){
            $employees = Receipt::where('status', '=', 'P')->orwhere('status', '=', 'PP')->orderBy('issueddate', 'DESC')->get();
            $html = view('admin.receipt.ajax-receipt-employee')
                ->with(compact('employees'))->render();
            $output = ['html' => $html, 'success' => true, 'msg' => '' ];
            return $output;
        }
    }
    public function employeeFilterList(Request $request) {
        if ($request->ajax()){
            $selected = $request->company_filter;
            $employees = Receipt::where('companyId', '=', $selected)->orderBy('issueddate', 'DESC')->get();
            $html = view('admin.receipt.ajax-receipt-employee')
                ->with(compact('employees'))->render();
            $output = ['html' => $html, 'success' => true, 'msg' => '' ];
            return $output;
        }
    }
    public function invoiceDetail(Request $request) {
        if ($request->ajax()){
            $receipt = Receipt::find($request->receiptid);
            $html = view('admin.receipt.ajax-invoice-detail')
                ->with(compact('receipt'))->render();
            $output = ['html' => $html, 'success' => true, 'msg' => '' ];
            return $output;
        }
    }
    public function invoicestatuschange(Request $request) {
        if ($request->ajax()){
            $receipt = Receipt::find($request->receiptid);
            $receipt->status = $request->status;
            $receipt->save();
            $output = ['success' => 1,
                            'msg' => "Updated Successfully!"
                            ];
            return response()->json($output);
        }
    }
    public function add(Request $request) {
        if($request->submit) {
            $rules = array(
                'employee_filter'   => 'required',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
            else {
                $receipt = new Receipt;
                $receipt->issueddate = Carbon::createFromFormat('Y.m.d', $request->issuedon)->format('Y-m-d');
                if($request->icompany){
                    $receipt->companyId   = $request->icompany;
                }
                else{
                    $emp = Employee::find($request->employee_filter);
                    $receipt->companyId   = $emp->companyId;
                }
                $receipt->status      = $request->istatus;
                $receipt->bankname      = $request->bankname;
                $receipt->bankinformation      = $request->bankinformation;
                $receipt->employeeId      = $request->employee_filter;
                $receipt->category      = $request->icategory;
                $receipt->note      = $request->inote;
                $receipt->payment      = $request->payment;
                $receipt->save();
                $receiptu = Receipt::find($receipt->id);
                $prefix = 'S-';
                $receiptu->invoicenumber = sprintf("%s%05s", $prefix, $receiptu->id);
                $receiptu->save();
                $items = (int)$request->total_item;
                
                for($i=0;$i<$items;$i++){
                    $receiptitem = new Receiptitem;
                    $itemname = "itemname_".$i;
                    $quantity = "quantity_".$i;
                    $price = "price_".$i;
                    $total = "total_".$i;
                    $receiptitem->item = $request->input($itemname);
                    $receiptitem->quantity = $request->input($quantity);
                    $receiptitem->price = $request->input($price);
                    $receiptitem->total = $request->input($total);
                    $receiptitem->receiptId=$receipt->id;
                    $receiptitem->save();
                }
                if($files=$request->file('images')){
                    
                    foreach($files as $file){
                        $invoicephoto = new Invoicephoto;
                        $invoice_filename = $file->getClientOriginalName();
                        $success = $file->move('images/invoice/'.$receipt->id, $invoice_filename);
                        if(!$success)
                            return back()->withError("error");
                        $invoicephoto->photo =url('images/invoice').'/'.$receipt->id.'/'.$invoice_filename;
                        $invoicephoto->receiptId= $receipt->id;
                        $invoicephoto->save();
                    }
                }
                $this->helper->flash_message('success', 'Added Successfully'); 
                return redirect('admin/receipt');
            }
        }
        else {
            return redirect('admin/receipt');
        }
    }
    public function update(Request $request) {
        if($request->submit) {
            $rules = array(
                'upemployee_filter'   => 'required',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
            else {
                $receipt = Receipt::find($request->id);
                $receipt->issueddate = Carbon::createFromFormat('Y.m.d', $request->upissuedon)->format('Y-m-d');
                if($request->upicompany){
                    $receipt->companyId   = $request->upicompany;
                }
                else{
                    $emp = Employee::find($request->upemployee_filter);
                    $receipt->companyId   = $emp->upcompanyId;
                }
                $receipt->status      = $request->upistatus;
                $receipt->bankname      = $request->upbankname;
                $receipt->bankinformation      = $request->upbankinformation;
                $receipt->employeeId      = $request->upemployee_filter;
                $receipt->category      = $request->upicategory;
                $receipt->note      = $request->upinote;
                $receipt->payment      = $request->uppayment;
                $receipt->save();
                foreach($receipt->receiptitem as $item){
                    $item->delete();
                }
                $items = (int)$request->uptotal_item;
                for($i=0;$i<$items;$i++){
                    $receiptitem = new Receiptitem;
                    $itemname = "upitemname_".$i;
                    $quantity = "upquantity_".$i;
                    $price = "upprice_".$i;
                    $total = "uptotal_".$i;
                    $receiptitem->item = $request->input($itemname);
                    $receiptitem->quantity = $request->input($quantity);
                    $receiptitem->price = $request->input($price);
                    $receiptitem->total = $request->input($total);
                    $receiptitem->receiptId=$receipt->id;
                    $receiptitem->save();
                }
                if($files=$request->file('images')){
                    
                    foreach($files as $file){
                        $invoicephoto = new Invoicephoto;
                        $invoice_filename = $file->getClientOriginalName();
                        $success = $file->move('images/invoice/'.$receipt->id, $invoice_filename);
                        if(!$success)
                            return back()->withError("error");
                        $invoicephoto->photo =url('images/invoice').'/'.$receipt->id.'/'.$invoice_filename;
                        $invoicephoto->receiptId= $receipt->id;
                        $invoicephoto->save();
                    }
                }
                $this->helper->flash_message('success', 'Updated Successfully'); 
                return redirect('admin/receipt');
            }
        }
        else {
            return redirect('admin/receipt');
        }
    }
    public function invoiceanalyse(Request $request) {
        if ($request->ajax()) {
            
            $currentDay = Carbon::now(); 
            $start_date = $currentDay->firstOfMonth();
            $lastDay = Carbon::now(); 
            $end_date = $lastDay->endOfMonth();
            $groups = Receipt::select([
                'receipts.employeeId',
                DB::raw('COUNT(DISTINCT receiptitems.receiptId) as employee'),
                DB::raw("SUM(IF(receipts.payment='CD',receiptitems.total, 0)) AS card"),
                DB::raw("SUM(IF(receipts.payment='CH',receiptitems.total, 0)) AS cash"),
                DB::raw('SUM(receiptitems.total) as totalamount'),
                'receipts.issueddate',
                'receipts.payment'
            ])
            ->join('receiptitems', 'receipts.id', '=','receiptitems.receiptId')
            ->where('receipts.status', '=', 'A')
            ->whereBetween('receipts.issueddate', [date($start_date->format('Y-m-d')), date($end_date->format('Y-m-d'))])
            ->groupBy('receipts.issueddate')
            ->orderBy('receipts.issueddate','DESC')
            ->get();
            $everyreceipt = Receipt::where('status', '=', 'A')
                ->whereBetween('issueddate', [date($start_date->format('Y-m-d')), date($end_date->format('Y-m-d'))])
                ->orderBy('issueddate','DESC')->get();
            foreach($everyreceipt as $every){
                $total = 0;
                $cash = 0;
                $card = 0;
                foreach($every->receiptitem as $item){
                    $total += $item->total;
                    if($every->payment == "CD"){
                        $card += $item->total;
                    } else if($every->payment == "CH"){
                        $cash += $item->total;
                    }
                }
                
                $every->total = $total;
                $every->card = $card;
                $every->cash = $cash;
            }
            
            $html = view('admin.receipt.ajax-analysis')
                ->with(compact('groups', 'everyreceipt'))->render();
            $output = ['html' => $html, 'success' => true, 'msg' => '' ];
            return $output;
        }
    }
    public function invoiceanalysefilter(Request $request) {
        if ($request->ajax()) {
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $groups = Receipt::select([
                'receipts.employeeId',
                DB::raw('COUNT(receipts.employeeId) as employee'),
                DB::raw("SUM(IF(receipts.payment='CD',receiptitems.total, 0)) AS card"),
                DB::raw("SUM(IF(receipts.payment='CH',receiptitems.total, 0)) AS cash"),
                DB::raw('SUM(receiptitems.total) as totalamount'),
                'receipts.issueddate',
                'receipts.payment'
            ])
            ->join('receiptitems', 'receipts.id', '=','receiptitems.receiptId')
                ->where('receipts.status', '=', 'A')
                ->whereBetween('receipts.issueddate', [$start_date, $end_date])
                ->groupBy('receipts.issueddate')
                ->orderBy('receipts.issueddate','DESC')
                ->get();
            // dd(DB::getQueryLog());
            $everyreceipt = Receipt::where('status', '=', 'A')
                ->whereBetween('issueddate', [$start_date, $end_date])
                ->orderBy('issueddate','DESC')->get();
            foreach($everyreceipt as $every){
                $total = 0;
                $cash = 0;
                $card = 0;
                foreach($every->receiptitem as $item){
                    $total += $item->total;
                    if($every->payment == "CD"){
                        $card += $item->total;
                    } else if($every->payment == "CH"){
                        $cash += $item->total;
                    }
                }
                
                $every->total = $total;
                $every->card = $card;
                $every->cash = $cash;
            }
            $html = view('admin.receipt.ajax-analysis')
                ->with(compact('groups', 'everyreceipt'))->render();
            $output = ['html' => $html, 'success' => true, 'msg' => '' ];
            return $output;
        }
    }
    public function delete(Request $request) {
        if ($request->ajax()){
            $receipt = Receipt::find($request->invoice_id);
            $receipt->delete();
            $output = ['success' => 1,
                            'msg' => "Deleted Successfully!"
                            ];
            return response()->json($output);
        }
    }
    public function invoicedata(Request $request) {
        if ($request->ajax()) {
            $receipt = Receipt::find($request->invoice_id);
            $employees = Employee::get();
            $ucompanies = Company::where('isActive', '=', 'Y')->where('isDelete', '=', 'N')->where('isApproved', '=', 'Y')->with('owner')->get();
            $html = view('admin.receipt.ajax-invoice-update')
                ->with(compact('receipt', 'employees', 'ucompanies'))->render();
            $output = ['html' => $html, 'success' => true, 'msg' => '' ];
            return $output;
        }
    }
}
