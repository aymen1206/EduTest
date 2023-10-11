<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class PaymentMethodsContoller extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.auth:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('subscription_periods')->get();
        return view('admin.payment-methods.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = DB::table('edu_facilities_types')->get();
        return view('admin.payment-methods.create',compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required|min:2|max:255',
            'name_en' => 'required|min:2|max:255',
            'type' => 'required|max:255',
        ]);

        $text = '';
        foreach ($request->type as $key => $vl){
            if($key == 0){
                $text = $text.$vl;
            }else{
                $text = $text.','.$vl;
            }
        }

        DB::table('subscription_periods')->insert(['name'=>$request->name,'name_en'=>$request->name_en , 'type' => $text]);

        return redirect()->back()->with('toast_success',  trans('lang.save_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CurrencyController  $eduFacilitiesCurrencyController
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = DB::table('subscription_periods')->where('id',$id)->first();
        return view('admin.payment-methods.show',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = DB::table('subscription_periods')->where('id',$id)->first();
        $types = DB::table('edu_facilities_types')->get();
        return view('admin.payment-methods.edit',compact('data','types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        request()->validate([
            'name' => 'required|min:2|max:255',
            'name_en' => 'required|min:2|max:255',
            'type' => 'required',
        ]);

        $text = '';
        foreach ($request->type as $key => $vl){
            if($key == 0){
                $text = $text.$vl;
            }else{
                $text = $text.','.$vl;
            }
        }

        DB::table('subscription_periods')->where('id',$id)->update(['name'=>$request->name ,'name_en'=>$request->name_en, 'type' => $text]);

        return redirect()->back()->with('toast_success',  trans('lang.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CurrencyController  $eduFacilitiesCurrencyController
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         DB::table('subscription_periods')->where('id',$id)->delete();
        return redirect('admin/paymentmethods')->with('toast_success',  trans('lang.delete_success'));
    }
}
