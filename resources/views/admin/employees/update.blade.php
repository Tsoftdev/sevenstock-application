@extends('admin.layouts.app')
@section('title', 'Employee Edit')
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
                                <h4>Employee Edit</h4>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="justify-content-end d-flex">
                                <a href="{{ route('admin.employees') }}" class="btn btn-primary btn-sm" style="margin-bottom: 0px!important;">
                                <i class="mdi mdi-backspace-outline"></i> Back</a>
                            </div>
                        </div>
                    </div>
                    <hr class="my-auto flex-grow-1 mt-1 mb-3" style="height:1px;">
                    <form class="form-horizontal mt-4 needs-validation" method="POST" action="{{ route('admin.employee.update', ['id' => $employee->id]) }}" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="name">Admin Name</label>
                                    <input type="text" class="form-control" style="height:38px;" id="name" name="name" value="{{ $employee->name }}">
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="email">ID</label>
                                    <input type="text" class="form-control" style="height:38px;" id="email" name="email" value="{{ $employee->email }}" required>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="passencrypt">Password</label>
                                    <input type="password" class="form-control" style="height:38px;" id="passencrypt" name="passencrypt" value="{{ $employee->passencrypt }}" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="company">기업 <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <select class="form-control select2" id="company" name="company" required>
                                            <option value="">기업 ..</option>
                                            @foreach($companies as $company)
                                                <option value="{{$company->id}}" @if($company->id == $employee->companyId) selected @endif>{{$company->companyName}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="role">Position</label>
                                    <input type="text" class="form-control" style="height:38px;" id="position" name="position" value="{{ $employee->position }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="justify-content-start d-flex">
                                    <button type="sumbit" name="submit" value="submit" class="btn btn-primary btn-sm">
                                        <i class="mdi mdi-content-save-move"></i> Create
                                        <i class="fa fa-spinner fa-spin" style="display:none;"></i>
                                    </button>
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