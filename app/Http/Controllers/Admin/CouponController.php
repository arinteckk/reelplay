<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use URL;
use Validator;

class CouponController extends Controller
{

    public function index()
    {
        try {
            return view('admin.coupon.index');
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function data(Request $request)
    {
        try {
            if ($request == true) {
                $data = Coupon::latest()->get();

                return DataTables()::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="' . route("editCoupon", $row->id) . '" class="btn"><img src="' . url("assets/imgs/edit.png") . '" /></a> ';
                        $btn .= '<a href="' . route("deleteCoupon", $row->id) . '" onclick="return confirm(\'Are you sure you want to delete this item\')" class="delete btn btn-sm"><img src="' . url("assets/imgs/trash.png") . '" /></a>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            } else {
                return view('admin.coupon.index');
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function add()
    {
        try {
            return view('admin.coupon.add');
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function save(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|min:2',
                'start_date' => 'required',
                'end_date' => 'required',
                'price' => 'required',
            ]);
            if ($validator->fails()) {
                $errs = $validator->errors()->all();
                return response()->json(array('status' => 400, 'errors' => $errs));
            } else {

                $insert = new Coupon();
                $insert->unique_id = Str::random(6);
                $insert->name = $request->name;
                $insert->start_date = $request->start_date;
                $insert->end_date = $request->end_date;
                $insert->amount_type = $request->amount_type;
                $insert->price = $request->price;
                $insert->is_use = $request->is_use;
                $insert->status = '1';

                if ($insert->save()) {
                    return response()->json(array('status' => 200, 'success' => __('Label.Data Add Successfully')));
                } else {
                    return response()->json(array('status' => 400, 'errors' => __('Label.Data Not Add')));
                }
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function randomAdd()
    {
        try {
            return view('admin.coupon.random_add');
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function randomSave(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'total_number' => 'required|numeric|min:1',
                'start_date' => 'required',
                'end_date' => 'required',
                'price' => 'required',
            ]);
            if ($validator->fails()) {
                $errs = $validator->errors()->all();
                return response()->json(array('status' => 400, 'errors' => $errs));
            } else {

                for ($i=0; $i < $request->total_number; $i++) { 

                    $insert = new Coupon();
                    $insert->unique_id = Str::random(6);
                    $insert->name = Str::random(8);
                    $insert->start_date = $request->start_date;
                    $insert->end_date = $request->end_date;
                    $insert->amount_type = $request->amount_type;
                    $insert->price = $request->price;
                    $insert->is_use = $request->is_use;
                    $insert->status = '1';
                    $insert->save();
                }
                return response()->json(array('status' => 200, 'success' => __('Label.Data Add Successfully')));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function edit(Request $request, $id)
    {
        try {
            $data = Coupon::where('id', $id)->first();
            return view('admin.coupon.edit', ['result' => $data]);
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function update(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|min:2',
                'start_date' => 'required',
                'end_date' => 'required',
                'price' => 'required',
            ]);
            if ($validator->fails()) {
                $errs = $validator->errors()->all();
                return response()->json(array('status' => 400, 'errors' => $errs));
            } else {

                $update = Coupon::where('id', $request->id)->first();
                if (isset($update->id)) {

                    $update->name = $request->name;
                    $update->start_date = $request->start_date;
                    $update->end_date = $request->end_date;
                    $update->amount_type = $request->amount_type;
                    $update->price = $request->price;
                    $update->is_use = $request->is_use;

                    if ($update->save()) {
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
            $data = Coupon::where('id', $id)->first();
            if ($data->delete()) {
                return back()->with('success', __('Label.Data Delete Successfully'));
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

}
