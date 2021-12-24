@extends('admin.layouts.app')
@section('title', 'Company')
@section('css')
<link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<!-- DataTables -->
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<!-- Responsive datatable examples -->
<link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<!-- Sweet Alert-->
<link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
<style>
  .dt-header {

    display: flex;
    justify-content: space-between;

  }
</style>
@stop
@section('content')

<div class="container-fluid">
  <!-- tabs -->
  @include('admin.contact-box.tabs')
  <!-- /tabs -->

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <form method="POST" action="{{ url('admin/contact-box/read-inquiries') }}">
            @csrf
            <table id="dt-company-inquiries" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
              <thead>
                <tr>
                  <th>
                    <input type="checkbox" id="select-all">
                  </th>
                  <th>Date</th>
                  <th>Company Name</th>
                  <th>Name</th>
                  <th>Phone Number</th>
                  <th>Inquiry</th>
                  <th>Attachment</th>
                  <th>Read/Unread</th>
                  <!-- <th></th> -->
                </tr>
              </thead>

              <tbody>

              </tbody>
            </table>
          </form>
        </div>

      </div>
    </div>
    <!-- end col -->
  </div>
</div>


<!-- /content -->




@stop

@section('javascript')
<!-- Sweet Alerts js -->
<script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<!-- Required datatable js -->
<script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<!-- Responsive examples -->
<script src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

<script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js">
</script>
<script>
  $(document).ready(function() {
    var table = $("#dt-company-inquiries").DataTable({
      ajax: "{{ url('admin/contact-box/get-inquiries') }}/Company",
      columns: [{
          data: "id"
        },
        {
          data: "created_at"
        },
        {
          data: "company_name"
        },

        {
          data: "name"
        },
        {
          data: "phone_number"
        },
        {
          data: "inquiry"
        },
        {
          data: "attachment",
          render: function(data) {
            return `<a href="${data}">${data}</a>`;
          }
        },
        {
          data: "read",
          render: function(data, type, row) {
            return data == 0 ? '<a href="<?php echo url('admin/contact-box/read-inquiry'); ?>/' + row.id + '"><i style="font-size: 20px" class="fas fa-envelope"></i></a>' : '<a href="<?php echo url('admin/contact-box/unread-inquiry'); ?>/' + row.id + '"><i style="font-size: 20px" class="fas fa-envelope-open-text"></i></a>';
          }
        },
        // {
        //   data: null,
        //   render: function() {
        //     return '<button type="submit" class="btn btn-primary waves-effect waves-light">Add as New User</button>';
        //   }
        // },
      ],
      dom: '<"dt-header" <"del-btn">f>rtip',
      aaSorting: [],
      columnDefs: [{
          orderable: false,
          className: 'select-checkbox',
          targets: 0,
          'render': function(data, type, full, meta) {
            return '<input type="checkbox" class="inq-id" value="' + data + '" name="inquiries[]">';
          }
        }, {
          width: '25%',
          targets: 5
        },
        // {
        //   orderable: false,
        //   targets: 6,
        // }
      ],

      fixedColumns: true

    });

    $('#select-all').on('click', function() {
      var rows = table.rows({
        'search': 'applied'
      }).nodes();
      $('input[type="checkbox"]', rows).prop('checked', this.checked);
    });


    $('#example tbody').on('change', 'input[type="checkbox"]', function() {
      if (!this.checked) {
        var el = $('#select-all').get(0);
        if (el && el.checked && ('indeterminate' in el)) {
          el.indeterminate = true;
        }
      }
    });
    $('.del-btn').html(
      '<button type="button" class="btn btn-sm btn-danger waves-effect waves-light" id="delete-selected"><i class="fas fa-trash-alt me-1"></i>Delete Selected</button><button type="submit" class="ms-2 btn btn-sm btn-primary waves-effect waves-light"><i class="fas fa-envelope-open-text"></i> Mark as Read</button>'
    );

    //  Delete selected checkbox
    $('body').on('click', '#delete-selected', function() {

      const ids = [];

      $.each($('.inq-id:checked'), function() {
        ids.push($(this).val());
      });

      if (ids.length > 0) {

        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this and all!",
          icon: 'warning',
          showCancelButton: !0,
          confirmButtonColor: '#34c38f',
          cancelButtonColor: '#f46a6a',
          confirmButtonText: 'Yes, delete it!',
        }).then(function(t) {
          t.value &&

            // Ajax request
            $.ajax({
              url: '/admin/contact-box/delete-inquiries',
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              type: 'DELETE',
              data: {
                ids: ids
              },
              success: function(response) {
                Swal.fire(
                  'Deleted!',
                  'Selected records has been deleted.',
                  'success'

                );
                $('#all_inquiries_count').html(response.data.all_inquiries_count);
                $('#invertor_inquiries_count').html(response.data.investor_inquiries_count);
                $('#company_inquiries_count').html(response.data.company_inquiries_count);
                table.ajax.reload();
              }
            });

        });
      }
    });

  });
</script>
@stop