@extends('website.layouts.webapp')
@section('title', 'ContactUs')
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
                <a class="nav-link toplink toplinkactive" href="{{ url('contact-us') }}">상담문의</a>
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

  <!-- Contact Section  -->
  <div class="mycontact-wrapper-full">
    <div class="section-m">
      <div class="grey-bg-3 mygrey-bg">
        <div class="n-container">
          <div class="contact-header mycontact-header">
            <p class="black-36 ctop-text">상장예정기업 & 기업 컨설팅 문의
            </p>
            <p class="grey-18 cbottom-text">문의사항을 남겨주시거나 연락주시면 친절히 상담 도와드리겠습니다.</p>
          </div>
        </div>
      </div>

      <div class="n-container">
        <div class="contact-form ncontact-form">

          <div class="forms-container nforms-container">

            <div class="mail-send nmail-send">
              <p class="grey-24 n-grey-24">상담문의</p>

              <form method="POST" class="needs-validation" id="contact-form" novalidate>
                <div class="send-form nsend-form">
                  <div class="inputs-container-1 ninputs-container-1">

                    <div class="inputs-1 ninputs-1">
                      <input type="text" id="company-name" class="form-control n-input" placeholder="회사 이름" name="company_name" required />
                      <input type="text" id="name" class="form-control n-input" placeholder="성함" name="name" required />
                      <input name="phone_number" onkeypress=" return isNumberKey(event)" id="txtPhoneNo" type="tel" class="form-control n-input" placeholder="핸드폰 번호" maxlength='13' />
                      <div class="form-box">
                        <label id="contact-radio-left">
                          <input type="radio" name="inquiry_type" value="Investor" checked required />
                          <div class="circle"></div>
                          <span>투자자</span>
                        </label>
                        <label class="right-radio" id="contact-radio-right">
                          <input type="radio" name="inquiry_type" value="Company" required />
                          <div class="circle"></div>
                          <span>기업</span>
                        </label>
                      </div>
                    </div>

                    <div class="ntextarea-wrapper">
                      <textarea id="inquiry" rows="8" class="textarea form-control n-textarea" placeholder="문의하실 내용을 남겨주세요." name="inquiry" required></textarea>
                      <div class="filefieldwrapper">
                        <div class="fileupwrapper" id="filewrapper">
                          <input type="file" name="attachment" id="fileup" class="fileup" />
                        </div>
                        <!-- <div class="plus-file-wrapper">
                          <i class="fa fa-plus-circle" id="addfield" aria-hidden="true"></i>
                        </div> -->
                      </div>
                      <!-- File upload  -->

                      <!-- File upload  -->
                    </div>
                  </div>

                  <div class="send-btn-container"><button type="submit" class="contac-submit-btn">문의하기 </div>

                  <div class="sending-inquiry" style="opacity: 0;">
                    <i class="fas fa-cog fa-spin"></i> Sending inquiry
                  </div>
                  <div class="inquiry-sent" style="opacity: 0;">
                    <i class="fas fa-check"></i> Inquiry sent
                  </div>

                </div>
              </form>

            </div>
            <div class="contacts ncontacts">
              <p class="grey-24 ngrey-24">오시는 길</p>

              <div class="address-contact naddress-contact">
                <div class="mobile-address nmobile-address">
                  <div class="contact-info-1 ncontact-info-1">
                    <img class="location" src="{{ asset ('website/assets/images/Location.svg') }}" alt="">

                    <div class="info-text">
                      <div class="popup">
                        <span class="popuptext">Text copied</span>
                      </div>
                      <div class="icon-text nicon-text">

                        <p class="black-19 nblack-19">서울특별시 강남구 테헤란로 88길

                          17 (대치동,세안빌딩) 6층 </p>
                        <img class="copyContact copyimage" src="{{ asset ('website/assets/images/map-icons.svg') }}" alt="">
                      </div>

                      <p class="grey-16 ngrey-16">1층에 <span class="red">‘파리바게트(빵집)</span>’가 있는 건물,
                        6층입니다.</p>
                    </div>


                  </div>

                  <div id="contact-info-container" class="ncontact-info-contaier">
                    <div class="popup">
                      <span class="popuptext">Text copied</span>
                    </div>

                    <div class="contact-info-2 ncontact-info-2">
                      <img src="{{ asset ('website/assets/images/Call.svg') }}" class="ncopy" alt="">

                      <p class="black-22 nblack-22">02-529-1001</p>
                      <img src="{{ asset ('website/assets/images/map-icons.svg') }}" alt="Copy" class="copyContact">

                    </div>

                  </div>
                </div>

                <div class="contact-btn-1 ncontact-btn-1">
                  <a href="#">건물 주변 사진</a>
                  <a href="#">지하철 길 안내</a>
                </div>
              </div>
            </div>

          </div>

        </div>
      </div>

    </div>
  </div>
</section>
<!-- Contact Section  -->


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
  // // New Field
  // var addfiled = document.getElementById("addfield");
  // var filewrapper = document.getElementById("filewrapper");
  // addfiled.addEventListener("click", function() {
  //   console.log("okay");
  //   var newfiled = document.createElement("input");
  //   newfiled.setAttribute("type", "file");
  //   newfiled.setAttribute("name", "fileup");
  //   newfiled.setAttribute("class", "fileup");
  //   newfiled.setAttribute("size", 40);
  //   filewrapper.appendChild(newfiled);
  // });
  // // New Field
  // var j = document.getElementsByClassName('copyContact');
  // for (let i = 0; i < j.length; i++) {
  //   j[i].addEventListener('click', copy);
  // }

  // function copy() {
  //   /* Get the text field */
  //   var copyText = this.parentElement.querySelector("p");
  //   var popups = this.parentElement.parentElement.getElementsByClassName("popup");
  //   var b = popups[0].querySelectorAll('span');
  //   /* Select the text field */
  //   /* Copy the text inside the text field */
  //   if (navigator.clipboard != undefined) { //Chrome
  //     navigator.clipboard.writeText(copyText.innerText).then(function() {
  //       console.log('Async: Copying to clipboard was successful!');
  //     }, function(err) {
  //       console.error('Async: Could not copy text: ', err);
  //     });
  //   } else if (window.clipboardData) { // Internet Explorer
  //     window.clipboardData.setData("copyText", copyText.innerText);
  //   }
  //   b[0].classList.add("show");
  //   setTimeout(function() {
  //     b[0].classList.remove('show')
  //   }, 2000);
  // }






  $(function() {
    $('#contact-form').submit(function(e) {
      e.preventDefault();
      // Form indications
      const sendingInquiry = $('.sending-inquiry');
      const inquirySent = $('.inquiry-sent');
      // Show indication
      sendingInquiry.animate({
        opacity: 1
      }, 500);
      // Get form data
      const form = $(this)[0];
      // Create form data
      const formData = new FormData(form);
      // Ajax request
      $.ajax({
        url: '/contact/send-contact-request',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        processData: false,
        contentType: false,
        data: formData,
        success: function(response) {
          if (response.status == 'ok') {
            $('#company-name').val('');
            $('#name').val('');
            $('#txtPhoneNo').val('');
            $('#inquiry').val('');
            // form.reset();
            $('#contact-form').removeClass('was-validated');
            sendingInquiry.animate({
              opacity: 0
            }, 500, function() {
              inquirySent.animate({
                opacity: 1
              }, 500, function() {
                setTimeout(function() {
                  inquirySent.animate({
                    opacity: 0
                  }, 500);
                }, 2000);
              });
            });
          } else {
            sendingInquiry.animate({
              opacity: 0
            }, 500);
          }
        }
      });
    });
  });
</script>
@stop
@section('css')
<style>
  #contact-form {
    position: relative;
  }

  .sending-inquiry,
  .inquiry-sent {
    position: absolute;
    right: 30px;
    bottom: 50px;
  }

  .inquiry-sent i {
    color: #b7e543;
  }
</style>
@stop