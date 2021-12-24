@extends('admin.layouts.app')
@section('title', 'Blog Content')
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

  <div class="row">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <form id="blog-form" class="needs-validation" enctype="multipart/form-data" novalidate data-id="">
            <div class="row mb-3 gx-3">
              <div class="col-md-6">
                <div class="row gx-1">
                  <div class="col-md-8">
                    <select class="form-select blog-tags" name="tag" required>
                      <option disabled selected>Tags</option>
                      @foreach ($blog_tags as $tag)
                      <option value="{{$tag['id']}}">{{$tag['keyword']}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-md-4 d-grid">
                    <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Manage</button>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                @php
                $date_now = Carbon\Carbon::now()->format('Y-m-d');
                @endphp
                <input class="form-control" type="date" value="{{$date_now}}" id="date" name="date" required>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-12">
                <input class="form-control" name="title" type="text" value="" id="title" placeholder="Title" required>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-12">
                <textarea id="description" name="description" required></textarea>
              </div>
            </div>
            <div class="row">
              <input type="file" class="imagepicker" name="blog_images[]" />
            </div>
            <hr>
            <div class="row">
              <div class="col-md-12 text-end">
                <button type="submit" id="add-blog-btn" class="btn btn-primary waves-effect waves-light">Save</button>
                <button type="submit" id="update-blog-btn" class="btn btn-warning waves-effect waves-light d-none">Update</button>
                <a href="#" id="cancel-blog-btn" class="btn btn-danger waves-effect waves-light d-none">Cancel</a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-6">

      <div class="card">
        <div class="card-body">
          <!-- Select Tags -->
          <div class="mb-4">
            <select class="form-control select2 blog-tags" id="tag-filter">
              <option disabled selected>Tag Name</option>
              <option value="">All</option>
              @foreach ($blog_tags as $tag)
              <option value="{{$tag['id']}}">{{$tag['keyword']}}</option>
              @endforeach
            </select>
          </div>
          <!-- /Select Tags -->
          <div class="row g-0">
            <div class="col-md-12">
              <table id="dt-blog" class="table dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                  <tr>
                    <th>Thumbnail</th>
                    <th>Content</th>
                    <th>Tag</th>
                  </tr>
                </thead>

                <tbody>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>



</div>
</div>

<!-- right offcanvas -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel" style="width: 300px">
  <div class="offcanvas-header">
    <h5 id="offcanvasRightLabel">Manage Tags</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body pt-0">
    <form id="tag-form" class="needs-validation" novalidate>
      <div class="row gx-2 mb-3">
        <div class="col-md-5">
          <input class="form-control" type="text" id="tag-keyword" name="keyword" placeholder="Keyword" required>
        </div>
        <div class="col-md-5">
          <input class="form-control form-control-color mw-100" type="color" value="#7a6fbe" id="tag-color" name="color">
        </div>
        <div class="col-md-2 d-grid">
          <button class="btn btn-success waves-effect waves-light" type="submit">
            <i class="fas fa-plus tag-loader"></i>
            <i class="fas fa-spinner tag-loader fa-pulse me-1 spinner d-none"></i>
          </button>
        </div>
      </div>
    </form>
    <div class="row">
      <div class="col-md-12">
        <table id="dt-blog-tags" class="table dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
          <thead>
            <tr>
              <th>Keyword</th>
              <th></th>
            </tr>
          </thead>

          <tbody>
          </tbody>
        </table>
      </div>
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

<!--tinymce js-->
<script src="{{ asset('assets/libs/tinymce/tinymce.min.js') }}"></script>

<!-- Required datatable js -->
<script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<!-- Responsive examples -->
<script src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>


<script>
  $(document).ready(function() {

    // blog form buttons
    const saveBlogBtn = $('#add-blog-btn');
    const updateBlogBtn = $('#update-blog-btn');
    const cancelBlogBtn = $('#cancel-blog-btn');

    // initialize plugin with defaults
    $(".imagepicker").fileinput({
      showUpload: false,
      showCancel: false,
      layoutTemplates: {
        footer: ''
      }
    });

    0 < $("#description").length && tinymce.init({
      selector: "textarea#description",
      image_class_list: [{
        title: 'img-responsive',
        value: 'img-responsive'
      }, ],
      height: 500,
      setup: function(editor) {
        editor.on('init change', function() {
          editor.save();
        });
      },
      plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste imagetools"
      ],
      toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image ",

      image_title: true,
      automatic_uploads: true,
      images_upload_url: '/admin/blog-upload',
      file_picker_types: 'image',
      file_picker_callback: function(cb, value, meta) {
        var input = document.createElement('input');
        input.setAttribute('type', 'file');
        input.setAttribute('accept', 'image/*');
        input.onchange = function() {
          var file = this.files[0];

          var reader = new FileReader();
          reader.readAsDataURL(file);
          reader.onload = function() {
            var id = 'blobid' + (new Date()).getTime();
            var blobCache = tinymce.activeEditor.editorUpload.blobCache;
            var base64 = reader.result.split(',')[1];
            var blobInfo = blobCache.create(id, file, base64);
            blobCache.add(blobInfo);
            cb(blobInfo.blobUri(), {
              title: file.name
            });
          };
        };
        input.click();
      }
    });


    // Tags Datatable
    var tableTags = $("#dt-blog-tags").DataTable({
      dom: "<'search-bar' f>rt",
      paging: false,
      ajax: "{{ url('admin/blog-tags') }}",
      language: {
        search: "",
        searchPlaceholder: "Search tags"
      },
      aaSorting: [],
      columns: [{
          data: 'keyword',
          render: function(data, type, row, meta) {
            return `<span class="badge text-uppercase fw-bold" style="padding: 5px; background-color: ${row['color']}">${data}</span>`;
          }
        },
        {
          data: 'id',
          className: 'dt-right',
          render: function(data) {
            return `<button type="button" class="btn btn-sm btn-danger waves-effect waves-light del-tag" data-id="${data}"><i class="fas fa-trash-alt"></i></button>`;
          }
        }
      ],
      columnDefs: [{
        orderable: false,
        targets: [0, 1]
      }],
      drawCallback: function(settings) {
        $("#dt-blog-tags thead").remove();
      }
    });

    // Submit tag
    $('#tag-form').submit(function(e) {
      e.preventDefault();

      // Loader
      $('.fa-plus').addClass('d-none');
      $('.fa-spinner').removeClass('d-none');

      // Get form data
      const form = $(this)[0];

      // Create form data
      const formData = new FormData(form);

      // Ajax request
      $.ajax({
        url: '/admin/blog-tags',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        processData: false,
        contentType: false,
        data: formData,
        success: function(response) {

          if (response.status == 'ok') {

            form.reset();

            $('#tag-form').removeClass('was-validated');

            // Loader
            $('.tag-loader.fa-plus').removeClass('d-none');
            $('.tag-loader.fa-spinner').addClass('d-none');

            tableTags.ajax.reload();

            $('.blog-tags').append(`<option value="${response.data.id}">${response.data.keyword}</option>`)
          } else {
            // Loader
            $('.tag-loader.fa-plus').removeClass('d-none');
            $('.tag-loader.fa-spinner').addClass('d-none');
          }
        }
      });

    });

    // Delete tag
    $('body').on('click', '.del-tag', function() {
      const id = $(this).data('id');

      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this and all blog posts related to this tag will be untagged.",
        icon: 'warning',
        showCancelButton: !0,
        confirmButtonColor: '#34c38f',
        cancelButtonColor: '#f46a6a',
        confirmButtonText: 'Yes, delete it!',
      }).then(function(t) {
        t.value &&
          // Ajax request
          $.ajax({
            url: '/admin/blog-tags/' + id,
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'DELETE',
            success: function(response) {

              if (response.status == 'ok') {
                Swal.fire(
                  'Deleted!',
                  'Tag has been deleted.',
                  'success'
                );
                tableTags.ajax.reload();
                tableblog.ajax.reload();
                $(".blog-tags option[value='" + id + "']").remove();
              }
            }
          });
      });
    });


    // blog Datatable
    var tableblog = $("#dt-blog").DataTable({
      dom: "rtp",
      ajax: "{{ url('admin/get-blog') }}",
      aaSorting: [],
      columns: [{
          data: 'images',
          render: function(data, type, row, meta) {
            return `<img src="${data[0]}" alt="" class="img-fluid">`;;
          }
        },
        {
          data: 'title',
          render: function(data, type, row, meta) {
            let tag = '';
            if (row.tag_id != 0) {
              tag =
                `<span class="badge text-uppercase" style="background-color: ${row.tag.color}">${row.tag.keyword}</span>`;
            } else {
              tag = `<strong><small>(Untagged)</small></strong>`;
            }
            return `<div class="row">
                      <div class="col-md-8">
                        <h5 class="mb-0">${row.title}</h5>
                        <span class="badge bg-dark">${row.date}</span>
                        ${tag}
                      </div>
                      <div class="col-md-4 text-end">
                        <a href="#" type="button" class="btn btn-sm btn-info waves-effect waves-light edit-blog" data-id="${row.id}"><i class="fas fa-edit"></i></a>
                        <button type="button" class="btn btn-sm btn-danger waves-effect waves-light del-blog" data-id="${row.id}"><i class="fas fa-trash-alt"></i></button>
                      </div>
                      <div class="col-md-12">
                      ${row.description.length > 100 ? row.description.substring(0,100) + "..." : row.description}
                      </div>
                    </div>`;
          }
        },
        {
          data: 'tag_id',
          visible: false,
          render: function(data) {
            return data;
          }
        }
      ],
      columnDefs: [{
        orderable: false,
        targets: [0, 1]
      }],
      drawCallback: function(settings) {
        $("#dt-blog thead").remove();
      }
    });


    // Filter blog
    $('body').on('change', '#tag-filter', function() {
      const tag = $(this).val();

      if ((tag != '') || (tag != null)) {
        tableblog.column(2).search(tag).draw();
      }
    });


    // blog form submit
    $('body').on('submit', '#blog-form', function(e) {
      e.preventDefault();

      // Get form data
      const form = $(this)[0];

      // Create form data
      const formData = new FormData(form);

      // blog ID - If updating blog
      const blogID = $(this).data('id');

      // Ajax request
      $.ajax({
        url: '/admin/blog' + ((blogID) ? '/' + blogID : ''),
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        type: 'POST',
        processData: false,
        contentType: false,
        data: formData,
        success: function(response) {

          if (response.status == 'ok') {

            form.reset();

            $("#images-picker").empty();

            $('#blog-form').removeClass('was-validated');

            toastr.success(response.message);

            tableblog.ajax.reload();

            if (blogID) {
              // Change buttons on the form
              saveBlogBtn.removeClass('d-none');
              updateBlogBtn.addClass('d-none');
              cancelBlogBtn.addClass('d-none');

              // Remove in blog id
              $('#blog-form').data('id', '');
            }

          } else {

            let errors = '';
            if (response.data.tag) {
              errors += `<li>${response.data.tag[0]}</li>`;
            }
            if (response.data.date) {
              errors += `<li>${response.data.date[0]}</li>`;
            }
            if (response.data.title) {
              errors += `<li>${response.data.title[0]}</li>`;
            }
            if (response.data.description) {
              errors += `<li>${response.data.description[0]}</li>`;
            }
            if (response.data.blog_images) {
              errors += `<li>${response.data.blog_images[0]}</li>`;
            }

            toastr.error(`<ul class="m-0">${errors}</ul>`, response.message);


          }
        }
      });


    });


    // Edit blog
    $('body').on('click', '.edit-blog', function() {
      const id = $(this).data('id');

      // Change buttons on the form
      saveBlogBtn.addClass('d-none');
      updateBlogBtn.removeClass('d-none');
      cancelBlogBtn.removeClass('d-none');

      // Fill in blog id
      $('#blog-form').data('id', id);

      $.ajax({
        url: '/admin/blog/' + id + '/edit',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        success: function(response) {

          console.log(response.data);

          const blog = response.data;

          if (response.status == 'ok') {
            $('.blog-tags option[value="' + blog.tag_id + '"]').prop('selected', true);
            $('#date').val(blog.date);
            $('#title').val(blog.title);
            tinyMCE.activeEditor.setContent(blog.description);
            $('.imagepicker').fileinput('destroy');
            $('.imagepicker').fileinput({
              showUpload: false,
              showCancel: false,
              layoutTemplates: {
                footer: ''
              },
              validateInitialCount: true,
              initialPreviewAsData: true,
              initialPreview: blog.images,
            });
          }
        }
      });

    });


    // Cancel blog
    cancelBlogBtn.click(function() {

      // Change buttons on the form
      saveBlogBtn.removeClass('d-none');
      updateBlogBtn.addClass('d-none');
      cancelBlogBtn.addClass('d-none');

      // Remove in blog id
      $('#blog-form').data('id', '');

      // Reset form
      $('#blog-form')[0].reset();

    });


    // Delete blog
    $('body').on('click', '.del-blog', function() {
      const id = $(this).data('id');

      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: !0,
        confirmButtonColor: '#34c38f',
        cancelButtonColor: '#f46a6a',
        confirmButtonText: 'Yes, delete it!',
      }).then(function(t) {
        t.value &&
          // Ajax request
          $.ajax({
            url: '/admin/blog/' + id,
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'DELETE',
            success: function(response) {

              if (response.status == 'ok') {
                Swal.fire(
                  'Deleted!',
                  'Blog has been deleted.',
                  'success'
                );
                tableblog.ajax.reload();
              }
            }
          });
      });
    });

  });
</script>
@stop