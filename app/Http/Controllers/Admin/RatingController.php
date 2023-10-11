<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RatingController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.auth:admin');
    }

    public function index(Request $request)
    {
        $query = Comment::join('edu_facilities','comments.commentable_id','=','edu_facilities.id')
            ->join('students','comments.commented_id','=','students.id')
            ->select('comments.*','students.name','students.email','students.id as student_id','edu_facilities.id as facility_id','edu_facilities.name as facility_name');

        if (isset($request->from) && $request->from != null && isset($request->to) && $request->to != null) {
            $query->whereBetween('comments.created_at', [$request->from, $request->to]);
            $_from = $request->from;
            $_to = $request->to;
        }else{
            $_to = null;
            $_from =  null;
        }

        $data = $query->where('commentable_type','App\Models\EduFacility')->get();
        return view('admin.ratings.index',compact('data','_to','_from'));

    }

    public function show($id){
        $data = Comment::join('edu_facilities','comments.commentable_id','=','edu_facilities.id')
            ->join('students','comments.commented_id','=','students.id')
            ->select('comments.*','students.name','students.email','students.id as student_id','edu_facilities.id as facility_id','edu_facilities.name as facility_name')
            ->where('commentable_type','App\Models\EduFacility')
            ->where('comments.id',$id)
            ->first();

        return view('admin.ratings.show',compact('data'));
    }

    public function status($id){
        $dt = Comment::findOrFail($id);

        if ($dt->admin_approved == 0){
            $status = 1;
        }else{
            $status = 0;
        }

        $dt->admin_approved = $status;
        $dt->approved = $status;
        $dt->update();
        return redirect()->back()->with('toast_success','تم تعديل حالة التقييم بنجاح');;

    }
}
