<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Currency;

class CurrencyContoller extends Controller
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
        $data = Currency::all();
        return view('admin.currency.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.currency.create');
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
            'code' => 'required|min:2|max:255',
            'format' => 'required|max:255',
            'symbol' => 'required|max:255',
            'active' => 'required|min:2|max:255',
            'exchange_rate' => 'required|min:1|max:255',
        ]);

        $currency = new Currency;
        $currency->name = $request->name;
        $currency->code = $request->code;
        $currency->format = $request->format;
        $currency->symbol = $request->symbol;
        $currency->active = $request->active;
        $currency->exchange_rate = $request->exchange_rate;

        $currency->save();
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
        $data = Currency::find($id);
        return view('admin.currency.show',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Currency::find($id);
        return view('admin.currency.edit',compact('data'));
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
            'code' => 'required|max:255',
            'format' => 'required|max:255',
            'symbol' => 'required|max:255',
            'active' => 'required|max:255',
            'exchange_rate' => 'required|max:255',
        ]);

        $currency = Currency::find($id);
        $currency->name = $request->name;
        $currency->code = $request->code;
        $currency->format = $request->format;
        $currency->symbol = $request->symbol;
        $currency->active = $request->active;
        $currency->exchange_rate = $request->exchange_rate;
        $currency->update();

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
        $currency = Currency::find($id);
        $currency->delete();
        return redirect('admin/currency')->with('toast_success',  trans('lang.delete_success'));
    }
}
