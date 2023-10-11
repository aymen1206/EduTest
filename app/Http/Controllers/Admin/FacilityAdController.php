<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FacilityAd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FacilityAdController extends Controller
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
    public function index()
    {
        $data = FacilityAd::all();
        return view('admin.ads.index', compact('data'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.ads.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        request()->validate([
            'title' => 'required|min:2|max:255',
            'title_en' => 'required|min:2|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'text' => 'required|min:10',
            'text_en' => 'required|min:10',
            'price' => 'required',
            'price_after_discount' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'subscribers_allowed_number' => 'required',
        ]);


        $ad = new FacilityAd;
        $ad->title = $request->title;
        $ad->title_en = $request->title_en;
        $ad->text = $request->text;
        $ad->text_en = $request->text_en;

        $ad->price = $request->price;
        $ad->price_after_discount = $request->price_after_discount;
        $ad->start_date = $request->start_date;
        $ad->end_date = $request->end_date;
        $ad->subscribers_allowed_number = $request->subscribers_allowed_number;

        if ($request->has('image') == true) {
            $imageName = time() . rand(1, 10000) . '.' . request()->image->getClientOriginalExtension();
            request()->image->move(public_path('uploads/ads/'), $imageName);
            $ad->image = 'uploads/ads/' . $imageName;
        }

        $ad->save();
        return redirect()->back()->with('toast_success', trans('lang.save_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\FacilityAdController $adAdTypeController
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = FacilityAd::where('id', $id)->first();
        return view('admin.ads.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = FacilityAd::find($id);
        return view('admin.ads.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        request()->validate([
            'title' => 'required|min:2|max:255',
            'title_en' => 'required|min:2|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'text' => 'required|min:10',
            'text_en' => 'required|min:10',
            'price' => 'required',
            'price_after_discount' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'subscribers_allowed_number' => 'required',
        ]);

        $ad = FacilityAd::find($id);
        $ad->title = $request->title;
        $ad->title_en = $request->title_en;
        $ad->text = $request->text;
        $ad->text_en = $request->text_en;
        $ad->price = $request->price;
        $ad->price_after_discount = $request->price_after_discount;
        $ad->start_date = $request->start_date;
        $ad->end_date = $request->end_date;
        $ad->subscribers_allowed_number = $request->subscribers_allowed_number;

        if ($request->has('image') == true) {
            $imageName = time() . rand(1, 10000) . '.' . request()->image->getClientOriginalExtension();
            request()->image->move(public_path('uploads/ads/'), $imageName);
            $ad->image = 'uploads/ads/' . $imageName;
        }
        $ad->update();
        return redirect()->back()->with('toast_success', trans('lang.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\FacilityAdController $adAdTypeController
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $adAd = FacilityAd::where('id', $id)->first();
        $adAd->delete();
        return redirect('admin/ads')->with('toast_success', trans('lang.delete_success'));
    }
}
