<?php

namespace App\Http\Controllers\Api;

use App\Models\EduFacility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    public function search(Request $request){
        
        $public_path = asset('/');
        
        if (isset($request->lang)){
            $lang = $request->lang;
        }else{
            $lang = 'en';
        }

        if ($lang == 'ar') {
            $prefix = '';
            $prefix2 = 'AR';
        }elseif($lang == 'en'){
            $prefix = '_en';
            $prefix2 = 'EN';
        }
        
        $filter['keyword'] = $request->keyword;
      	$filter['map'] = $request->map;
      
        $filter['rate'] = $request->rate;
        $filter['stages'] = DB::table('edu_facilities_types')->select('id',"name$prefix as name")->get();
        $filter['payment_methods'] = DB::table('subscription_periods')->select('id',"name$prefix as name")->get();
      	$all_payment_methods_ids = DB::table('subscription_periods')->pluck('id')->toarray();
      	$all_stages_ids = DB::table('edu_facilities_types')->pluck('id')->toarray();
      
      
        $q2 = EduFacility::join('cities', 'edu_facilities.city', '=', 'cities.id');
       // $q2->orWhere('edu_facilities.name_en',"LIKE" , '%'.$request->keyword.'%');
        if(isset($request->stage)) { 
          if($request->stage == -1){         
            $q2->join('facilities_types','facilities_types.facility_id','=','edu_facilities.id')
              ->whereIn('facilities_types.facilities_type', $all_stages_ids);
              
            $filter['payment_methods'] = DB::table('subscription_periods')
              							->whereRaw("FIND_IN_SET($all_stages_ids[0],type)")
              							->select('id',"name$prefix as name")
              							->get();
          }else{
             $stages_arr = explode(',',$request->stage);
            $q2->join('facilities_types','facilities_types.facility_id','=','edu_facilities.id')
              ->whereIn('facilities_types.facilities_type', $stages_arr);
              
            $filter['payment_methods'] = DB::table('subscription_periods')
              							->whereRaw("FIND_IN_SET($stages_arr[0],type)")
              							->select('id',"name$prefix as name")
              							->get();
          }
        }

        if(isset($request->payment_method)) {  
          if($request->payment_method == -1){
             $q2->join('facility_prices','edu_facilities.id','=','facility_prices.facility_id')
              ->whereIn('facility_prices.subscription_period', $all_payment_methods_ids);
          }else{
            $payment_method_arr = explode(',',$request->payment_method);
            $q2->join('facility_prices','edu_facilities.id','=','facility_prices.facility_id')
              ->whereIn('facility_prices.subscription_period', $payment_method_arr);
          }
          
        }

        if(isset($request->rate)) {        
          if($request->rate == -1){
            $q2->whereIn('edu_facilities.rate', [0,1,2,3,4,5]);
          }else{
            $rate_arr = explode(',',$request->rate);
           	$q2->whereIn('edu_facilities.rate', $rate_arr);
          }
        	
        }
        $q2->where('status',1);
      if($request->paginate == 'on'){
         $data = $q2->where("edu_facilities.name$prefix","LIKE" , '%'.$request->keyword.'%')
                //->orWhere('edu_facilities.name_en',"LIKE" , '%'.$request->keyword.'%')
                ->select(
                    'edu_facilities.id',
                    "edu_facilities.name$prefix as name",
                    "about$prefix as about",
                    'phone',
                    'mobile',
                    'email',
                    "address$prefix as address",
                    'map_location',
                    DB::raw("CONCAT('$public_path', commercial_record) as commercial_record"),
                    DB::raw("CONCAT('$public_path', owner_id) as owner_id"),
                    DB::raw("CONCAT('$public_path', logo) as logo"),
                    'rate',
                    'visits',
                    'status',
                    'city as city_id',
                    "cities.name$prefix2 as city_name"
                )->groupBy('edu_facilities.id')->paginate(20);

      }else{
         $data = $q2->where("edu_facilities.name$prefix","LIKE" , '%'.$request->keyword.'%')
                ->select(
                    'edu_facilities.id',
                    "edu_facilities.name$prefix as name",
                    "about$prefix as about",
                    'phone',
                    'mobile',
                    'email',
                    "address$prefix as address",
                    'map_location',
                    DB::raw("CONCAT('$public_path', commercial_record) as commercial_record"),
                    DB::raw("CONCAT('$public_path', owner_id) as owner_id"),
                    DB::raw("CONCAT('$public_path', logo) as logo"),
                    'rate',
                    'visits',
                    'status',
                    'city as city_id',
                    "cities.name$prefix2 as city_name"
                )->groupBy('edu_facilities.id')->get();

      }
       
        if ($request->map == true){
            $map = \Mapper::map(24.381128999999990000, 41.470085000000040000, ['zoom' => 15, 'center' => false, 'marker' => false]);
            foreach ($data as $key=> $dt){
                $loc = explode(",",$dt->map_location);
                if (isset($loc[0]) && isset($loc[1])){
                    $map->informationWindow($loc[0] , $loc[1], "<center><a style='text-decoration: none; color: black' href='../facility/$dt->id' <div style='padding: 5px 10px'><span style='font-width: bold; font-size: 17px; color: black'> $dt->name<span><br> <img width='150' src='../$dt->image'></div></a></center>", ['open' => true, 'maxWidth'=> 200, 'autoClose' => true, 'markers' => ['title' => 'Title']]);
                }
                $loc = [];
            }
        }
        
        $response = [             
            'facilities' => $data,
        ];
        return response()->json($response, 200);
    }
}
