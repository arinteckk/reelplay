<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Avatar;
use App\Services\PayUService\Exception;
use DataTables;
use Illuminate\Http\Request;
use URL;
use Validator;

class AvatarController extends Controller
{
    private $folder = "/avatar";

    public function index()
    {
        try {
            return view('admin.avatar.index');
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

    public function data(Request $request)
    {
        try {
            if ($request == true) {
                $data = Avatar::get();
                return DataTables()::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="' . route("editAvatar", $row->id) . '" class="btn"><img src="' . url("assets/imgs/edit.png") . '"/></a> ';
                        $btn .= '<a href="' . route("deleteAvatar", $row->id) . '" onclick="return confirm(\'Are you sure you want to delete this item\')" class="delete btn btn-sm"><img src="' . url("assets/imgs/trash.png") . '" /></a>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            } else {
                return view('admin.category.index');
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

    public function add()
    {
        try {
            return view('admin.avatar.add');
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

    public function save(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|min:2',
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);
            if ($validator->fails()) {
                $errs = $validator->errors()->all();
                return response()->json(array('status' => 400, 'errors' => $errs));
            } else {

                $user = new Avatar();
                $user->name = $request->name;
                $org_name = $request->file('image');
                $user->image = saveImage($org_name, $this->folder);

                if ($user->save()) {
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
            $user = Avatar::where('id', $id)->first();
            return view('admin.avatar.edit', ['result' => $user]);
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

    public function update(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|min:2',
                'image' => 'image|mimes:jpeg,png,jpg|max:2048',
            ]);
            if ($validator->fails()) {

                $errs = $validator->errors()->all();
                return response()->json(array('status' => 400, 'errors' => $errs));
            } else {

                $user = Avatar::where('id', $request->id)->first();
                if (isset($user->id)) {

                    $user->name = $request->name;
                    $org_name = $request->file('image');
                    if ($org_name == null && $user->image == null) {
                        $user->image = "";
                    } else if ($org_name != null && $user->image == null) {
                        $user->image = saveImage($org_name, $this->folder);
                    } else if ($org_name != null) {
                        $user->image = saveImage($org_name, $this->folder);
                        @unlink("images/avatar/" . $request->old_image);
                    } else {
                        $user->image = $request->old_image;
                    }

                    if ($user->save()) {
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
            $Avatar = Avatar::where('id', $id)->first();

            if ($Avatar->image) {
                if ($Avatar->delete()) {
                    @unlink("images/avatar/" . $Avatar->image);
                    return back()->with('success', __('Label.Data Delete Successfully'));
                }
            } else {
                if ($Avatar->delete()) {
                    return back()->with('success', __('Label.Data Delete Successfully'));
                }
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

}
