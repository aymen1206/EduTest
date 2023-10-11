<?php

namespace App\Http\Controllers\EduFacility;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EduFacility;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;

class CustomAuthController extends Controller
{


	public function register(Request $request)
	{
		$validator = Validator::make($request->all(), [			
			'name' => ['required', 'string', 'max:255'],			
			'mobile' => ['required', 'string', 'max:255'],
			'phone' => ['required', 'string', 'max:255'],
			'city' => ['required'],
			'legal_agreement' => ['required'],
			'email' => ['required', 'string', 'email', 'max:255','unique:students','unique:admins','unique:edu_facilities'],
			'password' => ['required', 'string', 'min:8', 'confirmed'],
		]);

		if ($validator->fails()) {			
			 return response()->json(['error'=>$validator->errors()->all()]);
		}

		$facility = new EduFacility;
		$facility->name = $request->name;
        //$facility->facility_type = $request->type_id;
        $facility->phone = $request->phone;
        $facility->mobile = $request->mobile;
        $facility->email = $request->email;
        $facility->city = $request->city;
        $facility->password = bcrypt($request->password);
        $facility->save();
		
		if (Auth::guard('edu_facility')->attempt(['email' => $facility->email, 'password' => $request->password])) {
			return response()->json(['success']);
		}else {
			return response()->json(['error'=> trans('auth.failed')]);
		}

	}

}