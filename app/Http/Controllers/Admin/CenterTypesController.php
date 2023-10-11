<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CenterTypes;
use Illuminate\Http\Request;

class CenterTypesController extends Controller
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
        $data = CenterTypes::all();
        return view('admin.center-types.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.center-types.create');
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
        ]);

        $CenterTypes = new CenterTypes;
        $CenterTypes->name = $request->name;

        $CenterTypes->save();
        return redirect()->back()->with('toast_success',  trans('lang.save_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CenterTypesController  $eduFacilitiesCenterTypesController
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = CenterTypes::find($id);
        return view('admin.center-types.show',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = CenterTypes::find($id);
        return view('admin.center-types.edit',compact('data'));
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

        $CenterTypes = CenterTypes::find($id);
        $CenterTypes->name = $request->name;

        $CenterTypes->update();
        return redirect()->back()->with('toast_success',  trans('lang.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CenterTypesController  $eduFacilitiesCenterTypesController
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $CenterTypes = CenterTypes::find($id);
        $CenterTypes->delete();
        return redirect('admin/CenterTypess')->with('toast_success',  trans('lang.delete_success'));
    }
}
