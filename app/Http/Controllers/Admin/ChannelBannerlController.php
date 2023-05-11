<?php

namespace App\Http\Controllers\Admin;

use Validator;
use App\Models\Channel_Banner;
use App\Models\Channel;
use DataTables, URL, DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class ChannelBannerlController extends Controller
{

    private $folder = "show";

    public function index()
    {
        try{
            return view('admin.channel_banner.index');
        } catch(Exception $e){
            return response()->json(array('status' => 400, 'errors'=> $e->getMessage() ));
        } 
    }
    public function data(Request $request)
    {
        try{
            if ($request==true) {
                $data = Channel_Banner::get();
                
                return DataTables()::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="'.route("editChannelBanner",$row->id).'" class="btn"><img src="'.url("assets/imgs/edit.png").'" /></a> ';
                    $btn .= '<a href="'.route("deleteChannelBanner",$row->id).'" onclick="return confirm(\'Are you sure you want to delete this item\')" class="delete btn btn-sm"><img src="'.url("assets/imgs/trash.png").'" /></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
            } else{     
                return view('admin.channel_banner.index');
            }
        } catch(Exception $e){
            return response()->json(array('status' => 400, 'errors'=> $e->getMessage() ));
        } 
    }
    public function add()
    {
        try{
            $channel = Channel::get();
            return view('admin.channel_banner.add', ['channel'=>$channel]);
        } catch(Exception $e){
            return response()->json(array('status' => 400, 'errors'=> $e->getMessage() ));
        } 
    }
    public function save(Request $request)
    {
        try{
            $validator = Validator::make($request->all(),[
                'name' => 'required|min:2',
                'link' => 'required',
                'order_no' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);
            if($validator->fails()){
                $errs = $validator->errors()->all();
                return response()->json(array('status' => 400, 'errors'=> $errs ));
            } else {

                $banner = new Channel_Banner();
                $banner->name = $request->name;
                $banner->link = $request->link;
                $banner->order_no = $request->order_no;
                $banner->status = '1';

                $org_name = $request->file('image');
                $banner->image = saveImage($org_name,$this->folder);

                if($banner->save()){
                    return response()->json(array('status' => 200, 'success'=> __('Label.Data Add Successfully')));
                } else {
                    return response()->json(array('status' => 400, 'errors'=> __('Label.Data Not Add') ));
                }
            }
        } catch(Exception $e){
            return response()->json(array('status' => 400, 'errors'=> $e->getMessage() ));
        } 
    }
    public function edit(Request $request,$id)
    {
        try{
            $user = Channel_Banner::where('id',$id)->first();
            $channel = Channel::get();
            return view('admin.channel_banner.edit', ['result'=>$user, 'channel'=>$channel]);
        } catch(Exception $e){
            return response()->json(array('status' => 400, 'errors'=> $e->getMessage() ));
        } 
    }
    public function update(Request $request)
    {
        try{
            $validator = Validator::make($request->all(),[
                'name' => 'required|min:2',
                'link' => 'required',
                'order_no' => 'required',
                'image' => 'image|mimes:jpeg,png,jpg|max:2048',
            ]);
            if($validator->fails()){
                $errs = $validator->errors()->all();
                return response()->json(array('status' => 400, 'errors'=> $errs ));
            } else {

                $banner = Channel_Banner::where('id',$request->id)->first();

                if (isset($banner->id)) {

                    $banner->name = $request->name;
                    $banner->link = $request->link;
                    $banner->order_no = $request->order_no;
                    $banner->status = '1';
                    
                    $org_name = $request->file('image');
                    if ($org_name == null && $banner->image ==null) {
                        $banner->image = "";
                    } else if($org_name != null && $banner->image == null){                        
                        $banner->image = saveImage($org_name,$this->folder);
                    } else if ($org_name != null){
                        $banner->image = saveImage($org_name,$this->folder);
                        @unlink("images/channel/".$request->old_image);      
                    } else {
                        $banner->image = $request->old_image;                    
                    }

                    if($banner->save()){
                        return response()->json(array('status' => 200, 'success'=> __('Label.Data Edit Successfully') ));
                    } else {
                        return response()->json(array('status' => 400, 'errors'=> __('Label.Data Not Updated') ));
                    }
                }
            }
        } catch(Exception $e){
            return response()->json(array('status' => 400, 'errors'=> $e->getMessage() ));
        }
    }
    public function delete($id){
        try{
            $banner = Channel_Banner::where('id',$id)->first();

            if($banner->image){
                if($banner->delete()){
                    @unlink("images/channel/".$banner->image);        
                    return back()->with('success', __('Label.Data Delete Successfully'));
                }  
            } else{
                if($banner->delete()){
                    return back()->with('success', __('Label.Data Delete Successfully'));
                }  
            }
        } catch(Exception $e){
            return response()->json(array('status' => 400, 'errors'=> $e->getMessage() ));
        } 
    }
    
}