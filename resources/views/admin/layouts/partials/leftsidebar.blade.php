<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

  <div data-simplebar class="h-100">

    <!--- Sidemenu -->
    <div id="sidebar-menu">
      <!-- Left Menu Start -->
      <ul class="metismenu list-unstyled" id="side-menu">
        <li class="menu-title">Main</li>
        <li>
          <a href="{{ url('admin/dashboard') }}" class="waves-effect">
            <i class="mdi mdi-view-dashboard"></i>
            <span>Dashboard</span>
          </a>
        </li>

        <li class=" @if(strpos(Request::path(), 'customer') != false) mm-active @endif ">
          <a href="{{ url('admin/customers') }}" class="waves-effect">
            <i class="mdi mdi-account-tie-outline"></i>
            <span>고객관리</span>
          </a>
        </li>
        <li class=" @if(strpos(Request::path(), 'articles') != false) mm-active @endif ">
          <a href="{{ url('admin/articles') }}" class="waves-effect">
            <i class="mdi mdi-account-tie-outline"></i>
            <span>뉴스페이지 관리</span>
          </a>
        </li>
        <li class=" @if(strpos(Request::path(), 'shareholder') != false) mm-active @endif ">
          <a href="{{ url('admin/shareholder') }}">
            <i class="mdi mdi-bag-personal-outline"></i>
            <span>주주관리</span>
          </a>
        </li>
        <li class=" @if(strpos(Request::path(), 'user-record') != false) mm-active @endif ">
          <a href="{{ url('admin/user-record/stocks') }}" class="waves-effect">
            <i class="ion ion-md-alarm"></i>
            <span>전체고객기록</span>
          </a>
        </li>
        @if(Auth::guard('admin')->user()->can('manage_schedule'))
        <li class=" @if(strpos(Request::path(), 'schedule') != false) mm-active @endif ">
          <a href="{{ url('admin/schedule') }}" class="waves-effect">
            <i class="mdi mdi-calendar-check"></i>
            <span>스케줄관리</span>
          </a>
        </li>
        <li class=" @if(strpos(Request::path(), 'employees') != false) mm-active @endif ">
          <a href="{{ route('admin.employees') }}" class="waves-effect">
            <i class="ion ion-md-contacts"></i>
            <span>Employee</span>
          </a>
        </li>
        <li class=" @if(strpos(Request::path(), 'receipt') != false) mm-active @endif ">
          <a href="{{ route('admin.receipt') }}" class="waves-effect">
            <i class="mdi mdi-credit-card-marker-outline"></i>
            <span>Receipt</span>
          </a>
        </li>
        @endif
        @if(Auth::guard('admin')->check() && Auth::guard('admin')->user()->can('manage_admin'))
        <li class=" @if(strpos(Request::path(), 'statistics') != false) mm-active @endif ">
          <a href="{{ url('admin/statistics') }}">
            <i class="ion ion-md-analytics"></i>
            <span>기업통계</span>
          </a>
        </li>
        @endif
        <li class="menu-title">ETC</li>
        <li>
          <a href="{{ route('admin.messages') }}" class="waves-effect">
            <i class="mdi mdi-chat-processing-outline"></i>
            <span>SMS</span>
          </a>
        </li>
        <li>
          <a href="javascript: void(0);" class="waves-effect">
            <i class="mdi mdi-email-outline"></i>
            <span>E-mail</span>
          </a>
        </li>
        <li>
          <a href="javascript: void(0);" class="has-arrow waves-effect">
            <i class="ion ion-md-settings"></i>
            <span>설정</span>
          </a>
          <ul class="sub-menu" aria-expanded="false">
            @if(Auth::guard('admin')->check() && Auth::guard('admin')->user()->can('manage_admin'))
            <li class=" @if(strpos(Request::path(), 'users') != false) mm-active @endif "><a
                href="{{ route('admin.users') }}">관리자 계정관리</a></li>
            <li class=" @if(strpos(Request::path(), 'roles') != false) mm-active @endif ">
              <a href="{{ url('admin/roles') }}" class="waves-effect">관리자 역할설정</a>
            </li>
            <li class=" @if(strpos(Request::path(), 'companies') != false) mm-active @endif ">
              <a href="{{ url('admin/companies') }}" class="waves-effect">기업관리</a>
            </li>
            @endif
          </ul>
        </li>
        <li class="menu-title">Website</li>
        <li>
          <a href="{{ url('admin/contact-box/investor') }}" class="waves-effect">
            <i class="mdi mdi-email-multiple-outline"></i>
            @php
            $total_inquiries_count = total_inquiries_count();
            @endphp
            <span class="badge bg-primary float-end fs-6 mt-0"
              id="all_inquiries_count">{{ $total_inquiries_count }}</span>
            <span>Contact Box</span>
          </a>
        </li>
        <li class="{{ request()->is('admin/change-content/*') ? 'mm-active' : '' }}">
          <a href="{{ url('admin/change-content/home') }}" class="waves-effect">
            <i class="fas fa-edit"></i>
            <span>Change Content</span>
          </a>
        </li>

      </ul>
    </div>
    <!-- Sidebar -->
  </div>
  <!-- Sidebar -->
</div>
</div>
<!-- Left Sidebar End -->