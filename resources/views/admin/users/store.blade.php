@extends('admin.layouts.app')
@section('title', 'Admin Store')
@section('css')
<link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
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
                                <h4>Admin Store</h4>
                            </div>
                        </div>
                        <!--div class="col-md-6">
                            <div class="justify-content-end d-flex">
                                <a href="" class="btn btn-primary btn-sm" style="margin-bottom: 0px!important;">
                                <i class="mdi mdi-content-save-move"></i> Memo</a>
                            </div>
                        </div-->
                    </div>
                    <hr class="my-auto flex-grow-1 mt-1 mb-3" style="height:1px;">
                    <form class="form-horizontal mt-4 needs-validation" method="POST" action="{{ route('admin.user.store') }}" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="name">Admin Name</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="email">ID</label>
                                    <input type="text" class="form-control" id="email" name="email" required>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="role">Role</label>
                                    <select class="form-control select2" id="role" name="role" required>
                                        @foreach($roles as $role)
                                            <option value="{{$role->id}}">{{$role->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="justify-content-start d-flex">
                                    <button type="sumbit" name="submit" value="submit" class="btn btn-success btn-sm me-2">
                                        <i class="mdi mdi-content-save-move"></i> Create
                                        <i class="fa fa-spinner fa-spin" style="display:none;"></i>
                                    </button>
                                    <a href="{{ url('admin/users') }}" class="btn btn-danger btn-sm" style="margin-bottom: 0px!important;">
                                        <i class="mdi mdi-backspace-outline"></i> back</a>
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
<script>
    $(".select2").select2({width: '100%'});
</script>
@endsection