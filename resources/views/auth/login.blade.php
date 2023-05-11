<!DOCTYPE html>
<html lang="en">

  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{env('APP_NAME')}}</title>

    <!-- Start: Css -->
    <link rel="stylesheet" href="{{asset('/assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('/assets/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{asset('/assets/css/toastr.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('/assets/css/style.css') }}" rel="stylesheet">
    <!-- End: Css -->
  </head>

  <body>

    <div class="h-100">
      <div class="h-100 no-gutters row">
        <div class="d-none d-lg-block h-100 col-lg-5 col-xl-4">
            <div class="left-caption">
                <img src="{{asset('assets/imgs/login.jpg')}}" class="bg-img" />
                <div class="caption">
                    <div>
                        <!-- logo -->
                        @if(setting_app_name() == "")
                          <img src="{{asset('assets/imgs/dtlive-white.png')}}" alt="" class="img-fluid" width="50%"/>
                        @else
                          <h1>{{setting_app_name()}}</h1>
                        @endif   
                        <p class="text">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Iusto quaerat fuga optio voluptatibus ullam
                            aliquam consectetur, quam, veritatis facilis dolor id perspiciatis distinctio ratione! Reprehenderit
                            rerum
                            provident vero praesentium molestiae?
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="h-100 d-flex login-bg justify-content-center align-items-lg-center col-md-12 col-lg-7 col-xl-8">
            <div class="mx-auto col-sm-12 col-md-10 col-xl-8">
                <div class="py-5 p-3">

                    <!-- logo -->
                    <div class="app-logo mb-4">
                        <a href="#" class="mb-4 d-block d-lg-none">
                            <img src="{{asset('assets/imgs/dtlive.png')}}" alt="" class="img-fluid" />
                        </a>
                        <h3 class="primary-color mb-0 font-weight-bold">Login</h3>
                    </div>
                    <!-- end logo -->

                    <h4 class="mb-0 font-weight-bold">
                        <span class="d-block mb-2">Welcome back,</span>
                        <span>Please sign in to your account.</span>
                    </h4>
                    <!-- <h6 class="mt-3 border-bottom pb-3">No account? <a href="javascript:void(0);" class="text-primary">Sign up
                        now</a></h6>
                    <div> -->
                    <form  id="save_login">
                        @csrf
                        <div class="form-row mt-4">
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <label for="exampleEmail" class="">Email</label>
                                    <input name="email" id="email" placeholder="Email here..." type="email" class="form-control @error('email') is-invalid @enderror" value="admin@admin.com" required autocomplete="email" autofocus>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <label for="examplePassword" class="">Password</label>
                                    <input name="password" id="password" placeholder="Password here..." type="password" class="form-control @error('password') is-invalid @enderror" value="admin" required autocomplete="current-password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="custom-control custom-checkbox mr-sm-2">
                            <input type="checkbox" class="custom-control-input" id="customControlAutosizing" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="custom-control-label" for="customControlAutosizing">Keep me logged in</label>
                        </div>

                        <div class="form-row mt-4">
                            <div class="col-sm-6 text-center text-sm-left">
                                <button class="btn btn-default my-3 mw-120" onclick="save_login()" type="button">Login</button>
                            </div>
                              <!--<div class="col-sm-6 d-flex align-items-center justify-content-center justify-content-sm-end">
                                <a href="javascript:void(0);" class="btn-lg btn btn-link">Recover Password</a>
                              </div>-->
                        </div>

                        <!--  <div class="row mb-0">
                          <div class="col-md-8 offset-md-4">
                              <button type="submit" class="btn btn-primary">
                                  {{ __('Login') }}
                              </button>

                              @if (Route::has('password.request'))
                              <a class="btn btn-link" href="{{ route('password.request') }}">
                                  {{ __('Forgot Your Password?') }}
                              </a>
                              @endif
                          </div>
                        </div>-->
                    </form>
                </div>
            </div>
        </div>
      </div>
    </div>
    <!-- End: Content -->

    <!-- Start: Javascript -->
      <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
      <script src="{{ asset('assets/js/popper.min.js') }}"></script>
      <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
      <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
      <script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>
      <script src="{{ asset('https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js') }}"></script>
      <script src="{{ asset('assets/js/js.js') }}"></script>
      <script src="{{ asset('/assets/js/toastr.min.js')}}"></script>
      <script>
        // Login Form
        function save_login() {
          var formData = new FormData($("#save_login")[0]);
          $("#dvloader").show();
          $.ajax({
            type: 'POST',
            url: '{{ route("adminLoginPost") }}',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success:function(resp){
              $("#dvloader").hide();
              get_responce_message(resp, 'save_login', '{{ route("dashboard") }}');
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
              $("#dvloader").hide();
              toastr.error(errorThrown.msg,'failed');         
            }
          });
        }
        // Toastr
        function get_responce_message(resp, form_name, url) {
          if (resp.status == '200') {
            toastr.success(resp.success);
            document.getElementById(form_name).reset();
            setTimeout(function () {
              window.location.replace(url);
            }, 500);
          } else {
            var obj = resp.errors;
            if (typeof obj === 'string') {
              toastr.error(obj);
            } else {
              $.each(obj, function (i, e) {
                toastr.error(e);
              });
            }
          }
        }
        $(document).ready(function() {
          @if (Session::has('error'))
          toastr.error('{{ Session::get('error') }}');
          @elseif(Session::has('success'))
          toastr.success('{{ Session::get('success') }}');
          @endif
        });
      </script>
    <!-- End: javascript -->
    
  </body>
</html>
