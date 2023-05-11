<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Users;
use App\Models\Transction;
use App\Models\Type;
use App\Models\Package_Detail;
use Validator;  
use DataTables;

class PackageController extends Controller
{

    public function index()
    {
        try{
            return view('admin.package.index');
        } catch(Exception $e) {
            return response()->json(array('status' => 400, 'errors'=> $e->getMessage() ));
        }
    }
    public function add()
    {
        try{
            $type = Type::get();
            return view('admin.package.add',['type'=>$type]);
        } catch(Exception $e) {
            return response()->json(array('status' => 400, 'errors'=> $e->getMessage() ));
        }
    }
    public function save(Request $request)
    {
        try {
            $validator = Validator::make($request->all(),[
                'name' => 'required|min:2',
                'price' => 'required',
                'type_id' => 'required',
                'watch_on_laptop_tv' => 'required',
                'ads_free_movies_shows' => 'required',
                'no_of_device' => 'required',
                'video_qulity' => 'required',
                'type' => 'required',
                'time' => 'required',
                'android_product_package' => 'required',
                'ios_product_package' => 'required',
            ]);
            if($validator->fails()){
                $errs = $validator->errors()->all();
                return response()->json(array('status' => 400, 'errors'=> $errs ));
            } else {

                $package = new Package();
                $package->name = $request->name;
                $package->price = $request->price;
                $type_id = implode(',', $request->type_id);
                $package->type_id = $type_id;
                $package->watch_on_laptop_tv = $request->watch_on_laptop_tv;
                $package->ads_free_movies_shows = $request->ads_free_movies_shows;
                $package->no_of_device = $request->no_of_device;
                $package->video_qulity = $request->video_qulity;
                $package->status = 1;
                $package->type = $request->type;
                $package->time = $request->time;
                $package->android_product_package = $request->android_product_package;
                $package->ios_product_package = $request->ios_product_package;

                if($package->save()){   
                    if(package_detail($package->id) == "Success"){
                       return response()->json(array('status' => 200, 'success'=> __('Label.Data Add Successfully') ));
                    } else {
                        return response()->json(array('status' => 400, 'errors'=> __('Label.Data Not Add') ));                       
                    }
                } else {
                    return response()->json(array('status' => 400, 'errors'=> __('Label.Data Not Add') ));
                }
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors'=> $e->getMessage() ));
        }
    }
    public function data(Request $request)
    {
        try{
            if($request==true) {
                $data = Package::get();
                for ($i=0; $i < count($data) ; $i++) { 
                    $type = Type::select('id','name')->whereIn('id', explode(",",$data[$i]->type_id))->get();
                    $data[$i]->type_name = $type;
                }
            
                return DataTables()::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="'.route("editPackage",$row->id).'" class="btn"><img src="'.url("assets/imgs/edit.png").'" /></a> ';
                    $btn .= '<a href="'.route("deletePackage",$row->id).'" onclick="return confirm(\'Are you sure you want to delete this item\')" class="delete btn btn-sm"><img src="'.url("assets/imgs/trash.png").'" /></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
            } else{     
                return view('admin.package.index');
            }
        } catch(Exception $e) {
            return response()->json(array('status' => 400, 'errors'=> $e->getMessage() ));
        }
    }
    public function delete($id)
    {
        try{
            $package = Package::where('id',$id)->first();
            $TVShowVideo = Transction::where('package_id',$package->id)->first();
            if ($TVShowVideo) {
                return back()->with('error', "This Package is used on some other table so you can not remove it.");
            } else {
                if($package){
                    $package->delete();
                    Package_Detail::where('package_id',$id)->delete();
                    return back()->with('success', __('Label.Data Delete Successfully'));
                }
            }
        } catch(Exception $e) {
            return response()->json(array('status' => 400, 'errors'=> $e->getMessage() ));
        }
    }
    public function edit(Request $request,$id)
    {
        try{
            $package = Package::where('id',$id)->first();
            $type = Type::get();
            return view('admin.package.edit',['result'=>$package, 'type'=>$type]);
        } catch(Exception $e) {
            return response()->json(array('status' => 400, 'errors'=> $e->getMessage() ));
        }
    }
    public function update(Request $request)
    {
        try {
            $validator = Validator::make($request->all(),[
                'name' => 'required|min:2',
                'price' => 'required',
                'type_id' => 'required',
                'watch_on_laptop_tv' => 'required',
                'ads_free_movies_shows' => 'required',
                'no_of_device' => 'required',
                'video_qulity' => 'required',
                'type' => 'required',
                'time' => 'required',
                'android_product_package' => 'required',
                'ios_product_package' => 'required',
            ]);
            if($validator->fails()){
                $errs = $validator->errors()->all();
                return response()->json(array('status' => 400, 'errors'=> $errs ));
            } else {
                $package = Package::where('id',$request->id)->first();
                if (isset($package->id)) {

                    $package->name = $request->name;
                    $package->price = $request->price;
                   
                    $type_id = implode(',', $request->type_id);
                    $package->type_id = $type_id;
                    $package->watch_on_laptop_tv = $request->watch_on_laptop_tv;
                    $package->ads_free_movies_shows = $request->ads_free_movies_shows;
                    $package->no_of_device = $request->no_of_device;
                    $package->status = 1;
                    $package->video_qulity = $request->video_qulity;
                    $package->type = $request->type;
                    $package->time = $request->time;
                    $package->android_product_package = $request->android_product_package;
                    $package->ios_product_package = $request->ios_product_package;

                    if($package->save()){
                        if(package_detail($package->id) == "Success"){
                            return response()->json(array('status' => 200, 'success'=> __('Label.Data Edit Successfully') ));
                         } else {
                             return response()->json(array('status' => 400, 'errors'=> __('Label.Data Not Updated') ));                        
                         }
                    } else {
                        return response()->json(array('status' => 400, 'errors'=> __('Label.Data Not Updated') ));
                    }
                }
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors'=> $e->getMessage() ));
        }
    }
}
