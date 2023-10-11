<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class SubjectsContoller extends Controller
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
        $data = DB::table('subjects')->get();
        return view('admin.subjects.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.subjects.create');
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
            'name' => 'required|min:2|max:255'
        ]);

        DB::table('subjects')->insert(['name'=>$request->name]);
        
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
        $data = DB::table('subjects')->where('id',$id)->first();
        return view('admin.subjects.show',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = DB::table('subjects')->where('id',$id)->first();
        return view('admin.subjects.edit',compact('data'));
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
        ]);

        DB::table('subjects')->where('id',$id)->update(['name'=>$request->name]);

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
         DB::table('subjects')->where('id',$id)->delete();
        return redirect('admin/currency')->with('toast_success',  trans('lang.delete_success'));
    }
}
