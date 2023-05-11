@extends('admin.layouts.master')
@section('title', __('Label.Notification'))
@section('content')

<!-- Start: Body-Content -->
<div class="body-content">
    <!-- mobile title -->
    <h1 class="page-title-sm"> @yield('title') </h1>

    <div class="border-bottom row">
        <div class="col-sm-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{__('Label.Dashboard')}}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{__('Label.Notification List')}}
                </li>
            </ol>
        </div>
        <div class="col-sm-12 mb-3 d-flex justify-content-between">
            <a href="{{ route('notificationAdd') }}" class="btn btn-default mw-120">{{__('Label.Add')}}</a>
            <a href="{{ route('notificationSetting') }}"
                class="btn btn-default mw-120">{{__('Label.Notification Setting')}}</a>
        </div>
    </div>

    <div class="table-responsive mt-3">
        <table class="table table-striped notification-table text-center table-bordered">
            <thead>
                <tr style="background: #F9FAFF;">
                    <th> {{__('Label.Id')}} </th>
                    <th> {{__('Label.Image')}} </th>
                    <th> {{__('Label.Title')}} </th>
                    <th> {{__('Label.Message')}} </th>
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
    $(function() {
        var table = $('.notification-table').DataTable({
            "responsive": true,
            "autoWidth": false,
            language: {
                paginate: {
                    previous: "<img src='{{url('assets/imgs/left-arrow.png')}}' >",
                    next: "<img src='{{url('assets/imgs/left-arrow.png')}}' style='transform: rotate(180deg)'>"
                }
            },
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All']
            ],
            processing: true,
            serverSide: false,
            order: [
                [0, 'desc']
            ],
            ajax: "{{ route('notificationData') }}",
            columns: [{data: 'id',name: 'id'},
                {data: 'image',name: 'image',
                    "render": function(data, type, full, meta) {

                        if (data == "") {
                            return "<img src='{{asset('assets/imgs/1.png')}}' height=50 width=50 class='img-thumbnail' />";
                        } else {
                            return "<img src='{{Get_Image('notification')}}" + data + "'  height=50 width=50 class='img-thumbnail' />";
                        }
                    }
                },
                {data: 'title',name: 'title'},
                {data: 'message',name: 'message'},
                {data: 'action', name: 'action', orderable: false, searchable: false},

            ],
        });
    });
});
</script>
@endpush