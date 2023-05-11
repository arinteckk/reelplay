@extends('admin.layouts.master')
@section('title', 'Add Episodes')
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
                    <a href="{{ route('TVShow') }}">{{__('Label.TV Show')}}</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('TVShowvideo', ['id' => $tvshowId]) }}">Episode List</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Add Episode
                </li>
            </ol>
        </div>
        <div class="col-sm-2 d-flex align-items-center justify-content-end">
            <a href="{{ route('TVShowvideo',['id'=> $tvshowId]) }}" class="btn btn-default mw-120" style="margin-top:-14px">Episode List</a>
        </div>
    </div>

    <div class="card custom-border-card mt-3">
        <form enctype="multipart/form-data" id="save_TVShow_video" autocomplete="off">
            @csrf
            <input type="hidden" name="show_id" id="show_id" value="{{$tvshowId}}">
            <div class="custom-border-card">
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label>{{__('Label.Session')}}</label>
                            <select class="form-control" id="session_id" name="session_id">
                                <option value="">{{__('Label.Select Session')}}</option>
                                @foreach ($session as $key => $value)
                                <option value="{{ $value->id}}">
                                    {{ $value->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="video_duration">Video Duration</label>
                            <input name="video_duration" type="time" step="1" value="00:00:00" class="form-control" id="video_duration">
                        </div>
                    </div> 
                </div>
                <div class="form-row">
                    <div class="form-group col-lg-6">
                        <label for="video_upload_type">{{__('Label.Video Upload Type')}}</label>
                        <select name="video_upload_type" id="video_upload_type" class="form-control">
                            <option selected="selected" value="server_video">{{__('Label.Server Video')}}</option>
                            <option value="external">External URL</option>
                            <option value="youtube">Youtube</option>
                            <option value="vimeo">Vimeo</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-group Is_Download">
                            <label for="download">Is Download</label>
                            <select class="form-control" name="download">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                            </select>
                        </div>
                    </div>    
                </div>
                <div class="form-row">
                    <div class="form-group col-lg-3 video_box">
                        <div style="display: block;">
                            <label>{{__('Label.Upload Video (320 px)')}}</label>
                            <div id="filelist"></div>
                            <div id="container" style="position: relative;">
                                <div class="form-group">
                                    <input type="file" id="uploadFile" name="uploadFile" style="position: relative; z-index: 1;" class="form-control">
                                </div>
                                <input type="hidden" name="upload_video_320" id="mp3_file_name" class="form-control">
    
                                <div class="form-group">
                                    <a id="upload" class="btn text-white" style="background-color:#4e45b8;">{{__('Label.Upload Files')}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 video_box">
                        <div style="display: block;">
                            <label>{{__('Label.Upload Video (480 px)')}}</label>
                            <div id="filelist1"></div>
                            <div id="container1" style="position: relative;">
                                <div class="form-group">
                                    <input type="file" id="uploadFile1" name="uploadFile1" style="position: relative; z-index: 1;" class="form-control">
                                </div>
                                <input type="hidden" name="upload_video_480" id="mp3_file_name1" class="form-control">
    
                                <div class="form-group">
                                    <a id="upload1" class="btn text-white" style="background-color:#4e45b8;">{{__('Label.Upload Files')}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 video_box">
                        <div style="display: block;">
                            <label>{{__('Label.Upload Video (720 px)')}}</label>
                            <div id="filelist2"></div>
                            <div id="container2" style="position: relative;">
                                <div class="form-group">
                                    <input type="file" id="uploadFile2" name="uploadFile2" style="position: relative; z-index: 1;" class="form-control">
                                </div>
                                <input type="hidden" name="upload_video_720" id="mp3_file_name2" class="form-control">
    
                                <div class="form-group">
                                    <a id="upload2" class="btn text-white" style="background-color:#4e45b8;">{{__('Label.Upload Files')}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-lg-3 video_box">
                        <div style="display: block;">
                            <label>{{__('Label.Upload Video (1080 px)')}}</label>
                            <div id="filelist3"></div>
                            <div id="container3" style="position: relative;">
                                <div class="form-group">
                                    <input type="file" id="uploadFile3" name="uploadFile3" style="position: relative; z-index: 1;" class="form-control">
                                </div>
                                <input type="hidden" name="upload_video_1080" id="mp3_file_name3" class="form-control">
    
                                <div class="form-group">
                                    <a id="upload3" class="btn text-white" style="background-color:#4e45b8;">{{__('Label.Upload Files')}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-lg-6 url_box">
                        <label for="url">{{__('Label.URL (320 px)')}}</label>
                        <input name="video_url_320" type="url" class="form-control" placeholder="Enter Video URL (320 px)">
                    </div>
                    <div class="form-group col-lg-6 url_box">
                        <label for="url">{{__('Label.URL (480 px)')}}</label>
                        <input name="video_url_480" type="url" class="form-control" placeholder="Enter Video URL (480 px)">
                    </div>
                    <div class="form-group col-lg-6 url_box">
                        <label for="url">{{__('Label.URL (720 px)')}}</label>
                        <input name="video_url_720" type="url" class="form-control" placeholder="Enter Video URL (720 px)">
                    </div>
                    <div class="form-group col-lg-6 url_box">
                        <label for="url">{{__('Label.URL (1080 px)')}}</label>
                        <input name="video_url_1080" type="url" class="form-control" placeholder="Enter Video URL (1080 px)">
                    </div>
                </div>
            </div>
            <div class="custom-border-card">
                <div class="form-row">
                    <div class="form-group col-lg-6">
                        <label for="subtitle_type">Subtitle Type</label>
                        <select name="subtitle_type" id="subtitle_type" class="form-control">
                            <option selected="selected" value="server_file">Server File</option>
                            <option value="external_url">External URL</option>
                        </select>
                    </div>
                    <div class="form-group col-lg-6 subtitle_box">
                        <div style="display: block;">
                            <label>SubTitle</label>
                            <div id="filelist4"></div>
                            <div id="container4" style="position: relative;">
                                <div class="form-group">
                                    <input type="file" id="uploadFile4" name="uploadFile4" style="position: relative; z-index: 1;" class="form-control">
                                </div>
                                <input type="hidden" name="subtitle" id="mp3_file_name4" class="form-control">
    
                                <div class="form-group">
                                    <a id="upload4" class="btn text-white" style="background-color:#4e45b8;">{{__('Label.Upload Files')}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-lg-6 subtitle_url_box">
                        <label for="url">SubTitle</label>
                        <input name="subtitle_url" type="url" class="form-control" placeholder="Enter Subtitle URL">
                    </div>
                </div>
            </div>
            <div class="custom-border-card">
                <div class="form-row">
                    <div class="form-group col-lg-12">
                        <label for="description">{{__('Label.Description')}}</label>
                        <textarea name="description" class="form-control" rows="3" id="description" placeholder="{{__('Label.Hello,')}}"></textarea>
                    </div>
                </div>
                <div class="form-row">
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
                </div>
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="thumbnail">{{__('Label.Thumbnail Image')}}</label>
                            <input type="file" class="form-control" id="thumbnail" name="thumbnail">
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
                                <img src="{{asset('assets/imgs/1.png')}}" height="120px" width="120px" class="mb-3 img-thumbnail"
                                    id="preview-image-before-upload">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="custom-file">
                                <img src="{{asset('assets/imgs/1.png')}}" height="120px" width="120px" class="mb-3 img-thumbnail"
                                    id="preview-image-before-upload1">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="border-top mt-2 pt-3 text-right">
                <button type="button" class="btn btn-default mw-120" onclick="save_TVShow_video()">{{__('Label.SAVE')}}</button>
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
		function save_TVShow_video() {
			var formData = new FormData($("#save_TVShow_video")[0]);
            $("#dvloader").show();
			$.ajax({
				type: 'POST',
				url: '{{ route("TVShow_video_Save") }}',
				data: formData,
				cache: false,
				contentType: false,
				processData: false,
				success: function(resp) {
                    $("#dvloader").hide();
					get_responce_message(resp, 'save_TVShow_video', '{{ route("TVShowvideo",['id' => $tvshowId]) }}');
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
                    $("#dvloader").hide();
					toastr.error(errorThrown.msg, 'failed');
				}
			});
		}

        $(document).ready(function() {
            $(".url_box").hide();
            $('#video_upload_type').change(function() {
                var optionValue = $(this).val();
    
                if (optionValue == 'server_video') {
                    $(".video_box").show();
                    $(".url_box").hide();
                } else {
                    $(".url_box").show();
                    $(".video_box").hide();
                }

                if (optionValue == 'server_video' || optionValue == 'external') {
                    $(".Is_Download").show();
                } else {
                    $(".Is_Download").hide();
                }
            });

            $(".subtitle_url_box").hide();
            $('#subtitle_type').change(function() {
                var optionValue = $(this).val();
    
                if (optionValue == 'server_file') {
                    $(".subtitle_box").show();
                    $(".subtitle_url_box").hide();
                } else {
                    $(".subtitle_url_box").show();
                    $(".subtitle_box").hide();
                }
            });
		});
	</script>
@endpush