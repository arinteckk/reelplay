<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\App_Section;
use App\Models\Cast;
use App\Models\Category;
use App\Models\Channel;
use App\Models\Channel_Section;
use App\Models\Language;
use App\Models\Type;
use App\Models\Video;
use DB;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Image;
use Validator;

class VideoController extends Controller
{
    private $folder = "video";
    private $folder1 = "cast";

    public function index(Request $request)
    {
        try {
            if ($request->type != null && $request->type != "all") {
                $video_list = Video::select('*')
                    ->where('type_id', $request->type)
                    ->with('type')
                    ->orderBy('id', 'desc')
                    ->paginate(7);
            } else {
                $video_list = Video::select('*')
                    ->with('type')
                    ->orderBy('id', 'desc')
                    ->paginate(7);
            }
            $type = Type::where('type', 1)->get();

            return view('admin.video.index', ['result' => $video_list, 'type' => $type]);
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
            $type = Type::select('*')->where('type', 1)->get();
            $cast = Cast::select('*')->get();

            return view('admin.video.add', ['channel' => $channel, 'category' => $category, 'language' => $language, 'cast' => $cast, 'type' => $type]);
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

    public function save(Request $request)
    {
        try {
            if ($request->video_upload_type == "server_video") {
                $validator = Validator::make($request->all(), [
                    'name' => 'required|min:2',
                    'category_id' => 'required',
                    'language_id' => 'required',
                    'cast_id' => 'required',
                    'type_id' => 'required',
                    'video_upload_type' => 'required',
                    'description' => 'required',
                    'video_duration' => 'required|after_or_equal:00:00:01',
                    'is_premium' => 'required',
                    'is_title' => 'required',
                    'upload_video_320' => 'required',
                    'thumbnail' => 'image|mimes:jpeg,png,jpg|max:2048',
                    'landscape' => 'image|mimes:jpeg,png,jpg|max:2048',
                ]);
            } else {
                $validator = Validator::make($request->all(), [
                    'name' => 'required|min:2',
                    'category_id' => 'required',
                    'language_id' => 'required',
                    'cast_id' => 'required',
                    'type_id' => 'required',
                    'video_upload_type' => 'required',
                    'description' => 'required',
                    'video_duration' => 'required|after_or_equal:00:00:01',
                    'is_premium' => 'required',
                    'is_title' => 'required',
                    'video_url_320' => 'required',
                    'thumbnail' => 'image|mimes:jpeg,png,jpg|max:2048',
                    'landscape' => 'image|mimes:jpeg,png,jpg|max:2048',
                ]);
            }
            if ($validator->fails()) {
                $errs = $validator->errors()->all();
                return response()->json(array('status' => 400, 'errors' => $errs));
            } else {

                $category_id = implode(',', $request->category_id);
                $language_id = implode(',', $request->language_id);
                $cast_id = implode(',', $request->cast_id);

                $video = new Video();
                $video->name = $request->name;
                $video->channel_id = isset($request->channel_id) ? $request->channel_id : 0;
                $video->category_id = $category_id;
                $video->language_id = $language_id;
                $video->cast_id = $cast_id;
                $video->video_type = 1;
                $video->video_upload_type = $request->video_upload_type;
                $video->is_premium = $request->is_premium;
                $video->description = $request->description;
                $video->video_duration = TimeToMilliseconds($request->video_duration);
                $video->is_title = $request->is_title;
                $video->trailer_url = isset($request->trailer_url) ? $request->trailer_url : '';
                $video->type_id = $request->type_id;
                $video->view = 0;
                $video->status = "1";

                if ($request->video_upload_type == "server_video" || $request->video_upload_type == "external") {
                    $video->download = $request->download;
                } else {
                    $video->download = 0;
                }

                if ($request->video_upload_type == "server_video") {

                    $video->video_320 = isset($request->upload_video_320) ? $request->upload_video_320 : '';
                    $video->video_480 = isset($request->upload_video_480) ? $request->upload_video_480 : '';
                    $video->video_720 = isset($request->upload_video_720) ? $request->upload_video_720 : '';
                    $video->video_1080 = isset($request->upload_video_1080) ? $request->upload_video_1080 : '';
                } else {

                    $video->video_320 = isset($request->video_url_320) ? $request->video_url_320 : '';
                    $video->video_480 = isset($request->video_url_480) ? $request->video_url_480 : '';
                    $video->video_720 = isset($request->video_url_720) ? $request->video_url_720 : '';
                    $video->video_1080 = isset($request->video_url_1080) ? $request->video_url_1080 : '';
                }

                $video->subtitle_type = isset($request->subtitle_type) ? $request->subtitle_type : '';
                if ($request->subtitle_type == "server_file") {
                    $video->subtitle = isset($request->subtitle) ? $request->subtitle : '';
                } else {
                    $video->subtitle = isset($request->subtitle_url) ? $request->subtitle_url : '';
                }

                $video->director_id = "";
                $video->starring_id = "";
                $video->supporting_cast_id = "";
                $video->networks = "";
                $video->maturity_rating = "";
                $video->release_year = isset($request->release_year) ? $request->release_year : '';
                $video->age_restriction = "";
                $video->max_video_quality = "";
                $video->imdb_rating = isset($request->imdb_rating) ? $request->imdb_rating : 0;
                $video->release_tag = "";
                $array = explode('.', $request->upload_video_320);
                $video->video_extension = end($array);

                $org_name = $request->file('thumbnail');
                if ($org_name != null && isset($org_name)) {
                    $video->thumbnail = saveImage($org_name, $this->folder);
                } elseif ($request->thumbnail_imdb) {
                    $url = $request->thumbnail_imdb;
                    $S_Name = URLSaveInImage($url, $this->folder);
                    $video->thumbnail = $S_Name;
                } else {
                    $video->thumbnail = "";
                }

                $org_name1 = $request->file('landscape');
                if ($org_name1 != null && isset($org_name1)) {
                    $video->landscape = saveImage_landscape($org_name1, $this->folder);
                } elseif ($request->landscape_imdb) {
                    $url = $request->landscape_imdb;
                    $S_Name = URLSaveInImage_landscape($url, $this->folder);
                    $video->landscape = $S_Name;
                } else {
                    $video->landscape = "";
                }

                if ($video->save()) {

                    // Send Notification
                    $imageURL = Get_Image('video') . $video->thumbnail;
                    $noti_array =array(
                        'id' => $video->id,
                        'name' => $video->name,
                        'image' => $imageURL,
                        'video_type' => $video->video_type,
                        'type_id' => $video->type_id,
                        'description' => string_cut($video->description, 90),
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

    public function detail($id)
    {
        try {
            $detail = Video::where('id', $id)->first();
            $x = explode(",", $detail->category_id);
            $y = explode(",", $detail->language_id);
            $z = explode(",", $detail->cast_id);

            $channel = Channel::select('name')->where('id', $detail->channel_id)->first();
            $category = Category::select('name')->whereIn('id', $x)->get();
            $language = Language::select('name')->whereIn('id', $y)->get();
            $cast = Cast::select('name', 'type')->whereIn('id', $z)->get();

            return view('admin.video.detail_page', ['tvshow' => $detail, 'channel' => $channel, 'category' => $category, 'language' => $language, 'cast' => $cast]);
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

    public function edit($id)
    {
        try {
            $TVShow = Video::where('id', $id)->first();

            $channel = Channel::select('*')->get();
            $category = Category::select('*')->get();
            $language = Language::select('*')->get();
            $type = Type::select('*')->where('type', 1)->get();
            $cast = Cast::select('*')->get();

            return view('admin.video.edit', ['result' => $TVShow, 'type' => $type, 'channel' => $channel, 'category' => $category, 'language' => $language, 'cast' => $cast]);
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

    public function update(Request $request)
    {
        try {
            if ($request->video_upload_type == "server_video") {
                $validator = Validator::make($request->all(), [
                    'name' => 'required|min:2',
                    'category_id' => 'required',
                    'language_id' => 'required',
                    'cast_id' => 'required',
                    'type_id' => 'required',
                    'video_upload_type' => 'required',
                    'description' => 'required',
                    'video_duration' => 'required|after_or_equal:00:00:01',
                    'is_premium' => 'required',
                    'is_title' => 'required',
                    'thumbnail' => 'image|mimes:jpeg,png,jpg|max:2048',
                    'landscape' => 'image|mimes:jpeg,png,jpg|max:2048',
                ]);
            } else {
                $validator = Validator::make($request->all(), [
                    'name' => 'required|min:2',
                    'category_id' => 'required',
                    'language_id' => 'required',
                    'cast_id' => 'required',
                    'type_id' => 'required',
                    'video_upload_type' => 'required',
                    'description' => 'required',
                    'video_duration' => 'required|after_or_equal:00:00:01',
                    'is_premium' => 'required',
                    'is_title' => 'required',
                    'thumbnail' => 'image|mimes:jpeg,png,jpg|max:2048',
                    'landscape' => 'image|mimes:jpeg,png,jpg|max:2048',
                ]);
            }

            if ($validator->fails()) {
                $errs = $validator->errors()->all();
                return response()->json(array('status' => 400, 'errors' => $errs));
            } else {

                $category_id = implode(',', $request->category_id);
                $language_id = implode(',', $request->language_id);
                $cast_id = implode(',', $request->cast_id);

                $video = Video::where('id', $request->id)->first();

                if (isset($video->id)) {
                    $video->name = $request->name;
                    $video->channel_id = isset($request->channel_id) ? $request->channel_id : 0;
                    $video->category_id = $category_id;
                    $video->language_id = $language_id;
                    $video->cast_id = $cast_id;
                    $video->type_id = $request->type_id;
                    $video->video_type = 1;
                    $video->video_upload_type = $request->video_upload_type;
                    $video->description = $request->description;
                    $video->video_duration = TimeToMilliseconds($request->video_duration);
                    $video->is_premium = $request->is_premium;
                    $video->is_title = $request->is_title;
                    $video->trailer_url = isset($request->trailer_url) ? $request->trailer_url : '';

                    if ($request->video_upload_type == "server_video" || $request->video_upload_type == "external") {
                        $video->download = $request->download;
                    } else {
                        $video->download = 0;
                    }

                    if ($request->video_upload_type == "server_video") {

                        if ($request->upload_video_320) {
                            $video->video_320 = $request->upload_video_320;
                            @unlink("images/video/" . $request->old_video_320);
                        }
                        if ($request->upload_video_480) {
                            $video->video_480 = $request->upload_video_480;
                            @unlink("images/video/" . $request->old_video_480);
                        }
                        if ($request->upload_video_720) {
                            $video->video_720 = $request->upload_video_720;
                            @unlink("images/video/" . $request->old_video_720);
                        }
                        if ($request->upload_video_1080) {
                            $video->video_1080 = $request->upload_video_1080;
                            @unlink("images/video/" . $request->old_video_1080);
                        }
                    } else {

                        if ($request->video_url_320) {
                            $video->video_320 = $request->video_url_320;
                        }
                        if ($request->video_url_480) {
                            $video->video_480 = $request->video_url_480;
                        }
                        if ($request->video_url_720) {
                            $video->video_720 = $request->video_url_720;
                        }
                        if ($request->video_url_1080) {
                            $video->video_1080 = $request->video_url_1080;
                        }
                    }

                    $video->subtitle_type = isset($request->subtitle_type) ? $request->subtitle_type : '';
                    @unlink("images/video/" . $request->old_subtitle);
                    if ($request->subtitle_type == "server_file") {
                        if ($request->subtitle) {
                            $video->subtitle = $request->subtitle;
                        }
                    } else {
                        if ($request->subtitle_url) {
                            $video->subtitle = $request->subtitle_url;
                        }
                    }

                    $org_name = $request->file('thumbnail');
                    if ($org_name != null && isset($org_name)) {
                        $video->thumbnail = saveImage($org_name, $this->folder);
                        @unlink("images/video/" . $request->old_thumbnail);
                    } elseif ($request->thumbnail_imdb) {
                        $url = $request->thumbnail_imdb;
                        $S_Name = URLSaveInImage($url, $this->folder);
                        $video->thumbnail = $S_Name;
                        @unlink("images/video/" . $request->old_thumbnail);
                    }

                    $org_name1 = $request->file('landscape');
                    if ($org_name1 != null && isset($org_name1)) {
                        $video->landscape = saveImage_landscape($org_name1, $this->folder);
                        @unlink("images/video/" . $request->old_landscape);
                    } elseif ($request->landscape_imdb) {
                        $url = $request->landscape_imdb;
                        $S_Name = URLSaveInImage_landscape($url, $this->folder);
                        $video->landscape = $S_Name;
                        @unlink("images/video/" . $request->old_landscape);
                    }

                    $video->release_year = isset($request->release_year) ? $request->release_year : '';
                    $video->imdb_rating = isset($request->imdb_rating) ? $request->imdb_rating : 0;
                    
                    if ($video->save()) {
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
            $video = Video::where('id', $id)->first();
            $App_Section = App_Section::whereRaw("find_in_set('" . $video->id . "',app_section.video_id)")->first();
            $Channel_Section = Channel_Section::whereRaw("find_in_set('" . $video->id . "',channel_section.video_id)")->first();

            if ($App_Section) {
                return back()->with('error', "This Video is used on some other table so you can not remove it.");
            } elseif ($Channel_Section) {
                return back()->with('error', "This Video is used on some other table so you can not remove it.");
            } else {
                if ($video->delete()) {
                    @unlink("images/video/" . $video->thumbnail);
                    @unlink("images/video/" . $video->landscape);
                    @unlink("images/video/" . $video->video);
                    @unlink("images/video/" . $video->video_320);
                    @unlink("images/video/" . $video->video_480);
                    @unlink("images/video/" . $video->video_720);
                    @unlink("images/video/" . $video->video_1080);
                    @unlink("images/video/" . $video->subtitle);
                    return back()->with('success', __('Label.Data Delete Successfully'));
                }
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

    public function saveChunk()
    {

        @set_time_limit(5 * 60);

        $targetDir = public_path('/images/video');

        //$targetDir = 'uploads';

        $cleanupTargetDir = true; // Remove old files

        $maxFileAge = 5 * 3600; // Temp file age in seconds

        // Create target dir
        if (!file_exists($targetDir)) {
            @mkdir($targetDir);
        }

        // Get a file name
        if (isset($_REQUEST["name"])) {
            $fileName = $_REQUEST["name"];
        } elseif (!empty($_FILES)) {
            $fileName = $_FILES["file"]["name"];
        } else {
            $fileName = uniqid("file_");
        }
        $category_image = $fileName;
        $filePath = $targetDir . DIRECTORY_SEPARATOR . $category_image;
        // Chunking might be enabled

        $chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
        $chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;
        // Remove old temp files

        if ($cleanupTargetDir) {
            if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
            }

            while (($file = readdir($dir)) !== false) {
                $tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;
                // If temp file is current file proceed to the next
                if ($tmpfilePath == "{$filePath}.part") {
                    continue;
                }

                // Remove temp file if it is older than the max age and is not the current file
                if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge)) {
                    @unlink($tmpfilePath);
                }
            }
            closedir($dir);
        }

        // Open temp file

        if (!$out = @fopen("{$filePath}.part", $chunks ? "ab" : "wb")) {
            die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
        }

        if (!empty($_FILES)) {
            if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
            }

            // Read binary input stream and append it to temp file
            if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
            }
        } else {
            if (!$in = @fopen("php://input", "rb")) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
            }
        }

        while ($buff = fread($in, 4096)) {
            fwrite($out, $buff);
        }

        @fclose($out);
        @fclose($in);
        // Check if file has been uploaded
        if (!$chunks || $chunk == $chunks - 1) {
            // Strip the temp .part suffix off
            rename("{$filePath}.part", $filePath);
        }
        // Return Success JSON-RPC response
        die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');
    }

    public function SerachName($txtVal)
    {
        try {
            $imdbTitle = $txtVal;

            if (strlen($imdbTitle) >= 3) {
                $url = 'http://www.omdbapi.com/?apikey=apikey&type=movie&s=' . $imdbTitle;
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
            $url = 'http://www.omdbapi.com/?apikey=apikey&type=movie&i=' . $imdbID;
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

            // Duration
            if (isset($movies['Runtime'])) {
                $Duration = GetMiniteToFormate($movies['Runtime']);
            } else {
                $Duration = "00:00:00";
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

            return response()->json(array('status' => 200, 'C_Id' => $C_Id, 'L_Id' => $L_Id, 'C_Insert_Data' => $C_Insert_Data, 'L_Insert_Data' => $L_Insert_Data, 'Poster_img' => $Poster_img, 'Description' => $Description, 'Cast_Id' => $Cast_Id, 'Cast_Insert_Data' => $Cast_Insert_Data, 'Duration' => $Duration, 'Year' => $Year, 'imdbRating' => $imdbRating));
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

}
