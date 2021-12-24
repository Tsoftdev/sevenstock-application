@extends('admin.layouts.app')
@section('title', '주식이체 수정')
@section('css')
<link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<style>
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

</style>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="page-title-custom">
                                <h4>주식이체 수정</h4>
                            </div>
                        </div>
                        <div class="mb-3 mt-1 col-md-6">
                            <div class="justify-content-end d-flex">
                                <a href="{{ url('admin/user-record/stocks') }}" class="btn btn-primary btn-sm"> 돌아가기</a>
                            </div>
                        </div>
                    </div>
                    <hr class="my-auto flex-grow-1 mt-1 mb-3" style="height:1px;">
                    <form class="form-horizontal mt-4 needs-validation" method="POST" action="{{ url('admin/user-record/edit_stock/'.$stock->id) }}" novalidate enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="date">날짜 <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="date" name="date" value="{{date('Y.m.d', strtotime($stock->date))}}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="company">기업 <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <select class="form-control select2" id="company" name="company" required>
                                            <option value="">기업 ..</option>
                                            @foreach($companies as $company)
                                                <option value="{{$company->id}}" @if($company->id == $stock->companyId) selected @endif>{{$company->companyName}}</option>
                                            @endforeach
                                        </select>
                                    
                                        <!--a href="javascript:void(0);" id="companymanage" class="btn btn-primary input-group-text">추가</a-->
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="stock_status">상태 <span class="text-danger">*</span></label>
                                    <select class="form-control select2" id="stock_status" name="stock_status" required>
                                        <option value="">상태..</option>
                                        <option value="Active" @if($stock->status == "Active") selected @endif>이체완료</option>
                                        <option value="Pending" @if($stock->status == "Pending") selected @endif>진행중</option>
                                        <option value="Canceled" @if($stock->status == "Canceled") selected @endif>취소</option>
                                        <option value="Exit" @if($stock->status == "Exit") selected @endif>Exit</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="stockPrice">주가금액 <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="stockPrice" name="stockPrice" value="{{$stock->stockPrice}}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="quantity">주식 수 <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="quantity" name="quantity" value="{{$stock->quantity}}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="invested">투자금액 <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="invested" name="invested" value="{{$stock->invested}}" required readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="customer">고객 <span class="text-danger">*</span></label>
                                    <select class="form-control select2" id="customer" name="customer" required>
                                        <option value="">고객..</option>
                                        @foreach($customers as $customer)
                                            <option value="{{$customer->id}}" @if($customer->id == $stock->userId) selected @endif>{{$customer->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="picture">Picture</label>
                                    <input type="file" class="form-control" id="picture" name="picture">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label>Display Picture</label>
                                    <div style="border: 1px solid #ddd; padding: 5px;">
                                        <img src="{{ $stock->picture }}" width="340">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="justify-content-start d-flex">
                                    <button type="sumbit" name="submit" value="submit" class="btn btn-success btn-sm m-2" style="margin-bottom: 0px!important;"><i class="mdi mdi-content-save-move"></i> 저장하기 </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!--company modal content -->
<!--div id="companymodal" class="modal fade" role="dialog" aria-labelledby="methodModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="head_title">기업명 추가하기</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body" id="company_info">
                <form class="needs-validation p-3" id="CompanyForm" novalidate>
                    <meta name="csrf-token" content="{{ csrf_token() }}" />              
                    <div class="mb-3 row">
                        <label class="form-label" for="mcompany">기업명 <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="mcompany" name="mcompany" required>
                    </div>
                </form>
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary waves-effect waves-light btn-sm btn_companyadd">Add</button>
                
            </div>
        </div>
    </div>
</div-->
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
    $(".select2").select2({width: '100%'});
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
    /*$("#companymanage").on('click', function(e){
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
                    console.log(data.id, data.companyName);
                    var newOption = new Option(data.companyName, data.id, true, true);
                    $("#company").append(newOption).trigger('change');
                    $("#companymodal").modal('hide');
                } 
            },
            error: function(data){
                console.log(data);
            }
       });
    })*/
</script>
@endsection