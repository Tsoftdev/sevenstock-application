@extends('admin.layouts.app')
@section('title', '기업관리')
@section('css')
<link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<!-- DataTables -->
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<!-- Responsive datatable examples -->
<link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" /> 
@endsection
@section('content')
<style>
.form-check-input {
    height: 22px;
    width: 22px;
}
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="page-title-custom">
                                <h4>기업관리</h4>
                            </div>
                        </div>
						
                        <div class="col-md-8">
                            <div class="justify-content-end d-flex">
                                <form method="POST" accept-charset="UTF-8" id="mass_delete_form" action="{{ url ('admin/companydelete') }}">
                                    @csrf
                                    <input id="selected_rows" name="selected_rows" type="hidden">
                                    <input class="btn btn-secondary btn-sm mt-1 me-2" id="delete-selected" type="submit" value="Delete" style="display:none;">
                                </form>
                                <a href="{{ url('admin/add_companies') }}" class="btn btn-primary btn-sm mt-1">
                                    <i class="mdi mdi-content-save-move"></i> 등록하기
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive pt-1">
                        <table id="datatable" class="table table-bordered align-middle dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th class="align-middle">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" id='select-all-row'><span></span>
                                        </label>
                                    </th>
                                    <th>날짜</th>
                                    <th>기업</th>
                                    <th>CEO 이름</th>
                                    <th>컨설팅 시작날짜</th>
                                    <th>재계약한 날짜</th>
                                    <th>컨설팅 종료</th>
                                    <th></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
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
<!-- Sweet Alerts js -->
<script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<script type="text/javascript">
    col_targets = [0, 2, 3];
    var company_table = $('#datatable').DataTable({
        aaSorting: [[ 1, "desc" ]],
        lengthChange:!1,
        processing: true,
        serverSide: true,
        searching: false, 
        paging: false, 
        info: false,
        ajax: {
            "url": "/admin/companies",
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
            "targets": col_targets,
            "orderable": false,
            "searchable": false
        } ],
        columns:[
            {"data":"mass_delete"},
            {"data":"date"},
            {"data":"companyName"},
            {"data":"ownerName"},
            {"data":"consultdate"},
            {"data":"reviewdate"},
            {"data":"enddate"},
            {"data":"action"}
        ],
        "createdRow": function( row, data, dataIndex ) {
            $( row ).find('td:eq(2)').attr('class', 'bg-light text-primary fw-bold');
        },
        
    });
    $(document).on('click', '#delete-selected', function(e){
        e.preventDefault();
        var selected_rows = [];
        var i = 0;
        $('.form-check-input:checked').each(function () {
            selected_rows[i++] = $(this).val();
        }); 
        
        if(selected_rows.length > 0){
            $('input#selected_rows').val(selected_rows);
            Swal.fire({
                title: "Are you Sure?",
                icon: "warning",
                showCancelButton:!0,
                confirmButtonColor:"#7a6fbe",
                cancelButtonColor:"#f46a6a",
            }).then((willDelete) => {
                if (willDelete.isConfirmed) {
                    $('form#mass_delete_form').submit();
                }
            });
        }  
    });
</script>
@endsection