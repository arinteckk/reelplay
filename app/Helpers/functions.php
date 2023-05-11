<?php

use GuzzleHttp\Client;

function adminEmail()
{
    return $emails = \App\Models\Admin::select('user_name', 'email')->first();
}
function setting_app_name()
{
    $setting = \App\Models\General_Setting::get();
    $data = [];
    foreach ($setting as $value) {
        $data[$value->key] = $value->value;
    }
    return $data['app_name'];
}
function no_format($num)
{
    if ($num > 1000) {
        $x = round($num);
        $x_number_format = number_format($x);
        $x_array = explode(',', $x_number_format);
        $x_parts = array('k', 'm', 'b', 't');
        $x_count_parts = count($x_array) - 1;
        $x_display = $x;
        $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
        $x_display .= $x_parts[$x_count_parts - 1];

        return $x_display;
    }
    return $num;
}
function setting_app_logo()
{
    $setting = \App\Models\General_Setting::get();
    $data = [];
    foreach ($setting as $value) {
        $data[$value->key] = $value->value;
    }
    return $data['app_logo'];
}
function saveImage($org_name, $folder)
{
    $img_ext = $org_name->getClientOriginalExtension();
    $filename = time() . '.' . $img_ext;
    $path = $org_name->move(public_path('images/' . $folder), $filename);
    return $filename;
}
function saveImage_landscape($org_name1, $subfolder)
{
    $img_ext1 = $org_name1->getClientOriginalExtension();
    $filename1 = 'land_' . time() . '.' . $img_ext1;
    $path1 = $org_name1->move(public_path('images/' . $subfolder), $filename1);
    return $filename1;
}
function package_detail($Pid)
{
    App\Models\Package_Detail::where('package_id', $Pid)->delete();

    $Pdata = App\Models\Package::where('id', $Pid)->first();
    $type = App\Models\Type::whereIn('id', explode(",", $Pdata->type_id))->get();

    for ($i = 0; $i < count($type); $i++) {
        $type_name[] = $type[$i]->name;
    }

    $type_name_data = implode(',', $type_name);
    if ($type_name_data) {
        $type_name_data_status = 1;
    } else {
        $type_name_data_status = 0;
    }

    $Pdetail = App\Models\Package_Detail::insert([
        ['package_id' => $Pdata->id, 'package_key' => "All Content", 'package_value' => $Pdata->status],
        ['package_id' => $Pdata->id, 'package_key' => $type_name_data, 'package_value' => $type_name_data_status],
        ['package_id' => $Pdata->id, 'package_key' => "Watch on tv or laptop ", 'package_value' => $Pdata->watch_on_laptop_tv],
        ['package_id' => $Pdata->id, 'package_key' => "Ads free movies and shows (except sports)", 'package_value' => $Pdata->ads_free_movies_shows],
        ['package_id' => $Pdata->id, 'package_key' => "number of devices that can be logged in", 'package_value' => $Pdata->no_of_device],
        ['package_id' => $Pdata->id, 'package_key' => "max video quality", 'package_value' => $Pdata->video_qulity],
    ]);
    return "Success";
}
function lang()
{
    $lang = \App\Models\Language::get();
    return $lang;
}

function currency_code()
{
    $setting = \App\Models\General_Setting::get();
    $data = [];
    foreach ($setting as $value) {
        $data[$value->key] = $value->value;
    }
    return $data['currency_code'];
}

// Web Function
function GetHeaderType()
{

    $RequestMethod = "POST";
    $URL = Config::get('app.api_url') . "get_type";

    $headers = [
        'Content-Type' => "application/json",
        'auth_token' => "jQfq4I2q6lv",
    ];

    $client = new Client();
    // $response = $client->request($RequestMethod, $URL, $headers);
    $response = Http::withHeaders($headers)->post($URL);

    $statusCode = $response->getStatusCode();
    $content = json_decode($response->getBody(), true);
    // dd($content);

    if ($content['status'] == 200 && $content['result'] != null) {
        return $content;
    } else {
        abort(503);
    }
}

function GetDataWithParamter($URL, $RequestMethod, $json = [])
{

    $headers = [
        'Content-Type' => "application/json",
        'auth_token' => "jQfq4I2q6lv",
    ];

    $client = new Client();
    // $response = $client->request($RequestMethod, $URL, $json);
    $response = Http::withHeaders($headers)->post($URL, $json);

    $statusCode = $response->getStatusCode();
    if ($statusCode == 200 && $statusCode != null) {
        $content = json_decode($response->getBody(), true);
        return $content;
    } else {
        abort(503);
    }
}

// Easy to string cut and check start and end number
function string_cut($string, $len)
{
    if (strlen($string) > $len) {
        $string = mb_substr(strip_tags($string), 0, $len, 'utf-8') . '...';
        // $string = substr(strip_tags($string),0,$len).'...';
    }
    return $string;
}

function Get_Image($folder = "", $name = "")
{
    $data = Config::get('app.image_url') . $folder . '/' . $name;
    return ($data);
}

function TimeToMilliseconds($str)
{

    $time = explode(":", $str);

    $hour = (int) $time[0] * 60 * 60 * 1000;
    $minute = (int) $time[1] * 60 * 1000;
    $sec = (int) $time[2] * 1000;
    $result = $hour + $minute + $sec;
    return $result;
}

function MillisecondsToTime($str)
{
    $Seconds = (int) $str / 1000;
    $Seconds = round($Seconds);

    $Format = sprintf('%02d:%02d:%02d', ((int) $Seconds / 3600), ((int) $Seconds / 60 % 60), ((int) $Seconds) % 60);
    return $Format;
}

function Web_MillisecondsToTime($str)
{
    $Seconds = (int) $str / 1000;
    $Seconds = round($Seconds);
    $Format = round($Seconds / 3600) . " " . "h" . " " . round($Seconds / 60 % 60) . " " . "min";
    return $Format;
}

function GetContinueWatchingTime($TotalTime, $StopTime)
{
    $TotalMinutes = (int) $TotalTime / 60000;
    $TotalStopMinutes = (int) $StopTime / 60000;

    if ($TotalMinutes < $TotalStopMinutes) {
        return (int) $TotalMinutes . " " . "of" . " " . (int) $TotalMinutes . " " . "min";
    } else {
        return (int) $TotalStopMinutes . " " . "of" . " " . (int) $TotalMinutes . " " . "min";
    }
}

function TimeToPercentage($TotalTime, $StopTime)
{
    if ($TotalTime != 0 && $StopTime != 0 && $TotalTime != $StopTime) {
        $per = (int) $StopTime * 100 / (int) $TotalTime;
        return $per . "%";
    } else {
        return "0%";
    }
}

function continue_watching($TotalTime, $StopTime)
{
    $Left_Time = $TotalTime - $StopTime;

    if ($Left_Time > 0) {

        $Seconds = (int) floor($Left_Time / 1000);
        $Minutes = (int) floor($Seconds / 60);
        $hours = (int) floor($Minutes / 60);

        $Seconds = $Seconds % 60;
        $Minutes = $Seconds >= 30 ? $Minutes + 1 : $Minutes;
        $Minutes = $Minutes % 60;
        $hours = $hours % 24;

        if ($hours == 0) {
            return $Minutes . " " . "min" . " " . $Seconds . " " . "sec" . " " . "left";
        }
        return $hours . " " . "hour" . " " . $Minutes . " " . "min" . " " . $Seconds . " " . "sec" . " " . "left";
    }
}

function APIResponse($status, $message, $result = "")
{
    $data['status'] = $status;
    $data['message'] = $message;

    if ($result != "") {
        if (isset($result)) {
            $data['result'] = $result;
        }
    }

    return $data;
}

function GetCategoryNameById($id)
{
    $data = \App\Models\Category::select('id', 'name')->where('id', $id)->first();
    if (!empty($data)) {
        return $data['name'];
    } else {
        return "";
    }
}

function GetCategoryNameByIds($ids)
{
    $Ids = explode(',', $ids);
    $data = \App\Models\Category::select('id', 'name')->whereIn('id', $Ids)->get();

    if (count($data) > 0) {

        foreach ($data as $key => $value) {
            $final_data[] = $value['name'];
        }

        $IDs = implode(", ", $final_data);
        return $IDs;
    } else {
        return "";
    }
}

function GetCastNameByIds($ids)
{
    $Ids = explode(',', $ids);
    $data = \App\Models\Cast::select('id', 'name')->whereIn('id', $Ids)->get();

    if (count($data) > 0) {

        foreach ($data as $key => $value) {
            $final_data[] = $value['name'];
        }

        $IDs = implode(", ", $final_data);
        return $IDs;
    } else {
        return "";
    }
}

function IsRentVideo($id, $video_type)
{
    $data = \App\Models\RentVideo::where('video_id', $id)->where('video_type', $video_type)->where('status', 1)->first();
    if (!empty($data)) {
        return 1;
    } else {
        return 0;
    }
}

function GetPriceByRentVideo($id, $video_type)
{
    $data = \App\Models\RentVideo::select('id', 'price')->where('video_id', $id)->where('video_type', $video_type)->where('status', 1)->first();
    if (!empty($data)) {
        return $data['price'];
    } else {
        return 0;
    }
}

function GetSessionByTVShowId($id)
{
    $data = \App\Models\TVShowVideo::select('session_id')->groupBy('session_id')->where('show_id', $id)->get();
    if (count($data) > 0) {

        foreach ($data as $key => $value) {
            $final_data[] = $value['session_id'];
        }
        $return = implode(",", $final_data);
        return $return;

    } else {
        return $return = "";
    }
}

function GetStopTimeByUser($user_id, $video_id, $type_id, $video_type)
{
    $data = \App\Models\Video_Watch::select('id', 'stop_time')->where('user_id', $user_id)->where('video_id', $video_id)->where('video_type', $video_type)->where('status', '1')->first();
    if (!empty($data)) {
        return (int) $data['stop_time'];
    } else {
        return 0;
    }
}

function Is_DownloadByUser($user_id, $video_id, $type_id, $video_type, $other_id = "0")
{
    $data = \App\Models\Download::where('user_id', $user_id)->where('video_id', $video_id)->where('type_id', $type_id)->where('video_type', $video_type)->where('other_id', $other_id)->first();
    if (!empty($data)) {
        return 1;
    } else {
        return 0;
    }
}

function Is_BookmarkByUser($user_id, $video_id, $type_id, $video_type)
{
    $data = \App\Models\Bookmark::where('user_id', $user_id)->where('video_id', $video_id)->where('type_id', $type_id)->where('video_type', $video_type)->where('status', 1)->first();
    if (!empty($data)) {
        return 1;
    } else {
        return 0;
    }
}

function VideoRentBuyByUser($user_id, $video_id, $type_id, $video_type)
{
    $all_data = \App\Models\RentTransction::get();
    for ($i = 0; $i < count($all_data); $i++) {
        if ($all_data[$i]['expiry_date'] < date("Y-m-d")) {
            $all_data[$i]->status = 0;
            $all_data[$i]->save();
        }
    }

    $data = \App\Models\RentTransction::where('user_id', $user_id)->where('video_id', $video_id)->where('type_id', $type_id)->where('video_type', $video_type)->where('status', 1)->first();
    if (!empty($data)) {
        return 1;
    } else {
        return 0;
    }
}

function IsBuyByUser($user_id)
{
    $all_data = \App\Models\Transction::get();
    for ($i = 0; $i < count($all_data); $i++) {
        if ($all_data[$i]['expiry_date'] <= date("Y-m-d")) {
            $all_data[$i]->status = '0';
            $all_data[$i]->save();
        }
    }

    $data = \App\Models\Transction::where('user_id', $user_id)->where('status', '1')->first();
    if (!empty($data)) {
        return 1;
    } else {
        return 0;
    }
}

function curl($url)
{
    $some_data = array();
    $curl = curl_init();
    // We POST the data
    curl_setopt($curl, CURLOPT_POST, 1);
    // Set the url path we want to call
    curl_setopt($curl, CURLOPT_URL, $url);
    // Make it so the data coming back is put into a string
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    // Insert the data
    curl_setopt($curl, CURLOPT_POSTFIELDS, $some_data);

    $result = curl_exec($curl);
    // Free up the resources $curl is using
    curl_close($curl);

    return (array) json_decode($result);
}

function GetMiniteToFormate($minute)
{
    $Time = explode(" ", $minute);
    $init = $Time[0];
    if ($init != "N/A") {

        $format = '%02d:%02d:%02d';

        $hours = floor($init / 60);
        $minutes = ($init % 60);
        $second = 00;

        return sprintf($format, $hours, $minutes, $second);
    } else {
        return "00:00:00";
    }

}

function URLSaveInImage($url, $folder)
{
    $ext = pathinfo($url);
    $image_name = rand(10, 100) . '_' . time() . '.' . $ext['extension'];
    $path = public_path() . '/' . 'images/' . $folder . '/';

    file_put_contents($path . $image_name, file_get_contents($url));
    return $image_name;
}

function URLSaveInImage_landscape($url, $folder)
{
    $ext = pathinfo($url);
    $image_name = 'land_' . time() . '.' . $ext['extension'];
    $path = public_path() . '/' . 'images/' . $folder . '/';

    file_put_contents($path . $image_name, file_get_contents($url));
    return $image_name;

}

function Paytm($data)
{

    $option = \App\Models\Payment_Option::get();
    foreach ($option as $key => $value) {
        if ($value['name'] == "paytm") {
            $payment_data = $value;
        }
    }

    if (isset($payment_data) && $payment_data['visibility'] == 1) {

        if ($payment_data['is_live'] == 1) {
            $M_id = $payment_data['live_key_1'];
            $M_Key = $payment_data['live_key_2'];
        } else {
            $M_id = $payment_data['test_key_1'];
            $M_Key = $payment_data['test_key_2'];
        }

        /* import checksum generation utility */
        require_once base_path() . '/vendor/paytm/paytmchecksum/PaytmChecksum.php';

        /* initialize an array */
        $paytmParams = array();

        /* add parameters in Array */
        $paytmParams["requestType"] = "Payment";
        $paytmParams["MID"] = $M_id;
        $paytmParams["ORDERID"] = $data['order_id'];
        $paytmParams["callbackUrl"] = $data['CALLBACK_URL'];
        $paytmParams["custId"] = $data['CUST_ID'];
        $paytmParams["txnAmount"] = $data['TXN_AMOUNT'];
        $paytmParams["websiteName"] = $data['WEBSITE'];

        /**
         * Generate checksum by parameters we have
         * Find your Merchant Key in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys
         */
        $paytmChecksum = PaytmChecksum::generateSignature($paytmParams, $M_Key);
        return $paytmChecksum;
    } else {
        return "";
    }
}

function sendNotification($array)
{
    $noty = \App\Models\General_Setting::where('key', 'onesignal_apid')->orWhere('key', 'onesignal_rest_key')->get();
    $notification = [];
    foreach ($noty as $row) {
        $notification[$row->key] = $row->value;
    }

    $ONESIGNAL_APP_ID = $notification['onesignal_apid'];
    $ONESIGNAL_REST_KEY = $notification['onesignal_rest_key'];

    $content = array(
        "en" => $array['description'],
    );

    $fields = array(
        'app_id' => $ONESIGNAL_APP_ID,
        'included_segments' => array('All'),
        'data' => $array,
        'headings' => array("en" => $array['name']),
        'contents' => $content,
        'big_picture' => $array['image'],
    );

    $fields = json_encode($fields);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; charset=utf-8',
        'Authorization: Basic ' . $ONESIGNAL_REST_KEY,
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);
    // dd($response);
    curl_close($ch);
}
