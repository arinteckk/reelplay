<!--Start: Right Contenct -->
  <div class="right-content">
    <!-- Start: Page-Header  -->
    <header class="header">
      <div class="title-control">
        <button class="btn side-toggle">
          <span></span>
          <span></span>
          <span></span>
        </button>
        <a href="#">
          <img src="{{asset('assets/imgs/dtlive.png')}}" alt="" class="side-logo" />
        </a>
        <h1 class="page-title">@yield('title')</h1>
      </div>
      <div class="head-control">

        <a href="{{ route('setting') }}" class="btn head-btn  d-none d-md-flex">
          <img src="{{ asset('assets/imgs/setting-colored.png') }}" />
        </a>
        
        <div class="dropdown dropright">
          <a href="#" class="btn head-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img src="{{ asset('assets/imgs/Profile.png') }}" class="avatar-img" />
          </a>
          <div class="dropdown-menu p-2 mt-2" aria-labelledby="dropdownMenuLink">
            <a class="dropdown-item" href="#">
                <?php $data = adminEmail(); echo $data->user_name; ?>
                <br>
                <?php echo $data->email; ?>
            </a>
            <a class="dropdown-item" href="{{ route('adminLogout')}}" style="color:#4E45B8;"><span><img src="{{ asset('assets/imgs/Logout-sm.png') }}" class="mr-2"></span>{{__('Label.Logout')}}</a>
          </div>
        </div>
      </div>
    </header>
    <!-- End: Page-Header -->
