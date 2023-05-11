@extends('admin.layouts.master')
@section('title', 'Episodes')
@section('content')
  
    <!-- Start: Body-Content -->
    <div class="body-content">
      <!-- mobile title -->
      <h1 class="page-title-sm">@yield('title')</h1>

      <div class="border-bottom row mb-3">
        <div class="col-sm-10">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{__('Label.Dashboard')}}</a></li>
            <li class="breadcrumb-item">
              <a href="{{ route('TVShow') }}">{{__('Label.TV Show')}}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
              Episode List        
            </li>
          </ol>
        </div>
        <div class="col-sm-2 d-flex align-items-center justify-content-end">
          <a href="{{ route('TVShow') }}" class="btn btn-default mw-150" style="margin-top: -14px;">{{__('Label.TV Show')}}</a>
        </div>
      </div>
      
      <div class="mb-1">
        <form class="form-inline" action="{{ route('TVShowVideoSerach', ['id' => $tvshowId]) }}" method="GET">
          <input type="hidden" name="show_id" id="show_id" value="{{$tvshowId}}">
          <div class="form-group col-xs-6 mr-3">
            <label>{{__('Label.Search :')}}</label>
          </div>
          <div class="form-group col-xs-6 mr-5">
            <select name="session" class="form-control col-sm-12">
              <option value="All"> {{__('Label.All Video')}} </option>
              @foreach ($session as $key => $value)
              <option value="{{$value->id}}" {{ $value->id == request()->get('session')  ? 'selected' : ''}}>  {{$value->name}} </option>
              @endforeach
            </select>
          </div>							
          <div class="form-group col-xs-6">
            <button class="btn btn-default" type="submit"> {{__('Label.SEARCH')}} </button>
          </div>
        </form>
      </div>

      <div class="row">
        <div class="col-12 col-sm-6 col-md-4 col-xl-3">
          <a href="{{ route('TVShowvideoAdd', ['id' => $tvshowId]) }}" class="add-video-btn">
            <img src="{{ asset('assets/imgs/add.png') }}" alt="" class="icon" />
            {{__('Label.Add new video')}}
          </a>
        </div>

        @foreach ($result as $key => $value)
        <div class="col-12 col-sm-6 col-md-4 col-xl-3">
          <div class="card video-card">
            <div class="position-relative">
              <img class="card-img-top" src="{{ Get_Image('show').'/'.$value->thumbnail }}" alt="">
              @if($value->video_upload_type == "server_video")
              <button class="btn play-btn video" data-toggle="modal" data-target="#videoModal"  data-video="{{Get_Image('video').'/'.$value->video_320}}" data-image="{{Get_Image('show').'/'.$value->landscape}}">
                <img src="{{ asset('assets/imgs/play.png') }}" alt="" />
              </button>
              @endif
            </div>
            <div class="card-body">
              <h5 class="card-title">{{$value->video_name}}</h5>
              <div class="dropdown dropright">
                <a href="#" class="btn head-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <img src="{{ asset('assets/imgs/dot.png') }}" class="dot-icon" />
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                  <!-- <a class="dropdown-item" href="#">
                    <img src="{{ asset('assets/imgs/view.png') }}" class="dot-icon" />
                    {{__('Label.Status')}}
                  </a> -->
                  <a class="dropdown-item" href="{{ route('editTVShow_video', ['show_id' => $value->show_id, 'id' => $value->id])}}">
                    <img src="{{ asset('assets/imgs/edit.png') }}" class="dot-icon" />
                    {{__('Label.Edit')}}
                  </a>
                  <a class="dropdown-item" href="{{ route('deleteTVShow_video', ['id' => $value->id])}}" onclick="return confirm('Are You Sure Delete This Video?')">
                    <img src="{{ asset('assets/imgs/trash.png') }}" class="dot-icon" />
                    {{__('Label.Delete')}}
                  </a>
                </div>
              </div>
              <div class="card-details">
                <p class="card-text">
                 {{$value->session_name}}
                </p>
                <!-- <p class="tag mt-3">
                  #tag
                </p> -->
              </div>
            </div>
          </div>
        </div>
        @endforeach

        <!-- Video Modal -->
        <div class="modal fade" id="videoModal" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
              <div class="modal-body p-0 bg-transparent">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close">
                  <span aria-hidden="true" class="text-dark">&times;</span>
                </button>
                <video controls width="800" height="500" preload='none' poster="" id="theVideo" controlsList="nodownload noplaybackrate" disablepictureinpicture>
                  <source src="" type="video/mp4">
                </video>
              </div>
            </div>
          </div>
        </div>
        <!-- End Video Modal -->
      </div>  

      <!-- Pagination -->
      <div class="d-flex justify-content-center">
        {{ $result->links() }}
      </div>
  
    </div>
    <!-- End: Body-Content -->
  </div>
  <!-- End: Right Contenct -->
@endsection

@push('scripts')
  <script>
    $(function() {
      $(".video").click(function () {
        var theModal = $(this).data("target"),
            videoSRC = $(this).attr("data-video"),
            videoPoster = $(this).attr("data-image"),
            videoSRCauto = videoSRC + "";

        $(theModal + ' source').attr('src', videoSRCauto);
        $(theModal + ' video').attr('poster', videoPoster);
        $(theModal + ' video').load();

        $(theModal + ' button.close').click(function () {
          $(theModal + ' source').attr('src', videoSRC);
        });
      });
    });

    $("#videoModal .close").click(function (){
      theVideo.pause()
    });

  </script>
@endpush