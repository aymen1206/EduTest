<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Language;

class LanguageController extends Controller
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
        $data = Language::all();
        return view('admin.language.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view('admin.language.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // request()->validate([
        //     'name' => 'required|min:2|max:255',
        //     'iso' => 'required|min:2|max:255',
        //     'status' => 'required|min:2|max:255',
        // ]);

        // $Language = new Language;
        // $Language->name = $request->name;
        // $Language->iso = $request->iso;
        // $Language->status = $request->status;
        // $Language->save();
        // return redirect()->back()->with('toast_success',  trans('lang.save_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LanguageController  $eduFacilitiesLanguageController
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Language::find($id);
        return view('admin.language.show',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Language::find($id);
        return view('admin.language.edit',compact('data'));
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
            'status' => 'required',
        ]);

        $Language = Language::find($id);
        $Language->status = $request->status;
        $Language->update();

        return redirect()->back()->with('toast_success',  trans('lang.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LanguageController  $eduFacilitiesLanguageController
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $Language = Language::find($id);
        // $Language->delete();
        // return redirect('admin/languages')->with('toast_success',  trans('lang.delete_success'));
    }
}
