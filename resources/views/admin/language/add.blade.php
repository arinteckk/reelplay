@extends('admin.layouts.master')
@section('title', __('Label.Add Language'))
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
    					<a href="{{ route('language') }}">{{__('Label.Language')}}</a>
    				</li>
    				<li class="breadcrumb-item active" aria-current="page">
    					{{__('Label.Add Language')}}
    				</li>
    			</ol>
    		</div>
    		<div class="col-sm-2 d-flex align-items-center justify-content-end">
    			<a href="{{ route('language') }}" class="btn btn-default mw-120" style="margin-top:-14px">{{__('Label.Language')}}</a>
    		</div>
    	</div>

    	<div class="card custom-border-card mt-3">
    		<form enctype="multipart/form-data" id="save_language">
    			@csrf
    			<div class="form-row">
    				<div class="col-md-6 mb-3">
    					<div class="form-group">
    						<label for="name">{{__('Label.Name')}}</label>
    						<input name="name" type="text" class="form-control" id="name" autocomplete="off" placeholder="{{__('Label.Enter Language Name')}}">
    					</div>
    				</div>
				<!-- <div class="col-md-6 mb-3">
    					<div class="form-group">
    						<label for="lang_code">{{__('Label.Language Code')}}</label>
    						<input name="lang_code" type="text" class="form-control" id="lang_code" placeholder="{{__('Label.Enter Language Code')}}">
    					</div>
    				</div> -->
    			</div>
    			<div class="form-row">
    				<div class="col-md-6">
    					<div class="form-group">
    						<label for="image">{{__('Label.IMAGE')}}</label>
    						<input type="file" class="form-control" id="image" name="image">
    						<label class="mt-1 text-gray">{{__('Label.Note_Image')}}</label>
    					</div>
    				</div>
					
    				<div class="col-md-6 mb-3">
    					<div class="col-md-6"> 
    						<div class="form-group">
    							<div class="custom-file ml-5"> 
    								<img  src="{{asset('assets/imgs/1.png')}}" height="120px" width="120px" class="img-thumbnail" id="preview-image-before-upload">
    							</div>
    						</div>
    					</div>
    				</div>
    			</div>
    			<div class="border-top mt-2 pt-3 text-right">
    				<button type="button" class="btn btn-default mw-120" onclick="save_language()">{{__('Label.SAVE')}}</button>
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

		function save_language(){
			var formData = new FormData($("#save_language")[0]);
			$("#dvloader").show();
			$.ajax({
				type:'POST',
				url:'{{ route("languageSave") }}',
				data:formData,
				cache:false,
				contentType: false,
				processData: false,
				success:function(resp){
					$("#dvloader").hide();
					get_responce_message(resp, 'save_language', '{{ route("language") }}');
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					$("#dvloader").hide();
					toastr.error(errorThrown.msg,'failed');         
				}
			});
		}
	</script>
@endpush
