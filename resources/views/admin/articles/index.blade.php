@extends('admin.layouts.app')
@section('title', '고객 추가')

@section('css')
<link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
    	<!-- @if(session()->has('message'))
		    <div class="alert alert-success">
		        {{ session()->get('message') }}
		    </div>
		@endif -->
        <div class="col-6">
        	<div class="custom-card-body bg-gray">
        		<form id="form" action="{{ url('admin/article/store') }}" method="POST">
		            <div class="card1">
		    			<div class="row mb-3">
		            		<div class="col-md-8">
		            			{{ Form::select('tag_id',$tags->pluck('name','id')->prepend('Select Tag',''),null,['class'=>'btn btn-outline-secondary w-100 tag-btn select2','id'=>'tag_ids']) }}
				            </div>
		            		<div class="col-md-4">
		        		        <button type="button" class="btn btn-outline-secondary w-100 manage-btn" data-bs-toggle="modal" data-bs-target="#tagModal">Manage</button>
				            </div>
		            	</div>
		            </div>
		            <div class="card1">
	            	    <!--div class="row mb-3">
			            	<div class="col-md-12 mb-2">
			            		{{ Form::select('company_id',$companies->pluck('companyName','id')->prepend('Select Company',''),null,['class'=>'form-control select2','id'=>'company_id']) }}
			            	</div>
			            </div-->
			            <div class="row mb-3">
			            	<div class="col-md-12 mb-2">
			            		{{ Form::text('title',null,['class'=>'form-control','placeholder'=>'Enter title','id'=>'title']) }}
			            	</div>
			            </div>
			            <div class="row mb-3">
			            	<div class="col-md-12 mb-2">
			            		{{ Form::textarea('description',null,['class'=>'form-control','id'=>'tinymceEditor1']) }}
			            	</div>
			            </div>
			            <div class="row mb-3 img_contain">
			            	<div class="col-md-12 mb-2">
			            		{{ Form::url('website_url',null,['class'=>'form-control','id'=>'website_url','placeholder'=>'Enter website url']) }}
			            	</div>
			            </div>
			            <div class="row mb-3 img_contain">
			            	<div class="col-md-6 mb-2">
			            		{{ Form::file('image',['class'=>'form-control select_img']) }}
			            	</div>
			            	<div class="col-md-6 mb-2">
			            		{{ Form::text('created_at',null,['class'=>'form-control','id'=>'datepicker1','placeholder'=>'Choose date']) }}
			            	</div>
			            </div>
			            <div class="row mb-3 img_contain">
			            	<div class="col-md-6 mb-2">
			            		<img class="preview_img mt-2" id="preview_img" src="{{ asset('images/picture.jpg') }}" width="200" />
			            	</div>
			            	<div class="col-md-6 mb-2">
			            		{{ Form::text('name',null,['class'=>'form-control','id'=>'article_name','placeholder'=>'Enter name']) }}
			            	</div>
			            </div>
			            <div class="row mb-3 img_contain">
			            	<div class="col-md-6 mb-2">
			            		<input name="comment_on_off"  id="switch1" switch="none" value="off" type="checkbox"/>
                                <label for="switch1" data-on-label="On" data-off-label="Off"></label>
                            </div>
			            </div>
			            <div id="comment_on_off_wrapper">
			            	<div class="row mb-3 img_contain">
				            	<div class="col-md-12 mb-2">
				            		{{ Form::text('comment_title',null,['class'=>'form-control','id'=>'comment_title','placeholder'=>'Enter comment title']) }}
				            	</div>
				            </div>
				            <div class="row mb-3 img_contain">
				            	<div class="col-md-12 mb-2">
				            		{{ Form::textarea('comment_description',null,['class'=>'form-control','id'=>'comment_description','placeholder'=>'Enter comment description']) }}
				            	</div>
				            </div>
			            </div>
			            <div class="row pb-4">
			            	<div class="col-md-12 mb-2 text-right">
			            		<input type="hidden" name="article_id" id="article_id" value="0">
			            		<button type="submit" class="btn custom-btn-lg">submit <i class="fa fa-spinner fa-spin" style="display:none; font-size: 20px; vertical-align: middle;"></i></button>
			            	</div>
			            </div>
			    	</div>
		        </form>
			</div>
        </div>
        <div class="col-6">
        	<div class="custom-card-body bg-gray">
	            <div class="card1">
	            	<div class="row mb-3">
	            		<div class="col-md-2"> 
	            			@if($articles->count() > 0)
					        	<a href="javascript:void(0);" data-type="articles" class="btn btn-danger btn-sm deleteMultipleRecord mb-2"><i class="mdi mdi-trash-can-outline"></i>  Delete All</a>
					        @endif
	                	</div>
	            		<div class="col-md-{{ ($articles->count() > 0) ? '10' : '12' }}">
	            			<form action="{{ url('admin/articles') }}">
		                		{{ Form::select('tag_id',$tags->pluck('name','id')->prepend('Choose Tag',''),request()->tag_id,['class'=>'btn btn-outline-secondary w-100 tag-btn select2','onchange'=>'this.form.submit()']) }}
		                	</form>
	                	</div>
	                </div>
		        </div>
		        <div class="card1">
		        	@if($articles->count() > 0)
		        		<form id="deleteAllArticlesForm" action="{{ url('admin/delete/all/articles') }}" method="post">
				            @csrf
				        	@foreach($articles as $article)
				            	<div class="row mb-3">
			            			<div class="col-md-2" style="padding-right: 0;">
			            				<div class="article-img-wrap">
			            					<div class="article-muliple">
				            					<input name="article_id[]" id="article_id_{{ $article->id }}" value="{{ $article->id }}" class="form-check-input" type="checkbox">
				            				</div>
				                			<div class="article-img">
				                				<img src="{{ $article->image ? asset($article->image) : asset('images/picture.jpg') }}">
				                			</div>
			            				</div>
			                		</div>
			                		<div class="col-md-10">
			                			<div class="article-detail">
			                				<h5>{{ collect($article->tags->pluck('name'))->implode(', ') }}</h5>
			                				<!-- <h5>{{ $article->company ? $article->company->companyName : '' }}</h5> -->
			                				<div class="article-title">
			                					<h5><b>{{ $article->title }}</b></h5>
			                				</div>
			                				<div class="actons">
			                					<div class="date">{{ date('Y.m.d', strtotime($article->created_at)) }}</div>
			                					<div class="action">
			                						<a class="custom-btn-sm editArticle" data-data="{{ $article }}" data-img="{{ $article->image ? asset($article->image) : asset('images/picture.jpg') }}" data-tag_ids="{{ $article->tags->pluck('id') }}" href="javascript:void(0);">Edit</a>&nbsp;&nbsp;
			                						<a class="custom-btn-sm deleteRecord" href="{{ url('admin/article/delete/'.$article->id) }}">Delete</a>
			                					</div>
			                				</div>
			                			</div>
			                		</div>
				                </div>
			                @endforeach
			            </form>
		            @else
		            	<p class="text-center text-danger">You have no article</p>
		            @endif
		        </div>
		    </div>
        </div>
    </div>
</div>


<!-- Tag manage Modal -->
<div class="modal fade come-from-modal right" id="tagModal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        	<div class="modal-header">
			    <h5 class="modal-title" id="staticBackdropLabel">Tags</h5>
			    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
			    <div style="border-bottom: 2px dashed #dcdbdb;">
			        {{ Form::open(array('url' => 'admin/tag/store','files' => true,'id'=>'infoSubForm', 'class'=>'pb-4')) }}
			            <div class="row mb-2">
			                <div class="col-md-12">
			                    <label class="mb-0">Name</label>
			                    {{ Form::text('name',null,array('class'=>'form-control','id'=>'name')) }}
			                </div>
			            </div>
			            <div class="text-right">
			                <input type="hidden" name="tag_id" id="tag_id" value="0">
			                <button type="submit" class="btn btn-primary w-25">등록<i class="fa fa-spinner fa-spin" style="display:none;"></i></button>
			            </div>
			        {{ Form::close() }}
			    </div>
			    <div class="table-responsive pt-3">
			    	@if($tags->count() > 0)
			        	<a href="javascript:void(0);" data-type="tags" class="btn btn-danger btn-sm deleteMultipleRecord mb-2"><i class="mdi mdi-trash-can-outline"></i>  Delete All</a>
			        @endif
			        <form id="deleteAllTagsForm" action="{{ url('admin/delete/all/tags') }}" method="post">
			            @csrf
			            <table class="table">
			                @foreach($tags as $tag)
			                    <tr>
			                        <td>
			                            <div class="form-check">
			                                <label for="tag_id_{{ $tag->id }}">
			                                    <input name="tag_id[]" id="tag_id_{{ $tag->id }}" value="{{ $tag->id }}" class="form-check-input" type="checkbox">{{ $tag->name }}
			                                </label>
			                            </div>
			                        </td>
			                        <td class="text-right actions">
			                            <a class="editTag" data-data="{{ $tag }}" href="javascript:void(0);">
			                                <i class="mdi mdi-pencil-outline"></i>
			                            </a>&nbsp;
			                            <a class="deleteRecord" href="{{ url('admin/tag/delete/'.$tag->id) }}">
			                                <i class="mdi mdi-trash-can-outline"></i>
			                            </a>
			                        </td>
			                    </tr>
			                @endforeach
			            </table>
			        </form>
			    </div>
			</div>
        </div>
    </div>
</div>
<style type="text/css">
#comment_on_off_wrapper{
	display: none;
}
.form-check-input {
    height: 22px;
    width: 22px;
}
.deleteMultipleRecord {
	width: 100%;
    font-size: 14px;
    padding: 8px;
    margin: unset !important;
}
.article-img-wrap .article-muliple input{
	margin-right: 0;
}
.article-img-wrap {
    display: flex;
    align-items: center;
}
.form-check-input {
    height: 22px;
    width: 22px;
    margin-right: 10px;
    margin-top: -1px;
}
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
</style>

<style type="text/css">
.custom-card-body{
	min-height: 1013px;
}
.bg-gray{
	background: #ececec;
}
.tag-btn{
    font-weight: 500;
    background: #fff;
    font-size: 26px;
    padding-top: 0;
    padding-bottom: 0;
}
.manage-btn{
	background: #fff;
    font-size: 16px;
    padding-top: 0;
    padding-bottom: 0;
    height: 37px;
    border: 1px solid #ced4da;
}
.article-img img {
    width: 100%;
    max-width: 129px;
    margin-left: 5px;
    height: 80px;
    object-fit: cover;
}
.custom-btn-lg {
    background: #c4c4c4;
    border-radius: 0;
    width: 100%;
    max-width: 193px;
    font-weight: 500;
    font-size: 35px;
    padding: 2px 10px;
	color: #000;
}
.custom-btn-sm {
     background: #c4c4c4;
    border-radius: 0;
    font-weight: 500;
    font-size: 13px;
    padding: 8px 25px;
    color: #000;
}
.actons {
    display: flex;
    justify-content: space-between;
    /*margin-top: 30px;*/
}
.actons .action {
    margin-top: 5px;
}
.actons .date {
    margin-top: 13px;
}
</style>
@stop

@section('javascript')

@include('admin.layouts.defaults.js')
<script>
$(document).ready(function() {
    $('#switch1').on('change', function () {
        var value = $(this).val();
        if(value=='off'){
           $('#comment_on_off_wrapper').show();
           $(this).val('on');
        }else{
           $('#comment_on_off_wrapper').hide();
           $(this).val('off');
        }
    });
});
</script>
@endsection