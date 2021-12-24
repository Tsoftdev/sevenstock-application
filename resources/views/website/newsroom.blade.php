@extends('website.layouts.webapp')
@section('title', 'NewsRoom')
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
                <a class="nav-link toplink toplinkactive" href="{{ url('newsroom') }}">뉴스룸</a>
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
              <li><a href="{{ url ('newsroom') }}" class="{{$active_tag ? '' : 'myactive'}}">전체보기</a></li>
              @foreach ($tags as $tag)
              <li><a href="{{ url ('newsroom') }}/{{$tag->id}}" class="{{($active_tag && $active_tag->id == $tag->id) ? 'myactive' : ''}}">{{$tag->keyword}}</a></li>
              @endforeach
            </ul>
          </div>
        </div>
        <div class="right">
          <div class="right-menu">
            <ul>
              <li><a class="right" href="{{ url ('newsroom') }}">보도자료</a></li>
              <li><a class="left" href="{{ url ('video') }}">동영상</a></li>
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
    <div class="n-container">
      <div class="press-video">
        <div class="press">
          <a href="{{ url('newsroom') }}">보도자료</a>
        </div>
        <div class="video">
          <a href="{{ url('video') }}">동영상</a>
        </div>
      </div>
    </div>
    <ul>
      <li><a href="#">전체보기</a></li>
      <li><a href="#">유라이크 코리아</a></li>
      <li><a href="#">알파도</a></li>
      <li><a href="#">코드에셋</a></li>
      <li><a href="#">세븐스톡 홀딩스</a></li>
    </ul>
  </div>
  <!-- Accordion List  -->


</section>

@if ($active_tag == null)
<section>
  <!-- Second Section  -->
  <div class="second-news-section">
    <div class="n-container">
      <div class="row">
        <div class="col-md-8">
          @if ($rec1)
          <a href="{{ url ('news') }}/{{$rec1->news->id}}" style="display:block;">
            <div class="left-inner" style="background-image: url({{ $rec1->news->images[0]}}); background-size: cover;">
              <div class="bottom-section">
                <div class="news-category-box">
                  <div class="left" style="background:{{$rec1->news->tag->color}};">
                    <p>{{ $rec1->news->tag->keyword }}</p>
                  </div>
                  @php
                  $date_now = Carbon\Carbon::parse($rec1->news->date)->format('d/m/Y');
                  @endphp
                  <div class="right">
                    <p>{{ $date_now }}</p>
                  </div>
                </div>
                <span style="color:#fff; font-size: 20px">{{ $rec1->news->title }}</span>
              </div>
            </div>
          </a>
          @endif
        </div>
        <div class="col-md-4">
          @if ($rec2)
          <div class="right-inner">
            <div class="news-category-box">
              <div class="left" style="background:{{$rec2->news->tag->color}};">
                <p style="color: #fff;">{{ $rec2->news->tag->keyword }}</p>
              </div>
              <div class="right">
                @php
                $date_now = Carbon\Carbon::parse($rec2->news->date)->format('d/m/Y');
                @endphp
                <p>{{$date_now}}</p>
              </div>
            </div>
            <a href="{{ url ('news') }}/{{$rec2->news->id}}">{{ $rec2->news->title }}</a>
          </div>
          @endif
          @if ($rec3)
          <div class="right-inner">
            <div class="news-category-box">
              <div class="left" style="background:{{$rec3->news->tag->color}};">
                <p style="color: #fff;">{{ $rec3->news->tag->keyword }}</p>
              </div>
              <div class="right">
                @php
                $date_now = Carbon\Carbon::parse($rec3->news->date)->format('d/m/Y');
                @endphp
                <p>{{$date_now}}</p>
              </div>
            </div>
            <a href="{{ url ('news') }}/{{$rec3->news->id}}">{{ $rec3->news->title }}</a>
          </div>
          @endif
          @if ($rec4)
          <div class="right-inner">
            <div class="news-category-box">
              <div class="left" style="background:{{$rec4->news->tag->color}};">
                <p style="color: #fff;">{{ $rec4->news->tag->keyword }}</p>
              </div>
              <div class="right">
                @php
                $date_now = Carbon\Carbon::parse($rec4->news->date)->format('d/m/Y');
                @endphp
                <p>{{$date_now}}</p>
              </div>
            </div>
            <a href="{{ url ('news') }}/{{$rec4->news->id}}">{{ $rec4->news->title }}</a>
          </div>
          @endif
        </div>
      </div>
    </div>
  </div>
  <!-- Second Section  -->
</section>
@endif

<!-- Latest News Section  -->
<section>
  <div class="latest-news-section">
    <div class="n-container">
      <div class="latest-news-inner">
        <h2>
          @if ($active_tag)
          {{$active_tag->keyword}}
          @else
          최신 뉴스
          @endif
        </h2>
        <div class="row latest-inner">
          <div class="col-md-9">
            @foreach ($news as $n)

            <!-- Post Box  -->
            <div class="left-inner-section Post-box">
              <div class="left-section">
                <a href="{{ url ('news') }}/{{$n->id}}">
                  <div class="overflow">
                    @if ($n->images)
                    <img src="{{$n->images[0]}}">
                    @else
                    <img src="http://ssdd.tech/sample/thumbnail.png">
                    @endif
                  </div>
                </a>

              </div>
              <div class="right-section">
                <div class="right-inner">
                  <div class="news-category-box">
                    @if($n->tag)
                    <div class="left" style="background:{{$n->tag->color}}; ">
                      <p style="color:#fff;">{{$n->tag->keyword}}</p>
                    </div>
                    @else
                    <strong class="pe-2">(Untag)</strong>
                    @endif
                    <div class="right">
                      @php
                      $date_now = Carbon\Carbon::parse($n->date)->format('Y-m-d');
                      @endphp
                      <p>{{$date_now}}</p>
                    </div>
                  </div>
                  <a href="{{ url ('news') }}/{{$n->id}}">{{$n->title}}</a>
                  <p>
                    {{Illuminate\Support\Str::limit(strip_tags($n->description), 200)}}
                  </p>
                </div>
              </div>
            </div>
            <!-- /Post Box  -->
            @endforeach
          </div>
          <div class="col-md-3">
            @if($newsroom_banner_1)
            <p>
              <img width="100%" src="{{ $newsroom_banner_1->image }}" alt="">
            </p>
            @endif
            @if($newsroom_banner_2)
            <p>
              <img width="100%" src="{{ $newsroom_banner_2->image }}" alt="">
            </p>
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