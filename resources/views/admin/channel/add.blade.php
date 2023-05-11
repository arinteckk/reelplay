@extends('admin.layouts.master')
@section('title', __('Label.Add Channel'))
@section('content')

<!-- Start: Body-Content -->
<div class="body-content">
    <!-- mobile title -->
    <h1 class="page-title-sm">@yield('title')</h1>

    <div class="border-bottom row mb-3">
        <div class="col-sm-10">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">{{__('Label.Dashboard')}}</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('channel') }}">{{__('Label.Channel')}}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{__('Label.Add Channel')}}
                </li>
            </ol>
        </div>
        <div class="col-sm-2 d-flex align-items-center justify-content-end">
            <a href="{{ route('channel') }}" class="btn btn-default mw-120" style="margin-top:-14px">{{__('Label.Channel')}}</a>
        </div>
    </div>

    <div class="card custom-border-card mt-3">
        <form enctype="multipart/form-data" id="save_channel">
            @csrf
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="name">{{__('Label.Name')}}</label>
                        <input name="name" type="text" class="form-control" id="name" placeholder="{{__('Label.Please Enter Name')}}" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="is_title">{{__('Label.Is Title')}}</label>
                        <select class="form-control" id="is_title" name="is_title">
                            <option value="0">{{__('Label.No')}}</option>
                            <option value="1">{{__('Label.Yes')}}</option>
                        </select>
                    </div>
                </div>
                <!-- <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="url">{{__('Label.URL')}}</label>
                        <input name="url" type="url" class="form-control" id="url" placeholder="{{__('Label.Please Enter URL')}}" autocomplete="off">
                    </div>
                </div> -->
            </div>
            <!-- <div class="form-row">
                <div class="form-group col-lg-12">
                    <label>{{__('Label.Description')}}</label>
                    <textarea name="description" class="form-control summernote" rows="5" id="description" placeholder="{{__('Label.Hello,')}}"></textarea>
                </div>
            </div> -->
            <!-- <div class="form-row">
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="is_premium">{{__('Label.Is Premium')}}</label>
                        <select class="form-control" id="is_premium" name="is_premium">
                            <option value="0">{{__('Label.No')}}</option>
                            <option value="1">{{__('Label.Yes')}}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="is_title">{{__('Label.Is Title')}}</label>
                        <select class="form-control" id="is_title" name="is_title">
                            <option value="0">{{__('Label.No')}}</option>
                            <option value="1">{{__('Label.Yes')}}</option>
                        </select>
                    </div>
                </div>
            </div> -->
            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="image">{{__('Label.IMAGE')}}</label>
                        <input type="file" class="form-control" id="image" name="image">
                        <label class="mt-1 text-gray">{{__('Label.Note_Image')}}</label>
                    </div>
                </div>
				<div class="col-md-6">
                    <div class="form-group">
                        <label for="landscape">{{__('Label.Landscape Image')}}</label>
                        <input type="file" class="form-control" id="landscape" name="landscape">
                        <label class="mt-1 text-gray">{{__('Label.Note_Image')}}</label>
                    </div>
                </div>
            </div>
			<div class="form-row mb-5">
				<div class="col-md-6">
                    <div class="form-group">
                        <div class="custom-file">
                            <img src="{{asset('assets/imgs/1.png')}}" height="120px" width="120px" class="mb-3 img-thumbnail" id="preview-image-before-upload">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="custom-file">
                            <img src="{{asset('assets/imgs/1.png')}}" height="120px" width="120px" class="mb-3 img-thumbnail" id="preview-image-before-upload1">
                        </div>
                    </div>
                </div>
            </div>
            <div class="border-top mt-2 pt-3 text-right">
                <button type="button" class="btn btn-default mw-120" onclick="save_channel()">{{__('Label.SAVE')}}</button>
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
        function save_channel() {
            var formData = new FormData($("#save_channel")[0]);
            $("#dvloader").show();
            $.ajax({
                type: 'POST',
                url: '{{ route("channelSave") }}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(resp) {
                    $("#dvloader").hide();
                    get_responce_message(resp, 'save_channel', '{{ route("channel") }}');
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    $("#dvloader").hide();
                    toastr.error(errorThrown.msg, 'failed');
                }
            });
        }
        $(document).ready(function(e) {
            $('#landscape').change(function() {
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#preview-image-before-upload1').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });
        });
    </script>
@endpush