<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seosetting;
use Illuminate\Http\Request;

class SeosettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $seo = Seosetting::first();
        return view('admin.seo.index',compact('seo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\seosetting  $seosetting
     * @return \Illuminate\Http\Response
     */
    public function show(seosetting $seosetting)
    {
        $seo = Seosetting::first();
        return view('admin.seo.show',compact('seo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\seosetting  $seosetting
     * @return \Illuminate\Http\Response
     */
    public function edit(seosetting $seosetting)
    {
        $seo = Seosetting::first();
        return view('admin.seo.edit',compact('seo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\seosetting  $seosetting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        request()->validate([
            'title' => ['required', 'string','max:255'],
            'description' => ['required','string','min:25'],
            'keywords' => ['required', 'string'],
        ]);
        $seo = Seosetting::first();

        $seo->title = $request->title;
        $seo->description = $request->description;
        $seo->keywords = $request->keywords;
        $seo->update();
        return redirect()->back()->with('toast_success',  trans('lang.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\seosetting  $seosetting
     * @return \Illuminate\Http\Response
     */
    public function destroy(seosetting $seosetting)
    {
        //
    }
}
