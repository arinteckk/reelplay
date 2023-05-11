<?php

namespace App\Http\Controllers\Admin;

use Validator;  
use App\Models\Type;
use App\Models\Video;
use App\Models\TVShow;
use App\Models\Page;
use DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class PageController extends Controller
{

    public function index()
    {
        try{
            return view('admin.page.index');
        } catch(Exception $e){
            return response()->json(array('status' => 400, 'errors'=> $e->getMessage() ));
        } 
    }
    public function data(Request $request)
    {
        try{
            if ($request==true) {
                $data = Page::get();
                return DataTables()::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="'.route("editPage",$row->id).'" class="btn"><img src="'.url("assets/imgs/edit.png").'" /></a> ';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
            } else{     
                return view('admin.page.index');
            }
        } catch(Exception $e){
            return response()->json(array('status' => 400, 'errors'=> $e->getMessage() ));
        } 
    }
    public function edit(Request $request,$id)
    {
        try{
            $page = Page::where('id',$id)->first();

            return view('admin.page.edit', ['result'=>$page]);
        } catch(Exception $e){
            return response()->json(array('status' => 400, 'errors'=> $e->getMessage() ));
        } 
    }
    public function update(Request $request)
    {
        try{

            $validator = Validator::make($request->all(),[
                'title' => 'required',
                'description' => 'required',
            ]);
            
            if($validator->fails()){
                $errs = $validator->errors()->all();
                return response()->json(array('status' => 400, 'errors'=> $errs ));
            } else {

                $page = Page::where('id',$request->id)->first();

                if (isset($page->id)) {

                    $page->title = $request->title;
                    $page->description = $request->description;
                    $page->status = '1';

                    if($page->save()){
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

}