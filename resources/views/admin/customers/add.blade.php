@extends('admin.layouts.app')
@section('title', '고객 추가')
@section('css')
<link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<style>
.nav-tabs>li>a {
    color: #000 !important;
}
.form-control {
    padding: 0.50rem .75rem;
}
.input-group {
    flex-wrap: nowrap;
}
.input-group-append {
    margin-left: -1px;
    display: flex;
}
.input-group > .input-group-append > .btn {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
}
.js-event-color {
    cursor: pointer;
}
.star{
    vertical-align: sub;
    font-size: 20px;
}
.form-control.note {
    resize: none;
    border: unset;
    min-height: 245px !important;
    background-color: #EFEFF0;
    padding: 10px;
}
</style>
<div class="container-fluid">
    <form class="form-horizontal needs-validation" method="POST" action="{{ url('admin/add_customer') }}" novalidate>
        @csrf
        <div class="row">
            <div class="col-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="page-title-custom">
                                    <h4><b>유저 정보</b></h4>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="justify-content-end d-flex">
                                    <a href="javascript:void(0);" class="btn btn-primary me-2">메모</a>
                                    <button type="sumbit" name="submit" value="submit" class="btn btn-success me-2">등록</button>
                                    <a href="{{ url('admin/customers') }}" class="btn btn-secondary">뒤로</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div style="border-bottom: 1px solid #ced4da;"></div>
                    
                    <div class="card-body" style="padding-top: 0;">
                        <div class="row">
                            <div class="col-md-6" style="border-right: 1px solid #ced4da;">
                                <div class="row mt-3">
                                    <div class="col-md-9">
                                        <div class="mb-3">
                                            <label class="form-label" for="name">이름</label>
                                            <input type="text" class="form-control" id="name" name="name" value="">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label" for="age">연령대</label>
                                            <input type="text" class="form-control" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" id="age" name="age" >
                                        </div>
                                    </div>
                                    <!--div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label" for="gender">성별</label>
                                            <select class="form-control select2" id="gender" name="gender" >
                                                <option value="M">Male</option>
                                                <option value="F">Female</option>
                                                <option value="O">Other</option>
                                            </select>
                                        </div>
                                    </div-->
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="phonenumber1">전화번호<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="phonenumber" name="phonenumber1" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="phonenumber2">전화번호 2</label>
                                            <input type="text" class="form-control" id="phonenumber2" name="phonenumber2" >
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="">
                                            <label class="form-label" for="email">이메일</label>
                                            <input type="email" class="form-control" id="email" name="email" >
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="row mt-3">
                                    <div class="col-md-9">
                                        <div class="mb-3">
                                            <label class="form-label" for="cities">지역</label>
                                            <div class="input-group">
                                                <select class="form-control select2" id="cities" name="cities" >
                                                    <option value="">Choose one</option>
                                                    @foreach($cities as $city)
                                                        <option value="{{$city->id}}">{{$city->cityName}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label></label>
                                        <button type="button" class="btn btn-outline-secondary w-100 mt-2 manageModalBtn" data-type="city">관리</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="address">주소</label>
                                            <input type="text" class="form-control" id="address" name="address" >
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label" for="level">경험</label>
                                            <div class="input-group">
                                                {{ Form::select('level',$levels->pluck('levelName','id')->prepend('Choose One', ''),null,['class'=>'form-control select2','id'=>'level']) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label></label>
                                        <button type="button" class="btn btn-outline-secondary w-100 mt-2 manageModalBtn" data-type="level">관리</button>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label" for="status">상태</label>
                                            <div class="input-group">
                                                {{ Form::select('status_id',$customerStatus->pluck('statusName','id')->prepend('Choose One', ''),null,['class'=>'form-control select2']) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label></label>
                                        <button type="button" class="btn btn-outline-secondary w-100 mt-2 manageModalBtn" data-type="status">관리</button>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label" for="cities">담당자</label>
                                            <div class="input-group">
                                                {{ Form::select('group',$groups->pluck('groupName','id'),null,['class'=>'form-control','id'=>'group']) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label></label>
                                        <button type="button" class="btn btn-outline-secondary w-100 mt-2 manageModalBtn" data-type="agent">관리</button>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="accountNumber">증권 계좌번호</label>
                                            <input type="text" class="form-control" id="accountNumber" name="accountNumber">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--div class="col-md-4">
                                <div class="row mt-3">
                                    <div class="col-md-9">
                                        <div class="mb-3">
                                            <label class="form-label" for="stock_firm">증권사</label>
                                            <div class="input-group">
                                                <select class="form-control select2" id="stock_firm" name="stock_firm" >
                                                    <option value="">Choose one</option>
                                                    @foreach($stockbrokers as $stockbroker)
                                                        <option value="{{$stockbroker->id}}">{{$stockbroker->brokerName}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label></label>
                                        <button type="button" class="btn btn-outline-secondary w-100 mt-2 manageModalBtn" data-type="stockbroker">관리</button>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="account_number">증권 계좌번호</label>
                                            <input type="text" class="form-control" id="account_number" name="account_number">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="mb-3">
                                            <label class="form-label" for="routsofknown">알게된 경로</label>
                                            <div class="input-group">
                                                <select class="form-control select2" id="routsofknown" name="routsofknown" >
                                                    <option value="">Choose one</option>
                                                    @foreach($routeknowns as $routeknown)
                                                        <option value="{{$routeknown->id}}">{{$routeknown->routeName}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label></label>
                                        <button type="button" class="btn btn-outline-secondary w-100 mt-2 manageModalBtn" data-type="routeknown">관리</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="edited_by"> 수정한 사람</label>
                                            {{ Form::select('',$admins->pluck('name','id'),Auth::guard('admin')->user()->id,['class'=>'form-control select2','id'=>'edited_by','disabled']) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="">
                                            <label class="form-label" for="edited_date">수정한 날짜</label>
                                            <input type="text" class="form-control" readonly id="edited_date" name="edited_date" >
                                        </div>
                                    </div>
                                </div>
                            </div-->
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="page-title-custom">
                                    <h4 class="note_heading"><b>노트</b></h4>
                                    <h4 class="finance_heading" style="display: none;"><b>금융 정보</b></h4>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <ul class="nav nav-pills nav-justified" role="tablist">
                                    <li class="nav-item waves-effect waves-light">
                                        <a class="nav-link {{ !request()->filled('period') ? 'active' : ''  }} note_tab" data-bs-toggle="tab" href="#customer_note" role="tab"><b>노트</b></a>
                                    </li>
                                    <li class="nav-item waves-effect waves-light">
                                        <a class="nav-link {{ request()->filled('period') ? 'active' : ''  }} finance_tab" data-bs-toggle="tab" href="#customer_finance" role="tab"><b>금융 정보</b></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="tab-content">
                        <div class="tab-pane {{ !request()->filled('period') ? 'active' : ''  }}" id="customer_note" role="tabpanel">
                            <div class="card-body" style="padding-top: 0;">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <textarea name="customer_note" class="form-control note"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-9">
                                                <div class="mb-3">
                                                    <label class="form-label" for="routsofknown">재테크 정보 출처</label>
                                                    <div class="input-group">
                                                        <select class="form-control select2" id="routsofknown" name="routsofknown" >
                                                            <option value="">Choose one</option>
                                                            @foreach($routeknowns as $routeknown)
                                                                <option value="{{$routeknown->id}}">{{$routeknown->routeName}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label></label>
                                                <button type="button" class="btn btn-outline-secondary w-100 mt-2 manageModalBtn" data-type="routeknown">관리</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane {{ request()->filled('period') ? 'active' : ''  }}" id="customer_finance" role="tabpanel">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">투자 가능 유동성 자금</label>
                                                    <input type="text" class="form-control" name="investable_liquid_funds" value="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">투자경로</label>
                                                    <input type="text" class="form-control" name="investment_path" value="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">재테크</label>
                                                    <input type="text" class="form-control" name="finance" value="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">주식투자경력</label>
                                                    <input type="text" class="form-control" name="stock_investment_experience" value="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">상장주식 투자 수익률</label>
                                                    <input type="text" class="form-control" name="return_on_investment" value="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">수익/손실</label>
                                                    <input type="text" class="form-control" name="profit_lose" value="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">첫 방문날짜</label>
                                                        <input type="date" class="form-control" name="first_visited_date" value="">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="stock_firm">증권사</label>
                                                        <div class="input-group">
                                                            <select class="form-control select2" id="stock_firm" name="stock_firm">
                                                                <option value="">Choose one</option>
                                                                @foreach($stockbrokers as $stockbroker)
                                                                    <option value="{{$stockbroker->id}}">{{ $stockbroker->brokerName }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label></label>
                                                    <button type="button" class="btn btn-outline-secondary w-100 mt-2 manageModalBtn" data-type="stockbroker">관리</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-tabs" role="tablist" style="float:left;">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" id="stocktab" href="#stocktransaction" role="tab">
                                    <span class="d-block d-sm-none">ST</span>
                                    <span class="d-none d-sm-block">주식이체
                                        &nbsp;
                                        <!-- <span class="text-danger star">*</span> -->
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" id="filetab" href="#filetransfer" role="tab">
                                    <span class="d-block d-sm-none">FT</span>
                                    <span class="d-none d-sm-block">파일전송
                                        &nbsp;
                                        <!-- <span class="text-danger star">*</span> -->
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" id="postertab" href="#poster" role="tab">
                                    <span class="d-block d-sm-none">PT</span>
                                    <span class="d-none d-sm-block">우편발송
                                        &nbsp;
                                        <!-- <span class="text-danger star">*</span> -->
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" id="visittab" href="#visitrecord" role="tab">
                                    <span class="d-block d-sm-none">VR</span>
                                    <span class="d-none d-sm-block">방문기록
                                        &nbsp;
                                        <!-- <span class="text-danger star">*</span> -->
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" id="inquerytab" href="#inquery" role="tab">
                                    <span class="d-block d-sm-none">IQ</span>
                                    <span class="d-none d-sm-block">전체메모
                                        &nbsp;
                                        <!-- <span class="text-danger star">*</span> -->
                                    </span>
                                </a>
                            </li>
                        </ul>

                        <!--div class="btns">
                            <button class="btn btn-outline-dark" type="button">100+</button>
                            <button class="btn btn-primary" type="button">Add</button>
                        </div-->

                        <!-- Tab panes -->
                        <div class="tab-content">

                            <!-- Stock transfer section -->
                            <div class="tab-pane p-3 active mt-5" id="stocktransaction" role="tabpanel">
                                <div class="card">
                                    <div class="card-body">

                                        <!-- Add Stock transfer -->
                                        <div class="row" id="formstock">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="stockdate">날짜</label>
                                                        <input type="text" class="form-control" id="stockdate" name="stockdate" autocomplete="off">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="company">기업</label>
                                                        <div class="input-group" >
                                                            <select class="form-control select2 companytab" id="company" name="company">
                                                                <option value="">Select Company</option>
                                                                @foreach($companies as $company)
                                                                    <option value="{{$company->id}}">{{$company->companyName}}</option>
                                                                @endforeach
                                                            </select>
                                                            <!--div class="input-group-append">
                                                                <a href="javascript:void(0);" class="btn btn-primary companymanage input-group-text">등록한 사람</a>
                                                            </div-->
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="stock_status">상태 </label>
                                                        <select class="form-control select2" id="stock_status" name="stock_status">
                                                            <option value="">Select Status</option>
                                                            <option value="Active">이체완료</option>
                                                            <option value="Pending">진행중</option>
                                                            <option value="Canceled">취소</option>
                                                            <option value="Exit">EXIT</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="stockPrice">주가금액</label>
                                                        <input type="text" class="form-control" id="stockPrice" name="stockPrice">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="quantity">주식 수</label>
                                                        <input type="text" class="form-control" id="quantity" name="quantity">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="invested">투자금액</label>
                                                        <input type="text" class="form-control" id="invested" name="invested" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- File transfer section -->
                            <div class="tab-pane p-3 mt-5" id="filetransfer" role="tabpanel">
                                <div class="card">
                                    <div class="card-body">

                                        <!-- Add file transfer -->
                                        <div class="row" id="formfiletransfer">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="filedate">날짜</label>
                                                        <input type="text" class="form-control" id="filedate" name="filedate" autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="filecompany">기</label>
                                                        <div class="input-group">
                                                            <select class="form-control select2 companytab" id="filecompany" name="filecompany">
                                                                <option value="">Select Company</option>
                                                                @foreach($companies as $company)
                                                                    <option value="{{$company->id}}">{{$company->companyName}}</option>
                                                                @endforeach
                                                            </select>
                                                        
                                                            <!--a href="javascript:void(0);" class="btn btn-primary companymanage input-group-text">등록한 사람</a-->
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="filemethod">전송 방법</label>
                                                        <select class="form-control select2" id="filemethod" name="filemethod">
                                                            <option value="">How to send</option>
                                                            <option value="Email">E-mail</option>
                                                            <option value="Post">Post</option>
                                                            <option value="SMS">SMS</option>
                                                            <option value="Messenger">Messenger</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="fileName">파일 이름</label>
                                                        <input type="text" class="form-control " id="fileName" name="fileName">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- Mailing Section -->
                            <div class="tab-pane p-3 mt-5" id="poster" role="tabpanel">
                                <div class="card">
                                    <div class="card-body">

                                        <!-- Add Mailing -->
                                        <div class="row" id="formposter">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="postdate">날짜</label>
                                                        <input type="text" class="form-control " id="postdate" name="postdate" autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="postcompany">기</label>
                                                        <div class="input-group">
                                                            <select class="form-control select2" id="postcompany" name="postcompany">
                                                                <option value="">Select Company</option>
                                                                @foreach($companies as $company)
                                                                    <option value="{{$company->id}}">{{$company->companyName}}</option>
                                                                @endforeach
                                                            </select>
                                                            <!--a href="javascript:void(0);" class="btn btn-primary companymanage input-group-text">등록한 사람</a-->
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="postcity">지역</label>
                                                        <select class="form-control select2" id="postcity" name="postcity">
                                                            <option value="">Select City</option>
                                                            @foreach($cities as $city)
                                                                <option value="{{$city->id}}">{{$city->cityName}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="postaddress">Address</label>
                                                        <input type="text" class="form-control pastAddress " id="postaddress" name="postaddress">
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-2">
                                                    <div class="mt-4 pt-1">
                                                        <!--<button type="button" class="btn btn-default w-100 fw-bold" style="background: #ffd2d2;">Use current info</button>-->
                                                        <input class="btn btn-info w-100 fw-bold copyAddress" type="button" value="Copy Existing Address">
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="post_status">상태</label>
                                                        <select class="form-control select2" id="post_status" name="post_status">
                                                            <option value="">Select Status</option>
                                                            <option value="Delivered">Shipment Completed</option>
                                                            <option value="Pending">Sending Out</option>
                                                            <option value="Returned">Bounced</option>
                                                            <option value="Canceled">Cancel</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Visit Record section -->
                            <div class="tab-pane p-3 mt-5" id="visitrecord" role="tabpanel">
                                <div class="card">
                                    <div class="card-body">

                                        <!-- Add Visit Record -->
                                        <div class="row" id="formvisit">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="title">Title</label>
                                                        <input type="text" class="form-control " id="title" name="title">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="visit_status">상태</label>
                                                        <select class="form-control select2" id="visit_status" name="visit_status">
                                                            <option value="">Select Status</option>
                                                            <option value="Active">Completed</option>
                                                            <option value="Pending">Pending</option>
                                                            <option value="Canceled">Canceled</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="visittype">Type</label>
                                                        <select class="form-control select2" id="visittype" name="visittype">
                                                            <option value="T">Time</option>
                                                            <option value="A">All Day</option>
                                                            <option value="E">Exact</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="startdate">Start Date</label>
                                                        <input type="text" class="form-control" id="startdate" name="startdate">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="starttime">Start Time</label>
                                                        <input type="text" class="form-control timepicker" id="starttime" name="starttime" autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="enddate">End Date</label>
                                                        <input type="text" class="form-control" id="enddate" name="enddate">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="endtime">End Time</label>
                                                        <input type="text" class="form-control timepicker" id="endtime" name="endtime" autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="visitnote">Content</label>
                                                        <textarea type="text" class="form-control" id="visitnote" name="visitnote" rows="4"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label" for="background">Background Color </label>
                                                    <div>
                                                        <div class="avatar avatar-xs m-r-5 ">
                                                            <div class="avatar-title text-white  js-event-color  rounded-circle"></div>
                                                        </div>
                                                        <div class="avatar avatar-xs m-r-5 ">
                                                            <div class="avatar-title text-white  js-event-color  bg-primary rounded-circle"></div>
                                                        </div>
                                                        <div class="avatar avatar-xs m-r-5 ">
                                                            <div class="avatar-title text-white  js-event-color  bg-secondary rounded-circle"></div>
                                                        </div>
                                                        <div class="avatar avatar-xs m-r-5 ">
                                                            <div class="avatar-title text-white  js-event-color  bg-success rounded-circle"></div>
                                                        </div>
                                                        <div class="avatar avatar-xs m-r-5 ">
                                                            <div class="avatar-title text-white  js-event-color  bg-danger rounded-circle"></div>
                                                        </div>
                                                        <div class="avatar avatar-xs m-r-5 ">
                                                            <div class="avatar-title text-white  js-event-color  bg-warning rounded-circle"></div>
                                                        </div>
                                                        <div class="avatar avatar-xs m-r-5 ">
                                                            <div class="avatar-title text-white  js-event-color  bg-info rounded-circle"></div>
                                                        </div>
                                                        <div class="avatar avatar-xs m-r-5 ">
                                                            <div class="avatar-title text-white  js-event-color  bg-dark rounded-circle"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <input class="" type="hidden" id="backgroundColor" name="backgroundColor" value="#B1C2D9" />
                                        </div>
                                    </div>
                                </div>            
                            </div>

                            <!-- Inquiries section -->
                            <div class="tab-pane p-3 mt-5" id="inquery" role="tabpanel">
                                <div class="card">
                                    <div class="card-body">

                                        <!-- Add Inquiry -->
                                        <div class="row" id="forminquery">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="note">Content</label>
                                                        <textarea type="text" class="form-control" rows="5" id="note" name="note"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="keyword">Keyword </label>
                                                        <div class="col-sm-12">
                                                            <input type="text" class="form-control" id="keyword" name="keyword" data-role="tagsinput">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>


<!-- Modal -->
<div class="modal fade come-from-modal right" id="manageModal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="html_append">

        </div>
    </div>
</div>
<style type="text/css">
.come-from-modal.left .modal-dialog,
.come-from-modal.right .modal-dialog {
    position: fixed;
    margin: auto;
    width: 320px;
    height: 100%;
    -webkit-transform: translate3d(0%, 0, 0);
    -ms-transform: translate3d(0%, 0, 0);
    -o-transform: translate3d(0%, 0, 0);
    transform: translate3d(0%, 0, 0);
}

.come-from-modal.left .modal-content,
.come-from-modal.right .modal-content {
    height: 100%;
    overflow-y: auto;
    border-radius: 0px;
}

.come-from-modal.left .modal-body,
.come-from-modal.right .modal-body {
    padding: 15px 15px 80px;
}
.come-from-modal.right.fade .modal-dialog {
    right: 0px;
    -webkit-transition: opacity 0.3s linear, right 0.3s ease-out;
    -moz-transition: opacity 0.3s linear, right 0.3s ease-out;
    -o-transition: opacity 0.3s linear, right 0.3s ease-out;
    transition: opacity 0.3s linear, right 0.3s ease-out;
}

.come-from-modal.right.fade.in .modal-dialog {
    right: 0;
}
</style>


@stop
@section('javascript')
<script src="{{ asset('assets/libs/select2/js/select2.full.min.js') }}"></script>
<!-- Required datatable js -->
<script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<!-- Responsive examples -->
<script src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>
<script type="text/javascript">
    if(localStorage.getItem('cuser')) {
        $("#name").val(localStorage.getItem('cuser'));
    }
    if(localStorage.getItem('cphone')) {
        $("#phonenumber").val(localStorage.getItem('cphone'));
    }

    $(".select2").select2({width: "100%"});
    $('#stockdate, #filedate, #postdate, #startdate, #enddate').datepicker({
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
    $("#starttime").val("07:00 AM");
    $("#starttime").timepicker('setTime', "07:00 AM");
    $("#endtime").val("01:00 PM");
    $("#endtime").timepicker('setTime', "01:00 PM");


    $("#quantity").keyup(function () {
        var total = $('#stockPrice').val();
        $("#quantity").each(function (index, item) {
            var temp = parseFloat($(item).val());
            if (isNaN(temp))
                temp = 1
            total = total * temp;
        });
        $("#invested").val(total);
    });
    $("#stockPrice").keyup(function () {
        var total = $('#quantity').val();
        $("#stockPrice").each(function (index, item) {
            var temp = parseFloat($(item).val());
            if (isNaN(temp))
                temp = 1
            total = total * temp;
        });
        $("#invested").val(total);
    });

    var currColor = '#B1C2D9';
    $("#backgroundColor").val(currColor);
    $('.js-event-color').click(function (e) {
        e.preventDefault()
        currColor = $(this).css('background-color');
        $("#backgroundColor").val($(this).css('background-color'));
        //Add color effect to button
        $('.btn_visitadd').css({'background-color': currColor, 'border-color': currColor})
        toastr.success('This color "'+ currColor+ '" slected', 'Success');
    });
    $('#edited_date').datepicker({
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
    }).datepicker("setDate",'now');
    // $("#groupmanage").on('click', function(e){
    //     $("#groupmodal").modal('show');
    // });

    // $(".btn_cityadd").on('click', function(e){
    //     var form = $("#CityForm");
    //     if (form[0].checkValidity() === false) {
    //         event.preventDefault()
    //         event.stopPropagation()
    //         form.addClass('was-validated');
    //         return;
    //     }
    //     $.ajaxSetup({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         }
    //     });
    //     $.ajax({
    //         url: `/admin/new-city`,
    //         data: {
    //             city: $("#mcity").val()
    //         },
    //         type: 'POST',
    //         success: function(data) {
    //             if (data.status == "Success") {
    //                 var newOption = new Option(data.cityName, data.id, true, true);
    //                 $("#cities").append(newOption).trigger('change');
    //                 $("#citymodal").modal('hide');
    //             } 
    //         },
    //         error: function(data){
    //             console.log(data);
    //         }
    //    });
    // });

    // $(".btn_groupadd").on('click', function(e){
    //     var form = $("#GroupForm");
    //     if (form[0].checkValidity() === false) {
    //         event.preventDefault()
    //         event.stopPropagation()
    //         form.addClass('was-validated');
    //         return;
    //     }
    //     $.ajaxSetup({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         }
    //     });
    //     $.ajax({
    //         url: `/admin/new-group`,
    //         data: {
    //             group: $("#mgroup").val()
    //         },
    //         type: 'POST',
    //         success: function(data) {
    //             if (data.status == "Success") {
    //                 var newOption = new Option(data.groupName, data.id, true, true);
    //                 $("#group").append(newOption).trigger('change');
    //                 $("#groupmodal").modal('hide');
    //             } 
    //         },
    //         error: function(data){
    //             console.log(data);
    //         }
    //    });
    // });

    
    // $("#stockmanage").on('click', function(e){
    //     $("#stockmodal").modal('show');
    // });
    // $(".btn_stockadd").on('click', function(e){
    //     var form = $("#StockForm");
    //     if (form[0].checkValidity() === false) {
    //         event.preventDefault()
    //         event.stopPropagation()
    //         form.addClass('was-validated');
    //         return;
    //     }
    //     $.ajaxSetup({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         }
    //     });
    //     $.ajax({
    //         url: `/admin/new-stock`,
    //         data: {
    //             stock: $("#mstock").val()
    //         },
    //         type: 'POST',
    //         success: function(data) {
    //             if (data.status == "Success") {
    //                 var newOption = new Option(data.brokerName, data.id, true, true);
    //                 $("#stock_firm").append(newOption).trigger('change');
    //                 $("#stockmodal").modal('hide');
    //             } 
    //         },
    //         error: function(data){
    //             console.log(data);
    //         }
    //    });
    // });
    // $("#routs_manage").on('click', function(e){
    //     $("#routemodal").modal('show');
    // });
    // $(".btn_routeadd").on('click', function(e){
    //     var form = $("#RouteForm");
    //     if (form[0].checkValidity() === false) {
    //         event.preventDefault()
    //         event.stopPropagation()
    //         form.addClass('was-validated');
    //         return;
    //     }
    //     $.ajaxSetup({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         }
    //     });
    //     $.ajax({
    //         url: `/admin/new-route`,
    //         data: {
    //             route: $("#mroute").val()
    //         },
    //         type: 'POST',
    //         success: function(data) {
    //             if (data.status == "Success") {
    //                 var newOption = new Option(data.routeName, data.id, true, true);
    //                 $("#routsofknown").append(newOption).trigger('change');
    //                 $("#routemodal").modal('hide');
    //             } 
    //         },
    //         error: function(data){
    //             console.log(data);
    //         }
    //    });
    // });
</script>
@endsection