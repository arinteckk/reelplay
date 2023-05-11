@extends('admin.layouts.master')
@section('title', __('Label.Settings'))
@section('content')

<!-- Start: Body-Content -->
<div class="body-content">
    <!-- mobile title -->
    <h1 class="page-title-sm">@yield('title')</h1>

    <div class="border-bottom row mb-3">
        <div class="col-sm-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">
                        {{__('Label.Dashboard')}}
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="{{ route('setting') }}">
                        {{__('Label.Setting')}}
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{__('Label.SMTP Setting')}}
                </li>
            </ol>
        </div>
    </div>

    <div class="card custom-border-card mt-3">
        <h5 class="card-header">{{__('Label.Email Setting [SMTP]')}}</h5>
        <div class="card-body">
            <form id="smtp_setting">
                @csrf
                <div class="row col-lg-12">
                    <div class="form-group  col-lg-6">
                        <label for="status">{{__('Label.IS SMTP Active')}}</label>
                        <select name="status" class="form-control" id="status">
                            <option value="0" {{ $smtp->status == 0  ? 'selected' : ''}}>
                                {{__('Label.No')}}
                            </option>
                            <option value="1" {{ $smtp->status == 1  ? 'selected' : ''}}>
                                {{__('Label.Yes')}}
                            </option>
                        </select>
                    </div>
                    <div class="form-group col-lg-6">
                        <input type="hidden" name="smtp_id" value="1">
                        <label for="host">{{__('Label.Host')}}</label>
                        <input type="text" name="host" class="form-control" id="host" value="{{$smtp->host}}">
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="port">{{__('Label.Port')}}</label>
                        <input type="text" name="port" class="form-control" id="port" value="{{$smtp->port}}">
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="protocol">{{__('Label.Protocol')}}</label>
                        <input type="text" name="protocol" class="form-control" id="protocol"
                            placeholder="Enter Your protocol" value="{{$smtp->protocol}}">
                    </div>
                </div>
                <div class="row col-lg-12">
                    <div class="form-group col-lg-6">
                        <label for="user">{{__('Label.User name')}}</label>
                        <input type="text" name="user" class="form-control" id="user" value="{{$smtp->user}}">
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="pass">{{__('Label.Password')}}</label>
                        <input type="password" name="pass" class="form-control" id="pass" value="{{$smtp->pass}}">
                    </div>
                </div>
                <div class="row col-lg-12">
                    <div class="form-group col-lg-6">
                        <label for="from_name">{{__('Label.From name')}}</label>
                        <input type="text" name="from_name" class="form-control" id="from_name"
                            value="{{$smtp->from_name}}">
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="from_email">{{__('Label.From Email')}}</label>
                        <input type="text" name="from_email" class="form-control" id="from_email"
                            value="{{$smtp->from_email}}">
                    </div>
                </div>
                <div class="border-top pt-3 text-right">
                    <button type="button" class="btn btn-default mw-120"
                        onclick="smtp_setting()">{{__('Label.SAVE')}}</button>
                </div>
            </form>
        </div>
    </div>

</div>
<!-- End: Body-Content -->
</div>
<!-- End: Right Contenct -->
@endsection

@push('scripts')
    <script type="text/javascript">
        function smtp_setting() {
            var formData = new FormData($("#smtp_setting")[0]);
            $.ajax({
                type: 'POST',
                url: '{{ route("settingsmtp") }}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(resp) {
                    get_responce_message(resp, 'smtp_setting', '{{ route("setting") }}');
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    toastr.error(errorThrown.msg, 'failed');
                }
            });
        }
    </script>
@endpush