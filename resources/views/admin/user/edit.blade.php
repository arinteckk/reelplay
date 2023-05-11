@extends('admin.layouts.master')
@section('title', __('Label.Edit User'))
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
  							{{__('Label.Edit User')}}
  						</li>
  					</ol>
  				</div>
  				<div class="col-sm-2 d-flex align-items-center justify-content-end">
  					<a href="{{ route('user') }}" class="btn btn-default mw-120" style="margin-top:-14px">{{__('Label.Users List')}}</a>
  				</div>
  			</div>

  			<div class="card custom-border-card mt-3">
  				<form enctype="multipart/form-data" id="save_edit_user">
  					@csrf
  					<div class="form-row">
  						<div class="col-md-6 mb-3">
  							<div class="form-group">
  								<label for="Inputtext1">{{__('Label.NAME')}}</label>
  								<input name="name" type="text" class="form-control" id="Inputtext1" value="{{$result->name}}" placeholder="Enter Your Name" autocomplete="off">
  							</div>
  						</div>
  						<div class="col-md-6 mb-3">
  							<div class="form-group">
  								<label for="Inputnumber1">{{__('Label.MOBILE NUMBER')}}</label>
  								<input name="mobile" type="number" class="form-control" id="Inputnumber1" value="{{$result->mobile}}" placeholder="Enter Mobile Number" autocomplete="off">
  							</div>
  						</div>
  					</div>
  					<div class="form-row">
  						<div class="col-md-6 mb-3">
  							<div class="form-group">
  								<label for="Inputemail1">{{__('Label.EMAIL')}}</label>
  								<input name="email" type="email" class="form-control" id="Inputemail1" value="{{$result->email}}" placeholder="Enter Email" autocomplete="off">
  							</div>
  						</div>
  						<div class="col-md-6 mb-3">
    					<div class="form-group">
    						<label for="gender"> {{__('Label.Gender')}}</label>
    						<select class="form-control" id="gender" name="gender">
    							<option value="male" {{ $result->gender == "male" ? 'selected' : ''}}> Male</option>
    							<option value="female" {{ $result->gender == "female"  ? 'selected' : ''}}> Female</option>
    						</select>
    					</div>
    				</div>
  					</div>
  					<div class="form-row">
  						<div class="col-md-6 mb-3"> 
  							<div class="form-group"> 
  								<label for="image">{{__('Label.IMAGE')}}</label> 
  								<input type="file" class="form-control" id="image" name="image" value="{{$result->profile_img}}"> 
  								<label class="mt-1 text-gray">{{__('Label.Note_Image')}}</label>
  							</div>
  						</div>
  						<div class="col-md-6">
  							<div class="form-group">
  								<div class="custom-file ml-5">
  									<?php 
										if($result->image){
											$app = Get_Image('user',$result->image);
										} else{
											$app = asset('assets/imgs/1.png');
										}
									?>
  									<img  src="{{$app}}" height="120px" width="120px" id="preview-image-before-upload" class="img-thumbnail">
  									<input type="hidden" name="old_image" value="{{$result->image}}">
  								</div>
  							</div>
  						</div>
  					</div>
  					<div class="border-top pt-3 text-right">
  						<input type="hidden" value="{{$result->id}}" name="id">
  						<button type="button" class="btn btn-default mw-120" onclick="save_edit_user()">{{__('Label.UPDATE')}}</button>
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

		function save_edit_user(){
			var formData = new FormData($("#save_edit_user")[0]);
			$("#dvloader").show();
			$.ajax({
				type:'POST',
				url:'{{ route("userUpdate") }}',
				data:formData,
				cache:false,
				contentType: false,
				processData: false,
				success:function(resp){
					$("#dvloader").hide();
					get_responce_message(resp, 'save_edit_user', '{{ route("user") }}');
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					$("#dvloader").hide();
					toastr.error(errorThrown.msg,'failed');         
				}
			});
		}
	</script>
@endpush