<?php

namespace App\Http\Controllers\Admin;

use Validator;  
use App\Http\Controllers\Controller;
use App\Models\Session;
use App\Models\TVShowVideo;
use Illuminate\Http\Request;
use DataTables, URL, DB;

class SessionController extends Controller
{

    public function index()
    {
        try{
            return view('admin.session.index');
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors'=> $e->getMessage() ));
        }
    }
    public function data(Request $request)
    {
        try{
            if ($request==true) {
            
                $data = Session::get();
            
                return DataTables()::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="'.route("editSession",$row->id).'" class="btn"><img src="'.url("assets/imgs/edit.png").'" /></a> ';
                    $btn .= '<a href="'.route("deleteSession",$row->id).'" onclick="return confirm(\'Are you sure you want to delete this item\')" class="delete btn btn-sm"><img src="'.url("assets/imgs/trash.png").'" /></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
            } else{     
                return view('admin.session.index');
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors'=> $e->getMessage() ));
        }
    }
    public function add()
    {
        try{
            return view('admin.session.add');
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors'=> $e->getMessage() ));
        }
    }
    public function save(Request $request)
    {
        try{
            $validator = Validator::make($request->all(),[
                'name' => 'required|min:2',
            ]);
            if($validator->fails()){
                $errs = $validator->errors()->all();
                return response()->json(array('status' => 400, 'errors'=> $errs ));
            } else {
                $session = new Session();
                $session->name = $request->name;
                $session->status = '1';

                if($session->save()){
                    return response()->json(array('status' => 200, 'success'=> __('Label.Data Add Successfully') ));
                } else {
                    return response()->json(array('status' => 400, 'errors'=> __('Label.Data Not Add') ));
                }
            }
        } catch(Exception $e) {
            return response()->json(array('status' => 400, 'errors'=> $e->getMessage() ));
        }
    }
    public function edit(Request $request,$id)
    {
        try{
            $session = Session::where('id',$id)->first();
            return view('admin.session.edit',['result'=>$session]);
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors'=> $e->getMessage() ));
        }
    }
    public function update(Request $request)
    {
        try {
            $validator = Validator::make($request->all(),[
                'name' => 'required|min:2',
            ]);
            if($validator->fails()){
                $errs = $validator->errors()->all();
                return response()->json(array('status' => 400, 'errors'=> $errs ));
            } else {
                $session = Session::where('id',$request->id)->first();
                if (isset($session->id)) {
                    $session->name = $request->name;
                    if($session->save()){
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
        try{
            $session = Session::where('id',$id)->first();
            $TVShowVideo = TVShowVideo::where('session_id',$session->id)->first();
            if ($TVShowVideo) {
                return back()->with('error', "This Session is used on some other table so you can not remove it.");
            } else {
                if($session->delete()){
                   return back()->with('success', __('Label.Data Delete Successfully'));
                }
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors'=> $e->getMessage() ));
        }
    }

}
