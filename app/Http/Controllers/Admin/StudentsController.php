<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Student;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use DB;
use Illuminate\Http\Response;

class StudentsController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin.auth:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {

        $query = Student::where('phone_verify',1);

        if (isset($request->from) && $request->from != null && isset($request->to) && $request->to != null) {
            $query->whereBetween('students.created_at', [$request->from, $request->to]);
            $_from = $request->from;
            $_to = $request->to;
        }else{
            $_to = null;
            $_from =  null;
        }

        $data = $query->select('students.*')-> orderBy('id', 'DESC')->get();


        return view('admin.Students.index',compact('data','_to','_from'));
    }

    public function show($id)
    {
        $data = Student::find($id);
        return view('admin.Students.show',compact('data'));
    }

    public function edit($id)
    {
        $data = Student::find($id);

        $data2 = DB::table('cities')->get();

        return view('admin.Students.edit',compact('data','data2'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function update(Request $request,$id)
    {
        request()->validate([
            'name' => 'required|min:2|max:255',
            'name_en' => 'nullable|min:2|max:255',
            'phone' => 'required',
            'email' => 'required|email|min:2|max:255|unique:edu_facilities,email,'.$id,
            'gradian' => 'nullable',
            'id_number' => 'nullable',
            'guardian_id_number' => 'nullable',
            'city_id' => 'required',
            'id_number_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'Family_id' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'certificate_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'nullable|min:8',
        ]);

        $student = Student::find($id);
        $student->name_en = $request->name;
        $student->name_en = $request->name_en;
        $student->guardian_name = $request->gradian;
        $student->id_number = $request->id_number;
        $student->guardian_id_number = $request->guardian_id_number;
        $student->phone = $request->phone;
        $student->email = $request->email;

        if( isset($request->city_id)){
            $student->city = $request->city_id;
        }

        if (isset($request->password)){
            $student->password = bcrypt($request->password);
        }

        if ($request->has('id_photo') == true) {
            $imageName = time().rand(1,10000).'.'.request()->id_photo->getClientOriginalExtension();
            request()->id_photo->move(public_path('uploads/students/'), $imageName);
            $student->id_image = 'uploads/students/'.$imageName;
        }
        if ($request->has('Family_id') == true) {
            $imageName = time().rand(1,10000).'.'.request()->Family_id->getClientOriginalExtension();
            request()->Family_id->move(public_path('uploads/students/'), $imageName);
            $student->family_id_image = 'uploads/students/'.$imageName;
        }

        if ($request->has('certificate_image') == true) {
            $imageName = time().rand(1,10000).'.'.request()->certificate_image->getClientOriginalExtension();
            request()->certificate_image->move(public_path('uploads/students/'), $imageName);
            $student->certificate_image = 'uploads/students/'.$imageName;
        }

        $student->update();
        

        return redirect()->back()->with('toast_success',  trans('lang.update_success'));
    }

    public function destroy($id)
    {
        $student = Student::find($id);

        try {
            $student->delete();
            return redirect('admin/students')->with('toast_success', trans('lang.delete_success'));
        } catch (QueryException $ex) {
            return redirect('admin/students')->with('toast_error', trans('lang.delete_error'));
        }
    }

}