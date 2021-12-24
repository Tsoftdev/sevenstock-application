<form method="POST" class="needs-validation" id="mini-contact-form" novalidate>
  <div id="footer-investor">
    <input class="form-control n-input" type="text" placeholder="성함" name="name" required id="name" />
    <input class="form-control n-input" type="text" placeholder="핸드폰 번호" id="phone-number" name="phone_number" required />
  </div>
  <div id="footer-company">
    <a href="{{ url('contact-us') }}">상담문의로 이동</a>
    <p>*클릭하시면 '상담문의'로 이동합니다.</p>
  </div>
  <div class="form-box">
    <label id="footer-left-radio">
      <input type="radio" name="inquiry_type" value="Investor" checked />
      <div class="circle"></div>
      <span>투자자</span>
    </label>
    <label class="right-radio" id="footer-right-radio">
      <input type="radio" name="inquiry_type" value="Company" />
      <div class="circle"></div>
      <span>기업</span>
    </label>
  </div>
  <div class="submit-wrapper">
    <button type="submit" id="footer-submitbtn" class="submit-btn">
      문의하기
    </button>
    <div class="sending-mini-inquiry" style="opacity: 0;">
      <i class="fas fa-cog fa-spin"></i> Sending inquiry
    </div>
    <div class="inquiry-mini-sent" style="opacity: 0;">
      <i class="fas fa-check"></i> Inquiry sent
    </div>
  </div>

</form>

<script>
  $(function() {

    // Mini contact form submission
    $('#mini-contact-form').submit(function(e) {

      e.preventDefault();

      // Form indications
      const sendingMiniInquiry = $('.sending-mini-inquiry');
      const inquiryMiniSent = $('.inquiry-mini-sent');

      // Show indication
      sendingMiniInquiry.animate({
        opacity: 1
      }, 500)

      // Get Mini form data
      const MiniForm = $(this)[0];

      // Create form data

      const MiniFormData = new FormData(MiniForm);

      // Ajax request
      $.ajax({
        url: '/contact/send-contact-request',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        processData: false,
        contentType: false,
        data: MiniFormData,
        success: function(response) {
          if (response.status == 'ok') {


            MiniForm.reset();

            $('#mini-contact-form').removeClass('was-validated');

            sendingMiniInquiry.animate({
              opacity: 0
            }, 500, function() {
              inquiryMiniSent.animate({
                opacity: 1
              }, 500, function() {
                setTimeout(function() {
                  inquiryMiniSent.animate({
                    opacity: 0
                  }, 500);
                }, 2000);
              });
            });

          } else {
            sendingMiniInquiry.animate({
              opacity: 0
            }, 500);
          }
        }
      });

    });

  });
</script>
<style>
  #mini-contact-form {
    position: relative;
  }

  .sending-mini-inquiry,
  .inquiry-mini-sent {
    position: absolute;
    right: 30px;
    bottom: -45px;
    color: #fff;
  }

  .inquiry-mini-sent i {
    color: #b7e543;
  }
</style>