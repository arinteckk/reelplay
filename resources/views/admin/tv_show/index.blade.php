@extends('admin.layouts.master')
@section('title', __('Label.TV Show'))
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
              {{__('Label.TV Show')}}
            </li>
          </ol>
        </div>
        <div class="col-sm-2 d-flex align-items-center justify-content-end">
          <a href="{{ route('TVShowAdd') }}" class="btn btn-default mw-150" style="margin-top: -14px;">{{__('Label.Add TV Show')}}</a>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-striped TVShow-table text-center table-bordered">
          <thead>
            <tr style="background: #F9FAFF;">
              <th> {{__('Label.Id')}} </th>
              <!-- <th> {{__('Label.Channel')}} </th> -->
              <th> {{__('Label.Image')}} </th>
              <th> {{__('Label.Name')}} </th>
              <th> {{__('Label.Type')}} </th>
              <th> {{__('Label.Views')}} </th>
              <th> {{__('Label.Details')}} </th>
              <th> Episodes </th>
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
        var table = $('.TVShow-table').DataTable({
          "responsive": true,
          "autoWidth": false,
          lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, 'All'] ],
          processing: true,
          serverSide: false,
          language: {
            paginate: {
              previous: "<img src='{{url('assets/imgs/left-arrow.png')}}' >",
              next: "<img src='{{url('assets/imgs/left-arrow.png')}}' style='transform: rotate(180deg)'>"
            }
          },
          order: [0, 'desc'],
          ajax: "{{ route('TVShowData') }}",
          columns: [
          {data: 'DT_RowIndex', name: 'DT_RowIndex'},
          // {data: 'channel.name', name:'channel'},
          { data: 'thumbnail', name: 'thumbnail', 
            "render": function (data, type, full, meta) {
              if(data) {
                return "<img src='{{ Get_Image('show') }}" + data + "' height=50 width=50 class='img-thumbnail'/>";
              } else {
                return "<img src='{{ asset('assets/imgs/1.png') }}' height=50 width=50 class='img-thumbnail' />";
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
          {data: 'type.name', name:'type'},
          {data: 'view', name:'view',
            "render": function (data, type, full, meta) {
              if (data) {
                return data;
              } else {
                return "0";
              }
            }
          },
          {data: 'details', name: 'details', orderable: false, searchable: false},
          {data: 'season', name: 'season', orderable: false, searchable: false},
          {data: 'action', name: 'action', orderable: false, searchable: false},
          ],
        });
      });
    });
  </script>
@endpush
