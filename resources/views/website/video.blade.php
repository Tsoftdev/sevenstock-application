@extends('website.layouts.webapp')
@section('title', 'Video')
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
          <a class="navbar-brand" href="./index.html"><img src="{{ asset ('website/assets/images/logo.svg') }}" alt="" /></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
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
        <a href="/"><img src="{{ asset ('website/assets/images/mobilelogo.svg') }}" alt=""></a>
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

  <!-- News Header  -->
  <div class="news-header-bottom">
    <div class="n-container">

      <div class="news-header-inner">
        <div class="left">
          <div class="left-menu">
            <ul>
              <li><a href="{{ url ('video') }}" class="{{$active_tag ? '' : 'myactive'}}">전체보기</a></li>
              @foreach ($tags as $tag)
              <li><a href="{{ url ('video') }}/{{$tag->id}}" class="{{($active_tag && $active_tag->id == $tag->id) ? 'myactive' : ''}}">{{$tag->keyword}}</a></li>
              @endforeach
            </ul>
          </div>
        </div>
        <div class="right">
          <div class="right-menu">
            <ul>
              <li><a class="left" href="{{ url ('newsroom') }}">보도자료</a></li>
              <li><a class="right" href="{{ url ('video') }}">동영상</a></li>
            </ul>
          </div>
        </div>
      </div>

      <!-- Mobile Accordion  -->
      <div class="mobile-accordion">
        <div class="top acc-top">
          <div class="left">
            <p>전체보기</p>
          </div>
          <div class="right"><img src="{{ asset ('website/assets/images/accordion.png') }}" class="acc-icon" alt="">
          </div>
        </div>

      </div>
      <!-- Mobile Accordion  -->
    </div>

  </div>
  <!-- News Header  -->

  <!-- Accordion List  -->
  <div class="accrdion-list">
    <ul>
      <li><a href="#">전체보기</a></li>
      <li><a href="#">유라이크 코리아</a></li>
      <li><a href="#">알파도</a></li>
      <li><a href="#">코드에셋</a></li>
      <li><a href="#">세븐스톡 홀딩스</a></li>
      <li class="bottom-last"><a href="#">보도자료</a></li>
      <li class="last"><a href="#">보도자료</a></li>
    </ul>
  </div>
  <!-- Accordion List  -->


</section>


<!-- Video Section  -->
<div class="myvideo-section">
  <div class="n-container">
    <div class="content-container-4 mycontent-container-4">

      @if ($active_tag == null)

      <div class="video-1 topvideo-section">
        @if ($rec1)
        <iframe src="{{ $rec1->video->video_link }}" allow="autoplay" id="video-1" frameborder="0" onclick="change()" style="cursor: pointer;" allowfullscreen></iframe>

        <div class="video-after-txt">

          <a href="{{ url ('video-inner') }}/{{ $rec1->video->id }}">{{ $rec1->video->title }}</a>
          <div class="category-box">
            <span class="category-1" style="background:{{$rec1->video->tag->color}};">
              <p style="color:#fff;">{{ $rec1->video->tag->keyword }}</p>
            </span>
            @php
            $date_now = Carbon\Carbon::parse($rec1->video->date)->format('d/m/Y');
            @endphp
            <p class="grey-18" id="videoDate">{{ $date_now }}</p>
          </div>
        </div>

        @endif
      </div>

      <div class="left-posts-s-container">

        @if ($rec2)
        <div class="left-posts-s">
          <a href="{{ url ('video-inner') }}/{{ $rec2->video->id }}">
            <img src="{{ $rec2->video->images[0] }}" class="videoLink sidethumbnail">
          </a>
          <span class="hidden">https://www.youtube.com/embed/AHRvvPCJuZA</span>
          <div class="posts-txt">
            <a href="{{ url ('video-inner') }}/{{ $rec2->video->id }}">{{ $rec2->video->title }}</a>
            <div class="category-box">
              <span class="category-2" style="background:{{$rec2->video->tag->color}};">
                <p style="color:#fff;">{{ $rec2->video->tag->keyword }}</p>
              </span>
              @php
              $date_now = Carbon\Carbon::parse($rec2->video->date)->format('d/m/Y');
              @endphp
              <p class="grey-12_5">{{$date_now }}</p>

            </div>
          </div>

        </div>
        @endif

        @if ($rec3)
        <div class="left-posts-s">
          <a href="{{ url ('video-inner') }}/{{ $rec3->video->id }}"><img src="{{ $rec3->video->images[0] }}" class="videoLink sidethumbnail"></a>
          <span class="hidden">https://www.youtube.com/embed/AHRvvPCJuZA</span>
          <div class="posts-txt">
            <a href="{{ url ('video-inner') }}/{{ $rec3->video->id }}">{{ $rec3->video->title }}</a>
            <div class="category-box">
              <span class="category-2" style="background:{{$rec3->video->tag->color}};">
                <p style="color:#fff;">{{ $rec3->video->tag->keyword }}</p>
              </span>
              @php
              $date_now = Carbon\Carbon::parse($rec3->video->date)->format('d/m/Y');
              @endphp
              <p class="grey-12_5">{{$date_now }}</p>

            </div>
          </div>

        </div>
        @endif

        @if ($rec4)
        <div class="left-posts-s">
          <a href="{{ url ('video-inner') }}/{{ $rec4->video->id }}"><img src="{{ $rec4->video->images[0] }}" class="videoLink sidethumbnail"></a>
          <span class="hidden">https://www.youtube.com/embed/AHRvvPCJuZA</span>
          <div class="posts-txt">
            <a href="{{ url ('video-inner') }}/{{ $rec4->video->id }}">{{ $rec4->video->title }}</a>
            <div class="category-box">
              <span class="category-2" style="background:{{$rec4->video->tag->color}};">
                <p style="color:#fff;">{{ $rec4->video->tag->keyword }}</p>
              </span>
              @php
              $date_now = Carbon\Carbon::parse($rec4->video->date)->format('d/m/Y');
              @endphp
              <p class="grey-12_5">{{$date_now }}</p>

            </div>
          </div>

        </div>
        @endif

        @if ($rec5)
        <div class="left-posts-s">
          <a href="{{ url ('video-inner') }}/{{ $rec5->video->id }}"><img src="{{ $rec5->video->images[0] }}" class="videoLink sidethumbnail"></a>
          <span class="hidden">https://www.youtube.com/embed/AHRvvPCJuZA</span>
          <div class="posts-txt">
            <a href="{{ url ('video-inner') }}/{{ $rec5->video->id }}">{{ $rec5->video->title }}</a>
            <div class="category-box">
              <span class="category-2" style="background:{{$rec5->video->tag->color}};">
                <p style="color:#fff;">{{ $rec5->video->tag->keyword }}</p>
              </span>
              @php
              $date_now = Carbon\Carbon::parse($rec5->video->date)->format('d/m/Y');
              @endphp
              <p class="grey-12_5">{{$date_now }}</p>

            </div>
          </div>

        </div>
        @endif

      </div>

      @endif

      <div id="articles" class="latest-video-section">
        <p class="black-30">
          @if ($active_tag)
          {{$active_tag->keyword}}
          @else
          최신 비디오
          @endif
        </p>
        <div class="articles-container">

          @foreach ($video as $v)
          <div class="article">
            <a href="{{ url ('video-inner') }}/{{$v->id}}"><img class="mythumnail" src="{{$v->images[0]}}" alt=""></a>

            <a href="{{ url ('video-inner') }}/{{$v->id}}" class="bottom-video-link">{{$v->title}}</a>
            <div class="category-box">
              @if($v->tag)
              <div class="category-1" style="background:{{$v->tag->color}}; ">
                <p style="color:#fff;">{{$v->tag->keyword}}</p>
              </div>
              @else
              <strong class="pe-2">(Untag)</strong>
              @endif
              @php
              $date_now = Carbon\Carbon::parse($v->date)->format('Y-m-d');
              @endphp
              <p class="grey-14">{{$date_now}}</p>
            </div>
          </div>
          @endforeach

        </div>
      </div>


    </div>
  </div>

</div>

<!-- Video Section  -->




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

@stop
@section('javascript')
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