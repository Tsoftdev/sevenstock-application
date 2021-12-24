@extends('admin.layouts.app')
@section('title', 'Receipt')
@section('css')
<link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<!-- DataTables -->
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<!-- Responsive datatable examples -->
<link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" /> 
<link href="{{ asset('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/jquery-scrollbar/jquery.scrollbar.css') }}">
<link rel="stylesheet" href="{{ asset('assets/libs/image-uploader/image-uploader.min.css') }}">
<link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/jquery-scrollbar/jquery.scrollbar.css') }}">
<link href="{{ asset('assets/libs/lightbox/dist/css/lightbox.min.css') }}" rel="stylesheet" type="text/css" /> 
@endsection
@section('content')
<style>
    .company-img {  
        max-height: 100%;  
        max-width: 100%; 
        position: relative;  
        height: 60px;
        padding: 10px; 
        margin: auto;
    }
    .receipt-check {
        width: 2em;
        height: 2em;
        margin-top: 0.25em;
        vertical-align: top;
        background-color: #fff;
        background-repeat: no-repeat;
        background-position: center;
        background-size: contain;
        border: 1px solid #adb5bd;
        float: left;
        margin-left: -1.5em;
    }
    .receipt-label {
        padding: 6px;
    }
    .receipt-status{
        font-size: 11px;
    }
    .invoice-content{
        border-radius: 5px;
        background: #ffffff;
        position: relative;
        padding: 20px;
        height:151px;
        box-shadow: 0 -3px 31px 0 rgb(0 0 0 / 5%), 0 6px 20px 0 rgb(0 0 0 / 2%);
    }
    .invoice-cash{
        border-radius: 5px;
        background: #ffffff;
        position: relative;
        padding: 10px;
        height:71px;
        box-shadow: 0 -3px 31px 0 rgb(0 0 0 / 5%), 0 6px 20px 0 rgb(0 0 0 / 2%);
    }
    .invoice-wid .invoice-item {
        position: relative;
        border-top: 1px solid #ced0d2;
        overflow: hidden;
        padding: 8px 0;
    }
    .invoice-btn{
        height:37px;
    }
    .invoice-title{
        display: flex; 
        align-items: center; 
    }
    .employee-scroll {
        height: 55vh;
    }
    .employee-card {
        padding: .1rem .75rem !important;
    }
    .employee-scroll .scroll-bar {
        background-color: #1f263d!important;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4 p-3">
            <div class="row mb-3">
                <div class="col-sm-3 p-1">
                    <div class="">
                        <h4 class="mt-1 bold">Invoice</h4>
                    </div>
                </div>
                <div class="col-sm-5 p-1">
                    <select class="form-control select2" id="company_filter" required>
                        <option value="">기업목록..</option>
                        @foreach($companies as $company)
                            <option value="{{$company->id}}">{{$company->companyName}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-2 p-1">
                    <button type="button" class="btn btn-dark w-100 invoice-btn">Filter</button>
                </div>
                <div class="col-sm-2 p-1">
                    <button type="button" id="invoiceadd" class="btn btn-primary w-100 invoice-btn">Add</button>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-md-6">
                    <div class="row p-1">
                        <div class="invoice-content">
                            <div class="row">
                                <span class="fw-bold text-primary" style="font-size:14px;">This Month</span>
                            </div>
                            <div class="row">
                                <span class="fw-bold" style="font-size:20px;">{{$analysis[0] ? number_format($analysis[0]->totalamount) : 0 }} 원</span>
                            </div>
                            <div class="row mt-3">
                                <button type="button" class="btn btn-primary w-100 waves-effect" id="analysisbtn">Analysis</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row p-1">
                        <div class="invoice-cash" style="padding:10px;height:71px;">
                            <p class="fw-bold" style="line-height:1.0!important;color:rgb(15 3 199);font-size:16px;"><i class="mdi mdi-checkbox-blank-circle font-size-13" style="color:rgb(15 3 199);"></i> Card</p>
                            <span style="font-size:16px;margin-left: 30%;" class="fw-bold">{{$analysis[0] ? number_format($analysis[0]->card) : 0 }} 원</span>
                        </div>
                    </div>
                    
                    <div class="row p-1">
                        <div class="invoice-cash" style="padding:10px;height:71px;">
                            <p class="fw-bold" style="line-height:1.0!important;color:#13953e;font-size:16px;"><i class="mdi mdi-checkbox-blank-circle font-size-13" style="color:#13953e;"></i> Cash</p>
                            <span class="fw-bold" style="font-size:16px;margin-left: 30%;">{{$analysis[0] ? number_format($analysis[0]->cash) : 0 }} 원</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="form-check ms-2">
                    <input type="checkbox" class="receipt-check" id="pendshow">
                    <label class="form-check-label receipt-label" for="pendshow">Show Pending Only</label>
                </div>
            </div>
            <div class="row mt-2">
                <div id="employee_list" class="employee-scroll employee-card"></div>
            </div>
        </div>
        <div class="col-md-8 p-3">
            <div class="invoice-analysis" id="invoice_analysis">
                <div class="row mb-3">
                    <div class="col-md-6 invoice-title">
                        <span class="mt-1 bold" style="font-size:18px;">Analysis
                            (<span id="analyse_intervel"></span>)
                        </span>
                    </div>
                    <div class="col-md-6">
                        <div class="row d-flex justify-content-end">
                            <div class="col-md-6 p-1">
                                <button type="button" class="btn btn-secondary btn-clasfy-select w-100" id="daterange-btn">
                                    <span>
                                        <i class="fa fa-calendar"></i> 기간 설정
                                    </span>
                                    <i class="fa fa-caret-down"></i>
                                </button>
                            </div>
                        </div>
                        
                    </div>              
                </div>
                <hr/>
                <div class="row p-1">
                    <div class="card">
                        <div class="card-body">
                            <div id="analysis_data"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="invoice-information" id="invoice_information" style="display:none;">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-3 p-1">
                                <button type="button" class="btn btn-secondary waves-effect waves-light w-100 invoice-btn">Download</button>
                            </div>
                            <div class="col-md-3 p-1">
                                <button type="button" class="btn btn-secondary waves-effect waves-light w-100 invoice-btn">Print</button>
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-md-6">
                        <div class="row d-flex justify-content-end">
                            <div class="col-md-4 p-1">
                                <select class="form-control select2" id="invoice_filter" required>
                                    <option value="P">Pending</option>
                                    <option value="PP">Request a Photo</option>
                                    <option value="R">Rejected</option>
                                    <option value="A">Completed</option>
                                </select>
                            </div>
                            <div class="col-md-3 p-1">
                                <button type="button" id="invoice_confirm" class="btn btn-success waves-effect waves-light w-100 invoice-btn">Confirm</button>
                            </div>
                        </div>
                        
                    </div>              
                </div>
                <hr/>
                <div class="row p-1">
                    <div id="invoice_detail"></div>
                </div>
                <div class="row p-1">
                    <div class="col-md-4">
                        <button type="button" id="invoiceupdate" class="btn btn-primary waves-effect waves-light">Update</button>
                        <button type="button" id="invoicedelete" class="btn btn-secondary waves-effect waves-light">Delete</button>
                    </div>           
                </div>
            </div>
            <input type="hidden" id="invoice_id" value="-1">
            <div class="invoice-information-add" id="invoice_information_add" style="display:none;">
                <form class="form-horizontal needs-validation" enctype="multipart/form-data" method="POST" action="{{ route('admin.receipt.add') }}" novalidate>
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6 invoice-title">
                            <span class="mt-1 bold" style="font-size:18px;">Add a receipt transaction</span>
                        </div>
                        <div class="col-md-6">
                            <div class="row d-flex justify-content-end">
                                <div class="col-md-3 p-1">
                                    <button type="button" class="btn btn-secondary waves-effect waves-light w-100 invoice-btn">Cancel</button>
                                </div>
                                <div class="col-md-3 p-1">
                                    <button type="submit" name="submit" value="submit" class="btn btn-success waves-effect waves-light w-100 invoice-btn">Add</button>
                                </div>
                            </div>
                            
                        </div>              
                    </div>
                    <hr/>
                    <div class="row p-1">
                        <div class="card">
                            <div class="card-body">
                                
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label class="form-label" for="payment">Cash/Card</label>
                                        <select class="form-control select2" id="payment" name="payment">
                                            <option value="">Select..</option>
                                            <option value="CD">Card</option>
                                            <option value="CH">Cash</option>
                                        </select>
                                    </div>  
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label" for="bankname">Bank Name</label>
                                            <input type="text" class="form-control" style="height:38px;" id="bankname" name="bankname" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label" for="bankinformation">Bank Information</label>
                                            <input type="text" class="form-control" style="height:38px;" id="bankinformation" name="bankinformation" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label" for="istatus">Status</label>
                                            <div class="input-group">
                                                <select class="form-control select2" id="istatus" name="istatus" required>
                                                    <option value="P">Pending</option>
                                                    <option value="PP">Request a Photo</option>
                                                    <option value="R">Rejected</option>
                                                    <option value="A">Completed</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label class="form-label" for="employee_filter">Employee</label>
                                        <select class="form-control select2" id="employee_filter" name="employee_filter" required>
                                            <option value="">Employee ..</option>
                                            @foreach($employees as $employee)
                                                <option value="{{$employee->id}}" data-company="{{$employee->companyId}}">{{$employee->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>  
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label" for="icompany">Company</label>
                                            <select class="form-control select2" id="icompany" name="icompany" required>
                                                <option value="">기업 ..</option>
                                                @foreach($companies as $company)
                                                    <option value="{{$company->id}}">{{$company->companyName}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label" for="icategory">Category</label>
                                            <input type="text" class="form-control" style="height:38px;" id="icategory" name="icategory" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label" for="issuedon">Issued On</label>
                                            <input type="text" class="form-control" id="issuedon" name="issuedon" style="height:38px;"  autocomplete="off" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="border p-3">
                                    <div class="row" id="receiptdetail_0">
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="itemname_0">Item Name</label>
                                                <input type="text" class="form-control" style="height:38px;" id="itemname_0" name="itemname_0" required>
                                            </div>
                                        </div>  
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="quantity_0">Quantity</label>
                                                <input type="text" class="form-control integer" style="height:38px;" id="quantity_0" name="quantity_0" onchange="valor()" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="price_0">Price</label>
                                                <input type="text" class="form-control integer" style="height:38px;" id="price_0" name="price_0" onchange="valor()" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="total_0">Total</label>
                                                <input type="text" class="form-control integer" style="height:38px;" id="total_0" name="total_0" readonly required>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="total_item" id="total_item" value="1"/>
                                </div>
                                <div class="row mt-3">
                                    <div class="justify-content-end d-flex">
                                        <div class="col-md-2 invoice-title">
                                            <h5 class="text-end p-1">Total Amount</h5>
                                        </div>
                                        <div class="col-md-2 invoice-title">
                                            <h5 class="text-end p-1" id="totalamount">0 원</h5>
                                        </div>
                                        <div class="col-md-2 text-end">
                                            <button type="button" id="btn_add_item" class="btn btn-sm btn-primary invoice-btn">Add Item</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="inote">Note</label>
                                            <textarea type="text" class="form-control" rows="4" id="inote" name="inote" required></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="inote">Photo</label>
                                            <div class="invoice_photo" style="padding-top: .5rem;"></div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="invoice-information-update" id="invoice_information_update" style="display:none;"></div>
        </div>
    </div>
</div>
@stop
@section('javascript')
<script src="{{ asset('assets/libs/select2/js/select2.full.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/libs/image-uploader/image-uploader.min.js') }}"></script>
<script src="{{ asset('assets/libs/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/libs/lightbox/dist/js/lightbox.min.js') }}"></script>
<!-- Required datatable js -->
<script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<!-- Responsive examples -->
<script src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/daterangepicker/daterangepicker.js') }}"></script>
<!-- Sweet Alerts js -->
<script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<script>
    $(".select2").select2({width: '100%'});
    $('.invoice_photo').imageUploader();
    $(".employee-scroll").scrollbar();
    $('#issuedon').datepicker({
        showOtherMonths: true,
        selectOtherMonths: true,
        numberOfMonths: 2,
        dateFormat: 'yy.mm.dd',
        monthNames: [ "1월", "2월", "3월", "4월", "5월", "6월",
        "7월", "8월", "9월", "10월", "11월", "12월" ],
        monthNamesShort: [ "1월", "2월", "3월", "4월", "5월", "6월",
        "7월", "8월", "9월", "10월", "11월", "12월" ],
        dayNames: [ "일요일", "월요일", "화요일", "수요일", "목요일", "금요일", "토요일" ],
        dayNamesShort: [ "일", "월", "화", "수", "목", "금", "토" ],
        dayNamesMin: [ "일", "월", "화", "수", "목", "금", "토" ],

    });
    var date = new Date();
    var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
    var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
    
    var ranges = {};
    ranges['today']         = [moment(), moment()]; 
    ranges['yesterday']     = [moment().subtract(1, 'days'), moment().subtract(1, 'days')]; 
    ranges['last 7 days']   = [moment().subtract(6, 'days'), moment()]; 
    ranges['last 30 days']  = [moment().subtract(29, 'days'), moment()];
    ranges['this month']    = [moment().startOf('month'), moment().endOf('month')];
    ranges['last month']    = [moment().subtract(1,'month').startOf('month'), moment().subtract(1, 'month').endOf('month')];
    var moment_date_format = "YYYY.MM.DD";
    var dateRangeSettings = {
        ranges: ranges,
        autoUpdateInput:false, 
        format: moment_date_format,
        showWeekNumbers: true,
        // howDropdowns: true,
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-primary',
        cancelClass: 'btn-secondary',
        opens: 'left',
        showDropdowns: true,
        locale: {
            cancelLabel: 'Reset',
            applyLabel: '적용',
            customRangeLabel: 'custom range',
            format: moment_date_format,
            toLabel: "~",
            daysOfWeek: ['일', '월', '화', '수', '목', '금', '토'],
            monthNames: ['1 월', '2 월', '3 월', '4 월', '5 월', '6 월', '7 월', '8 월', '9 월', '10 월', '11 월', '12 월'],
        }
    };
    $("#analyse_intervel").text(moment(firstDay).format("MM.DD") + " ~ " + moment(lastDay).format("MM.DD"));
    $('#daterange-btn').daterangepicker(
        dateRangeSettings,
        function (start, end) {
            $('#daterange-btn span').html(start.format(moment_date_format) + ' ~ ' + end.format(moment_date_format));
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: "{{route('admin.receipt.analysisfilter')}}",
                data: {
                    start_date: start.format('YYYY-MM-DD'),
                    end_date: end.format('YYYY-MM-DD'),
                },
                type: 'POST',
                success: function(data) {
                    if (data.success) {
                        $('div#analysis_data').html(data.html);
                    } 
                },
                error: function(data){
                    console.log(data);
                }
            });
        }
    );
    $('#daterange-btn').on('cancel.daterangepicker', function(ev, picker) {
        $('#daterange-btn span').html('<i class="fa fa-calendar"></i> 기간 설정');
        analysis_all_list();
    });
    employee_all_list();
    function employee_all_list(){
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: "{{route('admin.receipt.employeelist')}}",
            data: {},
            type: 'POST',
            success: function(data) {
                if (data.success) {
                    $('div#employee_list').html(data.html);
                } 
            },
            error: function(data){
                console.log(data);
            }
        });
    }
    analysis_all_list();
    function analysis_all_list(){
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: "{{route('admin.receipt.analysis')}}",
            data: {},
            type: 'POST',
            success: function(data) {
                if (data.success) {
                    $('div#analysis_data').html(data.html);
                } 
            },
            error: function(data){
                console.log(data);
            }
        });
    }
    $(document).on('click', '#invoice_confirm', function(e){
        if($("#invoice_id").val() != '-1'){
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: "{{route('admin.invoice.status')}}",
                data: {
                    status: $("#invoice_filter").val(),
                    receiptid: $("#invoice_id").val()
                },
                type: 'POST',
                success: function(data) {
                    if (data.success) {
                        location.reload();
                    } 
                },
                error: function(data){
                    console.log(data);
                }
            });
        }
    });
    $('#pendshow').change(function() {
        if(this.checked) {
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: "{{route('admin.receipt.employeepending')}}",
                data: {},
                type: 'POST',
                success: function(data) {
                    if (data.success) {
                        $('div#employee_list').html(data.html);
                    } 
                },
                error: function(data){
                    console.log(data);
                }
            });
        } else if(!this.checked) {
            employee_all_list();
        }   
    });
    $("#company_filter").on('change', function(e){
        if($("#company_filter").val() != "") {
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: "{{route('admin.receipt.companyfilter')}}",
                data: {
                    company_filter: $("#company_filter").val()
                },
                type: 'POST',
                success: function(data) {
                    if (data.success) {
                        $('div#employee_list').html(data.html);
                    } 
                },
                error: function(data){
                    console.log(data);
                }
            });
        }
        else {
            employee_all_list();
        }
        
    });
    $("#payment").on('change', function(e){
        if($("#payment").val() == "CD"){
            $('#bankname').prop('disabled', true);
            $('#bankinformation').prop('disabled', true);
        }
        else{
            $('#bankname').prop('disabled', false);
            $('#bankinformation').prop('disabled', false);
        }
    });
    $(document).on('change','#uppayment', function(e){
        if($("#uppayment").val() == "CD"){
            $('#upbankname').prop('disabled', true);
            $('#upbankinformation').prop('disabled', true);
        }
        else{
            $('#upbankname').prop('disabled', false);
            $('#upbankinformation').prop('disabled', false);
        }
    });
    $("#employee_filter").on('change', function(e){
        $("#icompany").val($(this).find(':selected').data('company'));
        $("#icompany").trigger('change');
        if($("#employee_filter").val() != ""){
            $('#icompany').prop('disabled', true);
        }
        else{
            $('#icompany').prop('disabled', false);
        }
    });
    $(document).on('change','#upemployee_filter', function(e){
        $("#upicompany").val($(this).find(':selected').data('company'));
        $("#upicompany").trigger('change');
        if($("#upemployee_filter").val() != ""){
            $('#upicompany').prop('disabled', true);
        }
        else{
            $('#upicompany').prop('disabled', false);
        }
    });
    $("#analysisbtn").on('click', function(e){
        $("#invoice_analysis").show();
        $("#invoice_information").hide();
        $("#invoice_information_add").hide();
        $("#invoice_information_update").hide();
        $('#daterange-btn span').html('<i class="fa fa-calendar"></i> 기간 설정');
        analysis_all_list();
        $("#analyse_intervel").text(moment(firstDay).format("MM.DD") + " ~ " + moment(lastDay).format("MM.DD"));
    });
    $("#invoiceadd").on('click', function(e){
        $("#payment").val("");
        $("#payment").trigger('change');
        $("#bankname").val("");
        $("#bankinformation").val("");
        $("#status").val("P");
        $("#status").trigger('change');
        $("#employee_filter").val("");
        $("#employee_filter").trigger("change");
        $("#icompany").val("");
        $("#icompany").trigger("change");
        $("#category").val("");
        $("#issueddate").val("");
        $("#category").val("");
        var total_len = $("#total_item").val();
        for (var i=0; i<total_len; i++){
            var total = "#total_" + i;
            tquantity = "#quantity_" + i;
            tprice = "#price_" + i;
            $(total).val("");
            $(tquantity).val("");
            $(tprice).val("");
        }
        $("#totalamount").text(0 + "원");
        $("#invoice_analysis").hide();
        $("#invoice_information").hide();
        $("#invoice_information_add").show();
    });
    $(document).on('click', '.invoiceone', function(e){
        $("#invoice_information_add").hide();
        $("#invoice_information_update").hide();
        $("#invoice_information_update").html("");
        $("#invoice_analysis").hide();
        $("#invoice_information").show();
        $("#invoice_id").val($(this).data('id'));
        $("#invoice_filter").val($(this).data('status'));
        $("#invoice_filter").trigger('change');
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: "{{route('admin.receipt.detail')}}",
            data: {
                receiptid: $(this).data('id')
            },
            type: 'POST',
            success: function(data) {
                if (data.success) {
                    $('div#invoice_detail').html(data.html);
                } 
            },
            error: function(data){
                console.log(data);
            }
        });
    });
</script>
<script>
    var k =0;
    $("#btn_add_item").on('click', function (){
        var div_temp = "#receiptdetail_" + k;
        k++;
        $("#total_item").val(k+1);
        return $(
            '<div class="row" id="receiptdetail_'+ k + '">'+
                '<div class="col-md-3">'+
                    '<div class="mb-3">'+
                        '<label class="form-label" for="itemname_' + k + '">Item Name</label>' + 
                        '<input type="text" class="form-control" style="height:38px;" id="itemname_' + k + '" name="itemname_' + k + '" required>' + 
                    '</div>'+
                '</div>' +
                '<div class="col-md-3">'+
                    '<div class="mb-3">'+
                        '<label class="form-label" for="quantity_' + k + '">Quantity</label>' + 
                        '<input type="text" class="form-control integer" style="height:38px;" onchange="valor()" id="quantity_' + k + '" name="quantity_' + k + '" required>' + 
                    '</div>'+
                '</div>' +
                '<div class="col-md-3">'+
                    '<div class="mb-3">'+
                        '<label class="form-label" for="price_' + k + '">Price</label>' + 
                        '<input type="text" class="form-control integer" style="height:38px;" onchange="valor()" id="price_' + k + '" name="price_' + k + '" required>' + 
                    '</div>'+
                '</div>' +
                '<div class="col-md-3">'+
                    '<div class="mb-3">'+
                        '<label class="form-label" for="total_' + k + '">Total</label>' + 
                        '<input type="text" class="form-control integer" style="height:38px;" id="total_' + k + '" name="total_' + k + '" readonly required>' + 
                    '</div>'+
                '</div>' +
            '</div>'
        ).insertAfter(div_temp);
    });
    function valor() {	 
        var alltotal = 0;
        var total_len = $("#total_item").val();
        
        for (var i=0; i<total_len; i++){
            var total = "#total_" + i;
            tquantity = "#quantity_" + i;
            tprice = "#price_" + i;
            if($(tquantity).val() != "" && $(tprice).val() != ""){
                total_temp = parseFloat($(tquantity).val()*$(tprice).val());
                $(total).val(total_temp);
                alltotal += total_temp;	
            } 
        }
        $("#totalamount").text(alltotal + "원");
    }
    $(".integer").keypress(function (e){
        var charCode = (e.which) ? e.which : e.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
    });
    $("#invoicedelete").on('click', function(e){
        if($("#invoice_id").val() != "-1"){
            var invoiceid = $("#invoice_id").val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            Swal.fire({
                title: "Are you Sure?",
                icon: "warning",
                showCancelButton:!0,
                confirmButtonColor:"#7a6fbe",
                cancelButtonColor:"#f46a6a",
            }).then((willDelete) => {
                if (willDelete.isConfirmed) {
                    $.ajax({
                        url: "{{route('admin.receipt.delete')}}",
                        data: {
                            invoice_id: invoiceid
                        },
                        type: 'POST',
                        success: function(data) {
                            if (data.success == true) {
                                toastr.success(data.msg);
                                location.reload();
                            } 
                        },
                        error: function(data){
                            console.log(data);
                        }
                    });
                }
            });
        }
    });
    $("#invoiceupdate").on('click', function(e){
        if($("#invoice_id").val() != "-1") {
            var invoiceid = $("#invoice_id").val();
            $("#invoice_analysis").hide();
            $("#invoice_information").hide();
            $("#invoice_information_add").hide();
            $("#invoice_information_update").show();
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: "{{route('admin.receipt.invoicedata')}}",
                data: {
                    invoice_id: invoiceid
                },
                type: 'POST',
                success: function(data) {
                    if (data.success) {
                        $('div#invoice_information_update').html(data.html);
                    } 
                },
                error: function(data){
                    console.log(data);
                }
            });
        }
    });
</script>
@endsection