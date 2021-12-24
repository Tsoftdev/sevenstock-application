@extends('admin.layouts.app')
@section('title', '방문기록 수정')
@section('css')
<link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<style>
    .form-control {
        padding: 0.50rem .75rem;
    }

</style>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="page-title-custom">
                                <h4>방문기록 수정</h4>
                            </div>
                        </div>
                        <div class="mb-3 mt-1 col-md-6">
                            <div class="justify-content-end d-flex">
                                <a href="{{ url('admin/user-record/visit-record') }}" class="btn btn-primary btn-sm"> 돌아가기</a>
                            </div>
                        </div>
                    </div>

                    <hr class="my-auto flex-grow-1 mt-1 mb-3" style="height:1px;">
                    <form class="form-horizontal mt-4 needs-validation" method="POST" action="{{ url('admin/user-record/edit_visit_record/'.$visitrecord->id) }}" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label" for="title">제목 <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="title" name="title" value="{{$visitrecord->title}}" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <?php 
                                    $status = $visitrecord->customer[0] ? $visitrecord->customer[0]['status'] : '';
                                    ?>
                                    <label class="form-label" for="visit_status">상태 <span class="text-danger">*</span></label>
                                    {{ Form::select('visit_status',[''=>'상태..','Active'=>'완료','Pending'=>'진행중','Canceled'=>'취소'],$status,['class'=>'form-control select2','id'=>'visit_status','required'=>'required']) }}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label" for="customer">고객 <span class="text-danger">*</span></label>
                                    <select class="select2 form-control select2-multiple wd-100p" multiple="multiple" data-placeholder="고객" id="customer" name="customer[]" required>
                                        @foreach($customers as $customer)
                                            <option value="{{$customer->id}}" @if(in_array($customer->id, $finalArray)) selected @endif>{{$customer->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label" for="type">유형 <span class="text-danger">*</span></label>
                                    <select class="form-control select2" id="type" name="type" required>
                                        <option value="T" @if($visitrecord->type == "T") selected @endif>Time</option>
                                        <option value="A" @if($visitrecord->type == "A") selected @endif>All Day</option>
                                        <option value="E" @if($visitrecord->type == "E") selected @endif>Exact</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label" for="startdate">시작날짜 <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="startdate" name="startdate" value="{{date('Y.m.d', strtotime($visitrecord->startdate))}}" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label" for="starttime">시작시간 <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control timepicker" id="starttime" name="starttime" value="{{$visitrecord->starttime}}" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label" for="enddate">마감날짜 <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="enddate" name="enddate" value="{{date('Y.m.d', strtotime($visitrecord->enddate))}}" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label" for="endtime">마감시간 <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control timepicker" id="endtime" name="endtime" value="{{$visitrecord->endtime}}" required>
                                </div>
                            </div>
                            
                            
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="note">내용 <span class="text-danger">*</span></label>
                                    <textarea type="text" class="form-control" id="note" name="note" rows="4">{{$visitrecord->note}}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="note">배경색 <span class="text-danger">*</span></label>
                                <div>
                                    <div class="avatar avatar-xs m-r-5 ">
                                        <div class="avatar-title js-event-color rounded-circle" data-color="#f91308" style="background-color:#f91308;"></div>
                                    </div>
                                    <div class="avatar avatar-xs m-r-5 ">
                                        <div class="avatar-title js-event-color rounded-circle" data-color="#f3d122" style="background-color:#f3d122;"></div>
                                    </div>
                                    <div class="avatar avatar-xs m-r-5 ">
                                        <div class="avatar-title js-event-color rounded-circle" data-color="#58db83" style="background-color:#58db83;"></div>
                                    </div>
                                    <div class="avatar avatar-xs m-r-5 ">
                                        <div class="avatar-title js-event-color rounded-circle" data-color="#0388f9" style="background-color:#0388f9;"></div>
                                    </div>

                                    <div class="avatar avatar-xs m-r-5 ">
                                        <div class="avatar-title js-event-color rounded-circle" data-color="#3b4044" style="background-color:#3b4044;"></div>
                                    </div>

                                    <div class="avatar avatar-xs m-r-5 ">
                                        <div class="avatar-title js-event-color rounded-circle" data-color="#fbe806" style="background-color:#fbe806;"></div>
                                    </div>
                                </div>
                                
                            </div>
                            
                        </div>
                        <input type="hidden" id="backgroundColor" name="backgroundColor" value="#B1C2D9" />
                        <div class="row">
                            <div class="col-md-6">
                                <div class="justify-content-start d-flex">
                                    <button type="sumbit" name="submit" value="submit" class="btn btn-success btn-sm m-2 btn_visit_update"><i class="mdi mdi-content-save-move"></i>  저장하기 </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
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
<!-- Responsive examples -->
<script src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
<script type="text/javascript">
    $(".select2").select2();
    $('#startdate').datepicker({
        // showOtherMonths: true,
        // selectOtherMonths: true,
        // numberOfMonths: 2,
        changeMonth:true, 
        changeYear:true,
        dateFormat: 'yy.mm.dd',
        monthNames: [ "1월", "2월", "3월", "4월", "5월", "6월",
        "7월", "8월", "9월", "10월", "11월", "12월" ],
        monthNamesShort: [ "1월", "2월", "3월", "4월", "5월", "6월",
        "7월", "8월", "9월", "10월", "11월", "12월" ],
        dayNames: [ "일요일", "월요일", "화요일", "수요일", "목요일", "금요일", "토요일" ],
        dayNamesShort: [ "일", "월", "화", "수", "목", "금", "토" ],
        dayNamesMin: [ "일", "월", "화", "수", "목", "금", "토" ],

    });
    $('#enddate').datepicker({
        changeMonth:true, 
        changeYear:true,
        dateFormat: 'yy.mm.dd',
        monthNames: [ "1월", "2월", "3월", "4월", "5월", "6월",
        "7월", "8월", "9월", "10월", "11월", "12월" ],
        monthNamesShort: [ "1월", "2월", "3월", "4월", "5월", "6월",
        "7월", "8월", "9월", "10월", "11월", "12월" ],
        dayNames: [ "일요일", "월요일", "화요일", "수요일", "목요일", "금요일", "토요일" ],
        dayNamesShort: [ "일", "월", "화", "수", "목", "금", "토" ],
        dayNamesMin: [ "일", "월", "화", "수", "목", "금", "토" ],

    });
    $('.timepicker').timepicker({
        showInputs: false
    });
    var currColor = '#B1C2D9';
    $("#backgroundColor").val(currColor);
    $('.js-event-color').click(function (e) {
        e.preventDefault()
        currColor = $(this).data('color');
        $("#backgroundColor").val($(this).data('color'));
        //Add color effect to button
        $('.btn_visit_update').css({'background-color': currColor, 'border-color': currColor})
    });
    $("#type").on('change', function(e){
        if ($("#type").val() == "T") {
            $("#starttime").prop('disabled', false);
            $("#endtime").prop('disabled', false);
            $("#startdate").prop('disabled', false);
            $("#enddate").prop('disabled', false);
            $("#starttime").val("07:00 AM");
            $("#starttime").timepicker('setTime', "07:00 AM");
            $("#endtime").val("01:00 PM");
            $("#endtime").timepicker('setTime', "01:00 PM");
        } else if ($("#type").val() == "A") {
            $("#starttime").prop('disabled', true);
            $("#endtime").prop('disabled', true);
            $("#startdate").prop('disabled', false);
            $("#enddate").prop('disabled', false);
            $("#starttime").val("");
            $("#starttime").timepicker('setTime', "");
            $("#endtime").val("");
            $("#endtime").timepicker('setTime', "");

        } else if ($("#type").val() == "E") {
            $("#starttime").prop('disabled', false);
            $("#endtime").prop('disabled', true);
            $("#startdate").prop('disabled', false);
            $("#enddate").prop('disabled', true);
            $("#endtime").val("");
            $("#endtime").timepicker('setTime', "");
            $("#enddate").val("");
        }
    });
    $( document ).ready(function() {
        var typeval = '{{$visitrecord->type}}';
        if(typeval === "A") {
            $("#starttime").prop('disabled', true);
            $("#endtime").prop('disabled', true);
            $("#startdate").prop('disabled', false);
            $("#enddate").prop('disabled', false);
            $("#starttime").val("");
            $("#starttime").timepicker('setTime', "");
            $("#endtime").val("");
            $("#endtime").timepicker('setTime', "");
        } else if (typeval === "T") {
            $("#starttime").prop('disabled', false);
            $("#endtime").prop('disabled', false);
            $("#startdate").prop('disabled', false);
            $("#enddate").prop('disabled', false);
            
        } else if (typeval === "E") {
            $("#starttime").prop('disabled', false);
            $("#endtime").prop('disabled', true);
            $("#startdate").prop('disabled', false);
            $("#enddate").prop('disabled', true);
            $("#endtime").val("");
            $("#endtime").timepicker('setTime', "");
            $("#enddate").val("");
        } 
    });
    
    
</script>
@endsection