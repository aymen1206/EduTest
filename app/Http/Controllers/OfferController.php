<?php

namespace App\Http\Controllers;

use App\Models\FacilityAd;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    public function offers(){
        $data = FacilityAd::orderBy('id','desc')->get();
        return view('site.offers',compact('data'));
    }

    public function offer($id){
        $data = FacilityAd::find($id);
        return view('site.offer',compact('data'));
    }
}
