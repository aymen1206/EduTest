<?php

namespace App\Http\Controllers;

use App\Models\EduFacility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function search(Request $request)
    {

        $filter['keyword'] = $request->keyword;
        $filter['rate'] = $request->rate;
        $filter['type'] = DB::table('edu_facilities_types')->where('id', $request->type)->first();
        if (isset($request->facility_type)){
            $filter['subscription_periods'] = DB::table('subscription_periods')->where('type', 'LIKE', '%' . $request->facility_type . '%')->orderBy('position','asc')->get();
        }else{
            $filter['subscription_periods'] = DB::table('subscription_periods')->orderBy('position','asc')->get();
        }
        $filter['subscription']= $request->subscription;
        $filter['facility_type'] = DB::table('edu_facilities_types')->where('id',$request->facility_type)->first();

        $filter['facility_types'] = DB::table('edu_facilities_types')->join('facilities_types','facilities_types.facilities_type','=','edu_facilities_types.id')->where('edu_facilities_types.type',1)->select('edu_facilities_types.*',DB::raw('COUNT(facilities_types.id) as subscriptions'))->groupBy('edu_facilities_types.id')->get();

        $q2 = EduFacility::where('edu_facilities.name',"LIKE" , '%'.$request->keyword.'%');

        if(isset($request->facility_type)) {
            $q2->join('facilities_types','edu_facilities.id','=','facilities_types.facility_id')->where('facilities_types.facilities_type',$request->facility_type);
        }

        if(isset($request->subscription)) {
            $q2->join('facility_prices','edu_facilities.id','=','facility_prices.facility_id')->where('facility_prices.subscription_period',$request->subscription);
        }

        if(isset($request->rate)) {
            $q2->whereBetween('edu_facilities.rate',[$request->rate, $request->rate + 0.99]);
        }

        $data = $q2->where('edu_facilities.status',1)->select('edu_facilities.*')->groupBy('edu_facilities.id')->get();

        if ($request->map == "true"){
            $map = \Mapper::map(24.381128999999990000, 41.470085000000040000, ['zoom' => 15,'locate'=> true, 'center' => false, 'marker' => true]);
            foreach ($data as $key=> $dt){
                $loc = explode(",",$dt->map_location);
                if (isset($loc[0]) && isset($loc[1])){
                    $map->informationWindow($loc[0] , $loc[1], "<center><a style='text-decoration: none; color: black' href='../facility/$dt->id' <div style='padding: 1px 2px'><span style='font-width: bold; font-size: 12px; color: black'> $dt->name<span><br> <img width='70' src='../$dt->logo'></div></a></center>", ['open' => true, 'maxWidth'=> 200, 'autoClose' => true,'animation' => 'DROP', 'markers' => ['title' => 'Title']]);
                }
                $loc = [];
            }
        } else{
          $map = null;
        }

        return view('site.index',compact('data','map','filter'));
    }
}
