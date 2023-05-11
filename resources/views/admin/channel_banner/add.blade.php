@extends('admin.layouts.master')
@section('title', 'Add Channel Banner')
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
                    <a href="{{ route('ChannelBanner') }}">Banner</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   Add Banner
                </li>
            </ol>
        </div>
        <div class="col-sm-2 d-flex align-items-center justify-content-end">
            <a href="{{ route('ChannelBanner') }}" class="btn btn-default mw-120" style="margin-top:-14px">Banner</a>
        </div>
    </div>

    <div class="card custom-border-card mt-3">
        <form id="save_channel_banner">
            @csrf
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label>{{__('Label.NAME')}}</label>
                        <select class="form-control" name="name">
                            <option value="">{{__('Label.Select_Name')}}</option>
                            @foreach ($channel as $key => $value)
                            <option value="{{ $value->name}}">
                                {{ $value->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="link">{{__('Label.Link')}}</label>
                        <input name="link" type="text" class="form-control" id="link" placeholder="Please Enter Link" autocomplete="off">
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="order_no">Order No</label>
                        <input name="order_no" type="number" class="form-control" id="order_no" placeholder="Please Enter No">
                    </div>
                </div>
            </div>
			<div class="form-row">
                <div class="col-md-6"> 
                    <div class="form-group"> 
                        <label for="image">{{__('Label.IMAGE')}}</label> 
                        <input type="file" class="form-control" id="image" name="image" autocomplete="off"> 
                        <label class="mt-1 text-gray">{{__('Label.Note_Image')}}</label>
                    </div>
                </div>
                <div class="col-md-6"> 
                    <div class="form-group">
                        <div class="custom-file ml-5"> 
                            <img  src="{{asset('assets/imgs/1.png')}}" height="120px" width="120px" class="mb-3 img-thumbnail" id="preview-image-before-upload">
                        </div>
                    </div>
                </div>
            </div>
            <div class="border-top mt-2 pt-3 text-right">
                <button type="button" class="btn btn-default mw-120" onclick="save_channel_banner()">{{__('Label.SAVE')}}</button>
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

        function save_channel_banner() {

            var formData = new FormData($("#save_channel_banner")[0]);
            $("#dvloader").show();
            $.ajax({
                type: 'POST',
                url: '{{ route("ChannelBannerSave") }}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(resp) {
                    $("#dvloader").hide();
                    get_responce_message(resp, 'save_channel_banner', '{{ route("ChannelBanner") }}');
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    $("#dvloader").hide();
                    toastr.error(errorThrown.msg, 'failed');
                }
            });
        }
	</script>
@endpush