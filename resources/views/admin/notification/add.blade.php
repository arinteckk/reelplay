@extends('admin.layouts.master')
@section('title', __('Label.Add Notification'))
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
                    {{__('Label.Add Notification')}}
                </li>
            </ol>
        </div>
    </div>

    <div class="card custom-border-card mt-3">
        <form enctype="multipart/form-data" id="save_notification_send">
            @csrf
            <div class="form-row">
                <div class="col-md-12 mb-3">
                    <div class="form-group">
                        <label for="title">{{__('Label.TITLE')}}</label>
                        <input name="title" type="text" class="form-control" id="title"
                            placeholder="{{__('Label.Enter Title')}}" autocomplete="off">
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12 mb-3">
                    <label for="message">{{__('Label.MESSAGE')}}</label>
                    <textarea class="form-control" id="message" rows="5" name="message" placeholder="{{__('Label.Start Write Here...')}}" autocomplete="off"></textarea>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="image">{{__('Label.IMAGE (OPTIONAL)')}}</label>
                        <input type="file" class="form-control" id="image" name="image">
                        <label class="mt-1 text-gray">{{__('Label.Note_Image')}}</label>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <div class="custom-file ml-5">
                            <img src="{{asset('assets/imgs/1.png')}}" height="120px" width="120px" class="mb-3 img-thumbnail" id="preview-image-before-upload">
                        </div>
                    </div>
                </div>
            </div>
            <div class="border-top mt-2 pt-3 text-right">
                <button type="button" class="btn btn-default mw-120"
                    onclick="save_notification_send()">{{__('Label.SAVE')}}</button>
            </div>
        </form>
    </div>
</div>
<!-- End: Body-Content -->
</div>
<!-- End: Right Contenct -->
@endsection

@push('scripts')
    <script type="text/javascript">
        function save_notification_send() {
            var formData = new FormData($("#save_notification_send")[0]);
            $("#dvloader").show();
            $.ajax({
                type: 'POST',
                url: '{{ route("notificationSave") }}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(resp) {
                    $("#dvloader").hide();
                    get_responce_message(resp, 'save_notification_send', '{{ route("notification") }}');
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    $("#dvloader").hide();
                    toastr.error(errorThrown.msg, 'failed');
                }
            });
        }
    </script>
@endpush