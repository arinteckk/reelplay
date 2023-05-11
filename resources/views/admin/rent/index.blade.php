@extends('admin.layouts.master')
@section('title', 'Rent Video')
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
              Rent video
            </li>
          </ol>
        </div>
        <div class="col-sm-2 d-flex align-items-center justify-content-end">
          <a href="{{ route('RentVideoAdd') }}" class="btn btn-default mw-120" style="margin-top: -14px;">Add Rent Video</a>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-striped rent-table text-center table-bordered">
          <thead>
            <tr style="background: #F9FAFF;">
            <th> {{__('Label.Id')}} </th>
            <th> {{__('Label.Video')}} </th>
            <th> {{__('Label.Price')}} </th>
            <th> {{__('Label.Video Type')}} </th>
            <th> {{__('Label.Type')}} </th>
            <th> {{__('Label.Validity')}} </th>
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
        var table = $('.rent-table').DataTable({
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
          ajax: "{{ route('RentVideoData') }}",
          columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'video_id', name:'video_id',
              "render": function (data, type, full, meta) {
                var type = [];
                if (data) {
                  for (var i = 0; i < data.length; i++) {
                    type.push(data[i].name);
                  }
                  if(type !== undefined && type != 0){
                    return type;
                  } else {
                    return "-";
                  }
                } else {
                  return "-";
                }
              }
            },
            {data: 'price', name: 'price',
              "render": function(data, type, full,meta) {
                if(data) {
                  return data;
                } else {
                  return "-";
                } 
              }
            },
            {data: 'video_type', name:'video_type',
              "render": function (data, type, full, meta) {
                if (data == 1) {
                  return "Video";
                } else if(data == 2) {
                  return "Show";
                } else {
                  return "-";
                }
              }
            },
            {data: 'type_id', name:'type_id',
              "render": function (data, type, full, meta) {
                var type = [];
                if (data) {
                  for (var i = 0; i < data.length; i++) {
                    type.push(data[i].name);
                  }
                  if(type !== undefined && type != 0){
                    return type;
                  } else {
                    return "-";
                  }
                } else {
                  return "-";
                }
              }
            },
            {data: 'time', name: 'time',
              render: function (data, type, row, meta) {
                if(row.time && row.type){
                  return row.time + " " + row.type;
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