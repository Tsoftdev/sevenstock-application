@php
$total_investor_inquiries_count = total_inquiries_count('Investor');
$total_company_inquiries_count = total_inquiries_count('Company');
@endphp
<!-- tabs -->
<div class="row mb-3">
  <div class=" col-md-12">
    <ul class="nav nav-pills">
      <li class="waves-effect waves-light">
        <a class="nav-link {{ request()->is('admin/contact-box/investor') ? 'active' : '' }}"
          href="{{ url('admin/contact-box/investor') }}">
          <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
          <span class="d-none d-sm-block">
            <span class="badge fs-6 fw-bolder float-end ms-2"
              style="line-height: 14px; color: #7a6fbe; background-color:#fff; border:1px solid #7a6fbe"
              id="invertor_inquiries_count">{{ $total_investor_inquiries_count }}</span>
            Investor</span>
        </a>
      </li>
      <li class="waves-effect waves-light">
        <a class="nav-link {{ request()->is('admin/contact-box/company') ? 'active' : '' }}"
          href="{{ url('admin/contact-box/company') }}">
          <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
          <span class="d-none d-sm-block">
            <span class="badge fs-6 fw-bolder float-end ms-2"
              style="line-height: 14px; color: #7a6fbe; background-color:#fff; border:1px solid #7a6fbe"
              id="company_inquiries_count">{{ $total_company_inquiries_count }}</span>
            Company</span>
        </a>
      </li>
    </ul>
  </div>
</div>
<!-- /tabs -->