<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\App_Section;
use App\Models\Cast;
use App\Models\Category;
use App\Models\Channel;
use App\Models\Channel_Section;
use App\Models\Language;
use App\Models\Session;
use App\Models\TVShow;
use App\Models\TVShowVideo;
use App\Models\Type;
use DataTables;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Validator;

class TVShowController extends Controller
{

    private $folder = "show";
    private $folder1 = "cast";

    public function index()
    {
        try {
            return view('admin.tv_show.index');
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

    public function data(Request $request)
    {
        try {
            if ($request == true) {

                $data = TVShow::select('*')
                    ->with('channel')
                    ->with('type')
                    ->get();

                return DataTables()::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="' . route("editTVShow", $row->id) . '" class="btn"><img src="' . url("assets/imgs/edit.png") . '" /></a> ';
                        $btn .= '<a href="' . route("deleteTVShow", $row->id) . '" onclick="return confirm(\'Are you sure you want to delete this item\')" class="delete btn btn-sm"><img src="' . url("assets/imgs/trash.png") . '" /> </a>';
                        return $btn;
                    })
                    ->addColumn('details', function ($row) {
                        $btn = '<a href="' . route("TVShowDetail", $row->id) . '" class="btn text-white p-1 font-weight-bold" style="background:#17a2b8;">More Details</a> ';
                        return $btn;
                    })
                    ->addColumn('season', function ($row) {
                        $btn = '<a href="' . route("TVShowvideo", $row->id) . '" class="btn text-white p-1 font-weight-bold" style="background:#006a4e;"> Episode List</a> ';
                        return $btn;
                    })
                    ->rawColumns(['action', 'details', 'season'])
                    ->make(true);
            } else {
                return view('admin.tv_show.index');
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

    public function add()
    {
        try {
            $channel = Channel::select('*')->get();
            $category = Category::select('*')->get();
            $language = Language::select('*')->get();
            $cast = Cast::select('*')->get();
            $type = Type::select('*')->where('type', '2')->get();

            return view('admin.tv_show.add', ['channel' => $channel, 'category' => $category, 'language' => $language, 'cast' => $cast, 'type' => $type]);
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

    public function save(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|min:2',
                'category_id' => 'required',
                'type_id' => 'required',
                'language_id' => 'required',
                'cast_id' => 'required',
                'description' => 'required',
                'is_premium' => 'required',
                'is_title' => 'required',
                'thumbnail' => 'image|mimes:jpeg,png,jpg|max:2048',
                'landscape' => 'image|mimes:jpeg,png,jpg|max:2048',
            ]);
            if ($validator->fails()) {
                $errs = $validator->errors()->all();
                return response()->json(array('status' => 400, 'errors' => $errs));
            } else {
                $category_id = implode(',', $request->category_id);
                $language_id = implode(',', $request->language_id);
                $cast_id = implode(',', $request->cast_id);

                $TVShow = new TVShow();
                $TVShow->name = $request->name;
                $TVShow->channel_id = isset($request->channel_id) ? $request->channel_id : 0;
                $TVShow->category_id = $category_id;
                $TVShow->language_id = $language_id;
                $TVShow->cast_id = $cast_id;
                $TVShow->video_type = 2;
                $TVShow->description = $request->description;
                $TVShow->is_premium = $request->is_premium;
                $TVShow->is_title = $request->is_title;
                $TVShow->type_id = $request->type_id;
                $TVShow->status = 1;
                $TVShow->view = 0;

                $TVShow->director_id = "";
                $TVShow->starring_id = "";
                $TVShow->supporting_cast_id = "";
                $TVShow->networks = "";
                $TVShow->maturity_rating = "";
                $TVShow->studios = "";
                $TVShow->content_advisory = "";
                $TVShow->viewing_rights = "";
                $TVShow->imdb_rating = isset($request->imdb_rating) ? $request->imdb_rating : 0;

                $org_name = $request->file('thumbnail');
                if ($org_name != null && isset($org_name)) {
                    $TVShow->thumbnail = saveImage($org_name, $this->folder);
                } elseif ($request->thumbnail_imdb) {
                    $url = $request->thumbnail_imdb;
                    $S_Name = URLSaveInImage($url, $this->folder);
                    $TVShow->thumbnail = $S_Name;
                } else {
                    $TVShow->thumbnail = "";
                }

                $org_name1 = $request->file('landscape');
                if ($org_name1 != null && isset($org_name1)) {
                    $TVShow->landscape = saveImage_landscape($org_name1, $this->folder);
                } elseif ($request->landscape_imdb) {
                    $url = $request->landscape_imdb;
                    $S_Name = URLSaveInImage_landscape($url, $this->folder);
                    $TVShow->landscape = $S_Name;
                } else {
                    $TVShow->landscape = "";
                }

                if ($TVShow->save()) {

                    // Send Notification
                    $imageURL = Get_Image('show') . $TVShow->thumbnail;
                    $noti_array = array(
                        'id' => $TVShow->id,
                        'name' => $TVShow->name,
                        'image' => $imageURL,
                        'video_type' => $TVShow->video_type,
                        'type_id' => $TVShow->type_id,
                        'description' => string_cut($TVShow->description, 90),
                    );
                    sendNotification($noti_array);

                    return response()->json(array('status' => 200, 'success' => __('Label.Data Add Successfully')));
                } else {
                    return response()->json(array('status' => 400, 'errors' => __('Label.Data Not Add')));
                }
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

    public function edit(Request $request, $id)
    {
        try {
            $TVShow = TVshow::where('id', $id)->first();
            $channel = Channel::select('*')->get();
            $category = Category::select('*')->get();
            $language = Language::select('*')->get();
            $cast = Cast::select('*')->get();
            $type = Type::select('*')->where('type', '2')->get();

            return view('admin.tv_show.edit', ['result' => $TVShow, 'type' => $type, 'channel' => $channel, 'category' => $category, 'language' => $language, 'cast' => $cast]);
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

    public function update(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|min:2',
                'category_id' => 'required',
                'language_id' => 'required',
                'cast_id' => 'required',
                'description' => 'required',
                'is_premium' => 'required',
                'type_id' => 'required',
                'is_title' => 'required',
                'thumbnail' => 'image|mimes:jpeg,png,jpg|max:2048',
                'landscape' => 'image|mimes:jpeg,png,jpg|max:2048',
            ]);
            if ($validator->fails()) {
                $errs = $validator->errors()->all();
                return response()->json(array('status' => 400, 'errors' => $errs));
            } else {

                $category_id = implode(',', $request->category_id);
                $language_id = implode(',', $request->language_id);
                $cast_id = implode(',', $request->cast_id);

                $TVShow = TVShow::where('id', $request->id)->first();
                if (isset($TVShow->id)) {
                    $TVShow->name = $request->name;
                    $TVShow->channel_id = isset($request->channel_id) ? $request->channel_id : 0;
                    $TVShow->category_id = $category_id;
                    $TVShow->language_id = $language_id;
                    $TVShow->cast_id = $cast_id;
                    $TVShow->description = $request->description;
                    $TVShow->is_premium = $request->is_premium;
                    $TVShow->is_title = $request->is_title;
                    $TVShow->type_id = $request->type_id;
                    $TVShow->status = 1;
                    $TVShow->video_type = 2;

                    $org_name = $request->file('thumbnail');
                    if ($org_name != null && isset($org_name)) {
                        $TVShow->thumbnail = saveImage($org_name, $this->folder);
                        @unlink("images/show/" . $request->old_thumbnail);
                    } elseif ($request->thumbnail_imdb) {
                        $url = $request->thumbnail_imdb;
                        $S_Name = URLSaveInImage($url, $this->folder);
                        $TVShow->thumbnail = $S_Name;
                        @unlink("images/show/" . $request->old_thumbnail);
                    } else {
                        $TVShow->thumbnail = $request->old_thumbnail;
                    }

                    $org_name1 = $request->file('landscape');
                    if ($org_name1 != null && isset($org_name1)) {
                        $TVShow->landscape = saveImage_landscape($org_name1, $this->folder);
                        @unlink("images/show/" . $request->old_landscape);
                    } elseif ($request->landscape_imdb) {
                        $url = $request->landscape_imdb;
                        $S_Name = URLSaveInImage_landscape($url, $this->folder);
                        $TVShow->landscape = $S_Name;
                        @unlink("images/show/" . $request->old_landscape);
                    } else {
                        $TVShow->landscape = $request->old_landscape;
                    }

                    if ($TVShow->save()) {
                        return response()->json(array('status' => 200, 'success' => __('Label.Data Edit Successfully')));
                    } else {
                        return response()->json(array('status' => 400, 'errors' => __('Label.Data Not Updated')));
                    }
                } else {
                    return response()->json(array('status' => 400, 'errors' => __('Label.Data Not Updated')));
                }
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

    public function delete($id)
    {
        try {
            $TVShow = TVShow::where('id', $id)->first();
            $App_Section = App_Section::whereRaw("find_in_set('" . $TVShow->id . "',app_section.tv_show_id)")->first();
            $Channel_Section = Channel_Section::whereRaw("find_in_set('" . $TVShow->id . "',channel_section.tv_show_id)")->first();

            if ($App_Section) {
                return back()->with('error', "This TVShow is used on some other table so you can not remove it.");
            } elseif ($Channel_Section) {
                return back()->with('error', "This TVShow is used on some other table so you can not remove it.");
            } else {
                if ($TVShow->delete()) {
                    @unlink("images/show/" . $TVShow->thumbnail);
                    @unlink("images/show/" . $TVShow->landscape);

                    $TVShowVideo = TVShowVideo::where('show_id', $TVShow->id)->get();
                    foreach ($TVShowVideo as $key => $value) {
                        if ($TVShowVideo->delete()) {
                            @unlink("images/show/" . $value->thumbnail);
                            @unlink("images/show/" . $value->landscape);
                            @unlink("images/video/" . $value->video);
                        }
                    }
                    return back()->with('success', __('Label.Data Delete Successfully'));
                }
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

    // TVShow Details
    public function TVShowDetail($id)
    {
        try {
            $TVShow = TVshow::where('id', $id)->first();
            $x = explode(",", $TVShow->category_id);
            $y = explode(",", $TVShow->language_id);
            $z = explode(",", $TVShow->cast_id);

            $channel = Channel::select('name')->where('id', $TVShow->channel_id)->first();
            $category = Category::select('name')->whereIn('id', $y)->get();
            $language = Language::select('name')->whereIn('id', $x)->get();
            $cast = Cast::select('name', 'type')->whereIn('id', $z)->get();

            return view('admin.tv_show.detail_page', ['tvshow' => $TVShow, 'channel' => $channel, 'category' => $category, 'language' => $language, 'cast' => $cast]);
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

    // TVShow Video
    public function TVShowvideo($id)
    {
        try {
            $video_list = TvShowVideo::select('tv_show_video.*', 'session.id as session_id', 'session.name as session_name')
                ->join('session', 'session.id', '=', 'tv_show_video.session_id')
                ->where('show_id', $id)
                ->latest()
                ->paginate(7);
            $session = Session::get();

            return view('admin.tv_show.video_list', ['tvshowId' => $id, 'result' => $video_list, 'session' => $session]);
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

    public function TVShowvideoadd($id)
    {
        try {
            $session = Session::select('*')->get();
            return view('admin.tv_show.add_video', ['tvshowId' => $id, 'session' => $session]);
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

    public function TVShowvideosave(Request $request)
    {
        try {
            if ($request->video_upload_type == "server_video") {
                $validator = Validator::make($request->all(), [
                    'show_id' => 'required',
                    'session_id' => 'required',
                    'video_upload_type' => 'required',
                    'thumbnail' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                    'landscape' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                    'video_duration' => 'required|after_or_equal:00:00:01',
                    'description' => 'required',
                    'is_premium' => 'required',
                    'is_title' => 'required',
                ]);
            } else {
                $validator = Validator::make($request->all(), [
                    'show_id' => 'required',
                    'session_id' => 'required',
                    'video_upload_type' => 'required',
                    'thumbnail' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                    'landscape' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                    'video_duration' => 'required|after_or_equal:00:00:01',
                    'description' => 'required',
                    'is_premium' => 'required',
                    'is_title' => 'required',
                ]);
            }

            if ($validator->fails()) {
                $errs = $validator->errors()->all();
                return response()->json(array('status' => 400, 'errors' => $errs));
            } else {

                $TvShowVideo = new TVShowVideo();
                $TvShowVideo->show_id = $request->show_id;
                $TvShowVideo->session_id = $request->session_id;

                $org_name = $request->file('thumbnail');
                $org_name1 = $request->file('landscape');
                if ($org_name != null) {
                    $TvShowVideo->thumbnail = saveImage($org_name, $this->folder);
                }
                if ($org_name1 != null) {
                    $TvShowVideo->landscape = saveImage_landscape($org_name1, $this->folder);
                }

                if ($request->video_upload_type == "server_video") {

                    $TvShowVideo->video_320 = isset($request->upload_video_320) ? $request->upload_video_320 : '';
                    $TvShowVideo->video_480 = isset($request->upload_video_480) ? $request->upload_video_480 : '';
                    $TvShowVideo->video_720 = isset($request->upload_video_720) ? $request->upload_video_720 : '';
                    $TvShowVideo->video_1080 = isset($request->upload_video_1080) ? $request->upload_video_1080 : '';

                    $array = explode('.', $request->upload_video_320);
                    $TvShowVideo->video_extension = end($array);
                } else {

                    $TvShowVideo->video_320 = isset($request->video_url_320) ? $request->video_url_320 : '';
                    $TvShowVideo->video_480 = isset($request->video_url_480) ? $request->video_url_480 : '';
                    $TvShowVideo->video_720 = isset($request->video_url_720) ? $request->video_url_720 : '';
                    $TvShowVideo->video_1080 = isset($request->video_url_1080) ? $request->video_url_1080 : '';

                    $array = explode('.', $request->video_url_320);
                    $array1 = explode('?', end($array));
                    if (isset($array1) && $array1 != null) {
                        $TvShowVideo->video_extension = isset($array1) ? reset($array1) : "";
                    } else {
                        $TvShowVideo->video_extension = "";
                    }
                }

                $TvShowVideo->subtitle_type = isset($request->subtitle_type) ? $request->subtitle_type : '';
                if ($request->subtitle_type == "server_file") {
                    $TvShowVideo->subtitle = isset($request->subtitle) ? $request->subtitle : '';
                } else {
                    $TvShowVideo->subtitle = isset($request->subtitle_url) ? $request->subtitle_url : '';
                }

                if ($request->video_upload_type == "server_video" || $request->video_upload_type == "external") {
                    $TvShowVideo->download = $request->download;
                } else {
                    $TvShowVideo->download = 0;
                }

                $TvShowVideo->video_type = 2;
                $TvShowVideo->video_upload_type = $request->video_upload_type;

                $TvShowVideo->is_premium = $request->is_premium;
                $TvShowVideo->video_duration = TimeToMilliseconds($request->video_duration);
                $TvShowVideo->description = $request->description;
                $TvShowVideo->view = 0;
                $TvShowVideo->status = "1";
                $TvShowVideo->is_title = $request->is_title;

                if ($TvShowVideo->save()) {

                    $showData = TVShow::where('id', $TvShowVideo->show_id)->first();
                    if (isset($showData)) {

                        // Send Notification
                        $imageURL = Get_Image('show') . $TvShowVideo->thumbnail;
                        $noti_array = array(
                            'id' => $showData->id,
                            'name' => $showData->name,
                            'image' => $imageURL,
                            'video_type' => $showData->video_type,
                            'type_id' => $showData->type_id,
                            'description' => string_cut($TvShowVideo->description, 90),
                        );
                        sendNotification($noti_array);
                    }
                    return response()->json(array('status' => 200, 'success' => __('Label.Data Add Successfully')));
                } else {
                    return response()->json(array('status' => 400, 'errors' => __('Label.Data Not Add')));
                }
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }

    }

    public function TVShowVideoSerach(Request $request)
    {
        try {
            if ($_GET['session'] != "All") {

                if (isset($_GET['session'])) {

                    $video_list = TvShowVideo::select('tv_show_video.*', 'session.id as session_id', 'session.name as session_name')
                        ->join('session', 'session.id', '=', 'tv_show_video.session_id')
                        ->where('show_id', $request->show_id)
                        ->where('session_id', $_GET['session'])
                        ->paginate(7);
                    $session = Session::get();

                    return view('admin.tv_show.video_list', ['tvshowId' => $request->show_id, 'result' => $video_list, 'session' => $session]);
                }
            } else {
                return redirect()->route('TVShowvideo', ['id' => $request->show_id]);
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

    public function TVShowvideoedit(Request $request, $show_id, $id)
    {
        try {
            $result = TVShowVideo::where('id', $id)->first();
            $session = Session::get();
            if ($result) {
                return view('admin.tv_show.edit_video', ['tvshowId' => $show_id, 'session' => $session, 'result' => $result]);
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

    public function TVShowvideoupdate(Request $request)
    {
        try {
            if ($request->video_upload_type == "server_video") {
                $validator = Validator::make($request->all(), [
                    'show_id' => 'required',
                    'video_id' => 'required',
                    'session_id' => 'required',
                    'video_upload_type' => 'required',
                    'thumbnail' => 'image|mimes:jpeg,png,jpg|max:2048',
                    'landscape' => 'image|mimes:jpeg,png,jpg|max:2048',
                    'video_duration' => 'required|after_or_equal:00:00:01',
                    'description' => 'required',
                    'is_premium' => 'required',
                    'is_title' => 'required',
                ]);
            } else {
                $validator = Validator::make($request->all(), [
                    'show_id' => 'required',
                    'video_id' => 'required',
                    'session_id' => 'required',
                    'video_upload_type' => 'required',
                    'thumbnail' => 'image|mimes:jpeg,png,jpg|max:2048',
                    'landscape' => 'image|mimes:jpeg,png,jpg|max:2048',
                    'video_duration' => 'required|after_or_equal:00:00:01',
                    'description' => 'required',
                    'is_premium' => 'required',
                    'is_title' => 'required',
                ]);
            }

            if ($validator->fails()) {
                $errs = $validator->errors()->all();
                return response()->json(array('status' => 400, 'errors' => $errs));
            } else {
                $TVShowVideo = TVShowVideo::where('id', $request->video_id)->first();
                if (isset($TVShowVideo->id)) {

                    $TVShowVideo->show_id = $request->show_id;
                    $TVShowVideo->session_id = $request->session_id;
                    $TVShowVideo->is_premium = $request->is_premium;
                    $TVShowVideo->is_title = $request->is_title;
                    $TVShowVideo->video_duration = TimeToMilliseconds($request->video_duration);
                    $TVShowVideo->description = $request->description;
                    $TVShowVideo->video_type = 2;
                    $TVShowVideo->video_upload_type = $request->video_upload_type;

                    if ($request->video_upload_type == "server_video") {

                        if ($request->upload_video_320) {
                            $TVShowVideo->video_320 = $request->upload_video_320;
                            @unlink("images/video/" . $request->old_video_320);

                            $array = explode('.', $request->upload_video_320);
                            $TVShowVideo->video_extension = end($array);
                        }
                        if ($request->upload_video_480) {
                            $TVShowVideo->video_480 = $request->upload_video_480;
                            @unlink("images/video/" . $request->old_video_480);
                        }
                        if ($request->upload_video_720) {
                            $TVShowVideo->video_720 = $request->upload_video_720;
                            @unlink("images/video/" . $request->old_video_720);
                        }
                        if ($request->upload_video_1080) {
                            $TVShowVideo->video_1080 = $request->upload_video_1080;
                            @unlink("images/video/" . $request->old_video_1080);
                        }
                    } else {

                        if ($request->video_url_320) {
                            $TVShowVideo->video_320 = $request->video_url_320;

                            $array = explode('.', $request->video_url_320);
                            $array1 = explode('?', end($array));
                            if (isset($array1) && $array1 != null) {
                                $TVShowVideo->video_extension = isset($array1) ? reset($array1) : "";
                            } else {
                                $TVShowVideo->video_extension = "";
                            }
                        }
                        if ($request->video_url_480) {
                            $TVShowVideo->video_480 = $request->video_url_480;
                        }
                        if ($request->video_url_720) {
                            $TVShowVideo->video_720 = $request->video_url_720;
                        }
                        if ($request->video_url_1080) {
                            $TVShowVideo->video_1080 = $request->video_url_1080;
                        }
                    }
                    if ($request->video_upload_type == "server_video" || $request->video_upload_type == "external") {
                        $TVShowVideo->download = $request->download;
                    } else {
                        $TVShowVideo->download = 0;
                    }

                    $TVShowVideo->subtitle_type = isset($request->subtitle_type) ? $request->subtitle_type : '';
                    @unlink("images/video/" . $request->old_subtitle);
                    if ($request->subtitle_type == "server_file") {
                        if ($request->subtitle) {
                            $TVShowVideo->subtitle = isset($request->subtitle) ? $request->subtitle : '';
                        }
                    } else {
                        if ($request->subtitle_url) {
                            $TVShowVideo->subtitle = isset($request->subtitle_url) ? $request->subtitle_url : '';
                        }
                    }

                    $org_name = $request->file('thumbnail');
                    $org_name1 = $request->file('landscape');
                    if ($org_name != null) {
                        $TVShowVideo->thumbnail = saveImage($org_name, $this->folder);
                        @unlink("images/show/" . $request->old_thumbnail);
                    }
                    if ($org_name1 != null) {
                        $TVShowVideo->landscape = saveImage_landscape($org_name1, $this->folder);
                        @unlink("images/show/" . $request->old_landscape);
                    }

                    if ($TVShowVideo->save()) {
                        return response()->json(array('status' => 200, 'success' => __('Label.Data Edit Successfully')));
                    } else {
                        return response()->json(array('status' => 400, 'errors' => __('Label.Data Not Updated')));
                    }
                } else {
                    return response()->json(array('status' => 400, 'errors' => __('Label.Data Not Updated')));
                }
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

    public function TVShowvideodelete($id)
    {
        try {
            $TVShowVideo = TVShowVideo::where('id', $id)->first();
            if ($TVShowVideo->thumbnail != null && $TVShowVideo->landscape != null && $TVShowVideo->video != null) {
                if ($TVShowVideo->delete()) {
                    @unlink("images/show/" . $TVShowVideo->thumbnail);
                    @unlink("images/show/" . $TVShowVideo->landscape);
                    @unlink("images/video/" . $TVShowVideo->video);
                    @unlink("images/video/" . $TVShowVideo->video_320);
                    @unlink("images/video/" . $TVShowVideo->video_480);
                    @unlink("images/video/" . $TVShowVideo->video_720);
                    @unlink("images/video/" . $TVShowVideo->video_1080);
                    @unlink("images/video/" . $TVShowVideo->subtitle);
                    return back()->with('success', __('Label.Data Delete Successfully'));
                }
            } else {
                if ($TVShowVideo->delete()) {
                    return back()->with('success', __('Label.Data Delete Successfully'));
                }
            }
        } catch (Exception $e) {
            return redirect('dashboard')->with($e);
        }
    }

    // IMDB
    public function SerachName($txtVal)
    {
        try {
            $imdbTitle = $txtVal;

            if (strlen($imdbTitle) >= 3) {
                $url = 'http://www.omdbapi.com/?apikey=989e01ee&type=series&s=' . $imdbTitle;
                $response = Http::get($url);
                $Status = $response->getStatusCode();
                $Data = $response->json();
                if ($Status == 200) {
                    return response()->json(array('status' => 200, 'success' => __('Label.Data Edit Successfully'), 'data' => $Data));
                }
            } else {
                return response()->json(array('status' => 400, 'success' => __('Label.Data Edit Successfully')));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

    public function GetData($imdbID)
    {
        try {
            $url = 'http://www.omdbapi.com/?apikey=989e01ee&type=series&i=' . $imdbID;
            $movies = curl($url);

            // Category
            $C_Id = [];
            $C_Insert_Data = [];
            if (isset($movies['Genre'])) {

                $Cat_name = explode(", ", $movies['Genre']);
                for ($i = 0; $i < count($Cat_name); $i++) {

                    $Category = Category::where(DB::raw('lower(name)'), strtolower($Cat_name[$i]))->first();
                    if (!empty($Category)) {

                        $C_Id[] = $Category['id'];
                    } else {

                        $insert = new Category();
                        $insert->name = $Cat_name[$i];
                        $insert->image = "";
                        $insert->save();

                        $C_Id[] = $insert->id;
                        $C_Insert_Data[] = $insert;
                    }
                }
            }

            // Language
            $L_Id = [];
            $L_Insert_Data = [];
            if (isset($movies['Language'])) {

                $Lang_name = explode(", ", $movies['Language']);
                for ($i = 0; $i < count($Lang_name); $i++) {

                    $Language = Language::where(DB::raw('lower(name)'), strtolower($Lang_name[$i]))->first();
                    if (!empty($Language)) {

                        $L_Id[] = $Language['id'];
                    } else {

                        $insert = new Language();
                        $insert->name = $Lang_name[$i];
                        $insert->image = "";
                        $insert->save();

                        $L_Id[] = $insert->id;
                        $L_Insert_Data[] = $insert;
                    }
                }
            }

            // Cast
            $Cast_Id = [];
            $Cast_Insert_Data = [];
            if (isset($movies['Director']) && $movies['Director'] != "N/A") {
                $Director_name = explode(", ", $movies['Director']);
                for ($i = 0; $i < count($Director_name); $i++) {

                    $Director = Cast::where(DB::raw('lower(name)'), strtolower($Director_name[$i]))->first();
                    if (!empty($Director)) {

                        $Cast_Id[] = $Director['id'];
                    } else {

                        $url = 'https://api.themoviedb.org/3/search/person?api_key=36c8c005f7dbad35c19ce56eec076321&query=' . $Director_name[$i];
                        $response = Http::get($url);
                        $Status = $response->getStatusCode();
                        $Data = (array) $response->json();

                        $insert = new Cast();
                        $insert->name = $Director_name[$i];
                        $insert->type = "Director";
                        if (isset($Data['results']) && count($Data['results']) > 0) {

                            $url1 = 'https://api.themoviedb.org/3/person/' . $Data['results'][0]['id'] . '?api_key=36c8c005f7dbad35c19ce56eec076321';
                            $Response = Http::get($url1);
                            $status = $Response->getStatusCode();
                            $Person_Data = (array) $Response->json();

                            if (isset($Person_Data) && $Person_Data != null) {

                                if ($Person_Data['profile_path'] != null) {

                                    $url1 = 'https://image.tmdb.org/t/p/original' . $Person_Data['profile_path'];

                                    $CI_Name = URLSaveInImage($url1, $this->folder1);
                                    $insert->image = $CI_Name;
                                } else {
                                    $insert->image = "";
                                }
                                $insert->personal_info = $Person_Data['biography'];
                            } else {

                                $insert->image = "";
                                $insert->personal_info = "";
                            }
                        } else {

                            $insert->image = "";
                            $insert->personal_info = "";
                        }
                        $insert->save();

                        $Cast_Id[] = $insert->id;
                        $Cast_Insert_Data[] = $insert;
                    }
                }
            }
            if (isset($movies['Writer']) && $movies['Writer'] != "N/A") {

                $Writer_name = explode(", ", $movies['Writer']);
                for ($i = 0; $i < count($Writer_name); $i++) {

                    $Writer = Cast::where(DB::raw('lower(name)'), strtolower($Writer_name[$i]))->first();
                    if (!empty($Writer)) {

                        $Cast_Id[] = $Writer['id'];
                    } else {

                        $url = 'https://api.themoviedb.org/3/search/person?api_key=36c8c005f7dbad35c19ce56eec076321&query=' . $Writer_name[$i];
                        $response = Http::get($url);
                        $Status = $response->getStatusCode();
                        $Data = (array) $response->json();

                        $insert = new Cast();
                        $insert->name = $Writer_name[$i];
                        $insert->type = "Writer";
                        if (isset($Data['results']) && count($Data['results']) > 0) {

                            $url1 = 'https://api.themoviedb.org/3/person/' . $Data['results'][0]['id'] . '?api_key=36c8c005f7dbad35c19ce56eec076321';
                            $Response = Http::get($url1);
                            $status = $Response->getStatusCode();
                            $Person_Data = (array) $Response->json();

                            if (isset($Person_Data) && $Person_Data != null) {

                                if ($Person_Data['profile_path'] != null) {

                                    $url1 = 'https://image.tmdb.org/t/p/original' . $Person_Data['profile_path'];

                                    $CI_Name = URLSaveInImage($url1, $this->folder1);
                                    $insert->image = $CI_Name;
                                } else {
                                    $insert->image = "";
                                }
                                $insert->personal_info = $Person_Data['biography'];
                            } else {

                                $insert->image = "";
                                $insert->personal_info = "";
                            }
                        } else {

                            $insert->image = "";
                            $insert->personal_info = "";
                        }
                        $insert->save();

                        $Cast_Id[] = $insert->id;
                        $Cast_Insert_Data[] = $insert;
                    }
                }
            }
            if (isset($movies['Actors']) && $movies['Actors'] != "N/A") {

                $Actors_name = explode(", ", $movies['Actors']);
                for ($i = 0; $i < count($Actors_name); $i++) {

                    $Actors = Cast::where(DB::raw('lower(name)'), strtolower($Actors_name[$i]))->first();
                    if (!empty($Actors)) {

                        $Cast_Id[] = $Actors['id'];
                    } else {

                        $url = 'https://api.themoviedb.org/3/search/person?api_key=36c8c005f7dbad35c19ce56eec076321&query=' . $Actors_name[$i];
                        $response = Http::get($url);
                        $Status = $response->getStatusCode();
                        $Data = (array) $response->json();

                        $insert = new Cast();
                        $insert->name = $Actors_name[$i];
                        $insert->type = "Actor";
                        if (isset($Data['results']) && count($Data['results']) > 0) {

                            $url1 = 'https://api.themoviedb.org/3/person/' . $Data['results'][0]['id'] . '?api_key=36c8c005f7dbad35c19ce56eec076321';
                            $Response = Http::get($url1);
                            $status = $Response->getStatusCode();
                            $Person_Data = (array) $Response->json();

                            if (isset($Person_Data) && $Person_Data != null) {

                                if ($Person_Data['profile_path'] != null) {

                                    $url1 = 'https://image.tmdb.org/t/p/original' . $Person_Data['profile_path'];

                                    $CI_Name = URLSaveInImage($url1, $this->folder1);
                                    $insert->image = $CI_Name;
                                } else {
                                    $insert->image = "";
                                }
                                $insert->personal_info = $Person_Data['biography'];
                            } else {

                                $insert->image = "";
                                $insert->personal_info = "";
                            }
                        } else {

                            $insert->image = "";
                            $insert->personal_info = "";
                        }
                        $insert->save();

                        $Cast_Id[] = $insert->id;
                        $Cast_Insert_Data[] = $insert;
                    }
                }
            }

            // Poster
            if (isset($movies['Poster'])) {
                $Poster_img = $movies['Poster'];
            } else {
                $Poster_img = "";
            }

            // Description
            if (isset($movies['Plot'])) {
                $Description = $movies['Plot'];
            } else {
                $Description = "";
            }

            // Year
            if (isset($movies['Year'])) {
                $Year = $movies['Year'];
            } else {
                $Year = "";
            }

            // imdbRating
            if (isset($movies['imdbRating'])) {
                $imdbRating = $movies['imdbRating'];
            } else {
                $imdbRating = "";
            }

            return response()->json(array('status' => 200, 'C_Id' => $C_Id, 'L_Id' => $L_Id, 'C_Insert_Data' => $C_Insert_Data, 'L_Insert_Data' => $L_Insert_Data, 'Poster_img' => $Poster_img, 'Description' => $Description, 'Cast_Id' => $Cast_Id, 'Cast_Insert_Data' => $Cast_Insert_Data, 'Year' => $Year, 'imdbRating' => $imdbRating));
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

}
