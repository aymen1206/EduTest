<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\EduFacility;
use App\Models\Student;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('student.auth:student');
        $this->middleware('StudentPhoneVerified');
    }

    /**
     * Show the Student dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        return view('student.home');
    }


     public function skipRate($facility_ID)
    {
        $_student = auth()->guard('student')->user();
         $student = Student::find($_student->id);
        DB::table('orders')->where('facility_id',$facility_ID)
        ->where('student',$student->id)
        ->update(['rate'=>'is_skipped']);
        return redirect()->back()->with('toast_success','تم تخطي التقيم بنجاح');;
    }

     public function rate(Request $request)
    {
        $_student = auth()->guard('student')->user();
         $student = Student::find($_student->id);
        $rating = $request->rating;
        $comment = $request->comment;
        $_facility = EduFacility::find($request->facility);
        $student->comment($_facility, $comment, $rating);
        DB::table('edu_facilities')->where('id',$request->facility)->update(['rate'=>$_facility->averageRate()]);
        DB::table('orders')->where('facility_id',$request->facility)
        ->where('student',$student->id)
        ->update(['rate'=>'is_rated']);
        return redirect()->back()->with('toast_success','تم ارسال التقييم بنجاح');;
    }

    public function changePassword() {
        return view('student.reset-password');
    }

    public function changePasswordPost(Request $request){
        request()->validate([
            'old_password' => 'required|min:8|string',
            'password' => 'required|min:8|confirmed|string',
        ]);
        $student = auth()->guard('student')->user();
        if (Hash::check($request->old_password, $student->password )) {
            $student->password = bcrypt($request->password);
            $student->update();
            return redirect()->back()->with('toast_success',  trans('lang.update_success'));
        }else{
            return redirect()->back()->with('toast_warning','كلمة المرور القديمة غير مطابقة');
        }
    }
}
