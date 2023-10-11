<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PhoneAuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('student.auth:student');
    }

    public function index()
    {
        $student = auth()->guard('student')->user();
        return view('student.phone_verify', compact('student'));
    }

    public function otpSuccess()
    {
        $student = auth()->guard('student')->user();
        $student->phone_verify = 1;
        $student->update();
        return redirect('student');
    }
}
