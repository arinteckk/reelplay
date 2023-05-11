<?php

namespace App\Http\Controllers\Admin;

use Validator;
use App\Models\Type;
use App\Models\Video;
use App\Models\TVShow;
use App\Models\TVShowVideo;
use App\Models\RentVideo;
use App\Models\Bookmark;
use App\Models\Channel_Section;
use App\Models\Banner;
use App\Models\Video_Watch;
use App\Models\Download;
use App\Models\App_Section;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TypeController extends Controller
{

    public function index()
    {
        try{
            return view('admin.type.index');
        } catch(Exception $e){
            return response()->json(array('status' => 400, 'errors'=> $e->getMessage() ));
        }
    }
    public function data(Request $request)
    {
        try{
            if ($request==true) {
                $data = Type::select('*');
            
                return DataTables()::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="'.route("editType",$row->id).'" class="btn"><img src="'.url("assets/imgs/edit.png").'" /></a> ';
                    $btn .= '<a href="'.route("deleteType",$row->id).'" onclick="return confirm(\'Are you sure you want to delete this item\')" class="delete btn btn-sm"><img src="'.url("assets/imgs/trash.png").'" /></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
            } else{     
                return view('admin.type.index');
            }
        } catch(Exception $e){
            return response()->json(array('status' => 400, 'errors'=> $e->getMessage() ));
        }
    }
    public function add()
    {
        try{
            return view('admin.type.add');
        } catch(Exception $e){
            return response()->json(array('status' => 400, 'errors'=> $e->getMessage() ));
        }
    }
    public function save(Request $request)
    {
        try {
        $validator = Validator::make($request->all(),[
            'name' => 'required|min:2',
            'type' => 'required'
        ]);
        if($validator->fails()){
            $errs = $validator->errors()->all();
            return response()->json(array('status' => 400, 'errors'=> $errs ));
        } else {
                $type = new Type();
                $type->name = $request->name;
                $type->type = $request->type;
                if($type->save()){
                    return response()->json(array('status' => 200, 'success'=> __('Label.Data Add Successfully') ));
                } else {
                    return response()->json(array('status' => 400, 'errors'=> __('Label.Data Not Add') ));
                }
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors'=> $e->getMessage() ));
        }
    }
    public function edit(Request $request,$id)
    {
        try{
            $user = Type::where('id',$id)->first();
            return view('admin.type.edit',['result'=>$user]);
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors'=> $e->getMessage() ));
        }
    }
    public function update(Request $request)
    {
        try{
            $validator = Validator::make($request->all(),[
                'name' => 'required|min:2',
                'type' => 'required'
            ]);
            if($validator->fails()){
                $errs = $validator->errors()->all();
                return response()->json(array('status' => 400, 'errors'=> $errs ));
            } else {
                $type = Type::where('id',$request->id)->first();
                if (isset($type->id)) {
                    $type->name = $request->name;
                    $type->type = $request->type;
                    if($type->save()){
                        return response()->json(array('status' => 200,'success'=> __('Label.Data Edit Successfully') ));
                    } else {
                        return response()->json(array('status' => 400, 'errors'=>__('Label.Data Not Updated') ));
                    }
                }
            }
        } catch(Exception $e){
            return response()->json(array('status' => 400, 'errors'=> $e->getMessage() ));
        }
    }
    public function delete($id)
    {
        try {
            $data = Type::where('id',$id)->first();
            $Video = Video::where('type_id',$data->id)->first();
            $TVShow = TVShow::where('type_id',$data->id)->first();
            $App_Section = App_Section::where('type_id',$data->id)->first();
            $Banner = Banner::where('type_id',$data->id)->first();
            $Channel_Section = Channel_Section::where('type_id',$data->id)->first();
            $RentVideo = RentVideo::where('type_id',$data->id)->first();
            $Bookmark = Bookmark::where('type_id',$data->id)->first();
            $Download = Download::where('type_id',$data->id)->first();
            $Video_Watch = Video_Watch::where('type_id',$data->id)->first();

            if ($Video) {
                return back()->with('error', "This Type is used on some other table so you can not remove it.");
            } elseif ($TVShow) {
                return back()->with('error', "This Type is used on some other table so you can not remove it.");
            } elseif ($App_Section) {
                return back()->with('error', "This Type is used on some other table so you can not remove it.");
            } elseif ($Banner) {
                return back()->with('error', "This Type is used on some other table so you can not remove it.");
            } elseif ($Channel_Section) {
                return back()->with('error', "This Type is used on some other table so you can not remove it.");
            } elseif ($RentVideo) {
                return back()->with('error', "This Type is used on some other table so you can not remove it.");
            } elseif ($Bookmark) {
                return back()->with('error', "This Type is used on some other table so you can not remove it.");
            } elseif ($Download) {
                return back()->with('error', "This Type is used on some other table so you can not remove it.");
            } elseif ($Video_Watch) {
                return back()->with('error', "This Type is used on some other table so you can not remove it.");
            } else {
                if($data->delete()){
                    return back()->with('success', __('Label.Data Delete Successfully'));
                }
            }
        } catch(Exception $e){
            return response()->json(array('status' => 400, 'errors'=> $e->getMessage() ));
        }
    }
}