@extends('website.layouts.webapp')
@section('title', 'Video Detail')
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
  <div class="single-news-header-bottom">
    <div class="n-container">
      <div class="single-news-header-inner">
        <div class="left">
          <div class="left-menu">
            <div class="back">
              <div class="left"><a href="javascript: history.back(-1)"><img src="{{ asset ('website/assets/images/backicon.svg') }}" class="single-back" alt=""></a></div>
              <div class="right">
                <p>돌아가기</p>
              </div>
            </div>
          </div>
        </div>
        <div class="right">
        </div>
      </div>
    </div>
  </div>
  <!-- News Header  -->
</section>

<!-- Video Section  -->
<div class="myvideo-section myvideo-inner">
  <div class="n-container">
    <div class="content-container-4 mycontent-container-4 myinner-container-4">
      <div class="video-1 topvideo-section inner-topvideo-section">
        <iframe src="{{ $video->video_link }}" allow="autoplay" id="video-1" class="inner-video-1" frameborder="0" onclick="change()" style="cursor: pointer;" allowfullscreen></iframe>

        <div class="video-after-txt">

          <a href="#">{{ $video->title }}</a>
          <div class="category-box">
            @if($video->tag)
            <div class="category-1" style="background:{{$video->tag->color}}; ">
              <p style="color:#fff;">{{$video->tag->keyword}}</p>
            </div>
            @else
            <strong class="pe-2">(Untag)</strong>
            @endif
            @php
            $date_now = Carbon\Carbon::parse($video->date)->format('Y-m-d');
            @endphp
            <p class="grey-18" id="videoDate">{{$date_now}}</p>
          </div>
          <!-- Inner Video Para Section  -->
          <div class="inner-video-para-section">
            {!! $video->description !!}
          </div>
          <!-- Inner Video Para Section  -->
        </div>

      </div>

      <div class="left-posts-s-container video-inner-left-container">
        <h2 class="video-inner-left-header">추천 영상</h2>
        @if($news_inner_recommend)
        @foreach ($news_inner_recommend as $news_rec)
        <div class="left-posts-s left-inner-video">
          @if ($news_rec->video)
          <img src="{{$news_rec->video->images[0]}}" alt="" class="videoLink sidethumbnail inner-left-thumbnail">
          @else
          <img src="http://ssdd.tech/sample/thumbnail.png" class="videoLink sidethumbnail inner-left-thumbnail">
          @endif
          <span class="hidden">https://www.youtube.com/embed/AHRvvPCJuZA</span>
          <div class="posts-txt">
            <a href="{{ url('video-inner/' . $news_rec->video->id) }}">{{$news_rec->video->title}}</a>
            <!-- <p class="black-17-300">코드에셋, 세계 최초 코드 기반 통합 플랫폼 ‘코드맵’ 개발 성공..</p> -->
            <div class="category-box">
              <span class="category-2" style="background:{{$news_rec->video->tag->color}};">
                <p style="color: #ffffff;">{{$news_rec->video->tag->keyword}}</p>
              </span>
              @php
              $date = Carbon\Carbon::parse($news_rec->video->date)->format('d/m/Y');
              @endphp
              <p class="grey-12_5">{{$date}}</p>

            </div>
          </div>

        </div>
        @endforeach
        @endif

        <!-- Video Inner Section  -->
        <div class="inner-add-left-section">
          <div class="myadd">
            <h5>지금 보고 계시는 기업의 정보가
              궁금하다면?</h5>
            <h2>ULIKEKOREA</h2>
            <a href="#">기업정보 확인하기</a>
          </div>
        </div>
        <!-- Video Inner Section  -->
      </div>
    </div>
  </div>

</div>
<!-- Video Section  -->


<!-- Middle Baner and link section  -->
<div class="inner-middle-section">
  <!-- Single bottom link and button  -->
  <div class="single-banner">
    <div class="n-container">
      <div class="single-inner">
        <div class="left">
          <div class="mylink">
            <div class="left">
              <h2>상장예정기업 & 저평가 가치주</h2>
            </div>
            <div class="right">
              <a href="{{ url('contact-us') }}">문의하기</a>
            </div>
          </div>
          <p>20년의 노하우로 기업가치 상승을 위한 성공적인 전략을 제시합니다.</p>
        </div>
        <div class="right">
          <div class="button-wrapper">
            <a href="{{ url('contact-us') }}" class="firstlink">전화상담 예약</a>
            <a href="{{ url('contact-us') }}">오시는 길</a>
          </div>
        </div>
      </div>
      <!-- Mobile link  -->
      <div class="mobile-link">
        <div class="link-top-wrapper">
          <div class="left">
            <h2>상장예정기업 & 저평가 가치주</h2>
          </div>
          <div class="right"> <a href="#">문의하기</a></div>
        </div>
        <div class="bottom-link">
          <p>20년의 노하우로 기업가치 상승을 위한 성공적인 전략을 제시합니다.</p>
          <div class="bottom-buttonn">
            <a href="#" class="firstlink">전화상담 예약</a>
            <a href="#">오시는 길</a>
          </div>
        </div>

      </div>
      <!-- Mobile link  -->
    </div>
  </div>
  <!-- Single bottom link and button  -->
</div>
<!-- Middle Baner and link section  -->

<!-- Video Bottom Vide section  -->
<div class="video-bottom-video-list-section">
  <div class="n-container">
    <h2 class="list-top-title">관련 영상</h2>
  </div>
  <div class="list-border"></div>
  <div class="n-container">
    <div id="articles" class="latest-video-section video-inner-bottom-list">
      <div class="articles-container video-inner-articles-container">
        <div class="article">
          <a href="javascript:void(0);"><img class="mythumnail" src="{{ asset ('website/assets/images/img-01.png') }}" alt=""></a>

          <a href="javascript:void(0);" class="bottom-video-link">코드에셋, 세계 최초 코드 기반 통합 플랫폼 ‘코드맵’ 개발 성공 안녕하세요 안녕하세요 안녕하세...</a>
          <div class="category-box">
            <span class="category-1">
              <p class="red-14">유라이크코리아</p>
            </span>
            <p class="grey-14">06/16/2021</p>
          </div>
        </div>

        <div class="article">
          <a href="javascript:void(0);"><img class="mythumnail" src="{{ asset ('website/assets/images/img-01.png') }}" alt=""></a>
          <a href="javascript:void(0);" class="bottom-video-link">코드에셋, 세계 최초 코드 기반 통합 플랫폼 ‘코드맵’ 개발 성공 안녕하세요 안녕하세요 안녕하세...</a>
          <div class="category-box">
            <span class="category-1">
              <p class="red-14">유라이크코리아</p>
            </span>
            <p class="grey-14">06/16/2021</p>

          </div>
        </div>

        <div class="article">
          <a href="javascript:void(0);"><img class="mythumnail" src="{{ asset ('website/assets/images/img-01.png') }}" alt=""></a>
          <a href="javascript:void(0);" class="bottom-video-link">코드에셋, 세계 최초 코드 기반 통합 플랫폼 ‘코드맵’ 개발 성공 안녕하세요 안녕하세요 안녕하세...</a>
          <div class="category-box">
            <span class="category-1">
              <p class="red-14">유라이크코리아</p>
            </span>
            <p class="grey-14">06/16/2021</p>

          </div>
        </div>

        <div class="article">
          <a href="javascript:void(0);"><img class="mythumnail" src="{{ asset ('website/assets/images/img-01.png') }}" alt=""></a>
          <a href="javascript:void(0);" class="bottom-video-link">코드에셋, 세계 최초 코드 기반 통합 플랫폼 ‘코드맵’ 개발 성공 안녕하세요 안녕하세요 안녕하세...</a>
          <div class="category-box">
            <span class="category-1">
              <p class="red-14">유라이크코리아</p>
            </span>
            <p class="grey-14">06/16/2021</p>

          </div>
        </div>

        <div class="article">
          <a href="javascript:void(0);"> <img class="mythumnail" src="{{ asset ('website/assets/images/img-01.png') }}" alt=""></a>
          <a href="javascript:void(0);" class="bottom-video-link">코드에셋, 세계 최초 코드 기반 통합 플랫폼 ‘코드맵’ 개발 성공 안녕하세요 안녕하세요 안녕하세...</a>
          <div class="category-box">
            <span class="category-1">
              <p class="red-14">유라이크코리아</p>
            </span>
            <p class="grey-14">06/16/2021</p>

          </div>
        </div>

        <div class="article">
          <a href="javascript:void(0);"> <img class="mythumnail" src="{{ asset ('website/assets/images/img-01.png') }}" alt=""></a>
          <a href="javascript:void(0);" class="bottom-video-link">코드에셋, 세계 최초 코드 기반 통합 플랫폼 ‘코드맵’ 개발 성공 안녕하세요 안녕하세요 안녕하세...</a>
          <div class="category-box">
            <span class="category-1">
              <p class="red-14">유라이크코리아</p>
            </span>
            <p class="grey-14">06/16/2021</p>

          </div>
        </div>

        <div class="article">
          <a href="javascript:void(0);"> <img class="mythumnail" src="{{ asset ('website/assets/images/img-01.png') }}" alt=""></a>
          <a href="javascript:void(0);" class="bottom-video-link">코드에셋, 세계 최초 코드 기반 통합 플랫폼 ‘코드맵’ 개발 성공 안녕하세요 안녕하세요 안녕하세...</a>
          <div class="category-box">
            <span class="category-1">
              <p class="red-14">유라이크코리아</p>
            </span>
            <p class="grey-14">06/16/2021</p>

          </div>
        </div>

        <div class="article">
          <a href="javascript:void(0);"> <img class="mythumnail" src="{{ asset ('website/assets/images/img-01.png') }}" alt=""></a>
          <a href="javascript:void(0);" class="bottom-video-link">코드에셋, 세계 최초 코드 기반 통합 플랫폼 ‘코드맵’ 개발 성공 안녕하세요 안녕하세요 안녕하세...</a>
          <div class="category-box">
            <span class="category-1">
              <p class="red-14">유라이크코리아</p>
            </span>
            <p class="grey-14">06/16/2021</p>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Video Bottom Vide section  -->

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


  var video = document.getElementById('video-1');
  var c = document.getElementsByClassName("videoLink");

  for (let h = 0; h < c.length; h++) {
    c[h].addEventListener('click', change)
  }

  function change() {
    var parent = this.parentElement;
    var info = parent.getElementsByClassName('posts-txt');
    var names = parent.querySelectorAll('p');
    var videoName = document.getElementById('videoName');
    var category = document.getElementById('videoCategory');
    var dateOfVide = document.getElementById('videoDate');
    var source = parent.querySelector('span');
    source.innerText + "?autoplay=1";
    console.log(source);
    // video.setAttribute('src', 'source' )
    video.setAttribute('src', source.innerText);

    videoName.innerText = names[0].innerText;
    videoCategory.innerText = names[1].innerText;
    videoDate.innerText = names[2].innerText;
  }
</script>
@endsection