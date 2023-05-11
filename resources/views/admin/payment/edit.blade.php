@extends('admin.layouts.master')
@section('title', 'Edit Payment Option')
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
      				<a href="{{ route('Payment') }}">Payment Option</a>
      			</li>
      			<li class="breadcrumb-item active" aria-current="page">
      				Edit Payment Option
      			</li>
      		</ol>
      	</div>
      	<div class="col-sm-2 d-flex align-items-center">
      		<a href="{{ route('Payment') }}" class="btn btn-default mw-120" style="margin-top:-14px">Payment Option</a>
      	</div>
      </div>

      <div class="card custom-border-card mt-3">
	 	<form id="edit_payment_option">
			@csrf
			<div class="form-row">
                	<div class="col-md-12 mb-3">
					<div class="form-group">
					<label for="name">{{__('Label.NAME')}}</label>
					<input name="name" type="text" class="form-control" id="name" readonly
						placeholder="{{__('Label.Please Enter Name')}}" value="{{$result->name}}">
					</div>
				</div>
            	</div>
			<div class="form-row">
				<div class="col-md-6 mb-3">
					<div class="form-group">
						<label for="visibility">{{__('Label.Status')}}</label>
						<select class="form-control" name="visibility" id="visibility">
							<option value="">Select Visibility</option>
							<option value="1" {{$result->visibility == 1 ? 'selected' : ''}}>Active</option>
							<option value="0" {{$result->visibility == 0 ? 'selected' : ''}}>In Active</option>
						</select>
					</div>
				</div>
				<div class="col-md-6 mb-3">
					<div class="form-group">
						<label for="is_live">Payment Environment</label>
						<select class="form-control" name="is_live" id="is_live">
							<option value="">Select Payment Environment</option>
							<option value="1" {{$result->is_live == 1 ? 'selected' : ''}}>Live</option>
							<option value="0" {{$result->is_live == 0 ? 'selected' : ''}}>Sandbox</option>
						</select>
					</div>
				</div>
			</div>
			<!-- Paypal -->
			@if($result->id == 2)
				<div class="form-row">
					<div class="col-md-6 mb-3">
						<div class="form-group">
						<label for="live_key_1">Live Paypal Client ID</label>
						<input name="live_key_1" type="text" class="form-control" id="live_key_1" placeholder="Please Enter ID" value="{{ $result->live_key_1}}">
						</div>
					</div>
					<div class="col-md-6 mb-3">
						<div class="form-group">
						<label for="test_key_1">Test Paypal Client ID</label>
						<input name="test_key_1" type="text" class="form-control" id="test_key_1" placeholder="Please Enter ID" value="{{ $result->test_key_1}}">
						</div>
					</div>
				</div>
			@endif
			<!-- Razorpay -->
			@if($result->id == 3)
				<div class="form-row">
					<div class="col-md-6 mb-3">
						<div class="form-group">
						<label>Live Key Id</label>
						<input name="live_key_1" type="text" class="form-control" id="live_key_1" placeholder="Please Enter ID" value="{{ $result->live_key_1}}">
						</div>
					</div>
					<div class="col-md-6 mb-3">
						<div class="form-group">
						<label>Live Key Secret Id</label>
						<input name="live_key_2" type="text" class="form-control" id="live_key_2" placeholder="Please Enter ID" value="{{ $result->live_key_2}}">
						</div>
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-6 mb-3">
						<div class="form-group">
						<label>Test Key Id</label>
						<input name="test_key_1" type="text" class="form-control" id="test_key_1" placeholder="Please Enter ID" value="{{ $result->test_key_1}}">
						</div>
					</div>
					<div class="col-md-6 mb-3">
						<div class="form-group">
						<label>Test Key Secret Id</label>
						<input name="test_key_2" type="text" class="form-control" id="test_key_2" placeholder="Please Enter ID" value="{{ $result->test_key_2}}">
						</div>
					</div>
				</div>
			@endif
			<!-- FlutterWave -->
			@if($result->id == 4)
				<div class="form-row">
					<div class="col-md-6 mb-3">
						<div class="form-group">
						<label for="live_key_1">Live Public ID</label>
						<input name="live_key_1" type="text" class="form-control" id="live_key_1" placeholder="Please Enter Live Public ID" value="{{ $result->live_key_1}}">
						</div>
					</div>
					<div class="col-md-6 mb-3">
						<div class="form-group">
						<label for="live_key_2">Live Encryption Key</label>
						<input name="live_key_2" type="text" class="form-control" id="live_key_2" placeholder="Please Enter Live Encryption Key" value="{{ $result->live_key_2}}">
						</div>
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-6 mb-3">
						<div class="form-group">
						<label for="test_key_1">Test Public ID</label>
						<input name="test_key_1" type="text" class="form-control" id="test_key_1" placeholder="Please Enter Test Public ID" value="{{ $result->test_key_1}}">
						</div>
					</div>
					<div class="col-md-6 mb-3">
						<div class="form-group">
						<label for="test_key_2">Test Encryption Key</label>
						<input name="test_key_2" type="text" class="form-control" id="test_key_2" placeholder="Please Enter Test Encryption Key" value="{{ $result->test_key_2}}">
						</div>
					</div>
				</div>
			@endif
			<!-- PayUMoney -->
			@if($result->id == 5)
				<div class="form-row">
					<div class="col-md-6 mb-3">
						<div class="form-group">
						<label for="live_key_1">Live Merchant ID</label>
						<input name="live_key_1" type="text" class="form-control" id="live_key_1" placeholder="Please Enter Live Merchant ID" value="{{ $result->live_key_1}}">
						</div>
					</div>
					<div class="col-md-6 mb-3">
						<div class="form-group">
						<label for="live_key_2">Live Merchant Key</label>
						<input name="live_key_2" type="text" class="form-control" id="live_key_2" placeholder="Please Enter Live Merchant Key" value="{{ $result->live_key_2}}">
						</div>
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-6 mb-3">
						<div class="form-group">
						<label for="live_key_3">Live Merchant Salt Key</label>
						<input name="live_key_3" type="text" class="form-control" id="live_key_3" placeholder="Please Enter Live Merchant Salt Key" value="{{ $result->live_key_3}}">
						</div>
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-6 mb-3">
						<div class="form-group">
						<label for="test_key_1">Test Marchant ID</label>
						<input name="test_key_1" type="text" class="form-control" id="test_key_1" placeholder="Please Enter Test Marchant ID" value="{{ $result->test_key_1}}">
						</div>
					</div>
					<div class="col-md-6 mb-3">
						<div class="form-group">
						<label for="test_key_2">Test Marchant Key</label>
						<input name="test_key_2" type="text" class="form-control" id="test_key_2" placeholder="Please Enter Test Marchant Key" value="{{ $result->test_key_2}}">
						</div>
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-6 mb-3">
						<div class="form-group">
						<label for="test_key_3">Test Marchant Salt Key</label>
						<input name="test_key_3" type="text" class="form-control" id="test_key_3" placeholder="Please Enter Test Marchant Salt Key" value="{{ $result->test_key_3}}">
						</div>
					</div>
				</div>
			@endif
			<!-- PayTm -->
			@if($result->id == 6)
				<div class="form-row">
					<div class="col-md-6 mb-3">
						<div class="form-group">
						<label for="live_key_1">Live Merchant ID</label>
						<input name="live_key_1" type="text" class="form-control" id="live_key_1" placeholder="Please Enter Live Merchant ID" value="{{ $result->live_key_1}}">
						</div>
					</div>
					<div class="col-md-6 mb-3">
						<div class="form-group">
						<label for="live_key_2">Live Merchant Key</label>
						<input name="live_key_2" type="text" class="form-control" id="live_key_2" placeholder="Please Enter Live Merchant Key" value="{{ $result->live_key_2}}">
						</div>
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-6 mb-3">
						<div class="form-group">
						<label for="test_key_1">Test Merchant ID</label>
						<input name="test_key_1" type="text" class="form-control" id="test_key_1" placeholder="Please Enter Test Merchant ID" value="{{ $result->test_key_1}}">
						</div>
					</div>
					<div class="col-md-6 mb-3">
						<div class="form-group">
						<label for="test_key_2">Test Merchant Key</label>
						<input name="test_key_2" type="text" class="form-control" id="test_key_2" placeholder="Please Enter Test Merchant Key" value="{{ $result->test_key_2}}">
						</div>
					</div>
				</div>
			@endif
      		<div class="border-top mt-2 pt-3 text-right">
      			<input type="hidden" value="{{$result->id}}" name="id">
      			<button type="button" class="btn btn-default mw-120" onclick="edit_payment_option()">{{__('Label.UPDATE')}}</button>
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
		function edit_payment_option(){
			var formData = new FormData($("#edit_payment_option")[0]);
			$("#dvloader").show();
			$.ajax({
				type:'POST',
				url:'{{ route("PaymentUpdate") }}',
				data:formData,
				cache:false,
				contentType: false,
				processData: false,
				success:function(resp){
					$("#dvloader").hide();
					get_responce_message(resp, 'edit_payment_option', '{{ route("Payment") }}');
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					$("#dvloader").hide();
					toastr.error(errorThrown.msg,'failed');         
				}
			});
		}
	</script>
@endpush