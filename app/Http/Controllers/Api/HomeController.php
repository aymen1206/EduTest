<?php

namespace App\Http\Controllers\Api;

use App\Models\About;
use App\Models\AppReview;
use App\Models\EduFacility;
use App\Models\FacilityAd;
use App\Models\FacilityPrice;
use App\Models\Message;
use App\Models\Type;
use Illuminate\Http\Request;
use Alert;
use Illuminate\Support\Facades\DB;
use Mail;
use App\Http\Controllers\Controller;
use Mapper;
use Illuminate\Support\Arr;

class HomeController extends Controller
{

    public function index()
    {
        $about = DB::table('abouts')->first();
        $types = DB::table('types')->get();
        $response = [
            'success' => true,
            'data' => [
                'about' => $about,
                'types' => $types,
            ]
        ];
        return response()->json($response, 200);
    }
    
    public function settings()
    {
        $settings = DB::table('settings')->first();
        $response = [
            'success' => true,
            'settings' => $settings,
            
        ];
        return response()->json($response, 200);
    }

    public function about(Request $request)
    {
        $public_path = asset('/');
        $lang = $request->lang;
         if ($lang == 'ar') {
            $prefix = '';
        }else{
            $prefix = '_en';
        }

        $about = About::select("title$prefix as title","text$prefix as text",DB::raw("CONCAT('$public_path', image) as image"),'map')->first();
        $response = [
            'success' => true,
            'data' =>$about,
        ];
        return response()->json($response, 200);
    }


     public function jeelwebhook(Request $request)
  {
         DB::table('log')->insert([
                    'value'=>$request,
                ]);

        $response = [
            'success' => true,
            'data' => [
                'message' => "Log Saved",
            ]
        ];
        return response()->json($response, 200);
 }


    public function eduFacilities($id, Request $request)
    {
        $filter['keyword'] = $request->keyword;
        $filter['rate'] = $request->rate;
        $filter['type'] = DB::table('types')->where('id', $id)->first();

        $filter['subscription_periods'] = DB::table('subscription_periods')->get();
        $filter['subscription'] = $request->subscription;

        $filter['facility_type'] = DB::table('edu_facilities_types')->where('id', $request->facility_type)->first();

        $filter['facility_types'] = DB::table('edu_facilities_types')->join('facilities_types', 'facilities_types.facilities_type', '=', 'edu_facilities_types.id')->where('edu_facilities_types.type', $request->type)->select('edu_facilities_types.*', DB::raw('COUNT(facilities_types.id) as subscriptions'))->groupBy('edu_facilities_types.id')->get();

        $q2 = EduFacility::where('edu_facilities.name', "LIKE", '%' . $request->keyword . '%');

        if (isset($request->facility_type)) {
            $q2->join('facilities_types', 'edu_facilities.id', '=', 'facilities_types.facility_id')->where('facilities_types.facilities_type', $request->facility_type);
        }

        if (isset($request->subscription)) {
            $q2->join('facility_prices', 'edu_facilities.id', '=', 'facility_prices.facility_id')->where('facility_prices.subscription_period', $request->subscription);
        }

        if (isset($request->rate)) {
            $q2->whereBetween('edu_facilities.rate', [$request->rate, $request->rate + 0.99]);
        }

        $data = $q2->where('edu_facilities.facility_type', $id)->select('edu_facilities.*')->groupBy('edu_facilities.id')->get();

        if ($request->map == "true") {
            $map = Mapper::map(24.381128999999990000, 41.470085000000040000, ['zoom' => 15, 'center' => false, 'marker' => false]);
            foreach ($data as $key => $dt) {
                $loc = explode(",", $dt->map_location);
                if (isset($loc[0]) && isset($loc[1])) {
                    $map->informationWindow($loc[0], $loc[1], "<center><a style='text-decoration: none; color: black' href='../facility/$dt->id' <div style='padding: 5px 10px'><span style='font-width: bold; font-size: 17px; color: black'> $dt->name<span><br> <img width='150' src='../$dt->image'></div></a></center>", ['open' => true, 'maxWidth' => 200, 'autoClose' => true, 'markers' => ['title' => 'Title']]);
                }
                $loc = [];
            }
        } else {
            $map = null;
        }
        return view('site.facilities', compact('data', 'map', 'filter'));
    }

    public function facility($id,Request $request)
    {
        $public_path = asset('/');
        if (isset($request->lang)){
            $lang = $request->lang;
        }else{
            $lang = 'both';
        }

        if ($lang == 'ar') {
            $prefix = '';
            $prefix2 = 'AR';
        }elseif($lang == 'en'){
            $prefix = '_en';
            $prefix2 = 'EN';
        }

        if ($lang != 'both'){
            $user = EduFacility::join('cities', 'edu_facilities.city', '=', 'cities.id')
                ->join('types', 'edu_facilities.facility_type', '=', 'types.id')
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
                    "cities.name$prefix2 as city_name",
                    'types.id as facility_type_id',
                    "types.name$prefix as facility_type"
                )->where('edu_facilities.id', $id)->first();
        }else{
            $user = EduFacility::join('cities', 'edu_facilities.city', '=', 'cities.id')
                ->join('types', 'edu_facilities.facility_type', '=', 'types.id')
                ->select(
                    'edu_facilities.id',
                    "edu_facilities.name as name_ar",
                    "edu_facilities.name_en as name_en",
                    "about as about",
                    "about_en as about_en",
                    'phone',
                    'mobile',
                    'email',
                    "address as address",
                    "address_en as address_en",
                    'map_location',
                    DB::raw("CONCAT('$public_path', commercial_record) as commercial_record"),
                    DB::raw("CONCAT('$public_path', owner_id) as owner_id"),
                    DB::raw("CONCAT('$public_path', logo) as logo"),
                    'rate',
                    'visits',
                    'status',
                    'city as city_id',
                    "cities.nameAR as city_name_ar",
                    "cities.nameEN as city_name_en",
                    'types.id as facility_type_id',
                    "types.name as facility_type_ar",
                    "types.name_en as facility_type_en"
                )->where('edu_facilities.id', $id)->first();
        }

        if ($lang == 'ar') {
            $prefix = '';
            $prefix2 = 'AR';
        }else{
            $prefix = '_en';
            $prefix2 = 'EN';
        }

        $stages = DB::table('facilities_types')
            ->join('edu_facilities_types','facilities_types.facilities_type','=','edu_facilities_types.id')
            ->where('facilities_types.facility_id', $id)
            ->select("edu_facilities_types.id","edu_facilities_types.name$prefix as name")
            ->get();

        $gallery = DB::table('galleries')
            ->where('facility_id', $id)
            ->select('galleries.*',DB::raw("CONCAT('$public_path', image) as image"))
            ->get();

        $prices = DB::table('facility_prices')
            ->JOIN('edu_facilities_types', 'facility_prices.type', '=', 'edu_facilities_types.id')
            ->JOIN('edu_stages', 'facility_prices.stage', '=', 'edu_stages.id')
            ->JOIN('subscription_periods', 'facility_prices.subscription_period', '=', 'subscription_periods.id')
            ->where('facility_id', $id)
            ->select(
                'facility_prices.id',
                'facility_prices.facility_id',
                "facility_prices.name$prefix as name",

                'facility_prices.price_discount as price_before_discount ',
                'facility_prices.price as price_after_discount',
                'facility_prices.allowed_number as number_of_allowed_student',

                'facility_prices.start',
                'facility_prices.end',
                "facility_prices.note$prefix as note",

                'facility_prices.type as stage_id',
                "edu_facilities_types.name$prefix as stage_name",
                "facility_prices.stage as class_id",
                "edu_stages.name$prefix as class_name",
                'facility_prices.subscription_period as payment_method_id',
                "subscription_periods.name$prefix as payment_method"
            )
            ->get();
      
      	$tamaraconfig = DB::table('tamaraconfigs')->first();
        $allowed_facilities = explode(',',$tamaraconfig->locked_facilities);
        $payment_options = [];
        $facility_status = in_array($id, $allowed_facilities);
     
        
        
      
      foreach($prices as $price){        
            if($price->price_after_discount >= $tamaraconfig->min && $price->price_after_discount <= $tamaraconfig->max){
               $price_flag = true;
            }else{
              $price_flag = false;
            }       
        
        if($tamaraconfig->status == 1 && $facility_status == true && $price_flag = true){
            $price->tamara = true;
        }else{
          $price->tamara = false;
        }
      }
      
      if ($lang != 'both'){
            $related = EduFacility::join('cities', 'edu_facilities.city', '=', 'cities.id')
                ->join('types', 'edu_facilities.facility_type', '=', 'types.id')
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
                    "cities.name$prefix2 as city_name",
                    'types.id as facility_type_id',
                    "types.name$prefix as facility_type"
               )
              ->where('city', $user->city_id)
              ->where('edu_facilities.id','!=', $id)
              ->where('edu_facilities.status', 1)
              ->take(10)
              ->get();
        }else{
            $related = EduFacility::join('cities', 'edu_facilities.city', '=', 'cities.id')
                ->join('types', 'edu_facilities.facility_type', '=', 'types.id')
                ->select(
                    'edu_facilities.id',
                    "edu_facilities.name as name_ar",
                    "edu_facilities.name_en as name_en",
                    "about as about",
                    "about_en as about_en",
                    'phone',
                    'mobile',
                    'email',
                    "address as address",
                    "address_en as address_en",
                    'map_location',
                    DB::raw("CONCAT('$public_path', commercial_record) as commercial_record"),
                    DB::raw("CONCAT('$public_path', owner_id) as owner_id"),
                    DB::raw("CONCAT('$public_path', logo) as logo"),
                    'rate',
                    'visits',
                    'status',
                    'city as city_id',
                    "cities.nameAR as city_name_ar",
                    "cities.nameEN as city_name_en",
                    'types.id as facility_type_id',
                    "types.name as facility_type_ar",
                    "types.name_en as facility_type_en"
                )->where('city', $user->city_id)
              ->where('edu_facilities.id','!=', $id)
              ->where('edu_facilities.status', 1)
              ->take(10)
              ->get();
        }
      

        return response()->json([
            'facility' => $user,
            'gallery'=>$gallery,
            'stages' => $stages,
            'prices' => $prices,
         	 'related' => $related
        ]);
    }

    public function allClass(Request $request)
    {
        $lang = $request->lang;
        if ($lang == 'ar') {
            $prefix = '';
            $prefix2 = 'AR';
        }else{
            $prefix = '_en';
            $prefix2 = 'EN';
        }

        $data['class'] = DB::table('edu_stages')
            ->where('type_id',$request->stage_id)
            ->select('id',"name$prefix as name")
            ->get();

        return response()->json([
            'classes' => $data['class'],
        ]);
    }

    public function allPayment(Request $request)
    {
        $lang = $request->lang;
        if ($lang == 'ar') {
            $prefix = '';
            $prefix2 = 'AR';
        }else{
            $prefix = '_en';
            $prefix2 = 'EN';
        }

        $data['payment_methods'] = DB::table('subscription_periods')
            ->whereRaw("FIND_IN_SET($request->stage_id,type)")
            ->select('id',"name$prefix as name")
            ->get();

        return response()->json([
            'payment_methods' => $data['payment_methods'],
        ]);
    }

    public function terms(Request $request)
    {
        $lang = $request->lang;
         if ($lang == 'ar') {
            $prefix = '';
        }else{
            $prefix = '_en';
        }

        $data = DB::table('legal_agreements')->select("text$prefix as text")->first();
        $response = [
            'success' => true,
            'data' => [
                'terms' => $data->text,
            ]
        ];
        return response()->json($response, 200);
    }

    public function offers(Request $request)
    {
        $lang = $request->lang;
        if ($lang == 'ar') {
            $prefix = '';
        }else{
            $prefix = '_en';
        }
        $public_path = asset('/');

        $data = FacilityAd::orderBy('id', 'desc')->select('id',"title$prefix as title",DB::raw("CONCAT('$public_path', image) as image"),"text$prefix as text",'price','price_after_discount','start_date','end_date','subscribers_allowed_number','created_at','updated_at')->paginate(10);
       $response = [
            'success' => true,
            'data' => $data
        ];
        return response()->json($response, 200);
    }

    public function offer($id)
    {
        $data = FacilityAd::find($id);
        $response = [
            'success' => true,
            'data' => [
                'offer' => $data,
            ]
        ];
        return response()->json($response, 200);
    }

    public function sendMessage(Request $request)
    {
        $message = new Message;
        if (isset($request->facility_id)) {

            $message->facility_id = $request->facility_id;
        } else {
            $message->facility_id = 0;
        }

        $message->name = $request->name;
        $message->phone = $request->phone;
        $message->email = $request->email;
        $message->subject = $request->subject;
        $message->text = $request->message;
        $message->save();

        $mailsubject = 'شكرا لتواصلك معنا';
        $recipient = $message->email;
        $data = ['message_id' => $message->id, 'mailsubject' => $mailsubject, 'recipient' => $recipient];
        $this->basic_email($data);

        $response = [
            'success' => true,
            'data' => [
                'message' => "Send Success",
            ]
        ];
        return response()->json($response, 200);
    }

    public function basic_email($data)
    {
        Mail::send(['html' => 'emails.welcome'], $data, function ($message) use ($data) {
            $message->to($data['recipient'], 'Edukey')->subject($data['mailsubject']);
            $message->from('theedukey@gmail.com', 'Edukey');
        });
    }

    public function priceList(Request $request)
    {

        $lang = $request->lang;
        if ($lang == 'ar') {
            $prefix = '';
            $prefix2 = 'AR';
        }else{
            $prefix = '_en';
            $prefix2 = 'EN';
        }

        $facility = auth('facility_api')->user();
        $data = DB::table('facility_prices')
            ->JOIN('edu_facilities_types', 'facility_prices.type', '=', 'edu_facilities_types.id')
            ->JOIN('edu_stages', 'facility_prices.stage', '=', 'edu_stages.id')
            ->JOIN('subscription_periods', 'facility_prices.subscription_period', '=', 'subscription_periods.id')
            ->where('facility_prices.id', $request->id)
            ->select(
                'facility_prices.id',
                'facility_prices.facility_id',
                "facility_prices.name$prefix as name",

                'facility_prices.price_discount as price_before_discount ',
                'facility_prices.price as price_after_discount',
                'facility_prices.allowed_number as number_of_allowed_student',

                'facility_prices.start',
                'facility_prices.end',
                "facility_prices.note$prefix as note",

                'facility_prices.type as stage_id',
                "edu_facilities_types.name$prefix as stage_name",
                "facility_prices.stage as class_id",
                "edu_stages.name$prefix as class_name",
                'facility_prices.subscription_period as payment_method_id',
                "subscription_periods.name$prefix as payment_method"
            )
            ->get();
        return response()->json([
            'status' => true,
            'data' => $data
        ]);

    }

    public function allFacilityTypes(Request $request)
    {
        $data = DB::table('types')->get();
        $response = [
            'success' => true,
            'data' => [
                'types' => $data,
            ]
        ];
        return response()->json($response, 200);
    }

    public function facilityTypeData(Request $request)
    {
        $data = DB::table('types')->where('id', $request->id)->first();
        $response = [
            'success' => true,
            'data' => [
                'type' => $data,
            ]
        ];
        return response()->json($response, 200);
    }

    public function stages(Request $request)
    {
        $lang = $request->lang;
        if ($lang == 'ar') {
            $prefix = '';
            $prefix2 = 'AR';
        }else{
            $prefix = '_en';
            $prefix2 = 'EN';
        }

        $stages = DB::table("edu_facilities_types")->select( "id","name$prefix")->get();
        return response()->json([
            'status' => true,
            'data' => $stages
        ], 200);
    }

    public function classes(Request $request)
    {
        $stages = DB::table("edu_stages")->where("type_id", $request->id)->pluck("name", "id");
        return response()->json([
            'status' => true,
            'data' => $stages
        ], 200);
    }

    public function filterdata(Request $request){
         $lang = $request->lang;
        if ($lang == 'ar') {
            $prefix = '';
          $name = 'الكل';
        }else{
            $prefix = '_en';
          $name = 'All';
        }

        $_stages = DB::table("edu_facilities_types")->select("name$prefix as name", "id")->get()->toArray();
      
      	$stages = Arr::prepend($_stages,[
          'name' => $name,
          'id' => -1
        ]);
          
        $_payment_methods =  DB::table('subscription_periods')->select('id',"name$prefix as name")->get()->toArray();
      	$payment_methods = Arr::prepend($_payment_methods,[
          'name' => $name,
          'id' => -1
        ]);
      
        return response()->json([
            'status' => true,
            'data' => ['stages'=>$stages , 'payment_methods' => $payment_methods]
        ], 200);
    }

    public function allCities(Request $request){
        if (isset($request->lang)){
            $lang = $request->lang;
        }else{
            $lang = 'ar';
        }

        if ($lang == 'ar') {
            $prefix = '';
            $prefix2 = 'AR';
        }else{
            $prefix = '_en';
            $prefix2 = 'EN';
        }

        $data = DB::table("cities")->select("id","name$prefix2 as name")->get();
        return response()->json([
            'status' => true,
            'data' => $data
        ], 200);
    }

}
