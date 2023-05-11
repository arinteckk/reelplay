@extends('admin.layouts.master')
@section('title', __('Label.TV Show Detail'))
@section('content')

<!-- Start: Body-Content -->
<div class="body-content">
    <!-- mobile title -->
    <h1 class="page-title-sm">@yield('title')</h1>

    <div class="border-bottom row mb-3">
        <div class="col-sm-10">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{__('Label.Dashboard')}}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('TVShow') }}">{{__('Label.TV Show')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{__('Label.Details')}}
                </li>
            </ol>
        </div>
        <div class="col-sm-2 d-flex align-items-center justify-content-end">
            <a href="{{ route('TVShow') }}" class="btn btn-default mw-150" style="margin-top: -14px;">{{__('Label.TV Show')}}</a>
        </div>
    </div>

    <div class="card custom-border-card">
        <table class="table table-striped table-hover table-bordered w-75 text-center" style="margin-left:auto; margin-right:auto">
            <thead>
                <tr class="table-info">
                    <th colspan="2">{{__('Label.TV Show Details')}}</th>
                </tr>
            </thead>
            <tbody >
                <tr>
                    <td>{{__('Label.Channel')}}</td>
                    <td>{{ isset($channel->name) ? $channel->name : "-" }}</td>
                </tr>
                <tr>
                    <td>{{__('Label.Name')}}</td>
                    <td>{{$tvshow->name}}</td>
                </tr>
                <tr>
                    <td>{{__('Label.Category')}}</td>
                    <td>
                        @foreach ($category as $key => $value)
                        {{ $value->name .","}}
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td>{{__('Label.Language')}}</td>
                    <td>
                        @foreach ($language as $key => $value)
                        {{ $value->name .","}}
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td>{{__('Label.Cast')}}</td>
                    <td>
                        @foreach ($cast as $key => $value)
                        {{ $value->name ." ("}}{{$value->type ."),"}}
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td>{{__('Label.Image (Thumbnail)')}}</td>
                    <td>
                        <?php
                            if($tvshow->thumbnail){
                                $app = Get_Image('show',$tvshow->thumbnail);
                            } else{
                                $app = asset('assets/imgs/1.png');
                            }
                        ?>
                        <img src="{{$app}}" height="60px" width="60px" class="img-thumbnail">
                    </td>
                </tr>
                <tr>
                    <td>{{__('Label.Image (Landscape)')}}</td>
                    <td>
                        <?php
                            if($tvshow->landscape){
                                $app = Get_Image('show',$tvshow->landscape);
                            } else{
                                $app = asset('assets/imgs/1.png');
                            }
                        ?>
                        <img src="{{$app}}" height="60px" width="60px" class="img-thumbnail">
                    </td>
                </tr>
                <tr>
                    <td>{{__('Label.View')}}</td>
                    <td>{{$tvshow->view}}</td>
                </tr>
                <tr>
                    <td>{{__('Label.Description')}}</td>
                    <td>
                        @if($tvshow->description)
                            {{$tvshow->description}}                            
                        @else 
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>{{__('Label.Is Title')}}</td>
                    <td>
                        @if($tvshow->is_title == 0)
                            No
                        @else 
                            Yes
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>{{__('Label.Video Type')}}</td>
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
                    <td>{{__('Label.Is Premium')}}</td>
                    <td>
                        @if($tvshow->is_premium == 0)
                            No
                        @else 
                            Yes
                        @endif
                    </td>
                </tr>

                <tr class="table-info">
                    <th colspan="2">{{__('Label.IMDB Details')}}</th>
                </tr>
                
                <tr>
                    <td>{{__('Label.Director Id')}}</td>
                    <td>
                        @if($tvshow->director_id)
                            {{$tvshow->director_id}}
                        @else 
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <td> {{__('Starring Id')}} </td>
                    <td>
                        @if($tvshow->starring_id)
                            {{$tvshow->starring_id}}
                        @else 
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>{{__('Label.Supporting Cast Id')}}</td>
                    <td>
                        @if($tvshow->supporting_cast_id)
                            {{$tvshow->supporting_cast_id}}
                        @else 
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>{{__('Label.Networks')}}</td>
                    <td>
                        @if($tvshow->networks)
                            {{$tvshow->networks}}
                        @else 
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>{{__('Label.Maturity Rating')}}</td>
                    <td>
                        @if($tvshow->maturity_rating)
                            {{$tvshow->maturity_rating}}
                        @else 
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>{{__('Label.Studios')}}</td>
                    <td>
                        @if($tvshow->studios)
                            {{$tvshow->studios}}
                        @else 
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>{{__('Label.Content Advisory')}}</td>
                    <td>
                        @if($tvshow->content_advisory)
                            {{$tvshow->content_advisory}}
                        @else 
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>{{__('Label.Viewing Rights')}}</td>
                    <td>
                        @if($tvshow->viewing_rights)
                            {{$tvshow->viewing_rights}}
                        @else 
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>{{__('Label.IMDB Rating')}}</td>
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