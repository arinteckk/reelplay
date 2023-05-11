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
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{__('Label.Dashboard')}}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{__('Label.Setting')}}
                </li>
            </ol>
        </div>
    </div>

    <ul class="nav nav-pills custom-tabs inline-tabs" id="pills-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="app-tab" data-toggle="tab" href="#app" role="tab" aria-controls="app"
                aria-selected="true">{{__('Label.APP SETTINGS')}}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="change-password-tab" data-toggle="tab" href="#change-password" role="tab"
                aria-controls="change-password" aria-selected="true">{{__('Label.CHANGE PASSWORD')}}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="admob-tab" data-toggle="tab" href="#admob" role="tab" aria-controls="admob"
                aria-selected="false">{{__('Label.ADMOB')}}</a>
        </li>
        <!-- <li class="nav-item">
            <a class="nav-link" id="facebook-ads-tab" data-toggle="tab" href="#facebook-ads" role="tab"
                aria-controls="facebook-ads" aria-selected="false">{{__('Label.FACEBOOK ADS')}}</a>
        </li> -->
    </ul>

    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="app" role="tabpanel" aria-labelledby="app-tab">
            <div class="app-right-btn">
                <a href="{{route('settingsmtpindex')}}" class="btn btn-default">{{__('Label.EMAIL SETTINGS [SMTP]')}}</a>
            </div>
            <div class="card custom-border-card">
                <h5 class="card-header">{{__('Label.App Configrations')}}</h5>
                <div class="card-body">
                    <div class="input-group">
                        <div class="col-2">
                            <label class="ml-5 pt-3" style="font-size:16px; font-weight:500; color:#1b1b1b">{{__('Label.API Path')}}</label>
                        </div>
                        <input type="text" readonly value="{{url('/')}}/api" name="api_path" class="form-control" style="background-color:matte gray;" id="api_path">
                        <div class="input-group-prepend">
                            <div class="input-group-text btn" style="background-color:matte gray;" onclick="Function_Api_path()">
                                <img src="{{ url('/') }}/assets/imgs/copy.png" alt=""/>
                            </div> 
                        </div>
                    </div> 
                </div>
            </div>
            <div class="card custom-border-card">
                <h5 class="card-header">{{__('Label.App Settings')}}</h5>
                <div class="card-body">
                    <form id="app_setting" enctype="multipart/form-data">
                        @csrf
                        <div class="row col-lg-12">
                            <div class="form-group col-lg-6">
                                <label for="app_name">{{__('Label.App Name')}}</label>
                                <input type="text" name="app_name" class="form-control" id="app_name"
                                    placeholder="Enter App Name" value="{{$result['app_name']}}">
                            </div>
                            <div class="form-group col-lg-6">
                                <label>{{__('Label.Host Email')}}</label>
                                <input type="email" name="host_email" class="form-control" id="host_email"
                                    value="{{$result['host_email']}}" placeholder="Enter Host Email">
                            </div>
                        </div>
                        <div class="row col-lg-12">
                            <div class="form-group col-lg-6">
                                <label>{{__('Label.App Version')}}</label>
                                <input type="text" name="app_version" class="form-control" id="app_version"
                                    value="{{$result['app_version']}}" placeholder="Enter App Version">
                            </div>
                            <div class="form-group col-lg-6">
                                <label>{{__('Label.Author')}}</label>
                                <input type="text" name="Author" class="form-control" id="Author"
                                    value="{{$result['Author']}}" placeholder="Enter Author">
                            </div>
                        </div>
                        <div class="row col-lg-12">
                            <div class="form-group col-lg-6">
                                <label>{{__('Label.Email')}} </label>
                                <input type="email" name="email" class="form-control" id="email"
                                    value="{{$result['email']}}" placeholder="Enter Email">
                            </div>
                            <div class="form-group  col-lg-6">
                                <label> {{__('Label.Contact')}} </label>
                                <input type="number" name="contact" class="form-control" id="contact"
                                    value="{{$result['contact']}}" placeholder="Enter Contact">
                            </div>
                        </div>
                        <div class="row col-lg-12">
                            <div class="form-group col-lg-12">
                                <label>{{__('Label.APP DESCRIPATION')}}</label>
                                <textarea name="app_desripation" class="form-control" id="app_desripation" rows="5"
                                    placeholder="Enter App Desripation">{{$result['app_desripation']}}</textarea>
                            </div>
                        </div>
                        <div class="row col-lg-12">
                            <div class="form-group col-lg-12">
                                <label>{{__('Label.PRIVACY POLICY')}}</label>
                                <textarea name="privacy_policy" class="form-control summernote" id="privacy_policy" rows="5"
                                    placeholder="Enter Privacy Policy">{{$result['privacy_policy']}}</textarea>
                            </div>
                        </div>
                        <div class="row col-lg-12">
                            <div class="form-group col-lg-12">
                                <label>{{__('Label.Instrucation')}}</label>
                                <textarea name="instrucation" class="form-control summernote" id="instrucation" rows="5"
                                    placeholder="Enter Instrucation">{{$result['instrucation']}}</textarea>
                            </div>
                        </div>
                        <div class="row col-lg-12">
                            <div class="form-group col-lg-6">
                                <label for="app_logo">{{__('Label.APP IMAGE')}}</label>
                                <input type="file" name="app_logo" class="form-control" id="app_logo"
                                    placeholder="Enter Your App Name" value="{{$result['app_logo']}}">
                                <label class="mt-1 text-gray">{{__('Label.Note_Image')}}</label>
                            </div>
                            <div class="form-group col-lg-6">
                                <label>{{__('Label.WEBSITE')}}</label>
                                <input type="text" name="website" class="form-control" id="website"
                                    value="{{$result['website']}}">
                            </div>
                        </div>
                        <div class="col-md-6 mb-5">
                            <div class="form-group">
                                <div class="custom-file ml-5">
                                    <?php 
                                        if($result['app_logo']){
                                            $app = Get_Image('app').$result['app_logo'];
                                        } else {
                                            $app = asset('assets/imgs/1.png');
                                        }
                                    ?>
                                    <img src="{{$app}}" height="120px" width="120px" class="mb-5 img-thumbnail"
                                        id="preview-image-before-upload">
                                    <input type="hidden" name="old_app_logo" value="{{$result['app_logo']}}">
                                </div>
                            </div>
                        </div>
                        <div class="border-top pt-3 text-right">
                            <button type="button" class="btn btn-default mw-120" id="Save_app" onclick="app_setting()">{{__('Label.SAVE')}}</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card custom-border-card">
                <h5 class="card-header">{{__('Label.Currency Settings')}}</h5>
                <div class="card-body">
                    <form id="save_currency">
                        @csrf
                        <div class="row col-lg-12">
                            <div class="form-group col-lg-6">
                                <label>{{__('Label.Currency Name')}} </label>
                                <input type="text" name="currency" class="form-control" value="{{$result['currency']}}" placeholder="Enter Currency Name">
                            </div>
                            <div class="form-group col-lg-6">
                                <label> {{__('Label.Currency Code')}} </label>
                                <input type="text" name="currency_code" class="form-control"
                                    value="{{$result['currency_code']}}" placeholder="Enter Currency Code">
                            </div>
                        </div>
                        <div class="border-top pt-3 text-right">
                            <button type="button" class="btn btn-default mw-120"
                                onclick="save_currency()">{{__('Label.SAVE')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="change-password" role="tabpanel" aria-labelledby="change-password-tab">
            <div class="card custom-border-card">
                <h5 class="card-header">{{__('Label.Change Password')}}</h5>
                <div class="card-body">
                    <div class="">
                        <div class="form-group">
                            <form id="change_password">
                                @csrf
                                <input type="hidden" name="admin_id" value="1">
                                <div class="row">
                                    <div class="form-group col-lg-12">
                                        <label for="password">{{__('Label.New Password')}}</label>
                                        <input type="password" name="password" class="form-control" id="password"
                                            placeholder="Enter New Password">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-12">
                                        <label for="confirm_password">{{__('Label.Confirm Password')}}</label>
                                        <input type="password" name="confirm_password" class="form-control"
                                            id="confirm_password" placeholder="Enter Confirm Password">
                                    </div>
                                </div>
                                <div class="border-top pt-3 text-right">
                                    <button type="button" class="btn btn-default mw-120"
                                        onclick="change_password()">{{__('Label.SAVE')}}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="admob" role="tabpanel" aria-labelledby="admob-tab">
            <div class="card custom-border-card mt-3">
                <h5 class="card-header">{{__('Label.Android Settings')}}</h5>
                <div class="card-body">
                    <form id="admob_android">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="form-group">
                                    <label for="banner_ad">{{__('Label.Banner Ad')}}</label>
                                    <div class="radio-group">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="banner_ad" name="banner_ad"
                                                class="custom-control-input"
                                                {{ ($result['banner_ad']=='1')? "checked" : "" }} value="1">
                                            <label class="custom-control-label"
                                                for="banner_ad">{{__('Label.Yes')}}</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="banner_ad1" name="banner_ad"
                                                class="custom-control-input"
                                                {{ ($result['banner_ad']=='0')? "checked" : "" }} value="0">
                                            <label class="custom-control-label"
                                                for="banner_ad1">{{__('Label.No')}}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="form-group">
                                    <label for="interstital_ad">{{__('Label.Interstital Ad')}}</label>
                                    <div class="radio-group">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="interstital_ad" name="interstital_ad"
                                                class="custom-control-input"
                                                {{ ($result['interstital_ad']=='1')? "checked" : "" }} value="1">
                                            <label class="custom-control-label"
                                                for="interstital_ad">{{__('Label.Yes')}}</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="interstital_ad1" name="interstital_ad"
                                                class="custom-control-input"
                                                {{ ($result['interstital_ad']=='0')? "checked" : "" }} value="0">
                                            <label class="custom-control-label"
                                                for="interstital_ad1">{{__('Label.No')}}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="form-group">
                                    <label for="reward_ad">Reward Ad</label>
                                    <div class="radio-group">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="reward_ad" name="reward_ad"
                                                class="custom-control-input"
                                                {{ ($result['reward_ad']=='1')? "checked" : "" }} value="1">
                                            <label class="custom-control-label"
                                                for="reward_ad">{{__('Label.Yes')}}</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="reward_ad1" name="reward_ad"
                                                class="custom-control-input"
                                                {{ ($result['reward_ad']=='0')? "checked" : "" }} value="0">
                                            <label class="custom-control-label"
                                                for="reward_ad1">{{__('Label.No')}}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="form-group">
                                    <label for="banner_adid">{{__('Label.Banner Ad ID')}}</label>
                                    <input type="text" name="banner_adid" class="form-control" id="banner_adid"
                                        placeholder="Enter Banner Ad ID" value="{{$result['banner_adid']}}">
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="form-group">
                                    <label for="interstital_adid">{{__('Label.Interstital Ad ID')}}</label>
                                    <input type="text" name="interstital_adid" class="form-control"
                                        id="interstital_adid" placeholder="Enter interstital Ad ID"
                                        value="{{$result['interstital_adid']}}">
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="form-group">
                                    <label for="reward_adid">Reward Ad ID</label>
                                    <input type="text" name="reward_adid" class="form-control" id="reward_adid"
                                        placeholder="Enter Reward Ad ID" value="{{$result['reward_adid']}}">
                                </div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="form-group">
                                    <label></label>
                                    &nbsp;
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="form-group">
                                    <label for="interstital_adclick">{{__('Label.Interstital Ad Click')}}</label>
                                    <input type="text" name="interstital_adclick" class="form-control"
                                        id="interstital_adclick" placeholder="Enter Interstital Ad Click"
                                        value="{{$result['interstital_adclick']}}">
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="form-group">
                                    <label for="reward_adclick">{{__('Label.Reward Ad Click')}}</label>
                                    <input type="text" name="reward_adclick" class="form-control"
                                        placeholder="Enter Reward Ad Click" value="{{$result['reward_adclick']}}">
                                </div>
                            </div>
                        </div>
                        <div class="border-top pt-3 text-right">
                            <button type="button" class="btn btn-default mw-120"
                                onclick="admob_android()">{{__('Label.SAVE')}}</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card custom-border-card mt-3">
                <h5 class="card-header">{{__('Label.IOS Settings')}}</h5>
                <div class="card-body">
                    <form id="admob_ios">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="form-group">
                                    <label for="ios_banner_ad">{{__('Label.Banner Ad')}}</label>
                                    <div class="radio-group">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="ios_banner_ad" name="ios_banner_ad"
                                                class="custom-control-input"
                                                {{ ($result['ios_banner_ad']=='1')? "checked" : "" }} value="1">
                                            <label class="custom-control-label"
                                                for="ios_banner_ad">{{__('Label.Yes')}}</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="ios_banner_ad1" name="ios_banner_ad"
                                                class="custom-control-input"
                                                {{ ($result['ios_banner_ad']=='0')? "checked" : "" }} value="0">
                                            <label class="custom-control-label"
                                                for="ios_banner_ad1">{{__('Label.No')}}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="form-group">
                                    <label for="ios_interstital_ad">{{__('Label.Interstital Ad')}}</label>
                                    <div class="radio-group">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="ios_interstital_ad" name="ios_interstital_ad"
                                                class="custom-control-input"
                                                {{ ($result['ios_interstital_ad']=='1')? "checked" : "" }} value="1">
                                            <label class="custom-control-label"
                                                for="ios_interstital_ad">{{__('Label.Yes')}}</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="ios_interstital_ad1" name="ios_interstital_ad"
                                                class="custom-control-input"
                                                {{ ($result['ios_interstital_ad']=='0')? "checked" : "" }} value="0">
                                            <label class="custom-control-label"
                                                for="ios_interstital_ad1">{{__('Label.No')}}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="form-group">
                                    <label for="ios_reward_ad">Reward Ad</label>
                                    <div class="radio-group">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="ios_reward_ad" name="ios_reward_ad"
                                                class="custom-control-input"
                                                {{ ($result['ios_reward_ad']=='1')? "checked" : "" }} value="1">
                                            <label class="custom-control-label"
                                                for="ios_reward_ad">{{__('Label.Yes')}}</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="ios_reward_ad1" name="ios_reward_ad"
                                                class="custom-control-input"
                                                {{ ($result['ios_reward_ad']=='0')? "checked" : "" }} value="0">
                                            <label class="custom-control-label"
                                                for="ios_reward_ad1">{{__('Label.No')}}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="form-group">
                                    <label for="ios_banner_adid">{{__('Label.Banner Ad ID')}}</label>
                                    <input type="text" name="ios_banner_adid" class="form-control" id="ios_banner_adid"
                                        placeholder="Enter Banner Ad ID" value="{{$result['ios_banner_adid']}}">
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="form-group">
                                    <label for="ios_interstital_adid">{{__('Label.Interstital Ad ID')}}</label>
                                    <input type="text" name="ios_interstital_adid" class="form-control"
                                        id="ios_interstital_adid" placeholder="Enter interstital Ad ID"
                                        value="{{$result['ios_interstital_adid']}}">
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="form-group">
                                    <label for="ios_reward_adid">Reward Ad ID</label>
                                    <input type="text" name="ios_reward_adid" class="form-control" id="ios_reward_adid"
                                        placeholder="Enter Reward Ad ID" value="{{$result['ios_reward_adid']}}">
                                </div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="form-group">
                                    <label></label>
                                    &nbsp;
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="form-group">
                                    <label for="ios_interstital_adclick">Interstital Ad Click</label>
                                    <input type="text" name="ios_interstital_adclick" class="form-control"
                                        id="ios_interstital_adclick" placeholder="Enter Interstital Ad Click"
                                        value="{{$result['ios_interstital_adclick']}}">
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="form-group">
                                    <label for="ios_reward_adclick">Reward Ad Click</label>
                                    <input type="text" name="ios_reward_adclick" class="form-control"
                                        placeholder="Enter Reward Ad Click" value="{{$result['ios_reward_adclick']}}">
                                </div>
                            </div>
                        </div>
                        <div class="border-top pt-3 text-right">
                            <button type="button" class="btn btn-default mw-120"
                                onclick="admob_ios()">{{__('Label.SAVE')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- <div class="tab-pane fade" id="facebook-ads" role="tabpanel" aria-labelledby="facebook-ads-tab">
            <div class="card custom-border-card mt-3">
                <h5 class="card-header">{{__('Label.Android Settings')}}</h5>
                <div class="card-body">
                    <form id="fbad">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="form-group">
                                    <label for="fb_native_status">{{__('Label.Native Status')}}</label>
                                    <div class="radio-group">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="fb_native_status" name="fb_native_status"
                                                class="custom-control-input"
                                                {{ ($result['fb_native_status']=='1')? "checked" : "" }} value="1">
                                            <label class="custom-control-label"
                                                for="fb_native_status">{{__('Label.Yes')}}</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="fb_native_status1" name="fb_native_status"
                                                class="custom-control-input"
                                                {{ ($result['fb_native_status']=='0')? "checked" : "" }} value="0">
                                            <label class="custom-control-label"
                                                for="fb_native_status1">{{__('Label.No')}}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="form-group">
                                    <label for="fb_banner_status">{{__('Label.Banner Status')}}</label>
                                    <div class="radio-group">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="fb_banner_status" name="fb_banner_status"
                                                class="custom-control-input"
                                                {{($result['fb_banner_status']=='1')? "checked" : "" }} value="1">
                                            <label class="custom-control-label"
                                                for="fb_banner_status">{{__('Label.Yes')}}</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="fb_banner_status1" name="fb_banner_status"
                                                class="custom-control-input"
                                                {{ ($result['fb_banner_status']=='0')? "checked" : "" }} value="0">
                                            <label class="custom-control-label"
                                                for="fb_banner_status1">{{__('Label.No')}}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="form-group">
                                    <label for="fb_interstiatial_status">{{__('Label.Interstiatial Status')}}</label>
                                    <div class="radio-group">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="fb_interstiatial_status"
                                                name="fb_interstiatial_status" class="custom-control-input"
                                                {{($result['fb_interstiatial_status']=='1')? "checked" : "" }}
                                                value="1">
                                            <label class="custom-control-label"
                                                for="fb_interstiatial_status">{{__('Label.Yes')}}</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="fb_interstiatial_status1"
                                                name="fb_interstiatial_status" class="custom-control-input"
                                                {{ ($result['fb_interstiatial_status']=='0')? "checked" : "" }}
                                                value="0">
                                            <label class="custom-control-label"
                                                for="fb_interstiatial_status1">{{__('Label.No')}}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="form-group">
                                    <label for="fb_native_id">{{__('Label.Native Key')}}</label>
                                    <input type="text" name="fb_native_id" class="form-control" id="fb_native_id"
                                        value="{{$result['fb_native_id']}}" placeholder="Enter Native Key">
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="form-group">
                                    <label for="fb_banner_id">{{__('Label.Banner Key')}}</label>
                                    <input type="text" name="fb_banner_id" class="form-control" id="fb_banner_id"
                                        value="{{$result['fb_banner_id']}}" placeholder="Enter Banner key">
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="form-group">
                                    <label for="fb_interstiatial_id">{{__('Label.Interstiatial Key')}}</label>
                                    <input type="text" name="fb_interstiatial_id" class="form-control"
                                        id="fb_interstiatial_id" value="{{$result['fb_interstiatial_id']}}"
                                        placeholder="Enter Interstiatial Key">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="form-group col-lg-6">
                                    <label for="fb_rewardvideo_status">{{__('Label.RewardVideo Status')}}</label>
                                    <div class="radio-group">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="fb_rewardvideo_status" name="fb_rewardvideo_status"
                                                class="custom-control-input"
                                                {{($result['fb_rewardvideo_status']=='1')? "checked" : "" }}
                                                value="1">
                                            <label class="custom-control-label"
                                                for="fb_rewardvideo_status">{{__('Label.Yes')}}</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="fb_rewardvideo_status1" name="fb_rewardvideo_status"
                                                class="custom-control-input"
                                                {{ ($result['fb_rewardvideo_status']=='0')? "checked" : "" }}
                                                value="0">
                                            <label class="custom-control-label"
                                                for="fb_rewardvideo_status1">{{__('Label.No')}}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="form-group col-lg-6">
                                    <label for="fb_native_full_status">{{__('Label.Native Full Status')}}</label>
                                    <div class="radio-group">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="fb_native_full_status" name="fb_native_full_status"
                                                class="custom-control-input"
                                                {{($result['fb_native_full_status']=='1')? "checked" : "" }}
                                                value="1">
                                            <label class="custom-control-label"
                                                for="fb_native_full_status">{{__('Label.Yes')}}</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="fb_native_full_status1" name="fb_native_full_status"
                                                class="custom-control-input"
                                                {{ ($result['fb_native_full_status']=='0')? "checked" : "" }}
                                                value="0">
                                            <label class="custom-control-label"
                                                for="fb_native_full_status1">{{__('Label.No')}}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="form-group">
                                    <label for="fb_rewardvideo_id">{{__('Label.Rewardvideo Status Key')}}</label>
                                    <input type="text" name="fb_rewardvideo_id" class="form-control"
                                        id="fb_rewardvideo_id" value="{{$result['fb_rewardvideo_id']}}"
                                        placeholder="Enter Reward Video Status Key">
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="form-group">
                                    <label for="fb_native_full_id">{{__('Label.Native Full Key')}}</label>
                                    <input type="text" name="fb_native_full_id" class="form-control"
                                        id="fb_native_full_id" value="{{$result['fb_native_full_id']}}"
                                        placeholder="Enter Native Full Key">
                                </div>
                            </div>
                        </div>
                        <div class="border-top pt-3 text-right">
                            <button type="button" class="btn btn-default mw-120"
                                onclick="fbad()">{{__('Label.SAVE')}}</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card custom-border-card mt-3">
                <h5 class="card-header">{{__('Label.IOS Settings')}}</h5>
                <div class="card-body">
                    <form id="fbad_ios">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="form-group">
                                    <label for="fb_ios_native_status">{{__('Label.Native Status')}}</label>
                                    <div class="radio-group">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="fb_ios_native_status" name="fb_ios_native_status"
                                                class="custom-control-input"
                                                {{ ($result['fb_ios_native_status']=='1')? "checked" : "" }}
                                                value="1">
                                            <label class="custom-control-label"
                                                for="fb_ios_native_status">{{__('Label.Yes')}}</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="fb_ios_native_status1" name="fb_ios_native_status"
                                                class="custom-control-input"
                                                {{ ($result['fb_ios_native_status']=='0')? "checked" : "" }}
                                                value="0">
                                            <label class="custom-control-label"
                                                for="fb_ios_native_status1">{{__('Label.No')}}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="form-group">
                                    <label for="fb_ios_banner_status">{{__('Label.Banner Status')}}</label>
                                    <div class="radio-group">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="fb_ios_banner_status" name="fb_ios_banner_status"
                                                class="custom-control-input"
                                                {{($result['fb_ios_banner_status']=='1')? "checked" : "" }} value="1">
                                            <label class="custom-control-label"
                                                for="fb_ios_banner_status">{{__('Label.Yes')}}</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="fb_ios_banner_status1" name="fb_ios_banner_status"
                                                class="custom-control-input"
                                                {{ ($result['fb_ios_banner_status']=='0')? "checked" : "" }}
                                                value="0">
                                            <label class="custom-control-label"
                                                for="fb_ios_banner_status1">{{__('Label.No')}}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="form-group">
                                    <label
                                        for="fb_ios_interstiatial_status">{{__('Label.Interstiatial Status')}}</label>
                                    <div class="radio-group">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="fb_ios_interstiatial_status"
                                                name="fb_ios_interstiatial_status" class="custom-control-input"
                                                {{($result['fb_ios_interstiatial_status']=='1')? "checked" : "" }}
                                                value="1">
                                            <label class="custom-control-label"
                                                for="fb_ios_interstiatial_status">{{__('Label.Yes')}}</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="fb_ios_interstiatial_status1"
                                                name="fb_ios_interstiatial_status" class="custom-control-input"
                                                {{ ($result['fb_ios_interstiatial_status']=='0')? "checked" : "" }}
                                                value="0">
                                            <label class="custom-control-label"
                                                for="fb_ios_interstiatial_status1">{{__('Label.No')}}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="form-group">
                                    <label for="fb_ios_native_id">{{__('Label.Native Key')}}</label>
                                    <input type="text" name="fb_ios_native_id" class="form-control"
                                        id="fb_ios_native_id" value="{{$result['fb_ios_native_id']}}"
                                        placeholder="Enter Native Key">
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="form-group">
                                    <label for="fb_ios_banner_id">{{__('Label.Banner Key')}}</label>
                                    <input type="text" name="fb_ios_banner_id" class="form-control"
                                        id="fb_ios_banner_id" value="{{$result['fb_ios_banner_id']}}"
                                        placeholder="Enter Banner Key">
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="form-group">
                                    <label for="fb_ios_interstiatial_id">{{__('Label.Interstiatial Key')}}</label>
                                    <input type="text" name="fb_ios_interstiatial_id" class="form-control"
                                        id="fb_ios_interstiatial_id" value="{{$result['fb_ios_interstiatial_id']}}"
                                        placeholder="Enter Interstiatial Key">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="form-group col-lg-6">
                                    <label for="fb_ios_rewardvideo_status">{{__('Label.RewardVideo Status')}}</label>
                                    <div class="radio-group">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="fb_ios_rewardvideo_status"
                                                name="fb_ios_rewardvideo_status" class="custom-control-input"
                                                {{($result['fb_ios_rewardvideo_status']=='1')? "checked" : "" }}
                                                value="1">
                                            <label class="custom-control-label"
                                                for="fb_ios_rewardvideo_status">{{__('Label.Yes')}}</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="fb_ios_rewardvideo_status1"
                                                name="fb_ios_rewardvideo_status" class="custom-control-input"
                                                {{ ($result['fb_ios_rewardvideo_status']=='0')? "checked" : "" }}
                                                value="0">
                                            <label class="custom-control-label"
                                                for="fb_ios_rewardvideo_status1">{{__('Label.No')}}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="form-group col-lg-6">
                                    <label for="fb_ios_native_full_status">{{__('Label.Native Full Status')}}</label>
                                    <div class="radio-group">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="fb_ios_native_full_status"
                                                name="fb_ios_native_full_status" class="custom-control-input"
                                                {{($result['fb_ios_native_full_status']=='1')? "checked" : "" }}
                                                value="1">
                                            <label class="custom-control-label"
                                                for="fb_ios_native_full_status">{{__('Label.Yes')}}</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="fb_ios_native_full_status1"
                                                name="fb_ios_native_full_status" class="custom-control-input"
                                                {{ ($result['fb_ios_native_full_status']=='0')? "checked" : "" }}
                                                value="0">
                                            <label class="custom-control-label"
                                                for="fb_ios_native_full_status1">{{__('Label.No')}}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="form-group">
                                    <label for="fb_ios_rewardvideo_id">{{__('Label.Rewardvideo Status Key')}}</label>
                                    <input type="text" name="fb_ios_rewardvideo_id" class="form-control"
                                        id="fb_ios_rewardvideo_id" value="{{$result['fb_ios_rewardvideo_id']}}"
                                        placeholder="Enter Reward Video Status Key">
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="form-group">
                                    <label for="fb_ios_native_full_id">{{__('Label.Native Full Key')}}</label>
                                    <input type="text" name="fb_ios_native_full_id" class="form-control"
                                        id="fb_ios_native_full_id" value="{{$result['fb_ios_native_full_id']}}"
                                        placeholder="Enter native Full Key">
                                </div>
                            </div>
                        </div>
                        <div class="border-top pt-3 text-right">
                            <button type="button" class="btn btn-default mw-120"
                                onclick="fbad_ios()">{{__('Label.SAVE')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div> -->
    </div>
            
</div>
<!-- End: Body-Content -->
</div>
<!-- End: Right Contenct -->
@endsection

@push('scripts')
    <script>

        function app_setting() {
            
            var formData = new FormData($("#app_setting")[0]);
            $("#dvloader").hide();
            $.ajax({
                type: 'POST',
                url: '{{ route("settingapp") }}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(resp) {
                    $("#dvloader").hide();
                    $("html, body").animate({ scrollTop: 0 }, "swing");
                    get_responce_message(resp);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    $("#dvloader").hide();
                    toastr.error(errorThrown.msg, 'failed');
                }
            });
        }

        $(document).ready(function(e) {
            $('#app_logo').change(function() {
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#preview-image-before-upload').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });
        });

        function change_password() {
            var formData = new FormData($("#change_password")[0]);
            $("#dvloader").show();
            $.ajax({
                type: 'POST',
                url: '{{ route("settingchangepassword") }}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(resp) {
                    $("#dvloader").hide();
                    $("html, body").animate({ scrollTop: 0 }, "swing");
                    get_responce_message(resp, 'change_password');
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    $("#dvloader").hide();
                    toastr.error(errorThrown.msg, 'failed');
                }
            });
        }

        function save_currency() {
            $("#dvloader").show();
            var formData = new FormData($("#save_currency")[0]);
            $("#dvloader").show();
            $.ajax({
                type: 'POST',
                url: '{{ route("settingcurrency") }}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(resp) {
                    $("#dvloader").hide();
                    $("html, body").animate({ scrollTop: 0 }, "swing");
                    get_responce_message(resp);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    $("#dvloader").hide();
                    toastr.error(errorThrown.msg, 'failed');
                }
            });
        }

        function admob_android() {
            var formData = new FormData($("#admob_android")[0]);
            $("#dvloader").show();
            $.ajax({
                type: 'POST',
                url: '{{ route("settingadmob_android") }}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(resp) {
                    $("#dvloader").hide();
                    $("html, body").animate({ scrollTop: 0 }, "swing");
                    get_responce_message(resp);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    $("#dvloader").hide();
                    toastr.error(errorThrown.msg, 'failed');
                }
            });
        }

        function admob_ios() {
            var formData = new FormData($("#admob_ios")[0]);
            $("#dvloader").show();
            $.ajax({
                type: 'POST',
                url: '{{ route("settingadmob_ios") }}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(resp) {
                    $("#dvloader").hide();
                    $("html, body").animate({ scrollTop: 0 }, "swing");
                    get_responce_message(resp);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    $("#dvloader").hide();
                    toastr.error(errorThrown.msg, 'failed');
                }
            });
        }

        function fbad() {
            var formData = new FormData($("#fbad")[0]);
            $("#dvloader").show();
            $.ajax({
                type: 'POST',
                url: '{{ route("settingfacebookad") }}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(resp) {
                    $("#dvloader").hide();
                    $("html, body").animate({ scrollTop: 0 }, "swing");
                    get_responce_message(resp);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    $("#dvloader").hide();
                    toastr.error(errorThrown.msg, 'failed');
                }
            });
        }

        function fbad_ios() {
            var formData = new FormData($("#fbad_ios")[0]);
            $("#dvloader").show();
            $.ajax({
                type: 'POST',
                url: '{{ route("settingfacebookad_ios") }}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(resp) {
                    $("#dvloader").hide();
                    $("html, body").animate({ scrollTop: 0 }, "swing");
                    get_responce_message(resp);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    $("#dvloader").hide();
                    toastr.error(errorThrown.msg, 'failed');
                }
            });
        }
        
        function Function_Api_path() {
            /* Get the text field */
            var copyText = document.getElementById("api_path");

            /* Select the text field */
            copyText.select();
            copyText.setSelectionRange(0, 99999); /* For mobile devices */

            document.execCommand('copy');
            
            /* Alert the copied text */
            alert("Copied the API Path: " + copyText.value);
        }
    </script>
@endpush