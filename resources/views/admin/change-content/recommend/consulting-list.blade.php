@extends('admin.layouts.app')
@section('title', 'Consulting List')
@section('content')
<div class="container-fluid">

  @include('admin.change-content.select-menu')

  <div class="row">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          @include('admin.change-content.recommend.recommend-select-menu')
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">

        </div>
      </div>
    </div>
  </div>
</div>



</div>
</div>
@stop
@section('javascript')
<!-- Moment -->
<script src="{{ asset('assets/libs/moment/moment.js') }}"></script>
<!-- Sweet Alerts js -->
<script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

<!-- Select 2 -->
<script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
<script>
// Select menu for content change
$(function() {
  $(".select2").select2();
  $('#page-select-recommend').on('change', function() {
    var url = $(this).val();
    if (url) {
      window.location = url;
    }
    return false;
  });
});
</script>

<style>
.visitor-review:first-child {
  border-top: 2px solid #8f8f8f;
}

.visitor-review {
  padding: 20px 0 10px;
  border-top: 1px solid #cccccc;
}
</style>
@endsection
@section('css')
<!-- Sweet Alert-->
<link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />

<link href="{{ url('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<style>
.select2-container .select2-selection--single .select2-selection__arrow b {
  border-color: #adb5bd transparent transparent transparent;
  border-width: 6px 6px 0 6px;
}

.select2-container .select2-selection--single {
  background-color: #fff;
  border: 1px solid #ced4da;
  height: 38px;
}

.select2-container .select2-selection--single .select2-selection__rendered {
  line-height: 36px;
  padding-left: 12px;
  color: #5b626b;
  float: left;
}

.select2-container .select2-selection--single .select2-selection__arrow {
  height: 34px;
  width: 34px;
  right: 3px;
}
</style>
@endsection