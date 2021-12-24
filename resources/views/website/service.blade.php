@extends('website.layouts.webapp')
@section('title', 'Consulting')
@section('content')
<section>
  <div class="news-header service-header">
    <div class="n-container">
      <div class="header-top service-header-top">
        <nav class="navbar navbar-expand-lg navbar-light">
          <a class="navbar-brand" href="/"><img src="{{ asset ('website/assets/images/logo.svg') }}" alt="" /></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText"
            aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
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
                <a class="nav-link toplink toplinkactive" href="{{ url('service') }}">서비스</a>
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

<!-- Service top section  -->
<div class="service-top-section">
  <div class="n-container">
    <div class="service-top-inner-wrapper">
      <div class="service-top-inner-left">
        <div class="stop">
          <h6>상장예정기업 전문 컨설팅 No.1</h6>
        </div>
        <h1>세븐스톡을 만나는 것만으로도<br /><span>이기는 게임</span>이 시작된다.</h1>
        <p>20년 노하우를 바탕으로 미래 가능성이 높은 기업을 발굴 및 검증하여<br>
          7STOCK만의 전략을 통한 컨설팅과 기업가치 관리로<br />
          보다 높은 밸류의 성공적인 투자유치를 이끌어 냅니다..</p>
      </div>
      <div class="service-top-inner-right">
        <div class="stop-right-img">
          <img src="{{ asset ('website/assets/images/service-top-right.svg') }}" alt="">
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Service top section  -->

<!-- 3 Up Section  -->
<div class="three-up-section">
  <div class="n-container">
    <div class="three-up-inner-wrapper">
      <div class="three-up-inner-left">
        <img src="{{ asset ('website/assets/images/three-up-left.svg') }}" alt="">
      </div>
      <div class="three-up-inner-right">
        <div class="three-right-top-wrapper">
          <div class="three-right-top-left">
            <h1>3 UP</h1>
          </div>
          <div class="three-right-top-right">
            <p>Package</p>
          </div>
        </div>
        <h3>기업의 가치창출을 위한 3가지 핵심</h3>
        <p>검증을 마친 기업에 대해 본격적인 투자 컨설팅을 시작으로 적극적인 홍보<br />
          상장을 위한 전문 인력 투입 등 기업이 본연의 역할에 집중할 수 있도록<br />
          역량을 업그레이드하고 환경을 조성하는 역할을 합니다.</p>
      </div>
    </div>
  </div>
</div>
<!-- 3 Up Section  -->


<!-- ato z section  -->
<div class="atoz-section">
  <div class="n-container">
    <div class="atoz-service-inner">
      <div class="atoz-inner-left">
        <h2>처음부터 끝까지!<br />
          세븐스톡은 모든 걸 함께합니다.</h2>
        <div class="nstair-list">
          <ul>
            <li><img src="{{ asset ('website/assets/images/stair1.svg') }}" alt="">
              <span>홍보·마케팅·영업
              </span>
            </li>
            <li><img src="{{ asset ('website/assets/images/stair2.svg') }}" alt="">
              <span>투자유치</span>
            </li>
            <li><img src="{{ asset ('website/assets/images/stair3.svg') }}" alt="">
              <span>신주발행</span>
            </li>
            <li><img src="{{ asset ('website/assets/images/stair4.svg') }}" alt="">
              <span>구주매각</span>
            </li>
            <li><img src="{{ asset ('website/assets/images/stair5.svg') }}" alt="">
              <span>M&amp;A 컨설팅</span>
            </li>
            <li><img src="{{ asset ('website/assets/images/stair6.svg') }}" alt="">
              <span>IPO 컨설팅</span>
            </li>

          </ul>
        </div>
      </div>
      <div class="atoz-inner-right">
        <img class="atoz-iamge" src="{{ asset ('website/assets/images/latesthocky.svg') }}" alt="">
        <img class="atoz-iamge1366" src="{{ asset ('website/assets/images/atoz-1366.svg') }}" alt="">
        <img class="atoz-iamge1280" src="{{ asset ('website/assets/images/atoz-1280.svg') }}" alt="">
        <img class="atoz-iamge1152" src="{{ asset ('website/assets/images/atoz-1152.svg') }}" alt="">
        <img class="atoz-iamge1024" src="{{ asset ('website/assets/images/atoz-1024.svg') }}" alt="">
        <img class="atoz-iamge414" src="{{ asset ('website/assets/images/atoz-414.svg') }}" alt="">
      </div>
    </div>


  </div>
  <h1 class="atoz">A to Z</h1>
</div>
<!-- ato z section  -->







<!-- Process Section  -->
<div class="process-section">
  <div class="n-container">
    <div class="process-section-inner">
      <h2>세븐스톡의 독보적인 <span>Process</span></h2>
      <img class="processbigimg" src="{{ asset ('website/assets/images/process.svg' ) }}" alt="">
      <img class="processmobileimg" src="{{ asset ('website/assets/images/processmobile.svg') }}" alt="">
      <img class="processSmallimg" src="{{ asset ('website/assets/images/processSmall.svg') }}" alt="">
      <p>세븐스톡은 기업을 대변하여 IPO 상장을 위한 길라잡이가 되어주며<br />
        본업에만 집중할 수 있도록 기업 성장을 위한 전문 컨설팅을 도와드립니다.</p>
    </div>
  </div>
</div>
<!-- Process Section  -->



<!-- Bottom Graph Section  -->
<div class="grap-section">
  <div class="n-container">
    <div class="grap-section-inner">
      <div class="grap-section-left">
        <img src="{{ asset ('website/assets/images/grapimage.svg') }}" alt="">
      </div>
      <div class="grap-section-right">
        <h3>세븐스톡의</h3>
        <h2>드라마틱한 가치창출</h2>
        <p>확실한 전략, 확실한 가치 상승<br />
          이제 세븐스톡에서 만나보세요!</p>
        <a href="{{ url('contact-us') }}" class="bottom-grap-btn">문의하기</a>
      </div>
    </div>
  </div>
</div>
<!-- Bottom Graph Section  -->





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
