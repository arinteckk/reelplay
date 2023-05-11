@extends('admin.layouts.master')
@section('title', __('Label.Add User'))
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
  						<a href="{{ route('user') }}">{{__('Label.Users')}}</a>
  					</li>
  					<li class="breadcrumb-item active" aria-current="page">
  						{{__('Label.Add User')}}
  					</li>
  				</ol>
  			</div>
  			<div class="col-sm-2 d-flex align-items-center justify-content-end">
  				<a href="{{ route('user') }}" class="btn btn-default mw-120" style="margin-top:-14px">{{__('Label.Users List')}}</a>
  			</div>
  		</div>

  		<div class="card custom-border-card mt-3">
  			<form id="save_user" enctype="multipart/form-data">
  				@csrf
  				<div class="form-row">
  					<div class="col-md-6 mb-3">
  						<div class="form-group">
  							<label for="name"> {{__('Label.NAME')}} </label>
  							<input name="name" type="text" class="form-control" id="name" placeholder="Enter Your Name" autocomplete="off">
  						</div>
  					</div>
  					<div class="col-md-6 mb-3">
  						<div class="form-group">
  							<label for="mobile"> {{__('Label.MOBILE NUMBER')}} </label>
  							<input name="mobile" type="number" class="form-control" id="mobile" placeholder="Enter Mobile Number" autocomplete="off">
  						</div>
  					</div>
  				</div>
  				<div class="form-row">
  					<div class="col-md-6 mb-3">
  						<div class="form-group">
  							<label for="email">{{__('Label.EMAIL')}}</label>
  							<input name="email" type="email" class="form-control" id="email" placeholder="Enter Email" autocomplete="off">
  						</div>
  					</div>
  					<div class="col-md-6 mb-3">
    					<div class="form-group">
    						<label for="gender"> {{__('Label.Gender')}}</label>
    						<select class="form-control" id="gender" name="gender">
    							<option value="male"> Male</option>
    							<option value="female"> Female</option>
    						</select>
    					</div>
    				</div>
  				</div>
  				
  				<div class="form-row">
  					<div class="col-md-6"> 
  						<div class="form-group"> 
  							<label for="image">{{__('Label.IMAGE')}}</label> 
  							<input type="file" class="form-control" id="image" name="image" > 
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
  				<div class="border-top pt-3 text-right">
  					<button type="button" class="btn btn-default mw-120" onclick="save_user()">{{__('Label.SAVE')}}</button>
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

		function save_user(){
			var formData = new FormData($("#save_user")[0]);
			$("#dvloader").show();
			$.ajax({
				type:'POST',
				url:'{{ route("userSave") }}',
				data:formData,
				cache:false,
				contentType: false,
				processData: false,
				success:function(resp){
					$("#dvloader").hide();
					get_responce_message(resp, 'save_user', '{{ route("user") }}');
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					$("#dvloader").hide();
					toastr.error(errorThrown.msg,'failed');         
				}
			});
		}
	</script>
@endpush
