@extends('admin.layouts.master')
@section('title', __('Label.Video'))
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
          {{__('Label.Videos')}}
        </li>
      </ol>
    </div>
  </div>

  <!-- Serach Dropdown -->
  <div class="border-bottom mb-3 pb-3">
    <form class="" action="{{ route('video')}}" method="GET">
      <div class="form-row">
        <div class="col-md-1 d-flex align-items-center">
          <label for="type">{{__('Label.SEARCH')}} :</label>
        </div>
        <div class="col-md-2">
          <div class="form-group">
            <select class="form-control" id="type" name="type">
              <option value="all">{{__('Label.All')}}</option>
              @for ($i = 0; $i < count($type); $i++) <option value="{{ $type[$i]['id'] }}" @if(isset($_GET['type'])){{ $_GET['type'] == $type[$i]['id'] ? 'selected' : ''}} @endif> {{ $type[$i]['name'] }} </option>
                @endfor
            </select>
          </div>
        </div>
        <div class="col-sm-2 ml-4">
          <button class="btn btn-default" type="submit"> {{__('Label.SEARCH')}} </button>
        </div>
      </div>
    </form>
  </div>

  <div class="row">
    <div class="col-12 col-sm-6 col-md-4 col-xl-3">
      <a href="{{ route('videoAdd') }}" class="add-video-btn">
        <img src="{{ asset('assets/imgs/add.png') }}" alt="" class="icon" />
        {{__('Label.Add new video')}}
      </a>
    </div>

    @foreach ($result as $key => $value)
    <div class="col-12 col-sm-6 col-md-4 col-xl-3">
      <div class="card video-card">
        <div class="position-relative">
          <img class="card-img-top" src="{{ Get_Image('video').'/'.$value->thumbnail}}" alt="">

          @if($value->video_upload_type == "server_video")
          <button class="btn play-btn video" data-toggle="modal" data-target="#videoModal" data-video="{{ Get_Image('video').'/'.$value->video_320}}" data-image="{{ Get_Image('video').'/'.$value->landscape}}">
            <img src="{{ asset('assets/imgs/play.png') }}" alt="" />
          </button>
          @endif

        </div>
        <div class="card-body">
          <h5 class="card-title mr-5">{{$value->name}}</h5>
          <div class="dropdown dropright">
            <a href="#" class="btn head-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <img src="{{ asset('assets/imgs/dot.png') }}" class="dot-icon" />
            </a>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
              <a class="dropdown-item" href="{{ route('videoDetail', ['id' => $value->id])}}">
                <img src="{{ asset('assets/imgs/view.png') }}" class="dot-icon" />
                {{__('Label.Details')}}
              </a>
              <a class="dropdown-item" href="{{ route('editVideo', ['id' => $value->id])}}">
                <img src="{{ asset('assets/imgs/edit.png') }}" class="dot-icon" />
                {{__('Label.Edit')}}
              </a>
              <a class="dropdown-item" href="{{ route('deleteVideo', ['id' => $value->id])}}" onclick="return confirm('Are You Sure Delete This Video?')">
                <img src="{{ asset('assets/imgs/trash.png') }}" class="dot-icon" />
                {{__('Label.Delete')}}
              </a>
            </div>
          </div>
          <div class="card-details">
            <p class="card-text">
              <?php
              if (isset($value->type->name)) {
                echo $value->type->name;
              } else {
                echo '';
              }
              ?>
            </p>
          </div>
        </div>
      </div>
    </div>
    @endforeach

    <div class="modal fade" id="videoModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-body p-0 bg-transparent">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true" class="text-dark">&times;</span>
            </button>
            <video controls width="800" height="500" preload='none' poster="" id="theVideo" controlsList="nodownload noplaybackrate" disablepictureinpicture>
              <source src="" type="video/mp4">
            </video>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Pagination -->
  <div class="d-flex justify-content-between align-items-center">
    <div> Showing {{ $result->firstItem() }} to {{ $result->lastItem() }} of total {{$result->total()}} entries </div>
    <div class="pb-5"> {{ $result->links() }} </div>
  </div>
</div>
<!-- End: Body-Content -->
</div>
<!-- End: Right Contenct -->
@endsection

@push('scripts')
<script>
  $(function() {
    $(".video").click(function() {
      var theModal = $(this).data("target"),
        videoSRC = $(this).attr("data-video"),
        videoPoster = $(this).attr("data-image"),
        videoSRCauto = videoSRC + "";

      $(theModal + ' source').attr('src', videoSRCauto);
      $(theModal + ' video').attr('poster', videoPoster);
      $(theModal + ' video').load();
      $(theModal + ' button.close').click(function() {
        $(theModal + ' source').attr('src', videoSRC);
      });
    });
  });

  $("#videoModal .close").click(function() {
    theVideo.pause()
  });
</script>
@endpush