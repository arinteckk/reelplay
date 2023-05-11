@extends('admin.layouts.master')
@section('title', 'Banner')
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
              Banner
            </li>
          </ol>
        </div>
      </div>

      <ul class="tabs nav nav-pills custom-tabs inline-tabs" id="pills-tab" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" id="app-tab" onclick="Selected_Type('{{$type[0]['id']}}','{{$type[0]['type']}}','1')" data-is_home_screen="1" href="#app" role="tab" data-toggle="tab" aria-controls="app" aria-selected="true">Home</a>
        </li>
        @for ($i = 0; $i < count($type); $i++)
        <li class="nav-item">
          <a class="nav-link" id="{{ $type[$i]['name']}}-tab" onclick="Selected_Type('{{$type[$i]['id']}}','{{$type[$i]['type']}}','2')" data-is_home_screen="2" data-id="{{$type[$i]['id']}}" data-type="{{$type[$i]['type']}}" data-toggle="tab" href="#{{ $type[$i]['name']}}" role="tab" aria-controls="{{ $type[$i]['name']}}" aria-selected="true">{{ $type[$i]['name']}}</a>
        </li>
        @endfor
      </ul>
      

      <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="app" role="tabpanel" aria-labelledby="app-tab">
            <div class="card custom-border-card">
                <h5 class="card-header">Add Banner </h5>
                <div class="card-body">
                    <form id="save_banner" name="banner">
                      @csrf
                      
                      <div class="form-row radio-row">
                        <div class="col-md-6 d-flex justify-content-start">
                          @for ($i = 0; $i < count($type); $i++)
                            <div class="form-check form-check-inline mr-3">
                              <input class="form-check-input radio" type="radio" onclick="Selected_Type('{{$type[$i]['id']}}','{{$type[$i]['type']}}','2')" name="type_id" data-type="{{ $type[$i]['type']}}" data-name="{{$type[$i]['name']}}" id="Video_Selecte{{$i}}" value="{{ $type[$i]['id']}}" {{ $i == 0  ? 'checked' : ''}}>
                              <label class="form-check-label font-weight-bold h6" for="inlineRadio{{$i}}">{{ $type[$i]['name']}}</label>
                            </div>
                          @endfor
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="col-md-6 mt-3 option_class_video">
                          <div class="form-group">
                            <label>{{__('Label.Video')}}</label>
                            <select class="form-control" name="video_id" id="video_id" style="width:100%!important;">
                              <option value="" selected disabled> Select Video </option>
                              @foreach ($video as $key => $value)
                                <option value="{{ $value->id}}">{{ $value->name }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="after-add-more">
                       
                      </div>
                    </form>
                </div>
            </div>
        </div>
      </div>

    </div>
  </div>
@endsection

@push('scripts')
  <script>
    $(document).ready(function() {
			$("#video_id").select2();
			$(".video_id").select2({
				placeholder: "{{__('Label.Select Video')}}"
			});
		});

    function Selected_Type(type_id, type, is_home_page){
      
      if(is_home_page == '1'){
        $("#Video_Selecte0").prop('checked', true);
      }

      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        url: '{{ route("BannerTypeByVideo") }}',
        data: {type_id:type_id,type:type},
        success: function(resp) {
          $("#video_id").empty();
          $('#video_id').append(`<option value="" selected disabled> Select Video </option>`);          
          for (var i = 0; i < resp.result.length; i++) {
            $('#video_id').append(`<option value="${resp.result[i].id}">${resp.result[i].name}</option>`);          
          }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          toastr.error(errorThrown.msg, 'failed');
        }
      });
    };

    $('select').on('change', function () {

      var Tab = $("ul.tabs li a.active");
      var Is_home_screen = Tab.data("is_home_screen");
      
      if(Is_home_screen == 1){
        var Sel_Type_Id = $('input[name=type_id]:checked').val();
        var Sel_Video_Type = $('input[name=type_id]:checked').data('type');
        
      } else {
        var Main_Type_Id = Tab.data("id");
        var Main_Type_Type = Tab.data("type");
        var Sel_Type_Id = Main_Type_Id;
        var Sel_Video_Type = Main_Type_Type;
      }
      var Video_Name = $('select[name=video_id] option').filter(':selected').val();
      var Order = 1;
      
      var Video_Name_Text = $('select[name=video_id] option').filter(':selected').text();
      var S_Video_Type = $('input[name=type_id]:checked').data('name');     
      
      $("#dvloader").show();
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        url: '{{ route("BannerSave") }}',
        data: {type_id:Sel_Type_Id, is_home_screen:Is_home_screen, video_type: Sel_Video_Type, video_id:Video_Name, order_no:Order},
        success: function(resp) {
          $("#dvloader").hide();
          get_responce_message2(resp, 'save_banner',"",1);
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          $("#dvloader").hide();
          toastr.error(errorThrown.msg, 'failed');
        }
      });
    });

    var Tab = $("ul.tabs li a.active");
    var Is_home_screen = Tab.data("is_home_screen");
    if(Is_home_screen == 1){

      var type_id = $('input[name=type_id]:checked').val();
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        data: {is_home_screen:Is_home_screen},
        url: '{{ route("BannerList") }}',
        success: function(resp) {
          for (var i = 0; i < resp.result.length; i++) {
            var data ='<div class="form-group row">' +
                        '<div class="col-md-2">' +
                          '<label>Type</label>' +
                          '<input type="text" class="form-control" name="type" value="'+ resp.result[i].type.name +'" placeholder="Dropdown" readonly/>' +
                          '<input type="hidden" class="form-control" name="video_type" value=""/>' +
                        '</div>' +
                        '<div class="col-md-4">' +
                          '<label>Video</label>' +
                          '<input type="text" class="form-control" name="video" value="'+ resp.result[i].video_id.name +'" id="video" placeholder="Dropdown" readonly/>' +
                        '</div>' +
                        '<div class="col-md-1 flex-grow-1 px-3">' +
                          '<div class="change">' +
                            '<label>&nbsp;</label><br/><a onclick="DeleteBanner('+ resp.result[i].id +')" class="btn btn-danger remove" id="remove"> <img src="{{ asset('assets/imgs/trash-black.png') }}"> </a>' +
                          '</div>' +
                        '</div>' +
                      '</div>';
            $('.after-add-more').append(data);
          }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          toastr.error(errorThrown.msg, 'failed');
        }
      });
    }

    $('.nav-item a').on('click', function() {
      var Is_home_screen = $(this).data("is_home_screen");
      $(".after-add-more .row").remove();
      if(Is_home_screen == 2){
        
        $('.radio-row').hide();
        var type_id = $(this).data("id");

        $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: "POST",
          data: {type_id:type_id, is_home_screen:Is_home_screen},
          url: '{{ route("BannerList") }}',
          success: function(resp) {
            for (var i = 0; i < resp.result.length; i++) {
              var data ='<div class="form-group row">' +
                          '<div class="col-md-2">' +
                            '<label>Type</label>' +
                            '<input type="text" class="form-control" name="type" value="'+ resp.result[i].type.name +'" placeholder="Dropdown" readonly/>' +
                            '<input type="hidden" class="form-control" name="video_type" value=""/>' +
                          '</div>' +
                          '<div class="col-md-4">' +
                            '<label>Video</label>' +
                            '<input type="text" class="form-control" name="video" value="'+ resp.result[i].video_id.name +'" id="video" placeholder="Dropdown" readonly/>' +
                          '</div>' +
                          '<div class="col-md-1 flex-grow-1 px-3">' +
                            '<div class="change">' +
                              '<label for="">&nbsp;</label><br/><a onclick="DeleteBanner('+ resp.result[i].id +')" class="btn btn-danger remove" id="remove"> <img src="{{ asset('assets/imgs/trash-black.png') }}"> </a>' +
                            '</div>' +
                          '</div>' +
                        '</div>';
              $('.after-add-more').append(data);
            }
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) {
            toastr.error(errorThrown.msg, 'failed');
          }
        });
      } else {
        
        $('.radio-row').show(); 

        $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: "POST",
          data: {is_home_screen:Is_home_screen},
          url: '{{ route("BannerList") }}',
          success: function(resp) {
            for (var i = 0; i < resp.result.length; i++) {
              var data ='<div class="form-group row">' +
                          '<div class="col-md-2">' +
                            '<label>Type</label>' +
                            '<input type="text" class="form-control" name="type" value="'+ resp.result[i].type.name +'" placeholder="Dropdown" readonly/>' +
                            '<input type="hidden" class="form-control" name="video_type" value=""/>' +
                          '</div>' +
                          '<div class="col-md-4">' +
                            '<label>Video</label>' +
                            '<input type="text" class="form-control" name="video" value="'+ resp.result[i].video_id.name +'" id="video" placeholder="Dropdown" readonly/>' +
                          '</div>' +
                          '<div class="col-md-1 flex-grow-1 px-3">' +
                            '<div class="change">' +
                              '<label for="">&nbsp;</label><br/><a onclick="DeleteBanner('+ resp.result[i].id +')" class="btn btn-danger remove" id="remove"> <img src="{{ asset('assets/imgs/trash-black.png') }}"> </a>' +
                            '</div>' +
                          '</div>' +
                        '</div>';
              $('.after-add-more').append(data);
            }
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) {
            toastr.error(errorThrown.msg, 'failed');
          }
        });
      };
    });
  
    function DeleteBanner(id) {
      var url = "{{route('deleteBanner', '')}}"+"/"+id;

      $("#dvloader").show();
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        url:url,
        success: function(resp) {
          $("#dvloader").hide();
          get_responce_message2(resp, 'save_banner', '{{ route("Banner") }}', 2);
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          $("#dvloader").hide();
          toastr.error(errorThrown.msg, 'failed');
        }
      });
    }
  </script>
@endpush