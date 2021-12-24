<div class="row mb-4">
  <h6>Page</h6>
  <div class="col-md-3">
    <select class="form-control select2" id="page-select-dd">
      <option {{ request()->is('admin/change-content/home') ? 'selected' : '' }} value="{{ url('admin/change-content/home') }}">Home</option>
      <option {{ request()->is('admin/change-content/news-room-content') || request()->is('admin/change-content/news-room-content-videos') ? 'selected' : '' }} value="{{ url('admin/change-content/news-room-content') }}">News Room</option>
      <option {{ request()->is('admin/change-content/recommend/news-room') ? 'selected' : '' }} value="{{ url('admin/change-content/recommend/news-room') }}">Recommend</option>
      <option {{ request()->is('admin/change-content/blog') ? 'selected' : '' }} value="{{ url('admin/change-content/blog') }}">Blog</option>
      <option {{ request()->is('admin/change-content/consulting/*') ? 'selected' : '' }} value="{{ url('admin/change-content/consulting/0') }}">Consulting</option>
      <option {{ request()->is('admin/change-content/banner') ? 'selected' : '' }} value="{{ url('admin/change-content/banner') }}">Banner</option>
    </select>
  </div>
  <div class="col-md-9">
    @if (
    request()->is('admin/change-content/news-room-content')
    || request()->is('admin/change-content/news-room-video')
    )
    <ul class="nav nav-pills">
      <li class="waves-effect waves-light">
        <a class="nav-link {{ request()->is('admin/change-content/news-room-content') ? 'active' : '' }}" href="{{ url('admin/change-content/news-room-content') }}">
          <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
          <span class="d-none d-sm-block">News</span>
        </a>
      </li>
      <li class="waves-effect waves-light">
        <a class="nav-link {{ request()->is('admin/change-content/news-room-video') ? 'active' : '' }}" href="{{ url('admin/change-content/news-room-video') }}">
          <span class="d-block d-sm-none"><i class="fas fa-video"></i></span>
          <span class="d-none d-sm-block">Video</span>
        </a>
      </li>
    </ul>
    @endif
  </div>
</div>