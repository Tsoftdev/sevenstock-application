@extends('admin.layouts.app')
@section('title', '스케줄관리')
@section('css')
<link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/libs/fullcalendar/main.css') }}">
<link rel="stylesheet" href="{{ asset('assets/datetimepicker/datetimepicker.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/jquery-scrollbar/jquery.scrollbar.css') }}">
<style>
    .btn-schedule {
        background-color: #ffffff!important;
        border-color: #ced4da!important;
    }
    .schedule-time {
		border:none!important;
		font-size:1.2rem!important;
		background-color:#f3f5f7!important;
		
	}
    .page-title-schedule {
        padding-top: 0px;
    }
    .fc-event, .fc-event-dot {
        background-color: #ffffff!important;
        cursor: pointer!important;
    }
    a.fc-event {
        padding: 3px!important;
        border-radius: 3px!important;
        font-size: .6725rem!important;
        white-space: nowrap;
    }
    
    .fc a, .fc a:hover {
        cursor: pointer;
        color: #2b3a4a;
    }
    
    .fc-h-event {
        border: 1px solid #3788d8!important;
        background-color: #3788d8!important;
    }

    .dropdown-menu {
        min-width: 2rem!important;
    }

    .fc .fc-button-primary {
        color: #2b3a4a;
        border-color: #7a6fbe;
        background-color: transparent;
    }
    .fc-state-active, .fc-state-disabled, .fc-state-down {
        background-color: #7a6fbe!important;
        color: #fff!important;
        text-shadow: none;
    } 
    .bg-custom-color {
        background-color: #f1f1f1!important;
    }
    .schedule-scroll {
        height: 78vh;
    }
    .schedule-card {
        padding: .1rem .75rem !important;
    }
    .schedule-scroll .scroll-bar {
        background-color: #1f263d!important;
    }
    .schedule-date-time {
        padding: 1.375rem .5rem !important;
        background-color: #eee!important;
    }
    .schedule-bg-active {
        background-color: rgb(178 179 233 / 15%);
    }
    .pinned-title {
        font-family: Inter;
        font-style: normal;
        font-weight: 600;
        font-size: 16px;
        line-height: 24px;
        letter-spacing: 0.011em;
        color: #000000;
    }
    .adjustment {
        height: 12vh;
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
@endsection
@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-9">
            <div class="card mt-4 mt-xl-0 mb-0">
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div> <!-- end col -->
        <div class="col-md-3">
            <div class="mb-3" id="schedule_show_all">
                <div class="card mt-4 mt-xl-0 mb-0">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="page-title-custom">
                                    <h5><span id="stoday"></span></h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="justify-content-end d-flex">
                                    <!-- <a href="javascript:void(0);" class="btn btn-secondary btn-sm me-2 btn_today_data"> 전체보기</a> -->
                                    <a href="javascript:void(0);" class="btn btn-primary btn_scheduleadd_part"> 등록하기</a>
                                </div>
                            </div>
                        </div>
                        <hr class="flex-grow-1 mt-1 mb-3" style="height:1px;">
                        <div class="row">
                            <div id="show_all_list" class="schedule-scroll schedule-card"></div>
                            <input type="hidden" id="selected_date" />
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" id="memo_admin_id" />
            <div class="mb-3" id="schedule_add_part" style="display:none;">
                <div class="card mt-4 mt-xl-0 mb-0">
                    <div class="card-body">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="page-title-custom">
                                    <h4>스케줄등록</h4>
                                </div>
                            </div>
                            <div class="mb-3 mt-1 col-md-6">
                                <div class="justify-content-end d-flex">
                                    <a href="javascript:void(0);" class="btn btn-secondary btn-sm me-2 btn_schedulecancel"> 취소하기</a>
                                    <a href="javascript:void(0);" class="btn btn-primary btn-sm btn_scheduleadd"> 등록하기</a>
                                </div>
                            </div>
                        </div>
                        
                        <hr class="flex-grow-1 mt-1 mb-3" style="height:1px;">
                        <form class="form-horizontal needs-validation" id="ScheduleForm" novalidate>
                            <div class="row mt-2 mb-3">
                                <div class="col-sm-9">
                                    <input class="form-control" placeholder="Pleae enter a title" type="text" name="stitle" id="stitle" autocomplete="off" required>
                                    
                                </div>
                                <div class="col-sm-3">
                                    <div class="justify-content-end d-flex">
                                        <div class="dropdown d-inline-block">
                                            <a class="btn btn-schedule dropdown-toggle" style="color:#f91308;" href="javascript:void(0);" role="button" id="schdule-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="mdi mdi-checkbox-blank-circle font-size-13 me-2"></i>
                                                <i class="mdi mdi-chevron-down font-size-13"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="schedule-dropdown" style="">
                                                <a class="dropdown-item color_select" data-color="#f91308" href="javascript:void(0);"><i class="mdi mdi-checkbox-blank-circle font-size-13 me-2" style="color:#f91308;"></i> 내부미팅 </a>
                                                <a class="dropdown-item color_select" data-color="#f3d122" href="javascript:void(0);"><i class="mdi mdi-checkbox-blank-circle font-size-13 me-2" style="color:#f3d122;"></i> 외부미팅 - 법인 </a>
                                                <a class="dropdown-item color_select" data-color="#58db83" href="javascript:void(0);"><i class="mdi mdi-checkbox-blank-circle font-size-13 me-2" style="color:#58db83;"></i> 라운딩 </a>
                                                <a class="dropdown-item color_select" data-color="#0388f9" href="javascript:void(0);"><i class="mdi mdi-checkbox-blank-circle font-size-13 me-2" style="color:#0388f9;"></i> 외부일정 - 개인 </a>
                                                <a class="dropdown-item color_select" data-color="#3b4044" href="javascript:void(0);"><i class="mdi mdi-checkbox-blank-circle font-size-13 me-2" style="color:#3b4044;"></i> 취소 </a>
                                                <a class="dropdown-item color_select" data-color="#fbe806" href="javascript:void(0);"><i class="mdi mdi-checkbox-blank-circle font-size-13 me-2" style="color:#fbe806;"></i> 외부모임 </a>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" id="schedule_item_color" value="#f91308" />
                                
                            </div>
                            <div class="row pt-2">
                                <div class="col-md-4">
                                    <label class="form-label" for="start">기간 설정</label>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check form-switch" id="exact_switch">
                                        <input type="checkbox" class="form-check-input" id="exacttime" />
                                        <label class="form-check-label" for="exacttime">정확한 시간</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row pb-2 mb-3" id="sche_time">
                                
                                <div class="col-sm-12 mt-1" id="range_sche">
                                    <input type="text" class="form-control text-center input-daterange-timepicker schedule-date-time" id="start" name="start" style="font-size: 15px;">
                                </div>
                                <div class="col-sm-12 mt-1" id="exact_sche" style="display:none;">
                                    <input type="text" class="form-control text-center input-daterange-exact schedule-date-time" id="exstart" name="exstart" style="font-size: 18px;">
                                </div>
                            </div>
                            <input type="hidden" id="starttemp" />
                            <input type="hidden" id="endtemp" />
                            <input type="hidden" id="check_time_type" value="0" />
                            <input type="hidden" id="click_date" />
                            <div class="row pt-2 pb-2 mb-3" id="sche_all">
                                <div class="col-sm-5">
                                    <div class="form-group mt-1 mb-1">
                                        <input type="text" class="form-control text-center schedule-date-time" id="allstart" name="allstart" style="font-size: 15px;">
                                    </div>
                                </div>
                                <div class="col-sm-1" style="margin:auto;">
                                    <i class="fas fa-chevron-right" style="font-size:30px;"></i>
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-group mt-1 mb-1">
                                        <input type="text" class="form-control text-center schedule-date-time" id="allend" name="allend" style="font-size: 15px;">
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="allstarttemp" />
                            <input type="hidden" id="allendtemp" />
                            <div class="me-1 ms-1 mb-3">
                                <div class="row">
                                    <div class="col-sm-6 d-grid">
                                        <button class="btn btn-secondary border btn-block" id="btn_time" type="button"> 시간 </button>
                                    </div>
                                    <div class="col-sm-6 d-grid">
                                        <button class="btn btn-light border btn-block" id="btn_all_day" type="button"> 하루종일 </button>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-1">
                                    <i class="mdi mdi-account-multiple-plus" style="font-size:24px;"></i>
                                </div>
                                <div class="col-sm-11">
                                    <div class="justify-content-end d-flex">
                                        <select class="select2 form-control select2-multiple wd-100p" multiple="multiple" data-placeholder="고객을 선택해주세요"  id="usersearch" name="usersearch[]">
                                            @foreach($customers as $customer)
                                                <option value="{{$customer->id}}">{{$customer->name}}</option>
                                            @endforeach
                                        </select>	
                                    </div>					
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-sm-1">
                                    <i class="mdi mdi-note" style="font-size:25px;"></i>
                                </div>
                                <div class="col-sm-11">
                                    <div class="justify-content-end d-flex">
                                        <textarea class="form-control" type="text" rows="5" placeholder="메모를 입력하세요." id="schedulenote" name="schedulenote"></textarea>
                                    </div>
                                                                            
                                </div>
                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="mb-3" id="schedule_update_part" style="display:none;">
                <div class="card mt-4 mt-xl-0 mb-0">
                    <div class="card-body">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="page-title-custom">
                                    <h4>스케줄등록</h4>
                                </div>
                            </div>
                            <div class="mb-3 mt-1 col-md-6">
                                <div class="justify-content-end d-flex">
                                    <a href="javascript:void(0);" class="btn btn-secondary btn-sm me-2 btn_schedulecancel"> 취소하기</a>
                                    <a href="javascript:void(0);" class="btn btn-primary btn-sm btn_scheduleupdate"> 저장하기</a>
                                </div>
                            </div>
                        </div>
                        
                        <hr class="flex-grow-1 mt-1 mb-3" style="height:1px;">
                        <form class="form-horizontal needs-validation" id="UpScheduleForm" novalidate>
                            <input type="hidden" id="schedule_up" />
                            <div class="row mt-2 mb-3">
                                <div class="col-sm-9">
                                    <input class="form-control" placeholder="Pleae enter a title" type="text" name="ustitle" id="ustitle" autocomplete="off" required>
                                </div>
                                <div class="col-sm-3">
                                    <div class="justify-content-end d-flex">
                                        <div class="dropdown d-inline-block">
                                            <a class="btn btn-schedule dropdown-toggle" style="color:#f91308;" href="javascript:void(0);" role="button" id="uschdule-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="mdi mdi-checkbox-blank-circle font-size-13 me-2"></i>
                                                <i class="mdi mdi-chevron-down font-size-13"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="uschedule-dropdown" style="">
                                                <a class="dropdown-item ucolor_select" data-color="#f91308" href="javascript:void(0);"><i class="mdi mdi-checkbox-blank-circle font-size-13 me-2" style="color:#f91308;"></i> 내부미팅 </a>
                                                <a class="dropdown-item ucolor_select" data-color="#f3d122" href="javascript:void(0);"><i class="mdi mdi-checkbox-blank-circle font-size-13 me-2" style="color:#f3d122;"></i> 외부미팅 - 법인 </a>
                                                <a class="dropdown-item ucolor_select" data-color="#58db83" href="javascript:void(0);"><i class="mdi mdi-checkbox-blank-circle font-size-13 me-2" style="color:#58db83;"></i> 라운딩 </a>
                                                <a class="dropdown-item ucolor_select" data-color="#0388f9" href="javascript:void(0);"><i class="mdi mdi-checkbox-blank-circle font-size-13 me-2" style="color:#0388f9;"></i> 외부일정 - 개인 </a>
                                                <a class="dropdown-item ucolor_select" data-color="#3b4044" href="javascript:void(0);"><i class="mdi mdi-checkbox-blank-circle font-size-13 me-2" style="color:#3b4044;"></i> 취소 </a>
                                                <a class="dropdown-item ucolor_select" data-color="#fbe806" href="javascript:void(0);"><i class="mdi mdi-checkbox-blank-circle font-size-13 me-2" style="color:#fbe806;"></i> 외부모임 </a>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" id="uschedule_item_color" value="#7a6fbe" />
                                
                            </div>
                            <div class="row pt-2">
                                <div class="col-md-4">
                                    <label class="form-label" for="ustart">기간 설정</label>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check form-switch" id="uexact_switch">
                                        <input type="checkbox" class="form-check-input" id="uexacttime" />
                                        <label class="form-check-label" for="uexacttime">정확한 시간</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row p-1 mb-3" id="usche_time">
                                <div class="col-sm-12 mt-1" id="urange_sche">
                                    <input type="text" class="form-control text-center input-daterange-timepicker schedule-date-time" style="font-size: 15px;" id="ustart" name="ustart">
                                </div>
                                <div class="col-sm-12 mt-1" id="uexact_sche" style="display:none;">
                                    <input type="text" class="form-control text-center input-daterange-exact schedule-date-time" id="uexstart" style="font-size: 18px;" name="uexstart">
                                </div>
                            </div>
                            <input type="hidden" id="ustarttemp" />
                            <input type="hidden" id="uendtemp" />
                            <input type="hidden" id="ucheck_time_type" value="0" />
                            <div class="row p-2 mb-3" id="usche_all">
                                <div class="col-sm-5">
                                    <div class="form-group mt-1 mb-1">
                                        <input type="text" class="form-control text-center schedule-date-time" id="uallstart" name="uallstart" style="font-size: 15px;">
                                    </div>
                                </div>
                                <div class="col-sm-1" style="margin:auto;">
                                    <i class="fas fa-chevron-right" style="font-size:30px;"></i>
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-group mt-1 mb-1">
                                        <input type="text" class="form-control text-center schedule-date-time" id="uallend" name="uallend" style="font-size: 15px;" >
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="uallstarttemp" />
                            <input type="hidden" id="uallendtemp" />
                            <div class="me-1 ms-1 mb-3">
                                <div class="row">
                                    <div class="col-sm-6 d-grid">
                                        <button class="btn btn-secondary border btn-block" id="ubtn_time" type="button"> Time </button>
                                    </div>
                                    <div class="col-sm-6 d-grid">
                                        <button class="btn border btn-block" id="ubtn_all_day" type="button"> All day </button>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-1">
                                    <i class="mdi mdi-account-multiple-plus" style="font-size:24px;"></i>
                                </div>
                                <div class="col-sm-11">
                                    <div class="justify-content-end d-flex">
                                        <select class="select2 form-control select2-multiple wd-100p" multiple="multiple" data-placeholder="고객을 선택해주세요" id="uusersearch" name="uusersearch[]">
                                            <option value="">고객을 선택해주세요</option>
                                            @foreach($customers as $customer)
                                                <option value="{{$customer->id}}">{{$customer->name}}</option>
                                            @endforeach
                                        </select>	
                                    </div>					
                                </div>
                                
                            </div>
                            
                            <div class="row">
                                <div class="col-sm-1">
                                    <i class="mdi mdi-note" style="font-size:25px;"></i>
                                </div>
                                <div class="col-sm-11">
                                    <div class="justify-content-end d-flex">
                                        <textarea class="form-control" type="text" rows="5" placeholder="메모를 입력하세요." id="uschedulenote" name="uschedulenote"></textarea>
                                    </div>
                                                                            
                                </div>
                                
                            </div>
                        
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- <div class="mb-3">
                <div class="card mt-4 mt-xl-0 mb-0">
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
                            <div id="pinnedlist" class="schedule-scroll schedule-card"></div>
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
            </div> -->
        </div> 
    </div>
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
@stop
@section('javascript')
<script src="{{ asset('assets/libs/select2/js/select2.full.min.js') }}"></script>
<!-- plugin js -->
<script src="{{ asset('assets/libs/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('assets/datetimepicker/datetimepicker.js') }}"></script>
<script src="{{ asset('assets/libs/fullcalendar/main.js') }}"></script>
<script src="{{ asset('assets/libs/fullcalendar/locales-all.js') }}"></script>
<script src="{{ asset('assets/libs/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
<!-- Sweet Alerts js -->
<script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<script>
    $("body").toggleClass("vertical-collpsed");
    $(".schedule-scroll").scrollbar();
    var schedulelist = [];
    getevents();
    function getevents() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: `/admin/getschedule`,
            data: {},
            type: 'POST',

            success: function(data) {
                
                schedulelist.push.apply(schedulelist, data);
                calendar.refetchEvents();
            },
            error: function(data){
                console.log(data);
            }
        });
    }
    
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
    $('.input-daterange-timepicker').daterangepicker({
        timePicker:true,
        opens: 'left',
        locale: { 
            cancelLabel: '취소',
            applyLabel: '적용',
            format: 'YYYY.MM.DD hh:mm A',
            daysOfWeek: ['일', '월', '화', '수', '목', '금', '토'],
            monthNames: ['1 월', '2 월', '3 월', '4 월', '5 월', '6 월', '7 월', '8 월', '9 월', '10 월', '11 월', '12 월'],
         },
    });
    $('.input-daterange-exact').daterangepicker({
        timePicker:true,
        singleDatePicker: true,
        locale: { 
            cancelLabel: '취소',
            applyLabel: '적용',
            format: 'YYYY.MM.DD hh:mm A',
            daysOfWeek: ['일', '월', '화', '수', '목', '금', '토'],
            monthNames: ['1 월', '2 월', '3 월', '4 월', '5 월', '6 월', '7 월', '8 월', '9 월', '10 월', '11 월', '12 월'],
         },
    });
    $('#exstart').data('daterangepicker').setStartDate(moment().set('hour', 7).minutes(30));
    function currDate(date) {
        var currentd = new Date(date);
        var weekdays = new Array(7);
        weekdays[0] = "일";
        weekdays[1] = "월";
        weekdays[2] = "화";
        weekdays[3] = "수";
        weekdays[4] = "목";
        weekdays[5] = "금";
        weekdays[6] = "토";
        var r = weekdays[currentd.getDay()];
        return r;
    };
    $('#allstart').datepicker({
        changeMonth: true,
        changeYear: true,
        timePicker:true,
        dateFormat: 'yy.mm.dd',
        monthNames: [ "1월", "2월", "3월", "4월", "5월", "6월",
        "7월", "8월", "9월", "10월", "11월", "12월" ],
        monthNamesShort: [ "1월", "2월", "3월", "4월", "5월", "6월",
        "7월", "8월", "9월", "10월", "11월", "12월" ],
        dayNames: [ "일요일", "월요일", "화요일", "수요일", "목요일", "금요일", "토요일" ],
        dayNamesShort: [ "일", "월", "화", "수", "목", "금", "토" ],
        dayNamesMin: [ "일", "월", "화", "수", "목", "금", "토" ],
        onSelect: function(dateText, inst) {
            $("#allstart").val(dateText +' (' + currDate(dateText) + ')');
            $("#allstarttemp").val(dateText);
            var date2 = $('#allstart').datepicker('getDate');
            $('#allend').datepicker('option', 'minDate', date2);
            $("#allend").val(dateText +' (' + currDate(dateText) + ')');
        }

    });
    $('#allend').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy.mm.dd',
        monthNames: [ "1월", "2월", "3월", "4월", "5월", "6월",
        "7월", "8월", "9월", "10월", "11월", "12월" ],
        monthNamesShort: [ "1월", "2월", "3월", "4월", "5월", "6월",
        "7월", "8월", "9월", "10월", "11월", "12월" ],
        dayNames: [ "일요일", "월요일", "화요일", "수요일", "목요일", "금요일", "토요일" ],
        dayNamesShort: [ "일", "월", "화", "수", "목", "금", "토" ],
        dayNamesMin: [ "일", "월", "화", "수", "목", "금", "토" ],
        onSelect: function(dateText, inst) {
            $("#allend").val(dateText +' (' + currDate(dateText) + ')');
            $("#allendtemp").val(dateText);
            var dt1 = $('#allstart').datepicker('getDate');
            var dt2 = $('#allend').datepicker('getDate');
            //check to prevent a user from entering a date below date of dt1
            if (dt2 <= dt1) {
                var minDate = $('#allend').datepicker('option', 'minDate');
                $('#allend').datepicker('setDate', minDate);
            }
        }

    });
    $('#uallstart').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy.mm.dd',
        monthNames: [ "1월", "2월", "3월", "4월", "5월", "6월",
        "7월", "8월", "9월", "10월", "11월", "12월" ],
        monthNamesShort: [ "1월", "2월", "3월", "4월", "5월", "6월",
        "7월", "8월", "9월", "10월", "11월", "12월" ],
        dayNames: [ "일요일", "월요일", "화요일", "수요일", "목요일", "금요일", "토요일" ],
        dayNamesShort: [ "일", "월", "화", "수", "목", "금", "토" ],
        dayNamesMin: [ "일", "월", "화", "수", "목", "금", "토" ],
        onSelect: function(dateText, inst) {
            $("#uallstart").val(dateText +' (' + currDate(dateText) + ')');
            $("#uallstarttemp").val(dateText);
            var date2 = $('#uallstart').datepicker('getDate');
            $('#uallend').datepicker('option', 'minDate', date2);
            $("#uallend").val(dateText +' (' + currDate(dateText) + ')');
        }

    });
    $('#uallend').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy.mm.dd',
        monthNames: [ "1월", "2월", "3월", "4월", "5월", "6월",
        "7월", "8월", "9월", "10월", "11월", "12월" ],
        monthNamesShort: [ "1월", "2월", "3월", "4월", "5월", "6월",
        "7월", "8월", "9월", "10월", "11월", "12월" ],
        dayNames: [ "일요일", "월요일", "화요일", "수요일", "목요일", "금요일", "토요일" ],
        dayNamesShort: [ "일", "월", "화", "수", "목", "금", "토" ],
        dayNamesMin: [ "일", "월", "화", "수", "목", "금", "토" ],
        onSelect: function(dateText, inst) {
            $("#uallend").val(dateText +' (' + currDate(dateText) + ')');
            $("#uallendtemp").val(dateText);
            var dt1 = $('#uallstart').datepicker('getDate');
            var dt2 = $('#uallend').datepicker('getDate');
            //check to prevent a user from entering a date below date of dt1
            if (dt2 <= dt1) {
                var minDate = $('#uallend').datepicker('option', 'minDate');
                $('#uallend').datepicker('setDate', minDate);
            }
        }

    });
    
    $("#schedulestatusm").on('click', function(e){
        var form = $("#DetailForm");
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
                status: $("#msstatus").val(),
                schedule_id: $("#detailid").val()
            },
            type: 'POST',
            success: function(data) {
                if (data.success == true) {
                    schedulelist = [];
                    getevents();
                    toastr.success(data.msg);
                    $("#schedule_show_all").show();
                    $("#schedule_add_part").hide();
                    $("#schedule_update_part").hide();
                    $("#detailmodal").modal('hide');
                    if($("#selected_date").val() != "") {
                        $.ajax({
                            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                            url: `/admin/schedule-selectdate`,
                            data: {
                                select_date: $("#selected_date").val(),
                            },
                            type: 'POST',
                            success: function(data) {
                                if (data.success) {
                                    $('div#show_all_list').html(data.html);
                                } 
                            },
                            error: function(data){
                                console.log(data);
                            }
                        });
                    } else {
                        schedule_list();
                    }
                } 
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
                            if($("#click_date").val()) {
                                $.ajax({
                                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                                    url: `/admin/schedule-list`,
                                    data: {
                                        date: moment($("#click_date").val()).format("YYYY-MM-DD")
                                    },
                                    type: 'POST',
                                    success: function(data) {
                                        if (data.success) {
                                            $('div#show_all_list').html(data.html);
                                        } 
                                    },
                                    error: function(data){
                                        console.log(data);
                                    }
                                });
                            } else {
                                $.ajax({
                                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                                    url: `/admin/schedule-list`,
                                    data: {
                                        date: moment(today).format("YYYY-MM-DD")
                                    },
                                    type: 'POST',
                                    success: function(data) {
                                        if (data.success) {
                                            $('div#show_all_list').html(data.html);
                                        } 
                                    },
                                    error: function(data){
                                        console.log(data);
                                    }
                                });
                            }
                            

                        } 
                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            }
        });
    });


    var today = new Date();
	var dayname = currentDate();
    function currentDate() {
        var currentd = new Date();
        var weekdays = new Array(7);
        weekdays[0] = "일";
        weekdays[1] = "월";
        weekdays[2] = "화";
        weekdays[3] = "수";
        weekdays[4] = "목";
        weekdays[5] = "금";
        weekdays[6] = "토";
        var r = weekdays[currentd.getDay()];
        return r;
    };
    schedule_list();
    function schedule_list(){
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: `/admin/schedule-list`,
            data: {
                date: moment(today).format("YYYY-MM-DD")
            },
            type: 'POST',
            success: function(data) {
                if (data.success) {
                    $('div#show_all_list').html(data.html);
                } 
            },
            error: function(data){
                console.log(data);
            }
        });
    }
    function schedule_all_list(){
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: `/admin/schedule-all-list`,
            data: {},
            type: 'POST',
            success: function(data) {
                if (data.success) {
                    $('div#show_all_list').html(data.html);
                } 
            },
            error: function(data){
                console.log(data);
            }
        });
    }
    $(".btn_today_data").on('click', function(e){
        schedule_all_list();
    })
    $(".btn_scheduleadd_part").on('click', function(e){
        $("#stitle").val('');
        $("#exacttime").prop('checked', false);
        $("#schedulenote").val('');
        $("#usersearch").val('');
        $('#usersearch').trigger('change');
        $("#exact_sche").hide();
        $("#range_sche").show();
        $("#schedule_show_all").hide();
        $("#schedule_add_part").show();
    });
    $(".btn_schedulecancel").on('click', function(e){
        $("#schedule_show_all").show();
        $("#schedule_add_part").hide();
        $("#schedule_update_part").hide();
    });
    
    $(".select2").select2({width: '100%'});
    $(".select_status").select2({width: '100%' ,dropdownParent: $("#manage_info")});
    
    $("#sche_all").hide();
    
    var dd = String(today.getDate()).padStart(2, '0');
	var mm = String(today.getMonth() + 1).padStart(2, '0');

	$("#stoday").html(mm+ '월 ' + dd + "일");
	
    $("#btn_time").on('click', function(e){
        $("#btn_time").removeClass('btn-secondary');
        $("#btn_all_day").removeClass('btn-secondary');
        $("#btn_time").addClass('btn-secondary');
        $("#exact_switch").show();
        if($("#click_date").val() != "") {
            $('#start').data('daterangepicker').setStartDate(moment($("#click_date").val(), "YYYY.MM.DD").set('hour', 7).minutes(30));
            $('#start').data('daterangepicker').setEndDate(moment($("#click_date").val(), "YYYY.MM.DD").set('hour', 17).minutes(30));
        } else {
            $('#start').data('daterangepicker').setStartDate(moment().set('hour', 7).minutes(30));
            $('#start').data('daterangepicker').setEndDate(moment().set('hour', 17).minutes(30));
        }
        
        $("#sche_all").hide();
        $("#sche_time").show();
        $("#check_time_type").val(0);
    });

    $("#btn_all_day").on('click', function(e){
        $("#btn_time").removeClass('btn-secondary');
        $("#btn_all_day").removeClass('btn-secondary');
        $("#btn_all_day").removeClass('btn-light');
        $("#btn_all_day").addClass('btn-secondary');
        $("#exact_switch").hide();
        $("#starttime").val('');
        $("#endtime").val('');
        if($("#click_date").val() != "") {
            $("#allstart").val(moment($("#click_date").val(), "YYYY.MM.DD").format("YYYY.MM.DD") +' (' + currDate($("#click_date").val()) + ')');
            $("#allend").val(moment($("#click_date").val(), "YYYY.MM.DD").format("YYYY.MM.DD")  +' (' + currDate($("#click_date").val()) + ')');
            $("#allstarttemp").val(moment($("#click_date").val(), "YYYY.MM.DD").format("YYYY.MM.DD"));
            $("#allendtemp").val(moment($("#click_date").val(), "YYYY.MM.DD").format("YYYY.MM.DD"));
        } else {
            $("#allstart").val(moment(today).format("YYYY.MM.DD") +' (' + dayname + ')');
            $("#allend").val(moment(today).format("YYYY.MM.DD")  +' (' + dayname + ')');
            $("#allstarttemp").val(moment(today).format("YYYY.MM.DD"));
            $("#allendtemp").val(moment(today).format("YYYY.MM.DD"));
        }
        
        
        $("#sche_all").show();
        $("#sche_time").hide();
        $("#check_time_type").val(1);
    });

    $('#start').data('daterangepicker').setStartDate(moment().set('hour', 7).minutes(30));
    $('#start').data('daterangepicker').setEndDate(moment().set('hour', 17).minutes(30));
    function formatAMPM(date) {
        var hours = date.getHours();
        var minutes = date.getMinutes();
        var ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12;
        hours = hours ? hours : 12; // the hour '0' should be '12'
        minutes = minutes < 10 ? '0'+minutes : minutes;
        var strTime = hours + ':' + minutes + ' ' + ampm;
        return strTime;
    }
    var crrent_time = formatAMPM(new Date);

    var date = new Date()
    var d = date.getDate(),
        m = date.getMonth(),
        y = date.getFullYear()
    
    var calendarEl = document.getElementById('calendar');
    // var Draggable = FullCalendar.Draggable;
    var calendar = new FullCalendar.Calendar(calendarEl, {
        contentHeight: '80vh',
        expandRows: true,
        locale: 'ko',
        headerToolbar: {
            left: 'title',
            center: '',
            right: 'dayButton weekButton monthButton allButton prev next'
        },
        initialView: 'dayGridMonth',
        navLinks: true, 
        editable: true,
        selectable: true,
        nowIndicator: true,
        dayMaxEventRows: true,
        droppable: true,
        views: {
            dayGridMonth: {
                dayMaxEventRows: 4
            }
        },
        events: function (fetchInfo, successCallback, failureCallback) {
                successCallback(schedulelist);
            },
        customButtons: {
            allButton: {
                text:'모두',
                click:function(info){  
                    calendar.changeView('listYear');
                    var view = calendar.view;
                    //$("#head_date").html(view.title);
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
                    //$("#head_date").html(view.title);
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
                    //$("#head_date").html(view.title);
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
            dayButton: {
                text:'일',
                click:function(info){
                    calendar.changeView('listDay');
                    var view = calendar.view;
                    //$("#head_date").html(view.title);
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
        windowResize: function(info) {
            console.log('The calendar has adjusted to a window resize. Current view: ' + info.view.type);
        },  
          
        eventDrop: function(info) {
            if(info.event.extendedProps.time_type == "T") {
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    url: `/admin/scheduleupdate`,
                    data: {
                        schedule_id: info.event.id,
                        start: moment(info.event.start).format("YYYY-MM-DD"),
                        end: moment(info.event.end).format("YYYY-MM-DD"),
                        starttime: moment(info.event.start).format("HH:mm A"),
                        endtime: moment(info.event.end).format("HH:mm A"),
                        time_type: info.event.extendedProps.time_type
                    },
                    type: 'POST',
                    success: function(data) {
                            if (data.success == true) {
                                toastr.success(data.msg);
                                schedule_list();
                            } 
                        },
                    error: function(data){
                        console.log(data);
                    }
                });
            } else if (info.event.extendedProps.time_type == "A") {

                console.log(info.event.end)
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    url: `/admin/scheduleupdate`,
                    data: {
                        schedule_id: info.event.id,
                        start: moment(info.event.start).format("YYYY-MM-DD"),
                        end: info.event.end != null ? moment(info.event.end).subtract(1, "days").format("YYYY-MM-DD") : moment(info.event.start).format("YYYY-MM-DD"),
                        time_type: info.event.extendedProps.time_type
                    },
                    type: 'POST',
                    success: function(data) {
                            if (data.success == true) {
                                toastr.success(data.msg);
                                schedule_list();
                            } 
                        },
                    error: function(data){
                        console.log(data);
                    }
                });
            } else if (info.event.extendedProps.time_type == "E") {
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    url: `/admin/scheduleupdate`,
                    data: {
                        schedule_id: info.event.id,
                        start: moment(info.event.start).format("YYYY-MM-DD"),
                        starttime: moment(info.event.start).format("HH:mm:ss"),
                        time_type: info.event.extendedProps.time_type
                    },
                    type: 'POST',
                    success: function(data) {
                            if (data.success == true) {
                                toastr.success(data.msg);
                                schedule_list();
                            } 
                        },
                    error: function(data){
                        console.log(data);
                    }
                });
            }
            

        },  
        eventResize: function(info) {
            console.log(info.event.start, info.event.end);
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: `/admin/scheduleupdate`,
                data: {
                    schedule_id: info.event.id,
                    start: moment(info.event.start).format("YYYY-MM-DD"),
                    end: moment(info.event.end).subtract(1, "days").format("YYYY-MM-DD"),
                    time_type: info.event.extendedProps.time_type
                },
                type: 'POST',
                success: function(data) {
                        if (data.success == true) {
                            toastr.success(data.msg);
                            schedule_list();
                        } 
                    },
                error: function(data){
                    console.log(data);
                }
            });

        },
        
        eventDidMount: function (info) {

            var title = info.view.title;
            // $("#head_date").html(title);
            if (info.view.type === 'dayGridMonth') {
                $(".fc-dayButton-button").hide();
                $(".fc-weekButton-button").hide();
                $(".fc-monthButton-button").hide();
                $(".fc-allButton-button").hide();
                $(".fc-scrollgrid-sync-table tr").addClass("adjustment");
                // $(info.el).find(".fc-event-title").attr("data-id", info.event.id);
                $(info.el).addClass("detail_data").attr("data-id", info.event.id);
                if (info.event.allDay) {
                    $(info.el).attr('style', 'background-color:' + info.backgroundColor + '!important;' + 'border-color:' + info.borderColor + '!important;');
                }
                else {
                    
                    if(info.event.extendedProps.time_type == "T") {
                        $(info.el).attr('style', 'border: 1px solid ' + info.borderColor + '!important;');
                    } else if (info.event.extendedProps.time_type == "E") {
                        $(info.el).attr('style', 'border: 1px solid ' + info.borderColor + '!important;');
                        // var removebtn = $("<button/>")
                        //     .addClass("btn-close schedule__del_btn").attr('style', 'font-size: 7px').attr("data-id", info.event.id);
                        // $(info.el).append(removebtn);
                    }
                }
            }
            else {
                $(info.el).find(".fc-list-event-time").addClass("detail_data").attr("data-id", info.event.id);
                $(info.el).find(".fc-list-event-title").addClass("detail_data").attr("data-id", info.event.id);
                $(".fc-dayButton-button").hide();
                $(".fc-weekButton-button").show();
                $(".fc-monthButton-button").show();
                $(".fc-allButton-button").show();
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
                if(info.event.extendedProps.customer.length > 0) {
                    var usericon = $("<button/>").addClass("btn waves-effect btn_list_user").attr("data-id", info.event.id).append($("<i/>").addClass("far fa-user"));
                }
                if(info.event.extendedProps.note) {
                    var chaticon = $("<button/>").addClass("btn waves-effect btn_list_chat").attr("data-id", info.event.id).append($("<i/>").addClass("fab fa-rocketchat"));
                }
                
                // var removebtn = $("<button/>")
                //     .addClass("btn-close schedule__del_btn").attr('style', 'font-size: 7px').attr("data-id", info.event.id);
                var custombtn = $("<td/>")
                    .addClass("fc-list-event text-end").append(usericon).append(chaticon);
                $(info.el).append(custombtn);
            }
            // $(info.el).find(".schedule__del_btn").on('click', function() {
            //     var sid = $(this).data('id');
            //     var event = calendar.getEventById(sid);
            //     event.remove();
            //     $.ajaxSetup({
            //         headers: {
            //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //         }
            //     });
            //     $.ajax({
            //         url: `/admin/scheduledelete`,
            //         data: {
            //             schedule_id: sid
            //         },
            //         type: 'POST',
            //         success: function(data) {
            //             if (data.success == true) {
            //                 toastr.success(data.msg);
            //                 schedule_list();
            //             } 
            //         },
            //         error: function(data){
            //             console.log(data);
            //         }
            //     });

            // });
            // $(info.el).on('click', function(e){
            //     $(info.el).popModal({
            //         placement : 'bottomLeft',
            //         showCloseBut : true,
            //         onDocumentClickClose : true,
            //         onDocumentClickClosePrevent : 'el',
            //         overflowContent : true,
            //         inline : true,
            //         asMenu : false,
            //         size : '',
            //         onOkBut : function(event, el) {},
            //         onCancelBut : function(event, el) {},
            //         onLoad : function(el) {},
            //         onClose : function(el) {},
            //         html: function () {
            //             var dataTitle="<div class='page-title-custom'> " + info.event.title + "</div>";
            //             if(info.event.allDay) {
            //                 var dateHtml="<div> 날짜:  " + moment(info.event.start).format("YYYY.MM.DD") + ' - ' + moment(info.event.end).format("YYYY.MM.DD") + '</div>';
            //                 var infoHtml="<div> 편집자: " + info.event.extendedProps.createdBy +'</div>';
                            
            //             } else {
            //                 if (info.event.extendedProps.time_type == "T") {
            //                     var dateHtml="<div> 시간:  " + moment(info.event.start).format("HH:mm A") + ' - ' + moment(info.event.end).format("HH:mm A") + '</div>';
            //                     var infoHtml="<div> 편집자: " + info.event.extendedProps.createdBy +'</div>';
            //                 } else if (info.event.extendedProps.time_type == "E") {
            //                     var dateHtml="<div> 시간:  " + moment(info.event.start).format("HH:mm A")  + '</div>';
            //                     var infoHtml="<div> 편집자: " + info.event.extendedProps.createdBy +'</div>';
            //                 }
                            
            //             }
            //             var popModalHtml = dataTitle + dateHtml + infoHtml;
            //             return popModalHtml;
            //         }
            //     });
            // })
            // $(info.el).popModal({
            //     title: function () {
            //         return info.event.title;
            //     },
            //     placement: 'top',
            //     html:true,
            //     trigger: 'click',
            //     content: function () {

            //         if(info.event.allDay) {
            //             var dateHtml="<div> 날짜:  " + moment(info.event.start).format("YYYY.MM.DD") + ' - ' + moment(info.event.end).format("YYYY.MM.DD") + '</div>';
            //             var infoHtml="<div> 편집자: " + info.event.extendedProps.createdBy +'</div>';
                        
            //         } else {
            //             if (info.event.extendedProps.time_type == "T") {
            //                 var dateHtml="<div> 시간:  " + moment(info.event.start).format("HH:mm A") + ' - ' + moment(info.event.end).format("HH:mm A") + '</div>';
            //                 var infoHtml="<div> 편집자: " + info.event.extendedProps.createdBy +'</div>';
            //             } else if (info.event.extendedProps.time_type == "E") {
            //                 var dateHtml="<div> 시간:  " + moment(info.event.start).format("HH:mm A")  + '</div>';
            //                 var infoHtml="<div> 편집자: " + info.event.extendedProps.createdBy +'</div>';
            //             }
                        
            //         }
                    
            //         popoverHtml = dateHtml+infoHtml;
            //         return popoverHtml; 
            //     },
            //     container: 'body'
            // }).popover();
        },
        viewDidMount: function(info) {
            if (info.view.type !== 'dayGridMonth') {
                
                var tableHeader = $(".fc-list-table th");
                var listEvents = $('tr.fc-list-event');
                var maxCol = 0;
                var arrayLength = listEvents.length;
                for (var i = 0; i < arrayLength; i++) {
                    maxCol = Math.max(maxCol, listEvents[i].children.length);
                }
                tableHeader.attr("colspan", maxCol);
                $(".fc-dayButton-button").hide();
                $(".fc-weekButton-button").show();
                $(".fc-monthButton-button").show();
                $(".fc-allButton-button").show();
            }
        },
        dateClick: function(info) {

            $("#schedule_add_part").hide();
            $("#schedule_update_part").hide();
            $("#schedule_show_all").show();
            $("#pinnedlist").show();
            $("#click_date").val(moment(info.date).format("YYYY.MM.DD"));
            $('#start').data('daterangepicker').setStartDate(moment(info.date).set('hour', 7).minutes(30).format("YYYY.MM.DD hh:mm A"));
            $('#start').data('daterangepicker').setEndDate(moment(info.date).set('hour', 17).minutes(30).format("YYYY.MM.DD hh:mm A"));
            if($("#exacttime").prop("checked")) {
                $('#exstart').data('daterangepicker').setStartDate(moment($("#click_date").val(), "YYYY.MM.DD").set('hour', 7).minutes(30));
                $('#exstart').data('daterangepicker').setEndDate(moment($("#click_date").val(), "YYYY.MM.DD").set('hour', 7).minutes(30));
            }
            $("#allstart").val(moment(info.date, "YYYY.MM.DD").format("YYYY.MM.DD") +' (' + currDate(info.date) + ')');
            $("#allend").val(moment(info.date, "YYYY.MM.DD").format("YYYY.MM.DD")  +' (' + currDate(info.date) + ')');
            $("#allstarttemp").val(moment(info.date, "YYYY.MM.DD").format("YYYY.MM.DD"));
            $("#allendtemp").val(moment(info.date, "YYYY.MM.DD").format("YYYY.MM.DD"));

            $("#selected_date").val(info.dateStr);
            var current_change = (info.dateStr).split("-")[1] + "월 " + (info.dateStr).split("-")[2] + "일";
            $("#stoday").html(current_change);
            if(moment(info.date).format("YYYY.MM.DD") == moment(calendar.getDate()).format("YYYY.MM.DD")) {
                $(".fc-today-button").removeClass('fc-button-active');
                $(".fc-today-button").addClass('fc-button-active');
            } else {
                $(".fc-today-button").removeClass('fc-button-active');
            }
            
            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: `/admin/schedule-selectdate`,
                data: {
                    select_date: info.dateStr,
                },
                type: 'POST',
                success: function(data) {
                    if (data.success) {
                        $('div#show_all_list').html(data.html);
                    } 
                },
                error: function(data){
                    console.log(data);
                }
            });
            // $.ajax({
            //     headers: {
            //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //     },
            //     url: `/admin/pinned-list`,
            //     data: {
            //         date: info.dateStr,
            //     },
            //     type: 'POST',
            //     success: function(data) {
            //         if (data.success) {
                        
            //             $("#pinnedlist").html(data.html);
            //         } 
            //     },
            //     error: function(data){
            //         console.log(data);
            //     }
            // });
            $(".fc-scrollgrid-sync-table").find("td").each(function() {
                $(this).removeClass("schedule-bg-active");
                
            });
            $(info.dayEl).addClass("schedule-bg-active");
            
        },
        drop: function(info) {
            
        }
        
    });

    calendar.render();
    calendar.setOption('duration', { days: 1 });
    //$("#head_date").html(calendar.view.title);
    addButtons();
    addToday();

    bindButtonActions();
    function addButtons() {
        // create buttons
        var month = $("<button/>")
            .addClass("fc-dayGridMonth-button fc-button fc-button-primary fc-state-active me-2")
            .text("월");

        var listweek = $("<button/>")
            .addClass("fc-listWeek-button fc-button")
            .text("일정목록");
        var section = $("<span/>").addClass("p-3 bg-custom-color border border-light rounded-3").append(month).append(listweek);
        $(".fc-weekButton-button").before(section);
    }
    $(".fc-toolbar-title").css('font-size', '21px');
    function addToday() {
        var todaybtn = $("<button/>")
            .addClass("ms-2 fc-today-button fc-button fc-button-primary").css('font-size', '14px')
            .text("오늘");
        $(".fc-toolbar-title").append(todaybtn);
    }
    $(".fc-today-button").on('click', function(e) {
        
        $(".fc-today-button").removeClass('fc-button-active');
        $(".fc-today-button").addClass('fc-button-active');
        calendar.today();
        $(".fc-scrollgrid-sync-table").find("td").each(function() {
            $(this).removeClass("schedule-bg-active");
        });
        var t_change = (moment(calendar.getDate()).format("YYYY.MM.DD")).split(".")[1] + "월 " + (moment(calendar.getDate()).format("YYYY.MM.DD")).split(".")[2] + "일";
        $("#stoday").html(t_change);
        if(calendar.view.type != "dayGridMonth") {
            $(".fc-dayButton-button").click();
        }
        
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: `/admin/schedule-selectdate`,
            data: {
                select_date: moment(calendar.getDate()).format("YYYY-MM-DD"),
            },
            type: 'POST',
            success: function(data) {
                if (data.success) {
                    $('div#show_all_list').html(data.html);
                } 
            },
            error: function(data){
                console.log(data);
            }
        });
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `/admin/pinned-list`,
            data: {
                date: moment(calendar.getDate()).format("YYYY-MM-DD"),
            },
            type: 'POST',
            success: function(data) {
                if (data.success) {
                    
                    $("#pinnedlist").html(data.html);
                } 
            },
            error: function(data){
                console.log(data);
            }
        });
    });

    function bindButtonActions(){
        $(".fc-dayGridMonth-button").on('click', function() {
            // $(".fc-weekButton-button").hide();
            // $(".fc-monthButton-button").hide();
            // $(".fc-allButton-button").hide();
            if ($(this).hasClass("fc-state-active")) {
            } else {
                $(this).addClass("fc-state-active");
                if($(this).hasClass("fc-button-primary")){} 
                else {
                    $(this).addClass("fc-button-primary");
                }
            }
            $(".fc-listWeek-button").removeClass("fc-state-active");
            $(".fc-listWeek-button").removeClass("fc-button-primary");
            var view = "dayGridMonth";
            calendar.changeView(view);
            var view = calendar.view;
            // $("#head_date").html(view.title);
        });
        $(".fc-listWeek-button").on('click', function() {
            $(".fc-weekButton-button").addClass('fc-button-active');
            $(".fc-monthButton-button").removeClass('fc-button-active');
            $(".fc-allButton-button").removeClass('fc-button-active');
            if ($(this).hasClass("fc-state-active")) {  
            } else {
                $(this).addClass('fc-state-active');
                if($(this).hasClass("fc-button-primary")){} 
                else {
                    $(this).addClass("fc-button-primary");
                }
            }
            $(".fc-dayGridMonth-button").removeClass("fc-state-active");
            $(".fc-dayGridMonth-button").removeClass("fc-button-primary");
            view = "listWeek";
            calendar.changeView(view);
            var view = calendar.view;
            // $("#head_date").html(view.title);
        });
    }
    $(".fc-dayButton-button").hide();
    $(".fc-weekButton-button").hide();
    $(".fc-monthButton-button").hide();
    $(".fc-allButton-button").hide();
    $(".fc-weekButton-button").on('click', function(e){
        $(".fc-weekButton-button").removeClass('fc-button-active');
        $(".fc-weekButton-button").addClass('fc-button-active');
        $(".fc-monthButton-button").removeClass('fc-button-active');
        $(".fc-allButton-button").removeClass('fc-button-active');
        $(".fc-today-button").removeClass('fc-button-active');
    });
    $(".fc-monthButton-button").on('click', function(e){
        $(".fc-monthButton-button").removeClass('fc-button-active');
        $(".fc-weekButton-button").removeClass('fc-button-active');
        $(".fc-monthButton-button").addClass('fc-button-active');
        $(".fc-allButton-button").removeClass('fc-button-active');
        $(".fc-today-button").removeClass('fc-button-active');
    });
    $(".fc-allButton-button").on('click', function(e){
        $(".fc-allButton-button").removeClass('fc-button-active');
        $(".fc-weekButton-button").removeClass('fc-button-active');
        $(".fc-monthButton-button").removeClass('fc-button-active');
        $(".fc-allButton-button").addClass('fc-button-active');
        $(".fc-today-button").removeClass('fc-button-active');
    });

    // $('.fc-prev-button span').click(function(){
    //     //calendar.refetchEvents();
    //     console.log(calendar.view.title)
    //     //$("#head_date").html(calendar.view.title);
    // });

    // $('.fc-next-button span').click(function(){
    //     $("#head_date").html(calendar.view.title);
    // });
    $(".color_select").on("click", function(e) {
        $('.btn-schedule').removeClass('text-primary');
        $('.btn-schedule').css({'color': $(this).data('color'), 'border-color': $(this).data('color')});
        $("#schedule_item_color").val($(this).data('color'));
    });
    $('.timepicker').timepicker({
        showInputs: false
    });
    $(".btn_scheduleadd").on('click', function(e){
        var form = $("#ScheduleForm");
        if (form[0].checkValidity() === false) {
            event.preventDefault()
            event.stopPropagation()
            form.addClass('was-validated');
            return;
        } 
        if($("#check_time_type").val() == "1") {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: `/admin/scheduleadd`,
                data: {
                    'title': $('#stitle').val(),
                    'startdate': $("#allstarttemp").val(),
                    'enddate': $("#allendtemp").val(),
                    'starttime': $("#starttime").val(),
                    'endtime': $("#endtime").val(),
                    'backgroundColor': $("#schedule_item_color").val(),
                    'borderColor': $("#schedule_item_color").val(),
                    'customer': $("#usersearch").val(),
                    'note': $("#schedulenote").val(),
                    'type': $("#check_time_type").val()
                },
                type: 'POST',
                success: function(data) {
                    if (data.success == true) {
                        toastr.success(data.msg);
                        schedulelist = [];
                        getevents();

                        $("#schedule_show_all").show();
                        $("#schedule_add_part").hide();
                        $("#schedule_update_part").hide();
                        if($("#selected_date").val() != "") {
                            $.ajax({
                                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                                url: `/admin/schedule-selectdate`,
                                data: {
                                    select_date: $("#selected_date").val(),
                                },
                                type: 'POST',
                                success: function(data) {
                                    if (data.success) {
                                        $('div#show_all_list').html(data.html);
                                    } 
                                },
                                error: function(data){
                                    console.log(data);
                                }
                            });
                        } else {
                            schedule_list();
                        }

                    } 
                },
                error: function(data){
                    console.log(data);
                }
            });
        } else if($("#check_time_type").val() == "0") {
            if($("#exacttime").prop("checked")) {
                if($("#click_date").val() != "") {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: `/admin/scheduleadd`,
                        data: {
                            'title': $('#stitle').val(),
                            'startdate': $('input#exstart').data('daterangepicker').startDate.format("YYYY-MM-DD"),
                            'enddate': "",
                            'starttime': $('input#exstart').data('daterangepicker').startDate.format('hh:mm A'),
                            'endtime': "",
                            'backgroundColor': $("#schedule_item_color").val(),
                            'borderColor': $("#schedule_item_color").val(),
                            'customer': $("#usersearch").val(),
                            'note': $("#schedulenote").val(),
                            'type': $("#check_time_type").val()
                        },
                        type: 'POST',
                        success: function(data) {
                            if (data.success == true) {
                                toastr.success(data.msg);
                                schedulelist = [];
                                getevents();

                                $("#schedule_show_all").show();
                                $("#schedule_add_part").hide();
                                $("#schedule_update_part").hide();
                                if($("#selected_date").val() != "") {
                                    $.ajax({
                                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                                        url: `/admin/schedule-selectdate`,
                                        data: {
                                            select_date: $("#selected_date").val(),
                                        },
                                        type: 'POST',
                                        success: function(data) {
                                            if (data.success) {
                                                $('div#show_all_list').html(data.html);
                                            } 
                                        },
                                        error: function(data){
                                            console.log(data);
                                        }
                                    });
                                } else {
                                    schedule_list();
                                }
                                

                            } 
                        },
                        error: function(data){
                            console.log(data);
                        }
                    });

                } else {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: `/admin/scheduleadd`,
                        data: {
                            'title': $('#stitle').val(),
                            'startdate': $('input#exstart').data('daterangepicker').startDate.format('YYYY.MM.DD'),
                            'enddate': "",
                            'starttime': $('input#exstart').data('daterangepicker').startDate.format('hh:mm A'),
                            'endtime': "",
                            'backgroundColor': $("#schedule_item_color").val(),
                            'borderColor': $("#schedule_item_color").val(),
                            'customer': $("#usersearch").val(),
                            'note': $("#schedulenote").val(),
                            'type': $("#check_time_type").val()
                        },
                        type: 'POST',
                        success: function(data) {
                            if (data.success == true) {
                                toastr.success(data.msg);
                                schedulelist = [];
                                getevents();

                                $("#schedule_show_all").show();
                                $("#schedule_add_part").hide();
                                $("#schedule_update_part").hide();
                                if($("#selected_date").val() != "") {
                                    $.ajax({
                                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                                        url: `/admin/schedule-selectdate`,
                                        data: {
                                            select_date: $("#selected_date").val(),
                                        },
                                        type: 'POST',
                                        success: function(data) {
                                            if (data.success) {
                                                $('div#show_all_list').html(data.html);
                                            } 
                                        },
                                        error: function(data){
                                            console.log(data);
                                        }
                                    });
                                } else {
                                    schedule_list();
                                }
                                

                            } 
                        },
                        error: function(data){
                            console.log(data);
                        }
                    });
                }
                
            } else {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: `/admin/scheduleadd`,
                    data: {
                        'title': $('#stitle').val(),
                        'startdate': $('input#start').data('daterangepicker').startDate.format('YYYY.MM.DD'),
                        'enddate': $('input#start').data('daterangepicker').endDate.format('YYYY.MM.DD'),
                        'starttime': $('input#start').data('daterangepicker').startDate.format('hh:mm A'),
                        'endtime': $('input#start').data('daterangepicker').endDate.format('hh:mm A'),
                        'backgroundColor': $("#schedule_item_color").val(),
                        'borderColor': $("#schedule_item_color").val(),
                        'customer': $("#usersearch").val(),
                        'note': $("#schedulenote").val(),
                        'type': $("#check_time_type").val()
                    },
                    type: 'POST',
                    success: function(data) {
                        if (data.success == true) {
                            toastr.success(data.msg);
                            schedulelist = [];
                            getevents();

                            $("#schedule_show_all").show();
                            $("#schedule_add_part").hide();
                            $("#schedule_update_part").hide();
                            if($("#selected_date").val() != "") {
                                $.ajax({
                                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                                    url: `/admin/schedule-selectdate`,
                                    data: {
                                        select_date: $("#selected_date").val(),
                                    },
                                    type: 'POST',
                                    success: function(data) {
                                        if (data.success) {
                                            $('div#show_all_list').html(data.html);
                                        } 
                                    },
                                    error: function(data){
                                        console.log(data);
                                    }
                                });
                            } else {
                                schedule_list();
                            }
                            

                        } 
                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            }
            
        }
        
    });
    $(document).on('click','.fc-daygrid-day-number', function(e){
        console.log("-d--d--")
        $(".fc-dayGridMonth-button").removeClass('fc-state-active');
        $(".fc-dayGridMonth-button").removeClass('fc-button-primary');
        $(".fc-listWeek-button").addClass('fc-state-active fc-button-primary');
    })
    $(document).on('click', '.btn_schedule_delete', function(e){
        var sid = $(this).data('id');
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
                            if($("#click_date").val()) {
                                $.ajax({
                                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                                    url: `/admin/schedule-list`,
                                    data: {
                                        date: moment($("#click_date").val()).format("YYYY-MM-DD")
                                    },
                                    type: 'POST',
                                    success: function(data) {
                                        if (data.success) {
                                            $('div#show_all_list').html(data.html);
                                        } 
                                    },
                                    error: function(data){
                                        console.log(data);
                                    }
                                });
                            } else {
                                $.ajax({
                                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                                    url: `/admin/schedule-list`,
                                    data: {
                                        date: moment(today).format("YYYY-MM-DD")
                                    },
                                    type: 'POST',
                                    success: function(data) {
                                        if (data.success) {
                                            $('div#show_all_list').html(data.html);
                                        } 
                                    },
                                    error: function(data){
                                        console.log(data);
                                    }
                                });
                            }
                            

                        } 
                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            }
        });
        
    });
    // $(".fc-month-button").on('click', function(e){
    //     $(".fc-listMonth-button").click();
    // })
    $(document).on('click','.btn_schedulestatus', function(e) {
        $("#mstatus").val($(this).data('status'));
        $('#mstatus').trigger('change');
        $("#scheduleid").val($(this).data('id'));
        $("#statusmodal").modal('show');
        $("#detailmodal").modal('hide');
    });
    //$("#detailmodal").on('hidden.bs.modal', () => $("#statusmodal").modal('show'));
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
                    $("#schedule_show_all").show();
                    $("#schedule_add_part").hide();
                    $("#schedule_update_part").hide();
                    $("#statusmodal").modal('hide');
                    if($("#selected_date").val() != "") {
                        $.ajax({
                            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                            url: `/admin/schedule-selectdate`,
                            data: {
                                select_date: $("#selected_date").val(),
                            },
                            type: 'POST',
                            success: function(data) {
                                if (data.success) {
                                    $('div#show_all_list').html(data.html);
                                } 
                            },
                            error: function(data){
                                console.log(data);
                            }
                        });
                    } else {
                        schedule_list();
                    }
                    
                    
                } 
            },
            error: function(data){
                console.log(data);
            }
       });
        
    });
    
    $(document).on('click', '.btn_today_edit', function(e) {
        $("#schedule_add_part").hide();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `/admin/schedule-getitem`,
            data: {
                'schedule_id': $(this).data('id'),
            },
            type: 'POST',
            success: function(data) {
                $("#schedule_up").val(data.id);
                $("#ustitle").val(data.title);
                $('.btn-schedule').removeClass('text-primary');
                $('.btn-schedule').css({'color': data.backgroundColor, 'border-color': data.backgroundColor});
                $("#uschedule_item_color").val(data.backgroundColor);
                if (data.type == "A") {
                    $("#usche_all").show();
                    $("#usche_time").hide();
                    $("#uexact_switch").hide();
                    $("#uallstart").val(data.start + ' (' + currDate(data.start) + ')');
                    $("#uallstarttemp").val(data.start);
                    $("#uallendtemp").val(data.end);
                    $("#uallend").val(data.end + ' (' + currDate(data.end) + ')');
                    $("#ucheck_time_type").val(1);
                    $("#ubtn_all_day").removeClass('btn-secondary');
                    $("#ubtn_time").removeClass('btn-secondary');
                    $("#ubtn_all_day").addClass('btn-secondary');
                    $("#ucheck_time_type").val(1);
                    
                } else if(data.type == "T") {
                    $('#ustart').data('daterangepicker').setStartDate(moment(data.start + " " + data.starttime, "YYYY.MM.DD hh:mm A").format("YYYY.MM.DD hh:mm A"));
                    $('#ustart').data('daterangepicker').setEndDate(moment(data.end + " " + data.endtime, "YYYY.MM.DD hh:mm A").format("YYYY.MM.DD hh:mm A"));
                    $("#uexacttime").prop('checked', false);
                    $("#uexact_switch").show();
                    $("#usche_all").hide();
                    $("#usche_time").show();
                    $("#uexact_sche").hide();
                    $("#urange_sche").show();
                    $("#ubtn_time").removeClass('btn-secondary');
                    $("#ubtn_time").addClass('btn-secondary');
                    $("#ubtn_all_day").removeClass('btn-secondary');
                    $("#ucheck_time_type").val(0);
                } else if(data.type == "E") {
                    $('#uexstart').data('daterangepicker').setStartDate(moment(data.start + " " + data.starttime, "YYYY.MM.DD hh:mm A").format("YYYY.MM.DD hh:mm A"));
                    $('#uexstart').data('daterangepicker').setEndDate(moment(data.start + " " + data.starttime, "YYYY.MM.DD hh:mm A").format("YYYY.MM.DD hh:mm A"));
                    $("#uexacttime").prop('checked', true);
                    $("#uexact_switch").show();
                    $("#ubtn_time").removeClass('btn-secondary');
                    $("#ubtn_time").addClass('btn-secondary');
                    $("#ubtn_all_day").removeClass('btn-secondary');
                    $("#usche_time").show();
                    $("#usche_all").hide();
                    $("#urange_sche").hide();
                    $("#uexact_sche").show();
                    $("#ucheck_time_type").val(0);
                    
                }
                $("#uusersearch").val(data.customer);
                $('#uusersearch').trigger('change');
                $("#uschedulenote").val(data.note);
                
                $("#schedule_show_all").hide();
                $("#schedule_update_part").show();

            },
            error: function(data){
                console.log(data);
            }
        });
       
       

    });
    $(".ucolor_select").on("click", function(e) {
        $('.btn-schedule').removeClass('text-primary');
        $('.btn-schedule').css({'color': $(this).data('color'), 'border-color': $(this).data('color')});
        $("#uschedule_item_color").val($(this).data('color'));
    });
    $("#ubtn_time").on('click', function(e){
        if($("#click_date").val() != "") {
            $('input#ustart').data('daterangepicker').setStartDate(moment($("#click_date").val(), "YYYY.MM.DD").set('hour', 7).minutes(30));
            $('input#ustart').data('daterangepicker').setEndDate(moment($("#click_date").val(), "YYYY.MM.DD").set('hour', 17).minutes(30));
        } else {
            $('input#ustart').data('daterangepicker').setStartDate(moment(today, "YYYY.MM.DD").set('hour', 7).minutes(30));
            $('input#ustart').data('daterangepicker').setEndDate(moment(today, "YYYY.MM.DD").set('hour', 17).minutes(30));
        }
        
        $("#uexacttime").prop('checked', false);
        $("#usche_all").hide();
        $("#usche_time").show();
        $("#uexact_switch").show();
        $("#ucheck_time_type").val(0);
        $("#ubtn_all_day").removeClass('btn-secondary');
        $("#ubtn_time").removeClass('btn-secondary');
        $("#ubtn_time").addClass('btn-secondary');
    });

    $("#ubtn_all_day").on('click', function(e){
        $("#ustarttime").val('');
        $("#uendtime").val('');
        if($("#click_date").val() != "") {
            $("#uallstart").val(moment($("#click_date").val()).format("YYYY.MM.DD") +' (' + dayname + ')');
            $("#uallend").val(moment($("#click_date").val()).format("YYYY.MM.DD")  +' (' + dayname + ')');
            $("#uallstarttemp").val(moment($("#click_date").val()).format("YYYY.MM.DD"));
            $("#uallendtemp").val(moment($("#click_date").val()).format("YYYY.MM.DD"));
        } else {
            $("#uallstart").val(moment(today).format("YYYY.MM.DD") +' (' + dayname + ')');
            $("#uallend").val(moment(today).format("YYYY.MM.DD")  +' (' + dayname + ')');
            $("#uallstarttemp").val(moment(today).format("YYYY.MM.DD"));
            $("#uallendtemp").val(moment(today).format("YYYY.MM.DD"));
        }
        
        $("#usche_all").show();
        $("#usche_time").hide();
        $("#uexact_switch").hide();
        $("#ucheck_time_type").val(1);
        $("#ubtn_all_day").removeClass('btn-secondary');
        $("#ubtn_time").removeClass('btn-secondary');
        $("#ubtn_all_day").addClass('btn-secondary');
    });
    $(".btn_scheduleupdate").on('click', function(e){
        var form = $("#UpScheduleForm");
        if (form[0].checkValidity() === false) {
            event.preventDefault()
            event.stopPropagation()
            form.addClass('was-validated');
            return;
        } 
        
        if ($("#ucheck_time_type").val() == 0) {
            if($("#uexacttime").prop("checked")) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: `/admin/schedule-update`,
                    data: {
                        'title': $('#ustitle').val(),
                        'startdate': $('input#uexstart').data('daterangepicker').startDate.format('YYYY.MM.DD'),
                        'enddate': null,
                        'starttime': $('input#uexstart').data('daterangepicker').startDate.format('hh:mm A'),
                        'endtime': null,
                        'backgroundColor': $("#uschedule_item_color").val(),
                        'borderColor': $("#uschedule_item_color").val(),
                        'customer': $("#uusersearch").val(),
                        'note': $("#uschedulenote").val(),
                        'type': $("#ucheck_time_type").val(),
                        'schedule_id': $("#schedule_up").val()    
                    },
                    type: 'POST',
                    success: function(data) {
                        if (data.success == true) {
                            toastr.success(data.msg);
                            schedulelist = [];
                            getevents();

                            $("#schedule_show_all").show();
                            $("#schedule_add_part").hide();
                            $("#schedule_update_part").hide();
                            if($("#selected_date").val() != "") {
                                $.ajax({
                                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                                    url: `/admin/schedule-selectdate`,
                                    data: {
                                        select_date: $("#selected_date").val(),
                                    },
                                    type: 'POST',
                                    success: function(data) {
                                        if (data.success) {
                                            $('div#show_all_list').html(data.html);
                                        } 
                                    },
                                    error: function(data){
                                        console.log(data);
                                    }
                                });
                            } else {
                                schedule_list();
                            }
                        } 
                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            } else {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: `/admin/schedule-update`,
                    data: {
                        'title': $('#ustitle').val(),
                        'startdate': $('input#ustart').data('daterangepicker').startDate.format('YYYY.MM.DD'),
                        'enddate': $('input#ustart').data('daterangepicker').endDate.format('YYYY.MM.DD'),
                        'starttime': $('input#ustart').data('daterangepicker').startDate.format('hh:mm A'),
                        'endtime': $('input#ustart').data('daterangepicker').endDate.format('hh:mm A'),
                        'backgroundColor': $("#uschedule_item_color").val(),
                        'borderColor': $("#uschedule_item_color").val(),
                        'customer': $("#uusersearch").val(),
                        'note': $("#uschedulenote").val(),
                        'type': $("#ucheck_time_type").val(),
                        'schedule_id': $("#schedule_up").val()    
                    },
                    type: 'POST',
                    success: function(data) {
                        if (data.success == true) {
                            toastr.success(data.msg);
                            schedulelist = [];
                            getevents();

                            $("#schedule_show_all").show();
                            $("#schedule_add_part").hide();
                            $("#schedule_update_part").hide();
                            if($("#selected_date").val() != "") {
                                $.ajax({
                                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                                    url: `/admin/schedule-selectdate`,
                                    data: {
                                        select_date: $("#selected_date").val(),
                                    },
                                    type: 'POST',
                                    success: function(data) {
                                        if (data.success) {
                                            $('div#show_all_list').html(data.html);
                                        } 
                                    },
                                    error: function(data){
                                        console.log(data);
                                    }
                                });
                            } else {
                                schedule_list();
                            }
                        } 
                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            }
        } else if ($("#ucheck_time_type").val() == 1) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: `/admin/schedule-update`,
                data: {
                    'title': $('#ustitle').val(),
                    'startdate': $('input#uallstarttemp').val(),
                    'enddate': $('input#uallendtemp').val(),
                    'starttime': "",
                    'endtime': "",
                    'backgroundColor': $("#uschedule_item_color").val(),
                    'borderColor': $("#uschedule_item_color").val(),
                    'customer': $("#uusersearch").val(),
                    'note': $("#uschedulenote").val(),
                    'type': $("#ucheck_time_type").val(),
                    'schedule_id': $("#schedule_up").val()    
                },
                type: 'POST',
                success: function(data) {
                    if (data.success == true) {
                        toastr.success(data.msg);
                        schedulelist = [];
                        getevents();

                        $("#schedule_show_all").show();
                        $("#schedule_add_part").hide();
                        $("#schedule_update_part").hide();
                        if($("#selected_date").val() != "") {
                            $.ajax({
                                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                                url: `/admin/schedule-selectdate`,
                                data: {
                                    select_date: $("#selected_date").val(),
                                },
                                type: 'POST',
                                success: function(data) {
                                    if (data.success) {
                                        $('div#show_all_list').html(data.html);
                                    } 
                                },
                                error: function(data){
                                    console.log(data);
                                }
                            });
                        } else {
                            schedule_list();
                        }
                    } 
                },
                error: function(data){
                    console.log(data);
                }
            });
        }
        
    });
    // $(document).on('click', '.btn_list_user', function(e){
    //     console.log("========================", $(this).data('id'));
    // });
    // $(document).on('click', '.btn_list_chat', function(e){
    //     console.log("========================", $(this).data('id'));
    // });

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
                    $("#btn_pinadd").show();
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
    $('#exacttime').change(function() {
        if(this.checked) {
            $("#range_sche").hide();
            $("#exact_sche").show();
            if($("#click_date").val() != "") {
                $('#exstart').data('daterangepicker').setStartDate(moment($("#click_date").val(), "YYYY.MM.DD").set('hour', 7).minutes(30));
                $('#exstart').data('daterangepicker').setEndDate(moment($("#click_date").val(), "YYYY.MM.DD").set('hour', 7).minutes(30));
            }
        } else {
            $("#range_sche").show();
            $("#exact_sche").hide();
        }       
    });
    $('#uexacttime').change(function() {
        if(this.checked) {
            $("#urange_sche").hide();
            $("#uexact_sche").show();
            if($("#click_date").val() != "") {
                $('#uexstart').data('daterangepicker').setStartDate(moment($("#click_date").val(), "YYYY.MM.DD").set('hour', 7).minutes(30));
                $('#uexstart').data('daterangepicker').setEndDate(moment($("#click_date").val(), "YYYY.MM.DD").set('hour', 7).minutes(30));
            }
        } else {
            $("#urange_sche").show();
            $("#uexact_sche").hide();
        }       
    });
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
    $(document).on('click', '.btn_scheule_memo', function(e){
        var customersid = $(this).data('customer');
        var adminsid = $(this).data('admin');
        $("#memo_customer_id").val(customersid);
        $("#memo_admin_id").val(adminsid);
        $("body").addClass("right-memo-enabled");
        if(customersid == ""){
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: `/admin/memo-admin-list`,
                data: {
                    admin_id: adminsid,
                },
                type: 'POST',
                success: function(data) {
                    console.log("ddddd",data)
                    if (data.success) {
                        $("#customer_memo_list").html(data.html);
                    } 
                },
                error: function(data){
                    console.log(data);
                }
            });
        } else {
            
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: `/admin/memo-list`,
                data: {
                    customer_id: customersid,
                },
                type: 'POST',
                success: function(data) {
                    if (data.success) {
                        $("#customer_memo_list").html(data.html);
                    } 
                },
                error: function(data){
                    console.log(data);
                }
            });
        }
    });
    $(document).on("click", "body", function(e) {
        0 < $(e.target).closest(".btn_scheule_memo, .right-bar-memo").length || $("body").removeClass("right-memo-enabled")
    });
    $(document).on('click', "#customer_memo_add", function(e) {
        $("#memonote").val('');
        $("#memokeyword").val('');
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
        if ($("#memo_customer_id").val() != ""){
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
        } else if($("#memo_admin_id").val() != "") {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: `/admin/memo-admin-add`,
                data: {
                    admin: $("#memo_admin_id").val(),
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
                            url: `/admin/memo-admin-list`,
                            data: {
                                admin_id: $("#memo_admin_id").val(),
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
        }
        

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
        if ($("#memo_customer_id").val() != "") {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: `/admin/memo-update`,
                data: {
                    customer: $("#memo_customer_id").val(),
                    note: $("#upmemonote").val(),
                    company: $("#upmemocompany").val(),
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
        } else if($("#memo_admin_id").val() != "") {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: `/admin/memo-admin-update`,
                data: {
                    admin: $("#memo_admin_id").val(),
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
                            url: `/admin/memo-admin-list`,
                            data: {
                                admin_id: $("#memo_admin_id").val(),
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
        }
        

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
                    if ($("#memo_customer_id").val() != "") {
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
                    }  else if($("#memo_admin_id").val() != "") {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: `/admin/memo-admin-list`,
                            data: {
                                admin_id: $("#memo_admin_id").val(),
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
                    if ($("#memo_customer_id").val() != "") {
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
                    } else if($("#memo_admin_id").val() != "") {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: `/admin/memo-admin-list`,
                            data: {
                                admin_id: $("#memo_admin_id").val(),
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
                    
                                        
                } 
            },
            error: function(data){
                console.log(data);
            }
        });
    });
    
</script>
@endsection