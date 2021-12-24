@extends('admin.layouts.app')
@section('title', 'SMS')
@section('content')
@include('admin.layouts.defaults.css')
<style>
.custom_card_1, .custom_card_2{
    min-height: 650px;
}
.custom_card_3{
    min-height: 590px;
}
input.add_a_picture {
    opacity: 0;
    width: 0;
}
.modal-body .btn-secondary {
    color: #fff;
    background-color: #B3B3B3;
    border-color: #B3B3B3;
    color: #4e4949;
}
.user-all-list-count-sec .card-body,
.more-count-sec .card-body{
    padding: 20px 20px;
}
.selected-user-sec .card-body,
.sms-record-sec .card-body{
    padding: 0;
}
.user-all-list-count-sec .user-all-list,
.more-count-sec .spl-more {
    display: flex;
    justify-content: space-around;
    align-items: center;
}
.user-all-list-count-sec .user-all-list p,
.more-count-sec .spl-more p {
    margin-bottom: 0;
}
.user-all-list-count-sec .user-all-list span.refresh {
    font-size: 26px;
}
.user-all-list-count-sec .user-all-list span.refresh i {
    transform: rotate(18deg) scaleX(-1);
}
.p0{
    padding: 0;
}
.nav-fill .nav-item .nav-link, .nav-justified .nav-item .nav-link {
    width: 100%;
    height: 43px;
    padding-top: 12px;
}
.nav-pills .nav-link, .nav-pills .show>.nav-link {
    color: #000;
    background-color: #fff;
}
.filterModal .nav-pills .nav-link.active, .filterModal .nav-pills .show>.nav-link {
    color: #fff;
    background-color: #7a6fbe;
}
.filterModal .nav-pills .nav-link, .filterModal .nav-pills .show>.nav-link {
    color: #fff;
    background-color: #000;
}
.custome-form-control{
    resize: none;
    border: unset;
    min-height: 290px !important;
    background-color: #EFEFF0;
    border-radius: 5px;
    padding: 10;
}
.custome-form-control:focus{
    background-color: #EFEFF0 !important;
}
img#output {
    width: 100%;
    margin-bottom: 19px;
}
.row_btns {
    padding: 0;
}
.row_btns a {
    padding: 7px;
}
.select2-container .select2-selection--single {
    border: 1px solid #ced4da !important;
    height: 34px !important;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #444;
    line-height: 32px !important;
}
.select2-container--default .select2-selection--single .select2-selection__arrow b{
    top: 54% !important;
}
.btn-ctn a {
    padding: .15rem .4rem;
}
.selectUserCountBtn {
    padding-left: 16px;
}
.resetCount {
    padding-right: 16px;
}
.date_agree {
    width: 20px;
    height: 20px;
    margin-left: 5px;
    margin-top: 6px;
}
div#sms_customer_datatable_filter input{
    display: block;
    width: 100%;
    padding: .375rem .75rem;
    font-size: .8125rem;
    font-weight: 400;
    line-height: 1.5;
    color: #5b626b;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    border-radius: .25rem;
    -webkit-transition: border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;
    transition: border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;
}
table.dataTable.no-footer {
    border-bottom: 1px solid #e9ecef;
}
.sms_customer_datatable_previous {
    color: #6c757d;
    pointer-events: none;
    background-color: #fff;
    border-color: #ced4da;
}
.form-check-input {
    height: 22px;
    width: 22px;
}
</style>
<link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<div class="container-fluid">
    <div class="row">
        
        <div class="col-md-3 user-all-list-count-sec">
            <div class="card custom_card_1">
                <div class="card-body">
                    {{ Form::open(array('route' => 'admin.file.store','files' => true,'id'=>'form')) }}
                    <div class="row mb-2">
                        <!--div class="col-md-7" style="padding-right: .5rem;">
                            {{ Form::select('category_id',$categories->pluck('name','id')->prepend('전체 전체고객 기록함', ''),null,['class'=>'form-control category','id'=>'category_id']) }}
                        </div-->
                        <div class="col-md-12">
                            <button type="button" class="btn btn-primary waves-effect waves-light titleSection w-100">등록</button>   
                        </div>
                        <!--div class="col-md-2 p0">
                            <button type="button" class="btn btn-outline-primary waves-effect waves-light categorySection">수정</button>   
                        </div-->
                    </div>
                    <div class="title_wrapper d-none">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <input type="text" name="name" id="title_name" class="form-control" placeholder="Title">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    {{ Form::textarea('description',null,['class'=>'form-control','id'=>'title_description','rows'=>'3','placeholder'=>'Content']) }}
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-7">
                                <input type="hidden" name="title_id" id="title_id" value="0">
                                <button type="submit" class="btn btn-primary waves-effect waves-light w-100 exp_heading">Submit <i class="fa fa-spinner fa-spin" style="display:none;"></i></button>
                            </div>
                            <div class="col-md-5">
                                <button type="button" class="btn btn-secondary waves-effect waves-light w-100 hideTitleWrapper">Cancel</button>
                            </div>
                        </div>
                    </div>
                    {{ Form::close() }}
                    <div class="title_listing_wrapper">
                        @foreach($titles as $file)
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="text-primary">{{ $file->name }}</label>
                                </div>
                            </div>
                            <div class="row">
                                <?php 
                                $string = strip_tags($file->description);
                                if (strlen($string) > 100) {
                                    $stringCut = substr($string, 0, 100);
                                    $endPoint = strrpos($stringCut, ' ');
                                    $string = $endPoint ? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                                    $string .= '... <a href="javascript:void(0)" class="show-more">show more</a>';
                                }
                                ?>
                                <div class="col-md-12 fileDescription">
                                    <p class="half-desc"><?php echo $string; ?></p>
                                    <p class="full-desc" style="display: none"><span>{{ strip_tags($file->description) }}</span><a href="javascript:void(0)" class="show-less">show less</a></p>
                                </div>
                                <div class="col-md-12 text-right btn-ctn mt-3">
                                    <a class="btn btn-outline-secondary btn-sm mb-2 copy-btn">
                                        <i class="fas fa-copy"></i>
                                    </a>
                                    <a class="btn btn-outline-secondary btn-sm mb-2 editFile" data-data="{{ $file }}" data-category_id="{{ $file->categories ? ($file->categories->first() ? $file->categories->first()->id : '') : ''}}">
                                        <i class="fas fa-pencil-alt text-success"></i>
                                    </a>
                                    <a href="{{ route('admin.file.delete',$file->id) }}" class="btn btn-outline-secondary btn-sm mb-2" title="Delete" onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash text-danger"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="category_wrapper d-none">
                        {{ Form::open(array('route'=>'admin.category.store','files'=>true,'id'=>'form2')) }}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <input type="text" name="name" id="category_name" class="form-control" placeholder="전체고객 기록함">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-7">
                                <input type="hidden" name="categoryId" id="categoryId" value="0">
                                <button type="submit" class="btn btn-outline-primary waves-effect waves-light w-100">등록 <i class="fa fa-spinner fa-spin" style="display:none;"></i></button>
                            </div>
                            <div class="col-md-5">
                                <button type="button" class="btn btn-secondary waves-effect waves-light w-100 hideCategoryWrapper">Cancel</button>
                            </div>
                        </div>
                        {{ Form::close() }}
                        @foreach($categories as $category)
                            <hr>
                            <div class="row">
                                <div class="col-md-8">{{ $category->name }}</div>
                                <div class="col-md-4">
                                    <a class="btn btn-outline-secondary btn-sm mb-2 editCategory" data-data="{{ $category }}">
                                        <i class="fas fa-pencil-alt text-success"></i>
                                    </a>
                                    <a href="{{ route('admin.category.delete',$category->id) }}" class="btn btn-outline-secondary btn-sm mb-2" title="Delete" onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash text-danger"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
        <div class="col-md-3 more-count-sec">
            <div class="card custom_card_2">
                {{ Form::open(array('url' => '', 'files' => true,'id'=>'sendSmsForm')) }}
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 p0">
                            <div class="spl-more">
                                <p>
                                    <span class="text-primary"> 확인 문자</span> 
                                    {{ isset($smsRemain['SMS_CNT']) ? $smsRemain['SMS_CNT'] : 0 }}
                                </p>
                                <p>
                                    <span class="text-primary"> LMS</span> 
                                    {{ isset($smsRemain['LMS_CNT']) ? $smsRemain['LMS_CNT'] : 0 }}
                                </p>
                                <p>
                                    <span class="text-primary"> MMS</span> 
                                    {{ isset($smsRemain['MMS_CNT']) ? $smsRemain['MMS_CNT'] : 0 }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-9 selectUserCountBtn">
                            <button id="selectuser" data-bs-toggle="modal" data-bs-target="#offcanvasRight" type="button" class="btn btn-danger waves-effect waves-light w-100">
                                <span class="selectedUser">0</span> 명 선택됨
                            </button>
                        </div>
                        <div class="col-md-3 resetCount">
                            <a href="javascript:void(0)" class="btn btn-outline-danger waves-effect waves-light float-end reset">리셋</a>
                        </div>
                    </div>
                    <div class="row mt-2 mb-2">
                        <div class="col-md-2 p0 text-center">
                            <input type="checkbox" name="is_scheduled" class="date_agree">
                        </div>
                        <div class="col-md-5" style="padding-left: 0;padding-right: 0.4rem;">
                            <input type="text" name="date" placeholder="Date" class="form-control" id="date">
                        </div>
                        <div class="col-md-5" style="padding-left: 0;">
                            <input type="time" name="time" class="form-control" style="padding: .375rem 0.2rem;">
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <textarea class="form-control custome-form-control" name="message" id="message" name="message" id="message"></textarea>
                              <div id="the-count">
                                <span id="current">0</span>
                                <span>/ </span>
                                <span id="maximum">90</span>
                              </div>
                        </div>
                    </div>
                  
                    <div class="row">
                        <div class="col-md-12">
                            <img id="output"/>
                            <label class="btn btn-primary waves-effect waves-light w-100 mb-4">
                                <input type="file" name="picture" class="add_a_picture" id="picture" onchange="loadFile(event)">
                                <span class="">사진 업로드</span>
                            </label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" id="send_message" class="btn btn-primary btn-lg waves-effect waves-light w-100">전송하기<i class="fa fa-spinner fa-spin" style="display:none;"></i></button>
                        </div>
                    </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>


        <div class="col-md-6 selected-user-sec">
            <ul class="nav nav-pills nav-justified mb-3" role="tablist">
                <li class="nav-item waves-effect waves-light">
                    <a class="nav-link {{ !request()->filled('period') ? 'active' : ''  }}" data-bs-toggle="tab" href="#user_selected" role="tab">
                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                        <span class="d-none d-sm-block"><b>유저 선택</b></span>
                    </a>
                </li>
                <li class="nav-item waves-effect waves-light">
                    <a class="nav-link {{ request()->filled('period') ? 'active' : ''  }}" data-bs-toggle="tab" href="#sms_record" role="tab">
                        <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                        <span class="d-none d-sm-block"><b>전송 결과</b></span>
                    </a>
                </li>
            </ul>
            <div class="card custom_card_3">
                <div class="tab-content">
                    <div class="tab-pane {{ !request()->filled('period') ? 'active' : ''  }} p-3" id="user_selected" role="tabpanel">
                        <div class="card-body">

                            {{ Form::open(array('url' => 'admin/messages', 'method'=>'get', 'id'=>'customer_filter_form')) }}
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            {{ Form::select('group_id',$customerGroups,request()->group_id,['class'=>'form-control search_filter','id'=>'group_filter'])}}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <select name="company_id" id="company_filter" class="form-control select2 search_filter">
                                                <option value="">기업</option>
                                                @foreach($companies as $company)
                                                    <option value="{{ $company->id}}" {{ request()->company_id==$company->id ? 'selected' : ''}}>
                                                        {{ $company->companyName}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            {{ Form::select('city_id',$cities,request()->city_id,['class'=>'form-control select2 search_filter','id'=>'city_filter']) }}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <input type="hidden" name="is_filter" value="yes">
                                            <button type="button" class="btn btn-primary w-100 selectCheckboxAll" data-ck="1"> 전체 선택</button>
                                        </div>
                                    </div>
                                </div>
                                
                            {{ Form::close() }}
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <h5><b>고객목록</b></h5>
                                </div>
                                <div class="col-md-4 text-right">
                                    <select class="btn btn-outline-dark waves-effect waves-light getPageLength">
                                        <option value="100">100</option>
                                        <option value="200">200</option>
                                        <option value="500">500</option>
                                        <option value="1000">1000</option>
                                    </select>
                                </div>
                                <div class="">
                                    <table id="sms_customer_datatable" class="table table-bordered" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <input type="checkbox" class="form-check-input selectCheckboxAll">
                                                </th>
                                                <th>이름</th>
                                                <th> 지역</th>
                                                <th>전화번호</th>
                                                <th>담당자</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane p-3 {{ request()->filled('period') ? 'active' : ''  }}" id="sms_record" role="tabpanel">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6"></div>
                                <div class="col-md-3">
                                    <!-- <a class="btn btn-outline-secondary mb-2">100+</a> -->
                                </div>
                                <div class="col-md-3">
                                    <form class="form-inline">
                                        <div class="form-group">
                                            <label>Period:</label>
                                            <input type="text" name="period" id="date1" value="{{ request()->period }}" class="form-control" onchange="this.form.submit()">
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>날짜</th>
                                                    <th>Type</th>
                                                    <th>Sender</th>
                                                    <th>확인 문자 Count</th>
                                                    <th>상태</th>
                                                    <th>Fail Count</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($smsRecords as $smsRecord)
                                                <tr>
                                                    <td>{{ $smsRecord->date->format('Y.m.d') }}</td>
                                                    <td>{{ $smsRecord->type }}</td>
                                                    <td>{{ $smsRecord->sender }}</td>
                                                    <td>{{ $smsRecord->sms_count }}</td>
                                                    <td>{{ $smsRecord->status }}</td>
                                                    <td>{{ $smsRecord->fail_count }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-end">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" tabindex="-1">Previous</a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">Next</a>
                                    </li>
                                </ul>
                            </nav> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Selected customer listing modal-->
<!--div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">전체  고객목록</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="px-3">
        <button type="button" class="btn btn-danger waves-effect waves-light">
            <span class="selectedUser">0</span> 명 선택됨
        </button>
    </div>
    <div class="offcanvas-body">
        <table class="table">
            <thead>
                <th>이름</th>
                <th>전화번호</th>
                <th>액션</th>
            </thead>
            <tbody id="contact_list">
            </tbody>
        </table>
        <button type="submit" class="btn btn-primary waves-effect waves-light w-100" data-bs-dismiss="offcanvas" aria-label="Close">종료</button>
    </div>
</div-->

<!-- Manage Modal -->
<div class="modal fade come-from-modal right" id="offcanvasRight" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">전체  고객목록</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="px-3 pt-3">
                <button type="button" class="btn btn-danger waves-effect waves-light">
                    <span class="selectedUser">0</span> 명 선택됨
                </button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <th>이름</th>
                        <th>전화번호</th>
                        <th>액션</th>
                    </thead>
                    <tbody id="contact_list">
                    </tbody>
                </table>
                <button type="submit" class="btn btn-primary waves-effect waves-light w-100" data-bs-dismiss="offcanvas" aria-label="Close">종료</button>
            </div>
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
<script>
    $(".search_filter").select2({width: '100%'});
    $('#date, #date1').datepicker({
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
</script>
@include('admin.layouts.defaults.js')
<script>
  var loadFile = function(event) {
    var output = document.getElementById('output');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function() {
      URL.revokeObjectURL(output.src) // free memory
    }
  };
</script>

@endsection