@extends('admin.layouts.app')
@section('title', 'Consulting')
@section('css')
<!-- Sweet Alert-->
<link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />

<!-- Select 2 -->
<link href="{{ url('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />

<!-- Fileinput -->
<link href="{{ url('assets/libs/fileinput/css/fileinput.min.css') }}" rel="stylesheet" type="text/css" />

<!-- tagsinput -->
<!-- <script src="{{ asset('assets/libs/bootstrap-tagsinput/bootstrap-tagsinput.css') }}"></script> -->

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

  .bootstrap-tagsinput {
    width: 100% !important;
  }

  .highlight-content {
    position: relative;
  }

  .highlight-content.clone-highlight-content .delete-highlight-content,
  .shareholder.clone-shareholder .delete-shareholder,
  .shareholder.clone-shareholder .delete-evs,
  .attachment.clone-attachment .delete-attachment {
    display: none;
  }

  .delete-highlight-content {
    position: absolute;
    top: 0;
    right: 12px;
  }

  .delete-attachment {
    position: absolute;
    top: 0;
    right: 12px;
    z-index: 10;
  }

  .delete-shareholder {
    position: absolute;
    top: 0;
    right: 4px;
  }

  .delete-evs {
    position: absolute;
    top: 0;
    right: 4px;
  }

  .attachment .attachment-inner {
    background-color: #f3f3f3;
  }


  .file-drop-zone {
    min-height: 50px;
  }

  .file-drop-zone-title {
    padding: 0 10px;
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

  #dt-video-tags tr:first-child td,
  #dt-video tr:first-child td {
    border: 0;
  }

  #dt-video-tags tr td {
    padding: 10px 0;
    vertical-align: baseline;
  }

  #dt-video tr td {
    padding: 10px 0
  }

  #dt-video tr td:first-child {
    width: 150px;
    padding-right: 10px;
  }

  .dt-right {
    text-align: end;
  }

  .dataTables_empty {
    text-align: center;
  }
</style>
@stop
@section('content')
<div class="container-fluid">

  @include('admin.change-content.select-menu')


  <form method="POST" action="{{ url('admin/change-content/consulting/' . $selected_company) }}" enctype="multipart/form-data" style="position: relative;">
    @csrf
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">

            <div class="row gx-2 mb-3 justify-content-between">
              <div class="col-md-6">

                <!-- company -->
                <select class="form-control select2" id="company-select" name="company_id" required>
                  <option disabled selected>Company</option>
                  @foreach ($companies as $company)
                  <option value="{{ url('admin/change-content/consulting/' . $company->id) }}" {{$selected_company == $company->id ? 'selected' : ''}}>{{ $company->companyName }}</option>
                  @endforeach
                </select>
                <!-- /company -->
              </div>
              <div class="col-md-3 pt-1">
                <div class="form-check form-switch form-switch-lg mb-3" dir="ltr">
                  <input value="1" type="checkbox" class="form-check-input" id="publish" name="publish" {{$consulting != null && $consulting->publish == 1 ? 'checked=""' : ''}}">
                  <label class="form-check-label" for="publish">Publish</label>
                </div>
              </div>
              <div class="col-md-3 text-right">
                <button type="submit" class="btn btn-primary waves-effect waves-light">Save</button>
              </div>
            </div>

            <h4 class="card-title mb-2">Banner (List)</h4>
            <!-- row -->
            <div class="row gx-2 mb-2">
              <div class="col-md-12">
                <Label class="mb-0">Icon</Label>
              </div>
              <div class="col-md-12">
                <input type="file" class="icon" name="icon" />
              </div>
            </div>
            <!-- row -->
            <div class="row gx-2 mb-2">
              <div class="col-md-6">
                <input type="text" name="company_name_kor" class="form-control" placeholder="Company name (Kor)" value="{{ $consulting == null ? '' : $consulting->company_name_kor }}">
              </div>
              <div class="col-md-6">
                <input type="text" name="company_name_eng" class="form-control" placeholder="Company name (End)" value="{{ $consulting == null ? '' : $consulting->company_name_eng }}">
              </div>
            </div>
            <!-- row -->
            <div class="row mb-2">
              <div class="col-md-12">
                <textarea id="textarea" name="title" class="form-control" maxlength="225" rows="3" placeholder="Title">{{ $consulting == null ? '' : $consulting->title }}</textarea>
              </div>
            </div>
            <!-- row -->
            <div class="row gx-2 mb-2">
              <div class="col-md-4">
                <input type="text" name="industry" class="form-control" placeholder="Industry" value="{{ $consulting == null ? '' : $consulting->industry }}">
              </div>
              <div class="col-md-4">
                <input type="text" name="enterprise_valuation" class="form-control" placeholder="Enterprise Valuation" value="{{ $consulting == null ? '' : $consulting->enterprise_valuation }}">
              </div>
              <div class="col-md-4">
                <input type="text" name="expected_growth_rate" class="form-control" placeholder="Expected growth rate" value="{{ $consulting == null ? '' : $consulting->expected_growth_rate }}">
              </div>
            </div>
            <!-- row -->
            <div class="row gx-2 mb-2">
              <div class="col-md-12">
                <Label class="mb-0">Background Image</Label>
              </div>
              <div class="col-md-12">
                <input type="file" class="background_image" name="background_image" />
              </div>
            </div>
            <!-- separator -->
            <hr>
            <h4 class="card-title mb-2">Inner (Header)</h4>
            <!-- row -->
            <div class="row gx-2 mb-2">
              <div class="col-md-12">
                <Label class="mb-0">Icon</Label>
              </div>
              <div class="col-md-12">
                <input type="file" class="icon_inner" name="icon_inner" />
              </div>
            </div>
            <!-- row -->
            <div class="row gx-2 mb-2">
              <div class="col-md-6">
                <input type="text" name="company_name_kor_inner" class="form-control" placeholder="Company name (Kor)" value="{{ $consulting == null ? '' : $consulting->company_name_kor_inner }}">
              </div>
              <div class="col-md-6">
                <input type="text" name="subtitle" class="form-control" placeholder="Subtitle" value="{{ $consulting == null ? '' : $consulting->subtitle }}">
              </div>
            </div>
            <!-- row -->
            <div class="mb-2 row">
              <label for="company_video_link" class="col-md-3 col-form-label">Company</label>
              <div class="col-md-9">
                <input class="form-control" name="company_video_link" type="text" placeholder="Video link" id="company_video_link" value="{{ $consulting == null ? '' : $consulting->company_video_link }}">
              </div>
            </div>
            <!-- row -->
            <div class="mb-2 row">
              <label for="service_video_link" class="col-md-3 col-form-label">Service</label>
              <div class="col-md-9">
                <input class="form-control" name="service_video_link" type="text" placeholder="Video link" id="service_video_link" value="{{ $consulting == null ? '' : $consulting->service_video_link }}">
              </div>
            </div>
            <!-- row -->
            <div class="mb-2 row">
              <label for="user_review_video_link" class="col-md-3 col-form-label">User's Review</label>
              <div class="col-md-9">
                <input class="form-control" name="user_review_video_link" type="text" placeholder="Video link" id="user_review_video_link" value="{{ $consulting == null ? '' : $consulting->user_review_video_link }}">
              </div>
            </div>
            <!-- row -->
            <div class="row mb-2">
              <div class="col-md-12">
                <input type="text" name="industry_inner" class="form-control" placeholder="Industry" value="{{ $consulting == null ? '' : $consulting->industry_inner }}">
              </div>
            </div>
            <!-- row -->
            <div class="mb-2 row">
              <div class="col-md-6">
                <label class="mb-0">Highlight Content</label>
              </div>
              <div class="col-md-6 text-right">
                <button type="button" class="btn btn-sm btn-primary waves-effect waves-light" id="add-highlight-content">Add Content</button>
              </div>
            </div>
            <!-- model -->
            <div class="col-md-12 mb-2 clone-highlight-content highlight-content d-none">
              <a href="#" class="badge bg-danger delete-highlight-content"><i class="fas fa-trash-alt"></i></a>
              <input type="text" class="form-control" placeholder="Highlight Content">
            </div>
            <!-- row -->
            <div class="row highlight-content-list">
              @if($consulting != null && count($consulting->highlight_content) > 0)
              @foreach ($consulting->highlight_content as $key => $hc)
              <div class="col-md-12 mb-2 highlight-content">
                <a href="#" class="badge bg-danger delete-highlight-content"><i class="fas fa-trash-alt"></i></a>
                <input type="text" class="form-control" name="highlight_content[{{$key}}]" value="{{$hc->content}}" placeholder="Highlight Content">
              </div>
              @endforeach
              @endif
            </div>
            <!-- row -->
            <div class="mb-2 gx-2 row">
              <label for="market_value" class="col-md-3 col-form-label">Market Value</label>
              <div class="col-md-9">
                <input class="form-control" name="market_value" type="text" placeholder="Video link" id="market_value" value="{{ $consulting == null ? '' : $consulting->market_value }}">
              </div>
            </div>
            <!-- separator -->
            <hr>
            <h4 class="card-title mb-2">Company info (Right side)</h4>
            <!-- row -->
            <div class="row gx-2 mb-2">
              <div class="col-md-4">
                <label for="ceo_name" class="mb-0">CEO Name</label>
                <input id="ceo_name" type="text" name="ceo_name" class="form-control" value="{{ $consulting == null ? '' : $consulting->ceo_name }}">
              </div>
              <div class="col-md-4">
                <label for="founding_date" class="mb-0">Founding Date</label>
                <input type="text" name="founding_date" id="founding_date" class="form-control" value="{{ $consulting == null ? '' : $consulting->founding_date }}">
              </div>
              <div class="col-md-4">
                <label for="capital" class="mb-0">Capital</label>
                <input type="text" name="capital" class="form-control" id="capital" value="{{ $consulting == null ? '' : $consulting->capital }}">
              </div>
            </div>
            <!-- row -->
            <div class="row gx-2 mb-2">
              <div class="col-md-6">
                <label for="total_shares" class="mb-0">Total number of shares issued</label>
                <input type="text" name="total_shares" class="form-control" id="total_shares" value="{{ $consulting == null ? '' : $consulting->total_shares }}">
              </div>
              <div class="col-md-6">
                <label for="unified_stocks" class="mb-0">Issuance of unified stocks</label>
                <input type="text" name="unified_stocks" class="form-control" id="unified_stocks" value="{{ $consulting == null ? '' : $consulting->unified_stocks }}">
              </div>
            </div>
            <!-- row -->
            <div class="mb-2 row">
              <div class="col-md-12">
                <label for="keyword" class="mb-0">Keyword</label><br>
                <input class="form-control" data-role="tagsinput" name="keyword" type="text" id="keyword" value="{{ $consulting == null ? '' : $consulting->keyword }}">
              </div>
            </div>
            <!-- row -->
            <div class="mb-2 row">
              <div class="col-md-12">
                <label for="company_website" class="mb-0">Company Website</label><br>
                <input class="form-control" name="company_website" type="text" id="company_website" value="{{ $consulting == null ? '' : $consulting->company_website }}">
              </div>
            </div>
            <!-- row shareholders -->
            <div class="mb-2 row">
              <div class="col-md-6">
                <label class="mb-0">Shareholders</label>
              </div>
              <div class="col-md-6 text-right">
                <button type="button" class="btn btn-sm btn-primary waves-effect waves-light" id="add-shareholder">Add Shareholder</button>
              </div>
            </div>
            <!-- model -->
            <div class="row mb-2 gx-2 shareholder d-none clone-shareholder">
              <div class="col-md-9">
                <input class="form-control shareholder-ceo" type="text" placeholder="CEO">
              </div>
              <div class="col-md-3">
                <a href="#" class="badge bg-danger delete-shareholder">
                  <i class="fas fa-trash-alt"></i>
                </a>
                <input class="form-control shareholder-percent" type="text" placeholder="%">
              </div>
            </div>
            <div class="shareholders-list">
              @if($consulting != null && count($consulting->shareholders) > 0)
              @foreach ($consulting->shareholders as $key => $sh)
              <div class="row mb-2 gx-2 shareholder">
                <div class="col-md-9">
                  <input class="form-control shareholder-ceo" type="text" name="shareholders[{{$key}}][ceo]" placeholder="CEO" value="{{$sh->ceo}}">
                </div>
                <div class="col-md-3">
                  <a href="#" class="badge bg-danger delete-shareholder"><i class="fas fa-trash-alt"></i></a>
                  <input class="form-control shareholder-percent" type="text" name="shareholders[{{$key}}][percent]" placeholder="%" value="{{$sh->percent}}">
                </div>
              </div>
              @endforeach
              @endif
            </div>
            <!-- /row shareholders -->

            <!-- row -->
            <div class="mb-2 row">
              <div class="col-md-6">
                <label class="mb-0">Attachment</label>
              </div>
              <div class="col-md-6 text-right">
                <button type="button" class="btn btn-sm btn-primary waves-effect waves-light" id="add-attachment">Add Attachment</button>
              </div>
            </div>
            <!-- model -->
            <div class="col-md-12 mb-2 clone-attachment d-none attachment">
              <div class="attachment-inner">
                <input type="hidden" name="attachment_id[0]" class="attachment_id">
                <input name="attachment[0]" type="file" data-buttonname="btn-secondary" class="attachment_file">
                <a href="#" class="badge bg-danger delete-attachment"><i class="fas fa-trash-alt"></i></a>
              </div>
            </div>
            <div class="row attachment-list">
              @if ($consulting != null && count($consulting->attachment) > 0)
              @foreach ($consulting->attachment as $key => $attachment)
              <div class="col-md-12 mb-2 attachment">
                <div class="attachment-inner">
                  <input type="hidden" name="attachment_id[{{ $key }}]" value="{{ $attachment->id }}">
                  <input type="text" class="form-control" name="attachment[{{ $key }}]" readonly value="{{ $attachment->name }}">
                  <a href="#" class="badge bg-danger delete-attachment"><i class="fas fa-trash-alt"></i></a>
                </div>
              </div>
              @endforeach
              @endif
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <div class="row mb-3">
              <div class="col-md-6">
                <!-- tab selector -->
                <select class="form-control select2" id="consulting-tab">
                  <option value="about_company">About Company</option>
                  <option value="before_after">Before/After</option>
                  <option value="news">News</option>
                  <option value="qa">Q/A</option>
                </select>
                <!-- /tab selector -->
              </div>
              <div class="col-md-6 text-right">
                <button type="button" id="add-qa" class="btn btn-primary waves-effect waves-light" style="display: none;">Add</button>

                <!-- Nav tabs -->
                <ul class="nav nav-pills nav-justified" role="tablist" id="news_videos-tabs" style="display: none;">
                  <li class="nav-item waves-effect waves-light">
                    <a class="nav-link active" data-bs-toggle="tab" href="#news-tab" role="tab">
                      <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                      <span class="d-none d-sm-block">News</span>
                    </a>
                  </li>
                  <li class="nav-item waves-effect waves-light">
                    <a class="nav-link" data-bs-toggle="tab" href="#videos-tab" role="tab">
                      <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                      <span class="d-none d-sm-block">Videos</span>
                    </a>
                  </li>
                </ul>

              </div>
            </div>

            <!-- about company -->
            <div class="consulting-tab" id="about_company">

              <!-- highlight -->
              <div class="row mb-3">
                <div class="col-md-12">
                  <label>Highlight</label>
                </div>
                <div class="col-md-12">
                  <textarea id="highlight" class="consulting-editor" name="highlight">{!! $consulting == null ? '' : $consulting->highlight !!}</textarea>
                </div>
              </div>
              <!-- highlight -->

              <!-- problem -->
              <div class="row mb-3">
                <div class="col-md-12">
                  <label>Problem</label>
                </div>
                <div class="col-md-12">
                  <textarea id="problem" class="consulting-editor" name="problem">{!! $consulting == null ? '' : $consulting->problem !!}</textarea>
                </div>
              </div>
              <!-- problem -->

              <!-- suggest_solution -->
              <div class="row mb-3">
                <div class="col-md-12">
                  <label>Suggest a Solution</label>
                </div>
                <div class="col-md-12">
                  <textarea id="suggest_solution" class="consulting-editor" name="suggest_solution">{!! $consulting == null ? '' : $consulting->suggest_solution !!}</textarea>
                </div>
              </div>
              <!-- suggest_solution -->

              <!-- service_introduction -->
              <div class="row mb-3">
                <div class="col-md-12">
                  <label>Services Introduction</label>
                </div>
                <div class="col-md-12">
                  <textarea id="service_introduction" class="consulting-editor" name="service_introduction">{!! $consulting == null ? '' : $consulting->service_introduction !!}</textarea>
                </div>
              </div>
              <!-- service_introduction -->

              <!-- service_diff_eff -->
              <div class="row mb-3">
                <div class="col-md-12">
                  <label>Services Differentiation and Effectiveness</label>
                </div>
                <div class="col-md-12">
                  <textarea id="service_diff_eff" class="consulting-editor" name="service_diff_eff">{!! $consulting == null ? '' : $consulting->service_diff_eff !!}</textarea>
                </div>
              </div>
              <!-- service_diff_eff -->

              <!-- market_analysis -->
              <div class="row mb-3">
                <div class="col-md-12">
                  <label>Market Analysis</label>
                </div>
                <div class="col-md-12">
                  <textarea id="market_analysis" class="consulting-editor" name="market_analysis">{!! $consulting == null ? '' : $consulting->market_analysis !!}</textarea>
                </div>
              </div>
              <!-- market_analysis -->

              <!-- business_status -->
              <div class="row mb-3">
                <div class="col-md-12">
                  <label>Business Status</label>
                </div>
                <div class="col-md-12">
                  <textarea id="business_status" class="consulting-editor" name="business_status">{!! $consulting == null ? '' : $consulting->business_status !!}</textarea>
                </div>
              </div>
              <!-- business_status -->

              <!-- about_company -->
              <div class="row mb-3">
                <div class="col-md-12">
                  <label>About Company</label>
                </div>
                <div class="col-md-12">
                  <textarea id="about_company" class="consulting-editor" name="about_company">{!! $consulting == null ? '' : $consulting->about_company !!}</textarea>
                </div>
              </div>
              <!-- about_company -->

              <!-- ceo -->
              <div class="row mb-3">
                <div class="col-md-12">
                  <label>CEO</label>
                </div>
                <div class="col-md-12">
                  <textarea id="ceo" class="consulting-editor" name="ceo">{!! $consulting == null ? '' : $consulting->ceo !!}</textarea>
                </div>
              </div>
              <!-- ceo -->

              <!-- members -->
              <div class="row mb-3">
                <div class="col-md-12">
                  <label>Members</label>
                </div>
                <div class="col-md-12">
                  <textarea id="members" class="consulting-editor" name="members">{!! $consulting == null ? '' : $consulting->members !!}</textarea>
                </div>
              </div>
              <!-- members -->

            </div>
            <!-- /about company -->

            <!-- before/after -->
            <div class="consulting-tab" id="before_after" style="display: none;">
              <!-- before/after description -->
              <div class="row mb-3">
                <div class="col-md-12">
                  <textarea id="before_after_desc" class="consulting-editor" name="before_after_desc">{!! $consulting == null ? '' : $consulting->before_after_desc !!}</textarea>
                </div>
              </div>

              <!-- label -->
              <div class="row">
                <div class="col-md-12">
                  <label>Expectation enterprise value</label>
                </div>
              </div>

              <!-- before consulting -->
              <div class="row gx-2 mb-3">
                <div class="col-md-3">
                  <input type="text" name="before_consulting" class="form-control" id="before_consulting" value="{{ $consulting == null ? '' : $consulting->before_consulting }}" placeholder="Before Consulting">
                </div>
                <div class="col-md-3">
                  <input type="text" name="current_value" class="form-control" id="current_value" value="{{ $consulting == null ? '' : $consulting->current_value }}" placeholder="Current Value">
                </div>
                <div class="col-md-3">
                  <input type="date" name="current_value_date" class="form-control" id="current_value_date" value="{{ $consulting == null ? '' : $consulting->current_value_date }}" placeholder="Current Value's Date">
                </div>
                <div class="col-md-3">
                  <input type="text" name="expectation_growth_rate" class="form-control" id="expectation_growth_rate" value="{{ $consulting == null ? '' : $consulting->expectation_growth_rate }}" placeholder="Expectation growth rate">
                </div>
              </div>

              <!-- red point -->
              <div class="row">
                <div class="col-md-6">
                  <label>1. Red Dot Point</label>
                </div>
                <div class="col-md-6">
                  <div class="form-check form-switch float-right" dir="ltr">
                    <input type="checkbox" class="form-check-input" name="show_red_dot_1" id="show_red_dot_1" value="1" {{$consulting != null && $consulting->show_red_dot_1 == 1 ? 'checked=""' : ''}}">
                    <label class="form-check-label" for="show_red_dot_1">Hide</label>
                  </div>
                </div>
              </div>
              <div class="row gx-2 mb-3">
                <div class="col-md-6">
                  <input type="text" name="red_dot_1_title" class="form-control" id="red_dot_1_title" value="{{ $consulting == null ? '' : $consulting->red_dot_1_title }}" placeholder="Title">
                </div>
                <div class="col-md-6">
                  <input type="text" name="red_dot_1_amount" class="form-control" id="red_dot_1_amount" value="{{ $consulting == null ? '' : $consulting->red_dot_1_amount }}" placeholder="Amount">
                </div>
              </div>

              <!-- red point -->
              <div class="row">
                <div class="col-md-6">
                  <label>2. Red Dot Point</label>
                </div>
                <div class="col-md-6">
                  <div class="form-check form-switch float-right" dir="ltr">
                    <input type="checkbox" class="form-check-input" name="show_red_dot_2" id="show_red_dot_2" value="1" {{$consulting != null && $consulting->show_red_dot_2 == 1 ? 'checked=""' : ''}}">
                    <label class="form-check-label" for="show_red_dot_2">Hide</label>
                  </div>
                </div>
              </div>
              <div class="row gx-2 mb-3">
                <div class="col-md-6">
                  <input type="text" name="red_dot_2_title" class="form-control" id="red_dot_2_title" value="{{ $consulting == null ? '' : $consulting->red_dot_2_title }}" placeholder="Title">
                </div>
                <div class="col-md-6">
                  <input type="text" name="red_dot_2_amount" class="form-control" id="red_dot_2_amount" value="{{ $consulting == null ? '' : $consulting->red_dot_2_amount }}" placeholder="Amount">
                </div>
              </div>

              <!-- red point -->
              <div class="row">
                <div class="col-md-6">
                  <label>3. Red Dot Point</label>
                </div>
                <div class="col-md-6">
                  <div class="form-check form-switch float-right" dir="ltr">
                    <input type="checkbox" class="form-check-input" name="show_red_dot_3" id="show_red_dot_3" value="1" {{$consulting != null && $consulting->show_red_dot_3 == 1 ? 'checked=""' : ''}}">
                    <label class="form-check-label" for="show_red_dot_3">Hide</label>
                  </div>
                </div>
              </div>
              <div class="row gx-2 mb-3">
                <div class="col-md-6">
                  <input type="text" name="red_dot_3_title" class="form-control" id="red_dot_3_title" value="{{ $consulting == null ? '' : $consulting->red_dot_3_title }}" placeholder="Title">
                </div>
                <div class="col-md-6">
                  <input type="text" name="red_dot_3_amount" class="form-control" id="red_dot_3_amount" value="{{ $consulting == null ? '' : $consulting->red_dot_3_amount }}" placeholder="Amount">
                </div>
              </div>

              <!-- red point -->
              <div class="row">
                <div class="col-md-6">
                  <label>4. Red Dot Point</label>
                </div>
                <div class="col-md-6">
                  <div class="form-check form-switch float-right" dir="ltr">
                    <input type="checkbox" class="form-check-input" name="show_red_dot_4" id="show_red_dot_4" value="1" {{$consulting != null && $consulting->show_red_dot_4 == 1 ? 'checked=""' : ''}}">
                    <label class="form-check-label" for="show_red_dot_4">Hide</label>
                  </div>
                </div>
              </div>
              <div class="row gx-2 mb-3">
                <div class="col-md-6">
                  <input type="text" name="red_dot_4_title" class="form-control" id="red_dot_4_title" value="{{ $consulting == null ? '' : $consulting->red_dot_4_title }}" placeholder="Title">
                </div>
                <div class="col-md-6">
                  <input type="text" name="red_dot_4_amount" class="form-control" id="red_dot_4_amount" value="{{ $consulting == null ? '' : $consulting->red_dot_4_amount }}" placeholder="Amount">
                </div>
              </div>

              <hr>

              <!-- enterprise value status -->
              <div class="row mb-2">
                <div class="col-md-6">
                  <label>Enterprise Value Status</label>
                </div>
                <div class="col-md-6 text-right">
                  <button type="button" id="add-evs" class="btn btn-sm btn-primary waves-effect waves-light">Add</button>
                </div>
              </div>
              <div class="row gx-2 clone-evs d-none evs mb-2">
                <div class="col-md-8">
                  <input type="text" name="evs_title" class="form-control evs-title" value="{{ $consulting == null ? '' : $consulting->evs_title }}" placeholder="Title">
                </div>
                <div class="col-md-4">
                  <a href="#" class="badge bg-danger delete-evs"><i class="fas fa-trash-alt"></i></a>
                  <input type="date" name="evs_date" class="form-control evs-date" value="{{ $consulting == null ? '' : $consulting->date }}">
                </div>
              </div>
              <div id="evs-list">
                @if ($consulting != null && count($consulting->evs) > 0)
                @foreach ($consulting->evs as $key => $evs)
                <div class="row gx-2 evs mb-2">
                  <div class="col-md-8">
                    <input type="text" name="evs[{{$key}}][title]" class="form-control evs-title" value="{{ $consulting == null ? '' : $evs->title }}" placeholder="Title">
                  </div>
                  <div class="col-md-4">
                    <a href="#" class="badge bg-danger delete-evs"><i class="fas fa-trash-alt"></i></a>
                    <input type="date" name="evs[{{$key}}][date]" class="form-control evs-date" value="{{ $consulting == null ? '' : $evs->date }}">
                  </div>
                </div>
                @endforeach
                @endif
              </div>

            </div>
            <!-- /before/after -->

            <!-- news -->
            <div class="consulting-tab" id="news" style="display: none;">

              <!-- Tab panes -->
              <div class="tab-content">
                <div class="tab-pane active" id="news-tab" role="tabpanel">
                  <!-- Select Tags -->
                  <div class="mb-4">
                    <select class="form-control select2 news-tags" id="tag-filter" style="width: 100%">
                      <option disabled selected>Tag Name</option>
                      <option value="">All</option>
                      @foreach ($news_tags as $tag)
                      <option value="{{$tag['id']}}">{{$tag['keyword']}}</option>
                      @endforeach
                    </select>
                  </div>
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
                <div class="tab-pane" id="videos-tab" role="tabpanel">
                  <!-- Select Tags -->
                  <div class="mb-4">
                    <select class="form-control select2 video-tags" id="tag-filter-vid" style="width: 100%">
                      <option disabled selected>Tag Name</option>
                      <option value="">All</option>
                      @foreach ($video_tags as $tag)
                      <option value="{{$tag['id']}}">{{$tag['keyword']}}</option>
                      @endforeach
                    </select>
                  </div>
                  <!-- /Select Tags -->
                  <div class="row g-0">
                    <div class="col-md-12">
                      <table id="dt-video" class="table dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
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
            <!-- /news -->

            <!-- QA -->
            <div class="consulting-tab" id="qa" style="display: none;">
              <div class="accordion-item mb-3 d-none clone-accordion-item">
                <h2 class="accordion-header" id="flush-heading-1">
                  <div class="row pb-3">
                    <div class="col-md-10">
                      <input type="text" name="" class="form-control me-3" placeholder="Question">
                    </div>
                    <div class="col-md-2">
                      <button class="accordion-button pb-2 pt-2 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse-1" aria-expanded="false" aria-controls="flush-collapse-1">
                      </button>
                    </div>
                  </div>
                </h2>
                <div id="flush-collapse-1" class="accordion-collapse collapse" aria-labelledby="flush-heading-1" data-bs-parent="#accordionQA">
                  <div class="accordion-body pt-0 pe-0 ps-0">
                    <textarea name="" class="form-control" maxlength="225" rows="3" spellcheck="false" placeholder="Answer"></textarea>
                    <div class="text-right pt-2"><button type="button" class="btn btn-danger delete-qa waves-effect waves-light" style=""><i class="fas fa-trash-alt"></i></button></div>
                  </div>
                </div>
              </div>
              <div class="accordion accordion-flush" id="accordionQA">
                @if ($consulting != null && count($consulting->qa) > 0)
                @foreach ($consulting->qa as $key => $qa)
                <div class="accordion-item mb-3">
                  <h2 class="accordion-header" id="flush-heading-{{$key}}">
                    <div class="row pb-3">
                      <div class="col-md-10">
                        <input type="text" name="qa[{{$key}}][question]" class="form-control me-3" placeholder="Question" value="{{$qa->answer}}">
                      </div>
                      <div class="col-md-2"><button class="accordion-button pb-2 pt-2 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse-{{$key}}" aria-expanded="false" aria-controls="flush-collapse-{{$key}}">
                        </button></div>
                    </div>
                  </h2>
                  <div id="flush-collapse-{{$key}}" class="accordion-collapse collapse" aria-labelledby="flush-heading-{{$key}}" data-bs-parent="#accordionQA">
                    <div class="accordion-body pt-0 pe-0 ps-0">
                      <textarea name="qa[{{$key}}][answer]" class="form-control" maxlength="225" rows="3" spellcheck="false" placeholder="Answer">{{$qa->question}}</textarea>
                      <div class="text-right pt-2"><button type="button" class="btn btn-danger delete-qa waves-effect waves-light" style=""><i class="fas fa-trash-alt"></i></button></div>
                    </div>
                  </div>
                </div>
                @endforeach
                @endif
              </div>
            </div>
            <!-- /QA -->

          </div>
        </div>
      </div>
    </div>
  </form>


  @stop
  @section('javascript')
  <!-- Select 2 -->
  <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
  <!-- tagsinput -->
  <!-- <script src="{{ asset('assets/libs/bootstrap-tagsinput/bootstrap-tagsinput.js') }}"></script> -->

  <script src="{{ asset('assets/libs/fileinput/js/fileinput.min.js') }}"></script>

  <!--tinymce js-->
  <script src="{{ asset('assets/libs/tinymce/tinymce.min.js') }}"></script>

  <!-- Required datatable js -->
  <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
  <!-- Responsive examples -->
  <script src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
  <script src="{{ asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

  <script>
    // Select menu for content change
    $(function() {
      $(".select2, #company-select, #consulting-tab").select2();
      $('#page-select-dd').on('change', function() {
        var url = $(this).val();
        if (url) {
          window.location = url;
        }
        return false;
      });

      $('#company-select').on('change', function() {
        var url = $(this).val();
        console.log(url);
        if (url) {
          window.location = url;
        }
        return false;
      });

      $('#consulting-tab').on('change', function() {
        var tabID = $(this).val();
        console.log(tabID);
        if (tabID) {
          $('.consulting-tab').hide();
          $('#' + tabID).show();
        }
        if (tabID == 'qa') {
          $('#add-qa').show();
        } else {
          $('#add-qa').hide();
        }

        if (tabID == 'news') {
          $('#news_videos-tabs').show();
        } else {
          $('#news_videos-tabs').hide();
        }

        return false;
      });

      // initialize plugin with defaults
      $(".icon").fileinput({
        showUpload: false,
        showCancel: false,
        layoutTemplates: {
          footer: ''
        },
        <?php
        if ($consulting != null && $consulting->icon != '') {
          echo "validateInitialCount: true,
          initialPreviewAsData: true,
          initialPreview: ['" . $consulting->icon . "']";
        }
        ?>
      });
      $(".icon_inner").fileinput({
        showUpload: false,
        showCancel: false,
        layoutTemplates: {
          footer: ''
        },
        <?php
        if ($consulting != null && $consulting->icon_inner != '') {
          echo "validateInitialCount: true,
          initialPreviewAsData: true,
          initialPreview: ['" . $consulting->icon_inner . "']";
        }
        ?>
      });
      $(".background_image").fileinput({
        showUpload: false,
        showCancel: false,
        layoutTemplates: {
          footer: ''
        },
        <?php
        if ($consulting != null && $consulting->background_image != '') {
          echo "validateInitialCount: true,
          initialPreviewAsData: true,
          initialPreview: ['" . $consulting->background_image . "']";
        }
        ?>
      });

      $('.icon').on('fileclear', function(event) {
        deleteMedia('icon');
      });

      function deleteMedia(mediaField) {
        // Create form data
        const formData = new FormData();
        formData.append('consulting_id', <?php echo $consulting != null ? $consulting->id : null; ?>);
        formData.append('media_field', mediaField);
        $.ajax({
          url: '/admin/change-content/consulting/delete-media',
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
          },
          type: 'POST',
          processData: false,
          data: formData,
          success: function(response) {
            console.log(response);
          }
        });
      }

      /** ======= Highlight Content ======= */
      // Add highlight content
      $('#add-highlight-content').click(function() {
        var list = $('.highlight-content-list');
        var clone = $('.clone-highlight-content').clone();
        clone.removeClass('clone-highlight-content');
        clone.removeClass('d-none');
        clone.find('input').val('');
        list.append(clone);
        setHighlightContentFieldName();
      });

      // Delete highlight content
      $('body').on('click', '.delete-highlight-content', function(e) {
        e.preventDefault();
        $(this).parent('.highlight-content').remove();
        setHighlightContentFieldName();
      });

      // Set field name for highlight content
      function setHighlightContentFieldName() {
        $('.highlight-content-list .highlight-content').each(function(index) {
          $(this).find('.form-control').attr('name', 'highlight_content[' + index + ']');
        });
      }

      /** ======= Shareholders ======= */
      // Add shareholder
      $('#add-shareholder').click(function() {
        var list = $('.shareholders-list');
        var clone = $('.clone-shareholder').clone();
        clone.removeClass('clone-shareholder');
        clone.removeClass('d-none');
        clone.find('input').val('');
        list.prepend(clone);
        setShareholdersFieldName();
      });

      // Delete shareholder
      $('body').on('click', '.delete-shareholder', function(e) {
        e.preventDefault();
        $(this).parents('.shareholder').remove();
        setShareholdersFieldName();
      });

      // Set field name for shareholders
      function setShareholdersFieldName() {
        $('.shareholders-list .shareholder').each(function(index) {
          $(this).find('.shareholder-ceo').attr('name', 'shareholders[' + index + '][ceo]');
          $(this).find('.shareholder-percent').attr('name', 'shareholders[' + index + '][percent]');
        });
      }

      /** ======= Attachment ======= */
      // Add attachment
      $('#add-attachment').click(function() {
        var list = $('.attachment-list');
        var clone = $('.clone-attachment').clone();
        clone.removeClass('clone-attachment');
        clone.removeClass('d-none');
        clone.find('input').val('');
        list.append(clone);
        setAttachmentName();
      });

      // Delete attachment
      $('body').on('click', '.delete-attachment', function(e) {
        e.preventDefault();
        $(this).parents('.attachment').remove();
        setAttachmentName();
      });

      // Set field name for attachment
      function setAttachmentName() {
        $('.attachment-list .attachment').each(function(index) {
          $(this).find('input.attachment_id').attr('name', 'attachment_id[' + index + ']').val(0);
          $(this).find('input.attachment_file').attr('name', 'attachment[' + index + ']');
        });
      }

      /** ======= QA ======= */
      // Add QA
      $('body').on('click', '#add-qa', function() {
        var list = $('#accordionQA');
        var clone = $('.clone-accordion-item').clone();
        clone.removeClass('clone-accordion-item');
        clone.removeClass('d-none');
        list.prepend(clone);
        setQAFieldName();
      });

      // Delete QA
      $('body').on('click', '.delete-qa', function(e) {
        e.preventDefault();
        $(this).parents('.accordion-item').remove();
        setQAFieldName();
      });

      // Set field name for QA
      function setQAFieldName() {
        $('#accordionQA .accordion-item').each(function(index) {
          $(this).find('.accordion-header').attr('id', 'flush-heading-' + index);
          $(this).find('.accordion-button').attr('aria-controls', 'flush-collapse-' + index).attr('data-bs-target', '#flush-collapse-' + index);
          $(this).find('.accordion-collapse').attr('id', 'flush-collapse-' + index).attr('aria-labelledby', 'flush-heading-' + index);
          $(this).find('input').attr('name', 'qa[' + index + '][question]');
          $(this).find('textarea').attr('name', 'qa[' + index + '][answer]');
        });
      }

      /** ======= EVS ======= */
      // Add EVS
      $('#add-evs').click(function() {
        var list = $('#evs-list');
        var clone = $('.clone-evs').clone();
        clone.removeClass('clone-evs');
        clone.removeClass('d-none');
        clone.find('input').val('');
        list.prepend(clone);
        setEVSFieldName();
      });

      // Delete EVS
      $('body').on('click', '.delete-evs', function(e) {
        e.preventDefault();
        $(this).parents('.evs').remove();
        setEVSFieldName();
      });

      // Set field name for EVS
      function setEVSFieldName() {
        $('#evs-list .evs').each(function(index) {
          $(this).find('.evs-title').attr('name', 'evs[' + index + '][title]');
          $(this).find('.evs-date').attr('name', 'evs[' + index + '][date]');
        });
      }

      0 < $(".consulting-editor").length && tinymce.init({
        selector: "textarea.consulting-editor",
        image_class_list: [{
          title: 'img-responsive',
          value: 'img-responsive'
        }, ],
        height: 300,
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
        images_upload_url: '/admin/news-content-upload',
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


      // News Datatable
      const news_ids = "<?php echo $consulting_news_ids; ?>";
      var tableNews = $("#dt-news").DataTable({
        dom: "rtp",
        ajax: "{{ url('admin/get-news') }}",
        aaSorting: [],
        columns: [{
            data: 'images',
            render: function(data, type, row, meta) {
              if (data) {
                return `<img src="${data}" alt="" class="img-fluid">`;
              } else {
                return `<img src="http://ssdd.tech/sample/thumbnail.png" alt="" class="img-fluid">`;
              }

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

              let checked = '';

              if (news_ids.includes(row.id)) {
                checked = 'checked';
              }

              return `<div class="row">
                      <div class="col-md-8">
                        <h5 class="mb-0">${row.title}</h5>
                        <span class="badge bg-dark">${row.date}</span>
                        ${tag}
                      </div>
                      <div class="col-md-4 text-end">
                      <div class="form-check float-right"><input class="form-check-input" type="checkbox" name="news_videos[]" value="news,${row.id}" ${checked}></div>
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
          $("#dt-news thead").remove();
        }
      });

      // video Datatable
      const videos_ids = "<?php echo $consulting_videos_ids; ?>";
      console.log(videos_ids);
      var tablevideo = $("#dt-video").DataTable({
        dom: "rtp",
        ajax: "{{ url('admin/get-video') }}",
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

              let checked = '';

              if (videos_ids.includes(row.id)) {
                checked = 'checked';
              }
              return `<div class="row">
                      <div class="col-md-8">
                        <h5 class="mb-0">${row.title}</h5>
                        <span class="badge bg-dark">${row.date}</span>
                        ${tag}
                      </div>
                      <div class="col-md-4 text-end">
                      <div class="form-check float-right"><input class="form-check-input" type="checkbox" name="news_videos[]" value="video,${row.id}" ${checked}></div>
                      </div>
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
          $("#dt-video thead").remove();
        }
      });


      // Filter news
      $('body').on('change', '#tag-filter', function() {
        const tag = $(this).val();

        if ((tag != '') || (tag != null)) {
          tableNews.column(2).search(tag).draw();
        }
      });

      // Filter video
      $('body').on('change', '#tag-filter-vid', function() {
        const tag = $(this).val();

        if ((tag != '') || (tag != null)) {
          tablevideo.column(2).search(tag).draw();
        }
      });

      <?php
      if (Session::has('message')) {
        echo "toastr." . Session::get('type') . "('" . Session::get('message') . "');";
      }
      ?>


    });
  </script>

  @stop