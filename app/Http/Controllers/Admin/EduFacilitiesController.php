<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\EduFacility;
use App\Models\EduFacilitiesType;
use App\Models\EduFacilityController;
use App\Models\EduStage;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use DB;
use Illuminate\Http\Response;

class EduFacilitiesController extends Controller
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
        $facility['types'] = DB::table('types')->get();

        $query = EduFacility::where('edu_facilities.id','>',0);

        if (isset($request->type) && $request->type != null) {
            $query->where('facility_type',$request->type);
            $_type = $request->type;
        }else{
            $_type = null;
        }

        if (isset($request->status) && $request->status != null) {
            $query->where('status',$request->status);
            $_status = $request->status;
        }else{
            $_status = null;
        }

        if (isset($request->from) && $request->from != null && isset($request->to) && $request->to != null) {
            $query->whereBetween('edu_facilities.created_at', [$request->from, $request->to]);
            $_from = $request->from;
            $_to = $request->to;
        }else{
            $_to = null;
            $_from =  null;
        }

        $data = $query->select('edu_facilities.*')->get();


        return view('admin.edu-facilities.index',compact('data','_type','_status','_to','_from','facility'));
    }

    public function getStages($id)
    {
        $stages = DB::table("edu_stages")->where("type_id",$id)->pluck("name","id");
        return json_encode($stages);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $data = EduFacilitiesType::all();
        return view('admin.edu-facilities.create',compact('data'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required|min:2|max:255',
            'name_en' => 'required|min:2|max:255',
            'about' => 'required',
            'about_en' => 'required',
            'type_id' => 'nullable',
            'facility_type' => 'required',
            'stages' => 'nullable',
            'phone' => 'required',
            'mobile' => 'required',
            'email' => 'required|email|min:2|max:255|unique:edu_facilities',
            'country' => 'required',
            'city' => 'required',
            'address' => 'required',
            'address_en' => 'required',
            'map_location' => 'required',

            'commercial_record' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'owner_id' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'sp_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'teacher_id' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            'password' => 'required|min:8|confirmed',
            'legal_agreement' => 'required',
        ]);

        $facility = new EduFacility;
        $facility->facility_type = $request->facility_type;
        $facility->name = $request->name;
        $facility->name_en = $request->name_en;
        $facility->about = $request->about;
        $facility->about_en = $request->about_en;

        if( $request->facility_type == 1 && isset($request->type_id)){
            $facility->facility_type = $request->type_id;
        }

        $facility->phone = $request->phone;
        $facility->mobile = $request->mobile;
        $facility->email = $request->email;
        $facility->country = $request->country;
        $facility->city = $request->city;
        $facility->address = $request->address;
        $facility->address_en = $request->address_en;
        $facility->map_location = $request->map_location;
        $facility->password = bcrypt($request->password);
        $facility->legal_agreement = $request->legal_agreement;


        if ($request->facility_type == 1 || $request->facility_type == 3){
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

            if ($request->has('image') == true) {
                $imageName = time().rand(1,10000).'.'.request()->image->getClientOriginalExtension();
                request()->image->move(public_path('uploads/facilities/'), $imageName);
                $facility->image = 'uploads/facilities/'.$imageName;
            }

            if ($request->has('banner') == true) {
                $imageName = time().rand(1,10000).'.'.request()->banner->getClientOriginalExtension();
                request()->banner->move(public_path('uploads/facilities/'), $imageName);
                $facility->banner = 'uploads/facilities/'.$imageName;
            }
        }

        if ($request->facility_type == 2){
            if ($request->has('teacher_id') == true) {
                $imageName = time().rand(1,10000).'.'.request()->teacher_id->getClientOriginalExtension();
                request()->teacher_id->move(public_path('uploads/facilities/'), $imageName);
                $facility->teacher_id = 'uploads/facilities/'.$imageName;
            }

            if ($request->has('sp_image') == true) {
                $imageName = time().rand(1,10000).'.'.request()->sp_image->getClientOriginalExtension();
                request()->sp_image->move(public_path('uploads/facilities/'), $imageName);
                $facility->sp_image = 'uploads/facilities/'.$imageName;
            }

            if ($request->has('profile_image') == true) {
                $imageName = time().rand(1,10000).'.'.request()->profile_image->getClientOriginalExtension();
                request()->profile_image->move(public_path('uploads/facilities/'), $imageName);
                $facility->profile_image = 'uploads/facilities/'.$imageName;
            }

            if ($request->has('image') == true) {
                $imageName = time().rand(1,10000).'.'.request()->image->getClientOriginalExtension();
                request()->image->move(public_path('uploads/facilities/'), $imageName);
                $facility->image = 'uploads/facilities/'.$imageName;
            }

            if ($request->has('banner') == true) {
                $imageName = time().rand(1,10000).'.'.request()->banner->getClientOriginalExtension();
                request()->banner->move(public_path('uploads/facilities/'), $imageName);
                $facility->banner = 'uploads/facilities/'.$imageName;
            }

        }

        $facility->save();

        //edu
        if ( $facility->facility_type == 1 && isset($request->stages)){
            foreach ($request->stages as $stage){
                DB::table('facilities_stages')->insert(['facility_id' => $facility->id , 'stage_id' =>$stage ]);
            }
        }

        //teacher
        if ( $facility->facility_type == 2 && isset($request->facility_types)){
            foreach ($request->facility_types as $fc_ty){
                DB::table('facilities_types')->insert(['facility_id' => $facility->id , 'facilities_type' =>$fc_ty ]);
            }
        }

        if ( $facility->facility_type == 2 && isset($request->specialties_group)){
            foreach ($request->specialties_group as $key => $group){

                if (isset($group['title'])){
                    $title = $group['title'];
                }else{
                    $title = '';
                }

                if (isset($group['file'])){
                    $file = $group['file'];
                    $imageName = time().rand(1,10000).'.'.$file->getClientOriginalExtension();
                    $file->move(public_path('uploads/specialties/'), $imageName);
                    $sp_image_name = 'uploads/specialties/'.$imageName;
                }else{
                    $sp_image_name = '';
                }

                DB::table('specialties')->insert(['facility_id' => $facility->id , 'title' =>$title , 'image' =>$sp_image_name ]);
            }
        }

        //center
        if ( $facility->facility_type == 3 && isset($request->center_types)){
            foreach ($request->center_types as $ct){
                DB::table('facilities_center_types')->insert(['facility_id' => $facility->id , 'center_type_id' =>$ct ]);
            }
        }



        return redirect()->back()->with('toast_success',  trans('lang.save_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param EduFacilityController $EduFacilitiesTypeController
     * @return Response
     */
    public function show($id)
    {
        $data = EduFacility::find($id);
        $current_types = DB::table('facilities_types')
            ->join('edu_facilities_types','facilities_types.facilities_type','=','edu_facilities_types.id')
            ->select('edu_facilities_types.*')
            ->where('facility_id',$data->id)
            ->get();

        return view('admin.edu-facilities.show',compact('data','current_types'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit($id)
    {
        $data = EduFacility::find($id);

        $data2 = DB::table('types')->get();

        $current_types = DB::table('facilities_types')
                    ->join('edu_facilities_types','facilities_types.facilities_type','=','edu_facilities_types.id')
                    ->select('edu_facilities_types.*')
                    ->where('facility_id',$data->id)
                    ->get();
            $current_types_ids=[];
        foreach($current_types as $key => $ct){
            $current_types_ids[$key] = $ct->id;
        }

        $data3 = DB::table('edu_facilities_types')
                    ->select('edu_facilities_types.*')
                    ->where('type',$data->facility_type)
                    ->whereNotIn('edu_facilities_types.id',$current_types_ids)
                    ->get();


        $data4 = DB::table('facilities_center_types')
            ->join('center_types','facilities_center_types.center_type_id','=','center_types.id')
            ->select('center_types.*')
            ->where('facility_id',$data->id)
            ->get();

        $teacher_types = DB::table('facilities_types')
            ->join('edu_facilities_types','facilities_types.facilities_type','=','edu_facilities_types.id')
            ->select('edu_facilities_types.*')
            ->where('facility_id',$data->id)
            ->get();

        return view('admin.edu-facilities.edit',compact('data','data2','data3','data4','teacher_types','current_types'));

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
            'name_en' => 'required|min:2|max:255',
            'about' => 'required',
            'about_en' => 'required',
            'type_id' => 'nullable',
            'stages' => 'nullable',
            'phone' => 'required',
            'mobile' => 'required',
            'email' => 'required|email|min:2|max:255|unique:edu_facilities,email,'.$id,
            'city' => 'required',
            'address' => 'required',
            'address_en' => 'required',
            'map_location' => 'required',
            'commercial_record' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'owner_id' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'sp_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'teacher_id' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'nullable|min:8',
        ]);


        $facility = EduFacility::find($id);
        $facility->name = $request->name;
        $facility->about = $request->about;
        $facility->name_en = $request->name_en;
        $facility->about_en = $request->about_en;

        if( $facility->facility_type == 1 && isset($request->type_id)){
            $facility->facility_type = $request->type_id;
        }

        $facility->phone = $request->phone;
        $facility->mobile = $request->mobile;
        $facility->email = $request->email;
        $facility->city = $request->city;
        $facility->address = $request->address;
        $facility->address_en = $request->address_en;
        $facility->map_location = $request->map_location;
        if (isset($request->password)){
            $facility->password = bcrypt($request->password);
        }

        if ($facility->facility_type == 1 || $facility->facility_type == 3){
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
        }

        if ($facility->facility_type == 2){
            if ($request->has('teacher_id') == true) {
                $imageName = time().rand(1,10000).'.'.request()->teacher_id->getClientOriginalExtension();
                request()->teacher_id->move(public_path('uploads/facilities/'), $imageName);
                $facility->teacher_id = 'uploads/facilities/'.$imageName;
            }

            if ($request->has('sp_image') == true) {
                $imageName = time().rand(1,10000).'.'.request()->sp_image->getClientOriginalExtension();
                request()->sp_image->move(public_path('uploads/facilities/'), $imageName);
                $facility->sp_image = 'uploads/facilities/'.$imageName;
            }

            if ($request->has('profile_image') == true) {
                $imageName = time().rand(1,10000).'.'.request()->profile_image->getClientOriginalExtension();
                request()->profile_image->move(public_path('uploads/facilities/'), $imageName);
                $facility->profile_image = 'uploads/facilities/'.$imageName;
            }
        }

        if ($request->has('image') == true) {
            $imageName = time().rand(1,10000).'.'.request()->image->getClientOriginalExtension();
            request()->image->move(public_path('uploads/facilities/'), $imageName);
            $facility->image = 'uploads/facilities/'.$imageName;
        }

        if ($request->has('banner') == true) {
            $imageName = time().rand(1,10000).'.'.request()->banner->getClientOriginalExtension();
            request()->banner->move(public_path('uploads/facilities/'), $imageName);
            $facility->banner = 'uploads/facilities/'.$imageName;
        }

        $facility->update();
        //edu
        if ($facility->facility_type == 1 && $request->stages){
            DB::table('facilities_stages')->where('facility_id',$id)->delete();
            foreach ($request->stages as $stage){
                DB::table('facilities_stages')->insert(['facility_id' => $facility->id , 'stage_id' =>$stage ]);
            }
        }

        //teacher
        if (isset($request->facility_types)){
            DB::table('facilities_types')->where('facility_id',$id)->delete();
            foreach ($request->facility_types as $fc_ty){
                DB::table('facilities_types')->insert(['facility_id' => $facility->id , 'facilities_type' =>$fc_ty ]);
            }
        }

        if ( $facility->facility_type == 2 && isset($request->specialties_group)){
            foreach ($request->specialties_group as $key => $group){
                if (isset($group['title'])){
                    $title = $group['title'];
                }else{
                    $title = '';
                }

                if (isset($group['file'])){
                    $file = $group['file'];
                    $imageName = time().rand(1,10000).'.'.$file->getClientOriginalExtension();
                    $file->move(public_path('uploads/specialties/'), $imageName);
                    $sp_image_name = 'uploads/specialties/'.$imageName;
                }else{
                    $sp_image_name = '';
                }

                if ($title != ''){
                    DB::table('specialties')->insert(['facility_id' => $facility->id , 'title' =>$title , 'image' =>$sp_image_name ]);
                }
            }
        }

        //center
        if ( $facility->facility_type == 3 && $request->center_types){
            DB::table('facilities_center_types')->where('facility_id',$id)->delete();
            foreach ($request->center_types as $ct){
                DB::table('facilities_center_types')->insert(['facility_id' => $facility->id , 'center_type_id' =>$ct ]);
            }
        }


        return redirect()->back()->with('toast_success',  trans('lang.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param EduFacilityController $EduFacilitiesTypeController
     * @return Response
     */
    public function destroy($id)
    {
        $facility = EduFacility::where('id',$id);

        try {
            $facility->forceDelete();
            return redirect('admin/trashed/edu-facilities')->with('toast_success', trans('lang.delete_success'));
        } catch (QueryException $ex) {
            return redirect('admin/trashed/edu-facilities')->with('toast_error', trans('lang.delete_error'));
        }


    }

    public function softdelete($id)
    {
        $facility = EduFacility::where('id',$id)->delete();
        return redirect('admin/edu-facilities')->with('toast_success', trans('lang.delete_success'));
    }

    public function trashed(Request $request)
    {
        $query = EduFacility::withTrashed()->where('edu_facilities.id','>',0);
        $data = $query->select('edu_facilities.*')->get();
        return view('admin.edu-facilities.trash',compact('data'));
    }

    public function restore($id) 
    {        
        $facility = EduFacility::where('id', $id)->withTrashed()->restore();        
        return redirect('admin/trashed/edu-facilities')->with('toast_success', trans('lang.restore_success'));
    }

    public function deleteSp($id){
        DB::table('specialties')->where('id',$id)->delete();
        return redirect()->back()->with('toast_success',  trans('lang.delete_success'));
    }

    public function statusSwicher($status, $id)
    {
        $dt = EduFacility::find($id);
        if ($status == 'active') {
            $dt->status = 1;
        } elseif ($status == 'inactive') {
            $dt->status = 0;
        }
        $dt->update();
        return redirect()->back()->with('toast_success', trans('lang.update_success'));
    }


    public function finance($id)
    {
        $business = DB::table('business')->where('facility_id', $id)->first();

        if ($business == null) {
            DB::table('business')->insert([
                'facility_id' => $id,
                'iban' => null,
                'title' => "Mr",
                'first' => null,
                'middle' => null,
                'last' => null,
                'email' => null,
                'json' => null,
            ]);
        }
        $data = DB::table('business')->where('facility_id', $id)->first();
        $data->facility_type = 1;
        return view('admin.edu-facilities.finance', compact('data'));
    }

    public function financeUpdate(Request $request)
    {
        $business = DB::table('business')->where('facility_id', $request->id)->first();

        request()->validate([
            'iban' => 'required|min:24|max:255',
            'first' => 'required|min:1',
            'middle' => 'required|min:1',
            'last' => 'required|min:1',
            'email' => 'required|email',
            'phone' => 'required',
        ]);


        DB::table('business')
            ->where('id', $business->id)
            ->update([
                'facility_id' => $request->id,
                'iban' => $request->iban,
                'first' => $request->first,
                'middle' => $request->middle,
                'last' => $request->last,
                'email' => $request->email,
                'phone' => $request->phone
            ]);

        return redirect()->back()->with('toast_success', trans('lang.update_success'));
    }
}
