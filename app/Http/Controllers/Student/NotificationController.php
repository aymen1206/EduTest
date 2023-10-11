<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('student.auth:student');
        $this->middleware('StudentPhoneVerified');
    }

    public function index()
    {
        $student = auth()->guard('student')->user();
        $data = DB::table('notifications')->where('target', 'student')->where('target_id', $student->id)->orderBy('id', 'desc')->get();
        return view('student.notifications', compact('data'));
    }
}
