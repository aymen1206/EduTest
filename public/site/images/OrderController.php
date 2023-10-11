<?php

namespace App\Http\Controllers\EduFacility;

use App\Http\Controllers\Controller;

use App\Models\FacilityPrice;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('edu_facility.auth:edu_facility');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Order::where('facility_id',auth()->guard('edu_facility')->user()->id)->get();
        return view('edu-facility.orders.index',compact('data'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OrderController  $OrderTypeController
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Order::where('id',$id)->where('facility_id',auth()->guard('edu_facility')->user()->id)->first();
        $dt = FacilityPrice::where('id',$data->price_id)->first();
        return view('edu-facility.orders.show',compact('data','dt'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $order = Order::where('id',$id)->where('facility_id',auth()->guard('edu_facility')->user()->id)->first();
        $order->status = $request->status;
        $order->update();
        return redirect()->back()->with('toast_success',  trans('lang.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OrderController  $OrderTypeController
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::where('id',$id)->where('facility_id',auth()->guard('edu_facility')->user()->id)->first();
        $order->delete();
        return redirect('edu-facility/orders')->with('toast_success',  trans('lang.delete_success'));
    }
}
