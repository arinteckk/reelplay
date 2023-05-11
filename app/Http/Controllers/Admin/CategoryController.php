<?php

namespace App\Http\Controllers\Admin;

use Validator;  
use DataTables, URL, DB;
use App\Models\Category;
use App\Models\TVShow;
use App\Models\Video;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Services\PayUService\Exception;

class CategoryController extends Controller
{
    private $folder = "category";
    
    public function index()
    {
        try{
            return view('admin.category.index');
        } catch(Exception $e){
            return response()->json(array('status' => 400, 'errors'=> $e->getMessage() ));
        }
    }
    public function data(Request $request)
    {
        try{
            if ($request==true) {
                $data = Category::select('*');
                return DataTables()::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="'.route("editCategory",$row->id).'" class="btn"><img src="'.url("assets/imgs/edit.png").'"/></a> ';
                    $btn .= '<a href="'.route("deleteCategory",$row->id).'" onclick="return confirm(\'Are you sure you want to delete this item\')" class="delete btn btn-sm"><img src="'.url("assets/imgs/trash.png").'" /></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
            } else{     
                return view('admin.category.index');
            }
        } catch(Exception $e){
            return response()->json(array('status' => 400, 'errors'=> $e->getMessage() ));
        }
    }
    public function add()
    {
        try{
            return view('admin.category.add');
        } catch(Exception $e){
            return response()->json(array('status' => 400, 'errors'=> $e->getMessage() ));
        }
    }
    public function save(Request $request)
    {
        try {
            $validator = Validator::make($request->all(),[
                'name' => 'required|min:2',
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);
            if($validator->fails()){
                $errs = $validator->errors()->all();
                return response()->json(array('status' => 400, 'errors'=> $errs ));
            } else{

                $user = new Category();
                $user->name = $request->name;
                $org_name = $request->file('image');
                $user->image = saveImage($org_name,$this->folder);

                if($user->save()){
                    return response()->json(array('status' => 200, 'success'=> __('Label.Data Add Successfully') ));
                } else {
                    return response()->json(array('status' => 400, 'errors'=> __('Label.Data Not Add')));
                }
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors'=> $e->getMessage() ));
        }
    }
    public function edit(Request $request,$id)
    {
        try{
            $user = Category::where('id',$id)->first();
            return view('admin.category.edit',['result'=>$user]);
        } catch(Exception $e){
            return response()->json(array('status' => 400, 'errors'=> $e->getMessage() ));
        }
    }
    public function update(Request $request)
    {
        try{     
            $validator = Validator::make($request->all(),[
                'name' => 'required|min:2',
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            if($validator->fails()){

                $errs = $validator->errors()->all();
                return response()->json(array('status' => 400, 'errors'=> $errs ));
            } else {
            
                $user = Category::where('id',$request->id)->first();
                if (isset($user->id)) {

                    $user->name = $request->name;
                    $org_name = $request->file('image');
                    if ($org_name == null && $user->image ==null) {
                        $user->image = "";
                    } else if($org_name != null && $user->image == null){                        
                        $user->image = saveImage($org_name,$this->folder);
                    } else if ($org_name != null){
                        $user->image = saveImage($org_name,$this->folder);
                        @unlink("images/category/".$request->old_image);      
                    } else {
                        $user->image = $request->old_image;                    
                    }

                    if($user->save()){
                        return response()->json(array('status' => 200, 'success'=>__('Label.Data Edit Successfully')));
                    } else {
                        return response()->json(array('status' => 400, 'errors'=> __('Label.Data Not Updated')));
                    }
                } 
            }
        } catch(Exception $e) {
            return response()->json(array('status' => 400, 'errors'=> $e->getMessage() ));
        }
    }
    public function delete($id)
    {
        try{
            $category = Category::where('id',$id)->first();
            $Video = Video::whereRaw("find_in_set('".$category->id."',video.category_id)")->first();
            $TVShow = TVShow::whereRaw("find_in_set('".$category->id."',tv_show.category_id)")->first();

            if ($Video) {
                return back()->with('error', "This Category is used on some other table so you can not remove it.");
            } elseif ($TVShow) {
                return back()->with('error', "This Category is used on some other table so you can not remove it.");
            } else {
                if($category->delete()){
                   @unlink("images/category/".$category->image);        
                   return back()->with('success', __('Label.Data Delete Successfully'));
                }
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors'=> $e->getMessage() ));
        }
    }

}

