@extends('admin.layouts.master')
@section('title', __('Label.Users List'))
@section('content')
    <!-- Start: Body-Content -->
    <div class="body-content">
      <!-- mobile title -->
      <h1 class="page-title-sm">@yield('title')</h1> 

      <div class="border-bottom row mb-3">
        <div class="col-sm-10">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{__('Label.Dashboard')}}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
              {{__('Label.Users List')}}
            </li>
          </ol>
        </div>
        <div class="col-sm-2 d-flex align-items-center justify-content-end">
          <a href="{{ route('userAdd') }}" class="btn btn-default mw-120" style="margin-top: -14px;">{{__('Label.Add User')}}</a>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-striped user-table text-center table-bordered example">
          <thead>
            <tr style="background: #F9FAFF;">
              <th> {{__('Label.Id')}} </th>
              <th> {{__('Label.Image')}} </th>
              <th> {{__('Label.Name')}} </th>
              <th> {{__('Label.Email')}} </th>
              <th> {{__('Label.Mobile')}} </th>
              <th> {{__('Label.Gender')}} </th>
              <th> {{__('Label.Type')}} </th>
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
        var table = $('.user-table').DataTable({
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
          ajax: "{{ route('userData') }}",
          columns: [
          {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false},
          { data: 'image', name: 'image', searchable: false, 
            "render": function (data, type, full, meta) {
              if(data){
                return "<img src='{{ Get_Image('user')}}" + data + "' height=50 Width=50 class='rounded-circle' />";
              } else {
                return "<img src='{{ asset('assets/imgs/1.png') }}' height='50' width=50 class='rounded-circle' />";
              }
            },
          },
          {data: 'name', name:'name',
            "render": function (data, type, full, meta) {
              if (data) {
                return data;
              } else {
                return "-";
              }
            }
          },
          {data: 'email', name: 'email',
            "render": function (data, type, full, meta) {
              if (data) {
                return data;
              } else {
               return "-";
              }
            }
          },
          {data: 'mobile', name: 'mobile',
            "render": function (data, type, full, meta) {
              if (data) {
                return data;
              } else {
               return "-";
              }
            }
          },
          {data: 'gender', name: 'gender',
            "render": function(data, type, full,meta) {
              if(data) {
                return data;
              } else {
                return "-";
              } 
            }
          },
          {data: 'type', name: 'type',
            "render": function(data, type, full,meta) {
              if(data == 1) {
                return "Facebook";
              } else if(data == 2) {
                return "Google";
              } else if(data == 3) {
                return "OTP";
              } else if(data == 4){
                return "Normal";
              } else {
                return "-";
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
