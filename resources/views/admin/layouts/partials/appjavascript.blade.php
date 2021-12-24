<!-- JAVASCRIPT -->
<script>
  var ajaxUrl = "{{ url('/') }}"
</script>
<script src="{{asset('assets/libs/jquery/jquery.min.js')}}"></script>
<script src="{{asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
<script src="{{asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{asset('assets/libs/node-waves/waves.min.js') }}"></script>
<script src="{{asset('assets/libs/jquery-sparkline/jquery.sparkline.min.js') }}"></script>

<!-- lightbox -->
<script src="{{ asset('assets/libs/magnific-popup/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/lightbox.init.js') }}"></script>

<script src="{{asset('assets/js/app.js') }}"></script>
<script src="{{ asset('assets/js/validations.js') }}"></script>
<script src="{{ asset('assets/js/datepicker.js') }}"></script>
<script src="{{ asset('assets/js/tagsinput.js') }}"></script>
<script src="{{ asset('assets/js/moment.min.js') }}"></script>
<script src="{{ asset('assets/timepicker/bootstrap-timepicker.min.js') }}"></script>
<script src="{{ asset('assets/libs/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
<script src="{{ asset('assets/libs/admin-resources/bootstrap-filestyle/bootstrap-filestyle.min.js') }}"></script>
<!-- toastr -->
<script src="{{ url('assets/toastr/js/toastr.min.js') }}"></script>
<script src="{{ asset('assets/js/common.js') }}"></script>
@yield('javascript')
<script>
  $("#select-all-row, .select-all-row").on('click', function(e) {
    if (this.checked) {
      $(this).closest('table').find('tbody').find('input.form-check-input').each(function() {
        if (!this.checked) {
          $(this).prop('checked', true).change();
          $('#delete-selected').show();
        }
      });
    } else {
      $(this).closest('table').find('tbody').find('input.form-check-input').each(function() {
        if (this.checked) {
          $(this).prop('checked', false).change();
          $('#delete-selected').hide();
        }
      });
    }
  });
  $(document).on('change', "input.form-check-input", function() {
    if (this.checked) {
      $(this).closest('tr').addClass('selected');
      $('#delete-selected').show();
    } else {
      $(this).closest('tr').removeClass('selected');
      $('#delete-selected').hide();
    }
  });
</script>
<script>
  $(".right-bar-toggle").on("click", function(e) {
    $("body").addClass("right-bar-enabled");
    $("#notify_user_list").show();
    $(".notifynamesearch").show();
    $("#notify_user_memo_list").hide();
    $("#notify_customer_memo_form_new").hide();
    $("#notify_customer_memo_form_update").hide();
    $("#notifycustomertab").addClass('active');
    $("#notifyadmintab").removeClass('active');
    $("#notifycustomer").addClass('active');
    $("#notifyadmin").removeClass('active');
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: `/admin/notify-user-list`,
      data: {},
      type: 'POST',
      success: function(data) {
        if (data.success) {
          $("#notify_user_list").html(data.html);

        }
      },
      error: function(data) {
        console.log(data);
      }
    });

  });

  $("#notify-user-searchbox").keyup(function(e){
    $("#notify_user_memo_list").hide();
    $("#notify_user_list").show();
    if($("#notify-user-searchbox").val() != "") {
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: `/admin/notify-search-user-list`,
        data: {
          searchval: $("#notify-user-searchbox").val()
        },
        type: 'POST',
        success: function(data) {
          if (data.success) {
            $("#notify_user_list").html(data.html);

          }
        },
        error: function(data) {
          console.log(data);
        }
      });
    } else {
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: `/admin/notify-user-list`,
        data: {},
        type: 'POST',
        success: function(data) {
          if (data.success) {
            $("#notify_user_list").html(data.html);

          }
        },
        error: function(data) {
          console.log(data);
        }
      });
    }
  })
  $(document).on("click", "body", function(e) {
    0 < $(e.target).closest(".right-bar-toggle, .right-bar").length || $("body").removeClass("right-bar-enabled")
  });
  $(document).on('click', '.notify-user-item', function(e) {
    $("#notify_user_list").hide();
    $("#notify_memo_customer_id").val($(this).data('userid'));
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: `/admin/notify-user-memo-list`,
      data: {
        customer_id: $(this).data('userid'),
      },
      type: 'POST',
      success: function(data) {
        if (data.success) {

          $("#notify_user_memo_list").show();
          $("#notify_user_memo_list").html(data.html);

        }
      },
      error: function(data) {
        console.log(data);
      }
    });
  });
  $(document).on('click', '#customer_notify_memo_add', function(e) {
    $("#notify_user_memo_list").hide();
    $(".notifynamesearch").hide();
    $("#notify_customer_memo_form_update").hide();
    $("#notifymemonote").val('');
    $("#notifymemokeyword").tagsinput('removeAll');
    $("#notify_customer_memo_form_new").show();

  });
  $(document).on('click', '.btn_notify_customer_memocancel', function(e) {
    $(".notifynamesearch").show();
    $("#notify_customer_memo_form_new").hide();
    $("#notify_customer_memo_form_update").hide();
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: `/admin/notify-user-memo-list`,
      data: {
        customer_id: $("#notify_memo_customer_id").val(),
      },
      type: 'POST',
      success: function(data) {
        if (data.success) {

          $("#notify_user_memo_list").show();
          $("#notify_user_memo_list").html(data.html);

        }
      },
      error: function(data) {
        console.log(data);
      }
    });
  });
  $(document).on('click', ".btn_notify_customer_memoadd", function(e) {
    var form = $("#NotifyMemoForm");
    if (form[0].checkValidity() === false) {
      event.preventDefault()
      event.stopPropagation()
      form.addClass('was-validated');
      return;
    }
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: `/admin/notify-memo-add`,
      data: {
        customer: $("#notify_memo_customer_id").val(),
        note: $("#notifymemonote").val(),
        keyword: $("#notifymemokeyword").val(),
        company: $("#notifymemocompany").val()
      },
      type: 'POST',
      success: function(data) {
        if (data.status = 'success') {
          $("#notify_user_memo_list").show();
          $(".notifynamesearch").show();
          $("#notify_customer_memo_form_new").hide();
          $("#notify_customer_memo_form_update").hide();
          $.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `/admin/notify-user-memo-list`,
            data: {
              customer_id: $("#notify_memo_customer_id").val(),
            },
            type: 'POST',
            success: function(data) {
              if (data.success) {

                $("#notify_user_memo_list").html(data.html);
              }
            },
            error: function(data) {
              console.log(data);
            }
          });

        }
      },
      error: function(data) {
        console.log(data);
      }
    });

  });
  $(document).on('click', '.customer_notify_memo_update', function(e) {
    $('.notifynamesearch').hide();
    $("#notify_user_list").hide();
    $("#notify_user_memo_list").hide();
    $("#upnotifymemo_id").val($(this).data('id'));
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: `/admin/user-memo-get`,
      data: {
        memoid: $("#upnotifymemo_id").val(),
      },
      type: 'POST',
      success: function(data) {
        $("#upnotifymemonote").val(data.note);
        $("#upnotifymemocompany").val(data.company);
        $("#upnotifymemokeyword").tagsinput('removeAll');
        $("#upnotifymemokeyword").tagsinput('add', data.keyword);
        $("#notify_customer_memo_form_update").show();
      },
      error: function(data) {
        console.log(data);
      }
    });

  });
  $(document).on('click', '.upbtn_notify_customer_memo', function(e) {
    var form = $("#UpNotifyMemoForm");
    if (form[0].checkValidity() === false) {
      event.preventDefault()
      event.stopPropagation()
      form.addClass('was-validated');
      return;
    }
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: `/admin/user-memo-update`,
      data: {
        customer: $("#notify_memo_customer_id").val(),
        company: $("#upnotifymemocompany").val(),
        note: $("#upnotifymemonote").val(),
        keyword: $("#upnotifymemokeyword").val(),
        memoid: $("#upnotifymemo_id").val()
      },
      type: 'POST',
      success: function(data) {
        $("#notify_user_memo_list").show();
        $(".notifynamesearch").show();
        $("#notify_customer_memo_form_new").hide();
        $("#notify_customer_memo_form_update").hide();
        if (data.status = 'success') {
          $.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `/admin/notify-user-memo-list`,
            data: {
              customer_id: $("#notify_memo_customer_id").val(),
            },
            type: 'POST',
            success: function(data) {
              if (data.success) {
                $("#notify_user_memo_list").html(data.html);
              }
            },
            error: function(data) {
              console.log(data);
            }
          });

        }
      },
      error: function(data) {
        console.log(data);
      }
    });
  });
  $(document).on('click', '.customer_notify_memo_pin', function(e) {
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: `/admin/user-memo-pin`,
      data: {
        memoid: $(this).data('id'),
      },
      type: 'POST',
      success: function(data) {
        $("#notify_user_memo_list").show();
        $(".notifynamesearch").show();
        $("#notify_customer_memo_form_new").hide();
        $("#notify_customer_memo_form_update").hide();
        if (data.status = 'success') {
          $.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `/admin/notify-user-memo-list`,
            data: {
              customer_id: $("#notify_memo_customer_id").val(),
              pin: true,
            },
            type: 'POST',
            success: function(data) {

              if (data.success) {
                $("#notify_user_memo_list").html(data.html);
              }
            },
            error: function(data) {
              console.log(data);
            }
          });

        }
      },
      error: function(data) {
        console.log(data);
      }
    });
  });
  $(document).on('click', '.customer_notify_memo_delete', function(e) {
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: `/admin/user-memo-delete`,
      data: {
        memo_id: $(this).data('id')
      },
      type: 'POST',
      success: function(data) {
        $("#notify_user_memo_list").show();
        $(".notifynamesearch").show();
        $("#notify_customer_memo_form_new").hide();
        $("#notify_customer_memo_form_update").hide();
        if (data.status = 'success') {
          $.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `/admin/notify-user-memo-list`,
            data: {
              customer_id: $("#notify_memo_customer_id").val(),
            },
            type: 'POST',
            success: function(data) {
              if (data.success) {
                $("#notify_user_memo_list").html(data.html);
              }
            },
            error: function(data) {
              console.log(data);
            }
          });

        }
      },
      error: function(data) {
        console.log(data);
      }
    });
  });
  $('a[role=tabnotify]').click(function() {
    if (this.id == "notifyadmintab") {
      $("#notify_user_list").show();
      $(".notifynamesearch").show();
      $("#notify_user_memo_list").hide();
      $("#notify_customer_memo_form_new").hide();
      $("#notify_customer_memo_form_update").hide();
    } else if (this.id == "notifycustomertab") {
      $("#admin_memo_type").show();
      $("#admin_memo_add").hide();
      $("#admin_memo_type_list").hide();
    };

  });
  $(document).on('click', '.btn_admin_add', function(e) {
    $("#admin_memo_type").hide();
    $("#admin_memo_add").show();
    $("#adminmemonote").val('');
    $("#administrater").val('');
    $("#admin_memo_type_list").hide();
  });
  $(document).on("click", '.btn_admin_memocancel', function(e) {
    $("#admin_memo_type").show();
    $("#admin_memo_add").hide();
  });
  $(document).on('click', '.btn_admin_memoadd', function(e) {
    var form = $("#AdminMemoForm");
    if (form[0].checkValidity() === false) {
      event.preventDefault()
      event.stopPropagation()
      form.addClass('was-validated');
      return;
    }
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: `/admin/admin-memo-add`,
      data: {
        note: $("#adminmemonote").val(),
        admin: $("#administrater").val()
      },
      type: 'POST',
      success: function(data) {

        $("#admin_memo_type").show();
        if (data.status = 'success') {
          $("#admin_memo_add").hide();
        }
      },
      error: function(data) {
        console.log(data);
      }
    });
  });
  $(document).on('click', '.admin_memo_personal', function(e) {
    $("#admin_memo_type").show();
    $("#admin_memo_add").hide();
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: `/admin/admin-memo-type-list`,
      data: {},
      type: 'POST',
      success: function(data) {

        $("#admin_memo_type_list").show();
        if (data.status = 'success') {
          $("#admin_memo_type_list").html(data.html);
        }
      },
      error: function(data) {
        console.log(data);
      }
    });

  });
  $(document).on('click', '.admin_memo_sent', function(e){
    $("#admin_memo_type").show();
    $("#admin_memo_add").hide();
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: `/admin/admin-memo-sent-list`,
      data: {},
      type: 'POST',
      success: function(data) {

        $("#admin_memo_type_list").show();
        if (data.status = 'success') {
          $("#admin_memo_type_list").html(data.html);
        }
      },
      error: function(data) {
        console.log(data);
      }
    });
  });
  $(document).on('click', '.admin_memo_all', function(e){
    $("#admin_memo_type").show();
    $("#admin_memo_add").hide();
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: `/admin/admin-memo-receive-list`,
      data: {},
      type: 'POST',
      success: function(data) {

        $("#admin_memo_type_list").show();
        if (data.status = 'success') {
          $("#admin_memo_type_list").html(data.html);
        }
      },
      error: function(data) {
        console.log(data);
      }
    });
  });
  $(document).on('click', '.admin_notify_memo_pin', function(e) {
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: `/admin/admin-memo-pin`,
      data: {
        memoid: $(this).data('id'),
      },
      type: 'POST',
      success: function(data) {
        $("#admin_memo_type_list").show();
        $("#admin_memo_add").hide();
        if (data.status = 'success') {
          $.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `/admin/admin-memo-type-list`,
            data: {
              pin: true,
            },
            type: 'POST',
            success: function(data) {

              $("#admin_memo_type_list").show();
              if (data.status = 'success') {
                $("#admin_memo_type_list").html(data.html);
              }
            },
            error: function(data) {
              console.log(data);
            }
          });
        }
      },
      error: function(data) {
        console.log(data);
      }
    });
  });
</script>

