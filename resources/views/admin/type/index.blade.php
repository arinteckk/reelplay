@extends('admin.layouts.master')
@section('title', __('Label.Types'))
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
                    {{__('Label.Types')}}
                </li>
            </ol>
        </div>
        <div class="col-sm-2 d-flex align-items-center justify-content-end">
            <a href="{{ route('typeAdd') }}" class="btn btn-default mw-130" style="margin-top: -14px;">
                {{__('Label.Add Types')}}
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped type-table text-center table-bordered">
            <thead>
                <tr style="background: #F9FAFF;">
                    <th> {{__('Label.Id')}} </th>
                    <th> {{__('Label.Name')}} </th>
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
    $(function() {
        var table = $('.type-table').DataTable({
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
            ajax: "{{ route('typeData') }}",
            columns: [{
                    data: 'id',
                    name: 'id',
                },
                {
                    data: 'name',
                    name: 'name',
                    "render": function(data, type, full, meta) {
                        if (data) {
                            return data;
                        } else {
                            return "-";
                        }
                    }
                },
                {
                    data: 'type',
                    name: 'type',
                    "render": function(data, type, full, meta) {
                        if (data == 1) {
                            return "Video";
                        } else if (data == 2) {
                            return "Show";
                        } else {
                            return "-";
                        }
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ],
        });
    });
});
</script>
@endpush