@extends('website.layouts.webapp')
@section('title', 'Consulting')
@section('content')
<section>
  <div class="news-header">
    <div class="n-container">
      <div class="header-top">
        <nav class="navbar navbar-expand-lg navbar-light">
          <a class="navbar-brand" href="/"><img src="{{ asset ('website/assets/images/logo.svg') }}" alt="" /></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item">
                <a class="nav-link toplink toplinkactive" href="{{ url('consultmain') }}">컨설팅 중인 기업</a>
              </li>
              <li class="nav-item">
                <a class="nav-link toplink" href="{{ url('newsroom') }}">뉴스룸</a>
              </li>
              <li class="nav-item">
                <a class="nav-link toplink" href="{{ url('about-us') }}">회사소개</a>
              </li>
              <li class="nav-item">
                <a class="nav-link toplink" href="{{ url('service') }}">서비스</a>
              </li>
              <li class="nav-item">
                <a class="nav-link toplink" href="{{ url('blog') }}">블로그</a>
              </li>
              <li class="nav-item">
                <a class="nav-link toplink" href="{{ url('contact-us') }}">상담문의</a>
              </li>
            </ul>
            <span class="navbar-text">
              <a href="tel:832 939 8280"><i class="fa fa-phone" aria-hidden="true"></i>&nbsp;
                02-529-1001</a>
            </span>
          </div>
        </nav>
      </div>
    </div>
  </div>

  <!-- Mobile mune for news  -->
  <div class="news-mobile-wrapper">
    <div class="mobile-header-menu" id="mobile-header">
      <div class="left">
        <a href="/"><img src="{{ asset ('website/assets/images/mobilelogo.svg') }}" alt="" /></a>
      </div>
      <div class="right">
        <div class="myicon">
          <i class="fa fa-ellipsis-h menu-dots news-menu-dots" id="menu-dots" aria-hidden="true"></i>
          <span class="cross news-cross"> &times; </span>
        </div>
      </div>
    </div>
    <div class="mymobile-menu">
      <ul>
        <li><a href="{{ url('consultmain') }}">컨설팅 중인 기업</a></li>
        <li><a href="{{ url('newsroom') }}">뉴스룸</a></li>
        <li><a href="{{ url('about-us') }}">회사소개</a></li>
        <li><a href="{{ url('service') }}">서비스</a></li>
        <li><a href="{{ url('blog') }}">블로그</a></li>
        <li><a href="{{ url('contact-us') }}">상담문의</a></li>
      </ul>
      <div class="mphone">
        <a class="mobile-phone" href="tel:832 939 8280"><i class="fa fa-phone" aria-hidden="true"></i>&nbsp;
          02-529-1001</a>
      </div>
    </div>
  </div>
  <!-- Mobile mune for news  -->
</section>

<!-- Second Section  -->
<!--div class="second-news-section nsecond-new-section"-->
  <!-- Consulting bottom navigation  -->
  <!-- <div class="nconsulting-bottom-header">
    <div class="n-container">
      <div class="nconsulting-inner">
        <div class="nconsulting-inner-left">
          <a href="{{ url('newsroom') }}">뉴스 룸</a>
        </div>
        <div class="nconsulting-inner-right">
          <a href="{{ url('newsroom') }}">전체보기 <span>></span></a>
        </div>
      </div>
    </div>
  </div> -->
  <!-- Consulting bottom navigation  -->

  <!-- <div class="n-container">
    <div class="row">
      <div class="col-md-8">
        <div class="left-inner">
          <div class="bottom-section">
            <div class="news-category-box">
              <div class="left">
                <p>유라이크코리아</p>
              </div>
              <div class="right">
                <p>06/16/2021</p>
              </div>
            </div>
            <a href="{{ url('newsroomdetail') }}">
              김희진 유라이크코리아 대표 "바이오캡슐 하나면 가축<br />질병
              알 수 있죠"
            </a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="right-inner">
          <div class="news-category-box">
            <div class="left">
              <p>유라이크코리아</p>
            </div>
            <div class="right">
              <p>06/16/2021</p>
            </div>
          </div>
          <a href="{{ url('newsroomdetail') }}">김희진 유라이크코리아 대표 "바이오캡슐 하나면 가축<br />질병
            알 수 있죠"</a>
        </div>
        <div class="right-inner">
          <div class="news-category-box">
            <div class="left">
              <p>유라이크코리아</p>
            </div>
            <div class="right">
              <p>06/16/2021</p>
            </div>
          </div>
          <a href="{{ url('newsroomdetail') }}">김희진 유라이크코리아 대표 "바이오캡슐 하나면 가축<br />질병
            알 수 있죠"</a>
        </div>
        <div class="right-inner">
          <div class="news-category-box">
            <div class="left">
              <p>유라이크코리아</p>
            </div>
            <div class="right">
              <p>06/16/2021</p>
            </div>
          </div>
          <a href="{{ url('newsroomdetail') }}">김희진 유라이크코리아 대표 "바이오캡슐 하나면 가축<br />질병
            알 수 있죠"</a>
        </div>
      </div>
    </div>
  </div> -->
<!--/div-->
<!-- Second Section  -->

<!-- Ulike Korea Section  -->

<div class="ulike-korea-section">
  <div class="n-container">
    <h2 class="ulike-title">컨설팅 회사</h2>

    @forelse ($consulting as $consult)
    <div class="ulike-korea-bottom-top-section">
      <div class="bottom-top-section-left">
        <a href="{{ url('consult' . '/' . $consult->id) }}">
          <div class="top-left-inner">
            <div class="uleft">
              @if($consult->icon)
              <img src="{{ $consult->icon }}" alt="" />
              @endif
            </div>
            <div class="uright">
              <h5>{{ $consult->company_name_kor }}</h5>
              <p>{{ $consult->company_name_eng }}</p>
            </div>
          </div>
        </a>
      </div>
      <div class="bottom-top-section-right">
        <a href="{{ url('consult' . '/' . $consult->id) }}">
          <img src="{{ asset ('website/assets/images/rightlink.svg') }}" alt="" />
        </a>
      </div>
    </div>

    <div class="ulike-korea-bottom-bottom-section-wrapper" style="margin-bottom: 30px">
      <a href="{{ url('consult' . '/' . $consult->id) }}">
        <div class="bgfor-desktop bgfor-mobile" style="background-image: url('{{$consult->background_image}}');">
          <h2>{!!$consult->title !!}</h2>
          <div class="cbottom-section-wrapper">
            <div class="cbottom-section-left">
              <div class="cbottom-left-section-wrapper">
                <div class="cbottom-left-section-left">
                  <div class="cbottom-left-box">
                    <div class="box-top">
                      <div class="box-top-left">
                        <img src="{{ asset ('website/assets/images/cbottom.svg') }}" alt="" />
                      </div>
                      <div class="box-top-right">
                        <p>산업분야</p>
                      </div>
                    </div>
                    <div class="cbottom-txt cbottom-left-box-mobile0">
                      <p class="c-txt">{{ $consult->industry }}</p>
                    </div>
                  </div>
                  <div class="cbottom-left-box">
                    <div class="box-top">
                      <div class="box-top-left">
                        <img src="{{ asset ('website/assets/images/cbottom.svg') }}" alt="" />
                      </div>
                      <div class="box-top-right">
                        <p>기업가치평가</p>
                      </div>
                    </div>
                    <div class="cbottom-txt cbottom-left-box-mobile1">
                      <p class="c-txt">{{ $consult->enterprise_valuation }}</p>
                    </div>
                  </div>
                  <div class="cbottom-left-box">
                    <div class="box-top">
                      <div class="box-top-left">
                        <img src="{{ asset ('website/assets/images/cbottom.svg') }}" alt="" />
                      </div>
                      <div class="box-top-right">
                        <p>예상성장률</p>
                      </div>
                    </div>
                    <div class="cbottom-txt cbottom-left-box-mobile2">
                      <p class="c-txt">{{ $consult->expected_growth_rate }}</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="cbottom-section-right">
              <p>자세히 보기</p>
            </div>
          </div>
        </div>
      </a>
    </div>

    @empty
    <h2>No data available!</h2>
    @endforelse
  </div>
</div>

<!-- Ulike Korea Section  -->


<!-- Footer  -->
<div class="myfooter">
  <div class="mycontainer">
    <div class="footer-inner">
      <div class="left-section">
        <div class="logo">
          <a href="/"><img src="{{ asset ('website/assets/images/logo-white.svg') }}" alt="" /></a>
        </div>
        <p class="top">
          상장예정기업 전문 컨설팅 기업<br />
          (주)세븐스톡 홀딩스
        </p>
        <p class="bottom">
          대표자 : 송영봉 | 사업자 등록번호 : 109-86-46874<br />통신판매업신고번호
          : 제2016 서울 강남 0411호
        </p>
        <span><img src="{{ asset ('website/assets/images/phonefooter.svg') }}" alt="" />&nbsp;
          <span id="footerphone">02-529-1001</span></span>
        <div class="popupphone" id="popupphone">
          <span class="fpopuptext" id="fpopuptext">copied</span>
        </div>
      </div>
      <div class="right-section">
        <div class="left">
          <h2>상담이 필요하신가요?</h2>
          <p>
            성함과 핸드폰 번호를 남겨주시면<br />
            빠른 시일 내에 연락 드리도록 하겠습니다.
          </p>
        </div>
        <div class="right">
          @include('website.layouts.partials.footer-mini-contact-form')
          <!-- 투자자 -->
          <!-- 기업 -->
        </div>
      </div>
    </div>
    <div class="footer-bottom copyright-border">
      <div class="left">
        <ul>
          <li><a href="#" class="white-16-100">이용약관</a></li>
          <li>
            <a href="#" class="white-16-100">개인정보 취급방식</a>
          </li>
          <li><a href="#" class="white-16-100">회사소개서</a></li>
        </ul>
      </div>

      <div class="right">
        <p class="white-16-100">
          Copyright © 2021 Sevenstock Holdings Inc. All rights are
          reserved.
        </p>
      </div>
    </div>
  </div>
</div>

<!-- Back to top  -->
<button onclick="topFunction()" id="toTopBtn" title="Go to top">
  <img src="{{ asset ('website/assets/images/fast-forward.svg') }}" alt="Arrow up" />
</button>
<!-- Back to top  -->

@endsection