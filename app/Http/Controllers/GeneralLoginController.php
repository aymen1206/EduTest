<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Alert;
use Illuminate\Support\Facades\Auth;

class GeneralLoginController extends Controller
{
	public function index(Request $request)
	{
		request()->validate([
			'email' => ['required', 'string', 'email', 'max:255'],
			'password' => ['required', 'string', 'min:8'],			
		]);
		
		$email = $request->email;
		$password = $request->password;		
		$remember = $request->remember;
		
		if (Auth::guard('admin')->attempt(['email' => $email, 'password' => $password], $remember)) {
			return redirect()->intended('/admin');
		}
		
		if (Auth::guard('edu_facility')->attempt(['email' => $email, 'password' => $password], $remember)) {
			return redirect()->intended('edu-facility');
		}
		
		if (Auth::guard('student')->attempt(['email' => $email, 'password' => $password], $remember)) {
			return redirect()->intended('student');
		}
			
		return redirect()->back()->with('toast_error',  trans('auth.failed'));
	}
}
