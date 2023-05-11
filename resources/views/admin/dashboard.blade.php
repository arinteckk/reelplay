@extends('admin.layouts.master')
@section('title', __('Label.Dashboard'))
@section('content')

    <!-- Start: Body-Content -->
    <div class="body-content">
      <!-- mobile title -->
      <h1 class="page-title-sm">@yield('title')</h1>

      <div class="row counter-row">
        <div class="col-6 col-sm-4 col-md col-lg-4 col-xl">
          <div class="db-color-card user-card">
            <img src="{{ asset('assets/imgs/user-brown.png') }}" alt="" class="card-icon" />
            <div class="dropdown dropright">
              <a href="#" class="btn head-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img src="{{ asset('assets/imgs/dot.png') }}" class="dot-icon" />
              </a>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                <a class="dropdown-item" href="{{ route('user') }}" style="color: #A98471;">{{__('Label.View All')}}</a>
              </div>
            </div>
            <h2 class="counter">
              {{$result['user'] ?: 00}}
              <span>{{__('Label.Users')}}</span>
            </h2>
          </div>
        </div>
        <div class="col-6 col-sm-4 col-md col-lg-4 col-xl">
          <div class="db-color-card artist-card">
            <img src="{{ asset('assets/imgs/channel-blue.png') }}" alt="" class="card-icon" style="color:#6db3c6;" />
            <div class="dropdown dropright">
              <a href="#" class="btn head-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img src="{{ asset('assets/imgs/dot.png') }}" class="dot-icon" />
              </a>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                <a class="dropdown-item" href="{{ route('channel') }}" style="color: #6DB3C6">{{__('Label.View All')}}</a>
              </div>
            </div>
            <h2 class="counter">
              {{$result['channel'] ?: 00}}
              <span>{{__('Label.Channel')}}</span>
            </h2>
          </div>
        </div>
        <div class="col-6 col-sm-4 col-md col-lg-4 col-xl">
          <div class="db-color-card">
            <img src="{{ asset('assets/imgs/video-green.png') }}" alt="" class="card-icon" />
            <div class="dropdown dropright">
              <a href="#" class="btn head-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img src="{{ asset('assets/imgs/dot.png') }}" class="dot-icon" />
              </a>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                <a class="dropdown-item" href="{{ route('video') }}" style="color: #6cb373;">{{__('Label.View All')}}</a>
              </div>
            </div>
            <h2 class="counter">
              {{ $result['video'] ?: 00 }}
              <span>{{__('Label.Videos')}}</span>
            </h2>
          </div>
        </div>
        <div class="col-6 col-sm-4 col-md col-lg-4 col-xl">
          <div class="db-color-card cate-card">
            <img src="{{ asset('assets/imgs/TVShow-color.png') }}" alt="" class="card-icon" />
            <div class="dropdown dropright">
              <a href="#" class="btn head-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img src="{{ asset('assets/imgs/dot.png') }}" class="dot-icon" />
              </a>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                <a class="dropdown-item" href="{{ route('TVShow') }}" style="color: #736AA6">{{__('Label.View All')}}</a>
              </div>
            </div>
            <h2 class="counter">
              {{$result['TvShow'] ?: 00}}
              <span>{{__('Label.TV Shows')}}</span>
            </h2>
          </div>
        </div>
        <div class="col-6 col-sm-4 col-md col-lg-4 col-xl">
          <div class="db-color-card package-card">
            <img src="{{ asset('assets/imgs/cast-pink.png') }}" alt="" class="card-icon" />
            <div class="dropdown dropright">
              <a href="#" class="btn head-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img src="{{ asset('assets/imgs/dot.png') }}" class="dot-icon" />
              </a>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                <a class="dropdown-item" href="{{ route('cast') }}" style="color: #C0698B">{{__('Label.View All')}}</a>
              </div>
            </div>
            <h2 class="counter">
            {{$result['cast'] ?: 00}}
              <span>{{__('Label.Cast')}}</span>
            </h2>
          </div>
        </div>
      </div>

      <div class="row counter-row">
        <div class="col-6 col-sm-4 col-md col-lg-4 col-xl">
          <div class="db-color-card category-card">
            <img src="{{ asset('assets/imgs/Rent_Earnings.png') }}" alt="" class="card-icon" />
            <h2 class="counter {{ strlen((string)no_format($result['RentTransction'])) <= 2 ? 'pt-4' : ''}}">
              {{currency_code()}}{{no_format($result['RentTransction']) ?: 00 }}
              <span> Rent Earnings </span>
            </h2>
          </div>
        </div>
        <div class="col-6 col-sm-4 col-md col-lg-4 col-xl">
          <div class="db-color-card rent_video-card">
            <img src="{{ asset('assets/imgs/rent_video_color.png') }}" alt="" class="card-icon" style="color:#6db3c6;" />
            <div class="dropdown dropright">
              <a href="#" class="btn head-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img src="{{ asset('assets/imgs/dot.png') }}" class="dot-icon" />
              </a>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                <a class="dropdown-item" href="{{ route('RentVideo') }}" style="color: #692705">{{__('Label.View All')}}</a>
              </div>
            </div>
            <h2 class="counter pt-4">
              {{$result['RentVideo'] ?: 00}}
              <span> Rent Videos </span>
            </h2>
          </div>
        </div>
        <div class="col-6 col-sm-4 col-md col-lg-4 col-xl">
          <div class="db-color-card plan-card">
            <img src="{{ asset('assets/imgs/plan_color.png') }}" alt="" class="card-icon" />
            <div class="dropdown dropright">
              <a href="#" class="btn head-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img src="{{ asset('assets/imgs/dot.png') }}" class="dot-icon" />
              </a>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                <a class="dropdown-item" href="{{ route('package') }}" style="color: #201f1e">{{__('Label.View All')}}</a>
              </div>
            </div>
            <h2 class="counter pt-4">
              {{$result['Package'] ?: 00}}
              <span>Subscription Plan</span>
            </h2>
          </div>
        </div>
        <div class="col-6 col-sm-4 col-md col-lg-4 col-xl">
          <div class="db-color-card subscribers-card">
            <img src="{{ asset('assets/imgs/plan_earnings.png') }}" alt="" class="card-icon" />
            <div class="dropdown dropright">
            </div>
            <h2 class="counter ">
              <!-- {{ "$".$result['Transction'] ?: 00}} -->
              {{currency_code()}}{{no_format($result['Transction']) ?: 00}}
              <span> Package Earnings </span>
            </h2>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-12 col-xl-8">

          <div class="box-title">
            <h2 class="title">Recently Added Users</h2>
            <a href="{{ route('user') }}" class="btn btn-link">{{__('Label.View All')}}</a>
          </div>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>
                    {{__('Label.Full Name')}}
                  </th>
                  <th>
                    {{__('Label.Email')}}
                  </th>
                  <th>
                    {{__('Label.Number')}}
                  </th>
                  <th>
                    {{__('Label.Type')}}
                  </th>
                  <th>
                    {{__('Label.Created Date')}}
                  </th>
                </tr>
              </thead>
              <tbody>
                @if(isset($user_data))
                @foreach ($user_data as $value)
                  <tr>
                    <td>
                      <span class="avatar-control">
                        <?php 
                          if($value->image){
                            $app = Get_Image('user') . $value->image; 
                          } else {
                            $app = URL::asset('/assets/imgs/1.png'); 
                          }
                        ?>
                        <img src="{{ $app }}" class="avatar-img">
                        @if($value->name)
                          {{$value->name}}
                        @else
                          -
                        @endif
                      </span>
                    </td>
                    <td>
                      @if($value->email)
                        {{$value->email}}
                      @else($value->email == 'null')
                        -
                      @endif
                    </td>
                    <td>
                      @if($value->mobile)
                        {{$value->mobile}}
                      @else($value->mobile == 'null')
                        -
                      @endif
                    </td>
                    <td>
                      @if ($value->type == 1)
                        FaceBook
                      @elseif($value->type == 2)
                        Google
                      @elseif($value->type == 3)
                        OTP
                      @elseif($value->type == 4)
                        Normal
                      @else 
                        -
                      @endif
                    </td>
                    <td>{{ date("d-m-Y", strtotime($value->created_at));}}</td>
                  </tr>
                @endforeach
                @endif
              </tbody>
            </table>
          </div>

          <div class="box-title">
            <h2 class="title">Recently Added TVShow</h2>
            <a href="{{ route('TVShow')}}" class="btn btn-link">{{__('Label.View All')}}</a>
          </div>
          <div class="row artist-row">
            @if(isset($tvshow) && $tvshow != null)
              @foreach ($tvshow as $value)
                <div class="col-6 col-md-3">
                  <div class="artist-grid-card">
                    <span class="avatar-control">
                      @if($value->landscape != "")
                      <img src="{{ Get_Image('show').$value->landscape }}" class="img-thumbnail" style="height: 100px; width: 100%;" />
                      @else 
                      <img src="{{asset('/assets/imgs/no_img.png')}}" class="img-thumbnail" style="height: 180px; width: 100%;"/>
                      @endif
                    </span>
                    <h3 class="name" style="display: inline-block; text-overflow:ellipsis; white-space:nowrap; overflow:hidden; width:100%;">{{ $value->name ?: ""}}</h3>
                    <p class="post mb-1"><b>Views :</b> {{$value->view}}</p>
                    <p class="details">{{ $value->description}}</p>
                  </div>
                </div>
              @endforeach
            @endif
          </div>

          <div class="box-title">
            <h2 class="title">Recently Added Rent Videos</h2>
            <a href="{{ route('RentVideo')}}" class="btn btn-link">{{__('Label.View All')}}</a>
          </div>
          <div class="row artist-row">
            @if(isset($rent_video) && $rent_video != null)
              @foreach ($rent_video as $value)
                @if($value->video_type == 1)
                  <div class="col-6 col-md-3">
                    <div class="artist-grid-card">
                      <span class="avatar-control">
                      @if($value->video->landscape != "")
                      <img src="{{ Get_Image('video').$value->video->landscape }}" class="img-thumbnail" style="height: 100px; width: 100%;" />
                      @else 
                      <img src="{{asset('/assets/imgs/no_img.png')}}" class="img-thumbnail" style="height: 180px; width: 100%;"/>
                      @endif
                      </span>
                      <h3 class="name" style="display: inline-block; text-overflow:ellipsis; white-space:nowrap; overflow:hidden; width:100%;">{{ $value->video->name ?: ""}}</h3>
                      <p class="post"><b>Price :</b> &#x20B9; {{$value->price}}</p>
                    </div>
                  </div>
                @elseif ($value->video_type == 2)
                  <div class="col-6 col-md-3">
                    <div class="artist-grid-card">
                      <span class="avatar-control">
                        <img src="{{ Get_Image('show').$value->tvshow->landscape }}" class="img-thumbnail" style="height: 100px; width: 100%;"/>
                      </span>
                      <h3 class="name" style="display: inline-block; text-overflow:ellipsis; white-space:nowrap; overflow:hidden; width:100%;">{{ $value->tvshow->name ?: ""}}</h3>
                      <p class="post"><b>Price :</b> &#x20B9; {{$value->price}}</p>
                    </div>
                  </div>
                @endif
              @endforeach
            @endif
          </div>

          <div class="box-title">
            <h2 class="title">Recently Added Artist</h2>
            <a href="{{ route('cast')}}" class="btn btn-link">{{__('Label.View All')}}</a>
          </div>
          <div class="row artist-row">
            @if(isset($cast) && $cast != null)
              @foreach ($cast as $value)
                <div class="col-6 col-md-3">
                  <div class="artist-grid-card">
                    <span class="avatar-control">
                      @if($value->image != "")
                      <img src="{{ Get_Image('cast').$value->image }}" class="img-thumbnail" style="height: 180px; width: 100%;"/>
                      @else 
                      <img src="{{asset('/assets/imgs/no_img.png')}}" class="img-thumbnail" style="height: 180px; width: 100%;"/>
                      @endif
                    </span>
                    <h3 class="name" style="display: inline-block; text-overflow:ellipsis; white-space:nowrap; overflow:hidden; width:100%;">{{ $value->name ?: ""}}</h3>
                    <p class="post mb-1">{{$value->type}}</p>
                    <p class="details">{{ $value->personal_info}}</p>
                  </div>
                </div>
              @endforeach
            @endif
          </div>

        </div>   

        <div class="col-12 col-xl-4">
          <div class="video-box">

          <div class="box-title mt-0">
            <h2 class="title">Most Viewed Video</h2>
          </div>
          @if(isset($most_view_video) && $most_view_video != null)
          <div class="p-3 bg-white mt-4">
            @if($most_view_video->landscape != "")
            <img src="{{ Get_Image('video').$most_view_video->landscape }}" class="img-fluid d-block mx-auto img-thumbnail" style="height: 300px; width: 100%;"/>
            @else 
            <img src="{{asset('/assets/imgs/no_img.png')}}" class="img-thumbnail" style="height: 180px; width: 100%;"/>
            @endif
            <div class="box-title box-border-0">
              <h5 class="f600" style="display: inline-block; text-overflow:ellipsis; white-space:nowrap; overflow:hidden; width:75%;">{{ $most_view_video->name}}</h5>
              <div class="d-flex justify-content-between">
                <i data-feather="eye" style="color:#4e45b8" class="mr-3"></i> {{$most_view_video->view}}
              </div>
            </div>
            <div class="details">
              <span>{{ string_cut($most_view_video->description,110) }}</span>
            </div>
          </div>
          @endif

          <div class="box-title">
            <h2 class="title">Recently Added Videos</h2>
            <a href="{{ route('video')}}" class="btn btn-link">{{__('Label.View All')}}</a>
          </div>
          <div class="row">
          @if(isset($recent_video) && $recent_video != null)
            @foreach ($recent_video as $value)
            <div class="col-sm-6 col-xl-12">
              <div class="media suggested-video">
                @if($value->thumbnail != "")
                <img class="mr-3 poster-img" src="{{ Get_Image('video').$value->thumbnail }}" alt="">
                @else 
                <img src="{{asset('/assets/imgs/no_img.png')}}" class="img-thumbnail" style="height: 180px; width: 100%;"/>
                @endif
                <div class="media-body">
                  <h5 class="mt-0 video-title">{{ $value->name }}</h5>
                  <div class="details">
                    <span>{{ $value->description}}</span>
                  </div>
                </div>
              </div>
            </div>
            @endforeach
          @endif
          </div>

          </div>
        </div>
      </div>                    

    </div>
    <!-- End: Body-Content -->
  </div>
  <!-- End: Right Contenct -->
@endsection