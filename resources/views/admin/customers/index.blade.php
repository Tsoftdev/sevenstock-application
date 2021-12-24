@extends('admin.layouts.app')
@section('title', '고객관리')
@section('css')
<link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<!-- DataTables -->
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<!-- Responsive datatable examples -->
<link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" /> 
<link href="{{ asset('assets/libs/ion-rangeslider/css/ion.rangeSlider.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/libs/slick-master/slick/slick.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/libs/slick-master/slick/slick-theme.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<style type="text/css">
.dt-button-collection .dropdown-menu {
    position:relative !important
}
.dt-button-collection {
    left: unset !important;
    right: 10px ;
}
.dropdown-item.active, .dropdown-item:active {
    color: #f4f5f7;
    text-decoration: none;
    background-color: #7a6fbe;
}
#daterange, #allcustomer {
    height: 38px;
    white-space: nowrap;
}
.dt-buttons.btn-group.flex-wrap {
    display: none;
}
.text-white {
    color: #fff!important;
}
.hover:hover {
    color: #6c757d;
}  
.select2-container .select2-selection--single .select2-selection__arrow b {
    border-color: #000000 transparent transparent transparent;
} 

.mdi-keyboard-return::before {
    transform: rotate(180deg) scaleX(-1);
}
.modal-backdrop.fade.show {
    opacity: 0;
}
.irs--big .irs-handle {
    background: #fff !important;
    border-radius: unset !important;
    border: 1px solid #7A6FBE !important;
}
.irs--big .irs-bar {
    height: 15px !important;
    border: #7A6FBE !important;
    background: #7A6FBE !important;
    box-shadow: unset !important;
}
.irs--big .irs-line {
    height: 15px !important;
    background: #C4C4C4 !important;
    border: 1px solid #7A6FBE !important;
}
#offcanvasRight{
    margin-top: 70px; 
    overflow-y: scroll;
    background: rgb(248, 248, 248); 
    box-shadow: rgb(0 0 0 / 25%) -4px 8px 14px 4px;
}
.offcanvas-header{
    border-bottom: 1px solid #b0b0b0; 
    padding-top: 14px;
    padding-bottom: 14px;
}
.resetBtn{
    border-radius: 0; 
    height: 45px;
}
.searchBtn{
    border-radius: 0;
    height: 47px;
}
.carousel{
  width:100%;
  margin:0px auto;
  padding: 0 !important;
}
.slick-list.draggable {
    padding: 0 !important;
}
button.slick-next.slick-arrow {
    right: 74px;
    top: 16px;
}
.slick-prev:before, .slick-next:before{
    color: #000 !important;
}
#carousel .slick-active {
    background-color: #343a40;
    border-color: #343a40;
}
.box{
    width: 96%;
}
.carousel{
    margin-top: 6px;
}
.radio_choose_range{
    height:25px; width: 26px;
}
.carousel {
    opacity: 0;
    display: none;
    transition: auto;
    -webkit-transition: opacity 1s ease;
}
.carousel.slick-initialized {
    display: block;
    opacity: 1;    
}
.email_box{
    padding: 0px 15px;
}
.email_box i{
    font-size: 20px;
}


button.slick-prev.slick-arrow.slick-disabled {
    position: absolute;
    left: -194px;
    top: 14px;
}
button.slick-prev.slick-arrow{
    position: absolute;
    left: -194px;
    top: 14px;
}
.slick-list.draggable {
    width: 88%;
}
/*.daterangepicker.dropdown-menu.opensright {
    overflow-y: scroll;
    max-height: 200px;
}*/
.daterangepicker.dropdown-menu.opensright.show-calendar {
    overflow-y: scroll;
    height: 700px;
}
#datatable-buttons_filter {
    position: absolute;
    top: 29px;
    left: 160px;
}   
.form-check-input {
    height: 22px;
    width: 22px;
}
.slick-track {
    margin-left: unset !important;
}
input#daterange1 {
    background-color: #e9ecef;
    opacity: 1;
}
</style>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-7" style="display: flex;">
            <ul class="carousel1" style="padding:0">
                <li class="slide" style="list-style:none; width: 170px;">
                    <input type="hidden" id="selected_company_id" value="all">
                    <a data-id="all" class="company_filter box btn btn-dark waves-effect waves-light" href="javascript:void(0);" style="margin-top: 5px;">전체 ({{ $customers->count() }})</a>
                </li>
            </ul>
            <ul class="carousel" style="width:90%;">
                @foreach($companies as $company)
                    <li class="slide">
                        <a data-id="{{ $company->id }}" class="company_filter box btn btn-outline-secondary waves-effect me-md-1 hover" href="javascript:void(0);">{{ $company->companyName }} ({{ $company->stocks->count() > 0 ? $company->stocks->groupBy('userId')->count() : 0}})
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="col-md-5">
            <div class="" style="padding: 5px 4px;">
                {{ Form::open(array('url' => '','class'=>'form-inline', 'files' => true,'id'=>'cutomerImportForm')) }}
                    <div class="row">
                        <div class="col-md-6 pe-0">
                            {{ Form::file('file',array('class'=>'form-control import-file' )) }}
                        </div>
                        <div class="col-md-3 pe-0">
                            <button type="submit" class="btn btn-secondary waves-effect import-btn w-100">
                               업로드 <i class="fas fa-file-import"></i> 
                                <i class="fa fa-spinner fa-spin" style="display:none;"></i>
                            </button>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ url('admin/cutomerExport') }}" class="btn btn-secondary waves-effect w-100">
                                다운로드 <i class="fa fa-file-export"></i>
                            </a>
                        </div>
                    </div>
                {{ Form::close() }}    
            </div>
            <div id="message"></div>
        </div>
    </div>
    
    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="page-title-custom">
                                <h4>고객목록 &nbsp;
                                    <span style="color: #6c757d; font-size: 15px;">
                                        ({{ $customers->count() }})
                                    </span>
                                </h4>
                            </div>
                        </div>
                        <div class="col-md-4 text-right">
                            <select class="btn btn-outline-dark waves-effect waves-light getPageLength">
                                <option value="100">100</option>
                                <option value="200">200</option>
                                <option value="500">500</option>
                                <option value="1000">1000</option>
                            </select>

                            <button type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight" class="btn btn-dark waves-effect waves-light text-white">
                                <i class="ti-filter"></i> 필터
                            </button>
                            <button type="button" id="alldelete" class="btn btn-secondary waves-effect w-25 text-white" style="display:none">삭제</button>
                            <a href="{{ url('admin/add_customer') }}" class="btn btn-primary waves-effect waves-light w-25 text-white">등록</a>
                        </div>
                    </div>
                    <div class="table-responsive pt-1">
                        <table id="datatable-buttons" class="table table-bordered align-middle dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th class="align-middle">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input selectCheckboxAll" id='select-all-row'><span></span>
                                        </label>
                                    </th>
                                    <!-- <th>날짜</th> -->
                                    <th>경험</th>
                                    <th>상태</th>
                                    <th>이름</th>
                                    <th>전화번호</th>
                                    <!-- <th>성별</th> -->
                                    <th>연령대</th>
                                    <!-- <th>지역</th> -->
                                    <th>총 투자한 기업 수</th>
                                    <th>총 투자금액</th>
                                    <th>담당자</th>
                                    <!--th>Email</th>
                                    <th>Level</th-->
                                    <th></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- filter right offcanvas modal-->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <form id="customerFilterForm">
        <div class="offcanvas-header">
            <h5 id="offcanvasRightLabel" style="margin: 0;">필터</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
   
        <div class="offcanvas-body">

            <div class="row mb-2">
                <div class="col-md-12">
                    <label class="mb-0">날짜</label>
                    {{ Form::text('daterange',null,array('class'=>'form-control','id'=>'daterange','readonly')) }}
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-12">
                    <label class="mb-0">투자 경과 기간</label>
                    {{ Form::text('investment_elapset_time',null,array('class'=>'form-control','id'=>'daterange1')) }}
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-12">
                    <label class="mb-0">투자한 년도</label>
                    <?php 
                    $result = \App\Models\Stock::groupBy('year')->select(DB::raw('YEAR(created_at) as year'))->distinct()->get();
                    $years = $result->pluck('year','year')->prepend('Select Year','');

                    $s_i_e = \App\Models\Customer::pluck('stock_investment_experience','stock_investment_experience')->prepend('Select Stock investment experience','');
                    $i_l_f = \App\Models\Customer::pluck('investable_liquid_funds','investable_liquid_funds')->prepend('Select investable liquid funds','');
                    $ageGroup = \App\Models\Customer::pluck('age','age')->prepend('Select age group','');
                    ?>
                    {{ Form::select('year_of_investment',$years,null,array('class'=>'form-control search_filter','id'=>'year_of_investment')) }}
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-12">
                    <label class="mb-0">관리</label>
                    {{ Form::select('group_filter[]',$groups->pluck('groupName','id'),null,array('class'=>'form-control search_filter','multiple','id'=>'group_filter')) }}
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-12">
                    <label class="mb-0">기업</label>
                    {{ Form::select('companyFilter[]',$companies->pluck('companyName','id'),null,array('class'=>'form-control search_filter','multiple','id'=>'company_filter')) }}
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-12">
                    <label class="mb-0">지역</label>
                    {{ Form::select('city_filter[]',$cities,null,array('class'=>'form-control search_filter','multiple','id'=>'city_filter')) }}
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-12">
                    <label class="mb-0">알게된 경로</label>
                    {{ Form::select('route_filter[]',$routeknowns,null,array('class'=>'form-control search_filter','multiple','id'=>'route_filter')) }}
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-12">
                    <label class="mb-0">연령대</label>
                    {{ Form::select('age_group',$ageGroup,null,array('class'=>'form-control','id'=>'age_group')) }}
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-12">
                    <label class="mb-0">주식투자경력</label>
                    {{ Form::select('stock_investment_experience',$s_i_e,null,array('class'=>'form-control search_filter','id'=>'stock_investment_experience')) }}
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-12">
                    <label class="mb-0">투자 가능 유동성 자금</label>
                    {{ Form::select('investment_liquid_funds',$i_l_f,null,array('class'=>'form-control search_filter','id'=>'investment_liquid_funds')) }}
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-6">
                   <label>투자 범위</label>
                </div>
                <div class="col-md-6 text-right">
                   <label>Unit: 100 만원</label>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-12">
                    <input type="text" id="range_slider">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-5">
                   <input type="text" name="from_range" class="form-control text-center" value="0" id="from_range">
                </div>
                <div class="col-md-2"><p style="font-size: 18px;">~</p></div>
                <div class="col-md-5 text-right">
                   <input type="text" name="to_range" class="form-control text-center" value="10000" id="to_range">
                   <input type="hidden" name="onload" id="onload" value="yes">
                </div>
            </div>

            <div class="row mb-1">
                <div class="col-md-1">
                    <input type="radio" name="radio_choose_range" id="first" class="radio_choose_range" value="1-10">
                </div>
                <div class="col-md-3" style="margin-top: 4px;">
                    <label for="first">1~10</label>
                </div>
                <div class="col-md-7" style="margin-top: 5px;">
                    <label for="first">({{getStockCounts(1,10)}})</label>
                </div>
            </div>
            <div class="row mb-1">
                <div class="col-md-1">
                    <input type="radio" name="radio_choose_range" id="second" class="radio_choose_range" value="10-50">
                </div>
                <div class="col-md-3" style="margin-top: 4px;">
                    <label for="second">10~50</label>
                </div>
                <div class="col-md-7" style="margin-top: 5px;">
                    <label for="second">({{getStockCounts(10,50)}})</label>
                </div>
            </div>
            <div class="row mb-1">
                <div class="col-md-1">
                    <input type="radio" name="radio_choose_range" id="third" class="radio_choose_range" value="50-100">
                </div>
                <div class="col-md-3" style="margin-top: 4px;">
                    <label for="third">50~100</label>
                </div>
                <div class="col-md-7" style="margin-top: 5px;">
                    <label for="third">({{getStockCounts(50,100)}})</label>
                </div>
            </div>
            <div class="row mb-1">
                <div class="col-md-1">
                    <input type="radio" name="radio_choose_range" id="fourth" class="radio_choose_range" value="100-1000">
                </div>
                <div class="col-md-3" style="margin-top: 4px;">
                    <label for="fourth">100~1,000</label>
                </div>
                <div class="col-md-7" style="margin-top: 5px;">
                    <label for="fourth">({{getStockCounts(100,1000)}})</label>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-1">
                    <input type="radio" name="radio_choose_range" id="fifth" class="radio_choose_range" value="1000-10000">
                </div>
                <div class="col-md-3" style="margin-top: 4px;">
                    <label for="fifth">1,000~10,000</label>
                </div>
                <div class="col-md-7" style="margin-top: 5px;">
                    <label for="fifth">({{getStockCounts(1000,10000)}})</label>
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-secondary waves-effect mb-2 w-100 resetBtn" id="reset_search">리셋</button>
        <button type="button" id="searchFilter" class="btn btn-primary btn-lg waves-effect waves-light w-100 searchBtn">
            검색 <i class="fa fa-spinner fa-spin" style="display:none;"></i>
        </button>
    </form>
</div>

<!--excel upload modal content -->
<div id="exceluploadmodal" class="modal fade" role="dialog" aria-labelledby="excelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="head_title">Add New Excel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <form class="needs-validation p-3" id="ExceluploadForm" enctype="multipart/form-data" novalidate>
                    <meta name="csrf-token" content="{{ csrf_token() }}" />
                    <div id="text_error" class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
                    </div>
                    <div class="mb-3 row pt-2">
                        <label for="excel_file" class="col-md-4 col-form-label">Excel File:</label>
                        <div class="col-md-8">
                            <input class="dropify" type="file" id="excel_file" name="excel_file" required>
                        </div>
                    </div>
                </form>           
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary waves-effect waves-light btn-sm btn_exceladd">업로드</button>
            </div>
        </div>
    </div>
</div>
@stop
@section('javascript')
<script src="{{ asset('assets/libs/select2/js/select2.full.min.js') }}"></script>
<!-- Required datatable js -->
<script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<!-- Buttons examples -->
<script src="{{ asset('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/libs/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('assets/libs/pdfmake/build/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/libs/pdfmake/build/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>
<!-- Responsive examples -->
<script src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
<!-- <script src="{{ asset('assets/libs/jquery.maskedinput/jquery.maskedinput.js') }}"></script> -->

<script src="{{ asset('assets/libs/slick-master/slick/slick.min.js') }}"></script>

<!-- Ion Range Slider-->
<script src="{{ asset('assets/libs/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>

<!-- Range slider init js-->
<script src="{{ asset('assets/js/pages/range-sliders.init.js') }}"></script>

<script src="{{ asset('assets/daterangepicker/moment.min.js') }}"></script>
<script src="{{ asset('assets/daterangepicker/daterangepicker.js') }}"></script>

<script type="text/javascript">

$(document).ready(function(){
    localStorage.removeItem('cuser');
    localStorage.removeItem('cphone');
    $('#date').datepicker({
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

    $('.carousel').slick({
        speed: 500,
        infinite: false,
        slidesToShow: 4,
        slidesToScroll: 3,
        autoplay: false,
        autoplaySpeed: 2000,
        dots:false,
        centerMode: false,
    });
});


//For range slider
var $range_slider       = $("#range_slider");
var $radio_choose_range = $(".radio_choose_range");
var $from_range         = $("#from_range");
var $to_range           = $("#to_range");
$range_slider.ionRangeSlider({
    skin: "big",
    type: "double",
    min:  0,
    max:  10000,
    from: 0,
    to:   10000
});
$range_slider.on("change", function () {
    var $inp    = $(this);
    var v       = $inp.prop("value");     // input value in format FROM;TO
    var from    = $inp.data("from");   // input data-from attribute
    var to      = $inp.data("to");       // input data-to attribute
    $("#from_range").val(from);
    $("#to_range").val(to);
});
var instance_update = $range_slider.data("ionRangeSlider");
$radio_choose_range.on("click", function () {
    var value = $(this).val().split('-');
    $("#from_range").val(value[0]);
    $("#to_range").val(value[1]);
    instance_update.update({
        from: value[0],
        to:   value[1],
    });
});
$from_range.on("change keyup", function () {
    var from = $(this).val();
    instance_update.update({
        from: from,
    });
});
$to_range.on("change keyup", function () {
    var to = $(this).val();
    instance_update.update({
        to:  to,
    });
});



//Default settings for daterangePicker
var ranges = {};
// $('#daterange').daterangepicker({ startDate: '', endDate: '' });
ranges['today']         = [moment(), moment()]; 
ranges['yesterday']     = [moment().subtract(1, 'days'), moment().subtract(1, 'days')]; 
ranges['last 7 days']   = [moment().subtract(6, 'days'), moment()]; 
ranges['last 30 days']  = [moment().subtract(29, 'days'), moment()];
ranges['this month']    = [moment().startOf('month'), moment().endOf('month')];
ranges['last month']    = [moment().subtract(1,'month').startOf('month'), moment().subtract(1, 'month').endOf('month')];
ranges['Reset']         = [null,null]; 
var moment_date_format = "YYYY.MM.DD";
var dateRangeSettings = {
    ranges: ranges,
    autoUpdateInput:false, 
    format: moment_date_format,
    showWeekNumbers: true,
    howDropdowns: true,
    buttonClasses: ['btn', 'btn-sm'],
    applyClass: 'btn-success',
    cancelClass: 'btn-danger',
    opens: 'left',
    locale: {
        cancelLabel: '취소',
        applyLabel: '적용',
        customRangeLabel: 'custom range',
        format: moment_date_format,
        toLabel: "~",
        daysOfWeek: ['일', '월', '화', '수', '목', '금', '토'],
        monthNames: ['1 월', '2 월', '3 월', '4 월', '5 월', '6 월', '7 월', '8 월', '9 월', '10 월', '11 월', '12 월'],
    }
};
if($('#daterange').length == 1){
    $('#daterange').daterangepicker(
        dateRangeSettings,
        function (start, end) {
            if(start._isValid && end._isValid) {
                $('#daterange').val(start.format(moment_date_format) + ' ~ ' + end.format(moment_date_format));
            } else {
                $('#daterange').data('daterangepicker').setStartDate(moment().startOf('year'));
                $('#daterange').data('daterangepicker').setEndDate(moment().endOf('year'));
                $("#daterange").val("");
            }
            customer_table.ajax.reload();
        }
    );
    $('#daterange').on('cancel.daterangepicker', function(ev, picker) {
        $('#daterange').val('');
        customer_table.ajax.reload();
    });
};

if($('#daterange1').length == 1){
    $('#daterange1').daterangepicker(
        dateRangeSettings,
        function (start, end) {
            if(start._isValid && end._isValid) {
                $('#daterange1').val(start.format(moment_date_format) + ' ~ ' + end.format(moment_date_format));
            } else {
                $('#daterange1').data('daterangepicker').setStartDate(moment().startOf('year'));
                $('#daterange1').data('daterangepicker').setEndDate(moment().endOf('year'));
                $("#daterange1").val("");
            }
            customer_table.ajax.reload();
        }
    );
    $('#daterange1').on('cancel.daterangepicker', function(ev, picker) {
        $('#daterange1').val('');
        customer_table.ajax.reload();
    });
};

//for datatable
col_targets = [0, 6, 7, 9];
var customer_table = $('#datatable-buttons').DataTable({
    aaSorting: [[ 0, "desc" ]],
    "oLanguage": { "sSearch": "" },
    lengthChange:false,
    processing: false,
    serverSide: true,
    searching: true,
    pageLength: 25, 
    paging: true, 
    info: false,
    fixedHeader: true,
    "ajax": {
        "url": "/admin/customers",
        "data": function ( d ) {
            d.group_filter          = $('select#group_filter').val();
            d.single_company_filter = $('#selected_company_id').val();
            d.year_of_investment    = $('#year_of_investment').val();
            d.stock_investment_experience    = $('#stock_investment_experience').val();
            d.investment_liquid_funds    = $('#investment_liquid_funds').val();
            d.age_group         = $('#age_group').val();
            d.company_filter    = $('#company_filter').val();
            d.from_range        = $('#from_range').val();
            d.to_range          = $('#to_range').val();
            d.onload            = $('#onload').val();
            d.route_filter      = $('select#route_filter').val();
            d.city_filter       = $("select#city_filter").val();
            d.start_date        = $('#daterange').val()!='' ? $('#daterange').data('daterangepicker').startDate.format('YYYY.MM.DD') : '' ;
            d.end_date          = $('#daterange').val()!='' ? $('#daterange').data('daterangepicker').endDate.format('YYYY.MM.DD') : '' ;
            
            d.start_date1       = $('#daterange1').val()!='' ? $('#daterange1').data('daterangepicker').startDate.format('YYYY.MM.DD') : '' ;
            d.end_date1         = $('#daterange1').val()!='' ? $('#daterange1').data('daterangepicker').endDate.format('YYYY.MM.DD') : '' ;

            d.desksearch        = $("#desksearchbox").val();
            d.mobilesearch      = $("#mobilesearchbox").val();
        },
        complete: function() {
            $("#searchFilter").find('i').hide();
        },
    },
    "language": {
        "sEmptyTable":     "등록된 자료가 없습니다",
        "sInfo":           "_START_ - _END_ / _TOTAL_",
        "sInfoEmpty":      "0 - 0 / 0",
        "sInfoFiltered":   "(총 _MAX_ 개)",
        "sInfoPostFix":    "",
        "sInfoThousands":  ",",
        "sLengthMenu":     "페이지당 줄수 _MENU_",
        "sLoadingRecords": "읽는중...",
        "sProcessing":     "처리중...",
        "sSearch":         "검색:",
        "sZeroRecords":    "검색 결과가 없습니다",
        "oPaginate": {
            "sFirst":    "처음",
            "sLast":     "마지막",
            "sNext":     "다음",
            "sPrevious": "이전"
        },
        "oAria": {
            "sSortAscending":  ": 오름차순 정렬",
            "sSortDescending": ": 내림차순 정렬"
        }
    },
    "dom": 'Bfrtip',
    columnDefs: [ {
        "targets": col_targets,
        "orderable": false,
        "searchable": false,
    },{ width: '5%', targets: 7 } ],
    select: true,
    columns:[
        {"data":"mass_delete"},
        //{"data":"date"},
        {"data":"level"},
        {"data":"status_id"},
        {"data":"name"},
        {"data":"phonenumber1"},
        //{"data":"gender"},
        {"data":"age"},
        //{"data":"cityName"},
        {"data":"numberOfInvertedCompany"},
        {"data":"totalInvested"},
        {"data":"customerGroupID"},
        //{"data":"email"},
        {"data":"action"}
    ],
    "createdRow": function( row, data, dataIndex ) {
        $( row ).find('td:eq(3)').attr('class', 'bg-light text-primary fw-bold');
    },
    buttons: [
        {
            extend: 'pdfHtml5',
            text: "PDF",
            exportOptions: {
                columns: ':visible'
            }
        },
        {
            extend: 'copyHtml5',
            text: "복사",
            exportOptions: {
                columns: ':visible'
            }
        },
        {
            extend: 'colvis',
            text: "Display",
            postfixButtons: [ 'colvisRestore' ]
        },
    ],
    language: {
        buttons: {
            copyTitle: '클립 보드에 복사',
            copySuccess: {
                _: '%d 개의 행을 클립보드에 복사했습니다',
                1: '1행 복사됨'
            }
        }
    }
});

customer_table.page.len(100).draw();
customer_table.buttons().container().appendTo(".custom_manage_button");
$(".dataTables_length select").addClass("form-select form-select-sm");
$("#text_error").hide();
$('.phoneMask').mask('(999) 9999-9999');

$(".search_filter").select2({width: '100%'});

/*$('select#group_filter, select#company_filter, select#route_filter, select#city_filter').on('change', function(){
    customer_table.ajax.reload();
});*/

$('.company_filter').on('click', function(){
    var that = $(this);
    $('.company_filter').removeClass('btn-dark').addClass('btn-outline-secondary');
    that.removeClass('btn-outline-secondary bg-white').addClass('btn-dark');
    $("#selected_company_id").val(that.data('id'));
    customer_table.ajax.reload();
});

$('.getPageLength').on('change', function(){
    customer_table.page.len($(this).val()).draw();
    if ($('input.selectCheckboxAll').is(':checked')) {
        $(".selectCheckbox").prop('checked', true);
    }
});

$('#searchFilter').on('click', function(){
    $("#onload").val('no');
    $("#searchFilter").find('i').show();
    customer_table.ajax.reload();
});

$('#reset_search').on('click', function(){
    $('#customerFilterForm')[0].reset() ;
    $("#year_of_investment").val('').trigger('change');
    $("#stock_investment_experience").val('').trigger('change');
    $("#investment_liquid_funds").val('').trigger('change');
    $("#group_filter").val('').trigger('change');
    $("#company_filter").val('').trigger('change');
    $("#city_filter").val('').trigger('change');
    $("#route_filter").val('').trigger('change');
    instance_update.update({
        from: 0,
        to:   10000,
    });
    customer_table.ajax.reload();
});

/*$('#allcustomer').on('click', function(e) {
    location.reload();
})*/

$(".btn_exceladd").on('click', function(e){
    var form = $("#ExceluploadForm");
    if (form[0].checkValidity() === false) {
        event.preventDefault()
        event.stopPropagation()
        form.addClass('was-validated');
        return;
    }
    var excel_file = $("#excel_file").prop('files')[0];
    var form_data = new FormData();
    form_data.append('excel_file', excel_file);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: `/admin/excel-upload`,
        data: form_data,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function(data) {
            if (data.status == "Success") {
                location.reload();
            } else {
                $("#text_error").html("File empty or bad file");
                $("#text_error").show();
            }
        },
        error: function(data){
            $("#text_error").html(data);
            $("#text_error").show();
        }
    });
});

$('#excel_file').on('change', function(event) {
    var inputFile      = event.currentTarget;
    var file_name      = inputFile.files[0].name;
    var arr_file_name  = file_name.split(".");
    var file_extension = arr_file_name[arr_file_name.length - 1];

    if (file_extension == "xls" || file_extension == "xlsx"){
        $("#text_error").html("");
        $("#text_error").hide();
        $(".btn_exceladd").prop('disabled', false);
    } else {
        $("#text_error").html("Should be Excel file");
        $("#text_error").show();
        $('#excel_file').empty();
        $(".btn_exceladd").prop('disabled', true);
    }
});


//Buld cusotmer delete start
var array = [];
$(".selectCheckboxAll").click(function(){
    $("input:checkbox[name=customer_ids]").prop('checked', $(this).prop('checked'));
    $('input:checkbox[name=customer_ids]').each(function(){
        var value = $(this).val();
        if($(this).is(':checked')){
            var index = array.findIndex((e) => e.id == value);
            if(index < 0){
                array.push({id:value});
            }
        }else{
            var index = array.findIndex((e) => e.id == value);
            array.splice(index, 1);
        }
    });
    if($(".selectCheckbox:checked").length > 0){
        $("#alldelete").show();
    }else{
        $("#alldelete").hide();
    }
});
var array = [];
$("body").on('click','.selectCheckbox', function(){
    var value = $(this).val();
    if($(this).is(':checked')){
        var index = array.findIndex((e) => e.id == value);
        if(index < 0){
            array.push({id:value});
        }
    }else{
        var index = array.findIndex((e) => e.id == value);
        array.splice(index, 1);
    }
    if($(".selectCheckbox:checked").length == $(".selectCheckbox").length){
        $(".selectCheckboxAll").prop('checked', true);
    }else{
        $(".selectCheckboxAll").prop('checked', false);
    }

    if($(".selectCheckbox:checked").length > 0){
        $("#alldelete").show();
    }else{
        $("#alldelete").hide();
    }
});
$("#alldelete").on('click', function(){
    if(array.length > 0) {
        $.ajax({
            beforeSend:function(){
                return confirm("Are you sure?");
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: ajaxUrl+'/admin/customerdelete',
            data: {
                ids: array,
            },
            type: 'POST',
            success: function(response) {
                if (response.success) {
                    if (Array.isArray(response.message)) {
                        $.each(response.message, function(i, v) {
                            if (v['type'] == 'success') {
                                toastr.success(v['message'], 'Success');
                            } else {
                                toastr.error(v['message'], 'Error');
                            }
                        });
                    } else {
                        toastr.success(response.message, 'Success');
                    }
                    if (response.reload != '') {
                        location.reload();
                    } else if (response.redirect_url != '') {
                        setTimeout(function() {
                            location.href = response.redirect_url;
                        }, 2000);
                    }
                } else {
                    toastr.error('Something going wrong!', 'Opps!');
                } 
            },
            error: function(status, error) {
                var errors = JSON.parse(status.responseText);
                if (status.status == 401 || status.status == 400) {
                    console.log(errors);
                    $("#form").find('button').attr('disabled', false);
                    $("#form").find('button>i.fa').hide();
                    $.each(errors.error, function(i, v) {
                        toastr.error(v[0], 'Opps!');
                    });
                } else {
                    toastr.error(errors.message, 'Opps!');
                }
            }
        });
        return false;
    }else{
        toastr.error('Please select at least one record for delete!', 'Opps!');
    }
})
//Buld cusotmer delete end

$(".customer_delete").on('click', function(e){
    e.preventDefault();
    var selected_rows = [];
    var i = 0;
    $('.form-check-input:checked').each(function () {
        selected_rows[i++] = $(this).val();
    });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    if(selected_rows.length > 0) {
        $.ajax({
            url: `/admin/customerdelete`,
            data: {
                selected_rows: selected_rows,
            },
            type: 'POST',
            success: function(data) {
                if (data.status == "Success") {
                    location.reload();
                } 
            },
            error: function(data){
                console.log(data);
            }
        });
    }
});

$("#cutomerImportForm").on('submit', function(){
    var formData = new FormData($("#cutomerImportForm")[0]);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function() {
            $("#cutomerImportForm").find('button').attr('disabled', true);
            $("#cutomerImportForm").find('button>.fa.fa-spinner.fa-spin').show();
        },
        url: `/admin/cutomerImport`,
        data: formData,
        type: 'POST',
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.success) {
                var html = '<span style="color:green;">'+response.message+'</span>';
                $('#message').html(html);
                location.reload();
            } 
        },
        complete: function() {
            $("#cutomerImportForm").find('button').attr('disabled', false);
            $("#cutomerImportForm").find('button>i.fa.fa-spinner.fa-spin').hide();
        },
        error: function(data){
            var errors = JSON.parse(data.responseText);
            if (data.status == 401) {
                $("#cutomerImportForm").find('button').attr('disabled', false);
                $("#cutomerImportForm").find('button>i.fa.fa-spinner.fa-spin').hide();
                $.each(errors.error, function(i, v) {
                    console.log(v[0]);
                    var html = '<span style="color:red;">'+v[0]+'</span>';
                    $('#message').html(html);
                });
            }
        }
    });
    return false;
});

$("#btn_desksearch").on("click", function(e){
    if($("#desksearchbox").val() != "") {
        customer_table.ajax.reload();
    }
});
$("#btn_mobilesearch").on("click", function(e){
    if($("#mobilesearchbox").val() != "") {
        customer_table.ajax.reload();
    }
});
$('#desksearchbox').keypress(function(event){
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13'){
        //if($("#desksearchbox").val() != "") {
            customer_table.ajax.reload();
        //}
    }
});
$('#mobilesearchbox').keypress(function(event){
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13'){
        if($("#mobilesearchbox").val() != "") {
            customer_table.ajax.reload();
        }
    }
});
$(document).on("click", ".btn_customer_memo", function(e) {
    $("body").toggleClass("right-memo-enabled");
    $("#memo_customer_id").val($(this).data('id'));
    $(".loader").show();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: `/admin/memo-list`,
        data: {
            customer_id: $(this).data('id'),
        },
        type: 'POST',
        success: function(data) {
            if (data.success) {
                $(".loader").hide();
                $("#customer_memo_list").html(data.html); 
            } 
        },
        error: function(data){
            console.log(data);
        }
    });
}); 
$(document).on("click", "body", function(e) {
    0 < $(e.target).closest(".btn_customer_memo, .right-bar-memo").length || $("body").removeClass("right-memo-enabled")
});

$(document).on('click', "#customer_memo_add", function(e) {
    $("#memonote").val('');
    $("#memokeyword").tagsinput('removeAll');
    $("#customer_memo_add_form").hide();
    $("#customer_memo_list").hide();
    $("#customer_memo_form_new").show();
});
$(document).on('click',".btn_customer_memoadd", function(e) {
    var form = $("#MemoForm");
    if (form[0].checkValidity() === false) {
        event.preventDefault()
        event.stopPropagation()
        form.addClass('was-validated');
        return;
    }
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: `/admin/memo-add`,
        data: {
            customer: $("#memo_customer_id").val(),
            note: $("#memonote").val(),
            company: $("#memocompany").val(),
            keyword: $("#memokeyword").val()
        },
        type: 'POST',
        success: function(data) {
            if (data.status = 'success') {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: `/admin/memo-list`,
                    data: {
                        customer_id: $("#memo_customer_id").val(),
                    },
                    type: 'POST',
                    success: function(data) {
                        if (data.success) {
                            $("#customer_memo_add_form").show();
                            $("#customer_memo_list").show();
                            $("#customer_memo_form_new").hide();
                            $("#customer_memo_list").html(data.html);
                        } 
                    },
                    error: function(data){
                        console.log(data);
                    }
                });                    
            } 
        },
        error: function(data){
            console.log(data);
        }
    });
});

$(document).on('click', ".btn_customer_memocancel", function(e) {
    $("#customer_memo_add_form").show();
    $("#customer_memo_list").show();
    $("#customer_memo_form_new").hide();
    $("#customer_memo_form_update").hide();
});
$(document).on('click', '.customer_memo_delete', function(e) {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: `/admin/memo-delete`,
        data: {
            memo_id: $(this).data('id')
        },
        type: 'POST',
        success: function(data) {
            if (data.status = 'success') {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: `/admin/memo-list`,
                    data: {
                        customer_id: $("#memo_customer_id").val(),
                    },
                    type: 'POST',
                    success: function(data) {
                        if (data.success) {
                            $("#customer_memo_list").show();
                            $("#customer_memo_list").html(data.html);
                        } 
                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            } 
        },
        error: function(data){
            console.log(data);
        }
    });
});

$(document).on('click', ".customer_memo_update", function(e) {
    $("#upmemo_id").val($(this).data('id'));
    $("#customer_memo_add_form").hide();
    $("#customer_memo_list").hide();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: `/admin/memo-get`,
        data: {
            memoid: $("#upmemo_id").val(),
        },
        type: 'POST',
        success: function(data) {          
            $("#upmemonote").val(data.note);
            $("#upmemocompany").val(data.company);
            $("#upmemokeyword").tagsinput('removeAll');
            $("#upmemokeyword").tagsinput('add',data.keyword);
            $("#customer_memo_form_update").show();
        },
        error: function(data){
            console.log(data);
        }
    });
});
$(document).on('click',".upbtn_customer_memo", function(e) {
    var form = $("#UpMemoForm");
    if (form[0].checkValidity() === false) {
        event.preventDefault()
        event.stopPropagation()
        form.addClass('was-validated');
        return;
    }
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: `/admin/memo-update`,
        data: {
            customer: $("#memo_customer_id").val(),
            note: $("#upmemonote").val(),
            keyword: $("#upmemokeyword").val(),
            company: $("#upmemocompany").val(),
            memoid: $("#upmemo_id").val()
        },
        type: 'POST',
        success: function(data) {
            if (data.status = 'success') {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: `/admin/memo-list`,
                    data: {
                        customer_id: $("#memo_customer_id").val(),
                    },
                    type: 'POST',
                    success: function(data) {
                        if (data.success) {
                            $("#customer_memo_add_form").show();
                            $("#customer_memo_list").show();
                            $("#customer_memo_form_new").hide();
                            $("#customer_memo_form_update").hide();
                            $("#customer_memo_list").html(data.html);
                        } 
                    },
                    error: function(data){
                        console.log(data);
                    }
                });                     
            } 
        },
        error: function(data){
            console.log(data);
        }
    });
});

$(document).on('click', '.customer_memo_pin', function(e) {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: `/admin/memo-pin`,
        data: {
            memoid: $(this).data('id')
        },
        type: 'POST',
        success: function(data) {
            if (data.status = 'success') {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: `/admin/memo-list`,
                    data: {
                        customer_id: $("#memo_customer_id").val(),
                        pinned: true
                    },
                    type: 'POST',
                    success: function(data) {
                        if (data.success) {
                            $("#customer_memo_add_form").show();
                            $("#customer_memo_list").show();
                            $("#customer_memo_form_new").hide();
                            $("#customer_memo_form_update").hide();
                            $("#customer_memo_list").html(data.html);
                        } 
                    },
                    error: function(data){
                        console.log(data);
                    }
                });                   
            } 
        },
        error: function(data){
            console.log(data);
        }
    });
});
</script>
@endsection