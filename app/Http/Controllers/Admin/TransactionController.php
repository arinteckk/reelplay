<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transction;
use DataTables;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        try {
            return view('admin.transaction.index');
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }

    public function data(Request $request)
    {
        try {
            if ($request == true) {

                $all_data =  Transction::get();
                for ($i=0; $i < count($all_data); $i++) { 
                    if($all_data[$i]['expiry_date'] <= date("Y-m-d")){            
                        $all_data[$i]->status = '0';
                        $all_data[$i]->save();
                    }
                }

                $data = Transction::with('user')->with('package')->get();

                return DataTables()::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        if ($row->status == 1) {
                            return "<button type='button' style='background:#15ca20; font-size:14px; font-weight:bold; border: none;  color: white; padding: 4px 20px; outline: none;'>Active</button>";
                        } else {
                            return "<button type='button' style='background:#0dceec; font-size:14px; font-weight:bold; letter-spacing:0.1px; border: none; color: white; padding: 5px 15px; outline: none;'>Expiry</button>";
                        }
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            } else {
                return view('admin.transaction.index');
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
}