@extends('admin.layouts.master')
@section('title', 'Edit Channel Banner')
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
      				Edit Banner
      			</li>
      		</ol>
      	</div>
      	<div class="col-sm-2 d-flex align-items-center justify-content-end">
      		<a href="{{ route('ChannelBanner') }}" class="btn btn-default mw-120" style="margin-top:-14px">Banner</a>
      	</div>
      </div>

      <div class="card custom-border-card mt-3">
	 	<form id="edit_channel_banner">
			@csrf
			<div class="form-row">
				<div class="col-md-6 mb-3">
					<div class="form-group">
						<label>{{__('Label.NAME')}}</label>
						<select class="form-control" name="name">
							<option value="">{{__('Label.Select_Name')}}</option>
							@foreach ($channel as $key => $value)
							<option value="{{ $value->name}}" {{ $result->name == $value->name  ? 'selected' : ''}}>
								{{ $value->name }}
							</option>
							@endforeach
						</select>
					</div>
                	</div>
				<div class="col-md-6 mb-3">
					<div class="form-group">
					<label for="link">{{__('Label.Link')}}</label>
					<input name="link" type="text" class="form-control" id="link" placeholder="Please Enter Link" autocomplete="off" value="{{ $result->link}}">
					</div>
				</div>
			</div>
			<div class="form-row">
				<div class="col-md-6 mb-3">
					<div class="form-group">
					<label for="order_no">Order No</label>
					<input name="order_no" type="number" class="form-control" id="order_no" placeholder="Please Enter No" value="{{ $result->order_no}}">
					</div>
				</div>
			</div>
			<div class="form-row">
				<div class="col-md-6 mb-3"> 
					<div class="form-group"> 
						<label for="image">{{__('Label.IMAGE')}}</label> 
						<input type="file" class="form-control" id="image" name="image" value="{{$result->image}}"> 
						<label class="mt-1 text-gray">{{__('Label.Note_Image')}}</label>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<div class="custom-file ml-5">
							<?php 
							if($result->image){
								$app = Get_Image('show',$result->image);
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
      		<div class="border-top mt-2 pt-3 text-right">
      			<input type="hidden" value="{{$result->id}}" name="id">
      			<button type="button" class="btn btn-default mw-120" onclick="edit_channel_banner()">{{__('Label.UPDATE')}}</button>
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

		function edit_channel_banner(){

			var formData = new FormData($("#edit_channel_banner")[0]);
			$("#dvloader").show();
			$.ajax({
				type:'POST',
				url:'{{ route("ChannelBannerUpdate") }}',
				data:formData,
				cache:false,
				contentType: false,
				processData: false,
				success:function(resp){
					$("#dvloader").hide();
					get_responce_message(resp, 'edit_channel_banner', '{{ route("ChannelBanner") }}');
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					$("#dvloader").hide();
					toastr.error(errorThrown.msg,'failed');         
				}
			});
		}
	</script>
@endpush