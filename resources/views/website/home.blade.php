@extends('website.layouts.webapp')
@section('title', 'Index')
@section('content')
<section class="smoth-scroll">
  <div class="myheader">
    <div class="header-top">
      <div class="mycontainer">
        <nav class="navbar navbar-expand-lg navbar-light">
          <a class="navbar-brand" href="/"><img src="{{ asset('website/assets/images/logo.svg' ) }}" alt="" /></a>
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
    <div class="mobile-wrapper">
      <div class="mobile-header-menu" id="mobile-header">
        <div class="left">
          <a href="/"><img src="{{ asset('website/assets/images/mobilelogo.svg' ) }}" alt=""></a>
        </div>
        <div class="right">
          <div class="myicon">
            <i class="fa fa-ellipsis-h menu-dots" id="menu-dots" aria-hidden="true"></i>
            <span class="cross"> &times; </span>
          </div>
        </div>
      </div>

      <div class="mymobile-menu">
        <ul>
          <li><a href="{{ asset('consultmain') }}">컨설팅 중인 기업</a></li>
          <li><a href="{{ asset('newsroom') }}">뉴스룸</a></li>
          <li><a href="{{ asset('about-us') }}">회사소개</a></li>
          <li><a href="{{ asset('service') }}">서비스</a></li>
          <li><a href="{{ asset('blog') }}">블로그</a></li>
          <li><a href="{{ asset('contact-us') }}">상담문의</a></li>
        </ul>
        <div class="mphone">
          <a class="mobile-phone" href="tel:832 939 8280"><i class="fa fa-phone" aria-hidden="true"></i>&nbsp;
            02-529-1001</a>
        </div>

      </div>
    </div>


    <div class="middle-part">
      <div class="mycontainer image-wrapper">
        <div class="left">
          <h5 data-aos="fade-down-right" data-aos-delay="200">세븐스톡 홀딩스</h5>
          <h1 data-aos="fade-right" data-aos-delay="200">
            기업의 가치를 더하다.<br />
            <span>상장예정기업 전문 컨설팅 No.1</span>
          </h1>
          <p data-aos="fade-left" data-aos-delay="200">
            다이아몬드 원석처럼 미래가치가 높은 스타트업을 발굴하여<br />
            세븐스톡만의 밸류업 프로세스를 통해 기업의 가치를 향상시키는<br />
            IPO 전문 컨설팅 기업입니다.
          </p>
          <div class="mybutton" data-aos="fade-up" data-aos-delay="200">
            <a href="{{ asset('contact-us') }}">전화상담 예약하기</a>
          </div>
        </div>
        <div class="right">
          <img data-aos="zoom-in" data-aos-delay="300" src="{{ asset('website/assets/images/image.png' ) }}" alt="" />
        </div>
      </div>
    </div>
    <div class="bottom-left">
      <div class="mycontainer">
        <ul data-aos="fade-right" data-aos-delay="200">
          <li>
            <img src="{{ asset('website/assets/images/bottomleft1.svg' ) }}" alt="" />
            <span>500%</span><br />
            <span class="bottom-text">기업평균성장률</span>
          </li>
          <li>
            <img src="{{ asset('website/assets/images/bottomleft2.svg' ) }}" alt="" />
            <span>2/1000</span><br />
            <span class="bottom-text">컨설팅 의뢰 수 (현재/총)</span>
          </li>
        </ul>
      </div>

    </div>
    <div class="bottom-right" data-aos="fade-left" data-aos-delay="200">
      <ul>
        <li>
          <p class="top">송 &nbsp; 영 &nbsp; 봉 &nbsp; 의장</p>
        </li>
        <li>
          <p class="bottom">세븐스톡 홀딩스</p>
        </li>
      </ul>
    </div>
    <div class="image-background" data-aos="zoom-in-left" data-aos-delay="100"></div>
  </div>
</section>

<!-- Second Section  -->
<section class="smoth-scroll">
  <div class="second-section">
    <div class="mycontainer">
      <div class="second-sectin-inner">
        <div class="left-section" data-aos="fade-up-left" data-aos-delay="200">
          <img src="{{ asset('website/assets/images/img-1.png' ) }}" alt="" />
        </div>
        <div class="right-section" data-aos="fade-up-right" data-aos-delay="200">
          <h2>
            세븐스톡 홀딩스는<br />
            <span class="middle">다를 수 밖에</span>
            <span class="last">없습니다.</span>
          </h2>
          <p>
            딜러를 통제하고 컨트롤 함으로써 기업의 가치를<br />
            가장 정상적이고 긍정적인 방향으로 컨설팅 합니다.
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- /Second Section  -->

<!-- Third Section  -->
<section class="smoth-scroll">
  <div class="third-section">
    <div class="mycontainer">
      <div class="third-section-inner">
        <div class="left-section" data-aos="fade-down-right" data-aos-delay="200">
          <h2>
            검증된 소수의 기업만을<br />
            <span>집중 컨설팅</span> 합니다.
          </h2>
          <p>
            세븐스톡만의 엄격한 선정 기준과 철저한 현장 검증 및 사실
            확인을 통해<br />0.3%의 보석을 발굴합니다.
          </p>
          <div class="ceo-section">
            <div class="ceo-list">
              <ul>
                <li>
                  <span class="ceo_check"><img src="{{ asset('website/assets/images/red-check.svg' ) }}" alt="" />&nbsp;
                    CEO 마인드</span>
                </li>
                <li>
                  <span>
                    <img src="{{ asset('website/assets/images/green-check.svg' ) }}" alt="" />&nbsp;
                    상장성</span>
                </li>
              </ul>
            </div>
            <div class="ceo-list">
              <ul>
                <li>
                  <span>
                    <img src="{{ asset('website/assets/images/green-check.svg' ) }}" alt="" />&nbsp;
                    저평가 가치주
                  </span>
                </li>
                <li>
                  <span><img src="{{ asset('website/assets/images/green-check.svg' ) }}" alt="" />&nbsp; 사업성</span>
                </li>
              </ul>
            </div>
            <div class="ceo-list">
              <ul>
                <li>
                  <span>
                    <img src="{{ asset('website/assets/images/green-check.svg' ) }}" alt="" />&nbsp;
                    기술성</span>
                </li>
                <li>
                  <span>
                    <img src="{{ asset('website/assets/images/green-check.svg' ) }}" alt="" />&nbsp;
                    시장성</span>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="right-section" data-aos="fade-down-left" data-aos-delay="200">
          <img src="{{ asset('website/assets/images/pyramid.png' ) }}" alt="" />
        </div>
      </div>
    </div>
  </div>
</section>

<!-- /Third Section  -->

<!-- Fourth Section  -->
<section class="smoth-scroll">
  <div class="fourth-section">
    <div class="mycontainer">
      <div class="fourth-section-inner">
        <div class="left-section" data-aos="flip-up" data-aos-delay="200">
          <img src="{{ asset('website/assets/images/graph1.png' ) }}" alt="" />
        </div>
        <div class="right-section" data-aos="flip-down" data-aos-delay="200">
          <h2>
            컨설팅 받은<br />
            기업가치의 변화
          </h2>
          <p>
            세븐스톡은 기업의 도약을 위한 발판이 되어줍니다.<br />
            상상만 하던 이상을 현실로 만들어내는 곳 세븐스톡 홀딩스.<br />
            오로지 기업의 성장과 기업가치 상승을 위한 선택만을 고집합니다.
          </p>
          <div class="bottom-section bottom-arrow">
            <img src="{{ asset('website/assets/images/arrow-right.svg' ) }}" class="right-arrow" alt="">
            <img src="{{ asset('website/assets/images/secondarrow.png' ) }}" class="right-small-arrow" alt="">
            <div class="left">
              <div class="top">
                <p>컨설팅 전</p>
              </div>
              <div class="bottom">
                <h4>30억 원</h4>
                <p>기업가치</p>
              </div>
            </div>
            <div class="right">
              <div class="top">
                <p>컨설팅 후</p>
              </div>
              <div class="bottom">
                <h4>1,500억 원</h4>
                <p>기업가치</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- /Fourth Section  -->

<!-- Fifth Section  -->
<section class="smoth-scroll">
  <div class="fifth-section">
    <div class="mycontainer">
      <div class="row">
        <div class="col-xl-6 col-12 col-sm-12" data-aos="zoom-in" data-aos-delay="200">
          <div class="left">
            <h1>방문자 후기</h1>
            <p>방문자 후기는 방문상담을 하신 고객님들이 직접 남겨주신<br />실제 후기 내용입니다.</p>
            <a href="{{ url('contact-us') }}">방문상담 예약하기</a>
          </div>
        </div>
        <!-- Slider  -->
        <div class="col-xl-6 col-12 col-sm-12">
          <!-- My Splide Story Wrapper  -->
          <div class="mystory-wrapper">
            <div class="splide" data-aos="fade-left" data-aos-delay="200">
              <div class="splide__track">
                <ul class="splide__list">
                  @foreach($reviews as $review)
                  <li class="splide__slide">
                    <div class="story-section">
                      <img src="{{ asset('website/assets/images/queto.svg' ) }}" alt="" />
                      <p class="top-para">
                        {{$review->review}}
                      </p>
                      <h3>{{$review->name}}</h3>
                      <p class="bottm-para">{{$review->company}}</p>
                    </div>
                  </li>
                  @endforeach
                </ul>
              </div>
            </div>
          </div>
          <!-- My Slider Story Wrapper  -->
        </div>
        <!-- Slider  -->
      </div>
    </div>
    <div class="bottom-bg"></div>
  </div>
  </div>
</section>
<!-- Fifth Section  -->

<!-- Map Section  -->
<section class="smoth-scroll">
  <div class="map-section">
    <div class="mycontainer">
      <div class="section s6">
        <!--  SECTION - 5 -->
        <div class="section-s">
          <div class="section-5 map-small-wrapper">
            <div class="map">
              <div class="map-hat">
                <span id="map-span">
                  <img src="{{ asset('website/assets/images/loud.svg' ) }}" alt="" />
                  <p class="">
                    {{$we_are_here}}
                  </p>
                </span>

                <div class="map-btns">
                  <button onclick="window.open('{{$pdf1}}');">건물 주변 사진</button>
                  <button onclick="window.open('{{$pdf2}}');">지하철 길 안내</button>
                </div>
              </div>

              <div class="map-container">
                <div id="map" class="mymap">
                  <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d33200186.357146237!2d117.70622513720585!3d-25.18311067068857!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2b2bfd076787c5df%3A0x538267a1955b1352!2sAustralia!5e0!3m2!1sen!2sbd!4v1631175512159!5m2!1sen!2sbd"
                    width="100%" height="100%" style="border: 0; border-radius: 10px" allowfullscreen="" loading="lazy">
                  </iframe>
                </div>
              </div>
            </div>

            <div class="section-5-text">
              <div class="map-header">
                <p class="black-40">오시는 길</p>
              </div>

              <ul class="map-list" id="map-left-side">
                @if($address)
                <li>
                  <div>
                    <p class="grey-19-l">주소</p>
                    <img src="{{ asset('website/assets/images/map-icons.svg' ) }}" alt="copy" class="copyIcon" />
                  </div>
                  <div class="popup">
                    <span class="popuptext">Text copied</span>
                  </div>

                  <p class="black-18-400">
                    {{$address}}
                  </p>
                </li>
                @endif
                @if($office_number)
                <li>
                  <div>
                    <p class="grey-19-l">연락처</p>
                    <img src="{{ asset('website/assets/images/map-icons.svg' ) }}" alt="copy" class="copyIcon" />
                  </div>

                  <div class="popup">
                    <span class="popuptext">Text copied</span>
                  </div>

                  <p class="black-18-400">{{$office_number}}</p>
                </li>
                @endif
                @if($fax_number)
                <li>
                  <div>
                    <p class="grey-19-l">팩스번호</p>
                    <img src="{{ asset('website/assets/images/map-icons.svg' ) }}" alt="copy" class="copyIcon" />
                  </div>

                  <div class="popup">
                    <span class="popuptext">Text copied</span>
                  </div>

                  <p class="black-18-400">{{$fax_number}}</p>
                </li>
                @endif
                @if($email)
                <li>
                  <div>
                    <p class="grey-19-l">이메일</p>
                    <img src="{{ asset('website/assets/images/map-icons.svg' ) }}" alt="copy" class="copyIcon" />
                  </div>

                  <div class="popup">
                    <span class="popuptext">Text copied</span>
                  </div>
                  <p class="black-18-400">{{$email}}</p>

                </li>
                @endif
              </ul>

              <button class="map-btn" onclick="window.location.href='{{$map_link}}'">네이버/카카오 지도로
                검색하기</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Map Section  -->

<!-- Footer  -->

<div class="myfooter">
  <div class="mycontainer">
    <div class="footer-inner">
      <div class="left-section" data-aos="fade-right" data-aos-delay="300">
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
      <div class="right-section" data-aos="fade-left" data-aos-delay="300">
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

<!-- Splide Slider  -->
<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js"></script>

<!-- <script>
// Splide Slider

var direction = "ttb";
var gap = "30px";

if ($(window).width() <= 1152) {
  direction = "ltr";
}
if ($(window).width() <= 575) {
  gap = "200px";
}
new Splide(".splide", {
  rewind: true,
  direction: direction,
  heightRatio: "1",
  perPage: 3,
  arrows: false,
  autoHeight: true,
  perMove: true,
  gap: gap,
  autoplay: false,
  pauseOnHover: true,
  breakpoints: {
    1152: {
      perPage: 1,
    },
  },
}).mount();
// Splide Slider

var y = document.getElementById("map-left-side").querySelectorAll("img");

for (let i = 0; i < y.length; i++) {
  y[i].addEventListener("click", copy);
}

function copy() {
  /* Get the text field */
  var copyText =
    this.parentElement.parentElement.getElementsByClassName(
      "black-18-400"
    );
  var popup =
    this.parentElement.parentElement.getElementsByClassName("popup");
  var g = popup[0].querySelectorAll("span");
  /* Select the text field */
  /* Copy the text inside the text field */
  navigator.clipboard.writeText(copyText[0].innerText);

  g[0].classList.add("show");
  setTimeout(function() {
    g[0].classList.remove("show");
  }, 2000);
}
</script> -->


<script>
// Splide Slider

var direction = "ttb";
var gap = "30px";

if ($(window).width() <= 1152) {
  direction = "ltr";
}
if ($(window).width() <= 575) {
  gap = "200px";
}
new Splide(".splide", {
  rewind: true,
  direction: direction,
  heightRatio: "1",
  perPage: 3,
  arrows: false,
  autoHeight: true,
  perMove: true,
  gap: gap,
  autoplay: false,
  pauseOnHover: true,
  breakpoints: {
    1152: {
      perPage: 1,
    },
  },
}).mount();
// Splide Slider

var y = document.getElementById("map-left-side").querySelectorAll("img");
// Footer Phone No copy
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

// Footer Phone No Copy

for (let i = 0; i < y.length; i++) {
  y[i].addEventListener("click", copy);
}

function copy() {
  /* Get the text field */
  var copyText =
    this.parentElement.parentElement.getElementsByClassName(
      "black-18-400"
    );
  var popup =
    this.parentElement.parentElement.getElementsByClassName("popup");
  var g = popup[0].querySelectorAll("span");
  /* Select the text field */
  /* Copy the text inside the text field */
  navigator.clipboard.writeText(copyText[0].innerText);

  g[0].classList.add("show");
  setTimeout(function() {
    g[0].classList.remove("show");
  }, 2000);
}
</script>
<!-- Splide Slider  -->
@endsection