@extends('website.layouts.webapp')
@section('title', 'NewsRoomDetail')
@section('css')
<!--Owl Carouse css-->
<link rel="stylesheet" href="{{ asset('website/css/owl.carousel.min.css') }}" />
<link rel="stylesheet" href="{{ asset('website/css/owl.theme.default.min.css') }}" />
<style>
  img.img-responsive {
    width: 100%;
    height: auto;
  }
</style>
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


<!-- Single Section  -->
<section>
  <div class="mysingle-wrapper">
    <div class="n-container">
      <div class="single-inner">
        <div class="left mobilesingle">
          <!-- Date and Author  -->
          <div class="news-category-box">
            @if($news->tag)
            <div class="left" style="background:{{$news->tag->color}};">
              <p style="color:#fff;">{{$news->tag->keyword}}</p>
            </div>
            @else
            <strong class="pe-2">(Untag)</strong>
            @endif
            <div class="right topdate">
              @php
              $date = Carbon\Carbon::parse($news->date)->format('d/m/Y');
              @endphp
              <p>{{$date}}</p>
            </div>
          </div>
          <!-- Date and Author  -->
          <!-- Title  -->
          <div class="single-title">
            <h3>{{$news->title}}</h3>
          </div>
          <!-- Title  -->

          {!!$news->description !!}
        </div>

        <!-- Mobile Single  -->
        <div class="mobile-single">
          <img src="{{ asset ('website/assets/images/compass.png') }}" alt="">
          <h3>세계최초 글로벌 특허기반으로 만들어진 ‘코드맵’</h3>
          <!-- Date and Author  -->
          <div class="news-category-box">
            <div class="left">
              <p>유라이크코리아</p>
            </div>
            <div class="right topdate">
              <p>06/16/2021</p>
            </div>
          </div>
          <!-- Date and Author  -->
          <!-- para  -->
          <div class="para">
            <p>특허기반으로 한글의 자음과 모음을 코드화한 코드맵 개발에 성공했다. 현재는 본격 서비스를 앞두고 테스트 중이다. 에셋 대표는 “글로벌 특허기반으로 한글의 자음과 모음을 코드화 셋 대표는 “글로벌 특허기반으로 한글의 자음과 모음을 코드화 양원진 코드에셋 대표는</p>
            <p>특허기반으로 한글의 자음과 모음을 코드화한 코드맵 개발에 성공했다. 현재는 본격 서비스를 앞두고 테스트 중이다. 에셋 대표는 “글로벌 특허.</p>
          </div>
          <!-- para  -->
        </div>
        <!-- Mobile Single  -->

        <div class="right recent">
          <!-- Featured Section  -->
          <h5>추천 뉴스</h5>
          @if($news_inner_recommend)
          @foreach ($news_inner_recommend as $news_rec)
          <!-- Featured Box  -->
          <div class="featured-section-inner">
            <div class="left">
              <a href="{{ url('news/' . $news_rec->news->id) }}">
                @if ($news_rec->news)
                <img src="{{$news_rec->news->images[0]}}" alt="">
                @else
                <img src="http://ssdd.tech/sample/thumbnail.png">
                @endif
              </a>
            </div>
            <div class="right feat-right">
              <a href="{{ url('news/' . $news_rec->news->id) }}">{{$news_rec->news->title}}</a>
              <div class="news-category-box">
                <div class="left" style="background:{{$news_rec->news->tag->color}};">
                  <p style="color: #ffffff;">{{$news_rec->news->tag->keyword}}</p>
                </div>
                @php
                $date = Carbon\Carbon::parse($news_rec->news->date)->format('d/m/Y');
                @endphp
                <div class="right">
                  <p>{{$date}}</p>
                </div>
              </div>
            </div>
          </div>
          <!-- Featured Box  -->
          @endforeach
          @endif

          <div class="myadd">
            <h5>지금 보고 계시는 기업의 정보가
              궁금하다면?</h5>
            <h2>ULIKEKOREA</h2>
            <a href="#">기업정보 확인하기</a>
          </div>
          <!-- Featured Section  -->
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Single Section  -->

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
            <a href="#">문의하기</a>
          </div>
        </div>
        <p>20년의 노하우로 기업가치 상승을 위한 성공적인 전략을 제시합니다.</p>
      </div>
      <div class="right">
        <div class="button-wrapper">
          <a href="{{ url ('contact-us') }}" class="firstlink">전화상담 예약</a>
          <a href="{{ url ('contact-us') }}">오시는 길</a>
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

<!-- Latest News Section  -->
<section>
  <div class="single-latest-news-section">
    <div class="n-container">
      <div class="latest-news-inner">
        <h2>최신 뉴스</h2>
        <div class="row latest-inner">
          <div class="col-md-12">
            @if($related_news)
            @foreach ($related_news as $rel_news)
            <!-- Post Box  -->
            <div class="left-inner-section Post-box">
              <div class="left-section">
                <a href="#">
                  <div class="overflow">
                    @if ($rel_news->news)
                    <img src="{{ $rel_news->images[0] }}" alt="">
                    @else
                    <img src="http://ssdd.tech/sample/thumbnail.png">
                    @endif

                  </div>
                </a>
              </div>
              <div class="right-section">
                <div class="right-inner">
                  <div class="news-category-box">
                    <div class="left" style="background:{{$rel_news->tag->color}};">
                      <p style="color: #fff">{{ $rel_news->tag->keyword }}</p>
                    </div>
                    <div class="right">
                      @php
                      $date_now = Carbon\Carbon::parse($rel_news->date)->format('d/m/Y');
                      @endphp
                      <p>{{$date_now}}</p>
                    </div>
                  </div>
                  <a href="#">{{ $rel_news->title }}</a>
                  <p>{!! Illuminate\Support\Str::limit(strip_tags($rel_news->description), 200) !!}</p>
                </div>
              </div>
            </div>
            <!-- Post Box  -->
            @endforeach
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Latest News Section  -->

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