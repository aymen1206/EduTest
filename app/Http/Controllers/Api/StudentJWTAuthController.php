<?php

namespace App\Http\Controllers\API;

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
use App\Http\Controllers\Student\Auth\ForgotPasswordController;
use Illuminate\Auth\Events\Registered;
use App\Http\Controllers\Admin\FinancialLogsController;
use App\Models\Adminfinanciallog;
use App\Models\Commission;
use App\Models\EduFacility;
use App\Models\Financiallog;
use Exception;
use beinmedia\payment\Parameters\PaymentParameters;
use Vinkla\Hashids\Facades\Hashids;

use App\Models\Tamaraconfig;
use Tap\TapPayment\Facade\TapPayment;
use GuzzleHttp\Client;

use Tamara\Configuration;
use Tamara\Client as TamaraClient;
use Tamara\Model\Order\Order as TmaraOrder;
use Tamara\Model\Money;
use Tamara\Model\Order\Address;
use Tamara\Model\Order\Consumer;
use Tamara\Model\Order\MerchantUrl;
use Tamara\Model\Order\OrderItemCollection;
use Tamara\Model\Order\OrderItem;
use Tamara\Model\Order\Discount;
use Tamara\Request\Checkout\CreateCheckoutRequest;
use App\Models\TamaraPayment;

class StudentJWTAuthController extends Controller
{
     /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register','forgot']]);
    }



    public function forgot(Request $request) {
        $credentials = request()->validate(['email' => 'required|email']);
        $fr = new ForgotPasswordController;
        $fr->sendResetLinkEmail($request);
        return response()->json(["msg" => 'Reset password link sent on your email id.']);
    }





    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 200);
        }

        if (!$token = Auth::guard('api')->attempt($validator->validated())) {
            return response()->json(['error' => 'false'], 200);
        }
        
       
        
        $user = $this->createNewToken($token);

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
        
      $city =  DB::table('cities')->select('id',"name$prefix2 as name")->where('id',3)->first();
      $user->city = $city;
            return response()->json([
                'user' =>$user
            ]);
        


    }

    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
			'name' => ['required', 'string', 'max:255'],
			'name_en' => ['required', 'string', 'max:255'],
			'phone' => ['required','unique:students'],
			'city' => ['required', 'max:255'],
			'email' => ['required', 'string', 'email', 'max:255','unique:students','unique:admins','unique:edu_facilities'],
			'password' => ['required', 'string', 'min:8', 'confirmed'],
		]);

        if ($validator->fails()) {
            return response()->json(array(
                "status" => false,
                "errors" => $validator->errors()
            ), 400);
        }
      
        $student = new Student;
		$student->name = $request->name;
		$student->name_en = $request->name_en;
      	$student->phone = $request->phone;
      	$student->phone_verify = 1;
		$student->city = $request->city;
		$student->email = $request->email;
		$student->password = Hash::make($request->password);
		$student->save();

		//event(new Registered($student));
		
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
        
      $city =  DB::table('cities')->select('id',"name$prefix2 as name")->where('id',$request->city)->first();
      $student->city = $city;
        return response()->json([
            'status' => true,
            'message' => 'Student successfully registered',
            'user' => $student,         
        ], 200);
    }


    public function updateProfile(Request $request)
	{
		$student = auth('api')->user();

        $validator = Validator::make($request->all(), [
			'name' => ['required', 'string', 'max:255'],
			'name_en' => ['required', 'string', 'max:255'],
          	'phone' => ['required','unique:students,phone,'.$student->id],    
          	'city' => ['required'],
			'email' => ['required', 'string', 'email', 'max:255','unique:admins','unique:edu_facilities','unique:students,email,'.$student->id],         
			'image' => ['nullable','image','mimes:jpeg,png,jpg,gif','max:2048'],
			'certificate_image' => ['nullable','image','mimes:jpeg,png,jpg,gif','max:2048'],
			'id_image' => ['nullable','image','mimes:jpeg,png,jpg,gif','max:2048'],
			'family_id_image' => ['nullable','image','mimes:jpeg,png,jpg,gif','max:2048'],
			'id_number' => ['nullable', 'string', 'max:255'],
			'guardian_id_number' => ['nullable', 'string', 'max:255'],
          	'old_password' => 'nullable|min:8|string',
            'password' => 'nullable|min:8|confirmed|string',
		]);

        if ($validator->fails()) {
            return response()->json(array(
                "status" => false,
                "errors" => $validator->errors()
            ), 400);
        }
      
      
      if(isset($request->old_password) ){
      	if(!isset($request->password) ){
      	 return response()->json(array(
                "status" => false,
                "errors" => 'password is required'
            ), 400);
      	}
      }
      
      if(isset($request->password) ){
      	if(!isset($request->old_password) ){
      	 return response()->json(array(
                "status" => false,
                "errors" => 'old password is required'
            ), 400);
      	}
      }
      
      if(isset($request->password) && isset($request->old_password)){
        if (Hash::check($request->old_password, $student->password )) {
            $student->password = bcrypt($request->password);
            $student->update();
        }else{
            return response()->json(array(
                "status" => false,
                "errors" => 'old password not mach the current password'
            ), 400);
        }
      }
      

		$student->name = $request->name;
		$student->name_en = $request->name_en;
      	$student->phone = $request->phone;
		$student->city = $request->city;
		$student->email = $request->email;

		if ($request->has('id_number') == true) {
		    $student->id_number = $request->id_number;
		}

		if ($request->has('guardian_id_number') == true) {
            $student->guardian_id_number = $request->guardian_id_number;
        }

		if ($request->has('image') == true) {
				$imageName = time().rand(1,10000).'.'.request()->image->getClientOriginalExtension();
				request()->image->move(public_path('uploads/students/profile/'), $imageName);
				$student->image = 'uploads/students/profile/'.$imageName;
		}

		if ($request->has('family_id_image') == true) {
			$imageName = time().rand(1,10000).'.'.request()->family_id_image->getClientOriginalExtension();
			request()->family_id_image->move(public_path('uploads/students/family_id_image/'), $imageName);
			$student->family_id_image = 'uploads/students/family_id_image/'.$imageName;
		}

		if ($request->has('certificate_image') == true) {
			$imageName = time().rand(1,10000).'.'.request()->certificate_image->getClientOriginalExtension();
			request()->certificate_image->move(public_path('uploads/students/certificate_image/'), $imageName);
			$student->certificate_image = 'uploads/students/certificate_image/'.$imageName;
		}

		if ($request->has('id_image') == true) {
			$imageName = time().rand(1,10000).'.'.request()->id_image->getClientOriginalExtension();
			request()->id_image->move(public_path('uploads/students/id_image/'), $imageName);
			$student->id_image = 'uploads/students/id_image/'.$imageName;
		}


		try {

			$student->update();

    		$public_path = asset('/');

    	if($student->image){
		    $student->image = $public_path.$student->image;
        }
        if($student->certificate_image){
		    $student->certificate_image = $public_path.$student->certificate_image;
        }
        if($student->id_image){
		    $student->id_image = $public_path.$student->id_image;
        }
        if($student->family_id_image){
		    $student->family_id_image = $public_path.$student->family_id_image;
        }
          
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
        
      $city =  DB::table('cities')->select('id',"name$prefix2 as name")->where('id',$student->city)->first();
      $student->city = $city;
			return response()->json([
                'status' => true,
                'message' => 'Student successfully Updated',
                'student' => $student
            ], 200);

		} catch (\Exception $e) {
			return response()->json([
                'status' => false,
                'message' => 'Faild Update Process'
            ], 200);
		}

	}


	public function resetPassword(Request $request)
    {

        $student = auth('api')->user();

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

        if (Hash::check($request->old_password, $student->password )) {
            $student->password = bcrypt($request->password);
            $student->update();

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


    public function completeAccountData(Request $request)
    {

		$student = auth('api')->user();

		$validator = Validator::make($request->all(), [
		  'family_id_image' => ['nullable','image','mimes:jpeg,png,jpg,gif','max:2048'],
		  'guardian_id_number' => ['nullable', 'string', 'max:255'],
		]);

        if ($validator->fails()) {
            return response()->json(array(
                "status" => false,
                "errors" => $validator->errors()
            ), 400);
        }

		$student->guardian_id_number = $request->guardian_id_number;

		if ($request->has('family_id_image') == true) {
			$imageName = time().rand(1,10000).'.'.request()->family_id_image->getClientOriginalExtension();
			request()->family_id_image->move(public_path('uploads/students/family_id_image/'), $imageName);
			$student->family_id_image = 'uploads/students/family_id_image/'.$imageName;
		}

		$student->update();

		$public_path = asset('/');
		if($student->image){
		    $student->image = $public_path.$student->image;
        }
        if($student->certificate_image){
		    $student->certificate_image = $public_path.$student->certificate_image;
        }
        if($student->id_image){
		    $student->id_image = $public_path.$student->id_image;
        }
        if($student->family_id_image){
		    $student->family_id_image = $public_path.$student->family_id_image;
        }

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
        
      $city =  DB::table('cities')->select('id',"name$prefix2 as name")->where('id',$student->city)->first();
      $student->city = $city;

		return response()->json([
           $student
        ], 200);

    }

	public function completeAccountOrder(Request $request)
    {
		$student = auth('api')->user();

		$validator = Validator::make($request->all(), [
		  'certificate_image' => ['nullable','image','mimes:jpeg,png,jpg,gif','max:2048'],
		  'id_image' => ['nullable','image','mimes:jpeg,png,jpg,gif','max:2048'],
		  'id_number' => ['nullable', 'string', 'max:255'],
		]);

        if ($validator->fails()) {
            return response()->json(array(
                "status" => false,
                "errors" => $validator->errors()
            ), 400);
        }

		$student->guardian_id_number = $request->id_number;
        $student->id_number = $request->id_number;

		if ($request->has('certificate_image') == true) {
			$imageName = time().rand(1,10000).'.'.request()->certificate_image->getClientOriginalExtension();
			request()->certificate_image->move(public_path('uploads/students/certificate_image/'), $imageName);
			$student->certificate_image = 'uploads/students/certificate_image/'.$imageName;
		}

		if ($request->has('id_image') == true) {
			$imageName = time().rand(1,10000).'.'.request()->id_image->getClientOriginalExtension();
			request()->id_image->move(public_path('uploads/students/id_image/'), $imageName);
			$student->id_image = 'uploads/students/id_image/'.$imageName;
		}

		$student->update();


		$public_path = asset('/');

		if($student->image){
		    $student->image = $public_path.$student->image;
        }
        if($student->certificate_image){
		    $student->certificate_image = $public_path.$student->certificate_image;
        }
        if($student->id_image){
		    $student->id_image = $public_path.$student->id_image;
        }
        if($student->family_id_image){
		    $student->family_id_image = $public_path.$student->family_id_image;
        }


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
        
      $city =  DB::table('cities')->select('id',"name$prefix2 as name")->where('id',$student->city)->first();
      $student->city = $city;
      
		return response()->json([
		    $student
        ], 200);

    }



    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        try {
            Auth::guard('api')->logout();
            $message = 'User successfully signed out';
        } catch (\Throwable $th) {
            $message = 'User can not signed out';
        }


        return response()->json(['message' => $message]);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return response()->json([
            'user' => $this->createNewToken(auth()->refresh())
        ]);

    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile()
    {
        $student = auth('api')->user();
        $public_path = asset('/');
        if($student->image){
		    $student->image = $public_path.$student->image;
        }
        if($student->certificate_image){
		    $student->certificate_image = $public_path.$student->certificate_image;
        }
        if($student->id_image){
		    $student->id_image = $public_path.$student->id_image;
        }
        if($student->family_id_image){
		    $student->family_id_image = $public_path.$student->family_id_image;
        }
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
        
      $city =  DB::table('cities')->select('id',"name$prefix2 as name")->where('id',$student->city)->first();
      $student->city = $city;
        return response()->json($student);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token)
    {
        $student = auth('api')->user();
        $student->token = $token;
        $student->city = DB::table('cities')->where('id',$student->city)->select('id','nameAr','nameEn')->first();
        $public_path = asset('/');
	    if($student->image){
		    $student->image = $public_path.$student->image;
        }
        if($student->certificate_image){
		    $student->certificate_image = $public_path.$student->certificate_image;
        }
        if($student->id_image){
		    $student->id_image = $public_path.$student->id_image;
        }
        if($student->family_id_image){
		    $student->family_id_image = $public_path.$student->family_id_image;
        }

		return $student;
    }


    public function children(Request $request)
    {
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
      
        $public_path = asset('/');
        $student = auth('api')->user();
      
         $query = Children::where('student_id',$student->id)
        ->select('childrens.id','childrens.student_id',"childrens.name$prefix as name",'childrens.gender','childrens.id_number','childrens.birth_date',DB::raw("CONCAT('$public_path', image) as image"),DB::raw("CONCAT('$public_path', id_image) as id_image"),DB::raw("CONCAT('$public_path', certificate_image) as certificate_image"));
      if(isset($request->pagenate) && $request->pagenate == true){
       $childrens =  $query->paginate(10);
      }else{
      	$childrens = $query->get();
      }
      
        return response()->json([
            'status' => true,
            'data' => $childrens
        ], 200);
    }

    public function storeChild(Request $request)
    {
        $student = auth('api')->user();

		$validator = Validator::make($request->all(), [
            'name' => ['required', 'string','max:255'],
            //'name_en' => ['required', 'string','max:255'],
			'image' => ['nullable','image','mimes:jpeg,png,jpg,gif','max:2048'],
            'gender' => ['required', 'string', 'max:255'],
            'id_number' => ['required', 'string', 'max:255'],
            'id_image' => ['nullable','image','mimes:jpeg,png,jpg,gif','max:2048'],
            'certificate_image' =>['nullable','image','mimes:jpeg,png,jpg,gif','max:2048'],
			'birth_date' => ['required', 'max:255'],
		]);

        if ($validator->fails()) {
            return response()->json(array(
                "status" => false,
                "errors" => $validator->errors()
            ), 400);
        }

		$child = new Children();

		$child->student_id = $student->id;
		$child->name = $request->name;
		$child->name_en = $request->name_en;
		$child->gender = $request->gender;
		$child->id_number = $request->id_number;
		$child->birth_date = $request->birth_date;

        if ($request->has('image') == true) {
            $imageName = time().rand(1,10000).'.'.request()->image->getClientOriginalExtension();
            request()->image->move(public_path('uploads/childrens/profile/'), $imageName);
            $child->image = 'uploads/childrens/profile/'.$imageName;
        }


        if ($request->has('certificate_image') == true) {
            $imageName = time().rand(1,10000).'.'.request()->certificate_image->getClientOriginalExtension();
            request()->certificate_image->move(public_path('uploads/childrens/certificate_image/'), $imageName);
            $child->certificate_image = 'uploads/childrens/certificate_image/'.$imageName;
        }

        if ($request->has('id_image') == true) {
            $imageName = time().rand(1,10000).'.'.request()->id_image->getClientOriginalExtension();
            request()->id_image->move(public_path('uploads/childrens/id_image/'), $imageName);
            $child->id_image = 'uploads/childrens/id_image/'.$imageName;
        }
		$child->save();
		$public_path = asset('/');

		if($child->image){
		    $child->image = $public_path.$child->image;
        }
        if($child->certificate_image){
		    $child->certificate_image = $public_path.$child->certificate_image;
        }
        if($child->id_image){
		    $child->id_image = $public_path.$child->id_image;
        }


		return response()->json([
            'status' => true,
            'data' => $child
        ], 200);
    }

    public function child(Request $request)
    {
        $public_path = asset('/');
        $student = auth('api')->user();
        $child =Children::where('id',$request->id)->where('student_id',$student->id)
        ->select('childrens.*',DB::raw("CONCAT('$public_path', image) as image"),DB::raw("CONCAT('$public_path', id_image) as id_image"),DB::raw("CONCAT('$public_path', certificate_image) as certificate_image"))
        ->first();
        return response()->json([
            'status' => true,
            'data' => $child
        ], 200);
    }


    public function updateChild(Request $request)
    {
        $student = auth('api')->user();

       $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            //'name_en' => ['required', 'string', 'max:255'],
			'image' => ['nullable','image','mimes:jpeg,png,jpg,gif','max:2048'],
            'gender' => ['required', 'string', 'max:255'],
            'id_number' => ['required', 'string', 'max:255'],
            'id_image' => ['nullable','image','mimes:jpeg,png,jpg,gif','max:2048'],
            'certificate_image' =>['nullable','image','mimes:jpeg,png,jpg,gif','max:2048'],
			'birth_date' => ['required', 'date', 'max:255'],
		]);

        if ($validator->fails()) {
            return response()->json(array(
                "status" => false,
                "errors" => $validator->errors()
            ), 400);
        }

		$child =  Children::find($request->id);
        if($child->student_id != $student->id){
            return response()->json(array(
                "status" => false,
                "errors" => 'you not have permission to access this data'
            ), 400);
        }
		$child->name = $request->name;
		$child->name_en = $request->name_en;
		$child->gender = $request->gender;
		$child->id_number = $request->id_number;
		$child->birth_date = $request->birth_date;

        if ($request->has('image') == true) {
            $imageName = time().rand(1,10000).'.'.request()->image->getClientOriginalExtension();
            request()->image->move(public_path('uploads/childrens/profile/'), $imageName);
            $child->image = 'uploads/childrens/profile/'.$imageName;
        }


        if ($request->has('certificate_image') == true) {
            $imageName = time().rand(1,10000).'.'.request()->certificate_image->getClientOriginalExtension();
            request()->certificate_image->move(public_path('uploads/childrens/certificate_image/'), $imageName);
            $child->certificate_image = 'uploads/childrens/certificate_image/'.$imageName;
        }

        if ($request->has('id_image') == true) {
            $imageName = time().rand(1,10000).'.'.request()->id_image->getClientOriginalExtension();
            request()->id_image->move(public_path('uploads/childrens/id_image/'), $imageName);
            $child->id_image = 'uploads/childrens/id_image/'.$imageName;
        }


		$child->update();
        $public_path = asset('/');

        if($child->image){
		    $child->image = $public_path.$child->image;
        }
        if($child->certificate_image){
		    $child->certificate_image = $public_path.$child->certificate_image;
        }
        if($child->id_image){
		    $child->id_image = $public_path.$child->id_image;
        }

		return response()->json([
            'status' => true,
            'data' => $child
        ], 200);
    }

    public function deleteChild(Request $request)
    {
        $student = auth('api')->user();
      
        $child = Children::where([['student_id','=',$student->id],['id','=',$request->id]])->first();
      
      if($child != null){
        $child->delete();
           return response()->json([
            'status' => true
        ], 200);
      }else{
       return response()->json([
            'status' => false,
         	'message' => 'no data found'
        ], 500);
      }

       
    }


    public function favorites(Request $request)
	{
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
      
	    $public_path = asset('/');
		$student = auth('api')->user();
		$data = Favorite::where('student_id',$student->id)
		->join('edu_facilities','favorites.facility_id','=','edu_facilities.id')
        ->join('cities', 'edu_facilities.city', '=', 'cities.id')
		->select('favorites.id','favorites.facility_id','favorites.student_id','favorites.created_at',"edu_facilities.name$prefix as name","edu_facilities.rate","edu_facilities.address$prefix as address","cities.name$prefix2 as city",DB::raw("CONCAT('$public_path', edu_facilities.logo) AS logo"))
		->paginate(10);
		return response()->json([
            'status' => true,
            'data' => $data
        ], 200);
	}

	public function addToFavorite(Request $request)
	{
        $student = auth('api')->user();
     	$fv_flag = Favorite::where('student_id',$student->id)->where('facility_id', $request->id)->first();
        if($fv_flag == null){
          $fv = new Favorite;
          $fv->student_id = $student->id;
          $fv->facility_id = $request->id;
          $fv->save();
        }		
		return response()->json([
            'status' => true
        ], 200);
	}

	public function removeFromFavorite(Request $request)
	{
        $student = auth('api')->user();
      try{
        Favorite::where('student_id',$student->id)->where('id',$request->id)->delete();
        return response()->json([
            'status' => true
        ], 200);
      }catch(\Exeption $ex){
        return response()->json([
            'status' => $ex
        ], 500);
      }
		
		
	}
  
  public function removeFromFavoriteByFacility(Request $request)
	{
        $student = auth('api')->user();
      try{
        Favorite::where('student_id',$student->id)->where('facility_id',$request->id)->delete();
        return response()->json([
            'status' => true
        ], 200);
      }catch(\Exeption $ex){
        return response()->json([
            'status' => $ex
        ], 500);
      }
		
		
	}

    public function notifications(Request $request)
	{
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
      
        $student = auth('api')->user();
	    $data = DB::table('notifications')->where('target','student')->where('target_id',$student->id)->select('id',"title$prefix as title","text$prefix as text","status","created_at")->orderBy('id','desc')->paginate(10);
		return response()->json([
            'status' => true,
            'data' => $data
        ], 200);
	}

    public function orders(Request $request)
	{
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
      
        $student = auth('api')->user();
		$data =  $student->orders()
          ->join('edu_facilities','orders.facility_id','=','edu_facilities.id')
          ->join('facility_prices','orders.price_id','=','facility_prices.id')
          ->join('edu_stages','facility_prices.stage','=','edu_stages.id')
          ->join('edu_facilities_types','facility_prices.type','=','edu_facilities_types.id')
          ->join('subscription_periods','facility_prices.subscription_period','=','subscription_periods.id')
          
          ->select(
          "orders.id as order_num",
          "orders.children as order_child_id",
          "orders.status as order_status",
          "orders.InvoiceId as InvoiceId",
          "edu_facilities.name$prefix as service_provider",
          "facility_prices.name$prefix as service_name",
          "facility_prices.start as from",
          "facility_prices.end as to",
          "facility_prices.price as price_after_discount",
          "facility_prices.price_discount as price_before_discount",
          "edu_stages.name$prefix as class",
          "edu_facilities_types.name$prefix as stage",
          "subscription_periods.name$prefix as subscription_typr",
          "orders.created_at as orderd_at",
          "orders.updated_at as last_update",
        )
          ->orderBy('orders.id','desc')
          ->paginate(10);
      
      foreach($data as $order){
        if($order->order_child_id == 0 OR $order->order_child_id == null){
          	$order->subscription_type = 'main_account';
        }else{
        	$order->subscription_type = 'child_account';
          $order->child_data = DB::table('childrens')->where('id',$order->order_child_id)->select('id',"name_en","name as name_ar",'gender')->first();
        }
      }
      
      foreach($data as $order_data){

        if($order_data->order_status == 'accepted'){
          $order_data->payment_url = $this->getPaymentMethods($order_data->order_num,$student);
        }else{
           $order_data->payment_url = null;
        }
        
        $order_data->invoice = DB::table('bn_myfatoorah_payments')->where('order_id',$order_data->order_num)->first();
        
      }
      
		return response()->json([
            'status' => true,
            'data' => $data
        ], 200);
	}

    public function addOrder(Request $request)
	{
        $student = auth('api')->user();
		$validator = Validator::make($request->all(), [
			'price_id' => ['required', 'string', 'string', 'max:255'],
			'facility_id' => ['required', 'string', 'string', 'max:255'],
			'children' => ['nullable', 'string', 'string', 'max:255'],
		]);
        if ($validator->fails()) {
            return response()->json(array(
                "status" => false,
                "errors" => $validator->errors()
            ), 400);
        }
		$order = new Order;
		$order->facility_id = $request->facility_id;
		$order->student = $student->id;
		$order->price_id = $request->price_id;
        if (isset($request->children)) {
            $order->children = $request->children;
        }else {
            $order->children = 0;
        }

        $order->status = 'new';
		$order->save();
        return response()->json([
            'status' => true,
            'data' => $order
        ], 200);
	}

    public function showOrder(Request $request)
    {
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

        $student = auth('api')->user();
        $order_data = Order::where('orders.student', $student->id)->where('id',$request->id)->select('*')->first();
      if($order_data == null){
        return response()->json([
            'status' => false,
            'message' => 'order not found'
        ], 200);
      }

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
                'edu_stages.id as class_id'
            )->first();

        $student_data = DB::table('students')->where('id', $order_data->student)
            ->select(
                'students.id as student_id',
                'students.name as student_name',
                'students.phone as student_phone',
                'students.email as student_email',
                'students.id_number as student_id_number'
            )->first();

        if ($order_data->children != null){
            $child_data = DB::table('childrens')->where('id', $order_data->children)
            ->select('childrens.*',DB::raw("CONCAT('$public_path', image) as image"),DB::raw("CONCAT('$public_path', id_image) as id_image"),DB::raw("CONCAT('$public_path', certificate_image) as certificate_image"))
            ->first();
        }else{
            $child_data = null;
        }
      
     // if($order_data->status == 'accepted'){
    //    $order_data->payment_url = $this->getPaymentMethods($request->id,$student);
     // }else{
    //     $order_data->payment_url = null;
     // }
      
        $tamaraconfig = DB::table('tamaraconfigs')->first();
        $allowed_facilities = explode(',',$tamaraconfig->locked_facilities);
        $payment_options = [];
        $facility_status = in_array($order_data->facility_id, $allowed_facilities);
        $order_price = DB::table('facility_prices')->where('id',$order_data->price_id)->first();
       $price_flag = false;
        if($order_price != null){
            if($order_price->price >= $tamaraconfig->min && $order_price->price <= $tamaraconfig->max){
               $price_flag = true;
            }
        }else{
            $price_flag = false;
        }
         $payment_options = [];
      
        if($tamaraconfig->status == 1 && $facility_status == true && $price_flag == true){
          $payment_options[0]['method'] ='Tamara';
          if($lang == 'ar'){
            $payment_options[0]['name'] = 'تمارا';
          }else{
            $payment_options[0]['name'] = 'Tamara';
          }
            
            $payment_options[0]['min'] = $tamaraconfig->min;
            $payment_options[0]['max'] = $tamaraconfig->max;
            $payment_options[0]['image'] = asset('images/tamara.png');
          
          
          
          $payment_options[1]['method'] ='TapPayment';
      	  if($lang == 'ar'){
            $payment_options[1]['name'] = 'تاب';
          }else{
           $payment_options[1]['name'] = 'TapPayment';
          }
        
        $payment_options[1]['min'] = null;
        $payment_options[1]['max'] = null;
        $payment_options[1]['image'] = asset('images/tap.png');
          
        }else{
          
          
           $payment_options[0]['method'] ='TapPayment';
      	  if($lang == 'ar'){
            $payment_options[0]['name'] = 'تاب';
          }else{
           $payment_options[0]['name'] = 'TapPayment';
          }
        
        $payment_options[0]['min'] = null;
        $payment_options[0]['max'] = null;
        $payment_options[0]['image'] = asset('images/tap.png');
          
          
        }
      
      //$order_data->tamara_payment = $this->Tamara($request->id,$student);
     
        
      

        return response()->json([
            'status' => true,
            'order' => $order_data,
            'price' => $price_data,
            'student' => $student_data,
            'child' => $child_data,
            'payment_options' => $payment_options,          
        ]);
    }
  
  
  public function facilities(Request $request){
  	$student = auth('api')->user();
 
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

        if ($lang != 'both'){
            $data = EduFacility::join('cities', 'edu_facilities.city', '=', 'cities.id')
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
                )->get();
        }else{
            $data = EduFacility::join('cities', 'edu_facilities.city', '=', 'cities.id')
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
                )->get();
        }

        if ($lang == 'ar') {
            $prefix = '';
            $prefix2 = 'AR';
        }else{
            $prefix = '_en';
            $prefix2 = 'EN';
        }

    $favorites = DB::table('favorites')->where('student_id',$student->id)->pluck('facility_id')->toArray();
    $orders = DB::table('orders')->where('student',$student->id)->pluck('facility_id')->toArray();
    foreach($data as $dt){
       if(in_array($dt->id, $favorites)){
        $dt->is_favorite = true;
       }else{
         $dt->is_favorite = false;
       }
      
      if(in_array($dt->id, $orders)){
        $dt->can_rate = true;
       }else{
         $dt->can_rate = false;
       }
      
    }
   
    
   
        return response()->json([
            'facility' => $data,           
        ]);
    
  }
  
  
  
  
    public function facility($id,Request $request){
  	$student = auth('api')->user();
 
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
    
    $favorites = DB::table('favorites')->where('student_id',$student->id)->pluck('facility_id')->toArray();
    $orders = DB::table('orders')->where('student',$student->id)->pluck('facility_id')->toArray();
   if(in_array($id, $favorites)){
   	$user->is_favorite = true;
   }else{
     $user->is_favorite = false;
   }
    
   if(in_array($user->id, $orders)){
   	$user->can_rate = true;
   }else{
     $user->can_rate = false;
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
               )->where('city', $user->city_id)
              ->where('edu_facilities.id','!=', $id)
              ->where('edu_facilities.status', 1)
              ->take(10)
              ->get();
        }else{
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
                )->where('city', $user->city_id)
              ->where('edu_facilities.id','!=', $id)
              ->where('edu_facilities.status', 1)
              ->take(10)
              ->get();
        }
      
      
       $tamaraconfig = DB::table('tamaraconfigs')->first();
        $allowed_facilities = explode(',',$tamaraconfig->locked_facilities);
        $payment_options = [];
        $facility_status = in_array($id, $allowed_facilities);
     
        
        if($tamaraconfig->status == 1 && $facility_status == true){
          
          $payment_options[0]['method'] ='Tamara';
          if($lang == 'ar'){
            $payment_options[0]['name'] = 'تمارا';
          }else{
           $payment_options[0]['name'] = 'Tamara';
          }           
            $payment_options[0]['min'] = $tamaraconfig->min;
            $payment_options[0]['max'] = $tamaraconfig->max;
            $payment_options[0]['image'] = asset('images/tamara.png');
        }
      
      $payment_options[1]['method'] ='TapPayment';
      if($lang == 'ar'){
            $payment_options[1]['name'] = 'تاب';
          }else{
           $payment_options[1]['name'] = 'TapPayment';
          }  
             
        $payment_options[1]['min'] = null;
        $payment_options[1]['max'] = null;
        $payment_options[1]['image'] = asset('images/tap.png');
      
        return response()->json([
            'facility' => $user,
          	'gallery'=> $gallery,
            'stages' => $stages,
            'prices' => $prices,
          	'related' => $related,
          	'payment_options' => $payment_options
        ]);
    
  }
  
  
  
  public function getPaymentMethods($order_id,$student)
    {
        $id = $order_id;
        $order = Order::find($id);
        $client = $student;
  
            $payment = TapPayment::createCharge();
            $payment->setCustomerName($client->name);
            $payment->setCustomerPhone("965", convert2english($client->phone));
            //$payment->setCustomerEmail($client->email);
            $payment->setDescription($order->pricelist->name . ' ' . $order->pricelist->price . ' ريال سعودي ');
            $payment->setAmount($order->pricelist->price);
            $payment->setCurrency("SAR");
            $payment->setSource("src_card");
            $payment->setRedirectUrl(url('student/successful-payment'));
            $invoice = $payment->pay();       
            DB::table('bn_myfatoorah_payments')->insert([
                'payment_method' => 'src_card',
                'currency' => "SAR",
                'payment_url' => $invoice->getPaymetUrl(),
                'invoice_status' => NULL,
                'order_id' => $order->id,
                'invoice_id' => $invoice->getId(),
                'invoice_value' => $order->pricelist->price,
                'customer_name' => $client->name,
                'customer_email' => $client->email,
                'customer_phone' => convert2english($client->phone),
            ]);
     
        return  $invoice->getPaymetUrl();      
    }
  
  
  public function invoice(Request $request){
        $client = auth('api')->user();
        $order =  DB::table('orders')->where('id',$request->order_id)->first();
        $invoice = DB::table('bn_myfatoorah_payments')->where('order_id',$request->order_id)->where('invoice_id',$request->invoice_id)->first();
        $contact = DB::table('contacts')->first();
    
    return response()->json([
            'order' => $order,
          	'client'=> $client,
            'invoice' => $invoice,
            'contact' => $contact,
        ]);       

    }
    
    public function TamaraOrder(Request $request){
        $client = auth('api')->user();
        $order =  DB::table('orders')->where('id',$request->order_id)->first();
        $tamaraconfig = DB::table('tamaraconfigs')->first();
        $allowed_facilities = explode(',',$tamaraconfig->locked_facilities);
        $payment_options = [];
        $facility_status = in_array($order->facility_id, $allowed_facilities);
        $order_price = DB::table('facility_prices')->where('id',$order->price_id)->first();
        if($order_price != null){
            if($order_price->price >= $tamaraconfig->min && $order_price->price <= $tamaraconfig->max){
               $price_flag = true;
            }
        }else{
            $price_flag = false;
        }
        
        if($tamaraconfig->status == 1 && $facility_status == true && $price_flag == true){
          $payment_options[0]['method'] ='Tamara';
          if(isset($request->lang) && $request->lang == 'ar'){
            $payment_options[0]['name'] = 'تمارا';
          }else{
           $payment_options[0]['name'] = 'Tamara';
          }  
                      
            $payment_options[0]['min'] = $tamaraconfig->min;
            $payment_options[0]['max'] = $tamaraconfig->max;
            $payment_options[0]['image'] = asset('images/tamara.png');
        }
        
      	$payment_options[1]['method'] ='TapPayment';
        if(isset($request->lang) && $request->lang == 'ar'){
            $payment_options[1]['name'] = 'تاب';
          }else{
           $payment_options[1]['name'] = 'TapPayment';
          }  
      
        $payment_options[1]['min'] = null;
        $payment_options[1]['max'] = null;
        $payment_options[1]['image'] = asset('images/tap.png');
        
        
    
    	return response()->json([
            'payment_options' => $payment_options,
        ]);       

    }
  
  
  public function Tamara($id,$myclient)
    {
        $config = Tamaraconfig::query()->first();      
        $myorder = Order::find($id);       
        $orderData = [];
        $order = new TmaraOrder;
        $order->setOrderReferenceId($id);
        $order->setLocale('en_US');
        $order->setCurrency('SAR');
        $order->setTotalAmount(new Money($myorder->pricelist->price, 'SAR'));
        $order->setCountryCode('SA');
        $order->setPaymentType('PAY_BY_INSTALMENTS');
        $order->setInstalments($config->instalments);
        $order->setDescription($myorder->pricelist->name_en);
        $order->setTaxAmount(new Money(0.00, 'SAR'));
        $order->setShippingAmount(new Money(0.00, 'SAR'));

        # order items
        $orderItemCollection = new OrderItemCollection();
        $orderItem = new OrderItem();
        $orderItem->setName($myorder->pricelist->name_en);
        $orderItem->setQuantity(1);
        $orderItem->setSku('SKU-123');
        $orderItem->setUnitPrice(new Money($myorder->pricelist->price, 'SAR'));
        $orderItem->setType($myorder->pricelist->name_en);
        $orderItem->setTotalAmount(new Money($myorder->pricelist->price, 'SAR'));
        $orderItem->setTaxAmount(new Money(0.0, 'SAR'));
        $orderItem->setDiscountAmount(new Money(0.0, 'SAR'));
        $orderItem->setReferenceId($myorder->id);

        $orderItemCollection->append($orderItem);
        $order->setItems($orderItemCollection);

        # shipping address
        $shipping = new Address();
        $shipping->setFirstName($myclient->name);
        $shipping->setLastName($myclient->name);
        $shipping->setLine1('المملكة العربية السعودية - الرياض');
        $shipping->setCity('الرياض');
        $shipping->setPhoneNumber($myclient->phone);
        $shipping->setCountryCode('SA');
        $order->setShippingAddress($shipping);

        # consumer
        $consumer = new Consumer();
        $consumer->setFirstName($myclient->name);
        $consumer->setLastName($myclient->name);
        $consumer->setEmail($myclient->email);
        $consumer->setPhoneNumber($myclient->phone);
        $order->setConsumer($consumer);

        # merchant urls
        $merchantUrl = new MerchantUrl();
        $merchantUrl->setSuccessUrl(url('/').'/tamara-success');
        $merchantUrl->setFailureUrl(url('/').'/tamara-failure');
        $merchantUrl->setCancelUrl(url('/').'/tamara-cancel');
        $merchantUrl->setNotificationUrl(url('/')."/tamara-notification");
        $order->setMerchantUrl($merchantUrl);

        # discount
        $order->setDiscount(new Discount('Coupon', new Money(0.00, 'SAR')));

        $client = TamaraClient::create(Configuration::create($config->url, $config->token));
        $request = new CreateCheckoutRequest($order);

        $response = $client->createCheckout($request);
        if (!$response->isSuccess()) {
           // $this->log($response->getErrors());
          //  return $this->handleError($response->getErrors());
            return null;
        }

        $checkoutResponse = $response->getCheckoutResponse();

        if ($checkoutResponse === null) {
           // $this->log($response->getContent());
            return null;
        }

        $tamaraOrderId = $checkoutResponse->getOrderId();
        $redirectUrl = $checkoutResponse->getCheckoutUrl();
        // do redirection to $redirectUrl

        $tp = TamaraPayment::query()
            ->where('student_id',$myclient->id)
            ->where('order_id', $myorder->id)
            ->first();

        if ($tp == null){
            $tp = new TamaraPayment;
        }

        $tp->student_id = $myclient->id;
        $tp->facility_id = $myorder->facility_id ;
        $tp->order_id = $myorder->id;
        $tp->status = 'new';
        $tp->checkout_url = $redirectUrl;
        $tp->tamaraOrderId = $tamaraOrderId;
        $tp->save();
        return $redirectUrl;      
    }
  
  public function PaymentUrl(Request $request){
    $student = auth('api')->user();
    
    if($request->type == 'Tamara'){
      $url = $this->Tamara($request->order_id,$student);
    }elseif($request->type == 'TapPayment'){
   		$url =  $this->getPaymentMethods($request->order_id,$student);
    }
    
  	return response()->json([
      'payment_url' => $url,
    ]);  
  }
  
  
  
  
  
  
  
  
  
  
  
  
  public function tamaraNotification(Request $request)
    {
        $token = $request->header('Authorization');
        $order_id = $request->order_id;
        $event_type = $request->event_type;
        if ($event_type === 'order_approved') {
            $this->autorize($order_id);
        }
    }


    public function autorize($id)
    {
        $config = Tamaraconfig::query()->first();

        $dt = Http::withHeaders([
            'Authorization' => "Bearer $config->token"
        ])->post("$config->url/orders/$id/authorise");
        $info = json_decode($dt);

        $tamara = TamaraPayment::query()->where('order_id', $id)->first();
        $order = Order::find($tamara->order_id);
        if (isset($info->status) && $info->status == 'authorised') {
            $tamara->authorised_status = $info->status;
            $tamara->order_expiry_time = $info->order_expiry_time;
            $tamara->auto_captured = $info->auto_captured;
            $tamara->capture_id = $info->capture_id;
            $tamara->update();

            $payment = Http::withHeaders([
                'Authorization' => "Bearer $config->token"
            ])->post("$config->url/payments/capture", [
                "order_id" => $id,
                "total_amount" => [
                    "amount" => $order->pricelist->price,
                    "currency" => "SAR"
                ],
                "shipping_info" => [
                    "shipped_at" => date('Y-m-d H:i:s'),
                    "shipping_company" => "DHL"
                ]
            ]);
        }

        return redirect()->back()->with('toast_success', trans('lang.update_success'));
    }

    public function TamaraCallback(Request $request)
    {
        $tp = TamaraPayment::query()
            ->where('order_id', $request->orderId)
            ->first();
      if($tp == null){
      	return response()->json([
      		'error' => 'no order found',
    	]);  
      }
        $tp->status = $request->paymentStatus;
        $tp->update();
        $dt = $request->paymentStatus == 'approved' ? true : false;
        $order = Order::where('id', $tp->order_id)->first();
        $order->tamara = 1;
        $order->status = 'is_paid';
        $order->update();




        $latest_logs = Financiallog::where('facility_id', $order->facility_id)->get()->last();

        if ($latest_logs != null) {
            $last_total = $latest_logs->total;
            $last_total_commission = $latest_logs->total_commission;
        } else {
            $last_total = 0;
            $last_total_commission = 0;
        }


        $adminlatest_logs = Adminfinanciallog::all()->last();

        if ($adminlatest_logs != null) {
            $adminlast_total = $adminlatest_logs->total;
            $adminlast_total_commission = $adminlatest_logs->total_commission;
            $final_total = $adminlatest_logs->final_total;
        } else {
            $adminlast_total = 0;
            $adminlast_total_commission = 0;
            $final_total = 0;
        }

        $commission_rate = Commission::first()->commission;
        $commission = ($commission_rate / 100) * $order->pricelist->price;
        $total_after_commission = $order->pricelist->price - $commission;

        //is log exist
        $flag = Financiallog::where('InvoiceId', $request->orderId)->where('facility_id', $order->facility_id)->first();
        if ($flag == null) {
            // add logs to facility logs
            $financial_logs = new Financiallog;
            $financial_logs->facility_id = $order->facility_id;
            $financial_logs->InvoiceId = $request->orderId;
            $financial_logs->Invoice_value = $order->pricelist->price;
            $financial_logs->text = " تم اضافة  $total_after_commission   ريال بعد خصم $commission_rate % من المبلغ الاساسي وذلك بقيمة  $commission نظير العمولة المستحقة للمنصة ";
            $financial_logs->withdraw = 0;
            $financial_logs->addition = $total_after_commission;
            $financial_logs->commission_rate = $commission_rate;
            $financial_logs->commission = $commission;
            $financial_logs->total = $last_total + $total_after_commission;
            $financial_logs->total_commission = $last_total_commission + $commission;
            $financial_logs->save();

            // add logs to admin logs
            $adminlog = new Adminfinanciallog;
            $adminlog->facility_id = $order->facility_id;
            $adminlog->InvoiceId = $request->orderId;
            $adminlog->Invoice_value = $order->pricelist->price;
            $adminlog->text = " تم اضافة  $total_after_commission   ريال بعد خصم $commission_rate % من المبلغ الاساسي وذلك بقيمة  $commission نظير العمولة المستحقة للمنصة ";
            $adminlog->withdraw = $commission;
            $adminlog->addition = $total_after_commission;
            $adminlog->commission_rate = $commission_rate;
            $adminlog->commission = $commission;
            $adminlog->total = $adminlast_total + $total_after_commission;
            $adminlog->total_commission = $adminlast_total_commission + $commission;
            $adminlog->final_total = $final_total + $order->pricelist->price;
            $adminlog->save();

            DB::table('notifications')->insert([
                'target' => 'facility',
                'target_id' => $order->facility_id,
                'title' => 'اضافة رصيد',
                'text' => " تم اضافة  $total_after_commission   ريال بعد خصم $commission_rate % من المبلغ الاساسي وذلك بقيمة  $commission نظير العمولة المستحقة للمنصة "
            ]);

            DB::table('notifications')->insert([
                'target' => 'student',
                'target_id' => $order->student,
                'title' => 'تم الدفع بنجاح واكتمال الطلب',
                'text' => " تم الدفع بنجاح للطلب رقم  $order->id وعليه تم تغيير حالة الطلب الي مكتمل "
            ]);
        }


        return response()->json([
      		'status' => 'success',
    	]);
    }


    public function TamaraCallbackCancelation(Request $request){
        $tp = TamaraPayment::query()
            ->where('order_id', $request->orderId)
            ->first();
      if($tp == null){
      	return response()->json([
      		'error' => 'no order found',
    	]);  
      }
        $tp->status = $request->paymentStatus;
        $tp->update();
        $dt = 'false';
       return response()->json([
      		'status' => 'success',
    	]);
    }

    public function TamaraInvoice($order_id){
        $id = Hashids::decode($order_id)[0];
        $client = auth()->guard('student')->user();
        $order = $data = $client->orders()->where('id', $id)->first();
        $contact = DB::table('contacts')->first();
        $tamara_payment = TamaraPayment::query()->where('order_id',$id)->first();
        $config = Tamaraconfig::query()->first();

        $dt = Http::withHeaders([
            'Authorization' => "Bearer $config->token"
        ])->get("$config->url/merchants/orders/reference-id/$id");
        $invoice = json_decode($dt);
      
      return response()->json([
      		'status' => 'success',
        	'order' => $order,
        	'client' => $client,
        	'contact' => $contact,
        	'invoice' => $invoice,
    	]);   
    }
    
    
    public function deleteAccount(Request $request)
    {

        $student = auth('api')->user();
        $st_id = $student->id;
         try {
            Auth::guard('api')->logout();
            $student->email = 'deleted_'.$student->email;
             $student->phone = 'deleted_'.$student->phone;
            $student->update();
            Student::find($st_id)->delete();
            $message = 'success';
        } catch (\Throwable $th) {
            dd($th);
        }

        if ($message == 'success') {
            return response()->json(array(
                "status" => true,
                "message" => 'ok'
            ), 200);

        }else{
            return response()->json(array(
                "status" => false,
                "errors" => 'Error while deleting your account'
            ), 400);
        }

    }


}
