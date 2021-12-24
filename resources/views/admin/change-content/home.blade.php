@extends('admin.layouts.app')
@section('title', 'Home Page Content')
@section('content')
<div class="container-fluid">

  @include('admin.change-content.select-menu')

  <div class="row">
    <div class="col-md-6">
      <div class="card" style="min-height: 548px;">
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <div class="page-title-custom pt-2">
                <h4 class="card-title">Visitor Review</h4>
              </div>
            </div>
            <div class="col-md-6 text-end">
              <button type="button" class="btn btn-sm btn-outline-primary waves-effect waves-light" data-bs-toggle="collapse" data-bs-target="#add-review" aria-controls="add-review">Add</button>
            </div>
          </div>
          <form id="add-review" class="needs-validation collapse" novalidate>
            <div class="row mb-4">
              <div class="col-md-12">
                <div class="mb-4">
                  <textarea class="form-control" placeholder="Please write visitor’s review here." rows="4" id="review" required></textarea>
                  <div class="invalid-feedback">
                    Please provide visitor review.
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-4">
                  <input type="text" id="name" class="form-control" placeholder="Visitor name" required>
                  <div class="invalid-feedback">
                    Please provide visitor name.
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <input type="text" id="company" class="form-control" placeholder="which company’s shareholder?" required>
                  <div class="invalid-feedback">
                    Please provide company name.
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 text-end">
                <div class="mb-3">
                  <button type="submit" class="btn btn-sm btn-primary waves-effect waves-light"><i class="fas fa-spinner fa-pulse me-1 spinner d-none"></i><i class="fas fa-plus"></i> Add</button>
                </div>
              </div>
            </div>
          </form>
          <div id="reviews">
            @foreach ($reviews as $review)
            <div class="visitor-review">
              <form class="needs-validation update-review" novalidate data-review-id="{{$review->id}}">
                <div class="row">
                  <div class="col-md-6">
                    <div class="page-title-custom pt-1">
                      <div class="mb-2">{{date_format($review->created_at, 'Y.m.d')}}</div>
                    </div>
                  </div>
                  <div class="col-md-6 text-end">
                    <button type="submit" class="btn btn-sm btn-success waves-effect waves-light"><i class="fas fa-spinner fa-pulse me-1 spinner d-none"></i><i class="far fa-save"></i>
                      SAVE</button>
                    <button type="button" class="btn btn-sm btn-danger waves-effect waves-light del-review"><i class="fas fa-trash-alt"></i></button>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="mb-3">
                      <textarea class="form-control review" rows="4" required>{{$review->review}}</textarea>
                      <div class="invalid-feedback">
                        Please provide visitor review.
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <input type="text" class="form-control name" value="{{$review->name}}" required>
                      <div class="invalid-feedback">
                        Please provide visitor name.
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <input type="text" class="form-control company" value="{{$review->company}}" required>
                      <div class="invalid-feedback">
                        Please provide company name.
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>

            @endforeach
            <div class="mt-4 alert alert-warning d-none no-review-msg text-center mh-100 align-content-center d-flex align-items-center" style="height: 200px; justify-content: center; align-items: center;">

              <h5><strong>Sorry!</strong> No reviews found.</h5>

            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <form id="update-contact-info" class="needs-validation" novalidate>
            <div class="row">
              <div class="col-md-12">
                <div class="page-title-custom pt-2">
                  <h4 class="card-title">We Are Here</h4>
                  <input class="form-control mb-4" type="text" value="{{$we_are_here}}" id="we-are-here" required>
                </div>
              </div>
            </div>
            <div class="row mb-4">
              <div class="col-md-6">
                <div class="page-title-custom pt-2">
                  <h5 class="font-size-14 mb-3"><i class="mdi mdi-file-pdf-outline"></i>
                    Around Building Photos</h5>
                  <input type="file" class="filestyle" id="pdf1" data-buttonname="btn-secondary" accept="application/pdf" required>
                  <small class="filename-pdf1 text-muted pt-2 d-block">{{$pdf1}}</small>
                </div>
              </div>
              <div class=" col-md-6">
                <div class="page-title-custom pt-2">
                  <h5 class="font-size-14 mb-3"><i class="mdi mdi-file-pdf-outline"></i> How
                    To Come By Subway</h5>
                  <input type="file" class="filestyle" id="pdf2" value="{{$pdf2}}" data-buttonname="btn-secondary" accept="application/pdf" required>
                  <small class="filename-pdf2 text-muted pt-2 d-block">{{$pdf2}}</small>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="page-title-custom pt-2">
                  <h4 class="card-title">Contact Info</h4>
                </div>
              </div>
            </div>
            <div class="mb-3 row">
              <label for="address" class="col-md-3 col-form-label">Address</label>
              <div class="col-md-9">
                <input class="form-control" type="text" value="{{$address}}" id="address" required>
              </div>
            </div>
            <div class="mb-3 row">
              <label for="office-number" class="col-md-3 col-form-label">Office Number</label>
              <div class="col-md-9">
                <input class="form-control" type="text" value="{{$office_number}}" id="office-number" required>
              </div>
            </div>
            <div class="mb-3 row">
              <label for="fax-number" class="col-md-3 col-form-label">Fax Number</label>
              <div class="col-md-9">
                <input class="form-control" type="text" value="{{$fax_number}}" id="fax-number" required>
              </div>
            </div>
            <div class="mb-3 row">
              <label for="email" class="col-md-3 col-form-label">E-mail</label>
              <div class="col-md-9">
                <input class="form-control" type="text" value="{{$email}}" id="email" required>
              </div>
            </div>
            <div class="mb-3 row">
              <label for="map-link" class="col-md-3 col-form-label">Map Link</label>
              <div class="col-md-9">
                <input class="form-control" type="text" value="{{$map_link}}" id="map-link" required>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 text-end">
                <button type="submit" class="btn btn-primary waves-effect waves-light"><i class="fas fa-spinner fa-pulse me-1 spinner d-none"></i><i class="far fa-save"></i> Save</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>



</div>
</div>
@stop
@section('javascript')
<!-- Moment -->
<script src="{{ asset('assets/libs/moment/moment.js') }}"></script>
<!-- Sweet Alerts js -->
<script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

<!-- Select 2 -->
<script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
<script>
  // Select menu for content change
  $(function() {
    $(".select2").select2();
    $('#page-select-dd').on('change', function() {
      var url = $(this).val();
      if (url) {
        window.location = url;
      }
      return false;
    });
  });
</script>

<script>
  $(function() {
    ifNoReviews();
    // Reviews container
    const reviewsContainer = $('#reviews');

    // Form on submit add review form
    const addReviewForm = $('#add-review');
    addReviewForm.submit(function(e) {
      e.preventDefault();

      // spinner
      const spinner = $(this).find('.spinner');

      // Data
      const review = $('#review');
      const name = $('#name');
      const company = $('#company');

      // If fields are not empty, show spinner
      if (review.val() != '' && name.val() != '' && company.val() != '') {
        // Show spinner
        spinner.removeClass('d-none');

        // Ajax request
        $.ajax({
          url: '/admin/add-visitor-review',
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'POST',
          data: {
            review: review.val(),
            name: name.val(),
            company: company.val()
          },
          success: function(response) {

            const newReview = response.data;

            spinner.addClass('d-none');
            addReviewForm.removeClass('was-validated');
            review.val('');
            name.val('');
            company.val('');
            toastr.success('Visitor review added.');


            // Append review
            const reviewHTML = `
                      <div class="visitor-review">
                      <form class="needs-validation update-review" novalidate data-review-id="${newReview.id}">
                            <div class="row">
                              <div class="col-md-6">
                                <div class="page-title-custom pt-1">
                                  <div class="mb-2">${moment(newReview.created_at).format('YYYY.MM.DD')}</div>
                                </div>
                              </div>
                              <div class="col-md-6 text-end">
                              <button type="submit" class="btn btn-sm btn-success waves-effect waves-light"><i class="fas fa-spinner fa-pulse me-1 spinner d-none"></i><i class="far fa-save"></i> SAVE</button>
                              <button type="button" class="btn btn-sm btn-danger waves-effect waves-light del-review"><i class="fas fa-trash-alt"></i></button>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-12">
                                <div class="mb-3">
                                  <textarea class="form-control review" rows="4" required>${newReview.review}</textarea>
                                  <div class="invalid-feedback">
                                    Please provide visitor review.
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-6">
                                <div class="mb-3">
                                  <input type="text" class="form-control name" value="${newReview.name}" required>
                                  <div class="invalid-feedback">
                                    Please provide visitor name.
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="mb-3">
                                  <input type="text" class="form-control company" value="${newReview.company}" required>
                                  <div class="invalid-feedback">
                                    Please provide company name.
                                  </div>
                                </div>
                              </div>
                            </div>
                          </form>
                        </div>`;

            reviewsContainer.prepend(reviewHTML);
            ifNoReviews();
          }
        });
      }
    });


    // On submit update review form
    $('body').on('submit', '.update-review', function(e) {
      e.preventDefault();

      const $this = $(this);

      // spinner
      const spinner = $this.find('.spinner');

      // Review ID
      const reviewID = $this.data('review-id');

      // Data
      const review = $this.find('.review').val();
      const name = $this.find('.name').val();
      const company = $this.find('.company').val();

      // If fields are not empty, show spinner
      if (review != '' && name != '' && company != '') {
        // Show spinner
        spinner.removeClass('d-none');

        // Ajax request
        $.ajax({
          url: '/admin/update-visitor-review',
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'PUT',
          data: {
            id: reviewID,
            review: review,
            name: name,
            company: company
          },
          success: function(response) {
            console.log(response);
            spinner.addClass('d-none');
            $this.removeClass('was-validated');
            toastr.success('Visitor review updated.');

          }
        });


      }

    });

    // Delete review
    $('body').on('click', '.del-review', function() {

      // This
      const $this = $(this);

      // Review ID
      const reviewID = $this.parents('form').data('review-id');

      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: !0,
        confirmButtonColor: '#34c38f',
        cancelButtonColor: '#f46a6a',
        confirmButtonText: 'Yes, delete it!',
      }).then(function(t) {
        t.value &&

          // Ajax request
          $.ajax({
            url: '/admin/delete-visitor-review',
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'DELETE',
            data: {
              id: reviewID,
            },
            success: function(response) {
              $this.parents('.visitor-review').remove();
              toastr.success('Visitor review deleted.');
              ifNoReviews();
              Swal.fire(
                'Deleted!',
                'Review has been deleted.',
                'success'
              );
            }
          });

      });

    });


    // Update home content
    const updateHomeContentForm = $('#update-contact-info');
    updateHomeContentForm.submit(function(e) {
      e.preventDefault();

      // spinner
      const spinner = $(this).find('.spinner');

      // Data
      const weAreHere = $('#we-are-here');
      const PDF1 = $('#pdf1');
      const PDF2 = $('#pdf2');
      const address = $('#address');
      const officeNumber = $('#office-number');
      const faxNumber = $('#fax-number');
      const email = $('#email');
      const mapLink = $('#map-link');

      if (weAreHere.val() != '' && address.val() != '' && officeNumber.val() != '' && faxNumber.val() != '' &&
        email.val() != '' && mapLink.val() != '') {

        // New form
        const formData = new FormData();
        formData.append('we_are_here', weAreHere.val());
        formData.append('address', address.val());
        formData.append('office_number', officeNumber.val());
        formData.append('fax_number', faxNumber.val());
        formData.append('email', email.val());
        formData.append('map_link', mapLink.val());
        formData.append('pdf1', PDF1.prop('files')[0]);
        formData.append('pdf2', PDF2.prop('files')[0]);

        // Show spinner
        spinner.removeClass('d-none');
        // Ajax request
        $.ajax({
          url: '/admin/update-home-content',
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'POST',
          processData: false,
          contentType: false,
          data: formData,
          success: function(response) {
            spinner.addClass('d-none');
            toastr.success('Content has been updated.');
            if (response.pdf1 != '') {
              $('.filename-pdf1').text(response.pdf1);
            }
            if (response.pdf2 != '') {
              $('.filename-pdf2').text(response.pdf2);
            }
          }
        });
      } else {
        console.log('Fields are not validated');
      }
    });

  });
</script>
<script>
  // If no reviews found
  function ifNoReviews() {
    var count = $("#reviews .visitor-review").length;

    console.log(count);

    if (count > 0) {
      $('.no-review-msg').addClass('d-none');

    } else {
      $('.no-review-msg').removeClass('d-none');
    }
  }
</script>
<style>
  .visitor-review:first-child {
    border-top: 2px solid #8f8f8f;
  }

  .visitor-review {
    padding: 20px 0 10px;
    border-top: 1px solid #cccccc;
  }
</style>
@endsection
@section('css')
<!-- Sweet Alert-->
<link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />

<link href="{{ url('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<style>
  .select2-container .select2-selection--single .select2-selection__arrow b {
    border-color: #adb5bd transparent transparent transparent;
    border-width: 6px 6px 0 6px;
  }

  .select2-container .select2-selection--single {
    background-color: #fff;
    border: 1px solid #ced4da;
    height: 38px;
  }

  .select2-container .select2-selection--single .select2-selection__rendered {
    line-height: 36px;
    padding-left: 12px;
    color: #5b626b;
    float: left;
  }

  .select2-container .select2-selection--single .select2-selection__arrow {
    height: 34px;
    width: 34px;
    right: 3px;
  }
</style>
@endsection