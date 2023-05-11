<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Type;
use App\Models\Users;
use Illuminate\Http\Request;
use Validator;

class UserController extends Controller
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

    public function get_profile(Request $request)
    {
        try {

            $validation = Validator::make(
                $request->all(),
                [
                    'id' => 'required|numeric',
                ],
                [
                    'id.required' => __('api_msg.please_enter_required_fields'),
                ]
            );
            if ($validation->fails()) {

                $errors = $validation->errors()->first('id');
                $data['status'] = 400;
                if ($errors) {
                    $data['message'] = $errors;
                }
                return $data;
            }

            $id = $request->id;
            $Data = Users::where('id', $id)->first();
            if (!empty($Data)) {

                if (!empty($Data->image)) {
                    $path = Get_Image($this->folder7, $Data->image);
                    $Data['image'] = $path;
                } else {
                    $Data['image'] = asset('/assets/imgs/no_img.png');
                }
                return APIResponse(200, __('api_msg.get_record_successfully'), $Data);
            } else {
                return APIResponse(400, __('api_msg.data_not_found'));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

    public function image_upload(Request $request)
    {
        try {

            $validation = Validator::make(
                $request->all(),
                [
                    'id' => 'required|numeric',
                    'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                ],
                [
                    'id.required' => __('api_msg.please_enter_required_fields'),
                    'image.required' => __('api_msg.please_enter_required_fields'),
                ]
            );
            if ($validation->fails()) {

                $errors = $validation->errors()->first('id');
                $errors1 = $validation->errors()->first('image');
                $data['status'] = 400;
                if ($errors) {
                    $data['message'] = $errors;
                } elseif ($errors1) {
                    $data['message'] = $errors1;
                }
                return $data;
            }

            $id = $request->id;
            $org_name = $request->file('image');

            $data = Users::where('id', $id)->first();
            if (!empty($data)) {

                @unlink("images/" . $this->folder7 . "/" . $data['image']);

                $data->image = saveImage($org_name, $this->folder7);
                if ($data->save()) {
                    return APIResponse(200, __('api_msg.update_successfully'));
                } else {
                    return APIResponse(400, __('api_msg.data_not_save'));
                }
            } else {
                return APIResponse(400, __('api_msg.data_not_found'));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

    public function registration(Request $request)
    {
        try {

            $validation = Validator::make(
                $request->all(),
                [
                    'type' => 'required|numeric',
                    'name' => 'required',
                    'email' => 'required|unique:user|email',
                    'password' => 'required',
                    'mobile' => 'required|numeric',
                ],
                [
                    'type.required' => __('api_msg.please_enter_required_fields'),
                    'email.required' => __('api_msg.please_enter_required_fields'),
                    'mobile.required' => __('api_msg.please_enter_required_fields'),
                ]
            );
            if ($validation->fails()) {

                $errors = $validation->errors()->first('type');
                $errors1 = $validation->errors()->first('email');
                $errors2 = $validation->errors()->first('mobile');
                $data['status'] = 400;
                if ($errors) {
                    $data['message'] = $errors;
                } elseif ($errors1) {
                    $data['message'] = $errors1;
                } elseif ($errors2) {
                    $data['message'] = $errors2;
                } else {
                    $data['message'] = __('api_msg.please_enter_required_fields');
                }
                return $data;
            }

            $type = $request->type;
            $name = $request->name;
            $email = $request->email;
            $password = $request->password;
            $mobile = $request->mobile;

            $data = array(
                'language_id' => 0,
                'name' => $name,
                'user_name' => "",
                'mobile' => $mobile,
                'email' => $email,
                'password' => $password,
                'gender' => 'male',
                'image' => "",
                'status' => 1,
                'type' => $type,
                'api_token' => "",
                'email_verify_token' => "",
                'is_email_verify' => "",
            );

            $user_id = Users::insertGetId($data);

            if (isset($user_id)) {

                $user_data = Users::where('id', $user_id)->first();
                return APIResponse(200, __('api_msg.User_registration_sucessfuly'), array($user_data));
            } else {
                return APIResponse(400, __('api_msg.data_not_save'));
            }

        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

    public function login(Request $request)
    {
        try {

            if ($request->type == 1 or $request->type == 2) {

                $validation = Validator::make(
                    $request->all(),
                    [
                        'name' => 'required',
                        'email' => 'required|email',
                    ],
                    [
                        'name.required' => __('api_msg.please_enter_required_fields'),
                        'email.required' => __('api_msg.please_enter_required_fields'),
                    ]
                );
                if ($validation->fails()) {

                    $errors = $validation->errors()->first('name');
                    $errors1 = $validation->errors()->first('email');
                    $data['status'] = 400;
                    if ($errors) {
                        $data['message'] = $errors;
                    } elseif ($errors1) {
                        $data['message'] = $errors1;
                    }
                    return $data;
                }

            } elseif ($request->type == 3) {

                $validation = Validator::make(
                    $request->all(),
                    [
                        'mobile' => 'required|numeric',
                    ],
                    [
                        'mobile.required' => __('api_msg.please_enter_required_fields'),
                    ]
                );
                if ($validation->fails()) {

                    $errors = $validation->errors()->first('mobile');
                    $data['status'] = 400;
                    if ($errors) {
                        $data['message'] = $errors;
                    }
                    return $data;
                }

            } elseif ($request->type == 4) {

                $validation = Validator::make(
                    $request->all(),
                    [
                        'email' => 'required|email',
                        'password' => 'required',
                    ],
                    [
                        'email.required' => __('api_msg.please_enter_required_fields'),
                    ]
                );
                if ($validation->fails()) {

                    $errors = $validation->errors()->first('email');
                    $data['status'] = 400;
                    if ($errors) {
                        $data['message'] = $errors;
                    } else {
                        $data['message'] = __('api_msg.please_enter_required_fields');
                    }
                    return $data;
                }

            } else {
                $validation = Validator::make(
                    $request->all(),
                    [
                        'type' => 'required|numeric',
                    ],
                    [
                        'type.required' => __('api_msg.please_enter_required_fields'),
                    ]
                );
                if ($validation->fails()) {

                    $errors = $validation->errors()->first('type');
                    $data['status'] = 400;
                    if ($errors) {
                        $data['message'] = $errors;
                    }
                    return $data;
                }
            }

            $type = $request->type;
            $name = isset($request->name) ? $request->name : "";
            $email = isset($request->email) ? $request->email : "";
            $password = isset($request->password) ? $request->password : "";
            $mobile = isset($request->mobile) ? $request->mobile : "";

            if ($type == 1 or $type == 2) {

                $data = Users::where('email', $email)->first();
                if (!empty($data)) {

                    // Image
                    if (!empty($data['image'])) {
                        $path = Get_Image($this->folder7, $data['image']);
                        $data['image'] = $path;
                    } else {
                        $data['image'] = asset('/assets/imgs/no_img.png');
                    }
                    $return['status'] = 200;
                    $return['message'] = __('api_msg.login_successfully');
                    $return['result'] = $data;
                    return $return;
                } else {

                    $imageName = "";
                    if($request->image != null){
                        $org_name = $request->file('image');
                        $imageName = saveImage($org_name, $this->folder7);
                    }

                    $data = array(
                        'language_id' => 0,
                        'name' => $name,
                        'user_name' => "",
                        'mobile' => $mobile,
                        'email' => $email,
                        'password' => $password,
                        'gender' => 'male',
                        'image' => $imageName,
                        'status' => 1,
                        'type' => $type,
                        'api_token' => "",
                        'email_verify_token' => "",
                        'is_email_verify' => "",
                    );
                    $user_id = Users::insertGetId($data);
                    if (isset($user_id)) {

                        $user_data = Users::where('id', $user_id)->first();
                        // Image
                        if (!empty($user_data['image'])) {
                            $path = Get_Image($this->folder7, $data['image']);
                            $user_data['image'] = $path;
                        } else {
                            $user_data['image'] = asset('/assets/imgs/no_img.png');
                        }

                        $return['status'] = 200;
                        $return['message'] = __('api_msg.login_successfully');
                        $return['result'] = $user_data;
                        return $return;
                    } else {
                        return APIResponse(400, __('api_msg.data_not_save'));
                    }
                }

            } elseif ($type == 3) {

                $data = Users::where('mobile', $mobile)->first();
                if (!empty($data)) {

                    // Image
                    if (!empty($data['image'])) {
                        $path = Get_Image($this->folder7, $data['image']);
                        $data['image'] = $path;
                    } else {
                        $data['image'] = asset('/assets/imgs/no_img.png');
                    }
                    $return['status'] = 200;
                    $return['message'] = __('api_msg.login_successfully');
                    $return['result'] = $data;
                    return $return;
                } else {

                    $data = array(
                        'language_id' => 0,
                        'name' => $name,
                        'user_name' => "",
                        'mobile' => $mobile,
                        'email' => $email,
                        'password' => $password,
                        'gender' => 'male',
                        'image' => "",
                        'status' => 1,
                        'type' => $type,
                        'api_token' => "",
                        'email_verify_token' => "",
                        'is_email_verify' => "",
                    );
                    $user_id = Users::insertGetId($data);
                    if (isset($user_id)) {

                        $user_data = Users::where('id', $user_id)->first();
                        // Image
                        if (!empty($user_data['image'])) {
                            $path = Get_Image($this->folder7, $data['image']);
                            $user_data['image'] = $path;
                        } else {
                            $user_data['image'] = asset('/assets/imgs/no_img.png');
                        }

                        $return['status'] = 200;
                        $return['message'] = __('api_msg.login_successfully');
                        $return['result'] = $user_data;
                        return $return;
                    } else {
                        return APIResponse(400, __('api_msg.data_not_save'));
                    }
                }

            } elseif ($type == 4) {

                $data = Users::where('email', $email)->where('password', $password)->first();
                if (!empty($data)) {

                    // Image
                    if (!empty($data['image'])) {
                        $path = Get_Image($this->folder7, $data['image']);
                        $data['image'] = $path;
                    } else {
                        $data['image'] = asset('/assets/imgs/no_img.png');
                    }
                    $return['status'] = 200;
                    $return['message'] = __('api_msg.login_successfully');
                    $return['result'] = $data;
                    return $return;
                } else {
                    return APIResponse(400, __('api_msg.email_pass_worng'), array($data));
                }

            } else {
                return APIResponse(400, __('api_msg.change_type'));
            }

        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

    public function update_profile(Request $request)
    {
        try {

            $validation = Validator::make(
                $request->all(),
                [
                    'id' => 'required|numeric',
                ],
                [
                    'id.required' => __('api_msg.please_enter_required_fields'),
                ]
            );
            if ($validation->fails()) {

                $errors = $validation->errors()->first('id');
                $data['status'] = 400;
                if ($errors) {
                    $data['message'] = $errors;
                }
                return $data;
            }

            $id = $request->id;
            $data = array();

            $User_Data = Users::where('id', $id)->first();
            if (!empty($User_Data)) {

                if (isset($request->name) && $request->name != '') {
                    $data['name'] = $request->name;
                }
                if (isset($request->email) && $request->email != '') {
                    $data['email'] = $request->email;
                }
                if (isset($request->mobile) && $request->mobile != '') {
                    $data['mobile'] = $request->mobile;
                }

                $User_Data->update($data);
                if(isset($User_Data)){

                    if (!empty($User_Data->image)) {
                        $path = Get_Image($this->folder7, $User_Data->image);
                        $User_Data['image'] = $path;
                    } else {
                        $User_Data['image'] = asset('/assets/imgs/no_img.png');
                    }

                    $Data['status'] = 200;
                    $Data['message'] = __('api_msg.update_profile_sucessfuly');
                    $Data['result'] = $User_Data;
                    return $Data;
                }
            } else {
                return APIResponse(400, __('api_msg.User_id_worng'));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

}
