@include('admin.layouts.header')

	@include('admin.layouts.sidebar')
	<!-- Start: Content Wrapper -->
	<div class="content-wrapper">
		@include('admin.layouts.navbar')
		@include('admin.layouts.contenct')
		<div style="display:none" id="dvloader"><img src="{{ asset('assets/imgs/loading.gif')}}" /></div>
	</div>
	<!-- End: Content Wrapper -->
	
	@include('admin.layouts.footer')
	@stack('scripts')
	<!-- End: Javascript -->
	

