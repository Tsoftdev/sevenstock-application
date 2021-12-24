@extends('website.layouts.webapp')
@section('title', 'Blog')
@section('css')
<!--Owl Carouse css-->
<link rel="stylesheet" href="{{ asset('website/css/owl.carousel.min.css') }}" />
<link rel="stylesheet" href="{{ asset('website/css/owl.theme.default.min.css') }}" />
@endsection
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
                <a class="nav-link toplink" href="{{ url('consultmain') }}">컨설팅 중인 기업</a>
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
                <a class="nav-link toplink toplinkactive" href="{{ url('blog') }}">블로그</a>
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

<!-- section  -->
<!-- Blog Section  -->
<div class="blog-section-wrapper">
  <div class="n-container">
    <h2 class="btop-title">인기 포스트</h2>
    <div class="owl-carousel blog-carousel owl-theme">

      @if($blog_recommend)
      @foreach ($blog_recommend as $blog_r)

      <!-- item -->
      <div class="item">
        <div class="blog-box-wrapper">
          <div class="blog-box-left">
            <div class="news-category-box">
              <div class="left" style="background:{{$blog_r->blog->tag->color}};">
                <p style="color: #ffffff;">{{$blog_r->blog->tag->keyword}}</p>
              </div>
              <div class="right">
                @php
                $date = Carbon\Carbon::parse($blog_r->blog->date)->format('d/m/Y');
                @endphp
                <p>{{$date}}</p>
              </div>
            </div>
            <a href="{{ url ('blog') }}/{{$blog_r->blog->id}}" class="blogh3">{{$blog_r->blog->title}}</a>
            <p class="blogpara">
              {!! Illuminate\Support\Str::limit(strip_tags($blog_r->blog->description), 200) !!}
            </p>
            <div class="readmore-btn">
              <a href="{{ url ('blog') }}/{{$blog_r->blog->id}}">자세히 보기</a>
            </div>
          </div>
          <div class="blog-box-right">
            @if ($blog_r->blog)
            <img src="{{$blog_r->blog->images[0]}}" alt="">
            @endif
          </div>
        </div>
      </div>
      <!-- item -->

      @endforeach
      @endif

    </div>
  </div>
</div>
<!-- Blog Section  -->
<!-- section  -->

<!-- Recent Posts  -->
<div class="recent-posts-wrapper">
  <div class="n-container">
    <div class="recent-post-inner">
      <div class="recent-post-inner-wrapper">
        <div class="recent-inner-left">
          <h2 class="recent-post-title">최신 포스트</h2>
          @foreach ($blog as $b)
          <!-- recent box  -->
          <div class="recent-left-wrapper">
            <div class="left-inner-left">
              <a href="{{ url ('blog') }}/{{$b->id}}"><img src="{{$b->images[0]}}" alt="" /></a>
            </div>
            <div class="left-inner-right">
              <div class="news-category-box">
                @if($b->tag)
                <div class="left" style="background:{{$b->tag->color}};">
                  <p style="color:#fff;">{{$b->tag->keyword}}</p>
                </div>
                @else
                <strong class="pe-2">(Untag)</strong>
                @endif
                <div class="right">
                  @php
                  $date = Carbon\Carbon::parse($b->date)->format('Y-m-d');
                  @endphp
                  <p>{{$date}}</p>
                </div>
              </div>
              <div class="recent-link">
                <a href="{{ url ('blog') }}/{{$b->id}}">{{$b->title}}</a>
              </div>
              <p class="recent-para">
                <!-- {!!$b->description !!} -->
                {!! Illuminate\Support\Str::limit(strip_tags($b->description), 200) !!}
              </p>
            </div>
          </div>
          <!-- /recent box  -->
          @endforeach
          <!-- Load More  -->
          <div class="load-more">
            <a href="#">더 보기</a>
          </div>
          <!-- Load More  -->
        </div>
        <div class="recent-inner-right">
          <div class="recent-add-wrapper-top">
            <h6>
              Unlisted Companies<br />
              & Value Stocks
            </h6>
            <p>
              A gathering place for experts looking<br />for undervalued
              stocks
            </p>
            <h3>Sevenstocks</h3>
            <a href="{{ url('contactus') }}" class="recent-right-link">전화 요청</a>
          </div>
          @if($blog_banner_1)
          <p style="padding-left: 66px; padding-right: 66px;">
            <img width="100%" src="{{ $blog_banner_1->image }}" alt="">
          </p>
          @endif
          @if($blog_banner_2)
          <p style="padding-left: 66px; padding-right: 66px;">
            <img width="100%" src="{{ $blog_banner_2->image }}" alt="">
          </p>
          @endif
          <!-- <div class="recent-add-wrapper-bottom1">
            <p>
              A gathering place for experts looking<br />for undervalued
              stocks
            </p>
            <h4>ULIKEKOREA</h4>
            <div class="recenright-link-wrapper">
              <a href="#" class="recent-readmore-link">Read more</a>
            </div>
          </div> 
          <div class="recent-add-wrapper-bottom">
            <p>
              A gathering place for experts looking<br />for undervalued
              stocks
            </p>
            <h4>ALPADO</h4>
            <div class="recent-link-bottom-wrapper">
              <a href="#" class="recent-readmore-link">Read more</a>
            </div>
          </div> -->
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Recent Posts  -->

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
<script>
  // Footer phone copy
  var fphone = document.getElementById("footerphone");
  var fpopuptext = document.getElementById("fpopuptext");
  fphone.addEventListener("click", () => {
    fpopuptext.classList.add('popactive');
    copyToclipboard();
  });
  fpopuptext.addEventListener("animationend", () => {
    fpopuptext.classList.remove('popactive');
  });

  function copyToclipboard() {
    const textrea = document.createElement("textarea");
    textrea.setAttribute("readonly", "");
    textrea.style.position = 'absolute';
    textrea.value = fphone.innerText;
    document.body.appendChild(textrea);
    textrea.select();
    document.execCommand('copy');
    document.body.removeChild(textrea);
  }
  // Footer phone copy
</script>

@endsection