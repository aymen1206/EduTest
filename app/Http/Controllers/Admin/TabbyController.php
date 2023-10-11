<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tabbyconfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TabbyController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.auth:admin');
    }

    public function index(){
        $data = Tabbyconfig::first();
        return view('admin.tabby.index',compact('data'));
    }

    public function edit(){
        $data = Tabbyconfig::first();
        $facilities = DB::table('edu_facilities')
            ->where('status',1)
            ->select('id','name')
            ->get();
        return view('admin.tabby.edit',compact('data','facilities'));
    }

    public function update(Request $request){
        request()->validate([
            'url' => ['required', 'string'],
            'token' => ['required', 'string'],
            'notification' => ['required', 'string'],
            'status' => ['required'],
        ]);
        $facilities = $request->facilities;
        $config = Tabbyconfig::first();
        $config->url = $request->url;
        $config->token = $request->token;
        $config->notification = $request->notification;
        $config->status = $request->status;
        $config->text = $request->text;
        $config->text_en = $request->text_en;
        $config->min = $request->min;
        $config->max = $request->max;
        if ($facilities != null && !empty($facilities)) {
            $config->locked_facilities = implode(',', $facilities);
        } else {
            $config->locked_facilities = '';
        }
        $config->update();
        return redirect()->back()->with('toast_success', trans('lang.update_success'));
    }
}
