<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\EduFacilitiesType;
use Illuminate\Http\Request;

class EduFacilitiesTypeController extends Controller
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
    public function index(Request $request)
    {
       if(isset($request->type)){
          $data = EduFacilitiesType::where('type',$request->type)->get();
       }else{
           $data = EduFacilitiesType::all();
       }

        return view('admin.facilities-types.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.facilities-types.create');
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

        $facility_type = new EduFacilitiesType;
        $facility_type->name = $request->name;
        $facility_type->name_en = $request->name_en;
        $facility_type->type = $request->type;
        $facility_type->save();
        return redirect()->back()->with('toast_success',  trans('lang.save_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EduFacilitiesTypeController  $eduFacilitiesTypeController
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = EduFacilitiesType::find($id);
        return view('admin.facilities-types.show',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = EduFacilitiesType::find($id);
        return view('admin.facilities-types.edit',compact('data'));
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
             'type' => 'required|max:255',
        ]);

        $facility_type = EduFacilitiesType::find($id);
        $facility_type->name = $request->name;
        $facility_type->name_en = $request->name_en;
        $facility_type->type = $request->type;
        $facility_type->update();
        return redirect()->back()->with('toast_success',  trans('lang.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EduFacilitiesTypeController  $eduFacilitiesTypeController
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $facility_type = EduFacilitiesType::find($id);
        $facility_type->delete();
        return redirect('admin/facilities-types')->with('toast_success',  trans('lang.delete_success'));
    }
}
