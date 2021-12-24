@extends('admin.layouts.app')
@section('title', 'Role')
@section('css')
<!-- DataTables -->
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<!-- Responsive datatable examples -->
<link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" /> 
@endsection
@section('content')

<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="page-title-custom">
                                <h4>Role management</h4>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="justify-content-end d-flex">
                                <div class="button-items">
                                    <div class="dropdown d-inline-block pt-1 mt-1" style="display: flex !important;">
                                         <a href="{{ url ('admin/add_roles') }}" class="btn btn-primary btn-sm"> 등록하기</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive pt-1">
                        <table id="datatable" class="table table-bordered align-middle dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Role</th>
                                    <th>Display Name</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($roles as $role)
                                <tr>
                                    <td>{{ $role->name }}</td>
                                    <td>{{ $role->display_name }}</td>
                                    <td>{{ $role->description }}</td>
                                    <td>
                                        <a href="{{ url('admin/edit_roles', $role->id) }}" class="btn btn-sm btn-primary"><i class="mdi mdi-circle-edit-outline"></i></a>
                                        <a href="javascript:void(0);" class="btn btn-sm btn-danger role_delete" data-id="{{$role->id}}"><i class="mdi mdi-delete-sweep-outline"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--role delete upload modal content -->
<div id="roledeletemodal" class="modal fade" role="dialog" aria-labelledby="roleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="delModalLabel">Delete Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <h5>Are you sure you want to delete this record?</h5>
                <input type="hidden" id="del_id" value="-1">        
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary waves-effect waves-light btn-sm del_confirm">OK</button>
                
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
@stop
@section('javascript')
<!-- Required datatable js -->
<script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<!-- Responsive examples -->
<script src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
<script>
    col_targets = [3];
    $('#datatable').DataTable({
        searching: false, 
        paging: false, 
        info: false,
        ordering: false,
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
            "searchable": false
        } ],
    });
    $(".role_delete").on('click', function(e){
        $("#del_id").val($(this).data('id'));
        $("#roledeletemodal").modal('show');
    });
    $(".del_confirm").on('click', function(event){
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `/admin/role-delete`,
            data: {
                'roleid': $("#del_id").val(),
            },
            type: 'POST',
            success: function (data) {
                if (data.success) {
                    toastr.success(data.msg);
                    location.reload(); 
                }
            }
        });
        $('#deletModal').modal('hide');
    });
</script>
@endsection