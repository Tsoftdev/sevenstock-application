@extends('admin.layouts.app')
@section('title', 'Employees')
@section('css')
<link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<!-- DataTables -->
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<!-- Responsive datatable examples -->
<link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" /> 
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="page-title-custom">
                                <h4>Employee management</h4>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="justify-content-end d-flex">
                                <div class="button-items">
                                    <div class="dropdown d-inline-block pt-1 mt-1" style="display: flex !important;">
                                         <a href="{{ route('admin.employee.add') }}" class="btn btn-primary btn-sm"><i class="mdi mdi-plus"></i> Add </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive pt-1">
                        <table id="datatable_button" class="table table-bordered align-middle dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Name</th>
                                    <th>ID</th>
                                    <th>Password</th>
                                    <th>Company</th>
                                    <th>Position</th>
                                    <th>Action</th>
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
<!-- Required datatable js -->
<script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<!-- Responsive examples -->
<script src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
<!-- Sweet Alerts js -->
<script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<script>
    col_targets = [0, 1, 5];
    var visit_table = $('#datatable_button').DataTable({
        aaSorting: [[ 1, "desc" ]],
        lengthChange:!1,
        processing: true,
        serverSide: true,
        searching: false, 
        paging: false, 
        info: false,
        "ajax": {
            "url": "{{ route('admin.employees') }}",
            "data": function ( d ) {
                
            }
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
        "columns":[
            {"data":"date"},
            {"data":"name"},
            {"data":"email"},
            {"data":"passencrypt"},
            {"data":"company"},
            {"data":"position"},
            {"data":"action"}
        ],
        "createdRow": function( row, data, dataIndex ) {
            $( row ).find('td:eq(2)').attr('class', 'bg-light text-primary fw-bold');
        },
    });
    $(document).on("click", ".btn_employ_delete", function(e) {
        var eid = $(this).data('id');
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
                    url: "{{ route('admin.employee.delete') }}",
                    data: {
                        emid: eid
                    },
                    type: 'POST',
                    success: function(data) {
                        if (data.success == true) {
                            toastr.success(data.msg);
                            location.reload();
                        } 
                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            }
        });
    });
</script>
@endsection