@extends('admin.layouts.master')
@section('title', 'Payment')
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
              Payment
            </li>
          </ol>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-striped payment-table text-center table-bordered">
          <thead>
            <tr style="background: #F9FAFF;">
            <th> {{__('Label.Id')}} </th>
            <th> {{__('Label.Name')}} </th>
            <th> {{__('Label.Status')}} </th>
            <th> Payment Environment </th>
            <th> {{__('Label.Action')}} </th>
            </tr>
          </thead>
          <tbody></tbody>
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
        var table = $('.payment-table').DataTable({
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
          ajax: "{{ route('PaymentData') }}",
          columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, visible: false },
            {data: 'name', name:'name',
              "render": function (data, type, full, meta) {
                if (data) {
                  return data;
                } else {
                  return "-";
                }
              }
            },
            {data: 'visibility', name: 'visibility',
              "render": function(data, type, full,meta) {
                if(data == 1) {
                  return "Active";
                } else {
                  return "In Active";
                } 
              }
            },
            {data: 'is_live', name:'is_live',
              "render": function (data, type, full, meta) {
                if (data == 1) {
                  return "Live";
                } else {
                  return "Sandbox";
                }
              }
            },
            {data: 'action', name: 'action', orderable: false, searchable: false},
          ],
        });
      });
    });
  </script>
@endpush