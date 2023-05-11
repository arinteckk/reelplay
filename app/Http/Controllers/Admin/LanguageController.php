<?php

namespace App\Http\Controllers\Admin;

use Validator;  
use App\Models\TVShow;
use App\Models\Video;
use App\Models\Language;
use DataTables, URL, DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LanguageController extends Controller
{

    private $folder = "language";

    public function index()
    {
        try{
            return view('admin.language.index');
        } catch(Exception $e){
            return response()->json(array('status' => 400, 'errors'=> $e->getMessage() ));
        }
    }
    public function data(Request $request)
    {
        try{
            if ($request==true) {
                $data = Language::select('*');

                return DataTables()::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="'.route("editLanguage",$row->id).'" class="btn"><img src="'.url("assets/imgs/edit.png").'" /></a> ';
                    $btn .= '<a href="'.route("deleteLanguage",$row->id).'" onclick="return confirm(\'Are you sure you want to delete this item\')" class="delete btn btn-sm"><img src="'.url("assets/imgs/trash.png").'" /></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
            } else{     
                return view('admin.contest.index');
            }
        } catch(Exception $e){
            return response()->json(array('status' => 400, 'errors'=> $e->getMessage() ));
        }
    }
    public function add()
    {
        try{
            return view('admin.language.add');
        } catch(Exception $e){
            return response()->json(array('status' => 400, 'errors'=> $e->getMessage() ));
        }
    }
    public function save(Request $request)
    {
        try{
            $validator = Validator::make($request->all(),[
                'name' => 'required|min:2',
                // 'lang_code' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            if($validator->fails()){
                $errs = $validator->errors()->all();
                return response()->json(array('status' => 400, 'errors'=> $errs ));
            } else {
                $language = new Language();
                $language->name = $request->name;
                $language->status = '0';
                // $language->lang_code = $request->lang_code;

                $org_name = $request->file('image');
                $language->image = saveImage($org_name,$this->folder);

                if($language->save()){
                    return response()->json(array('status' => 200, 'success'=> __('Label.Data Add Successfully') ));
                } else {
                    return response()->json(array('status' => 400, 'errors'=> __('Label.Data Not Add') ));
                }
            }
        } catch (Exception $e){
            return response()->json(array('status' => 400, 'errors'=> $e->getMessage() ));
        }
    }
    public function edit(Request $request,$id)
    {   
        try{
            $language = language::where('id',$id)->first();
            return view('admin.language.edit',['result'=>$language]);
        } catch(Exception $e){
            return response()->json(array('status' => 400, 'errors'=> $e->getMessage() ));
        }
    }
    public function update(Request $request)
    {
        try{
            $validator = Validator::make($request->all(),[
                'name' => 'required|min:2',
                // 'lang_code' => 'required|min:2',
                'image' => 'image|mimes:jpeg,png,jpg|max:2048',      
            ]);
        
            if($validator->fails()){
                $errs = $validator->errors()->all();
                return response()->json(array('status' => 400, 'errors'=> $errs ));
            } else {

                $language = Language::where('id',$request->id)->first();
                if (isset($language->id)) {

                    $language->name = $request->name;
                    // $language->lang_code = $request->lang_code;
                    $org_name = $request->file('image');
                    if ($org_name == null && $language->image ==null) {
                        $language->image = "";
                    } else if($org_name != null && $language->image == null){                        
                        $language->image = saveImage($org_name,$this->folder);
                    } else if ($org_name != null){
                        $language->image = saveImage($org_name,$this->folder);
                        @unlink("images/language/".$request->old_image);      
                    } else {
                        $language->image = $request->old_image;                    
                    }

                    if($language->save()){
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
    public function delete($id)
    {
        try{
            $language = Language::where('id',$id)->first();
            $Video = Video::whereRaw("find_in_set('".$language->id."',video.language_id)")->first();
            $TVShow = TVShow::whereRaw("find_in_set('".$language->id."',tv_show.language_id)")->first();

            if ($Video) {
                return back()->with('error', "This Language is used on some other table so you can not remove it.");
            } elseif ($TVShow) {
                return back()->with('error', "This Language is used on some other table so you can not remove it.");
            } else {
                if($language->delete()){
                    @unlink("images/language/".$language->image);        
                    return back()->with('success', __('Label.Data Delete Successfully'));
                }  
            }
        } catch(Exception $e){
            return response()->json(array('status' => 400, 'errors'=> $e->getMessage() ));
        }
    }

}
