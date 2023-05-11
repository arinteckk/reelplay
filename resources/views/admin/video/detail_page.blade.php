@extends('admin.layouts.master')
@section('title', 'video Details')
@section('content')

<!-- Start: Body-Content -->
<div class="body-content">
    <!-- mobile title -->
    <h1 class="page-title-sm">@yield('title')</h1>

    <div class="border-bottom row mb-3">
        <div class="col-sm-10">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{__('Label.Dashboard')}}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('video') }}">Video</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    Details
                </li>
            </ol>
        </div>
        <div class="col-sm-2 d-flex align-items-center justify-content-end">
            <a href="{{ route('video') }}" class="btn btn-default mw-150" style="margin-top: -14px;">Video List</a>
        </div>
    </div>

    <div class="card custom-border-card">
        <table class="table table-striped table-hover table-bordered w-75 text-center" style="margin-left:auto; margin-right:auto">
            <thead>
                <tr class="table-info">
                    <th colspan="2"> Video Details </th>
                </tr>
            </thead>
            <tbody >
                <tr>
                    <td>Name</td>
                    <td>{{$tvshow->name}}</td>
                </tr>
                <tr>
                    <td>Channel</td>
                    <td>{{ isset($channel->name) ? $channel->name : "-" }}</td>
                </tr>
                <tr>
                    <td>Category</td>
                    <td>
                        @foreach ($category as $key => $value)
                        {{ $value->name .","}}
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td>Language</td>
                    <td>
                        @foreach ($language as $key => $value)
                        {{ $value->name .","}}
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td>Cast</td>
                    <td>
                        @foreach ($cast as $key => $value)
                        {{ $value->name ." ("}}{{$value->type ."),"}}
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td>Image (Thumbnail)</td>
                    <td>
                        <?php
                            if($tvshow->thumbnail){
                                $app = Get_Image('video',$tvshow->thumbnail);
                            } else{
                                $app = asset('assets/imgs/1.png');
                            }
                        ?>
                        <img src="{{$app}}" height="60px" width="60px" class="img-thumbnail">
                    </td>
                </tr>
                <tr>
                    <td>Image (Landscape)</td>
                    <td>
                        <?php
                            if($tvshow->landscape){
                                $app = Get_Image('video',$tvshow->landscape);
                            } else{
                                $app = asset('assets/imgs/1.png');
                            }
                        ?>
                        <img src="{{$app}}" height="60px" width="60px" class="img-thumbnail">
                    </td>
                </tr>
                <tr>
                    <td>View</td>
                    <td>{{$tvshow->view}}</td>
                </tr>
                <tr>
                    <td>Downloads</td>
                    <td>
                        @if($tvshow->download == 0)
                            No
                        @else 
                            Yes
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td>
                        @if($tvshow->description)
                            {{$tvshow->description}}                            
                        @else 
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Is Title</td>
                    <td>
                        @if($tvshow->is_title == 0)
                            No
                        @else 
                            Yes
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Video Type</td>
                    <td>
                        @if($tvshow->video_type == 1)
                            Video
                        @elseif($tvshow->video_type == 2)
                            Show
                        @elseif($tvshow->video_type == 3)
                            Language
                        @elseif($tvshow->video_type == 4)
                            Category
                        @elseif($tvshow->video_type == 5)
                            Session
                        @endif
                    </td>
                    
                </tr>
                <tr>
                    <td>Is Premium</td>
                    <td>
                        @if($tvshow->is_premium == 0)
                            No
                        @else 
                            Yes
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Trailer URl</td>
                    <td>
                        @if($tvshow->trailer_url)
                            {{$tvshow->trailer_url}}
                        @else 
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Release Year</td>
                    <td>
                        @if($tvshow->release_year)
                            {{$tvshow->release_year}}
                        @else 
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Age Restriction</td>
                    <td>
                        @if($tvshow->age_restriction)
                            {{$tvshow->age_restriction}}
                        @else 
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Max Video Quality</td>
                    <td>
                        @if($tvshow->max_video_quality)
                            {{$tvshow->max_video_quality}}
                        @else 
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Release Tag</td>
                    <td>
                        @if($tvshow->release_tag)
                            {{$tvshow->release_tag}}
                        @else 
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Video Upload Type</td>
                    <td>
                        @if($tvshow->video_upload_type)
                            {{$tvshow->video_upload_type}}
                        @else 
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Video URL (320 px)</td>
                    <td>
                        @if($tvshow->video_upload_type == "server_video" && $tvshow->video_320 != null)
                            {{ Get_Image('video', $tvshow->video_320)}}
                        @elseif($tvshow->video_320 != null)
                            {{$tvshow->video_320}} 
                        @else
                            -                           
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Video URL (480 px)</td>
                    <td>
                        @if($tvshow->video_upload_type == "server_video" && $tvshow->video_480 != null)
                            {{ Get_Image('video', $tvshow->video_480)}}
                        @elseif ($tvshow->video_480 != null)
                            {{$tvshow->video_480}}
                        @else
                            -                   
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Video URL (720 px)</td>
                    <td>
                        @if($tvshow->video_upload_type == "server_video" && $tvshow->video_720 != null)
                            {{ Get_Image('video', $tvshow->video_720)}}
                        @elseif ($tvshow->video_720 != null)
                            {{$tvshow->video_480}}         
                        @else 
                            -                   
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Video URL (1080 px)</td>
                    <td>
                        @if($tvshow->video_upload_type == "server_video" && $tvshow->video_1080 != null)
                            {{ Get_Image('video', $tvshow->video_1080)}}
                        @elseif($tvshow->video_1080 != null)
                            {{$tvshow->video_1080}}
                        @else 
                            -                          
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Subtitle</td>
                    <td>
                        @if($tvshow->subtitle_type == "server_file" && $tvshow->subtitle != null)
                            {{ Get_Image('video', $tvshow->subtitle)}}
                        @elseif($tvshow->subtitle != null)
                            {{$tvshow->subtitle}}
                        @else
                            -                    
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Video Extension</td>
                    <td>
                        @if($tvshow->video_extension)
                            {{$tvshow->video_extension}}
                        @else 
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Video Duration</td>
                    <td>
                        @if($tvshow->video_duration)
                            {{MillisecondsToTime($tvshow->video_duration)}}
                        @else 
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Video Size</td>
                    <td>
                        @if($tvshow->video_size)
                            {{$tvshow->video_size}}
                        @else 
                            -
                        @endif
                    </td>
                </tr>

                <tr class="table-info">
                    <th colspan="2"> IMDB Details </th>
                </tr>
                
                <tr>
                    <td>Director Id</td>
                    <td>
                        @if($tvshow->director_id)
                            {{$tvshow->director_id}}
                        @else 
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Starring Id</td>
                    <td>
                        @if($tvshow->starring_id)
                            {{$tvshow->starring_id}}
                        @else 
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Supporting Cast Id</td>
                    <td>
                        @if($tvshow->supporting_cast_id)
                            {{$tvshow->supporting_cast_id}}
                        @else 
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Networks</td>
                    <td>
                        @if($tvshow->networks)
                            {{$tvshow->networks}}
                        @else 
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Maturity Rating</td>
                    <td>
                        @if($tvshow->maturity_rating)
                            {{$tvshow->maturity_rating}}
                        @else 
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Studios</td>
                    <td>
                        @if($tvshow->studios)
                            {{$tvshow->studios}}
                        @else 
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Content Advisory</td>
                    <td>
                        @if($tvshow->content_advisory)
                            {{$tvshow->content_advisory}}
                        @else 
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Viewing Rights</td>
                    <td>
                        @if($tvshow->viewing_rights)
                            {{$tvshow->viewing_rights}}
                        @else 
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>IMDB Rating</td>
                    <td>
                        @if($tvshow->imdb_rating)
                            {{$tvshow->imdb_rating}}
                        @else 
                            0
                        @endif
                    </td>
                </tr>            
            </tbody>
        </table>
    </div>
       
</div>
<!-- End: Body-Content -->
</div>
<!-- End: Right Contenct -->
@endsection