@extends('admin.layouts.master')
@section('title', __('Label.Add Cast'))
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
                    <a href="{{ route('cast') }}">Cast</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{__('Label.Add Cast')}}
                </li>
            </ol>
        </div>
        <div class="col-sm-2 d-flex align-items-center justify-content-end">
            <a href="{{ route('cast') }}" class="btn btn-default mw-120" style="margin-top:-14px">{{__('Label.Cast')}}</a>
        </div>
    </div>

    <div class="card custom-border-card mt-3">
        <form id="save_cast">
            @csrf
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="name">{{__('Label.NAME')}}</label>
                        <input name="name" type="text" class="form-control" id="name" placeholder="{{__('Label.Please Enter Cast')}}" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="type">{{__('Label.Type')}}</label>
                        <select class="form-control" id="type" name="type">
                            <option value="">{{__('Label.Select Type')}}</option>
                            <option value="Director">{{__('Label.Director')}}</option>
                            <option value="Writer">{{__('Label.Writer')}}</option>
                            <option value="Actor"> {{__('Label.Actor')}}</option>
                            <option value="Actress"> {{__('Label.Actress')}}</option>
                            <option value="Cricketer"> {{__('Label.Cricketer')}}</option>
                            <option value="Dancers"> {{__('Label.Dancers')}}</option>
                            <option value="Journalist"> {{__('Label.Journalist')}}</option>
                            <option value="Other"> {{__('Label.Other')}}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-row">
				<div class="form-group col-lg-12">
                    <label>{{__('Label.Personal Info')}}</label>
                    <textarea name="personal_info" class="form-control" rows="5" id="personal_info" placeholder="I am ..."></textarea>
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
                <button type="button" class="btn btn-default mw-120" onclick="save_cast()">{{__('Label.SAVE')}}</button>
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
        function save_cast() {

            var formData = new FormData($("#save_cast")[0]);
            $("#dvloader").show();
            $.ajax({
                type: 'POST',
                url: '{{ route("castSave") }}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(resp) {
                    $("#dvloader").hide();
                    get_responce_message(resp, 'save_cast', '{{ route("cast") }}');
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    $("#dvloader").hide();
                    toastr.error(errorThrown.msg, 'failed');
                }
            });
        }
	</script>
@endpush