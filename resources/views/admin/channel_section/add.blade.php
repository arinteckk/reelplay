@extends('admin.layouts.master')
@section('title', 'Add Channel Section')
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
                    <a href="{{ route('ChannelSection') }}">Channel Section</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   Add Channel Section
                </li>
            </ol>
        </div>
        <div class="col-sm-2 d-flex align-items-center">
            <a href="{{ route('ChannelSection') }}" class="btn btn-default mw-120" style="margin-top:-14px">Channel Section List</a>
        </div>
    </div>

    <div class="card custom-border-card mt-3">
        <form enctype="multipart/form-data" id="save_channel_section">
            @csrf
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="title">{{__('Label.Title')}}</label>
                        <input name="title" type="text" class="form-control" id="title" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="category_id">{{__('Label.Category')}}</label>
                        <select class="form-control" name="category_id" id="category_id">
                            <option value="">{{__('Label.Select Category')}}</option>
                            @foreach ($category as $key => $value)
                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="channel_id">{{__('Label.Channel')}}</label>
                        <select class="form-control" name="channel_id" id="channel_id">
                            <option value="">{{__('Label.Select Channel')}}</option>
                            @foreach ($channel as $key => $value)
                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="live_url">{{__('Label.URL')}}</label>
                        <input name="live_url" type="text" class="form-control" id="live_url" autocomplete="off">
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="type_id">{{__('Label.Type')}}</label>
                        <select class="form-control" name="type_id" id="type_id" onclick="SelectTypeId()">
                            <option value="">{{__('Label.Select Type')}}</option>
                            @foreach ($type as $key => $value)
                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="video_type">{{__('Label.Video Type')}}</label>
                        <select class="form-control" name="video_type" id="video_type" class="video_type">
                            <option value="">{{__('Label.Select Video Type')}}</option>
                            <option value="1">{{__('Label.Video')}}</option>
                            <option value="2">{{__('Label.Show')}}</option>
                            <option value="3">{{__('Label.Language')}}</option>
                            <option value="4">{{__('Label.Category')}}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="screen_layout">Screen Layout</label>
                        <select class="form-control" name="screen_layout">
                            <option value="landscape">Landscape</option>
                            <option value="square">Square</option>
                            <option value="potrait">Potrait</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6 mb-3 option_class_video">
                    <div class="form-group">
                        <label for="video_id">{{__('Label.Video')}}</label>
                        <select class="form-control selectd2" style="width:100%!important;" name="video_id[]" multiple id="video_id">
                            @foreach ($video as $key => $value)
                            <option value="{{ $value->id}}">
                                {{ $value->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6 mb-3 option_class_show">
                    <div class="form-group">
                        <label for="tv_show_id">{{__('Label.TV Show')}}</label>
                        <select class="form-control selectd2_1" style="width:100%!important;" name="tv_show_id[]" multiple id="tv_show_id">
                            @foreach ($tvshow as $key => $value)
                            <option value="{{ $value->id}}">
                                {{ $value->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6 mb-3 option_class_language">
                    <div class="form-group">
                        <label for="language_id">{{__('Label.Language')}}</label>
                        <select class="form-control selectd2_2" style="width:100%!important;" name="language_id[]" multiple id="language_id">
                            @foreach ($language as $key => $value)
                            <option value="{{ $value->id}}">
                                {{ $value->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6 mb-3 option_class_category">
                    <div class="form-group">
                        <label for="category_ids">{{__('Label.Category')}}</label>
                        <select class="form-control selectd2_3" style="width:100%!important;" name="category_ids[]" multiple id="category_ids">
                            @foreach ($category as $key => $value)
                            <option value="{{ $value->id}}">
                                {{ $value->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>        
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="section_type">Section Type</label>
                        <select class="form-control" id="section_type" name="section_type">
                            <option value="1">Normal Screen</option>
                            <option value="2">Banner Screen</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="border-top mt-2 pt-3 text-right">
                <button type="button" class="btn btn-default mw-120" onclick="save_channel_section()">{{__('Label.SAVE')}}</button>
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
		
		$(document).ready(function() {
            
            $("#video_id").select2();
            $(".selectd2").select2({
                placeholder: "Select Video"
            });
			
            $("#tv_show_id").select2();
            $(".selectd2_1").select2({
                placeholder: "Select TVShow"
            });
            
            $("#language_id").select2();
			$(".selectd2_2").select2({
                placeholder: "{{__('Label.Select Language')}}"
			});

            $("#category_ids").select2();
            $(".selectd2_3").select2({
                placeholder: "{{__('Label.Select Category')}}"
            });
		
            $('.option_class_video').hide();
			$('.option_class_show').hide();
            $('.option_class_language').hide();
            $('.option_class_category').hide();   
			$('.option_class_session').hide();
        });

		$('#video_type').on('click', function() {
			var question_type = $("#video_type").val()
			if (question_type == "1") {
				$('.option_class_video').show();
				$('.option_class_show').hide();
				$('.option_class_language').hide();
				$('.option_class_category').hide();     
                $('.option_class_session').hide();           
			} else if (question_type == "2") {
				$('.option_class_show').show();
                $('.option_class_video').hide();
				$('.option_class_language').hide();
				$('.option_class_category').hide();
                $('.option_class_session').hide();
            } else if (question_type == "3") {
                $('.option_class_video').hide();
				$('.option_class_show').hide();
				$('.option_class_language').show();
				$('.option_class_category').hide();
                $('.option_class_session').hide();
            } else if (question_type == "4") {
                $('.option_class_video').hide();
				$('.option_class_show').hide();
				$('.option_class_language').hide();
				$('.option_class_category').show();
                $('.option_class_session').hide();
            } else {
                $('.option_class_video').hide();
				$('.option_class_show').hide();
				$('.option_class_language').hide();
				$('.option_class_category').hide();
                $('.option_class_session').hide();
            }
		})

        function SelectTypeId(){
            var Type_id = $('#type_id').find(":selected").val();

            if(Type_id != null && Type_id !=""){
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'get',
                    url: '{{ route("ChannelSectionAdd") }}',
                    data: {type_id:Type_id},
                    success: function(resp) {
                        $('#video_id option').remove();
                        $('#tv_show_id option').remove();
                        for (let i = 0; i < resp.video.length; i++) {           
                            $('#video_id').append(new Option(resp.video[i].name, resp.video[i].id));
                        }
                        for (let i = 0; i < resp.tvshow.length; i++) {           
                            $('#tv_show_id').append(new Option(resp.tvshow[i].name, resp.tvshow[i].id));
                        }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        toastr.error(errorThrown.msg, 'failed');
                    }
                });
            };
        };

        function save_channel_section() {
			var formData = new FormData($("#save_channel_section")[0]);
            $("#dvloader").show();
			$.ajax({
				type: 'POST',
				url: '{{ route("ChannelSectionSave") }}',
				data: formData,
				cache: false,
				contentType: false,
				processData: false,
				success: function(resp) {
                    $("#dvloader").hide();
					get_responce_message(resp, 'save_channel_section', '{{ route("ChannelSection") }}');
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
                    $("#dvloader").hide();
					toastr.error(errorThrown.msg, 'failed');
				}
			});
		}

	</script>	
@endpush