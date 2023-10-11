<?php

namespace App\Http\Controllers\API;

use App\Models\Commission;
use App\Models\EduFacility;
use App\Models\FacilityWithdrawalLog;
use App\Models\Financiallog;
use App\Models\Gallery;
use JWTAuth;
use Validator;
use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use App\Models\Children;
use App\Models\Favorite;
use App\Models\Order;
use Illuminate\Support\Facades\Config;
use Auth;
use Illuminate\Support\Facades\Hash;
use DB;
use App\Models\FacilityPrice;
use App\Http\Controllers\EduFacility\Auth\ForgotPasswordController;

class FacilityJWTAuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:facility_api', ['except' => ['login', 'register','forgot']]);

    }

    public function forgot(Request $request) {
        $credentials = request()->validate(['email' => 'required|email']);
        $fr = new ForgotPasswordController;
        $fr->sendResetLinkEmail($request);
        return response()->json(["msg" => 'Reset password link sent on your email id.']);
    }


    public function check(Request $request){
        if ($request->has('token')) {
            try {
                $this->auth = JWTAuth::parseToken()->authenticate();
                return $next($request);
            } catch (\Exception $e) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'city' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255','unique:students','unique:admins','unique:edu_facilities'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if($validator->fails()) {
            return response()->json(array(
                "status" => false,
                "errors" => $validator->errors()
            ), 400);
        }

        $facility = new EduFacility;
        $facility->name = $request->name;
        $facility->phone = $request->phone;
        $facility->mobile = $request->mobile;
        $facility->email = $request->email;
        $facility->city = $request->city;
        $facility->password = bcrypt($request->password);
        $facility->save();

        return response()->json([
            'status' => true,
            'message' => 'Student successfully registered',
            'facility' => $facility
        ], 200);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (!$token = Auth::guard('facility_api')->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        if (isset($request->lang)){
            $lang = $request->lang;
        }else{
            $lang = 'ar';
        }

        return $this->createNewToken($token,$lang);
    }

    public function logout()
    {
        try {
            Auth::guard('facility_api')->logout();
            $message = 'User successfully signed out';
        } catch (\Throwable $th) {
            $message = 'User can not signed out';
        }


        return response()->json(['message' => $message]);
    }

    public function refresh(Request $request)
    {
        if (isset($request->lang)){
            $lang = $request->lang;
        }else{
            $lang = 'ar';
        }
        return $this->createNewToken(auth()->refresh(),$lang);
    }

    protected function createNewToken($token, $lang)
    {
        $public_path = asset('/');

        $user_id = auth('facility_api')->user()->id;
        if ($lang == 'ar') {
            $prefix = '';
            $prefix2 = 'AR';
        }else{
            $prefix = '_en';
            $prefix2 = 'EN';
        }
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
            )->where('edu_facilities.id', $user_id)->first();


        return response()->json([
            'access_token' => $token,
            'facility' => $user
        ]);
    }

    public function profile(Request $request)
    {
        $public_path = asset('/');

        $user_id = auth('facility_api')->user()->id;
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
                )->where('edu_facilities.id', $user_id)->first();
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
                )->where('edu_facilities.id', $user_id)->first();
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
            ->where('facilities_types.facility_id', $user_id)
            ->select("edu_facilities_types.id","edu_facilities_types.name$prefix as name")
            ->get();

        return response()->json([
            'facility' => $user,
            'stages' => $stages
        ]);
    }

    public function updateProfile(Request $request)
    {

        $facility = auth('facility_api')->user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2|max:255',
            'name_en' => 'required|min:2|max:255',
            'about' => 'required',
            'about_en' => 'required',
            'phone' => 'required',
            'mobile' => 'required',
            'email' => 'required|email|min:2|max:255|unique:students|unique:admins|unique:edu_facilities,email,'.$facility->id,
            'city' => 'required',
            'address' => 'required',
            'address_en' => 'required',
            'map_location' => 'required',
            'commercial_record' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'owner_id' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(array(
                "status" => false,
                "errors" => $validator->errors()
            ), 400);
        }

        $facility->name = $request->name;
        $facility->name_en = $request->name_en;
        $facility->about = $request->about;
        $facility->about_en = $request->about_en;
        $facility->phone = $request->phone;
        $facility->mobile = $request->mobile;
        $facility->email = $request->email;
        $facility->city = $request->city;
        $facility->address = $request->address;
        $facility->address_en = $request->address_en;
        $facility->map_location = $request->map_location;

        if ($request->has('commercial_record') == true) {
            $imageName = time().rand(1,10000).'.'.request()->commercial_record->getClientOriginalExtension();
            request()->commercial_record->move(public_path('uploads/facilities/'), $imageName);
            $facility->commercial_record = 'uploads/facilities/'.$imageName;
        }

        if ($request->has('owner_id') == true) {
            $imageName = time().rand(1,10000).'.'.request()->owner_id->getClientOriginalExtension();
            request()->owner_id->move(public_path('uploads/facilities/'), $imageName);
            $facility->owner_id = 'uploads/facilities/'.$imageName;
        }

        if ($request->has('logo') == true) {
            $imageName = time().rand(1,10000).'.'.request()->logo->getClientOriginalExtension();
            request()->logo->move(public_path('uploads/facilities/'), $imageName);
            $facility->logo = 'uploads/facilities/'.$imageName;
        }

        $facility->update();

        $public_path = asset('/');
		$facility->commercial_record = $public_path.$facility->commercial_record;
		$facility->owner_id = $public_path.$facility->owner_id;
		$facility->logo = $public_path.$facility->logo;

        //edu
        if ($request->stages) {
            DB::table('facilities_types')->where('facility_id', $facility->id)->delete();
            foreach ($request->stages as $stage) {
                DB::table('facilities_types')->insert(['facility_id' => $facility->id, 'facilities_type' => $stage]);
            }
        }

        return $this->profile($request);
    }

    public function resetPassword(Request $request)
    {

        $facility = auth('facility_api')->user();

        $validator = Validator::make($request->all(), [
            'old_password' => 'required|min:8|string',
            'password' => 'required|min:8|confirmed|string',
        ]);

        if ($validator->fails()) {
            return response()->json(array(
                "status" => false,
                "errors" => $validator->errors()
            ), 400);
        }

        if (Hash::check($request->old_password, $facility->password )) {
            $facility->password = bcrypt($request->password);
            $facility->update();

            return response()->json(array(
                "status" => true,
                "message" => 'ok'
            ), 200);

        }else{
            return response()->json(array(
                "status" => false,
                "errors" => 'old password not mach the current password'
            ), 400);
        }

    }

    public function gallery(Request $request)
    {
        $public_path = asset('/');
        $facility = auth('facility_api')->user();
        $data = DB::table('galleries')
            ->where('facility_id', $facility->id)
            ->select('galleries.*',DB::raw("CONCAT('$public_path', image) as image"))
            ->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function addImageToGallery(Request $request){
        $facility = auth('facility_api')->user();

        $validator = Validator::make($request->all(), [
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(array(
                "status" => false,
                "errors" => $validator->errors()
            ), 400);
        }


        if ($request->has('image') == true && $request->image != null) {
            $gallery = new Gallery;
            $imageName = time().rand(1,10000).'.'.request()->image->getClientOriginalExtension();
            request()->image->move(public_path('uploads/gallery/'), $imageName);
            $gallery->facility_id = $facility->id;
            $gallery->image = 'uploads/gallery/'.$imageName;
            $gallery->save();
        }

        return $this->gallery($request);
    }

    public function removeImageFromGallery(Request $request){
        $facility = auth('facility_api')->user();

        $validator = Validator::make($request->all(), [
            'image' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(array(
                "status" => false,
                "errors" => $validator->errors()
            ), 400);
        }

        $gallery = Gallery::where('id',$request->image)->where('facility_id',$facility->id)->first();
        if ($gallery != null){
            if (is_file(asset('uploads/gallery/'.$gallery->image))){
                unlink(asset('uploads/gallery/'.$gallery->image));
            }
            $gallery->delete();
        }
        return $this->gallery($request);
    }



    public function index(Request $request)
    {

        $facility = auth('facility_api')->user();
        $orders = DB::table('orders')->where('orders.facility_id', $facility->id)
            ->join('facility_prices', 'orders.price_id', 'facility_prices.id')
            ->select(
                DB::raw('SUM(facility_prices.price) AS sum_of_prices')
                , DB::raw("SUM(if(orders.status = 'accepted', 1, 0)) AS accepted_orders")
                , DB::raw("SUM(if(orders.status = 'new', 1, 0)) AS new_orders")
                , DB::raw("SUM(if(orders.status = 'under_revision', 1, 0)) AS under_revision_orders")
                , DB::raw("SUM(if(orders.status = 'rejected', 1, 0)) AS rejected_orders")
                , DB::raw("SUM(if(orders.status = 'accepted', 1, 0)) AS accepted_orders")
                , DB::raw("SUM(if(orders.status = 'is_paid', 1, 0)) AS is_paid_orders")
            )
            ->first();

//        $orders['types'] = $facility->orders()
//            ->join('facility_prices', 'orders.price_id', 'facility_prices.id')
//            ->join('edu_facilities_types', 'facility_prices.type', 'edu_facilities_types.id')
//            ->join('edu_stages', 'facility_prices.stage', 'edu_stages.id')
//            ->join('subscription_periods', 'facility_prices.subscription_period', 'subscription_periods.id')
//            ->groupBy('facility_prices.type')
//            ->select(
//                'orders.*',
//                'edu_facilities_types.name as type_name',
//                DB::raw('SUM(facility_prices.price) AS sum_of_prices'),
//                DB::raw('count(orders.id) AS sum_of_orders'),
//                DB::raw("SUM(if(orders.status = 'accepted', 1, 0)) AS accepted_orders"),
//                DB::raw("SUM(if(orders.status = 'new', 1, 0)) AS new_orders"),
//                DB::raw("SUM(if(orders.status = 'under_revision', 1, 0)) AS under_revision_orders"),
//                DB::raw("SUM(if(orders.status = 'rejected', 1, 0)) AS rejected_orders"),
//                DB::raw("SUM(if(orders.status = 'accepted', 1, 0)) AS accepted_orders"),
//                DB::raw("SUM(if(orders.status = 'is_paid', 1, 0)) AS is_paid_orders")
//            )
//            ->get();

        $prices = $facility->prices()
            ->JOIN('edu_facilities_types', 'facility_prices.type', '=', 'edu_facilities_types.id')
            ->JOIN('edu_stages', 'facility_prices.stage', '=', 'edu_stages.id')
            ->JOIN('subscription_periods', 'facility_prices.subscription_period', '=', 'subscription_periods.id')
            ->where('facility_id', $facility->id)
            ->select('facility_prices.*', 'edu_facilities_types.name as type_name', 'edu_stages.name as stage_name', 'subscription_periods.name as subscription_period_name')
            ->count();

        $financialRecord = $facility->financialRecords->count();
        $total_sucscription = $facility->orders()->where('status', 'is_paid')->count();
        $withdrawas = $facility->withdrawas()->count();
        $messages = $facility->messages()->count();
        return response()->json([
            'orders' => $orders,
            'prices plans' => $prices,
            'financialRecord' => $financialRecord,
            'total_sucscription' => $total_sucscription,
            'withdrawas' => $withdrawas,
            'messages' => $messages,
        ], 200);
    }

    public function allPrices(Request $request)
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
            ->where('facility_id', $facility->id)
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

    public function createPrice(Request $request)
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

        $data['stages'] = DB::table('facilities_types')
            ->join('edu_facilities_types', 'facilities_types.facilities_type', 'edu_facilities_types.id')
            ->where('facilities_types.facility_id', $facility->id)
            ->select('edu_facilities_types.id',"edu_facilities_types.name$prefix as name")
            ->get();

        return response()->json([
            'stages' => $data['stages'],
        ]);
    }


    public function storePrice(Request $request)
    {
        $facility = auth('facility_api')->user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2|max:255',
            'name_en' => 'required|min:2|max:255',
            'stage' => 'required|numeric',
            'class' => 'required|numeric',
            'price_after_discount' => 'required|numeric',
            'price_before_discount' => 'required|numeric',
            'allowed_student_number' => 'required|numeric',
            'payment_method' => 'required|numeric',
            'start' => 'required',
            'end' => 'required',
            'note' => 'required',
            'note_en' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(array(
                "status" => false,
                "errors" => $validator->errors()
            ), 400);
        }

        $ad = new FacilityPrice;
        $ad->facility_id = $facility->id;
        $ad->name = $request->name;
        $ad->name_en = $request->name_en;
        $ad->type = $request->stage;
        $ad->stage = $request->class;
        $ad->price = $request->price_after_discount;
        $ad->price_discount = $request->price_before_discount;
        $ad->start = $request->start;
        $ad->end = $request->end;
        $ad->subscription_period = $request->payment_method;
        $ad->allowed_number = $request->allowed_student_number;
        $ad->note = $request->note;
        $ad->note_en = $request->note_en;
        $ad->save();

        return response()->json([
            'status' => true,
        ]);
    }

    public function showPrice(Request $request)
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

    public function editPrice(Request $request)
    {

        $facility = auth('facility_api')->user();

        $data['price'] = FacilityPrice::where('id', $request->id)->where('facility_id', $facility->id)->first();
        $data['facility'] = $facility;
        $data['types'] = DB::table('edu_facilities_types')->get();
        $data['subjects'] = DB::table('subjects')->get();
        $data['subscription_periods'] = DB::table('subscription_periods')->where('type', $facility->facility_type)->get();
        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function updatePrice(Request $request)
    {

        $facility = auth('facility_api')->user();
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2|max:255',
            'name_en' => 'required|min:2|max:255',
            'stage' => 'required|numeric',
            'class' => 'required|numeric',
            'price_after_discount' => 'required|numeric',
            'price_before_discount' => 'required|numeric',
            'allowed_student_number' => 'required|numeric',
            'payment_method' => 'required|numeric',
            'start' => 'required',
            'end' => 'required',
            'note' => 'required',
            'note_en' => 'required',
        ]);

        $ad = FacilityPrice::where('id', $request->id)->where('facility_id', $facility->id)->first();
        $ad->name = $request->name;
        $ad->name_en = $request->name_en;
        $ad->type = $request->stage;
        $ad->stage = $request->class;
        $ad->price = $request->price_after_discount;
        $ad->price_discount = $request->price_before_discount;
        $ad->start = $request->start;
        $ad->end = $request->end;
        $ad->subscription_period = $request->payment_method;
        $ad->allowed_number = $request->allowed_student_number;
        $ad->note = $request->note;
        $ad->note_en = $request->note_en;
        $ad->update();

        return response()->json([
            'status' => true,
        ]);
    }

    public function destroyPrice(Request $request)
    {

        $facility = auth('facility_api')->user();
        $adAd = FacilityPrice::where('id', $request->id)->where('facility_id', $facility->id)->first();
        $adAd->delete();
        return response()->json([
            'status' => true
        ]);
    }

    public function orders(Request $request)
    {
        $facility = auth('facility_api')->user();

        $query = Order::where('orders.facility_id', $facility->id);

        if (isset($request->stage) && $request->stage != null) {

            $query->where('facility_prices.type', $request->stage);
            $_stage = $request->stage;
        } else {
            $_stage = null;
        }

        if (isset($request->status) && $request->status != null) {
            $query->where('orders.status', $request->status);
            $_status = $request->status;
        } else {
            $_status = null;
        }

        if (isset($request->from) && $request->from != null && isset($request->to) && $request->to != null) {
            $query->whereBetween('orders.created_at', [$request->from, $request->to]);
            $_from = $request->from;
            $_to = $request->to;
        } else {
            $_to = null;
            $_from = null;
        }

        $data = $query
            ->join('students','orders.student','=','students.id')
            ->join('facility_prices','orders.price_id','=','facility_prices.id')
            ->join('edu_facilities_types','facility_prices.type','=','edu_facilities_types.id')
            ->join('edu_stages','facility_prices.stage','=','edu_stages.id')
            ->join('subscription_periods','facility_prices.subscription_period','=','subscription_periods.id')
            ->select(
                'orders.id as order_num',
                'orders.created_at',
                'orders.status as order_status',
                'subscription_periods.id as payment_method_id',
                'subscription_periods.name as payment_method',
                'students.id as student_id',
                'students.name as student_name',
                'students.phone as student_phone',
                'edu_facilities_types.id as stage_id',
                'edu_facilities_types.name as stage_name',
                'edu_stages.id as class_id',
                'edu_stages.name as class_name',
            )->get();

        return response()->json([
            'status' => true,
            'data' => $data,
            '_stage' => $_stage,
            '_status' => $_status,
            '_from' => $_from,
            '_to' => $_to,


        ]);
    }

    public function showOrder(Request $request)
    {
        if (isset($request->lang)){
            $lang = $request->lang;
        }else{
            $lang = '_en';
        }

        if ($lang == 'ar') {
            $prefix = '';
            $prefix2 = 'AR';
        }elseif($lang == 'en'){
            $prefix = '_en';
            $prefix2 = 'EN';
        }

        $facility = auth('facility_api')->user();
        $order_data = Order::where('orders.facility_id', $facility->id)->where('id',$request->id)->select('*')->first();

        $price_data = DB::table('facility_prices')->where('facility_prices.id', $order_data->price_id)
            ->join('edu_facilities_types','facility_prices.type','=','edu_facilities_types.id')
            ->join('edu_stages','facility_prices.stage','=','edu_stages.id')
            ->join('subscription_periods','facility_prices.subscription_period','=','subscription_periods.id')
            ->select(
                'facility_prices.id',
                "facility_prices.name$prefix as name",
                "edu_facilities_types.name$prefix as stage_name",
                "edu_stages.name$prefix as class_name",
                "subscription_periods.name$prefix as payment_method",
                'facility_prices.price_discount as price_before_discount',
                'facility_prices.price as price',
                'facility_prices.allowed_number as students_allowed_number',
                'facility_prices.start as from',
                'facility_prices.end as to',
                "facility_prices.note$prefix as note",
                'subscription_periods.id as payment_method_id',
                'edu_facilities_types.id as stage_id',
                'edu_stages.id as class_id',

            )->first();

        $student_data = DB::table('students')->where('id', $order_data->student)
            ->select(
                'students.id as student_id',
                'students.name as student_name',
                'students.phone as student_phone',
                'students.email as student_email',
                'students.id_number as student_id_number',
            )->first();

        if ($order_data->children != null){
            $child_data = DB::table('childrens')->where('id', $order_data->children)->first();
        }else{
            $child_data = null;
        }

        return response()->json([
            'status' => true,
            'order' => $order_data,
            'price' => $price_data,
            'student' => $student_data,
            'child' => $child_data
        ]);
    }

    public function updateOrder(Request $request)
    {
        $facility = auth('facility_api')->user();
        $order = Order::where('id', $request->id)->where('facility_id', $facility->id)->first();
        $order->status = $request->status;
        $order->update();
        return response()->json([
            'status' => true,
        ]);
    }

    public function destroyOrder(Request $request)
    {
        $facility = auth('facility_api')->user();
        $order = Order::where('id', $request->id)->where('facility_id', $facility->id)->first();
        $order->delete();
        return response()->json([
            'status' => true
        ]);
    }


    public function notifications(Request $request)
    {
        $facility = auth('facility_api')->user();

        $data = DB::table('notifications')->where('target','facility')->where('target_id',$facility->id)->orderBy('id','desc')->get();

        return response()->json([
            'notifications' => $data,
        ]);
    }

    public function ratings(Request $request)
    {
        $facility = auth('facility_api')->user();
        $data = DB::table('comments')
            ->join('students','comments.commented_id','=','students.id')
            ->select('comments.id','comment','approved','rate','comments.created_at','students.name','students.id as student_id')
            ->where('commentable_type','App\Models\EduFacility')->where('commentable_id',$facility->id)->orderBy('id','desc')->get();

        return response()->json([
            'ratings' => $data,
        ]);
    }

    public function messages(Request $request)
    {
        try{
            $facility = auth('facility_api')->user();
        }catch (\Exception $e) {
            return $e->getMessage();
        }


        $data = DB::table('messages')->where('facility_id',$facility->id)->orderBy('id','desc')->get();

        return response()->json([
            'messages' => $data,
        ]);
    }

    public function logs(Request $request){

        $facility = auth('facility_api')->user();

        $data = DB::table('financiallogs')->where('facility_id',$facility->id)->orderBy('id','desc')->get();

        return response()->json([
            'status' => true,
            'data' => $data,
        ]);
    }

    public function withdrawalLogs(Request $request)
    {
        $facility = auth('facility_api')->user();
        $query = FacilityWithdrawalLog::where('facility_id',$facility->id);

        if (isset($request->status) && $request->status != null && $request->status != 'all') {
            $query->where('status',$request->status);
            $_status = $request->status;
        }else{
            $_status = null;
        }

        if (isset($request->from) && $request->from != null && isset($request->to) && $request->to != null) {
            $query->whereBetween('created_at', [$request->from, $request->to]);
            $_from = $request->from;
            $_to = $request->to;
        }else{
            $_to = null;
            $_from =  null;
        }
        $data = $query->get();

        return response()->json([
            'status' => true,
            'data' => $data,
            '_status' => $_status,
            '_from' => $_from,
            '_to' => $_to,


        ]);
    }

    public function addWithdrawalRequest(Request $request){
        $facility = auth('facility_api')->user();
        $validator = Validator::make($request->all(), [
            'bank' => 'required|min:2|max:255',
            'account_name' => 'required|min:5',
            'account_number' => 'required|min:5',
        ]);

        if ($validator->fails()) {
            return response()->json(array(
                "status" => false,
                "errors" => $validator->errors()
            ), 400);
        }


        $total = Financiallog::where('facility_id',$facility->id)->get()->last()->total;
        $withdrawal = new FacilityWithdrawalLog;
        $withdrawal->facility_id = $facility->id;
        $withdrawal->bank = $request->bank;
        $withdrawal->account_name = $request->account_name;
        $withdrawal->account_number = $request->account_number;
        $withdrawal->total = $total;

        $withdrawal->save();

        return response()->json(array(
            "status" => true,
        ), 200);
    }

    public function financialRecords(Request $request){
        $facility = auth('facility_api')->user();

        $records['total_orders'] =  Financiallog::where('facility_id',$facility->id)->sum('Invoice_value');
        $records['last_action'] = Financiallog::where('facility_id',$facility->id)->get()->last();
        $records['total_sucscription'] = $facility->orders()->where('status','is_paid')->count();
        $records['withdrawas'] = $facility->withdrawas()->count();
        $records['commission_rate'] = Commission::first()->commission;
        return response()->json(array(
            "status" => true,
            "data"=>$records
        ), 200);
    }
}
