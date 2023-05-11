<?php

namespace App\Http\Controllers\Admin;

use Validator;  
use App\Models\Payment_Option;
use DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class PaymentVideoController extends Controller
{

    public function index()
    {
        try{
            return view('admin.payment.index');
        } catch(Exception $e){
            return response()->json(array('status' => 400, 'errors'=> $e->getMessage() ));
        } 
    }
    public function data(Request $request)
    {
        try{
            if ($request==true) {
                $data = Payment_Option::get();

                return DataTables()::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="'.route("editPayment",$row->id).'" class="btn"><img src="'.url("assets/imgs/edit.png").'" /></a> ';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
            } else{     
                return view('admin.payment.index');
            }
        } catch(Exception $e){
            return response()->json(array('status' => 400, 'errors'=> $e->getMessage() ));
        } 
    }
    public function edit(Request $request,$id)
    {
        try{
            $payment = Payment_Option::where('id',$id)->first();
            return view('admin.payment.edit', ['result'=>$payment]);
        } catch(Exception $e){
            return response()->json(array('status' => 400, 'errors'=> $e->getMessage() ));
        } 
    }
    public function update(Request $request)
    {
        try{

            $validator = Validator::make($request->all(),[
                'visibility' => 'required',
                'is_live' => 'required',
            ]);
            if($validator->fails()){
                $errs = $validator->errors()->all();
                return response()->json(array('status' => 400, 'errors'=> $errs ));
            } else {

                $payment_option = Payment_Option::where('id',$request->id)->first();
            
                $data = $request->all();
                $payment_option->live_key_1= isset($data['live_key_1']) ?  $data['live_key_1']: '';
                $payment_option->live_key_2 = isset($data['live_key_2']) ?  $data['live_key_2']: '';
                $payment_option->live_key_3 = isset($data['live_key_3']) ?  $data['live_key_3']: '';
                $payment_option->test_key_1 = isset($data['test_key_1']) ?  $data['test_key_1']: '';
                $payment_option->test_key_2 = isset($data['test_key_2']) ?  $data['test_key_2']: '';
                $payment_option->test_key_3 = isset($data['test_key_3']) ?  $data['test_key_3']: '';

                if (isset($payment_option->id)) {
                    
                    $payment_option->visibility = $request->visibility;
                    $payment_option->is_live = $request->is_live;

                    if($payment_option->save()){
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