<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use Illuminate\Http\Request;

class AdvertisementController extends Controller
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
     $data = Advertisement::all();
     return view('admin.advertisements.index',compact('data'));
   }


   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {

     return view('admin.advertisements.create');
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
       'link' => 'required|min:2|max:255',
       'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',       
     ]);


     $ad = new Advertisement;
     $ad->link = $request->link;     

     if ($request->has('image') == true) {
       $imageName = time().rand(1,10000).'.'.request()->image->getClientOriginalExtension();
       request()->image->move(public_path('upload/advertisements/'), $imageName);
       $ad->image = 'upload/advertisements/'.$imageName;
     }

     $ad->save();
     return redirect()->back()->with('toast_success',  trans('lang.save_success'));
   }

   /**
    * Display the specified resource.
    *
    * @param  \App\Models\AdvertisementController  $adAdTypeController
    * @return \Illuminate\Http\Response
    */
   public function show($id)
   {
       $data = Advertisement::where('id',$id)->first();
       return view('admin.advertisements.show',compact('data'));
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function edit($id)
   {
       $data = Advertisement::find($id);
       return view('admin.advertisements.edit',compact('data'));
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
           'link' => 'required|min:2|max:255',
           'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',           
       ]);

       $ad = Advertisement::find($id);
       $ad->link = $request->link;

       if ($request->has('image') == true) {
           $imageName = time().rand(1,10000).'.'.request()->image->getClientOriginalExtension();
           request()->image->move(public_path('upload/advertisements/'), $imageName);
           $ad->image = 'upload/advertisements/'.$imageName;
       }
       $ad->update();
       return redirect()->back()->with('toast_success',  trans('lang.update_success'));
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Models\AdvertisementController  $adAdTypeController
    * @return \Illuminate\Http\Response
    */
   public function destroy($id)
   {
       $adAd = Advertisement::where('id',$id)->first();
       $adAd->delete();
       return redirect('admin/advertisements')->with('toast_success',  trans('lang.delete_success'));
   }
}
