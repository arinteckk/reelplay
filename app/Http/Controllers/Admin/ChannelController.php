<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Channel;
use App\Models\TVShow;
use App\Models\Video;
use DataTables;
use Illuminate\Http\Request;
use URL;
use Validator;

class ChannelController extends Controller
{

    private $folder = "channel";

    public function index()
    {
        try {
            return view('admin.channel.index');
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function data(Request $request)
    {
        try {
            if ($request == true) {

                $data = Channel::get();

                return DataTables()::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="' . route("editChannel", $row->id) . '" class="btn"><img src="' . url("assets/imgs/edit.png") . '" /></a> ';
                        $btn .= '<a href="' . route("deleteChannel", $row->id) . '" onclick="return confirm(\'Are you sure you want to delete this item\')" class="delete btn btn-sm"><img src="' . url("assets/imgs/trash.png") . '" /></a>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            } else {
                return view('admin.pratice_question.index');
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function add()
    {
        try {
            return view('admin.channel.add');
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function save(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|min:2',
                'is_title' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'landscape' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);
            if ($validator->fails()) {
                $errs = $validator->errors()->all();
                return response()->json(array('status' => 400, 'errors' => $errs));
            } else {

                $channel = new Channel();
                $channel->name = $request->name;
                $channel->is_title = $request->is_title;
                $channel->status = 1;

                $org_name = $request->file('image');
                $org_name1 = $request->file('landscape');
                if ($org_name != null) {
                    $channel->image = saveImage($org_name, $this->folder);
                }
                if ($org_name1 != null) {
                    $channel->landscape = saveImage_landscape($org_name1, $this->folder);
                }

                if ($channel->save()) {
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
            $channel = Channel::where('id', $id)->first();
            return view('admin.channel.edit', ['result' => $channel]);
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function update(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|min:2',
                'is_title' => 'required',
                'image' => 'image|mimes:jpeg,png,jpg|max:2048',
                'landscape' => 'image|mimes:jpeg,png,jpg|max:2048',
            ]);
            if ($validator->fails()) {

                $errs = $validator->errors()->all();
                return response()->json(array('status' => 400, 'errors' => $errs));
            } else {
                $channel = Channel::where('id', $request->id)->first();

                if (isset($channel->id)) {

                    $channel->name = $request->name;
                    $channel->is_title = $request->is_title;

                    $org_name = $request->file('image');
                    if ($org_name == null && $channel->image == null) {
                        $channel->image = "";
                    } else if ($org_name != null && $channel->image == null) {
                        $channel->image = saveImage($org_name, $this->folder);
                    } else if ($org_name != null) {
                        $channel->image = saveImage($org_name, $this->folder);
                        @unlink("images/channel/" . $request->old_image);
                    } else {
                        $channel->image = $request->old_image;
                    }

                    $org_name1 = $request->file('landscape');
                    if ($org_name1 == null && $channel->landscape == null) {
                        $channel->landscape = "";
                    } else if ($org_name1 != null && $channel->landscape == null) {
                        $channel->landscape = saveImage_landscape($org_name1, $this->folder);
                    } else if ($org_name1 != null) {
                        $channel->landscape = saveImage_landscape($org_name1, $this->folder);
                        @unlink("images/channel/" . $request->old_landscape);
                    } else {
                        $channel->landscape = $request->old_landscape;
                    }

                    if ($channel->save()) {
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
            $channel = Channel::where('id', $id)->first();
            $Video = Video::where('channel_id', $channel->id)->first();
            $TVShow = TVShow::where('channel_id', $channel->id)->first();

            if ($Video) {
                return back()->with('error', "This Channel is used on some other table so you can not remove it.");
            } elseif ($TVShow) {
                return back()->with('error', "This Channel is used on some other table so you can not remove it.");
            } else {
                if ($channel->image) {
                    @unlink("images/channel/" . $channel->image);
                }
                if ($channel->landscape) {
                    @unlink("images/channel/" . $channel->landscape);
                }
                $channel->delete();
                return back()->with('success', __('Label.Data Delete Successfully'));
            }

        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

}
