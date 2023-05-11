@extends('admin.layouts.master')
@section('title', 'Add Coupon')
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
                    <a href="{{ route('coupon') }}">Coupon</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                   Add Coupon
                </li>
            </ol>
        </div>
        <div class="col-sm-2 d-flex align-items-center justify-content-end">
            <a href="{{ route('coupon') }}" class="btn btn-default mw-120" style="margin-top:-14px">Coupon</a>
        </div>
    </div>

    <div class="card custom-border-card mt-3">
        <form id="save_random_coupon" autocomplete="off">
            @csrf
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label>{{__('Label.total_number_coupon')}}</label>
                        <input name="total_number" type="number" class="form-control" placeholder="Please Enter Number">
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label>{{__('Label.is_use')}}</label>
                        <select class="form-control" name="is_use">
                        <option value="0">{{__('Label.All')}}</option>
                        <option value="1">{{__('Label.One')}}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label>{{__('Label.start_date')}}</label>
                        <input name="start_date" type="date" class="form-control">
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label>{{__('Label.end_date')}}</label>
                        <input name="end_date" type="date" class="form-control">
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label>{{__('Label.amount_type')}}</label>
                        <select class="form-control" name="amount_type">
                        <option value="1">{{__('Label.Price')}}</option>
                        <option value="2">{{__('Label.Percentage')}}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label>{{__('Label.Price')}}</label>
                        <input name="price" type="number" class="form-control" placeholder="Please Enter Price">
                    </div>
                </div>
            </div>
            <div class="border-top mt-2 pt-3 text-right">
                <button type="button" class="btn btn-default mw-120" onclick="save_random_coupon()">{{__('Label.SAVE')}}</button>
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

        function save_random_coupon() {

            var formData = new FormData($("#save_random_coupon")[0]);
            $("#dvloader").show();
            $.ajax({
                type: 'POST',
                url: '{{ route("couponRandomSave") }}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(resp) {
                    $("#dvloader").hide();
                    get_responce_message(resp, 'save_random_coupon', '{{ route("coupon") }}');
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    $("#dvloader").hide();
                    toastr.error(errorThrown.msg, 'failed');
                }
            });
        }
	</script>
@endpush