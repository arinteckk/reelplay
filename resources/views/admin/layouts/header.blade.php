<!DOCTYPE html>
<html dir="{{(App::isLocale('ar') ? 'rtl' : 'ltr')}}">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        
        <title>{{env('APP_NAME')}}</title>
        
        <!-- Start: Css -->
        <link rel="stylesheet" href="{{asset('/assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{asset('/assets/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
        <link href="{{asset('/assets/css/toastr.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('/assets/css/style.css') }}" rel="stylesheet">
        <!-- Select2 -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"/>
        <!-- End: Css -->
        
        <input type="hidden" value="{{URL('')}}" id="base_url">

        <!-- Custom CSS -->
        <style>
            #dvloader {
                width: 100%;
                height: 100%;
                top: 0;
                left: 0;
                position: fixed;
                display: block;
                opacity: 0.7;
                background-color: #fff;
                z-index: 9999;
                text-align: center;
            }
            #dvloader image {
                position: absolute;
                top: 100px;
                left: 240px;
                z-index: 100;
            }
            .db-color-card.subscribers-card {
                background: #c9b7f1;
                color: #530899;
            }

            .db-color-card.rent_video-card {
                background: #dfab91;
                color: #692705;
            }
            .db-color-card.plan-card {
                background: #999898;
                color: #201f1e;
            }
            .db-color-card.category-card {
                background: #e9aaf1;
                color: #9d0bb1;    
            }
        </style>
    </head>
<body>