<html lang="en">
  <head>
    <meta charset="UTF-8">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    
    @include('admin.layouts.header')
  </head>

  <body>
  	@include('admin.layouts.sidebar')

	<div class="right-content">
		<header class="header">
			<div class="title-control">
			<button class="btn side-toggle">
				<span></span>
				<span></span>
				<span></span>
			</button>
			<a href="#">
				<img src="{{asset('assets/imgs/dtlive.png')}}" alt="" class="side-logo" />
			</a>
			<h1 class="page-title">Edit Page</h1>
			</div>
			<div class="head-control">

			<a href="{{ route('setting') }}" class="btn head-btn  d-none d-md-flex ">
				<img src="{{ asset('assets/imgs/setting-colored.png') }}" />
			</a>
			
			<div class="dropdown dropright">
				<a href="#" class="btn head-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<img src="{{ asset('assets/imgs/Profile.png') }}" class="avatar-img" />
				</a>
				<div class="dropdown-menu p-2 mt-2" aria-labelledby="dropdownMenuLink">
				<a class="dropdown-item" href="#">
					<?php $data = adminEmail(); echo $data->user_name; ?>
					<br>
					<?php echo $data->email; ?>
				</a>
				<a class="dropdown-item" href="{{ route('adminLogout')}}" style="color:#4E45B8;"><span><img src="{{ asset('assets/imgs/Logout-sm.png') }}" class="mr-2"></span>{{__('Label.Logout')}}</a>
				</div>
			</div>
			</div>
		</header>

		<div class="body-content">
      		<!-- mobile title -->
      		<h1 class="page-title-sm">Edit Page</h1>

			<div class="border-bottom row mb-3">
				<div class="col-sm-10">
					<ol class="breadcrumb">
						<li class="breadcrumb-item">
							<a href="{{ route('dashboard') }}">{{__('Label.Dashboard')}}</a>
						</li>
						<li class="breadcrumb-item">
							<a href="{{ route('Page') }}">Page</a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">
							Edit Page
						</li>
					</ol>
				</div>
				<div class="col-sm-2 d-flex align-items-center justify-content-end">
					<a href="{{ route('Page') }}" class="btn btn-default mw-120" style="margin-top:-14px">Page</a>
				</div>
			</div>

			<div class="card custom-border-card mt-3">
				<form id="edit_page">
					@csrf
					<div class="form-row">
						<div class="col-md-12 mb-3">
							<div class="form-group">
							<label>{{__('Label.TITLE')}}</label>
							<input name="title" type="text" class="form-control" id="title" value="{{$result->title}}" placeholder="Please Enter Title" autocomplete="off">
							</div>
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-12 mb-3">
							<div class="form-group">
								<label>DESCRIPTION</label>
								<textarea class="form-control" name="description" id="summernote">{{$result->description}}</textarea>
							</div>
						</div>
					</div>
					<div class="border-top mt-2 pt-3 text-right">
						<input type="hidden" value="{{$result->id}}" name="id">
						<button type="button" class="btn btn-default mw-120" onclick="edit_page()">{{__('Label.UPDATE')}}</button>
					</div>
				</form>
			</div>

			<div style="display:none" id="dvloader"><img src="{{ asset('assets/imgs/loading.gif')}}" /></div>
		</div>
	</div>

	<script type="text/javascript">
		function edit_page(){
			var formData = new FormData($("#edit_page")[0]);
			$("#dvloader").show();
			$.ajax({
				type:'POST',
				url:'{{ route("PageUpdate") }}',
				data:formData,
				cache:false,
				contentType: false,
				processData: false,
				success:function(resp){
					$("#dvloader").hide();
					get_responce_message(resp, 'edit_page', '{{ route("Page") }}');
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					$("#dvloader").hide();
					toastr.error(errorThrown.msg,'failed');         
				}
			});
		}
	     $('#summernote').summernote({
			placeholder: 'Hello stand alone ui',
			tabsize: 2,
			height: 120,
			toolbar: [
				['style', ['style']],
				['font', ['bold', 'underline', 'clear']],
				['color', ['color']],
				['para', ['ul', 'ol', 'paragraph']],
				['table', ['table']],
				['insert', ['link', 'picture', 'video']],
				['view', ['fullscreen', 'codeview', 'help']]
			]
		});
		function get_responce_message(resp, form_name="", url="") {
                if (resp.status == '200') {
                    toastr.success(resp.success);
                    document.getElementById(form_name).reset();
                    setTimeout(function() {
                        window.location.replace(url);
                    }, 500);
                } else {
                    var obj = resp.errors;
                    if (typeof obj === 'string') {
                        toastr.error(obj);
                    } else {
                        $.each(obj, function(i, e) {
                            toastr.error(e);
                        });
                    }
                }
            }
	</script>
	<script src="{{ asset('/assets/js/js.js')}}"></script>
	<!-- Toastr -->
	<script src="{{ asset('/assets/js/toastr.min.js')}}"></script>
  </body>
</html>
