@extends('admin.layouts.app')
@section('title', 'Dashboard')
@section('css')
<!-- C3 Chart css -->
<link href="{{ asset('assets/libs/c3/c3.min.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/libs/fullcalendar/main.css') }}">
<link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/jquery-scrollbar/jquery.scrollbar.css') }}">
@endsection
@section('content')
<style>
    .fc-event, .fc-event-dot {
        background-color: #ffffff!important;
        cursor: pointer!important;
    }
    .fc a, .fc a:hover {
        cursor: pointer;
        color: #2b3a4a;
    }
    .pinned-scroll {
        height: 92vh;
    }
    .pinned-card {
        padding: .1rem .75rem !important;
    }
    .pinned-scroll .scroll-bar {
        background-color: #1f263d!important;
    }
    .activity-scroll {
        height: 96vh;
    }
    .activity-card {
        padding: .1rem .75rem !important;
    }
    .activity-scroll .scroll-bar {
        background-color: #1f263d!important;
    }
    .activity-feed .feed-item {
        padding-left: 20px;
    }
    .cbottom {
        margin-bottom: 0;
    }
    .datestyle {
        border-radius: 7px;
        background-color: #e9ecef!important;
    }
    body[data-sidebar=dark].vertical-collpsed {
            min-height: auto!important;
        }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="mt-2">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="page-title-dashboard">
                                    <h5 class="font-size-14 mb-3">스케줄관리</h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="page-title-dashboard justify-content-end d-flex">
                                    <h5 class="font-size-14 mb-3">{{ date('Y.m.d') }}</h5>
                                </div>
                            </div>
                        </div>
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <!-- <div class="card">
                <div class="card-body">
                <div class="mt-2">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="page-title-dashboard">
                                <h5 class="font-size-14 mb-3">Recent Activity Feed</h5>
                            </div>
                        </div>
                    </div>
                    <ul class="list-unstyled activity-feed ms-1 activity-scroll activity-card" id="feedhistorylist">
                    </ul>
                </div>
                </div>
            </div> -->
            <div class="card">
                <div class="card-body">
                <div class="mt-1">
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="page-title-dashboard">
                                <h5 class="font-size-14 mb-3">상담요청 (웹사이트)</h5>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="justify-content-end d-flex">
                                <a href="javascript:void(0);" class="btn_contact_all fw-bold"> 전체 </a>
                                <a href="javascript:void(0);" class="btn_contact_investor fw-bold ms-2"> 투자자 </a>
                                <a href="javascript:void(0);" class="btn_contact_company fw-bold ms-2"> 기업 </a>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="contact_type" value="all" />
                    <div id="contactlist" class="activity-scroll activity-card"></div>
                </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <!-- <div class="card">
                <div class="card-body">
                    <div class="mt-1">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="page-title-custom">
                                    <h5 class="font-size-14 mb-4">Routs of Known Rate</h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="justify-content-end d-flex">
                                    <select class="form-control select2" id="routs_year" required>
                                    @foreach($periods as $period)
                                        <option value="{{$period}}">{{$period}} 년</option>
                                    @endforeach
                                </select>
                                </div>
                            </div>
                            <div id="routs-chart" class="morris-charts morris-charts-height" style="height: 50vh; width: 100%;" dir="ltr"></div>
                        </div>
                        
                    </div>
                </div>
            </div> -->
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="page-title-custom">
                                <h5 class="pinned-title">전달사항</h5>
                            </div>
                        </div>
                        <div class="mt-1 col-md-6">
                            <div class="justify-content-end d-flex">
                                <a href="javascript:void(0);" class="btn btn-primary me-2 btn-sm btn_pinadd"> 등록하기</a>
                                <a href="javascript:void(0);" class="btn btn-secondary btn-sm btn_pin_viewall"> View All</a>
                                
                            </div>
                        </div>
                    </div>
                    <hr class="flex-grow-1 mt-1 mb-3" style="height:1px;">
                    <div class="row" id="pinnedlistdiv"> 
                        <div id="pinnedlist" class="pinned-scroll pinned-card"></div>
                    </div>
                    <div id="pin_add_part" style="display:none;">
                        <div class="row mb-3" >
                            <form class="form-horizontal needs-validation" id="PinnedForm" novalidate>
                                <div class="col-md-12">
                                    <textarea class="form-control" id="pintext" name="pintext" placeholder="There will be some text by admin" rows="10" spellcheck="false" required></textarea>
                                </div>
                            </form>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="justify-content-start d-flex">
                                    <a href="javascript:void(0);" class="btn btn-primary btn-sm me-2 btn_pinned_add"> 등록하기 </a>
                                    <a href="javascript:void(0);" class="btn btn-secondary btn-sm btn_pinned_back"> 돌아가기</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div id="pin_update_part" style="display:none;">
                        <div class="row mb-3" >
                            <form class="form-horizontal needs-validation" id="UpPinnedForm" novalidate>
                                <div class="col-md-12">
                                    <textarea class="form-control" id="upintext" name="upintext" placeholder="There will be some text by admin" rows="10" spellcheck="false" required></textarea>
                                </div>
                                <input id="pinned_message_id" type="hidden" />
                            </form>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="justify-content-start d-flex">
                                    <a href="javascript:void(0);" class="btn btn-primary btn-sm me-2 btn_pinned_update"> 저장하기 </a>
                                    <a href="javascript:void(0);" class="btn btn-secondary btn-sm btn_pinned_back"> 돌아가기</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
<!--Detail modal content -->
<div id="detailmodal" class="modal fade" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">스케줄 정보</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body" id="detail_info">
                <div class="row mt-3 mb-3">
                    <div class="col-sm-12">
                        <strong>제목: </strong> <span id="dtitle"></span><br>   
                    </div>
                    
                </div> 
                <div class="row mb-3">
                    <div class="col-sm-6">
                        <label class="form-label">Start: </label>
                        <div class="border datestyle p-3">
                            <p class="cbottom text-center">
                                <span id="dstartdate"></span>
                            </p>
                            <p class="cbottom text-center">
                                <span id="dstarttime" style="font-size:16px;font-weight:bold;"></span>
                            </p>
                        </div>
                        
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label">End: </label>
                        <div class="border datestyle p-3" id="enddatepart">
                            <p class="cbottom text-center">
                                <span id="denddate"></span>
                            </p>
                            <p class="cbottom text-center">
                                <span id="dendtime" style="font-size:16px;font-weight:bold;"></span>
                            </p>
                        </div>
                        
                    </div>
                    
                </div> 
                <div class="row mb-3" id="sche_status">
                </div> 
                <div class="row mb-3">
                    <div class="col-sm-12">
                        <label class="form-label" for="mnote">Note: </label>
                        <textarea rows="4" class="form-control" id="dnote" readonly></textarea>
                    </div>
                </div>  
                <hr>  
                <input type="hidden" id="detailid" />
            
            </div>
            <div class="row mb-3 ps-3 pe-3">
                <div class="mt-1 col-sm-6">
                    <strong>편집자:</strong> <span id="dcreatedBy"></span>
                </div>
                <div class="col-sm-6">
                    <div class="d-flex justify-content-end">
                        <a href="javascript:void(0);" class="btn btn-danger me-2 w-50" id="delete_schedule">삭제</a>
                        <button type="button" class="btn btn-secondary w-50 waves-effect" data-bs-dismiss="modal">닫기</button>
                    </div>
                </div>
            </div> 
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!--status modal content -->
<div id="statusmodal" class="modal fade" role="dialog" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">상태 선택</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body" id="manage_info">
                <form class="needs-validation" id="StatusForm" novalidate>             
                    <div class="mb-3 row">
                        <label class="form-label" for="mstatus">상태 <span class="text-danger">*</span></label>
                        <select class="form-control select_status" id="mstatus" name="mstatus" required>
                            <option value="Active">완료</option>
                            <option value="Pending">진행중</option>
                            <option value="Canceled">취소</option>
                        </select>
                    </div>
                </form>
                <input type="hidden" id="scheduleid" />
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect btn-sm" data-bs-dismiss="modal">취소하기</button>
                <button type="button" class="btn btn-primary waves-effect waves-light btn-sm btn_schedule_status_change">등록하기</button>
                
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
@stop
@section('javascript')
<script src="{{ asset('assets/libs/d3/d3.min.js') }}"></script>
<script src="{{ asset('assets/libs/c3/c3.min.js') }}"></script>
<script src="{{ asset('assets/libs/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/libs/fullcalendar/main.js') }}"></script>
<script src="{{ asset('assets/libs/fullcalendar/locales-all.js') }}"></script>
<script src="{{ asset('assets/libs/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
<!-- Sweet Alerts js -->
<script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<script>
    localStorage.removeItem('cuser');
    localStorage.removeItem('cphone');
    $(document).on('click','.btn_new_user', function(e){
        localStorage.setItem("cuser", $(this).data('cuser'));
        localStorage.setItem("cphone", $(this).data('cphone'));
        location.href = `{{ url('admin/add_customer/') }}`;
    });
    
    $(".pinned-scroll").scrollbar();
    $(".activity-scroll").scrollbar();
    var schedulelist = [];
    
    $("#btn_desksearch").on("click", function(e){
        if($("#desksearchbox").val() != "") {
            getevents();
            feedhistory_list();
        }
    });
    $("#btn_mobilesearch").on("click", function(e){
        if($("#mobilesearchbox").val() != "") {
            getevents();
            feedhistory_list();
        }
    });
    $('#desksearchbox').keypress(function(event){
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13'){
            getevents();
            feedhistory_list();
        }
    });
    $('#mobilesearchbox').keypress(function(event){
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13'){
            if($("#mobilesearchbox").val() != "") {
                getevents();
                feedhistory_list();
            }
        }
    });
    var cols = [
                ["Campaign", 78],
                ["Order", 10],
                ["Registered", 10],
                ["Visitor", 10]
            ];
    ! function(e) {
        "use strict";
        function t() {}
        t.prototype.init = function() {
            c3.generate({
                bindto: "#routs-chart",
                data: {
                    columns: cols,
                    type: "donut"
                },
                subtitles: {
                    text: "$263.20",
                    verticalAlign: "center"
                },
                donut: {
                    title: "Customers",
                    width: 15,
                    label: {
                        show: !1
                    }
                },
                color: {
                    pattern: ["#7a6fbe", "#ec536c", "#58db83", "#0dcaf0"]
                }
            })
        }, e.ChartC3 = new t, e.ChartC3.Constructor = t
    }(window.jQuery),
    function() {
        "use strict";
        window.jQuery.ChartC3.init()
    }();
    // d3.select("svg").append("text")
    //     .attr("x", 130 )
    //     .attr("y", 130)
    //     //.style("text-anchor", "middle")
    //     .text("goes here");
    $(".select2").select2({width: "100%"});
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        contentHeight: '90vh',
        locale: 'ko',
        headerToolbar: {
            left: 'title',
            center: '',
            right: 'weekButton monthButton allButton'
        },
        initialView: 'listWeek',
        events: function (fetchInfo, successCallback, failureCallback) {
                successCallback(schedulelist);
            },
        customButtons: {
            allButton: {
                text:'모두',
                click:function(info){  
                    calendar.changeView('listYear');
                    var view = calendar.view;
                    var tableHeader = $(".fc-list-table th");
                    var listEvents = $('tr.fc-list-event');
                    var maxCol = 0;
                    var arrayLength = listEvents.length;
                    
                    for (var i = 0; i < arrayLength; i++) {
                        maxCol = Math.max(maxCol, listEvents[i].children.length);
                    }
                    tableHeader.attr("colspan", maxCol);
                }
            },
            weekButton: {
                text:'주',
                click:function(info){
                    calendar.changeView('listWeek');
                    var view = calendar.view;
                    var tableHeader = $(".fc-list-table th");
                    var listEvents = $('tr.fc-list-event');
                    var maxCol = 0;
                    var arrayLength = listEvents.length;
                    
                    for (var i = 0; i < arrayLength; i++) {
                        maxCol = Math.max(maxCol, listEvents[i].children.length);
                    }
                    tableHeader.attr("colspan", maxCol);
                }
            },
            monthButton: {
                text:'월',
                click:function(info){
                    calendar.changeView('listMonth');
                    var view = calendar.view;
                    var tableHeader = $(".fc-list-table th");
                    var listEvents = $('tr.fc-list-event');
                    var maxCol = 0;
                    var arrayLength = listEvents.length;
                    
                    for (var i = 0; i < arrayLength; i++) {
                        maxCol = Math.max(maxCol, listEvents[i].children.length);
                    }
                    tableHeader.attr("colspan", maxCol);
                }
            },
        },
        eventDidMount: function (info) {
            $(info.el).find(".fc-list-event-time").addClass("detail_data").attr("data-id", info.event.id);
            $(info.el).find(".fc-list-event-title").addClass("detail_data").attr("data-id", info.event.id);
            
            if(info.event.extendedProps.customer.length > 0) {
                var usericon = $("<button/>").addClass("btn waves-effect btn_list_user").attr("data-id", info.event.id).append($("<i/>").addClass("far fa-user"));
            }
            if(info.event.extendedProps.note) {
                var chaticon = $("<button/>").addClass("btn waves-effect btn_list_chat").attr("data-id", info.event.id).append($("<i/>").addClass("fab fa-rocketchat"));
            }
            var custombtn = $("<td/>")
                .addClass("fc-list-event text-end").append(usericon).append(chaticon);
            
            $(info.el).append(custombtn);
            $(info.el).find(".fc-list-event.text-end").addClass("detail_data").attr("data-id", info.event.id);
            var tableHeader = $(".fc-list-table th");
            var listEvents = $('tr.fc-list-event');
            var maxCol = 0;
            var arrayLength = listEvents.length;
            
            for (var i = 0; i < arrayLength; i++) {
                maxCol = Math.max(maxCol, listEvents[i].children.length);
            }
            
            tableHeader.attr("colspan", maxCol);
            $('tr.fc-list-event td').each(function(){
                $(this).addClass("align-middle");
                if($(this).hasClass('fc-list-event-title')) {
                    $(this).addClass('text-start');
                }
                
            });
            
        }
    });
    calendar.render();
    getevents();
    function getevents() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: `/admin/getfilterschedule`,
            data: {
                desksearch : $("#desksearchbox").val(),
                mobilesearch: $("#mobilesearchbox").val()
            },
            type: 'POST',

            success: function(data) {
                schedulelist = [];
                schedulelist.push.apply(schedulelist, data);
                calendar.refetchEvents();
            },
            error: function(data){
                console.log(data);
            }
        });
    }
    $(".btn_pinadd").on('click', function(e){
        $(this).hide();
        $("#pintext").val('');
        $("#pinnedlistdiv").hide();
        $("#pin_add_part").show();
        $(".btn_pin_viewall").hide();
        
    });
    $(".btn_pin_viewall").on('click', function(e){
        $("#pin_add_part").hide();
        $("#pin_update_part").hide();
        $(".btn_pinadd").show();
        $("#pinnedlist").show();
        pinned_all_list();
    });
    $(".btn_pinned_add").on('click', function(e){
        var form = $("#PinnedForm");
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
            url: `/admin/pinned-add`,
            data: {
                'message': $('#pintext').val(),
            },
            type: 'POST',
            success: function(data) {
                if (data.success) {
                    toastr.success(data.msg);
                    $("#pin_add_part").hide();
                    $("#pin_update_part").hide();
                    $(".btn_pinadd").show();
                    $(".btn_pin_viewall").show();

                    pinned_all_list();
                } 
            },
            error: function(data){
                console.log(data);
            }
        });
    });
    function pinned_all_list(){
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `/admin/pinned-all-list`,
            data: {},
            type: 'POST',
            success: function(data) {
                if (data.success) {
                   $("#pinnedlistdiv").show();
                   $("#pinnedlist").html(data.html);
                } 
            },
            error: function(data){
                console.log(data);
            }
        });
    }
    pinned_all_list();
    $(document).on('click', '.pagination a', function(event){
        event.preventDefault(); 
        var page = $(this).attr('href').split('page=')[1];
        pinned_pagination(page);
    });
    function pinned_list(){
        var currentdate = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `/admin/pinned-list`,
            data: {
                date: currentdate,
            },
            type: 'POST',
            success: function(data) {
                if (data.success) {
                   $("#pinnedlist").show();
                   $("#pinnedlist").html(data.html);
                   $(".btn_pinadd").show();
                } 
            },
            error: function(data){
                console.log(data);
            }
        });
    }
    function pinned_pagination(page) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:"{{ route('pinned.pagination.fetch') }}",
            method:"POST",
            data:{page:page},
            success:function(data)
            {
                $('#pinnedlist').html(data);
            }
        });
    }
    $(".btn_pinned_back").on('click', function(e) {
        $(".btn_pinadd").show();
        $("#pin_add_part").hide();
        $("#pin_update_part").hide();
        $("#pinnedlistdiv").show();
        $(".btn_pin_viewall").show();
        pinned_all_list();
    });
    $(document).on('click', '.pinned_delete', function(e){
        $("#pin_add_part").hide();
        
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `/admin/pinned_message_delete`,
            data: {
                messageid: $(this).data('id'),
            },
            type: 'POST',
            success: function(data) {   
                     
                if(data.success) {
                    toastr.success(data.msg);
                    $("#pin_update_part").hide();
                    pinned_all_list();
                }
            },
            error: function(data){
                console.log(data);
            }
        });
    });
    $(document).on('click', '.pinned_update', function(e) {
        $("#pinnedlistdiv").hide();
        $("#pin_add_part").hide();
        $(".btn_pinadd").hide();
        $(".btn_pin_viewall").hide();
        $("#pinned_message_id").val($(this).data('id'));
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `/admin/pinned-message-get`,
            data: {
                messageid: $("#pinned_message_id").val(),
            },
            type: 'POST',
            success: function(data) {          
                $("#upintext").val(data.message);
                $("#pin_update_part").show();
            },
            error: function(data){
                console.log(data);
            }
        });
    });
    $(document).on('click', '.btn_pinned_update', function(e){
        var form = $("#UpPinnedForm");
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
            url: `/admin/pinned-update`,
            data: {
                'message': $('#upintext').val(),
                'messageid': $('#pinned_message_id').val(),
            },
            type: 'POST',
            success: function(data) {
                if (data.success) {
                    $("#pin_add_part").hide();
                    $("#pin_update_part").hide();
                    $(".btn_pin_viewall").show();
                    toastr.success(data.msg);
                    pinned_all_list();
                } 
            },
            error: function(data){
                console.log(data);
            }
        });
    });
    var today = new Date();
    $(document).on('click','.pinned_pin', function(e){
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `/admin/pinned-message-pin`,
            data: {
                messageid: $(this).data('id'),
            },
            type: 'POST',
            success: function(data) {
                if (data.status = 'success') {
                    toastr.success("Pinned Successfully !");
                    var currentdate = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: `/admin/pinned-all-list`,
                        data: {
                            date: currentdate,
                            ped: true
                        },
                        type: 'POST',
                        success: function(data) {
                            if (data.success) {
                            $("#pinnedlist").show();
                            $("#pinnedlist").html(data.html);
                            $(".btn_pinadd").show();
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
    feedhistory_list();
    function feedhistory_list(){
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `/admin/feedhistory-list`,
            data: {
                desksearch : $("#desksearchbox").val(),
                mobilesearch: $("#mobilesearchbox").val()
            },
            type: 'POST',
            success: function(data) {
                if (data.success) {
                   $("#feedhistorylist").html(data.html);
                } 
            },
            error: function(data){
                console.log(data);
            }
        });
    }
    contact_list();
    function contact_list(){
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `/admin/contact-list`,
            data: {
                contact_type : $("#contact_type").val(),
            },
            type: 'POST',
            success: function(data) {
                if (data.success) {
                   $("#contactlist").html(data.html);
                } 
            },
            error: function(data){
                console.log(data);
            }
        });
    }
    $(".btn_contact_all").on('click', function(e) {
        $("#contact_type").val('all');
        contact_list();
    });
    $(".btn_contact_investor").on('click', function(e) {
        $("#contact_type").val('investor');
        contact_list();
    });
    $(".btn_contact_company").on('click', function(e) {
        $("#contact_type").val('company');
        contact_list();
    });
    $(document).on('click', '.detail_data', function(e){
        $("#detailid").val($(this).data('id'));
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: `/admin/schedule_detail`,
            data: {
                schedule_id: $(this).data('id')
            },
            type: 'POST',
            success: function(data) {
                $("#detailmodal").modal('show');
                $("#dtitle").html(data.title);
                $("#dcreatedBy").html(data.UserName);
                if(data.type == "A") {
                    $("#enddatepart").show();
                    $("#dstartdate").html(data.startdate);
                    $("#dstarttime").html('');
                    if(data.enddate) {
                        $("#denddate").html(data.enddate);
                        $("#dendtime").html('');
                    }
                } else {
                    if(data.type == "E") {
                        $("#dstartdate").html(data.startdate);
                        $("#dstarttime").html(data.starttime);
                        $("#denddate").html('');
                        $("#dendtime").html('');
                        $("#enddatepart").hide();
                    } else if(data.type == "T") {
                        $("#enddatepart").show();
                        $("#dstartdate").html(data.startdate);
                        $("#dstarttime").html(data.starttime);
                        if(data.enddate) {
                            $("#denddate").html(data.enddate);
                            $("#dendtime").html(data.endtime);
                        }
                        
                    }
                    
                }
                var tstatus = "";
                for(var customername of data.customer.split(",")){
                    var subcustom = customername.split(":");
                    tstatus += '<div class="col-sm-9 mb-3">'
                        + '<input type="text" class="form-control" placeholder="Customer Name" readonly value="' + subcustom[0].trim() + '">' + 
                        '</div>';
                    if(subcustom[1] == "Active") {
                        tstatus += '<div class="col-sm-3"><a href="javascript:void(0);" class="btn btn-success waves-effect text-nowrap waves-light btn_schedulestatus" data-status="' + subcustom[1] + '" style="width: 80px !important;" data-id="' + subcustom[2] + '">완료</a></div>';
                    }
                        
                    else if (subcustom[1] == "Pending") {
                        tstatus += '<div class="col-sm-3"><a href="javascript:void(0);" class="btn btn-info text-nowrap waves-effect waves-light btn_schedulestatus" data-status="' + subcustom[1] + '" style="width: 80px !important;" data-id="' + subcustom[2] + '">진행중</a></div>';
                    }
                    else if (subcustom[1] == "Canceled") {
                        tstatus += '<div class="col-sm-3"><a href="javascript:void(0);" class="btn btn-danger text-nowrap waves-effect waves-light btn_schedulestatus" data-status="' + subcustom[1] + '" style="width: 80px !important;" data-id="' + subcustom[2] + '">취소</a></div>'
                    }
                    
                }
                $("#sche_status").html(tstatus);
                $("#dnote").html(data.note);
                
                
               
            },
            error: function(data){
                console.log(data);
            }
        });
        
    });
    $("#delete_schedule").on('click', function() {
        var sid = $("#detailid").val();
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
                    url: `/admin/scheduledelete`,
                    data: {
                        schedule_id: sid
                    },
                    type: 'POST',
                    success: function(data) {
                        if (data.success == true) {
                            toastr.success(data.msg);
                            schedulelist = [];
                            getevents();
                            $("#detailmodal").modal('hide');
                            
                        } 
                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            }
        });
    });
    $(".btn_schedule_status_change").on('click', function(e){
        var form = $("#StatusForm");
        if (form[0].checkValidity() === false) {
            event.preventDefault()
            event.stopPropagation()
            form.addClass('was-validated');
            return;
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: `/admin/schedule-change-status`,
            data: {
                status: $("#mstatus").val(),
                schedule_id: $("#scheduleid").val()
            },
            type: 'POST',
            success: function(data) {
                if (data.success == true) {
                    schedulelist = [];
                    getevents();
                    toastr.success(data.msg);
                    $("#statusmodal").modal('hide');
                } 
            },
            error: function(data){
                console.log(data);
            }
       });
        
    });
    $(document).on('click','.btn_schedulestatus', function(e) {
        $("#mstatus").val($(this).data('status'));
        $('#mstatus').trigger('change');
        $("#scheduleid").val($(this).data('id'));
        $("#statusmodal").modal('show');
        $("#detailmodal").modal('hide');
    });
</script>
@endsection