@extends('admin.layouts.app')
@section('title', 'News Room')
@section('content')
<div class="container-fluid">

  @include('admin.change-content.select-menu')

  <div class="row">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          @include('admin.change-content.recommend.recommend-select-menu')
          <div class="row mb-3">
            <div class="col-md-6">
              <h4 class="card-title">News Inner Recommend</h4>
            </div>
            <div class="col-md-6 d-flex justify-content-end">
              <button type="button" class="add-random btn btn-sm btn-outline-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#recommendSelection">Add</button>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <table id="dt-news-random" class="table dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead style="display:none">
                  <tr>
                    <th>Thumbnail</th>
                    <th>Content</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($recommend_news_inner as $rand)
                  <tr>
                    <td width="150"><img src="{{$rand->news->images[0]}}" class="img-fluid" alt=""></td>
                    <td>
                      <div class="row">
                        <div class="col-md-8">
                          <h5 class="mb-0">{{$rand->news->title}}</h5>
                          <span class="badge bg-dark">{{$rand->news->date}}</span>
                          @if ($rand->news->tag_id != 0)
                          <span class="badge text-uppercase" style="background-color: {{$rand->news->tag->color}}">{{$rand->news->tag->keyword}}</span>
                          @else
                          <strong><small>(Untagged)</small></strong>
                          @endif
                        </div>
                        <div class="col-md-4 text-end">
                          <form method="POST" action="{{ url('admin/change-content/recommend/del-news-inner-recommend') . '/' . $rand->id }}">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-danger waves-effect waves-light del-news" data-id="${row.id}"><i class="fas fa-trash-alt"></i></button>
                          </form>
                        </div>
                        <div class="col-md-12">
                          {!!\Illuminate\Support\Str::limit(strip_tags($rand->news->description), 100, $end='...')!!}
                        </div>
                      </div>
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
</div>


<div id="recommendSelection" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Select News</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
      </div>
      <div class="modal-body">
        <table id="dt-news" class="table dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
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
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>



</div>
</div>
@stop
@section('javascript')
<!-- Moment -->
<script src="{{ asset('assets/libs/moment/moment.js') }}"></script>

<!-- Select 2 -->
<script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>

<!-- Required datatable js -->
<script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<!-- Responsive examples -->
<script src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
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
    $('#page-select-recommend').on('change', function() {
      var url = $(this).val();
      if (url) {
        window.location = url;
      }
      return false;
    });


    // News Datatable
    var tableNews = $("#dt-news").DataTable({
      dom: "<'search-bar' f>rtp",
      ajax: "{{ url('admin/get-news') }}",
      aaSorting: [],
      language: {
        search: "",
        searchPlaceholder: "Search news"
      },
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

            const desc = row.description.replace(/<\/?[^>]+(>|$)/g, "");
            return `<div class="row">
                      <div class="col-md-8">
                        <h5 class="mb-0">${row.title}</h5>
                        <span class="badge bg-dark">${row.date}</span>
                        ${tag}
                      </div>
                      <div class="col-md-4 text-end">
                      <form method="POST" class="news-list-form" action=""><button type="submit" class="btn btn-success waves-effect waves-light">Select</button>
                      <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />
                      <input class="box-id" type="hidden" name="box" value="" />
                      <input class="news-id" type="hidden" name="news" value="${row.id}" />
                      </form>
                      </div>
                      <div class="col-md-12">
                      ${desc.length > 100 ? desc.substring(0,100) + "..." : desc}
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
        $("#dt-news thead").remove();
      }
    });


    // Recommend selected
    $('body').on('click', '.select-this', function() {
      const rowData = $(this).data('row');
      const recBoxID = $(this).data('box-id');

    });

    // Add random
    $('body').on('click', '.add-random', function() {
      $('.news-list-form').attr('action', '<?php echo url('admin/change-content/recommend/add-news-inner-recommend'); ?>');
    });


    // News Datatable
    var tableNews = $("#dt-news-random").DataTable({
      dom: "rt",
      aaSorting: [],
      columnDefs: [{
        orderable: false,
        targets: [0, 1]
      }],
    });

  });
</script>

@endsection
@section('css')

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

  #dt-news-tags tr:first-child td,
  #dt-news tr:first-child td {
    border: 0;
  }

  #dt-news-tags tr td {
    padding: 10px 0;
    vertical-align: baseline;
  }

  #dt-news tr td {
    padding: 10px 0
  }

  #dt-news tr td:first-child {
    width: 150px;
    padding-right: 10px;
  }

  .dt-right {
    text-align: end;
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

  .rec-box {
    position: relative;
    display: block;
  }

  .rec-model {
    width: 100%;
    text-align: left;
  }

  .rec-model .tag-keyword {
    color: #676767;
    font-size: 10px;
  }

  .rec-model .date {
    color: #676767;
    font-size: 10px;
  }

  .rec-model h6 {
    font-size: 12px;
    margin-bottom: 0;
    color: #000000;
  }

  .del-rec {
    position: absolute;
    right: 0;
    top: 0;
  }



  #dt-news-random tr td {
    padding: 10px 0
  }

  #dt-news-random tr td:first-child {
    width: 150px;
    padding-right: 10px;
  }

  .dt-right {
    text-align: end;
  }
</style>
@endsection