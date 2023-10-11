<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Auth;

class CustomAuthcontroller extends Controller
{
     public function __construct()
    {
        $this->middleware('student.auth:student')->except('register');
        $this->middleware('StudentPhoneVerified')->except('register');
    }

	public function profile()
	{
		$student = auth()->guard('student')->user();
		return view('student.profile',compact('student'));
	}

	public function register(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'name' => ['required', 'string', 'max:255'],
			'phone' => ['required', 'string', 'regex:/^966\d{9}$/'],
			'city' => ['required'],
			'legal_agreement' => ['required'],
			'email' => ['required', 'string', 'email', 'max:255','unique:students','unique:admins','unique:edu_facilities'],
			'password' => ['required', 'string', 'min:8', 'confirmed'],
			],
			[
			'phone.regex' => "صيغة الهاتف يجب ان تكون كالتالي: 9661234567899"
	]);


		if ($validator->fails()) {
		    return response()->json(['error'=>$validator->errors()->all()]);
		}
		$student = new Student;
		$student->name = $request->name;
		$student->phone = $request->phone;
		$student->city = $request->city;
		$student->email = $request->email;

		if(config('app.phone_verification')=="off"){
		$student->phone_verify = 1;	
		}
		$student->password = Hash::make($request->password);
		$student->save();

        //event(new Registered($student));
		if (Auth::guard('student')->attempt(['email' => $student->email, 'password' => $request->password])) {
			 return response()->json(['success']);
		}else {
		    return response()->json(['error'=> trans('auth.failed')]);
		}

	}



	public function updateProfile(Request $request)
	{
		$student = auth()->guard('student')->user();

		  request()->validate([
			'name' => ['required', 'string', 'max:255'],
            'name_en' => ['required', 'string', 'max:255'],
			'image' => ['nullable','image','mimes:jpeg,png,jpg,gif','max:2048'],
			'certificate_image' => ['nullable','image','mimes:jpeg,png,jpg,gif','max:2048'],
			'id_image' => ['nullable','image','mimes:jpeg,png,jpg,gif','max:2048'],
			'family_id_image' => ['nullable','image','mimes:jpeg,png,jpg,gif','max:2048'],
			'id_number' => ['nullable', 'string', 'max:255'],
			'guardian_id_number' => ['nullable', 'string', 'max:255'],
            'phone' => ['required', 'string', 'regex:/^(009665|9665|\+9665|05|5)(5|0|3|6|4|9|1|8|7)([0-9]{7})$/'],
			'city' => ['required'],
			'email' => ['required', 'string', 'email', 'max:255','unique:admins','unique:edu_facilities','unique:students,email,'.$student->id],
			'password' => ['nullable', 'string', 'min:8']
		]);

		$student->name = $request->name;
      	$student->name_en = $request->name_en;
      	$student->phone = $request->phone;
		$student->city = $request->city;
		$student->email = $request->email;
		if (isset($request->password) && $request->password != null) {
			$student->password = Hash::make($request->password);
		}

		if ($request->has('id_number') == true) {
		    $student->id_number = $request->id_number;
            $student->guardian_id_number = $request->id_number;
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
            return redirect()->back()->with('toast_success', trans('lang.update_success'));

        } catch (Exception $e) {
            return view('student.auth.register')->withErrors($e);
        }

	}

	public function completeAccountData(Request $request)
    {

		$student = auth()->guard('student')->user();

		request()->validate([
		  'family_id_image' => ['nullable','image','mimes:jpeg,png,jpg,gif','max:2048'],
		  'guardian_id_number' => ['nullable', 'string', 'max:255'],
		]);

		$student->guardian_id_number = $request->guardian_id_number;

		if ($request->has('family_id_image') == true) {
			$imageName = time().rand(1,10000).'.'.request()->family_id_image->getClientOriginalExtension();
			request()->family_id_image->move(public_path('uploads/students/family_id_image/'), $imageName);
			$student->family_id_image = 'uploads/students/family_id_image/'.$imageName;
		}

		$student->update();
		return redirect()->back()->with('toast_success',  trans('lang.update_success'));

    }

	public function completeAccountOrder(Request $request)
    {
		$student = auth()->guard('student')->user();

		request()->validate([
		  'certificate_image' => ['nullable','image','mimes:jpeg,png,jpg,gif','max:2048'],
		  'id_image' => ['nullable','image','mimes:jpeg,png,jpg,gif','max:2048'],
		  'id_number' => ['nullable', 'string', 'max:255'],
		]);

		$student->guardian_id_number = $request->guardian_id_number;

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
		$student->id_number = $request->id_number;
		$student->update();
		return redirect()->back()->with('toast_success',  trans('lang.update_success'));

    }

}
