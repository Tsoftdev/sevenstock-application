@extends('admin.layouts.app')
@section('title', '통계')
@section('css')
<link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<!-- DataTables -->
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<!-- Responsive datatable examples -->
<link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" /> 
<link href="{{ asset('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/jquery-scrollbar/jquery.scrollbar.css') }}">
@endsection
@section('content')
<style>
    .seven-btn {
        width: 150px;
        height: 38px;
        background: #064D95;
        border: 1px solid #D3D3D3;
        box-sizing: border-box;
        border-radius: 5px;
        font-family: Noto Sans KR;
        font-style: normal;
        font-weight: 500;
        font-size: 15px;
        line-height: 22px;
        color: #FFFFFF;
        padding-top:7px;
        margin-right: 5px;
    }
    .seven-btn:hover, .seven-btn:focus, .seven-btn:active {
        color: #fff;
        background-color: #064D95;
        border-color: 1px solid #D3D3D3; 
    }
    .statistic-btn {
        width: 150px;
        border: 1px solid #6C757D;
        height: 38px;
        padding-top:8px;
        background: #FFFFFF;
    }
    .statistic-btn:hover, .statistic-btn:focus, .statistic-btn:active {
        color: #fff;
        background-color: #064D95;
        border-color: 1px solid #D3D3D3; 
    }
    .statistic-notice-title {
        font-family: Noto Sans KR;
        font-style: normal;
        font-weight: bold;
        font-size: 14px;
        line-height: 20px;

        color: #000000;
    }
    .statistic-notice-add {
        font-family: Noto Sans KR;
        font-style: normal;
        font-weight: 500;
        font-size: 13px;
        line-height: 19px;
        color: #5E5E5E;
    }
    .statistic-notice-all {
        font-family: Noto Sans KR;
        font-style: normal;
        font-weight: 500;
        font-size: 13px;
        line-height: 19px;
        color: #D36A1D;
    }
    .statistic-invest-title {
        font-family: Noto Sans KR;
        font-style: normal;
        font-weight: 500;
        font-size: 15px;
        line-height: 22px;
        color: #000000;
    }
    .btn-clasfy {
        width: 70px;
        background: #FFFFFF;
        border: 1px solid #989898;
        box-sizing: border-box;
        border-radius: 5px;
    }
    .btn-clasfy:hover, .btn-clasfy:focus, .btn-clasfy:active {
        color: #fff;
        background-color: #064D95;
    }
    .btn_active {
        color: #fff;
        background-color: #064D95;
    }
    .btn-clasfy-select {
        height: 28px;
        line-height: 1.2;
    }
    .company-name {
        font-family: Noto Sans KR;
        font-style: normal;
        font-weight: normal;
        font-size: 14px;
        line-height: 1.8;
        color: #000000;
    }
    .company-owner {
        font-family: Noto Sans KR;
        font-style: normal;
        font-weight: normal;
        font-size: 14px;
        line-height: 1.8;
        color: #000000;
    }
    .consultdate {
        font-family: Noto Sans KR;
        font-style: normal;
        font-weight: normal;
        font-size: 14px;
        line-height: 1.8;
        color: #000000;

    }
    .enddate {
        font-family: Noto Sans KR;
        font-style: normal;
        font-weight: normal;
        font-size: 14px;
        line-height: 1.8;
        color: #000000;

    }
    .reviewdate {
        font-family: Noto Sans KR;
        font-style: normal;
        font-weight: normal;
        font-size: 14px;
        line-height: 1.8;
        color: #000000;

    }
    .static-info {
        font-family: Noto Sans KR;
        font-style: normal;
        font-weight: normal;
        font-size: 14px;
        line-height: 1.8;
        color: #6C6C6C;
    }
    .shareholder-name {
        background-color: #f8f9fa!important;
    }
    .shareholder-box {
        height: 93px;
    }

    .total-invested {
        height: 93px;
    }
    .company-img {  
        max-height: 100%;  
        max-width: 100%; 
        position: relative;  
        height: 85px;
        padding: 10px; 
        margin: auto;
    }
    .statis-scroll {
        height: 190px;
        padding: .1rem .35rem !important;
    }
    .statis-scroll .scroll-bar {
        background-color: #1f263d!important;
    }
    .jsu-event-color {
        cursor: pointer;
    }
    
</style>
<div class="container-fluid">
    
    <div class="row">
        <div class="mb-3 mt-1 col-md-3 d-flex">
            <a href="javascript:void(0);" class="btn seven-btn">세븐스톡</a> 
            <select class="form-control company_filter" id="company_filter" required>
                <option value="">기업목록..</option>
                @foreach($companies as $company)
                    <option value="{{$company->id}}">{{$company->companyName}}</option>
                @endforeach
            </select>
            <input type="hidden" id="type_company" value="1" />
            <input type="hidden" name="view_type" value="day">            
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <!-- Company info section -->
                        <div class="col-md-4">
                            <div class="bg-light-grey text-center rounded p-2 mb-3" id="sevenstock-logo">
                                <div style="height:100px;">
                                    <img class="company-img" src="{{ asset('assets/images/logo.png') }}" alt="sevenstock logo">
                                </div>
                            </div>
                            <div class="bg-light-grey rounded shareholder-box p-3 mb-3" id="seven_stockholder" style="height:100px;">
                                <span class="text-dark">전체 주주 수</span>
                                <h3 class="text-right text-black investors-count"></h3>
                            </div>
                            <div class="bg-light-grey text-center rounded p-2 pb-0 mb-3" id="sevenstock-company" style="display:none;">
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 p-0 text-left">
                                        <ul class="no-list-style p-3">
                                            <li class="static-info">{{ __('기업:') }}</li>
                                            <li class="static-info">{{ __('CEO 이름:') }}</li>
                                            <li class="static-info">{{ __('컨설팅 시작날짜:') }}</li>
                                            <li class="static-info">{{ __('재계약한 날짜:') }}</li>
                                            <li class="static-info">{{ __('컨설팅 종료:') }}</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6 col-sm-6 p-0 text-left">
                                        <ul class="no-list-style p-3">
                                            <li class="company-name"></li>
                                            <li class="company-owner"></li>
                                            <li class="consultdate"></li>
                                            <li class="reviewdate"></li>
                                            <li class="enddate"></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-light-grey rounded p-3" style="height: 245px;" id="top_investment">
                                <div class="mb-2">
                                    <h6 class="text-dark">누적 투자금액 순위</h6>
                                   
                                </div>
                                <div class="pt-1 statis-scroll" id="total_statistic">
                                </div>
                                
                            </div>
                            <div class="bg-light-grey rounded shareholder-box p-3 mb-3" id="company_stockholder" style="display:none;">
                                <span class="text-dark">{{ __('주주 수') }}</span>
                                <h3 class="text-right text-black investors-count"></h3>
                            </div>

                            <div class="bg-light-grey rounded total-invested p-3 mb-3" id="company_total_stockholder" style="display:none;">
                                <span class="text-dark">{{ __('총 투자금액') }}</span>
                                <h3 class="text-right text-black total-investment"></h3>
                            </div>

                        </div>
                        <!-- End company info section -->
                        <!-- Company stats section -->
                        <div class="col-md-8">
                            <div class="row mb-3">
                                <div class="col-md-3 d-flex text-black">
                                    <span class="statistic-invest-title">
                                        Investment Status
                                    </span>
                                </div>
                                <div class="col-md-9 text-right">
                                    <button type="button" data-view-type="day" class="btn btn-clasfy switch_type btn-sm btn_active">일별</button>
                                    <button type="button" data-view-type="week" class="btn btn-clasfy switch_type btn-sm">주별</button>
                                    <button type="button" data-view-type="month" class="btn btn-clasfy switch_type btn-sm">월별</button>
                                    <button type="button" class="btn btn-primary btn-clasfy-select" id="daterange-btn">
                                        <span>
                                            <i class="fa fa-calendar"></i> 기간 설정
                                        </span>
                                        <i class="fa fa-caret-down"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="bg-light-grey rounded p-3 mt-1 mb-2">
                                        <canvas id="investmentChart" height="287"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <div class="bg-light-grey rounded p-3 mt-1 mb-2">
                                        <div class="d-flex justify-content-between">
                                            <small style="padding-top: 2px;">{{ __('총 투자자 수') }}</small>
                                            <div><h4 class="mb-0 text-black scope-investors-count"></h4></div>
                                        </div>
                                    </div>
                                    <div class="bg-light-grey rounded p-3 mt-1 mb-2">
                                        <div class="d-flex justify-content-between">
                                            <small style="padding-top: 2px;">{{ __('총 문의 건수') }}</small>
                                            <div><h4 class="mb-0 text-black total_inquery"></h4></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="bg-light-grey rounded p-3 pt-2 mt-1 mb-2 flex-stats">
                                        <span class="text-dark">{{ __('총 투자금액') }}</span>
                                        <h3 class="text-right text-black total-investment-scope"></h3>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="bg-light-grey rounded p-3 pt-2 mt-1 mb-2">
                                        <div class="mb-2">
                                            <small class="text-dark">{{ __('연령별 투자 TOP 3') }}</small>
                                            <div class="dropdown dropdown-topbar float-right">
                                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="mdi mdi-dots-horizontal"></i>
                                                    </a>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                    <a class="dropdown-item" href="#">Action</a>
                                                    <a class="dropdown-item" href="#">Another action</a>
                                                    <a class="dropdown-item" href="#">Something else here</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pt-1 investment-group-stats">
                                            <small>50</small>
                                            <div class="progress" style="height: 16px;">
                                                <div class="progress-bar bg-danger" role="progressbar" style="width: 65%;" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100">65%</div>
                                            </div>
                                        </div>
                                        
                                        <div class="pt-1 investment-group-stats">
                                            <small>60</small>
                                            <div class="progress" style="height: 16px;">
                                                <div class="progress-bar bg-primary" role="progressbar" style="width: 45%;" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100">45%</div>
                                            </div>
                                        </div>
                                        <div class="pt-1 investment-group-stats">
                                            <small>70</small>
                                            <div class="progress" style="height: 16px;">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <!-- end company stats section-->
                    </div>
                </div>
            </div>
            <div class="card" id="all_seven_view">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="d-flex justify-content-end">
                            <div class="col-md-1">
                                <select class="btn btn-outline-dark waves-effect waves-light getPageLength">
                                    <option value="100">100</option>
                                    <option value="200">200</option>
                                    <option value="500">500</option>
                                    <option value="1000">1000</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control" id="statisticsearchbox" placeholder="이름/전화번호">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="table-responsive pt-1" id="all_seven_statistic">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card" id="company_statistic" style="display:none;">
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive pt-1">
                            <table id="datatable" class="table table-bordered align-middle dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th class="align-middle">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" id='select-all-row'><span></span>
                                            </label>
                                        </th>
                                        <th>이름</th>
                                        <th>전화번호</th>
                                        <th>성별</th>
                                        <th>나이</th>
                                        <th>평균 주가금액</th>
                                        <th>총 주식 수</th>
                                        <th>총 투자금액</th>
                                        <th>담당자</th>
                                        <th></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Notices section -->
        <!-- <div class="col-md-3">
            <div class="card mt-xl-0 mb-0">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h5 class="statistic-notice-title">Notice</h5>
                        </div>
                        <div class="col-md-6">
                            <div class="justify-content-end d-flex">
                                <a href="javascript:void(0);" class="me-2 statistic-notice-add"> Add</a>
                                <a href="javascript:void(0);" class="statistic-notice-all"> View All</a>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <!-- End notices section-->
    </div>
</div>
@stop
@section('javascript')
<script src="{{ asset('assets/libs/select2/js/select2.full.min.js') }}"></script>
<!-- Chart JS -->
<script src="{{ asset('assets/libs/chart.js/Chart.bundle.min.js') }}"></script>
<!-- Required datatable js -->
<script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<!-- Responsive examples -->
<script src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
<!-- date picker -->
<script src="{{ asset('assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<!-- plugin js -->
<script src="{{ asset('assets/libs/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('assets/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('assets/libs/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
<!-- Sweet Alerts js -->
<script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

<script>
    $(".company_filter").select2({width: '100%'});
    $(".statis-scroll").scrollbar();
    $('.getPageLength').on('change', function(){
        $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `/admin/statistics_sevenstock`,
            data: {
                pagelen: $(".getPageLength").val()
            },
            type: 'POST',
            success: function(data) {
            if (data.success) {
                $("#all_seven_statistic").html(data.html);
            }
            },
            error: function(data) {
            console.log(data);
            }
        });
    });
    $("#statisticsearchbox").keyup(function(e){
        if($("#statisticsearchbox").val() != "") {
            $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: `/admin/statistics_sevenstock`,
                data: {
                    searchval: $("#statisticsearchbox").val()
                },
                type: 'POST',
                success: function(data) {
                if (data.success) {
                    $("#all_seven_statistic").html(data.html);
                }
                },
                error: function(data) {
                console.log(data);
                }
            });
        } else {
            SevenStocksInit();
        }
    });
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
    
    $('#daterange-btn').daterangepicker(
        dateRangeSettings,
        function (start, end) {
            $('#daterange-btn span').html(start.format(moment_date_format) + ' ~ ' + end.format(moment_date_format));

            var company = $("#company_filter").val();
            $(".switch_type").removeClass('btn_active');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if($("#type_company").val() == '0') {
                $.ajax({
                    url: `/admin/statistics_chart`,
                    data: {
                        company_id: company,
                        view_type: $("input[name=view_type]").val(),
                        start_date: start.format('YYYY-MM-DD'),
                        end_date: end.format('YYYY-MM-DD'),
                    },
                    type: 'POST',
                    success: function(data) {
                        updateChart(data.investments);
                        updateRecords(data);
                        shareholder_table.ajax.url( '/admin/statistics_shareholder?start_date=' + start.format('YYYY-MM-DD') + '&end_date=' + end.format('YYYY-MM-DD') ).load();
                    },
                    error: function(data){
                    }
                });
            } else if($("#type_company").val() == '1') {
                $.ajax({
                    url: `/admin/statistics_all_chart`,
                    data: {
                        view_type: $("input[name=view_type]").val(),
                        start_date: start.format('YYYY-MM-DD'),
                        end_date: end.format('YYYY-MM-DD'),
                    },
                    type: 'POST',
                    success: function(data) {
                        $("#total_statistic").html(data.html);
                        updateChart(data.investments);
                        $(".scope-investors-count").text(data.total_investor);
                        $(".total-investment-scope").text(new Intl.NumberFormat().format(data.total_invested));
                        $(".investors-count").text(data.total_investor);
                        shareholder_table.ajax.url( '/admin/statistics_shareholder?start_date=' + start.format('YYYY.MM.DD') + '&end_date=' + end.format('YYYY.MM.DD') ).load();
                    },
                    error: function(data){
                    }
                });
            }
            
        }
    );
    $('#daterange-btn').on('cancel.daterangepicker', function(ev, picker) {
        shareholder_table.ajax.url( '/admin/statistics_shareholder').load();
        if($("#type_company").val() == '1') {
            allcompanyInit();
        } else if ($("#type_company").val() == '0') {
            companyInit();
        }
        $('#daterange-btn span').html('<i class="fa fa-calendar"></i> Select Date');
    });
    
    var shareholder_table = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        lengthMenu: [ 100, 150, 200, 250 ],
        "ajax": {
            "url": "/admin/statistics_shareholder",
            "data": function ( d ) {
                d.company_filter = $('select#company_filter').val();
            }
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
            "targets": [0, 1, 9],
            // "orderable": false,
            // "searchable": false,
        } ],
        "columns":[
            {"data":"mass_delete"},
            // {"data":"date"},
            {"data":"name", "name": "name"},
            {"data":"phonenumber1", "name": "phonenumber1"},
            {"data":"gender", "name": "gender"},
            {"data":"age", "name": "age"},
            {"data":"stockPrice", "name": "stockPrice"},
            {"data":"quantity", "name": "quantity"},
            {"data":"invested", "name": "invested"},
            {"data":"customerGroupID", "name": "customerGroupID"},
            {"data":"action"},
        ],
        "createdRow": function( row, data, dataIndex ) {
            $( row ).find('td:eq(1)').attr('class', 'shareholder-name text-primary fw-bold');
        },
    });
    $('select#company_filter').on('change', function(){
        $("#company_statistic").show();
        $("#all_seven_view").hide();
        $("#type_company").val('0');
        if($('select#company_filter').val() != "") {
            $("#seven_stockholder").hide();
            $("#top_investment").hide();
            $("#sevenstock-company").show();
            $("#company_stockholder").show();
            $("#company_total_stockholder").show();
            companyInit();
            shareholder_table.ajax.reload();
        }; 
    });
    $(".seven-btn").on('click', function(e){
        $('select#company_filter').val('');
        $('select#company_filter').trigger('change');
        $("#type_company").val('1');
        shareholder_table.ajax.reload();
        $("#sevenstock-logo").find('.company-img').attr('src', `{{ asset('assets/images/logo.png') }}`);
        $("#seven_stockholder").show();
        $("#top_investment").show();
        $("#sevenstock-company").hide();
        $("#company_stockholder").hide();
        $("#company_total_stockholder").hide();
        $('#daterange-btn span').html('<i class="fa fa-calendar"></i> Select Date');
        $("#all_seven_view").show();
        $("#company_statistic").hide();
        allcompanyInit();
    });
    var backgroundColor = [];
    let chartLabels = [];
    let chartValues = [] 
    let chartLine = [];
    let Investors = [];

    var ctx = document.getElementById('investmentChart').getContext('2d');
    var investmentChart = new Chart(ctx, {
        type: 'bar',
        data: {},
        options: {
            legend: {
                display: false
            },
            maintainAspectRatio: false,
            scales: {
                yAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: '투자금액 (100만원 단위)'
                    },
                    ticks: {
                        beginAtZero: true,
                        callback: function(item, index) {
                            //var month = label.split(";")[0];
                            return parseInt(item)/10000;
                        }
                    }
                }],
                xAxes: [{
                    // scaleLabel: {
                    //     display: true,
                    //     labelString: 'Date',
                    // },
                    ticks: {
                        beginAtZero: false,
                    }
                }]
            },
            onClick: graphClickEvent
        }
    });

    function graphClickEvent(e){
        var element = this.getElementAtEvent(e);
        if(element.length > 0){
            for(var i=0;i<backgroundColor.length;i++){
                backgroundColor[i] = '#5e88f6';
            }
            backgroundColor[element[0]._index] = 'lightgreen';
            var total_investment_scope = chartValues[element[0]._index];
            var investors_count = Investors[element[0]._index];
            $(".total-investment-scope").text(new Intl.NumberFormat().format(total_investment_scope));
            $(".scope-investors-count").text(investors_count);
            this.update();
            // ctx.fillText(value, element[0]._model.x, element[0]._model.y - 5);
        }
    }
    allcompanyInit();
    function allcompanyInit() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: `/admin/statistics_all_chart`,
            data: {
                view_type: $("input[name=view_type]").val(),
                start_date: $("input[name=start_date]").val(),
                end_date: $("input[name=end_date]").val(),
            },
            type: 'POST',
            success: function(data) {
                $("#total_statistic").html(data.html);
                updateChart(data.investments);
                $(".scope-investors-count").text(data.total_investor);
                $(".total-investment-scope").text(new Intl.NumberFormat().format(data.total_invested));
                $(".investors-count").text(data.total_all_investor);
                $(".total_inquery").text(data.total_inqueries);
            },
            error: function(data){
            }
        });

    }
    
    function companyInit() {
        var company = $("#company_filter").val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: `/admin/statistics_chart`,
            data: {
                company_id: company,
                view_type: $("input[name=view_type]").val(),
            },
            type: 'POST',
            success: function(data) {
                updateChart(data.investments);
                updateRecords(data);
            },
            error: function(data){
            }
        });
    }
    SevenStocksInit();
    function SevenStocksInit() {
        $.ajax({
            url: `/admin/statistics_sevenstock`,
            data: {
                
            },
            type: 'POST',
            success: function(data) {
                $("#all_seven_statistic").html(data.html); 
            },
            error: function(data){
            }
        });
    }

    function updateRecords(data) {
        $(".investors-count").text(data.investors);
        $(".scope-investors-count").text(data.investors);
        $(".total-investment-scope").text(data.total_investment_scope);
        $(".total-investment").text(data.total_investment);
        $(".company-name").text(data.company.companyName);
        $(".total_inquery").text(data.total_inqueries);
        $(".company-owner").text(data.owner);
        if(data.company.consultdate){
            $(".consultdate").text(moment(data.company.consultdate).format("YYYY.MM.DD"));
        } else {
            $(".consultdate").text("");
        }
        if(data.company.reviewdate){
            $(".reviewdate").text(moment(data.company.reviewdate).format("YYYY.MM.DD"));
        } else {
            $(".reviewdate").text("");
        }
        if(data.company.enddate){
            $(".enddate").html("");
            var edate = $("<span/>").text(moment(data.company.enddate).format("YYYY.MM.DD"));
            var cbtn = $("<button/>").addClass("btn ms-3 btn-danger btn-sm end_cancel").attr("data-id", data.company.id).text("취소");
            $(".enddate").append(edate).append(cbtn);
        } else {
            $(".enddate").text("");
        }
        $("#sevenstock-logo").find('.company-img').attr('src', data.company.companylogo);
    }

    $(".switch_type").click(function(){
        $("input[name=view_type]").val($(this).data('view-type'));
        console.log($("input[name=view_type]").val())
        $(".switch_type").removeClass('btn_active');
        $(this).addClass('btn_active');
        if($("#type_company").val() == '1') {
            allcompanyInit();
        } else if ($("#type_company").val() == '0') {
            companyInit();
        }
        
        $('#daterange-btn span').html('<i class="fa fa-calendar"></i> Select Date');
    });

    $(document).on("click", '.end_cancel', function(e) {
        var comid = $(this).data('id');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        Swal.fire({
            title: "Are you Sure?",
            icon: "warning",
            showCancelButton:!0,
            confirmButtonText: "Yes",
            cancelButtonText: "Cancel",
            confirmButtonColor:"#7a6fbe",
            cancelButtonColor:"#f46a6a",
        }).then((willDelete) => {
            if (willDelete.isConfirmed) {
                $.ajax({
                    url: `/admin/companyend-delete`,
                    data: {
                        comid: comid
                    },
                    type: 'POST',
                    success: function(data) {
                        if (data.success == true) {
                            $(".enddate").html("");
                            toastr.success(data.msg);     
                                
                        } 
                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            }
        });
    });

    function updateChart(investments) {
        chartLabels = investments.map(m => m.date);
        chartValues = investments.map(m => m.amount);
        Investors = investments.map(m => m.investors);
        chartLine = investments.map(m => ({
            x: m.date,
            y: m.amount,
        }));
        
        backgroundColor = [];
        for (let index = 0; index < chartValues.length; index++) 
            backgroundColor.push("#5e88f6");
        
        
        investmentChart.data.labels = chartLabels;
        investmentChart.data.datasets[0] = {
            type: 'bar',
            label: '투자금액',
            data: chartValues,
            backgroundColor,
            borderWidth: 1
        }
        investmentChart.data.datasets[1] = {
            type: 'line',
            label: '송장',
            data: chartLine,
            pointBackgroundColor: 'red',
            pointRadius: 4,
            borderColor: '#000',
            borderWidth: 1,
            fill: true
        }
        investmentChart.update();
    }    

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