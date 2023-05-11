@extends('admin.layouts.master')
@section('title',  __('Label.Transactions'))
@section('content')
 
    <!-- Start: Body-Content -->
    <div class="body-content">
      <!-- mobile title -->
      <h1 class="page-title-sm">@yield('title')</h1>

      <div class="border-bottom row mb-3">
        <div class="col-sm-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{__('Label.Dashboard')}}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
              {{__('Label.Transaction')}}
            </li>
          </ol>
        </div>
      </div>

      <div class="table-responsive table">
          <table class="table table-striped text-center table-bordered" id="datatable">
              <thead>
                  <tr style="background: #F9FAFF;">
                      <th> {{__('Label.#')}} </th>
                      <th> {{__('Label.Coupons')}} </th>
                      <th> {{__('Label.User Name')}} </th>
                      <th> {{__('Label.Package Name')}} </th>
                      <th> {{__('Label.Payment Id')}} </th>
                      <th> {{__('Label.Amount')}} </th>
                      <th> {{__('Label.Description')}} </th>
                      <th> {{__('Label.Date')}} </th>
                      <th> {{__('Label.Status')}} </th>
                  </tr>
              </thead>
              <tbody>

              </tbody>
          </table>
      </div>
    </div>
    <!-- End: Body-Content -->
  </div>
  <!-- End: Right Contenct -->
@endsection

@push('scripts')
  <script type="text/javascript">
    $(document).ready(function() {
      $(function () {
        var table = $('#datatable').DataTable({
          "responsive": true,
          "autoWidth": false,
          language: {
            paginate: {
              previous: "<img src='{{url('assets/imgs/left-arrow.png')}}' >",
              next: "<img src='{{url('assets/imgs/left-arrow.png')}}' style='transform: rotate(180deg)'>"
            }
          },
          lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, 'All'] ],
          processing: true,
          serverSide: false,
          order: [ [0, 'desc'] ],
          ajax: "{{ route('TransactionData') }}",
          columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'unique_id', name: 'unique_id', orderable: false,
              "render": function (data, type, full, meta) {
                if(data != 0 && data != "") {
                  return data;
                } else {
                  return "-";
                }
              },
            },
            {data: 'user.name', name: 'name', orderable: false,
                "render": function (data, type, full, meta) {
                if(data) {
                    return data;
                } else {
                    return "-";
                }
                },
            },
            {data: 'package.name', name: 'title', orderable: false,
              "render": function (data, type, full, meta) {
                if(data) {
                    return data;
                } else {
                    return "-";
                }
              },
            },
            {data: 'payment_id', name: 'payment_id', orderable: false,
              "render": function (data, type, full, meta) {
                if(data) {
                  return data;
                } else {
                  return "-";
                }
              },
            },
            {data: 'price', name: 'price', orderable: false,
                render: function (data, type, row, meta) {
                return row.currency_code + " " + row.amount;
                }
            },  
            {data: 'description', name:'description', orderable: false, searchable: false,
                "render": function (data, type, full, meta) {
                if(data) {
                    return data;
                } else {
                    return "-";
                }
                },
            },
            {data: 'date', name: 'date'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
          ],
        });
      });
    });
  </script>
@endpush
