<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\FacilityPrice;
use App\Models\Order;
use Illuminate\Http\Request;
use DB;

class OrderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

     public function __construct()
     {
         $this->middleware('admin.auth:admin');
     }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $facility['types'] = DB::table('edu_facilities_types')->get();
        $query = Order::where('orders.id','>',0);

        if (isset($request->type) && $request->type != null) { 

            $query->join('facility_prices','orders.price_id','=','facility_prices.id')
                    ->where('facility_prices.type',$request->type);
            $_type = $request->type;
        }else{
            $_type = null;
        }

        if (isset($request->status) && $request->status != null) {             
            $query->where('orders.status',$request->status);
            $_status = $request->status;
        }else{
            $_status = null;
        }

        if (isset($request->from) && $request->from != null && isset($request->to) && $request->to != null) {             
            $query->whereBetween('orders.created_at', [$request->from, $request->to]);
            $_from = $request->from;
            $_to = $request->to;
        }else{
            $_to = null;
            $_from =  null;
        }

        $data = $query->select('orders.*')->get();


        return view('admin.orders.index',compact('data','_type','_status','_to','_from','facility'));
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
        $data = Order::where('id',$id)->first();
        $dt = FacilityPrice::where('id',$data->price_id)->first();
        return view('admin.orders.show',compact('data','dt'));
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
        $order = Order::where('id',$id)->first();
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
        $order = Order::where('id',$id)->first();
        $order->delete();
        return redirect('admin/orders')->with('toast_success',  trans('lang.delete_success'));
    }
}
