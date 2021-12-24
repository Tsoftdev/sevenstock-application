
@foreach($allday as $all)
<div class="row">
    <div class="mt-1 col-sm-6">
        <p class="card-title-schedule">{{$all->title}}</p>
    </div>
    <div class="col-sm-6">
        <div class="justify-content-end d-flex">
            <a href="javascript:void(0);" class="pt-1 pb-1 ps-1 pe-1 btn_today_edit" data-id="{{$all->id}}"><i class="mdi mdi-pen-remove" style="font-size:18px;"></i></a>
            <a href="javascript:void(0);" class="pt-1 pb-1 ps-1 pe-1 btn_schedule_delete" style="font-size: 18px;" data-id="{{$all->id}}"><i class="mdi mdi-delete"></i></a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-4">
        <p class="schedule-allday-title"><b>하루종일</b></p>
    </div>
    <div class="col-sm-8">
        <div class="justify-content-end d-flex">
            <p>
                {{$all->start}} - {{$all->end}}({{$all->days}} days)
                
            </p>
            <a href="javascript:void(0);" class="ms-1"><i class="mdi mdi-checkbox-blank-circle" style="font-size:8px; color: {{$all->backgroundColor}}"></i></a>
            
        </div>
    </div>
</div>
@if ($all->customer->count() > 0)
@foreach($all->customer as $customer)
<div class="row mb-2">
    <div class="col-sm-7">
        <a href="{{ url ('admin/edit_customer/'.$customer->subcustomer->id) }}">
            <input type="text" class="form-control schedule-ownname" id="owner" name="owner" value="{{ $customer != null ? $customer->subcustomer->name : $all->UserName }}" readonly>
        </a>
    </div>
    <div class="col-sm-5">
        <div class="justify-content-end d-flex"> 
            @if($customer->status == "Active")
            <a href="javascript:void(0);" class="btn btn-success waves-effect text-nowrap waves-light btn_schedulestatus" data-status="{{$customer->status}}" style="width: 80px !important;" data-id="{{$customer->id}}">완료</a>
            @elseif ($customer->status == "Pending")
            <a href="javascript:void(0);" class="btn btn-info text-nowrap waves-effect waves-light btn_schedulestatus" data-status="{{$customer->status}}" style="width: 80px !important;" data-id="{{$customer->id}}">진행중</a>
            @elseif ($customer->status == "Canceled")
            <a href="javascript:void(0);" class="btn btn-danger text-nowrap waves-effect waves-light btn_schedulestatus" data-status="{{$customer->status}}" style="width: 80px !important;" data-id="{{$customer->id}}">취소</a>
            @endif
            <a href="javascript:void(0);" class="btn btn-primary text-nowrap ms-1 btn_scheule_memo" data-customer="{{$customer->customerId}}" style="width: 55px !important;" data-admin="{{$all->createdBy}}"> 메모 </a>
        </div>
    </div>
</div>
@endforeach
<div class="row mb-1">
    <div class="col-sm-6">
        <span class="badge ps-3 pe-3 pt-2 pb-2" style="font-size:14px;background-color:{{$all->backgroundColor}};">
            @if ($all->backgroundColor == "#f91308") 
                내부미팅
            @elseif ($all->backgroundColor == "#f3d122")
                외부미팅 - 법인
            @elseif ($all->backgroundColor == "#58db83")
                라운딩
            @elseif ($all->backgroundColor == "#0388f9")
                외부일정 - 개인
            @elseif ($all->backgroundColor == "#3b4044")
                취소
            @elseif ($all->backgroundColor == "#fbe806")
                외부모임
            @endif
        </span>
    </div>
    
</div>
@else 
<div class="row mb-2">
    <div class="col-sm-12">
        <input type="text" class="form-control schedule-ownname" id="owner" name="owner" value="{{ $all->UserName }}" readonly>
    </div>
</div>
<div class="row mb-1">
    <div class="col-sm-6">
        <span class="badge ps-3 pe-3 pt-2 pb-2" style="font-size:14px;background-color:{{$all->backgroundColor}};">
            @if ($all->backgroundColor == "#f91308") 
                내부미팅
            @elseif ($all->backgroundColor == "#f3d122")
                외부미팅 - 법인
            @elseif ($all->backgroundColor == "#58db83")
                라운딩
            @elseif ($all->backgroundColor == "#0388f9")
                외부일정 - 개인
            @elseif ($all->backgroundColor == "#3b4044")
                취소
            @elseif ($all->backgroundColor == "#fbe806")
                외부모임
            @endif
        </span>
    </div>
    
</div>
@endif
@if($all->note)
<div class="row mt-3 mb-3">
    <div class="col-sm-12">
        <textarea type="text" rows="1" class="form-control schedule-note" id="ownnote" name="ownnote" readonly>{{$all->note}}</textarea>
    </div>
</div>
@endif
<hr class="flex-grow-1 mt-1 mb-3" style="height:1px;">
@endforeach
@forelse($schedules as $schedule)

<div class="row">
    <div class="mt-1 col-sm-6">
        <p class="card-title-schedule">{{$schedule->title}}</p>
    </div>
    <div class="col-sm-6">
        <div class="justify-content-end d-flex">
            <a href="javascript:void(0);" class="pt-1 pb-1 ps-1 pe-1 btn_today_edit" data-id="{{$schedule->id}}"><i class="mdi mdi-pen-remove" style="font-size:18px;"></i></a>
            <a href="javascript:void(0);" class="pt-1 pb-1 ps-1 pe-1 btn_schedule_delete" style="font-size: 18px;" data-id="{{$schedule->id}}"><i class="mdi mdi-delete"></i></a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        @if ($schedule->type == "T")
        <p class="schedule-time-title">{{$schedule->starttime}} ~ {{$schedule->endtime}}</p>
        @elseif ($schedule->type == "E")
        <p class="schedule-time-title">{{$schedule->starttime}}</p>
        @endif
    </div>
</div>
@if ($schedule->customer->count() > 0)
@foreach($schedule->customer as $customer)
<div class="row mb-2">
    <div class="col-sm-7">
        <a href="{{ url ('admin/edit_customer/'.$customer->subcustomer->id) }}">
            <input type="text" class="form-control schedule-ownname" id="ownername" name="ownername" value="{{ $customer != null ? $customer->subcustomer->name : $schedule->UserName }}" readonly>
        </a>
    </div>
    <div class="col-sm-5">
        <div class="justify-content-end d-flex">
            @if($customer->status == "Active")
            <a href="javascript:void(0);" class="btn btn-success waves-effect text-nowrap waves-light btn_schedulestatus" data-status="{{$customer->status}}" style="width: 80px !important;" data-id="{{$customer->id}}">완료</a>
            @elseif ($customer->status == "Pending")
            <a href="javascript:void(0);" class="btn btn-info text-nowrap waves-effect waves-light btn_schedulestatus" data-status="{{$customer->status}}" style="width: 80px !important;" data-id="{{$customer->id}}">진행중</a>
            @elseif ($customer->status == "Canceled")
            <a href="javascript:void(0);" class="btn btn-danger text-nowrap waves-effect waves-light btn_schedulestatus" data-status="{{$customer->status}}" style="width: 80px !important;" data-id="{{$customer->id}}">취소</a>
            @endif
            <a href="javascript:void(0);" class="btn btn-primary text-nowrap ms-1 btn_scheule_memo" data-customer="{{$customer->customerId}}" style="width: 55px !important;" data-admin="{{$schedule->createdBy}}"> 메모 </a>
        </div>
    </div>
</div>

@endforeach
<div class="row mb-1">
    <div class="col-sm-6">
        <span class="badge ps-3 pe-3 pt-2 pb-2" style="font-size:14px;background-color:{{$schedule->backgroundColor}};">
            @if ($schedule->backgroundColor == "#f91308") 
                내부미팅
            @elseif ($schedule->backgroundColor == "#f3d122")
                외부미팅 - 법인
            @elseif ($schedule->backgroundColor == "#58db83")
                라운딩
            @elseif ($schedule->backgroundColor == "#0388f9")
                외부일정 - 개인
            @elseif ($schedule->backgroundColor == "#3b4044")
                취소
            @elseif ($schedule->backgroundColor == "#fbe806")
                외부모임
            @endif
        </span>
    </div>
</div>
@else 
<div class="row mb-2">
    <div class="col-sm-12">
        <input type="text" class="form-control schedule-ownname" id="ownername" name="ownername" value="{{ $schedule->UserName }}" readonly>
    </div>
</div>
<div class="row mb-1">
    <div class="col-sm-6">
        <span class="badge ps-3 pe-3 pt-2 pb-2" style="font-size:14px;background-color:{{$schedule->backgroundColor}};">
            @if ($schedule->backgroundColor == "#f91308") 
                내부미팅
            @elseif ($schedule->backgroundColor == "#f3d122")
                외부미팅 - 법인
            @elseif ($schedule->backgroundColor == "#58db83")
                라운딩
            @elseif ($schedule->backgroundColor == "#0388f9")
                외부일정 - 개인
            @elseif ($schedule->backgroundColor == "#3b4044")
                취소
            @elseif ($schedule->backgroundColor == "#fbe806")
                외부모임
            @endif
        </span>
    </div>
    
</div>

@endif
@if($schedule->note)
<div class="row mt-3 mb-3">
    <div class="col-sm-12">
        <textarea type="text" rows="1" class="form-control schedule-note" id="ownernote" name="ownernote" readonly>{{$schedule->note}}</textarea>
    </div>
</div>
@endif
<hr class="flex-grow-1 mt-1 mb-3" style="height:1px;">
@empty
<p class="text-center">등록된 자료가 없습니다.</p>
@endforelse

<style type="text/css">
    .card-title-schedule {
        color: #000000;
        font-weight: normal;
        font-style: normal;
        font-size: 15px;
        line-height: 20px;
        font-family: Inter;
        margin-bottom: 0.5rem!important;
    }
    .card-title-desc {
        color: #6c757d;
        margin-bottom: 0px!important;
    }
    .schedule-allday-title {
        font-family: Inter;
        font-style: normal;
        font-weight: normal;
        font-size: 14px;
        line-height: 20px; 
        letter-spacing: 0.006em;

        color: #7A6FBE;
    }
    .schedule-time-title {
        font-family: Inter;
        font-style: normal;
        font-weight: bold;
        font-size: 16px;
        line-height: 20px; 
        letter-spacing: 0.011em;

        color: #7A6FBE;
    }
    .schedule-ownname {
        background: rgba(248, 249, 250, 0.7) !important;
        border: 1px solid #6C757D;
        box-sizing: border-box;
        border-radius: 6px;
        height: 37px;
    }
    .schedule-note {
        background: #F2F2F2!important;
        border: 1px solid #A9A9A9;
        box-sizing: border-box;
        border-radius: 6px;
    }
</style>

