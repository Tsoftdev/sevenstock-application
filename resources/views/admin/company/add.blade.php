@extends('admin.layouts.app')
@section('title', '회사 등록')
@section('css')
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="page-title-custom">
                                <h4>회사 등록</h4>
                            </div>
                        </div>
                        <div class="mb-3 mt-1 col-md-6">
                            <div class="justify-content-end d-flex">
                                <a href="{{ url('admin/companies') }}" class="btn btn-primary btn-sm"> 돌아가기</a>
                            </div>
                        </div>
                    </div>
                    <hr class="my-auto flex-grow-1 mt-1 mb-3" style="height:1px;">
                    <form class="form-horizontal mt-4 needs-validation" method="POST" action="{{ url('admin/add_companies') }}" enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="row">
                            
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="companyName">회사 <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="companyName" name="companyName" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="ownerName">CEO 이름 </label>
                                            <input type="text" class="form-control" id="ownerName" name="ownerName" autocomplete="off">
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="consultdate">컨설팅 시작날짜 </label>
                                            <input type="text" class="form-control customdatepicker" id="consultdate" name="consultdate" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="reviewdate">재계약한 날짜 </label>
                                            <input type="text" class="form-control customdatepicker" id="reviewdate" name="reviewdate" autocomplete="off">
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="enddate">컨설팅 종료 </label>
                                            <div class="input-group">
                                                <input type="text" class="form-control customdatepicker" id="enddate" name="enddate" autocomplete="off">
                                                <a href="javascript:void(0);" id="endmanage" class="btn btn-danger input-group-text">취소</a>
                                            </div>
                                        </div>
                                    </div>                                   
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="companylogo">아래를 클릭하여 로고 사진을 등록하세요 </label>
                                <div class="justify-content-center d-flex">
                                    <label class="avatar-input">
                                        <span class="logo-img">
                                            <img src="{{ asset('assets/images/company-upload.png') }}" alt="..." class="logo-img">
                                            <span class="avatar-input-icon">
                                                <i class="mdi mdi-upload mdi-24px"></i>
                                            </span>
                                        </span>
                                        <input type="file" name="companylogo" id="companylogo" class="avatar-file-picker">

                                    </label>
                                </div>
                            </div>
                            
                        </div>
                        
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="justify-content-start d-flex">
                                    <button type="sumbit" name="submit" value="submit" class="btn btn-success btn-sm m-2"><i class="mdi mdi-content-save-move"></i>  등록하기 </button>
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
<script>
    $('.customdatepicker').datepicker({
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

    });
    $("#endmanage").on('click', function(e){
        $("#enddate").val('');
    });
    function readFile(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $(input).parents('.avatar-input').find('.logo-img').attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
    $('.avatar-file-picker').on('change', function () {
         readFile(this);
    });

</script>
@endsection