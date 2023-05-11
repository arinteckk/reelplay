<?php

namespace App\Http\Controllers\Admin;

use Validator;  
use App\Models\Users;
use DataTables, URL, DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    private $folder = "user";

    public function index()
    {
        try{
            return view('admin.user.index');
        } catch(Exception $e){
            return response()->json(array('status' => 400, 'errors'=> $e->getMessage() ));
        }
    }
    public function data(Request $request)
    {
        try{
            if ($request==true) {
                $data = Users::select('*')->get();
                return DataTables()::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="'.route("editUser",$row->id).'" class="btn"><img src="'.url("assets/imgs/edit.png").'" /></a> ';
                    $btn .= '<a href="'.route("deleteUser",$row->id).'" id="'.$row->id.'" onclick="return confirm(\'Are you sure you want to delete this item\')" class="delete btn btn-sm"><img src="' .url("assets/imgs/trash.png").'" /></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
            } else{     
                return view('admin.user.index');
            }
        } catch(Exception $e){
            return response()->json(array('status' => 400, 'errors'=> $e->getMessage() ));
        }
    }
    public function add()
    {
        try{
            return view('admin.user.add');
        } catch(Exception $e){
            return response()->json(array('status' => 400, 'errors'=> $e->getMessage() ));
        }
    }
    public function save(Request $request)
    {
        try {
            $validator = Validator::make($request->all(),[
                'name' => 'required',
                'gender' => 'required',
                'mobile' => 'required',
                'email' => 'required|unique:user',
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);
            if($validator->fails()){
                $errs = $validator->errors()->all();
                return response()->json(array('status' => 400, 'errors'=> $errs ));
            } else {
                $user = new Users();
                $user->name = $request->name;
                $user->user_name = "";
                $user->mobile = $request->mobile;
                $user->email = $request->email;
                $user->password = "";
                $user->gender = $request->gender;
                $user->type = 2;
                $user->api_token = "";
                $user->email_verify_token = "";
                $user->is_email_verify = "";
                $org_name = $request->file('image');
                $user->image = saveImage($org_name,$this->folder);
                if($user->save()){
                    return response()->json(array('status' => 200, 'success'=>__('Label.Data Add Successfully') ));
                } else {
                    return response()->json(array('status' => 400, 'errors'=> __('Label.error_add_user') ));
                }
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors'=> $e->getMessage() ));
        }
    }
    public function edit(Request $request,$id)
    {
        try{
            $user = Users::where('id',$id)->first();
            if($user){
                return view('admin.user.edit',['result'=>$user]);
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors'=> $e->getMessage() ));
        }
    }
    public function update(Request $request)
    {
        try {
            $validator = Validator::make($request->all(),[
                'name' => 'required',
                'gender' => 'required',
                'mobile' => 'required',
                'email' => 'required',
                'image' => 'image|mimes:jpeg,png,jpg|max:2048',
            ]);
            if($validator->fails()){
                $errs = $validator->errors()->all();
                return response()->json(array('status' => 400, 'errors'=> $errs ));
            } else {
                $user = Users::where('id',$request->id)->first();

                if (isset($user->id)) {
                    $user->name = $request->name;
                    $user->mobile = $request->mobile;
                    $user->gender = $request->gender;
                    $user->email = $request->email;

                    $org_name = $request->file('image');
                    if ($org_name == null && $user->image ==null) {
                        $user->image = "";
                    } else if($org_name != null && $user->image == null){                        
                        $user->image = saveImage($org_name,$this->folder);
                    } else if ($org_name != null){
                        $user->image = saveImage($org_name,$this->folder);
                        @unlink("images/user/".$request->old_image);      
                    } else {
                        $user->image = $request->old_image;                    
                    }

                    if($user->save()) {
                        return response()->json(array('status' => 200, 'success'=> __('Label.Data Edit Successfully') ));
                    } else {
                        return response()->json(array('status' => 400, 'errors'=> __('Label.Data Not Updated') ));
                    }
                }
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors'=> $e->getMessage() ));
        }
    }
    public function delete($id)
    {
        try {
            $user = Users::where('id',$id)->first();
            if($user->image){
                if($user->delete()){
                    @unlink("images/user/".$user->image);        
                    return back()->with('success', __('Label.Data Delete Successfully'));         
                }  
            } else{
                if($user->delete()){
                    return back()->with('success', __('Label.Data Delete Successfully'));
                }  
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors'=> $e->getMessage() ));
        }
    }

}
