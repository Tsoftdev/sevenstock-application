@extends('admin.layouts.app')
@section('title', 'Role Edit')

@section('content')
<style>
    .checkbox {
        padding-top: 7px;
        margin-top: 0;
        margin-bottom: 0;
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
                                <h4>Role Edit</h4>
                            </div>
                        </div>
                        <div class="mb-3 mt-1 col-md-6">
                            <div class="justify-content-end d-flex">
                                <a href="{{ url('admin/roles') }}" class="btn btn-primary btn-sm"> 돌아가기</a>
                            </div>
                        </div>
                    </div>
                    <hr class="my-auto flex-grow-1 mt-1 mb-3" style="height:1px;">
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <form class="form-horizontal mt-4 needs-validation" method="POST" action="{{ url('admin/edit_roles/'.$role->id) }}" novalidate>
                                @csrf
                                <div class="row mb-3">
                                    <label class="col-form-label col-md-3" for="name">Role Name<em class="text-danger">*</em></label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" id="name" name="name" value="{{$role->name}}" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-form-label col-md-3" for="display_name">Display Name</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" id="display_name" name="display_name" value="{{$role->display_name}}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-form-label col-md-3" for="description">Description</label>
                                    <div class="col-md-9">
                                        <textarea type="text" class="form-control" rows="3" id="description" name="description">{{$role->description}}</textarea>
                                    </div>
                                </div>
                                <div class="row mb-3 mt-3">
                                    <label class="col-form-label col-md-3" for="permission">Permission</label>
                                    <div class="col-md-9">
                                        <ul style="display: inline-block;list-style-type: none;padding:0;margin:0;">
                                            @foreach($permissions as $row)
                                            <li class="checkbox" style="display: inline-block; min-width: 170px;">
                                                <label class="form-check-label">
                                                    <input type="checkbox" class="permission_check form-check-input" name="permission[]" value="{{ $row->id }}" {{ in_array($row->id, $stored_permissions) ? 'checked' : '' }}> 
                                                        {{ $row->display_name }}
                                                </label>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="justify-content-start d-flex">
                                            <button type="sumbit" name="submit" value="submit" class="btn btn-success btn-sm">
                                                <i class="mdi mdi-content-save-move"></i> 등록하기
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
    </div>
</div>
@endsection