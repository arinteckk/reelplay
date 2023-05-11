<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RentVideo;
use App\Models\TVShow;
use App\Models\Type;
use App\Models\Video;
use DataTables;
use Illuminate\Http\Request;
use URL;
use Validator;

class RentVideoController extends Controller
{

    public function index()
    {
        try {
            return view('admin.rent.index');
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

    public function data(Request $request)
    {
        try {
            if ($request == true) {
                $data = RentVideo::get();
                for ($i = 0; $i < count($data); $i++) {
                    $type_id = Type::select('id', 'name')->where('id', $data[$i]->type_id)->get();
                    $data[$i]->type_id = $type_id;
                }
                for ($i = 0; $i < count($data); $i++) {
                    if ($data[$i]->video_type == 1) {
                        $type_id = Video::select('id', 'name')->where('id', $data[$i]->video_id)->get();
                        $data[$i]->video_id = $type_id;
                    } else {
                        $type_id = TVShow::select('id', 'name')->where('id', $data[$i]->video_id)->get();
                        $data[$i]->video_id = $type_id;
                    }
                }
                return DataTables()::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="' . route("editRentVideo", $row->id) . '" class="btn"><img src="' . url("assets/imgs/edit.png") . '" /></a> ';
                        $btn .= '<a href="' . route("deleteRentVideo", $row->id) . '" onclick="return confirm(\'Are you sure you want to delete this item\')" class="delete btn btn-sm"><img src="' . url("assets/imgs/trash.png") . '" /></a>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            } else {
                return view('admin.level.index');
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

    public function add(Request $request)
    {
        try {

            if ($request->ajax()) {
                $video = Video::select('*')->where('type_id', $request->type_id)->get();
                $tvshow = TVShow::select('*')->where('type_id', $request->type_id)->get();
                return response()->json(array('status' => 200, 'success' => __('Label.Data Edit Successfully'), 'video' => $video, 'tvshow' => $tvshow));
            }

            $type = Type::select('*')->get();
            $video = Video::select('*')->get();
            $tvshow_video = TVShow::select('*')->get();
            return view('admin.rent.add', ['type' => $type, 'video' => $video, 'tvshowVideo' => $tvshow_video]);

        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

    public function save(Request $request)
    {
        try {
            if ($request->video_type == '1') {
                $validator = Validator::make($request->all(), [
                    'type_id' => 'required',
                    'video_type' => 'required',
                    'price' => 'required',
                    'video_id' => 'required',
                    'time' => 'required',
                    'type' => 'required',
                ]);
            } elseif ($request->video_type == '2') {
                $validator = Validator::make($request->all(), [
                    'type_id' => 'required',
                    'video_type' => 'required',
                    'price' => 'required',
                    'show_id' => 'required',
                    'time' => 'required',
                    'type' => 'required',
                ]);
            } else {
                $validator = Validator::make($request->all(), [
                    'type_id' => 'required',
                    'video_type' => 'required',
                    'price' => 'required',
                    'video_id' => 'required',
                    'show_id' => 'required',
                    'time' => 'required',
                    'type' => 'required',
                ]);
            }
            if ($validator->fails()) {
                $errs = $validator->errors()->all();
                return response()->json(array('status' => 400, 'errors' => $errs));
            } else {

                $rent = new RentVideo();
                $rent->type_id = $request->type_id;
                $rent->video_type = $request->video_type;
                $rent->price = $request->price;
                $rent->time = $request->time;
                $rent->type = $request->type;
                $rent->status = '1';

                if ($request->video_type == '1') {
                    $RentData = RentVideo::where('video_type', $request->video_type)->where('video_id', $request->video_id)->first();
                    if ($RentData != null && $RentData != "") {
                        return response()->json(array('status' => 400, 'errors' => "This Video is Already Exists"));
                    }
                    $rent->video_id = $request->video_id;
                } else {
                    $RentData = RentVideo::where('video_type', $request->video_type)->where('video_id', $request->show_id)->first();
                    if ($RentData != null && $RentData != "") {
                        return response()->json(array('status' => 400, 'errors' => "This Show is Already Exists"));
                    }
                    $rent->video_id = $request->show_id;
                }

                if ($rent->save()) {
                    return response()->json(array('status' => 200, 'success' => __('Label.Data Add Successfully')));
                } else {
                    return response()->json(array('status' => 400, 'errors' => __('Label.Data Not Add')));
                }
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

    public function edit(Request $request, $id)
    {
        try {
            $user = RentVideo::where('id', $id)->first();
            $type = Type::select('*')->get();
            $video = Video::select('*')->where('type_id', $user->type_id)->get();
            $tvshow_video = TVShow::select('*')->where('type_id', $user->type_id)->get();

            return view('admin.rent.edit', ['result' => $user, 'type' => $type, 'video' => $video, 'tvshowVideo' => $tvshow_video]);
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

    public function update(Request $request)
    {
        try {

            if ($request->video_type == '1') {
                $validator = Validator::make($request->all(), [
                    'type_id' => 'required',
                    'video_type' => 'required',
                    'price' => 'required',
                    'video_id' => 'required',
                    'time' => 'required',
                    'type' => 'required',
                ]);
            } elseif ($request->video_type == '2') {
                $validator = Validator::make($request->all(), [
                    'type_id' => 'required',
                    'video_type' => 'required',
                    'price' => 'required',
                    'show_id' => 'required',
                    'time' => 'required',
                    'type' => 'required',
                ]);
            } else {
                $validator = Validator::make($request->all(), [
                    'type_id' => 'required',
                    'video_type' => 'required',
                    'price' => 'required',
                    'video_id' => 'required',
                    'show_id' => 'required',
                    'time' => 'required',
                    'type' => 'required',
                ]);
            }
            if ($validator->fails()) {
                $errs = $validator->errors()->all();
                return response()->json(array('status' => 400, 'errors' => $errs));
            } else {

                $rent = RentVideo::where('id', $request->id)->first();

                if (isset($rent->id)) {

                    $rent->type_id = $request->type_id;
                    $rent->video_type = $request->video_type;
                    $rent->price = $request->price;
                    $rent->time = $request->time;
                    $rent->type = $request->type;
                    $rent->status = '1';

                    if ($request->video_type == '1') {
                        $RentData = RentVideo::where('id', '!=', $rent->id)->where('video_type', $request->video_type)->where('video_id', $request->video_id)->first();
                        if ($RentData) {
                            return response()->json(array('status' => 400, 'errors' => "This Video is Already Exists"));
                        }
                        $rent->video_id = $request->video_id;
                    } else {
                        $RentData = RentVideo::where('id', '!=', $rent->id)->where('video_type', $request->video_type)->where('video_id', $request->show_id)->first();
                        if ($RentData != null && $RentData != "") {
                            return response()->json(array('status' => 400, 'errors' => "This Show is Already Exists"));
                        }
                        $rent->video_id = $request->show_id;
                    }
                    if ($rent->save()) {
                        return response()->json(array('status' => 200, 'success' => __('Label.Data Edit Successfully')));
                    } else {
                        return response()->json(array('status' => 400, 'errors' => __('Label.Data Not Updated')));
                    }
                }
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

    public function delete($id)
    {
        try {
            $rent = RentVideo::where('id', $id)->first();
            if ($rent->delete()) {
                return back()->with('success', __('Label.Data Delete Successfully'));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

}
