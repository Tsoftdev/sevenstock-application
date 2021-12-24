@extends('admin.layouts.app')
@section('title', 'Banner')
@section('css')
<!-- Sweet Alert-->
<link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />

<!-- Select 2 -->
<link href="{{ url('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />

<!-- Fileinput -->
<link href="{{ url('assets/libs/fileinput/css/fileinput.min.css') }}" rel="stylesheet" type="text/css" />

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

  .search-bar label {
    display: block;
  }

  #tag-keyword,
  .search-bar input {
    margin: 0 !important;
    height: 36px;
    font-size: 12px;
  }

  #dt-blog-tags tr:first-child td,
  #dt-blog tr:first-child td {
    border: 0;
  }

  #dt-blog-tags tr td {
    padding: 10px 0;
    vertical-align: baseline;
  }

  #dt-blog tr td {
    padding: 10px 0
  }

  #dt-blog tr td:first-child {
    width: 150px;
    padding-right: 10px;
  }

  .dt-right {
    text-align: end;
  }

  .dataTables_empty {
    text-align: center;
  }

  .file-drop-zone {
    min-height: 50px;
  }

  .file-drop-zone-title {
    padding: 15px 10px;
  }
</style>
@stop
@section('content')
<div class="container-fluid">

  @include('admin.change-content.select-menu')

  <form method="POST" action="{{ url('admin/change-content/banner/store') }}" enctype="multipart/form-data">
    @csrf

    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <div class="row mb-4">
              <div class="col-md-6">
                <h6>Newsroom(Image)</h6>
              </div>
              <div class="col-md-6 text-end">
                <h6>Size: xxx-xx</h6>
              </div>
              <div class="col-md-6">
                <input type="file" class="newsroom_banner_1" name="newsroom_banner_1" />
              </div>
              <div class="col-md-6">
                <input type="file" class="newsroom_banner_2" name="newsroom_banner_2" />
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <h6>Blog(Image)</h6>
              </div>
              <div class="col-md-6">
                <input type="file" class="blog_banner_1" name="blog_banner_1" />
              </div>
              <div class="col-md-6">
                <input type="file" class="blog_banner_2" name="blog_banner_2" />
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- <div class="col-md-6">

      <div class="card">
        <div class="card-body">

        </div>
      </div>
    </div> -->

      <div class="col-md-12 mb-5">
        <button type="submit" class="btn btn-primary waves-effect waves-light">Save</button>
      </div>

    </div>
  </form>

</div>




</div>
</div>
@stop
@section('javascript')
<!-- Select 2 -->
<script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
<script>
  // Select menu for content change
  $(function() {
    $(".select2").select2();
    $('#page-select-dd').on('change', function() {
      var url = $(this).val();
      if (url) {
        window.location = url;
      }
      return false;
    });
  });
</script>

<!-- Fileinput js -->
<script src="{{ asset('assets/libs/fileinput/js/plugins/piexif.min.js') }}"></script>
<script src="{{ asset('assets/libs/fileinput/js/plugins/sortable.min.js') }}"></script>
<script src="{{ asset('assets/libs/fileinput/js/fileinput.min.js') }}"></script>

<!-- Sweet Alerts js -->
<script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>


<script>
  $(document).ready(function() {
    // initialize plugin with defaults
    $(".newsroom_banner_1").fileinput({
      showUpload: false,
      showCancel: false,
      layoutTemplates: {
        footer: ''
      },
      <?php
      if ($newsroom_banner_1 != '') {
        echo "validateInitialCount: true,
          initialPreviewAsData: true,
          initialPreview: ['" . $newsroom_banner_1->image . "']";
      }
      ?>
    });
    $(".newsroom_banner_2").fileinput({
      showUpload: false,
      showCancel: false,
      layoutTemplates: {
        footer: ''
      },
      <?php
      if ($newsroom_banner_2 != '') {
        echo "validateInitialCount: true,
          initialPreviewAsData: true,
          initialPreview: ['" . $newsroom_banner_2->image . "']";
      }
      ?>
    });
    $(".blog_banner_1").fileinput({
      showUpload: false,
      showCancel: false,
      layoutTemplates: {
        footer: ''
      },
      <?php
      if ($blog_banner_1 != '') {
        echo "validateInitialCount: true,
          initialPreviewAsData: true,
          initialPreview: ['" . $blog_banner_1->image . "']";
      }
      ?>
    });
    $(".blog_banner_2").fileinput({
      showUpload: false,
      showCancel: false,
      layoutTemplates: {
        footer: ''
      },
      <?php
      if ($blog_banner_2 != '') {
        echo "validateInitialCount: true,
          initialPreviewAsData: true,
          initialPreview: ['" . $blog_banner_2->image . "']";
      }
      ?>
    });
  });
</script>
@stop