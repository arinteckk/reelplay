<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Channel;
use App\Models\Channel_Banner;
use App\Models\Channel_Section;
use App\Models\TVShow;
use App\Models\Video;
use Illuminate\Http\Request;

class ChannelController extends Controller
{
    private $folder = "language";
    private $folder1 = "cast";
    private $folder2 = "category";
    private $folder3 = "video";
    private $folder4 = "show";
    private $folder5 = "channel";
    private $folder6 = "app";
    private $folder7 = "user";
    private $folder8 = "avatar";

    public function get_channel()
    {
        try {
            $Data = Channel::latest()->get();
            if (sizeof($Data) > 0) {

                for ($i = 0; $i < count($Data); $i++) {

                    if (!empty($Data[$i]['image'])) {
                        $path = Get_Image($this->folder5, $Data[$i]['image']);
                        $Data[$i]['image'] = $path;
                    } else {
                        $Data[$i]['image'] = asset('/assets/imgs/no_img.png');
                    }
                    if (!empty($Data[$i]['landscape'])) {
                        $path = Get_Image($this->folder5, $Data[$i]['landscape']);
                        $Data[$i]['landscape'] = $path;
                    } else {
                        $Data[$i]['landscape'] = asset('/assets/imgs/no_img.png');
                    }
                    $Data[$i]['status'] = (int) $Data[$i]['status'];
                }
                return APIResponse(200, __('api_msg.get_record_successfully'), $Data);
            } else {
                return APIResponse(400, __('api_msg.data_not_found'));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

    public function channel_section_list(Request $request)
    {
        try {

            $user_id = isset($request->user_id) ? $request->user_id : 0;
            $data = Channel_Section::with('channel')->latest()->get();
            if (count($data) > 0) {

                for ($i = 0; $i < count($data); $i++) {

                    $data[$i]['data'] = [];

                    // Channel_Name
                    if ($data[$i]['channel'] != null) {
                        $data[$i]['channel_name'] = $data[$i]['channel']['name'];
                    } else {
                        $data[$i]['channel_name'] = "";
                    }
                    unset($data[$i]['channel']);

                    if ($data[$i]['video_type'] == '1') {

                        $Ids = explode(',', $data[$i]['video_id']);
                        $video_data = Video::whereIn('id', $Ids)->latest()->get();

                        if (count($video_data) > 0) {

                            $data[$i]['data'] = $video_data;
                            for ($j = 0; $j < count($video_data); $j++) {

                                // Thumbnail
                                if (!empty($data[$i]['data'][$j]['thumbnail'])) {
                                    $path = Get_Image($this->folder3, $data[$i]['data'][$j]['thumbnail']);
                                    $data[$i]['data'][$j]['thumbnail'] = $path;
                                } else {
                                    $data[$i]['data'][$j]['thumbnail'] = asset('/assets/imgs/no_img.png');
                                }
                                // Landscape
                                if (!empty($data[$i]['data'][$j]['landscape'])) {
                                    $path = Get_Image($this->folder3, $data[$i]['data'][$j]['landscape']);
                                    $data[$i]['data'][$j]['landscape'] = $path;
                                } else {
                                    $data[$i]['data'][$j]['landscape'] = asset('/assets/imgs/no_img.png');
                                }
                                // Video
                                if (!empty($data[$i]['data'][$j]['video'])) {
                                    $path = Get_Image($this->folder3, $data[$i]['data'][$j]['video']);
                                    $data[$i]['data'][$j]['video'] = $path;
                                }
                                // Video_320
                                if (isset($data[$i]['data'][$j]['video_320']) && !empty($data[$i]['data'][$j]['video_320'])) {
                                    if ($data[$i]['data'][$j]['video_upload_type'] == "server_video") {
                                        $path = Get_Image($this->folder3, $data[$i]['data'][$j]['video_320']);
                                        $data[$i]['data'][$j]['video_320'] = $path;
                                    } else {
                                        $data[$i]['data'][$j]['video_320'] = $data[$i]['data'][$j]['video_320'];
                                    }
                                } else {
                                    $data[$i]['data'][$j]['video_320'] = "";
                                }
                                // Video_480
                                if (isset($data[$i]['data'][$j]['video_480']) && !empty($data[$i]['data'][$j]['video_480'])) {
                                    if ($data[$i]['data'][$j]['video_upload_type'] == "server_video") {
                                        $path = Get_Image($this->folder3, $data[$i]['data'][$j]['video_480']);
                                        $data[$i]['data'][$j]['video_480'] = $path;
                                    } else {
                                        $data[$i]['data'][$j]['video_480'] = $data[$i]['data'][$j]['video_480'];
                                    }
                                } else {
                                    $data[$i]['data'][$j]['video_480'] = "";
                                }
                                // Video_720
                                if (isset($data[$i]['data'][$j]['video_720']) && !empty($data[$i]['data'][$j]['video_720'])) {
                                    if ($data[$i]['data'][$j]['video_upload_type'] == "server_video") {
                                        $path = Get_Image($this->folder3, $data[$i]['data'][$j]['video_720']);
                                        $data[$i]['data'][$j]['video_720'] = $path;
                                    } else {
                                        $data[$i]['data'][$j]['video_720'] = $data[$i]['data'][$j]['video_720'];
                                    }
                                } else {
                                    $data[$i]['data'][$j]['video_720'] = "";
                                }
                                // Video_1080
                                if (isset($data[$i]['data'][$j]['video_1080']) && !empty($data[$i]['data'][$j]['video_1080'])) {
                                    if ($data[$i]['data'][$j]['video_upload_type'] == "server_video") {
                                        $path = Get_Image($this->folder3, $data[$i]['data'][$j]['video_1080']);
                                        $data[$i]['data'][$j]['video_1080'] = $path;
                                    } else {
                                        $data[$i]['data'][$j]['video_1080'] = $data[$i]['data'][$j]['video_1080'];
                                    }
                                } else {
                                    $data[$i]['data'][$j]['video_1080'] = "";
                                }
                                // Subtitle
                                if (isset($data[$i]['data'][$j]['subtitle']) && !empty($data[$i]['data'][$j]['subtitle'])) {
                                    if ($data[$i]['data'][$j]['subtitle_type'] == "server_file") {
                                        $path = Get_Image($this->folder3, $data[$i]['data'][$j]['subtitle']);
                                        $data[$i]['data'][$j]['subtitle'] = $path;
                                    } else {
                                        $data[$i]['data'][$j]['subtitle'] = $data[$i]['data'][$j]['subtitle'];
                                    }
                                } else {
                                    $data[$i]['data'][$j]['subtitle'] = "";
                                }

                                $data[$i]['data'][$j]['stop_time'] = GetStopTimeByUser($user_id, $data[$i]['data'][$j]['id'], $data[$i]['data'][$j]['type_id'], $data[$i]['data'][$j]['video_type']);
                                $data[$i]['data'][$j]['is_downloaded'] = Is_DownloadByUser($user_id, $data[$i]['data'][$j]['id'], $data[$i]['data'][$j]['type_id'], $data[$i]['data'][$j]['video_type']);
                                $data[$i]['data'][$j]['is_bookmark'] = Is_BookmarkByUser($user_id, $data[$i]['data'][$j]['id'], $data[$i]['data'][$j]['type_id'], $data[$i]['data'][$j]['video_type']);
                                $data[$i]['data'][$j]['rent_buy'] = VideoRentBuyByUser($user_id, $data[$i]['data'][$j]['id'], $data[$i]['data'][$j]['type_id'], $data[$i]['data'][$j]['video_type']);
                                $data[$i]['data'][$j]['is_rent'] = IsRentVideo($data[$i]['data'][$j]['id'], $data[$i]['data'][$j]['video_type']);
                                $data[$i]['data'][$j]['rent_price'] = GetPriceByRentVideo($data[$i]['data'][$j]['id'], $data[$i]['data'][$j]['video_type']);
                                $data[$i]['data'][$j]['is_buy'] = IsBuyByUser($user_id);
                                $data[$i]['data'][$j]['category_name'] = GetCategoryNameByIds($data[$i]['data'][$j]['category_id']);
                                $data[$i]['data'][$j]['session_id'] = "0";

                            }
                        } else {
                            $data[$i]['data'] = [];
                        }
                    } elseif ($data[$i]['video_type'] == '2') {

                        $Ids = explode(',', $data[$i]['tv_show_id']);
                        $tvshow_data = TVShow::whereIn('id', $Ids)->latest()->get();

                        if (count($tvshow_data) > 0) {
                            $data[$i]['data'] = $tvshow_data;
                            for ($j = 0; $j < count($tvshow_data); $j++) {

                                // Thumbnail
                                if (!empty($data[$i]['data'][$j]['thumbnail'])) {
                                    $path = Get_Image($this->folder4, $data[$i]['data'][$j]['thumbnail']);
                                    $data[$i]['data'][$j]['thumbnail'] = $path;
                                } else {
                                    $data[$i]['data'][$j]['thumbnail'] = asset('/assets/imgs/no_img.png');
                                }
                                // Landscape
                                if (!empty($data[$i]['data'][$j]['landscape'])) {
                                    $path = Get_Image($this->folder4, $data[$i]['data'][$j]['landscape']);
                                    $data[$i]['data'][$j]['landscape'] = $path;
                                } else {
                                    $data[$i]['data'][$j]['landscape'] = asset('/assets/imgs/no_img.png');
                                }

                                $data[$i]['data'][$j]['stop_time'] = 0;
                                $data[$i]['data'][$j]['is_downloaded'] = 0;
                                $data[$i]['data'][$j]['is_bookmark'] = Is_BookmarkByUser($user_id, $data[$i]['data'][$j]['id'], $data[$i]['data'][$j]['type_id'], $data[$i]['data'][$j]['video_type']);
                                $data[$i]['data'][$j]['rent_buy'] = VideoRentBuyByUser($user_id, $data[$i]['data'][$j]['id'], $data[$i]['data'][$j]['type_id'], $data[$i]['data'][$j]['video_type']);
                                $data[$i]['data'][$j]['is_rent'] = IsRentVideo($data[$i]['data'][$j]['id'], $data[$i]['data'][$j]['video_type']);
                                $data[$i]['data'][$j]['rent_price'] = GetPriceByRentVideo($data[$i]['data'][$j]['id'], $data[$i]['data'][$j]['video_type']);
                                $data[$i]['data'][$j]['is_buy'] = IsBuyByUser($user_id);
                                $data[$i]['data'][$j]['category_name'] = GetCategoryNameByIds($data[$i]['data'][$j]['category_id']);
                                $data[$i]['data'][$j]['session_id'] = GetSessionByTVShowId($data[$i]['data'][$j]['id']);

                            }
                        } else {
                            $data[$i]['data'] = [];
                        }
                    }
                }

                $live_url = Channel_Banner::orderBy('order_no', 'ASC')->get();
                if (count($live_url) > 0) {

                    for ($i = 0; $i < count($live_url); $i++) {

                        $url_data[$i] = $live_url[$i];
                        $Path = Get_Image($this->folder4, $live_url[$i]['image']);
                        $url_data[$i]['image'] = $Path;
                        $url_data[$i]['is_buy'] = IsBuyByUser($user_id);
                    }
                } else {
                    $url_data = [];
                }

                $final_array['status'] = 200;
                $final_array['message'] = __('api_msg.get_record_successfully');
                $final_array['result'] = $data;
                $final_array['live_url'] = $url_data;
                return $final_array;
            } else {
                return APIResponse(400, __('api_msg.data_not_found'));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

}