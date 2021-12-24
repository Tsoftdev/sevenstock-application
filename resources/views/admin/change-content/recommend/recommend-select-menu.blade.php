<div class="row mb-4">
  <div class="col-md-6">
    <select class="form-control select2" id="page-select-recommend">
      <!-- <option {{ request()->is('admin/change-content/recommend/consulting-list') ? 'selected' : '' }} value="{{ url('admin/change-content/recommend/consulting-list') }}">Consulting List</option> -->
      <option {{ request()->is('admin/change-content/recommend/news-room') ? 'selected' : '' }} value="{{ url('admin/change-content/recommend/news-room') }}">News Room (News-List)</option>
      <option {{ request()->is('admin/change-content/recommend/news-room-inner') ? 'selected' : '' }} value="{{ url('admin/change-content/recommend/news-room-inner') }}">News Room (News-Inner)</option>
      <option {{ request()->is('admin/change-content/recommend/news-room-videos') ? 'selected' : '' }} value="{{ url('admin/change-content/recommend/news-room-videos') }}">News Room (Video-List)</option>
      <option {{ request()->is('admin/change-content/recommend/news-room-videos-inner') ? 'selected' : '' }} value="{{ url('admin/change-content/recommend/news-room-videos-inner') }}">News Room (Video-Inner)</option>
      <option {{ request()->is('admin/change-content/recommend/blog') ? 'selected' : '' }} value="{{ url('admin/change-content/recommend/blog') }}">Blog</option>
    </select>
  </div>
</div>