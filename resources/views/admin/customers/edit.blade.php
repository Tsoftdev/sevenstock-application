@extends('admin.layouts.app')
@section('title', '고객 수정')

@section('css')
<link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<!-- DataTables -->
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<!-- Responsive datatable examples -->
<link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" /> 
<link href="{{ asset('assets/libs/slick-master/slick/slick.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/libs/slick-master/slick/slick-theme.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/libs/lightbox/dist/css/lightbox.min.css') }}" rel="stylesheet" type="text/css" /> 
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
.badge {
    padding: .5em .75em;
}
input.form-check-input.active {
    background-color: #3DD598;
    border-color: #3DD598;
}
.btns {
    text-align: right;
    margin-right: 18px;
}
#cityManageModal .table tr td,
#agentManageModal .table tr td,
#stockBrokerManageModal .table tr td,
#routesManageModal .table tr td{
    border-top: unset;
    padding: 0px 2px !important;
}
#cityManageModal .table tr td.actions a i,
#agentManageModal .table tr td.actions a i,
#stockBrokerManageModal .table tr td.actions a i,
#routesManageModal .table tr td.actions a i{
    color: gray;
    font-size: 23px;
    vertical-align: top;
}
#cityManageModal .form-check-label,
#agentManageModal .form-check-label,
#stockBrokerManageModal .form-check-label,
#routesManageModal .form-check-label{
    font-size: 17px;
    margin-left: 7px;
    font-weight: 600;
    margin-top: 3px;
}
#cityManageModal input#invalidCheck,
#agentManageModal input#invalidCheck,
#stockBrokerManageModal input#invalidCheck,
#routesManageModal input#invalidCheck{
    padding: 10px;
}
.jsu-event-color {
    cursor: pointer;
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
    /*right: 74px;*/
    top: 10px;
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
    margin-left: 15px;
    width: 100%;
    max-width: 1205px;
}
 
button.slick-prev.slick-arrow.slick-disabled {
    position: absolute;
    left: -30px;
    top: 10px;
}
button.slick-prev.slick-arrow{
    position: absolute;
    left: -30px;
    top: 10px;
}
.slick-list.draggable {
    width: 100%;
}
.slick-track {
    width: 1446px !important;
}
.slick-slide {
    /*width: 241px !important;*/
    width: auto !important;
    margin-right: 40px
}
.form-control.note {
    resize: none;
    border: unset;
    min-height: 245px !important;
    background-color: #EFEFF0;
    padding: 10px;
}
/*div#stock_datatable_filter {
    position: absolute;
    top: -33px;
    right: 12px;
}*/
.deleteAllStockTransferBtn,
.deleteAllFileTransferBtn,
.deleteAllPostDeliveryBtn,
.deleteAllVisitRecordsBtn,
.deleteAllInqueriesBtn{
    position: absolute;
    top: 10px;
}
.form-check-input1 {
    height: 22px;
    width: 22px;
}
.form-check-input {
    height: 22px;
    width: 22px;
}
</style>
<div class="container-fluid">
    <form class="form-horizontal needs-validation" method="POST" action="{{ url('admin/edit_customer/'.$customer->id) }}" novalidate>
        @csrf 
        <div class="row">
            <div class="col-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="page-title-custom">
                                    <h4>
                                        <b>유저 정보</b>
                                        &nbsp;&nbsp;
                                        <small>
                                            {{ $customer->user ? $customer->user->name : '' }} | {{ date('Y.m.d', strtotime($customer->date)) }}
                                        </small>
                                    </h4>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="justify-content-end d-flex">
                                    <a href="javascript:void(0);" class="btn btn-primary me-2 customer_edit_memo">메모</a>

                                    <!--a href="{{ url('admin/customer/delete/'.$customer->id) }}" onclick="return confirm('Are you sure?')" class="btn btn-danger" style="margin-bottom: 0px!important;"><i class="mdi mdi-delete"></i> Delete</a-->

                                    <button type="sumbit" name="submit" value="submit" class="btn btn-success me-2">Update</button>

                                    <a href="{{ url('admin/customers') }}" class="btn btn-secondary">뒤로</a>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div style="border-bottom: 1px solid #ced4da;"></div>
                    
                    <div class="card-body" style="padding-top: 0;">
                        <!-- <hr class="my-auto flex-grow-1 mt-1 mb-3" style="height:1px;"> -->
                        <div class="row">
                            <div class="col-md-6" style="border-right: 1px solid #ced4da;">
                                <div class="row mt-3">
                                    <div class="col-md-9">
                                        <div class="mb-3">
                                            <label class="form-label" for="name">이름</label>
                                            <input type="text" class="form-control" id="name" name="name" value="{{$customer->name}}">
                                            <!--<span class="text-danger">{{ $errors->first('name') }}</span>-->
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label" for="age">연령대</label>
                                            <input type="text" class="form-control" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" id="age" name="age" value="{{$customer->age}}">
                                        </div>
                                    </div>
                                    <!--div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label" for="gender">성별</label>
                                            <select class="form-control select2" id="gender" name="gender">
                                                <option value="">성별..</option>
                                                <option value="M" @if($customer->gender == "M") selected @endif>남자</option>
                                                <option value="F" @if($customer->gender == "F") selected @endif>여자</option>
                                                <option value="O" @if($customer->gender == "O") selected @endif>기타</option>
                                            </select>
                                        </div>
                                    </div-->
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="phonenumber1">전화번호<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="phonenumber" name="phonenumber1" value="{{$customer->phonenumber1}}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="phonenumber2">전화번호 2</label>
                                            <input type="text" class="form-control" id="phonenumber2" value="{{$customer->phonenumber2}}" name="phonenumber2">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="">
                                            <label class="form-label" for="email">이메일</label>
                                            <input type="email" class="form-control" id="email" name="email" value="{{$customer->email}}">
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
                                                <select class="form-control select2" id="cities" name="cities">
                                                    <option value="">Choose one</option>
                                                    @foreach($cities as $city)
                                                        <option value="{{$city->id}}" @if($city->id == $customer->city_id) selected @endif>{{$city->cityName}}</option>
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
                                            <input type="text" class="form-control" id="address" name="address" value="{{$customer->address}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label" for="level">경험</label>
                                            <div class="input-group">
                                                {{ Form::select('level',$levels->pluck('levelName','id')->prepend('Choose One', ''),$customer->level,['class'=>'form-control select2','id'=>'level']) }}
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
                                                {{ Form::select('status_id',$customerStatus->pluck('statusName','id')->prepend('Choose One', ''),$customer->status_id,['class'=>'form-control select2']) }}
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
                                                {{ Form::select('group',$groups->pluck('groupName','id'),$customer->customerGroupID,['class'=>'form-control','id'=>'group']) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label></label>
                                        <button type="button" class="btn btn-outline-secondary w-100 mt-2 manageModalBtn" data-type="agent">관리</button>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">첫 방문날짜</label>
                                            <input type="date" class="form-control" name="first_visited_date" value="{{ $customer->first_visited_date }}">
                                        </div>
                                    </div>
                                    <!--div class="col-md-9">
                                        <div class="mb-3">
                                            <label class="form-label" for="cities">담당자</label>
                                            <div class="input-group">
                                                {{ Form::select('group',$groups->pluck('groupName','id'),$customer->group,['class'=>'form-control','id'=>'group']) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label></label>
                                        <button type="button" class="btn btn-outline-secondary w-100 mt-2 manageModalBtn" data-type="agent">관리</button>
                                    </div-->
                                </div>
                            </div>

                            <!--div class="col-md-4">
                                <div class="row mt-3">
                                    <div class="col-md-9">
                                        <div class="mb-3">
                                            <label class="form-label" for="stock_firm">증권사</label>
                                            <div class="input-group">
                                                <select class="form-control select2" id="stock_firm" name="stock_firm">
                                                    <option value="">Choose one</option>
                                                    @foreach($stockbrokers as $stockbroker)
                                                        <option value="{{$stockbroker->id}}" @if($stockbroker->id == $customer->stockBroker) selected @endif>{{$stockbroker->brokerName}}</option>
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
                                            <input type="text" class="form-control" id="account_number" name="account_number" value="{{$customer->accountNumber}}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="mb-3">
                                            <label class="form-label" for="routsofknown">알게된 경로</label>
                                            <div class="input-group">
                                                <select class="form-control select2" id="routsofknown" name="routsofknown">
                                                    <option value="">Choose one</option>
                                                    @foreach($routeknowns as $routeknown)
                                                        <option value="{{$routeknown->id}}" @if($routeknown->id == $customer->routesOfKnownID) selected @endif>
                                                            {{ $routeknown->routeName }}
                                                        </option>
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
                                            {{ Form::select('',$admins->pluck('name','id'),$customer->updatedBy,['class'=>'form-control select2','id'=>'edited_by','disabled']) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="">
                                            <label class="form-label" for="edited_date">수정한 날짜</label>
                                            <input type="text" class="form-control" disabled id="edited_date" name="edited_date" value="{{ date('Y.m.d', strtotime($customer->date)) }}">
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
                                                    <textarea name="note" class="form-control note">{{ $customer->note }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-9">
                                                <div class="mb-3">
                                                    <label class="form-label" for="routsofknown">재테크 정보 출처</label>
                                                    <div class="input-group">
                                                        <select class="form-control select2" id="routsofknown" name="routsofknown">
                                                            <option value="">Choose one</option>
                                                            @foreach($routeknowns as $routeknown)
                                                                <option value="{{$routeknown->id}}" @if($routeknown->id == $customer->routesOfKnownID) selected @endif>
                                                                    {{ $routeknown->routeName }}
                                                                </option>
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
                                                    <input type="text" class="form-control" name="investable_liquid_funds" value="{{ $customer->investable_liquid_funds }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">투자경로</label>
                                                    <input type="text" class="form-control" name="investment_path" value="{{ $customer->investment_path }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">재테크</label>
                                                    <input type="text" class="form-control" name="finance" value="{{$customer->finance}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">주식투자경력</label>
                                                    <input type="text" class="form-control" name="stock_investment_experience" value="{{ $customer->stock_investment_experience }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">상장주식 투자 수익률</label>
                                                    <input type="text" class="form-control" name="return_on_investment" value="{{ $customer->return_on_investment }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">수익/손실</label>
                                                    <input type="text" class="form-control" name="profit_lose" value="{{ $customer->profit_lose }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="account_number">증권 계좌번호</label>
                                                    <input type="text" class="form-control" id="account_number" name="accountNumber" value="{{$customer->accountNumber}}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label" for="stock_firm">증권사</label>
                                                    <div class="input-group">
                                                        <select class="form-control select2" id="stock_firm" name="stock_firm">
                                                            <option value="">Choose one</option>
                                                            @foreach($stockbrokers as $stockbroker)
                                                                <option value="{{$stockbroker->id}}" @if($stockbroker->id == $customer->stockBroker) selected @endif>{{ $stockbroker->brokerName }}</option>
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
    </form>

    <div class="row mt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs" role="tablist" style="float:left;">
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" id="stocktab" href="#stocktransaction" role="tab">
                                <span class="d-block d-sm-none">ST</span>
                                <span class="d-none d-sm-block">주식이체
                                    &nbsp;
                                    <span class="badge rounded-circle bg-secondary float-end">
                                        {{ $stocksCount }}
                                    </span>
                                </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" id="filetab" href="#filetransfer" role="tab">
                                <span class="d-block d-sm-none">FT</span>
                                <span class="d-none d-sm-block">파일전송
                                    &nbsp;
                                    <span class="badge rounded-circle bg-secondary float-end">
                                        {{ $filetransfersCount }}
                                    </span>
                                </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" id="postertab" href="#poster" role="tab">
                                <span class="d-block d-sm-none">PT</span>
                                <span class="d-none d-sm-block">우편발송
                                    &nbsp;
                                    <span class="badge rounded-circle bg-secondary float-end">
                                        {{ $postdeliveriesCount }}
                                    </span>
                                </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" id="visittab" href="#visitrecord" role="tab">
                                <span class="d-block d-sm-none">VR</span>
                                <span class="d-none d-sm-block">방문기록
                                    &nbsp;
                                    <span class="badge rounded-circle bg-secondary float-end">  
                                        {{ $visitrecordsCount }}
                                    </span>
                                </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" id="inquerytab" href="#inquery" role="tab">
                                <span class="d-block d-sm-none">IQ</span>
                                <span class="d-none d-sm-block">전체메모
                                    &nbsp;
                                    <span class="badge rounded-circle bg-secondary float-end">  
                                        {{ $inqueriesCount }}
                                    </span>
                                </span>
                            </a>
                        </li>
                    </ul>

                    <div class="btns">
                        <button class="btn btn-outline-dark" type="button">100+</button>
                        <button class="btn btn-primary" type="button">등록</button>
                    </div>

                    <!-- Tab panes -->
                    <div class="tab-content">

                        <!-- Stock transfer section -->
                        <div class="tab-pane p-3" id="stocktransaction" role="tabpanel">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <?php $total_invested = 0;?>
                                            @foreach($stocks as $stock)
                                                <?php $total_invested +=$stock->invested; ?>
                                            @endforeach
                                            <div class="total_inveted">
                                                <p class="border"><b>Total Invested</b> : <span>
                                                    <a data-id="all" data-customer_id="{{ $customer->id }}" class="company_filter" href="javascript:void(0);">
                                                        {{ number_format($total_invested) }} 원</span>
                                                    </a>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-10 pt-2">
                                            <ul class="carousel mb-0">
                                                @foreach($companies as $company)
                                                    <li class="slide">
                                                        <b>{{ $company->companyName }} :</b> <a data-id="{{ $company->id }}" data-customer_id="{{ $customer->id }}" class="company_filter" href="javascript:void(0);">{{ $company->stocks ? number_format($company->stocks->where('userId',$customer->id)->sum('invested')) : 0 }} 원</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- Stock transfer listing -->
                                    <div class="row" id="stock_list">
                                        <div class="table-responsive pt-1">
                                            <form id="deleteAllStockTransferForm" action="{{ url('admin/delete/all/stock-transfers') }}" method="post">
                                                @csrf
                                                @if(count($stocks) > 0)
                                                    <a href="javascript:void(0);" class="btn btn-danger btn-sm deleteAllStockTransferBtn"><i class="mdi mdi-trash-can-outline"></i>  Delete All</a>
                                                @endif
                                                <table id="stock_datatable" class="table table-bordered align-middle dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th class="align-middle">
                                                                <label class="form-check-label">
                                                                    <input type="checkbox" class="form-check-input select-all-row">
                                                                </label>
                                                            </th>
                                                            <th>날짜</th>
                                                            <th>기업</th>
                                                            <th>주가금액</th>
                                                            <th>주식 수</th>
                                                            <th>투자금액</th>
                                                            <th>Proof</th>
                                                            <th>Registered By</th>
                                                            <th>상태</th>
                                                            <th class="text-center"> 확인 문자</th>
                                                        </tr>
                                                    </thead>
                                                    
                                                    <tbody id="filter_append_html">
                                                        @foreach($stocks as $stock)
                                                            <tr>
                                                                <td>
                                                                    <input type="checkbox" name="stock_transfer_id[]" class="form-check-input" value="{{ $stock->id }}" />
                                                                </td>
                                                                <td class="align-middle">{{$stock->date}}</td>
                                                                <td class="align-middle bg-light text-primary fw-bold"><a href="javascript:void(0);" class="stock_edit" data-id="{{$stock->id}}">{{$stock->companyName}}</a></td>
                                                                <td class="align-middle">{{ number_format($stock->stockPrice) }}</td>
                                                                <td class="align-middle">{{ number_format($stock->quantity) }}</td>
                                                                <td class="align-middle">{{ number_format($stock->invested) }}</td>

                                                                <td class="align-middle">
                                                                    <a data-lightbox="image-1" href="{{ $stock->picture }}">
                                                                        <img src="{{ $stock->picture }}" width="30">
                                                                    </a>
                                                                </td>
                                                                <td class="align-middle">{{$stock->adminname}}</td>
                                                                <td class="align-middle">
                                                                    @if($stock->status == "Active")
                                                                        <a href="javascript:void(0);" class="btn btn-success waves-effect waves-light btn_stock_status" data-status="{{ $stock->status }}" data-id="{{ $stock->id }}">Completed</a>
                                                                    @elseif ($stock->status == "Pending")
                                                                        <a href="javascript:void(0);" class="btn btn-primary waves-effect waves-light btn_stock_status" data-status="{{ $stock->status }}" data-id="{{ $stock->id }}">Pending</a>
                                                                    @elseif ($stock->status == "Canceled")
                                                                        <a href="javascript:void(0);" class="btn btn-secondary waves-effect waves-light btn_stock_status" data-status="{{ $stock->status }}" data-id="{{ $stock->id }}">Cancel</a>
                                                                    @elseif ($stock->status == "Exit")
                                                                        <a href="javascript:void(0);" class="btn btn-success waves-effect waves-light btn_stock_status" data-status="{{ $stock->status }}" data-id="{{ $stock->id }}">EXIT</a>
                                                                    @endif
                                                                </td>
                                                                <th class="align-middle text-center">
                                                                    @if($stock->is_sent == 1)
                                                                        <label class="form-check-label ">
                                                                            <input type="checkbox" value="{{$stock->is_sent}}" data-id="{{$stock->id}}" class="form-check-input1 active isMessageSent" checked>
                                                                        </label>
                                                                    @elseif ($stock->status == 0)
                                                                        <label class="form-check-label">
                                                                            <input type="checkbox" value="{{$stock->is_sent}}" data-id="{{$stock->id}}" class="form-check-input1 isMessageSent">
                                                                        </label>
                                                                    @endif
                                                                </th>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </form>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Add Stock transfer -->
                                    <div class="row" id="formstock">
                                        <form id="stockForm" class="form-horizontal mt-4 needs-validation" novalidate>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="stockdate">날짜 <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="stockdate" name="stockdate" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="company">기업 <span class="text-danger">*</span></label>
                                                        <div class="input-group" >
                                                            <select class="form-control select2 companytab" id="company" name="company" required>
                                                                <option value="">기업 ..</option>
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
                                                        <label class="form-label" for="stock_status">상태 <span class="text-danger">*</span></label>
                                                        <select class="form-control select2" id="stock_status" name="stock_status" required>
                                                            <option value="">상태..</option>
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
                                                        <label class="form-label" for="stockPrice">주가금액 <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="stockPrice" name="stockPrice" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="quantity">주식 수 <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="quantity" name="quantity" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="invested">투자금액 <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="invested" name="invested" required readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="justify-content-start d-flex">
                                                        <a href="javascript:void(0);" class="btn btn-success btn-sm me-2 btn_stockadd"><i class="mdi mdi-content-save-move"></i>  Save </a>
                                                        <a href="javascript:void(0);" class="btn btn-danger btn-sm btn_stockback"><i class="mdi mdi-backspace-outline"></i> Cancel</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <!-- Edit Stock transfer -->
                                    <div class="row" id="upformstock">
                                        <form id="upstockForm" class="form-horizontal mt-4 needs-validation" novalidate>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="ustockdate">날짜 <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="ustockdate" name="ustockdate" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    
                                                    <div class="mb-3">
                                                        <label class="form-label" for="ucompany">기업 <span class="text-danger">*</span></label>
                                                        <div class="input-group">
                                                            <select class="form-control select2 companytab" id="ucompany" name="ucompany" required>
                                                                <option value="">기업 ..</option>
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
                                                        <label class="form-label" for="ustock_status">상태 <span class="text-danger">*</span></label>
                                                        <select class="form-control select2" id="ustock_status" name="ustock_status" required>
                                                            <option value="">상태..</option>
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
                                                        <label class="form-label" for="ustockPrice">주가금액 <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="ustockPrice" name="ustockPrice" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="uquantity">주식 수 <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="uquantity" name="uquantity" required>
                                                    </div>
                                                    
                                                </div>
                                                <div class="col-md-4">
                                                    
                                                    <div class="mb-3">
                                                        <label class="form-label" for="uinvested">투자금액 <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="uinvested" name="uinvested" required readonly>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            <input type="hidden" id="upstockid" />
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="justify-content-start d-flex">
                                                        <a href="javascript:void(0);" class="btn btn-success btn-sm me-2 btn_stockupdate"><i class="mdi mdi-content-save-move"></i>  Update </a>
                                                        <a href="javascript:void(0);" class="btn btn-danger btn-sm btn_stockback"><i class="mdi mdi-backspace-outline"></i> Cancel</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <div class="justify-content-start d-flex">
                                                <a href="javascript:void(0);" class="btn btn-primary btn-sm btn_stockshow me-2"><i class="mdi mdi-content-save-move"></i>  Registration</a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- File transfer section -->
                        <div class="tab-pane p-3" id="filetransfer" role="tabpanel">
                            <div class="card">
                                <div class="card-body">

                                    <!-- File transfer listing-->
                                    <div class="row" id="filetransfer_list">
                                        <div class="table-responsive pt-1">
                                            <form id="deleteAllFileTransferForm" action="{{ url('admin/delete/all/file-transfers') }}" method="post">
                                                @csrf
                                                @if(count($filetransfers) > 0)
                                                    <a href="javascript:void(0);" class="btn btn-danger btn-sm deleteAllFileTransferBtn"><i class="mdi mdi-trash-can-outline"></i>  Delete All</a>
                                                @endif
                                                <table id="file_datatable" class="table table-bordered align-middle dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th class="align-middle">
                                                                <label class="form-check-label">
                                                                    <input type="checkbox" class="form-check-input select-all-row">
                                                                </label>
                                                            </th>
                                                            <th>날짜</th>
                                                            <th>기업</th>
                                                            <th>파일 이름</th>
                                                            <th>등록한 사람</th>
                                                            <th>전송 방법</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($filetransfers as $filetransfer)
                                                            <tr>
                                                                <td>
                                                                    <input type="checkbox" name="file_transfer_id[]" class="form-check-input" value="{{ $filetransfer->id }}" />
                                                                </td>
                                                                <td class="align-middle">{{$filetransfer->date}}</td>
                                                                <td class="align-middle bg-light text-primary fw-bold"><a href="javascript:void(0);" class="transfer_edit" data-id="{{$filetransfer->id}}">{{$filetransfer->companyName}}</a></td>
                                                                <td class="align-middle">{{$filetransfer->fileName}}</td>
                                                                <td class="align-middle">{{$filetransfer->adminname}}</td>
                                                                <td class="align-middle">
                                                                    @if($filetransfer->method == "Email")
                                                                    <a href="javascript:void(0);" class="btn btn-success waves-effect waves-light btn_file_method" data-method="{{$filetransfer->method}}" data-id="{{$filetransfer->id}}">이메일</a>
                                                                    @elseif ($filetransfer->method == "Post")
                                                                    <a href="javascript:void(0);" class="btn btn-primary waves-effect waves-light btn_file_method" data-method="{{$filetransfer->method}}" data-id="{{$filetransfer->id}}">우편</a>
                                                                    @elseif ($filetransfer->method == "SMS")
                                                                    <a href="javascript:void(0);" class="btn btn-info waves-effect waves-light btn_file_method" data-method="{{$filetransfer->method}}" data-id="{{$filetransfer->id}}"> 확인 문자</a>
                                                                    @elseif ($filetransfer->method == "Messenger")
                                                                    <a href="javascript:void(0);" class="btn btn-secondary waves-effect waves-light btn_file_method" data-method="{{$filetransfer->method}}" data-id="{{$filetransfer->id}}">카카오톡</a>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Add file transfer -->
                                    <div class="row" id="formfiletransfer">
                                        <form class="form-horizontal mt-4 needs-validation" id="transferForm" novalidate>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="filedate">날짜 <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="filedate" name="filedate" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="filecompany">기업 <span class="text-danger">*</span></label>
                                                        <div class="input-group">
                                                            <select class="form-control select2 companytab" id="filecompany" name="filecompany" required>
                                                                <option value="">기업 ..</option>
                                                                @foreach($companies as $company)
                                                                    <option value="{{$company->id}}">{{$company->companyName}}</option>
                                                                @endforeach
                                                            </select>
                                                            <!--a href="javascript:void(0);" class="btn btn-primary companymanage input-group-text">추가</a-->
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="filemethod">전송방법 <span class="text-danger">*</span></label>
                                                        <select class="form-control select2" id="filemethod" name="filemethod" required>
                                                            <option value="">전송방법..</option>
                                                            <option value="Email">이메일</option>
                                                            <option value="Post">우편</option>
                                                            <option value="SMS"> 확인 문자</option>
                                                            <option value="Messenger">카카오톡</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="fileName">파일 이름 <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="fileName" name="fileName" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="justify-content-start d-flex">
                                                        <a href="javascript:void(0);" class="btn btn-success btn-sm me-2 btn_fileadd"><i class="mdi mdi-content-save-move"></i>  등록하기 </a>
                                                        <a href="javascript:void(0);" class="btn btn-danger btn-sm btn_fileback"><i class="mdi mdi-backspace-outline"></i> 돌아가기</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <!-- Edit file transfer -->
                                    <div class="row" id="upformfiletransfer">
                                        <form class="form-horizontal mt-4 needs-validation" id="uptransferForm" novalidate>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="ufiledate">날짜 <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="ufiledate" name="ufiledate" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="ufilecompany">기업 <span class="text-danger">*</span></label>
                                                        <div class="input-group">
                                                            <select class="form-control select2 companytab" id="ufilecompany" name="ufilecompany" required>
                                                                <option value="">기업 ..</option>
                                                                @foreach($companies as $company)
                                                                    <option value="{{$company->id}}">{{$company->companyName}}</option>
                                                                @endforeach
                                                            </select>
                                                        
                                                            <!--a href="javascript:void(0);" class="btn btn-primary companymanage input-group-text">추가</a-->
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="ufilemethod">전송방법 <span class="text-danger">*</span></label>
                                                        <select class="form-control select2" id="ufilemethod" name="ufilemethod" required>
                                                            <option value="">전송방법..</option>
                                                            <option value="Email">이메일</option>
                                                            <option value="Post">우편</option>
                                                            <option value="SMS"> 확인 문자</option>
                                                            <option value="Messenger">카카오톡</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="ufileName">파일 이름 <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="ufileName" name="ufileName" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" id="fileid" />
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="justify-content-start d-flex">
                                                        <a href="javascript:void(0);" class="btn btn-success btn-sm me-2 btn_fileupdate"><i class="mdi mdi-content-save-move"></i>  저장하기 </a>
                                                        <a href="javascript:void(0);" class="btn btn-danger btn-sm btn_fileback"><i class="mdi mdi-backspace-outline"></i> 돌아가기</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <div class="justify-content-start d-flex">
                                                <a href="javascript:void(0);" class="btn btn-primary btn-sm btn_transfershow me-2"><i class="mdi mdi-content-save-move"></i> 등록하기</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Mailing Section -->
                        <div class="tab-pane p-3" id="poster" role="tabpanel">
                            <div class="card">
                                <div class="card-body">

                                    <!-- Mailing listing -->
                                    <div class="row" id="poster_list">
                                        <div class="table-responsive pt-1">
                                            <form id="deleteAllPostDeliveryForm" action="{{ url('admin/delete/all/post-delivery') }}" method="post">
                                                @csrf
                                                @if(count($postdeliveries) > 0)
                                                    <a href="javascript:void(0);" class="btn btn-danger btn-sm deleteAllPostDeliveryBtn"><i class="mdi mdi-trash-can-outline"></i>  Delete All</a>
                                                @endif
                                                <table id="poster_datatable" class="table table-bordered align-middle dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th class="align-middle">
                                                                <label class="form-check-label">
                                                                    <input type="checkbox" class="form-check-input select-all-row"><span></span>
                                                                </label>
                                                            </th>
                                                            <th>날짜</th>
                                                            <th>기업</th>
                                                            <th>주소</th>
                                                            <th>지역</th>
                                                            <th>관리자</th>
                                                            <th>상태</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($postdeliveries as $postdelivery)
                                                        <tr>
                                                            <td>
                                                                <input type="checkbox" name="post_delivery_id[]" class="form-check-input" value="{{ $postdelivery->id }}"/>
                                                            </td>
                                                            <td class="align-middle">{{ $postdelivery->date }}</td>
                                                            <td class="align-middle bg-light text-primary fw-bold"><a href="javascript:void(0);" class="poster_edit" data-id="{{$postdelivery->id}}">{{$postdelivery->companyName}}</a></td>
                                                            <td class="align-middle">{{ $postdelivery->address }}</td>
                                                            <td class="align-middle">{{ $postdelivery->city->cityName }}</td>
                                                            <td class="align-middle">{{ $postdelivery->adminname }}</td>
                                                            <td class="align-middle">
                                                                @if($postdelivery->status == "Delivered")
                                                                <a href="javascript:void(0);" class="btn btn-success waves-effect waves-light btn_post_status" data-status="{{$postdelivery->status}}" data-id="{{$postdelivery->id}}">발송완료</a>
                                                                @elseif ($postdelivery->status == "Pending")
                                                                <a href="javascript:void(0);" class="btn btn-primary waves-effect waves-light btn_post_status" data-status="{{$postdelivery->status}}" data-id="{{$postdelivery->id}}">발송중</a>
                                                                @elseif ($postdelivery->status == "Returned")
                                                                <a href="javascript:void(0);" class="btn btn-secondary waves-effect waves-light btn_post_status" data-status="{{$postdelivery->status}}" data-id="{{$postdelivery->id}}">반송됨</a>
                                                                @elseif ($postdelivery->status == "Canceled")
                                                                <a href="javascript:void(0);" class="btn btn-danger waves-effect waves-light btn_post_status" data-status="{{$postdelivery->status}}" data-id="{{$postdelivery->id}}">취소</a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Add Mailing -->
                                    <div class="row" id="formposter">
                                        <form class="form-horizontal mt-4 needs-validation" id="posterForm" novalidate>
                                            <div class="row">
                                                
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="postdate">날짜 <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="postdate" name="postdate" required>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="postcompany">기업 <span class="text-danger">*</span></label>
                                                        <div class="input-group">
                                                            <select class="form-control select2" id="postcompany" name="postcompany" required>
                                                                <option value="">기업 ..</option>
                                                                @foreach($companies as $company)
                                                                    <option value="{{$company->id}}">{{$company->companyName}}</option>
                                                                @endforeach
                                                            </select>
                                                        
                                                            <!--a href="javascript:void(0);" class="btn btn-primary companymanage input-group-text">추가</a-->
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="postcity">지역 <span class="text-danger">*</span></label>
                                                        <select class="form-control select2" id="postcity" name="postcity" required>
                                                            <option value="">지역..</option>
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
                                                        <label class="form-label" for="postaddress">주소 <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control pastAddress" id="postaddress" name="postaddress" required>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-2">
                                                    <div class="mt-4 pt-1">
                                                        <!--<button type="button" class="btn btn-default w-100 fw-bold" style="background: #ffd2d2;">Use current info</button>-->
                                                        <input class="btn btn-info w-100 fw-bold copyAddress" data-address="{{ $customer->address }}" type="button" value="Copy Existing Address">
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="post_status">상태 <span class="text-danger">*</span></label>
                                                        <select class="form-control select2" id="post_status" name="post_status" required>
                                                            <option value="">상태..</option>
                                                            <option value="Delivered">발송완료</option>
                                                            <option value="Pending">발송중</option>
                                                            <option value="Returned">반송됨</option>
                                                            <option value="Canceled">취소</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="justify-content-start d-flex">
                                                        <a class="btn btn-success btn-sm me-2 btn_posteradd"><i class="mdi mdi-content-save-move"></i>  등록하기 </a>
                                                        <a href="javascript:void(0);" class="btn btn-danger btn-sm btn_posterback"><i class="mdi mdi-backspace-outline"></i> 돌아가기</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <!-- Edit Mailing -->
                                    <div class="row" id="upformposter">
                                        <form class="form-horizontal mt-4 needs-validation" id="upposterForm" novalidate>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="upostdate">날짜 <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="upostdate" name="upostdate" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    
                                                    <div class="mb-3">
                                                        <label class="form-label" for="upostcompany">기업 <span class="text-danger">*</span></label>
                                                        <div class="input-group">
                                                            <select class="form-control select2" id="upostcompany" name="upostcompany" required>
                                                                <option value="">기업 ..</option>
                                                                @foreach($companies as $company)
                                                                    <option value="{{$company->id}}">{{$company->companyName}}</option>
                                                                @endforeach
                                                            </select>
                                                        
                                                            <!--a href="javascript:void(0);" class="btn btn-primary companymanage input-group-text">추가</a-->
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="upostcity">지역 <span class="text-danger">*</span></label>
                                                        <select class="form-control select2" id="upostcity" name="upostcity" required>
                                                            <option value="">지역..</option>
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
                                                        <label class="form-label" for="upostaddress">주소 <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control pastAddress" id="upostaddress" name="upostaddress" required>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-2">
                                                    <div class="mt-4 pt-1">
                                                        <!--<button type="button" class="btn btn-default w-100 fw-bold" style="background: #ffd2d2;">Use current info</button>-->
                                                        <input class="btn btn-info w-100 fw-bold copyAddress" data-address="{{ $customer->address }}" type="button" value="기존 주소 복사">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="upost_status">상태 <span class="text-danger">*</span></label>
                                                        <select class="form-control select2" id="upost_status" name="upost_status" required>
                                                            <option value="">상태..</option>
                                                            <option value="Delivered">발송완료</option>
                                                            <option value="Pending">발송중</option>
                                                            <option value="Returned">반송됨</option>
                                                            <option value="Canceled">취소</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" id="postid" />
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="justify-content-start d-flex">
                                                        <a class="btn btn-success btn-sm me-2 btn_posterupdate"><i class="mdi mdi-content-save-move"></i>  저장하기 </a>
                                                        <a href="javascript:void(0);" class="btn btn-danger btn-sm btn_posterback"><i class="mdi mdi-backspace-outline"></i> 돌아가기</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <div class="justify-content-start d-flex">
                                                <a href="javascript:void(0);" class="btn btn-primary btn-sm btn_postershow me-2"><i class="mdi mdi-content-save-move"></i> 등록하기</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Visit Record section -->
                        <div class="tab-pane p-3" id="visitrecord" role="tabpanel">
                            <div class="card">
                                <div class="card-body">

                                    <!-- Visit Record listing -->
                                    <div class="row" id="visit_list">
                                        <div class="table-responsive pt-1">
                                            <form id="deleteAllVisitRecordsForm" action="{{ url('admin/delete/all/visit-records') }}" method="post">
                                                @csrf
                                                @if(count($visitrecords) > 0)
                                                    <a href="javascript:void(0);" class="btn btn-danger btn-sm deleteAllVisitRecordsBtn"><i class="mdi mdi-trash-can-outline"></i>  Delete All</a>
                                                @endif
                                                <table id="visit_datatable" class="table table-bordered align-middle dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th class="align-middle">
                                                                <label class="form-check-label">
                                                                    <input type="checkbox" class="form-check-input select-all-row"><span></span>
                                                                </label>
                                                            </th>
                                                            <th>시작날짜</th>
                                                            <th>시작시간</th>
                                                            <th>이름</th>
                                                            <th>제목</th>
                                                            <th>마감날짜</th>
                                                            <th>마감시간</th>
                                                            <th>유형</th>
                                                            <th>Note</th>
                                                            <th>관리자</th>
                                                            <th>상태</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($visitrecords as $visitrecord)
                                                        <tr>
                                                            <td>
                                                                <input type="checkbox" name="visit_record_id[]" class="form-check-input" value="{{ $visitrecord->id }}"/>
                                                            </td>
                                                            <td class="align-middle">{{$visitrecord->startdate}}</td>
                                                            <td class="align-middle">{{$visitrecord->starttime}}</td>
                                                            <td class="align-middle bg-light text-primary fw-bold"><a href="javascript:void(0);" class="visit_edit" data-id="{{$visitrecord->id}}">{{$visitrecord->name}}</a></td>
                                                            <td class="align-middle">{{$visitrecord->title}}</td>
                                                            <td class="align-middle">{{$visitrecord->enddate}}</td>
                                                            <td class="align-middle">{{$visitrecord->endtime}}</td>
                                                            <td class="align-middle">
                                                                @if($visitrecord->type == "E")
                                                                Exact
                                                                @elseif ($visitrecord->type == "A")
                                                                All Day
                                                                @elseif ($visitrecord->type == "T")
                                                                Time
                                                                @endif
                                                            </td>
                                                            <td class="align-middle">{{$visitrecord->note}}</td>
                                                            <td class="align-middle">{{$visitrecord->adminname}}</td>
                                                            <td class="align-middle">
                                                                @if($visitrecord->status == "Active")
                                                                <a href="javascript:void(0);" class="btn btn-success waves-effect waves-light btn_visit_status" data-status="{{$visitrecord->status}}" data-id="{{$visitrecord->id}}">완료</a>
                                                                @elseif ($visitrecord->status == "Pending")
                                                                <a href="javascript:void(0);" class="btn btn-primary waves-effect waves-light btn_visit_status" data-status="{{$visitrecord->status}}" data-id="{{$visitrecord->id}}">진행중</a>
                                                                @elseif ($visitrecord->status == "Canceled")
                                                                <a href="javascript:void(0);" class="btn btn-danger waves-effect waves-light btn_visit_status" data-status="{{$visitrecord->status}}" data-id="{{$visitrecord->id}}">취소</a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Add Visit Record -->
                                    <div class="row" id="formvisit">
                                        <form class="form-horizontal mt-4 needs-validation" id="visitForm" novalidate>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="title">제목 <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="title" name="title" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="visit_status">상태 <span class="text-danger">*</span></label>
                                                        <select class="form-control select2" id="visit_status" name="visit_status" required>
                                                            <option value="">상태..</option>
                                                            <option value="Active">완료</option>
                                                            <option value="Pending">진행중</option>
                                                            <option value="Canceled">취소</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="visittype">유형 <span class="text-danger">*</span></label>
                                                        <select class="form-control select2" id="visittype" name="visittype" required>
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
                                                        <label class="form-label" for="startdate">시작날짜 <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="startdate" name="startdate" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="starttime">시작시간 <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control timepicker" id="starttime" name="starttime" required autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="enddate">마감날짜 <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="enddate" name="enddate" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="endtime">마감시간 <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control timepicker" id="endtime" name="endtime" required autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="visitnote">내용 <span class="text-danger">*</span></label>
                                                        <textarea type="text" class="form-control" id="visitnote" name="visitnote" rows="4"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label" for="background">배경색 <span class="text-danger">*</span></label>
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
                                            <input type="hidden" id="backgroundColor" name="backgroundColor" value="#B1C2D9" />
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="justify-content-start d-flex">
                                                        <a href="javascript:void(0);" class="btn btn-success btn-sm me-2 btn_visitadd"><i class="mdi mdi-content-save-move"></i>  등록하기 </a>
                                                        <a href="javascript:void(0);" class="btn btn-danger btn-sm btn_visitback"><i class="mdi mdi-backspace-outline"></i> 돌아가기</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <!-- Edit Visit Record -->
                                    <div class="row" id="upformvisit">
                                        <form class="form-horizontal mt-4 needs-validation" id="upvisitForm" novalidate>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="utitle">제목 <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="utitle" name="utitle" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="uvisit_status">상태 <span class="text-danger">*</span></label>
                                                        <select class="form-control select2" id="uvisit_status" name="uvisit_status" required>
                                                            <option value="">상태..</option>
                                                            <option value="Active">완료</option>
                                                            <option value="Pending">진행중</option>
                                                            <option value="Canceled">취소</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="uvisittype">유형 <span class="text-danger">*</span></label>
                                                        <select class="form-control select2" id="uvisittype" name="uvisittype" required>
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
                                                        <label class="form-label" for="ustartdate">시작날짜 <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="ustartdate" name="ustartdate" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="ustarttime">시작시간 <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control timepicker" id="ustarttime" name="ustarttime" required autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="uenddate">마감날짜 <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="uenddate" name="uenddate" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="uendtime">마감시간 <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control timepicker" id="uendtime" name="uendtime" required autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="uvisitnote">내용 <span class="text-danger">*</span></label>
                                                        <textarea type="text" class="form-control" id="uvisitnote" name="uvisitnote" rows="4"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label" for="ubackground">배경색 <span class="text-danger">*</span></label>
                                                    <div>
                                                        <div class="avatar avatar-xs m-r-5 ">
                                                            <div class="avatar-title text-white  jsu-event-color  rounded-circle"></div>
                                                        </div>
                                                        <div class="avatar avatar-xs m-r-5 ">
                                                            <div class="avatar-title text-white  jsu-event-color  bg-primary rounded-circle"></div>
                                                        </div>
                                                        <div class="avatar avatar-xs m-r-5 ">
                                                            <div class="avatar-title text-white  jsu-event-color  bg-secondary rounded-circle"></div>
                                                        </div>
                                                        <div class="avatar avatar-xs m-r-5 ">
                                                            <div class="avatar-title text-white  jsu-event-color  bg-success rounded-circle"></div>
                                                        </div>
                                                        <div class="avatar avatar-xs m-r-5 ">
                                                            <div class="avatar-title text-white  jsu-event-color  bg-danger rounded-circle"></div>
                                                        </div>
                                                        <div class="avatar avatar-xs m-r-5 ">
                                                            <div class="avatar-title text-white  jsu-event-color  bg-warning rounded-circle"></div>
                                                        </div>
                                                        <div class="avatar avatar-xs m-r-5 ">
                                                            <div class="avatar-title text-white  jsu-event-color  bg-info rounded-circle"></div>
                                                        </div>
                                                        <div class="avatar avatar-xs m-r-5 ">
                                                            <div class="avatar-title text-white  jsu-event-color  bg-dark rounded-circle"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" id="ubackgroundColor" name="ubackgroundColor" value="#B1C2D9" />
                                            <input type="hidden" id="visitid" />
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="justify-content-start d-flex">
                                                        <a href="javascript:void(0);" class="btn btn-success btn-sm me-2 btn_visitupdate"><i class="mdi mdi-content-save-move"></i>  저장하기</a>
                                                        <a href="javascript:void(0);" class="btn btn-danger btn-sm btn_visitback"><i class="mdi mdi-backspace-outline"></i> 돌아가기</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <div class="justify-content-start d-flex">
                                                <a href="javascript:void(0);" class="btn btn-primary btn-sm btn_visitshow me-2"><i class="mdi mdi-content-save-move"></i> 등록하기</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>            
                        </div>

                        <!-- Inquiries section -->
                        <div class="tab-pane p-3" id="inquery" role="tabpanel">
                            <div class="card">
                                <div class="card-body">

                                    <!--Inquiries listing-->
                                    <div class="row" id="inquery_list">
                                        <div class="table-responsive pt-1">
                                            <form id="deleteAllInqueriesForm" action="{{ url('admin/delete/all/inqueries') }}" method="post">
                                                @csrf
                                                @if(count($inqueries) > 0)
                                                    <a href="javascript:void(0);" class="btn btn-danger btn-sm deleteAllInqueriesBtn"><i class="mdi mdi-trash-can-outline"></i>  Delete All</a>
                                                @endif
                                                <table id="inquery_datatable" class="table table-bordered align-middle dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th class="align-middle">
                                                                <label class="form-check-label">
                                                                    <input type="checkbox" class="form-check-input select-all-row"><span></span>
                                                                </label>
                                                            </th>
                                                            <th>날짜</th>
                                                            <th>이름</th>
                                                            <th>내용</th>
                                                            <th>키워드</th>
                                                            <th>관리자</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($inqueries as $inquery)
                                                        <tr>
                                                            <td>
                                                                <input type="checkbox" name="inqueries_id[]" class="form-check-input" value="{{ $inquery->id }}"/>
                                                            </td>
                                                            <td class="align-middle">{{ $inquery->date }}</td>
                                                            <td class="align-middle bg-light text-primary fw-bold">
                                                                <a href="javascript:void(0);" class="inquery_edit" data-id="{{$inquery->id}}">
                                                                    {{ $inquery->name }}
                                                                </a>
                                                            </td>
                                                            <td class="align-middle">{{ $inquery->note }}</td>
                                                            <td class="align-middle">
                                                                <span class="tag badge bg-info p-1 me-1">
                                                                    {{ $inquery->keyword }}
                                                                </span>
                                                            </td>
                                                            <td class="align-middle">{{ $inquery->adminname }}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Add Inquiry -->
                                    <div class="row" id="forminquery">
                                        <form class="form-horizontal mt-4 needs-validation" id="inqueryForm" novalidate>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="note">내용 <span class="text-danger">*</span></label>
                                                        <textarea type="text" class="form-control" rows="5" id="note" name="note" required></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="keyword">키워드 </label>
                                                        <div class="col-sm-12">
                                                            <input type="text" class="form-control" id="keyword" name="keyword" data-role="tagsinput">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="justify-content-start d-flex">
                                                        <a href="javascript:void(0);" class="btn btn-success btn-sm me-2 btn_inqueryadd"><i class="mdi mdi-content-save-move"></i>  등록하기 </a>
                                                        <a href="javascript:void(0);" class="btn btn-danger btn-sm btn_inqueryback"><i class="mdi mdi-backspace-outline"></i> 돌아가기</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <!-- Edit Inquiry -->
                                    <div class="row" id="upforminquery">
                                        <form class="form-horizontal mt-4 needs-validation" id="upinqueryForm" novalidate>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="unote">내용 <span class="text-danger">*</span></label>
                                                        <textarea type="text" class="form-control" rows="5" id="unote" name="unote" required></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="ukeyword">키워드 </label>
                                                        <div class="col-sm-12">
                                                            <input type="text" class="form-control" id="ukeyword" name="ukeyword" data-role="tagsinput">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" id="inqueryid" />
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="justify-content-start d-flex">
                                                        <a href="javascript:void(0);" class="btn btn-success btn-sm me-2 btn_inqueryupdate"><i class="mdi mdi-content-save-move"></i>  저장하기 </a>
                                                        <a href="javascript:void(0);" class="btn btn-danger btn-sm btn_inqueryback"><i class="mdi mdi-backspace-outline"></i> 돌아가기</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <div class="justify-content-start d-flex">
                                                <a href="javascript:void(0);" class="btn btn-primary btn-sm btn_inqueryshow me-2"><i class="mdi mdi-content-save-move"></i> 등록하기</a>
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

<!--company modal content -->
<!--div id="companymodal" class="modal fade" role="dialog" aria-labelledby="companyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="head_title">기업명 추가하기</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body" id="company_info">
                <form class="needs-validation p-3" id="CompanyForm" novalidate>            
                    <div class="mb-3 row">
                        <label class="form-label" for="mcompany">기업명 <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="mcompany" name="mcompany" required>
                    </div>
                </form>
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary waves-effect waves-light btn-sm btn_companyadd"> 등록</button>
                
            </div>
        </div>
    </div>
</div-->

<!--stock status modal content -->
<div id="stockstatusmodal" class="modal fade" role="dialog" aria-labelledby="stockstatusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">상태 선택</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body" id="mstock_info">
                <form class="needs-validation" id="StockstatusForm" novalidate>            
                    <div class="mb-3 row">
                        <label class="form-label" for="smstatus">상태 <span class="text-danger">*</span></label>
                        <select class="form-control select_stock_status" id="smstatus" name="smstatus" required>
                            <option value="Active">이체완료</option>
                            <option value="Pending">진행중</option>
                            <option value="Canceled">취소</option>
                            <option value="Exit">EXIT</option>
                        </select>
                    </div>
                </form>
                <input type="hidden" id="mstockid" />
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary waves-effect waves-light btn-sm btn_stock_change"> 등록</button>
                
            </div>
        </div>
    </div>
</div>

<!--method modal content -->
<div id="methodmodal" class="modal fade" role="dialog" aria-labelledby="methodModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">전송방법 선택</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body" id="method_info">
                <form class="needs-validation" id="MethodForm" novalidate>             
                    <div class="mb-3 row">
                        <label class="form-label" for="smethod">전송방법 <span class="text-danger">*</span></label>
                        <select class="form-control select_method" id="smethod" name="smethod" required>
                            <option value="Email">이메일</option>
                            <option value="Post">우편</option>
                            <option value="SMS"> 확인 문자</option>
                            <option value="Messenger">카카오톡</option>
                        </select>
                    </div>
                </form>
                <input type="hidden" id="filetransferid" />
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary waves-effect waves-light btn-sm btn_transfer_change"> 등록</button>
            </div>
        </div>
    </div>
</div>

<!--post status modal content -->
<div id="poststatusmodal" class="modal fade" role="dialog" aria-labelledby="postModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">상태 선택</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body" id="poster_info">
                <form class="needs-validation" id="PostStatusForm" novalidate>            
                    <div class="mb-3 row">
                        <label class="form-label" for="pmstatus">상태 <span class="text-danger">*</span></label>
                        <select class="form-control select_status_post" id="pmstatus" name="pmstatus" required>
                            <option value="Delivered">발송완료</option>
                            <option value="Pending">발송중</option>
                            <option value="Returned">반송됨</option>
                            <option value="Canceled">취소</option>
                        </select>
                    </div>
                </form>
                <input type="hidden" id="mpostid" />
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary waves-effect waves-light btn-sm btn_post_change"> 등록</button>
            </div>
        </div>
    </div>
</div>

<!--visit status modal content -->
<div id="visitstatusmodal" class="modal fade" role="dialog" aria-labelledby="visitModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">상태 선택</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body" id="mvisit_info">
                <form class="needs-validation" id="VisitStatusForm" novalidate>            
                    <div class="mb-3 row">
                        <label class="form-label" for="mvstatus">상태 <span class="text-danger">*</span></label>
                        <select class="form-control select_visit_status" id="mvstatus" name="mvstatus" required>
                            <option value="Active">완료</option>
                            <option value="Pending">진행중</option>
                            <option value="Canceled">취소</option>
                        </select>
                    </div>
                </form>
                <input type="hidden" id="mvisitid" />
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary waves-effect waves-light btn-sm btn_visit_change"> 등록</button>
            </div>
        </div>
    </div>
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
.total_inveted .border {
    padding: 10px;
    border-radius: 5px;
}
</style>

@stop
@section('javascript')

<script src="{{ asset('assets/libs/select2/js/select2.full.min.js') }}"></script>
<!-- Required datatable js -->

<script src="{{ asset('assets/libs/slick-master/slick/slick.min.js') }}"></script>
<script src="{{ asset('assets/libs/lightbox/dist/js/lightbox.min.js') }}"></script>

@include('admin.layouts.defaults.js')

<script type="text/javascript">
$(document).ready(function(){
    $('.carousel').slick({
        speed: 500,
        infinite: false,
        slidesToShow: 5,
        slidesToScroll: 3,
        autoplay: false,
        autoplaySpeed: 2000,
        dots:false,
        centerMode: false,
    });
});

$(".deleteAllStockTransferBtn").click(function(){
    var checkstr = confirm("Are you sure?");
    if(checkstr == true){
        var count = $('input[name="stock_transfer_id[]"]:checked').length;
        if(count > 0){
            $("#deleteAllStockTransferForm").submit();  
        }else{
            toastr.error('Please first slected any stock.','Opps!');
            return false;
        }
    }
});
$(".deleteAllFileTransferBtn").click(function(){
    var checkstr = confirm("Are you sure?");
    if(checkstr == true){
        var count = $('input[name="file_transfer_id[]"]:checked').length;
        if(count > 0){
            $("#deleteAllFileTransferForm").submit();  
        }else{
            toastr.error('Please first slected any file.','Opps!');
            return false;
        }
    }
});
$(".deleteAllPostDeliveryBtn").click(function(){
    var checkstr = confirm("Are you sure?");
    if(checkstr == true){
        var count = $('input[name="post_delivery_id[]"]:checked').length;
        if(count > 0){
            $("#deleteAllPostDeliveryForm").submit();  
        }else{
            toastr.error('Please first slected any post delivery.','Opps!');
            return false;
        }
    }
});
$(".deleteAllVisitRecordsBtn").click(function(){
    var checkstr = confirm("Are you sure?");
    if(checkstr == true){
        var count = $('input[name="visit_record_id[]"]:checked').length;
        if(count > 0){
            $("#deleteAllVisitRecordsForm").submit();  
        }else{
            toastr.error('Please first slected any visit record.','Opps!');
            return false;
        }
    }
});
$(".deleteAllInqueriesBtn").click(function(){
    var checkstr = confirm("Are you sure?");
    if(checkstr == true){
        var count = $('input[name="inqueries_id[]"]:checked').length;
        if(count > 0){
            $("#deleteAllInqueriesForm").submit();  
        }else{
            toastr.error('Please first slected any inqueries.','Opps!');
            return false;
        }
    }
});


$(document).ready(function() {
    $(".select2").select2({width:'100%'});
    $(".select_stock_status").select2({width: '100%',dropdownParent: $("#mstock_info")});
    $(".select_method").select2({width: '100%',dropdownParent: $("#method_info")});
    $(".select_status_post").select2({width: '100%',dropdownParent: $("#poster_info")});
    $(".select_visit_status").select2({width: '100%',dropdownParent: $("#mvisit_info")});
});
$('a[role=tab]').click(function(){
    if (this.id == "stocktab") {
        localStorage.setItem("tabitem", '1');
    } else if (this.id == "filetab") {
        localStorage.setItem("tabitem", '2');
    } else if (this.id == "postertab") {
        localStorage.setItem("tabitem", '3');
    } else if (this.id == "visittab") {
        localStorage.setItem("tabitem", '4');
    } else if (this.id == "inquerytab") {
        localStorage.setItem("tabitem", '5');
    }
    
});
var tabactive = localStorage.getItem("tabitem");

if (tabactive == null || tabactive == '1') {
    $("#stocktab").addClass('active');
    $("#filetab").removeClass('active');
    $("#postertab").removeClass('active');
    $("#visittab").removeClass('active');
    $("#inquerytab").removeClass('active');

    $("#stocktransaction").addClass('active');
    $("#filetransfer").removeClass('active');
    $("#poster").removeClass('active');
    $("#visitrecord").removeClass('active');
    $("#inquery").removeClass('active');

} else if (tabactive == '2') {
    $("#filetab").addClass('active');
    $("#stocktab").removeClass('active');
    $("#postertab").removeClass('active');
    $("#visittab").removeClass('active');
    $("#inquerytab").removeClass('active');

    $("#stocktransaction").removeClass('active');
    $("#filetransfer").addClass('active');
    $("#poster").removeClass('active');
    $("#visitrecord").removeClass('active');
    $("#inquery").removeClass('active');
} else if (tabactive == '3'){
    $("#postertab").addClass('active');
    $("#stocktab").removeClass('active');
    $("#filetab").removeClass('active');
    $("#visittab").removeClass('active');
    $("#inquerytab").removeClass('active');

    $("#stocktransaction").removeClass('active');
    $("#filetransfer").removeClass('active');
    $("#poster").addClass('active');
    $("#visitrecord").removeClass('active');
    $("#inquery").removeClass('active');
} else if (tabactive == '4'){
    $("#visittab").addClass('active');
    $("#stocktab").removeClass('active');
    $("#filetab").removeClass('active');
    $("#postertab").removeClass('active');
    $("#inquerytab").removeClass('active');

    $("#stocktransaction").removeClass('active');
    $("#filetransfer").removeClass('active');
    $("#poster").removeClass('active');
    $("#visitrecord").addClass('active');
    $("#inquery").removeClass('active');
} else if (tabactive == '5'){
    $("#inquerytab").addClass('active');
    $("#stocktab").removeClass('active');
    $("#filetab").removeClass('active');
    $("#postertab").removeClass('active');
    $("#visittab").removeClass('active');

    $("#stocktransaction").removeClass('active');
    $("#filetransfer").removeClass('active');
    $("#poster").removeClass('active');
    $("#visitrecord").removeClass('active');
    $("#inquery").addClass('active');
}
$('.phoneMask').mask('(999)-9999-9999');
$('#edited_date').datepicker({
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
$('#stockdate').datepicker({
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
$('#ustockdate').datepicker({
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
$('#startdate').datepicker({
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
$('#enddate').datepicker({
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
$('#ustartdate').datepicker({
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
$('#uenddate').datepicker({
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
$('.timepicker').timepicker({
    showInputs: false
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
$("#starttime").val("07:00 AM");
$("#starttime").timepicker('setTime', "07:00 AM");
$("#endtime").val("01:00 PM");
$("#endtime").timepicker('setTime', "01:00 PM");

$("#visittype").on('change', function(e){
    if ($("#visittype").val() == "T") {
        $("#starttime").prop('disabled', false);
        $("#endtime").prop('disabled', false);
        $("#startdate").prop('disabled', false);
        $("#enddate").prop('disabled', true);
        $("#starttime").val("07:00 AM");
        $("#starttime").timepicker('setTime', "07:00 AM");
        $("#endtime").val("01:00 PM");
        $("#endtime").timepicker('setTime', "01:00 PM");
    } else if ($("#visittype").val() == "A") {
        $("#starttime").prop('disabled', true);
        $("#endtime").prop('disabled', true);
        $("#startdate").prop('disabled', false);
        $("#enddate").prop('disabled', false);
        $("#starttime").val("");
        $("#starttime").timepicker('setTime', "");
        $("#endtime").val("");
        $("#endtime").timepicker('setTime', "");

    } else if ($("#visittype").val() == "E") {
        $("#starttime").prop('disabled', false);
        $("#endtime").prop('disabled', true);
        $("#startdate").prop('disabled', false);
        $("#enddate").prop('disabled', true);
        $("#endtime").val("");
        $("#endtime").timepicker('setTime', "");
    }
});
$("#uvisittype").on('change', function(e){
    if ($("#uvisittype").val() == "T") {
        $("#ustarttime").prop('disabled', false);
        $("#uendtime").prop('disabled', false);
        $("#ustartdate").prop('disabled', false);
        $("#uenddate").prop('disabled', true);
        $("#ustarttime").val("07:00 AM");
        $("#ustarttime").timepicker('setTime', "07:00 AM");
        $("#uendtime").val("01:00 PM");
        $("#uendtime").timepicker('setTime', "01:00 PM");
    } else if ($("#uvisittype").val() == "A") {
        $("#ustarttime").prop('disabled', true);
        $("#uendtime").prop('disabled', true);
        $("#ustartdate").prop('disabled', false);
        $("#uenddate").prop('disabled', false);
        $("#ustarttime").val("");
        $("#ustarttime").timepicker('setTime', "");
        $("#uendtime").val("");
        $("#uendtime").timepicker('setTime', "");

    } else if ($("#uvisittype").val() == "E") {
        $("#ustarttime").prop('disabled', false);
        $("#uendtime").prop('disabled', true);
        $("#ustartdate").prop('disabled', false);
        $("#uenddate").prop('disabled', true);
        $("#uendtime").val("");
        $("#uendtime").timepicker('setTime', "");
    }
});
$('#uvisitdate').datepicker({
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
$('#filedate').datepicker({
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
$('#ufiledate').datepicker({
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
$('#postdate').datepicker({
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
$('#upostdate').datepicker({
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
$("#stock_datatable").DataTable({
    aaSorting: [[ 0, "desc" ]],
    searching: true, 
    paging: false, 
    info: false,
});
$("#file_datatable").DataTable({
    searching: true, 
    paging: false, 
    info: false,
});
$("#poster_datatable").DataTable({
    searching: true, 
    paging: false, 
    info: false,
});
$("#visit_datatable").DataTable({
    searching: true, 
    paging: false, 
    info: false,
});
$("#inquery_datatable").DataTable({
    searching: true, 
    paging: false, 
    info: false,
});
</script>
<script type="text/javascript">

$("#formstock").hide();
$("#upformstock").hide();
$("#formfiletransfer").hide();
$("#upformfiletransfer").hide();
$("#formposter").hide();
$("#upformposter").hide();
$("#formvisit").hide();
$("#upformvisit").hide();
$("#forminquery").hide();
$("#upforminquery").hide();
$(".btn_stockshow").on('click', function(e) {
    $("#quantity").val('');
    $("#stockPrice").val('');
    $("#invested").val('');
    $("#stockdate").val('');
    $("#company").val('');
    $('#company').trigger('change');
    $("#stock_status").val('');
    $('#stock_status').trigger('change');
    $(this).hide();
    $("#formstock").show();
    $("#stock_list").hide();
    $("#upformstock").hide();
});
$(".btn_transfershow").on('click', function(e) {
    $("#filedate").val('');
    $("#fileName").val('');
    $("#filecompany").val('');
    $('#filecompany').trigger('change');
    $("#filemethod").val('');
    $('#filemethod').trigger('change');
    $(this).hide();
    $("#formfiletransfer").show();
    $("#filetransfer_list").hide();
    $("#upformfiletransfer").hide();
});
$(".btn_postershow").on('click', function(e){
    $("#postdate").val('');
    $("#postcity").val('');
    $('#postcity').trigger('change');
    $("#postcompany").val('');
    $('#postcompany').trigger('change');
    $("#post_status").val('');
    $('#post_status').trigger('change');
    $(this).hide();
    $("#formposter").show();
    $("#poster_list").hide();
    $("#upformposter").hide();
});
$(".btn_posterback").on('click', function(e){
    $("#formposter").hide();
    $("#poster_list").show();
    $(".btn_postershow").show();
    $("#upformposter").hide();
});
$(".btn_stockback").on('click', function(e){
    $("#formstock").hide();
    $("#stock_list").show();
    $(".btn_stockshow").show();
    $("#upformstock").hide();
});
$(".btn_fileback").on('click', function(e){
    $("#formfiletransfer").hide();
    $("#filetransfer_list").show();
    $(".btn_transfershow").show();
    $("#upformfiletransfer").hide();
});
$(".btn_posteradd").on('click', function(e){
    var form = $("#posterForm");
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
        url: `/admin/posterfrom`,
        data: {
            date: $("#postdate").val(),
            company: $("#postcompany").val(),
            city: $("#postcity").val(),
            address: $("#postaddress").val(),
            status: $("#post_status").val(),
            customer: '{{$customer->id}}'

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
})
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
$("#uquantity").keyup(function () {
    var total = $('#ustockPrice').val();
    $("#uquantity").each(function (index, item) {
        var temp = parseFloat($(item).val());
        if (isNaN(temp))
            temp = 1
        total = total * temp;
    });
    $("#uinvested").val(total);
});
$("#ustockPrice").keyup(function () {
    var total = $('#uquantity').val();
    $("#ustockPrice").each(function (index, item) {
        var temp = parseFloat($(item).val());
        if (isNaN(temp))
            temp = 1
        total = total * temp;
    });
    $("#uinvested").val(total);
});
$(".btn_stockadd").on('click', function(e){
    var form = $("#stockForm");
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
        url: `/admin/stockform`,
        data: {
            date: $("#stockdate").val(),
            company: $("#company").val(),
            status: $("#stock_status").val(),
            stockPrice: $("#stockPrice").val(),
            quantity: $("#quantity").val(),
            invested: $("#invested").val(),
            customerId: '{{$customer->id}}'

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
});
$(".stock_edit").on('click', function(e){
    $("#formstock").hide();
    $(".btn_stockshow").hide();
    $("#stock_list").hide();
    $("#upstockid").val($(this).data('id'));
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: `/admin/getstock`,
        data: {
            upstock: $("#upstockid").val(),
        },
        type: 'POST',
        success: function(data) {               
            $("#uquantity").val(data.quantity);
            $("#ustockPrice").val(data.stockPrice);
            $("#uinvested").val(data.invested);
            $("#ustockdate").val(data.stockdate);
            $("#ucompany").val(data.company);
            $('#ucompany').trigger('change');
            $("#ustock_status").val(data.stock_status);
            $('#ustock_status').trigger('change');
            $("#upformstock").show();
        },
        error: function(data){
            console.log(data);
        }
    });
    
    
});
$(".poster_edit").on('click', function(e){
    $("#formposter").hide();
    $(".btn_postershow").hide();
    $("#poster_list").hide();
    $("#postid").val($(this).data('id'));
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: `/admin/getposterfrom`,
        data: {
            postid: $("#postid").val(),
        },
        type: 'POST',
        success: function(data) {               
            $("#upostdate").val(data.date);
            $("#upostcity").val(data.city);
            $('#upostcity').trigger('change');
            $("#upostcompany").val(data.company);
            $('#upostcompany').trigger('change');
            $("#upostaddress").val(data.address);
            $("#upost_status").val(data.status);
            $('#upost_status').trigger('change');
            $("#upformposter").show();
        },
        error: function(data){
            console.log(data);
        }
    });
});
$(".btn_posterupdate").on('click', function(e){
    
    var form = $("#upposterForm");
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
        url: `/admin/updateposterfrom`,
        data: {
            date: $("#upostdate").val(),
            company: $("#upostcompany").val(),
            city: $("#upostcity").val(),
            address: $("#upostaddress").val(),
            status: $("#upost_status").val(),
            customer: '{{$customer->id}}',
            postid: $("#postid").val()

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
});
$(".btn_stockupdate").on('click', function(e){
    var form = $("#upstockForm");
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
        url: `/admin/updatestockform`,
        data: {
            date: $("#ustockdate").val(),
            company: $("#ucompany").val(),
            status: $("#ustock_status").val(),
            stockPrice: $("#ustockPrice").val(),
            quantity: $("#uquantity").val(),
            invested: $("#uinvested").val(),
            customerId: '{{$customer->id}}',
            upstockid: $("#upstockid").val()

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
});
$(".btn_fileadd").on('click', function(e){
    var form = $("#transferForm");
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
        url: `/admin/filefrom`,
        data: {
            date: $("#filedate").val(),
            company: $("#filecompany").val(),
            method: $("#filemethod").val(),
            fileName: $("#fileName").val(),
            customerId: '{{$customer->id}}'

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
});
$(".transfer_edit").on('click', function(e){
    $("#formfiletransfer").hide();
    $("#filetransfer_list").hide();
    $(".btn_transfershow").hide();
    $("#fileid").val($(this).data('id'));
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: `/admin/getfiletransfer`,
        data: {
            fileid: $("#fileid").val(),
        },
        type: 'POST',
        success: function(data) {               
            $("#ufiledate").val(data.date);
            $("#ufileName").val(data.fileName);
            $("#ufilecompany").val(data.company);
            $('#ufilecompany').trigger('change');
            $("#ufilemethod").val(data.method);
            $('#ufilemethod').trigger('change');
            $("#upformfiletransfer").show();
        },
        error: function(data){
            console.log(data);
        }
    });

});
$(".btn_fileupdate").on('click', function(e){
    var form = $("#uptransferForm");
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
        url: `/admin/updatetransferform`,
        data: {
            date: $("#ufiledate").val(),
            company: $("#ufilecompany").val(),
            method: $("#ufilemethod").val(),
            fileName: $("#ufileName").val(),
            customerId: '{{$customer->id}}',
            fileid: $("#fileid").val()

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
})

/*$(".companymanage").on('click', function(e){
    $("#companymodal").modal('show');
});
$(".btn_companyadd").on('click', function(e){
    var form = $("#CompanyForm");
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
        url: `/admin/new-company`,
        data: {
            company: $("#mcompany").val()
        },
        type: 'POST',
        success: function(data) {
            if (data.status == "Success") {
                var newOption = new Option(data.companyName, data.id, true, true);
                $(".companytab").append(newOption).trigger('change');
                $("#companymodal").modal('hide');
            } 
        },
        error: function(data){
            console.log(data);
        }
   });
});*/
$(document).on('click','.isMessageSent', function(){
    var that = $(this);
    var is_sent = that.val();
    var stock_id = that.data('id');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type : 'POST',
        url : ajaxUrl+'/admin/isSentCheck',
        data:{
            'is_sent':is_sent,
            'stock_id':stock_id
        },
        success:function(response){
            that.val(is_sent==1 ? 0 : 1);
            toastr.success(response.message, 'Success')
        },
        error: function(status, error) {
            var errors = JSON.parse(status.responseText);
            if (status.status == 401 || status.status == 400) {
                $.each(errors.error, function(i, v) {
                    toastr.error(v[0], 'Opps!');
                });
            }else{
                toastr.error(errors.message, 'Opps!');
            }
        }
    });
});
$(".btn_visitshow").on('click', function(e){
    $("#startdate").val('');
    $("#enddate").val('');
    $("#title").val('');
    $("#visit_status").val('');
    $('#visit_status').trigger('change');
    $("#visittype").val('T');
    $('#visittype').trigger('change');
    $("#visitnote").val('');
    $(this).hide();
    $("#formvisit").show();
    $("#visit_list").hide();
    $("#upformvisit").hide();
});
$(".btn_visitadd").on('click', function(e){
    var form = $("#visitForm");
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
        url: `/admin/visitform`,
        data: {
            startdate: $("#startdate").val(),
            enddate: $("#enddate").val(),
            starttime: $("#starttime").val(),
            endtime: $("#endtime").val(),
            title: $("#title").val(),
            visittype: $("#visittype").val(),
            backgroundColor: $("#backgroundColor").val(),
            note: $("#visitnote").val(),
            status: $("#visit_status").val(),
            type: $("#visittype").val(),
            customer: '{{$customer->id}}'

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
});

$(".btn_visitupdate").on('click', function(e){
    var form = $("#upvisitForm");
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
        url: `/admin/updatevisitform`,
        data: {
            startdate: $("#ustartdate").val(),
            enddate: $("#uenddate").val(),
            title: $("#utitle").val(),
            starttime: $("#ustarttime").val(),
            endtime: $("#uendtime").val(),
            status: $("#uvisit_status").val(),
            type: $("#uvisittype").val(),
            note: $("#uvisitnote").val(),
            backgroundColor: $("#ubackgroundColor").val(),
            customer: '{{$customer->id}}',
            visitid: $("#visitid").val()

        },
        type: 'POST',
        success: function(data) {
            console.log("data", data)
            if (data.status == "Success") {
                location.reload();
            } 
        },
        error: function(data){
            console.log(data);
        }
    });
});

$(".visit_edit").on('click', function(e){
    $("#formvisit").hide();
    $("#visit_list").hide();
    $(".btn_visitshow").hide();
    $("#visitid").val($(this).data('id'));
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: `/admin/getvisitform`,
        data: {
            visitid: $("#visitid").val(),
        },
        type: 'POST',
        success: function(data) {  
            if (data.type == "T") {
                $("#ustartdate").val(data.startdate);
                $("#uenddate").val("");
                $("#utitle").val(data.title);
                $("#ustarttime").val(data.starttime);
                $("#ustarttime").timepicker('setTime', data.starttime);
                $("#uendtime").val(data.endtime);
                $("#uendtime").timepicker('setTime', data.endtime);
                $("#uvisit_status").val(data.status);
                $('#uvisit_status').trigger('change');
                $("#uvisittype").val(data.type);
                $('#uvisittype').trigger('change');
                $("#uvisitnote").val(data.note);
                $("#ubackgroundColor").val(data.backgroundColor);
                $("#uenddate").prop('disabled', true);
            } else if (data.type == "A") {
                $("#ustartdate").val(data.startdate);
                $("#uenddate").val(data.enddate);
                $("#utitle").val(data.title);
                $("#ustarttime").val("");
                $("#ustarttime").timepicker('setTime', "");
                $("#uendtime").val("");
                $("#uendtime").timepicker('setTime', "");
                $("#uvisit_status").val(data.status);
                $('#uvisit_status').trigger('change');
                $("#uvisittype").val(data.type);
                $('#uvisittype').trigger('change');
                $("#uvisitnote").val(data.note);
                $("#ubackgroundColor").val(data.backgroundColor);
                $("#ustarttime").prop('disabled', true);
                $("#uendtime").prop('disabled', true);
            } else if (data.type == "E") {
                $("#ustartdate").val(data.startdate);
                $("#uenddate").val("");
                $("#utitle").val(data.title);
                $("#ustarttime").val(data.starttime);
                $("#ustarttime").timepicker('setTime', data.starttime);
                $("#uendtime").val("");
                $("#uendtime").timepicker('setTime', "");
                $("#uvisit_status").val(data.status);
                $('#uvisit_status').trigger('change');
                $("#uvisittype").val(data.type);
                $('#uvisittype').trigger('change');
                $("#uvisitnote").val(data.note);
                $("#ubackgroundColor").val(data.backgroundColor);
                $("#ustarttime").prop('disabled', false);
                $("#uendtime").prop('disabled', true);
                $("#uenddate").prop('disabled', true);
            }        
            $("#upformvisit").show();
        },
        error: function(data){
            console.log(data);
        }
    });
});
$(".btn_visitback").on('click', function(e){
    $("#formvisit").hide();
    $("#visit_list").show();
    $(".btn_visitshow").show();
    $("#upformvisit").hide();
});
$(".btn_inqueryshow").on('click', function(e){
    $("#note").val('');
    $("#keyword").val('');
    $("#forminquery").show();
    $("#upforminquery").hide();
    $("#inquery_list").hide();
    $(this).hide();
});
$(document).on('keydown', ".bootstrap-tagsinput input", function(event){
    if ( event.which == 13 ) {
        $(this).blur();
        $(this).focus();
        return false;
    }
});
$(".btn_inqueryadd").on('click', function(e){
    var form = $("#inqueryForm");
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
        url: `/admin/inqueryform`,
        data: {
            note: $("#note").val(),
            keyword: $("#keyword").val(),
            customer: '{{ $customer->id }}'

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
});
$(".inquery_edit").on('click', function(e) {
    $("#forminquery").hide();
    $("#inquery_list").hide();
    $(".btn_inqueryshow").hide();
    $("#inqueryid").val($(this).data('id'));
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: `/admin/getinqueryform`,
        data: {
            inqueryid: $("#inqueryid").val(),
        },
        type: 'POST',
        success: function(data) {     
            console.log($("#ukeyword").tagsinput());        
            $("#unote").val(data.note);
            $("#ukeyword").tagsinput('removeAll');
            $("#ukeyword").tagsinput('add',data.keyword);
            $("#upforminquery").show();
        },
        error: function(data){
            console.log(data);
        }
    });
});
$(".btn_inqueryback").on('click', function(e){
    $("#upforminquery").hide();
    $("#forminquery").hide();
    $("#inquery_list").show();
    $(".btn_inqueryshow").show();
});
$(".btn_inqueryupdate").on('click', function(e) {
    var form = $("#upinqueryForm");
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
        url: `/admin/updateinqueryform`,
        data: {
            note: $("#unote").val(),
            keyword: $("#ukeyword").val(),
            customer: '{{$customer->id}}',
            inqueryid: $("#inqueryid").val()

        },
        type: 'POST',
        success: function(data) {
            console.log("data", data)
            if (data.status == "Success") {
                location.reload();
            } 
        },
        error: function(data){
            console.log(data);
        }
    });
});

$(document).on('click', "a.btn_stock_status", function() {
    $("#smstatus").val($(this).data('status'));
    $('#smstatus').trigger('change');
    $("#mstockid").val($(this).data('id'));
    $("#stockstatusmodal").modal('show');
});
$(".btn_stock_change").on('click', function(e){
    var form = $("#StockstatusForm");
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
        url: `/admin/stock-status`,
        data: {
            status: $("#smstatus").val(),
            stockid: $("#mstockid").val()
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
    
});
$(document).on('click', "a.btn_file_method", function() {
    $("#smethod").val($(this).data('method'));
    $('#smethod').trigger('change');
    $("#filetransferid").val($(this).data('id'));
    $("#methodmodal").modal('show');
});
$(".btn_transfer_change").on('click', function(e){
    var form = $("#MethodForm");
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
        url: `/admin/file-transfer-method`,
        data: {
            method: $("#smethod").val(),
            fileid: $("#filetransferid").val()
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
    
});
$(document).on('click', "a.btn_post_status", function() {
    $("#pmstatus").val($(this).data('status'));
    $('#pmstatus').trigger('change');
    $("#mpostid").val($(this).data('id'));
    $("#poststatusmodal").modal('show');
});
$(".btn_post_change").on('click', function(e){
    var form = $("#StockstatusForm");
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
        url: `/admin/post-status`,
        data: {
            status: $("#pmstatus").val(),
            postid: $("#mpostid").val()
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
    
});
$(document).on('click', "a.btn_visit_status", function() {
    $("#mvstatus").val($(this).data('status'));
    $('#mvstatus').trigger('change');
    $("#mvisitid").val($(this).data('id'));
    $("#visitstatusmodal").modal('show');
});
$(".btn_visit_change").on('click', function(e){
    var form = $("#VisitStatusForm");
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
        url: `/admin/visit-status`,
        data: {
            status: $("#mvstatus").val(),
            visitid: $("#mvisitid").val()
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
    
});

$(document).on("click", ".customer_edit_memo", function(e) {
    $("body").toggleClass("right-memo-enabled");
    $("#memo_customer_id").val('{{$customer->id}}');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: `/admin/memo-list`,
        data: {
            customer_id: '{{$customer->id}}',
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
    

}); 
$(document).on("click", "body", function(e) {
    0 < $(e.target).closest(".customer_edit_memo, .right-bar-memo").length || $("body").removeClass("right-memo-enabled")
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