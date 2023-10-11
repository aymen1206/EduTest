<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
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
        $data = Setting::first();
        return view('admin.setting.index',compact('data'));
    }

    public function legal()
    {
        $data = DB::table('legal_agreements')->first();
        return view('admin.legal.index',compact('data'));
    }


    public function updateTerms()
    {
        $text = request('text');
        $text_en = request('text_en');
        DB::table('legal_agreements')->updateOrInsert(
            ["id" => 1],
            ["text" =>$text, "text_en" => $text_en],
        );
        $data = DB::table('legal_agreements')->first();
        return view('admin.legal.index', compact('data')); 
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
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function edit(Legal $setting)
    {
        $data = Setting::first();
        return view('admin.setting.edit',compact('data'));
    }

    public function legalEdit(Setting $setting)
    {
        $data = DB::table('legal_agreements')->first();
        return view('admin.legal.edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Setting $setting)
    {

        request()->validate([
            'app_name' => 'required|min:2|max:20',
            'app_name_en' => 'required|min:2|max:20',
            'dark_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'light_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $setting = Setting::first();
        $setting->app_name = $request->app_name;
        $setting->app_name_en = $request->app_name_en;

        if ($request->has('dark_logo') == true) {
            $imageName = time().'.'.request()->dark_logo->getClientOriginalExtension();
            request()->dark_logo->move(public_path('uploads/settings/'), $imageName);
            $setting->dark_logo = 'uploads/settings/'.$imageName;
        }

        if ($request->has('light_logo') == true) {
            $imageName = time().'.'.request()->light_logo->getClientOriginalExtension();
            request()->light_logo->move(public_path('uploads/settings/'), $imageName);
            $setting->light_logo = 'uploads/settings/'.$imageName;
        }
        $setting->update();
        return redirect()->back()->with('toast_success',  trans('lang.update_success'));
    }



    public function legalUpdate(Request $request, Setting $setting)
    {
        request()->validate([
            'text' => 'required|min:2',
            'text_en' => 'required|min:2',
        ]);
        DB::table('legal_agreements')->update(['text'=>$request->text,'text_en' =>$request->text_en]);
        return redirect()->back()->with('toast_success',  trans('lang.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
