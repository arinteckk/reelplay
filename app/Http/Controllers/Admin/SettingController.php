<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\General_Setting;
use App\Models\Smtp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;

class SettingController extends Controller
{
    private $folder = "app";

    public function index()
    {
        try {
            $setting = General_Setting::select('*')->get();
            $admin = Admin::select('*')->first();
            $smtp = Smtp::select('*')->first();

            foreach ($setting as $row) {
                $data[$row->key] = $row->value;
            }

            if ($data && $admin && $smtp) {
                return view('admin.setting.index', ['result' => $data, 'admin' => $admin, 'smtp' => $smtp]);
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function app(Request $request)
    {
        try {
            if (Auth::guard('admin')->user()->type != 1) {
                return response()->json(array('status' => 400, 'errors' => __('Label.You have no right to add, edit, and delete')));
            } else {

                $validator = Validator::make($request->all(), [
                    'app_logo' => 'image|mimes:jpeg,png,jpg|max:2048',
                ]);
                if ($validator->fails()) {
                    $errs = $validator->errors()->all();
                    return response()->json(array('status' => 400, 'errors' => $errs));
                }

                $data = $request->all();
                $data["app_name"] = isset($data['app_name']) ? $data['app_name'] : '';
                $data["host_email"] = isset($data['host_email']) ? $data['host_email'] : '';
                $data["app_version"] = isset($data['app_version']) ? $data['app_version'] : '';
                $data["Author"] = isset($data['Author']) ? $data['Author'] : '';
                $data["email"] = isset($data['email']) ? $data['email'] : '';
                $data["contact"] = isset($data['contact']) ? $data['contact'] : '';
                $data["app_desripation"] = isset($data['app_desripation']) ? $data['app_desripation'] : '';
                $data["instrucation"] = isset($data['instrucation']) ? $data['instrucation'] : '';
                $data["privacy_policy"] = isset($data['privacy_policy']) ? $data['host_email'] : '';
                $data["website"] = isset($data['website']) ? $data['website'] : '';

                if (isset($data['app_logo']) && $data['app_logo'] != 'undefined') {
                    $org_name = $request->file('app_logo');
                    $data['app_logo'] = saveImage($org_name, $this->folder);
                    @unlink("images/app/" . $request->old_app_logo);
                } else {
                    if ($request->old_app_logo) {
                        $data['app_logo'] = $request->old_app_logo;
                    } else {
                        $data['app_logo'] = "";
                    }
                }

                foreach ($data as $key => $value) {
                    $setting = General_Setting::where('key', $key)->first();
                    if (isset($setting->id)) {
                        $setting->value = $value;
                        $setting->save();
                    }
                }
                return response()->json(array('status' => 200, 'success' => __('Label.save_setting')));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function changepassword(Request $request)
    {
        try {
            if (Auth::guard('admin')->user()->type != 1) {
                return response()->json(array('status' => 400, 'errors' => __('Label.You have no right to add, edit, and delete')));
            } else {

                $validator = Validator::make($request->all(), [
                    'password' => 'required|min:4',
                    'confirm_password' => 'required|min:4|same:password',
                ]);
                if ($validator->fails()) {
                    $errs = $validator->errors()->all();
                    return response()->json(array('status' => 400, 'errors' => $errs));
                } else {
                    $data = Admin::where('id', $request->admin_id)->first();

                    if (isset($data->id)) {
                        $data->password = Hash::make($request->password);
                        if ($data->save()) {
                            return response()->json(array('status' => 200, 'success' => __('Label.success_change_pass')));
                        } else {
                            return response()->json(array('status' => 400, 'errors' => __('Label.error_change_pass')));
                        }
                    } else {
                        return response()->json(array('status' => 400, 'errors' => "errors"));
                    }
                }
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function smtpindex()
    {
        try {
            $smtp = Smtp::select('*')->first();
            return view('admin.setting.smtp', ['smtp' => $smtp]);
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function smtp(Request $request)
    {
        try {
            if (Auth::guard('admin')->user()->type != 1) {
                return response()->json(array('status' => 400, 'errors' => __('Label.You have no right to add, edit, and delete')));
            } else {
                $validator = Validator::make($request->all(), [
                    'status' => 'required',
                    'host' => 'required',
                    'port' => 'required',
                    'protocol' => 'required',
                    'user' => 'required',
                    'pass' => 'required',
                    'from_name' => 'required',
                    'from_email' => 'required',
                ]);
                if ($validator->fails()) {
                    $errs = $validator->errors()->all();
                    return response()->json(array('status' => 400, 'errors' => $errs));
                } else {
                    $smtp = Smtp::where('id', $request->smtp_id)->first();

                    if (isset($smtp->id)) {
                        $smtp->protocol = $request->protocol;
                        $smtp->host = $request->host;
                        $smtp->port = $request->port;
                        $smtp->user = $request->user;
                        $smtp->pass = $request->pass;
                        $smtp->from_name = $request->from_name;
                        $smtp->from_email = $request->from_email;
                        $smtp->status = $request->status;
                        if ($smtp->save()) {
                            return response()->json(array('status' => 200, 'success' => __('Label.save_setting')));
                        } else {
                            return response()->json(array('status' => 400, 'errors' => __('Label.Data Not Updated')));
                        }
                    }
                }
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function currency(Request $request)
    {
        try {
            if (Auth::guard('admin')->user()->type != 1) {
                return response()->json(array('status' => 400, 'errors' => __('Label.You have no right to add, edit, and delete')));
            } else {
                $data = $request->all();
                $data["currency"] = isset($data['currency']) ? $data['currency'] : '';
                $data["currency_code"] = isset($data['currency_code']) ? $data['currency_code'] : '';

                foreach ($data as $key => $value) {
                    $setting = General_Setting::where('key', $key)->first();
                    if (isset($setting->id)) {
                        $setting->value = $value;
                        $setting->save();
                    }
                }
                return response()->json(array('status' => 200, 'success' => __('Label.save_setting')));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }

    }
    public function admob_android(Request $request)
    {
        try {
            if (Auth::guard('admin')->user()->type != 1) {
                return response()->json(array('status' => 400, 'errors' => __('Label.You have no right to add, edit, and delete')));
            } else {
                $data = $request->all();
                $data["banner_adid"] = isset($data['banner_adid']) ? $data['banner_adid'] : '';
                $data["interstital_adid"] = isset($data['interstital_adid']) ? $data['interstital_adid'] : '';
                $data["reward_adid"] = isset($data['reward_adid']) ? $data['reward_adid'] : '';
                $data["interstital_adclick"] = isset($data['interstital_adclick']) ? $data['interstital_adclick'] : '';
                $data["reward_adclick"] = isset($data['reward_adclick']) ? $data['reward_adclick'] : '';

                foreach ($data as $key => $value) {
                    $setting = General_Setting::where('key', $key)->first();
                    if (isset($setting->id)) {
                        $setting->value = $value;
                        $setting->save();
                    }
                }
                return response()->json(array('status' => 200, 'success' => 'Setting Save'));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function admob_ios(Request $request)
    {
        try {
            if (Auth::guard('admin')->user()->type != 1) {
                return response()->json(array('status' => 400, 'errors' => __('Label.You have no right to add, edit, and delete')));
            } else {
                $data = $request->all();
                $data["ios_banner_adid"] = isset($data['ios_banner_adid']) ? $data['ios_banner_adid'] : '';
                $data["ios_interstital_adid"] = isset($data['ios_interstital_adid']) ? $data['ios_interstital_adid'] : '';
                $data["ios_reward_adid"] = isset($data['ios_reward_adid']) ? $data['ios_reward_adid'] : '';
                $data["ios_interstital_adclick"] = isset($data['ios_interstital_adclick']) ? $data['ios_interstital_adclick'] : '';
                $data["ios_reward_adclick"] = isset($data['ios_reward_adclick']) ? $data['ios_reward_adclick'] : '';

                foreach ($data as $key => $value) {
                    $setting = General_Setting::where('key', $key)->first();
                    if (isset($setting->id)) {
                        $setting->value = $value;
                        $setting->save();
                    }
                }
                return response()->json(array('status' => 200, 'success' => 'Setting Save'));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function facebookad(Request $request)
    {
        try {
            if (Auth::guard('admin')->user()->type != 1) {
                return response()->json(array('status' => 400, 'errors' => __('Label.You have no right to add, edit, and delete')));
            } else {
                $data = $request->all();
                $data["fb_native_id"] = isset($data['fb_native_id']) ? $data['fb_native_id'] : '';
                $data["fb_banner_id"] = isset($data['fb_banner_id']) ? $data['fb_banner_id'] : '';
                $data["fb_interstiatial_id"] = isset($data['fb_interstiatial_id']) ? $data['fb_interstiatial_id'] : '';
                $data["fb_rewardvideo_id"] = isset($data['fb_rewardvideo_id']) ? $data['fb_rewardvideo_id'] : '';
                $data["fb_native_full_id"] = isset($data['fb_native_full_id']) ? $data['fb_native_full_id'] : '';

                foreach ($data as $key => $value) {
                    $setting = General_Setting::where('key', $key)->first();
                    if (isset($setting->id)) {
                        $setting->value = $value;
                        $setting->save();
                    }
                }
                return response()->json(array('status' => 200, 'success' => __('Label.save_setting')));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }

    }
    public function facebookad_ios(Request $request)
    {
        try {
            if (Auth::guard('admin')->user()->type != 1) {
                return response()->json(array('status' => 400, 'errors' => __('Label.You have no right to add, edit, and delete')));
            } else {
                $data = $request->all();
                $data["fb_ios_native_id"] = isset($data['fb_ios_native_id']) ? $data['fb_ios_native_id'] : '';
                $data["fb_ios_banner_id"] = isset($data['fb_ios_banner_id']) ? $data['fb_ios_banner_id'] : '';
                $data["fb_ios_interstiatial_id"] = isset($data['fb_ios_interstiatial_id']) ? $data['fb_ios_interstiatial_id'] : '';
                $data["fb_ios_rewardvideo_id"] = isset($data['fb_ios_rewardvideo_id']) ? $data['fb_ios_rewardvideo_id'] : '';
                $data["fb_ios_native_full_id"] = isset($data['fb_ios_native_full_id']) ? $data['fb_ios_native_full_id'] : '';

                foreach ($data as $key => $value) {
                    $setting = General_Setting::where('key', $key)->first();
                    if (isset($setting->id)) {
                        $setting->value = $value;
                        $setting->save();
                    }
                }
                return response()->json(array('status' => 200, 'success' => __('Label.save_setting')));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }

    }

}
