@extends('admin.layouts.master')
@section('title', __('Label.Edit Category'))
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
              <a href="{{ route('category') }}">{{__('Label.Category')}}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
              {{__('Label.Edit Category')}}
            </li>
          </ol>
        </div>
        <div class="col-sm-2 d-flex align-items-center justify-content-end">
          <a href="{{ route('category') }}" class="btn btn-default mw-120" style="margin-top:-14px">{{__('Label.Category')}}</a>
        </div>
      </div>

      <div class="card custom-border-card mt-3">
      	<form enctype="multipart/form-data" id="save_edit_category">
          @csrf
      		<div class="form-row">
      			<div class="col-md-12 mb-3">
      				<div class="form-group">
      					<label for="name">{{__('Label.NAME')}}</label>
      					<input name="name" type="text" class="form-control" id="name" value="{{$result->name}}" autocomplete="off" placeholder="{{__('Label.Please Enter Category')}}">
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
                  <?php 
                    if ($result->image){
                      $app = Get_Image('category',$result->image);
                    } else{
                      $app = asset('assets/imgs/1.png');
                    }
                  ?>
                  <img  src="{{$app}}" height="120px" width="120px" class="img-thumbnail" id="preview-image-before-upload">
      						<input type="hidden" name="old_image" value="{{$result->image}}">
                </div>
              </div>
            </div>
          </div>
      		<div class="border-top mt-2 pt-3 text-right">
      			<input type="hidden" value="{{$result->id}}" name="id">
      			<button type="button" class="btn btn-default mw-120" onclick="save_edit_category()">{{__('Label.UPDATE')}}</button>
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

    function save_edit_category(){
      var formData = new FormData($("#save_edit_category")[0]);
      $("#dvloader").show();
      $.ajax({
        type:'POST',
        url:'{{ route("categoryUpdate") }}',
        data:formData,
        cache:false,
        contentType: false,
        processData: false,
        success:function(resp){
          $("#dvloader").hide();
          get_responce_message(resp, 'save_edit_category', '{{ route("category") }}');
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          $("#dvloader").hide();
          toastr.error(errorThrown.msg,'failed');         
        }
      });
    }
  </script>
@endpush