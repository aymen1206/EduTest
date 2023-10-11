<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\EduFacilitiesType;
use App\Models\EduStage;
use Illuminate\Http\Request;
use DB;

class EduStageController extends Controller
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
        if(isset($request->facility_type)){
            $data = EduStage::where('type_id',$request->facility_type)->get();
            $type=$request->facility_type;
        }else{
         $data = EduStage::all();
         $type='all';
        }
        return view('admin.stages.index',compact('data','type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if(isset($request->type)){
            $ty = DB::table('edu_facilities_types')->where('id',$request->type)->first()->type;
            $data = EduFacilitiesType::where('type',$ty)->get();
        }else{
         $data = EduFacilitiesType::all();
        }
        return view('admin.stages.create',compact('data'));
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
            'type' => 'required',
        ]);

        $stage = new EduStage;
        $stage->name = $request->name;
        $stage->name_en = $request->name_en;
        $stage->type_id = $request->type;

        $stage->save();
        return redirect()->back()->with('toast_success',  trans('lang.save_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EduStageController  $eduFacilitiesTypeController
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = EduStage::find($id);
        return view('admin.stages.show',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id , Request $request)
    {
        if(isset($request->type)){
            $ty = DB::table('edu_facilities_types')->where('id',$request->type)->first()->type;
            $data_2 = EduFacilitiesType::where('type',$ty)->get();
        }else{
         $data_2 = EduFacilitiesType::all();
        }

        $data = EduStage::find($id);
        return view('admin.stages.edit',compact('data','data_2'));
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

        $stage = EduStage::find($id);

        $stage->type_id = $request->type;
        $stage->name = $request->name;
        $stage->name_en = $request->name_en;

        $stage->update();
        return redirect()->back()->with('toast_success',  trans('lang.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EduStageController  $eduFacilitiesTypeController
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $stage = EduStage::find($id);
        $stage->delete();
        return redirect('admin/stages')->with('toast_success',  trans('lang.delete_success'));
    }
}
