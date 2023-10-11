<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Tamaraconfig;
use App\Models\Tabbyconfig;
use App\Models\Jeelconfig;

use Illuminate\Support\Facades\Http;
use App\Models\EduFacility;
use App\Models\Message;
use Illuminate\Http\Request;
use Alert;
use App\Models\Gallery;
use DB;
use Mail;
use Mapper;

class HomeController extends Controller
{
    public function index(Request $request){
        //$data['about'] = DB::table('abouts')->first();
        $data['types'] = DB::table('edu_facilities_types')->where('type',1)->get();
      
      //-----------------------------------------------------------------------------
      
      if($request){
      $filter['keyword'] = $request->keyword;
        $filter['rate'] = $request->rate;
        $filter['type'] = DB::table('edu_facilities_types')->where('id', $request->type)->first();
        if (isset($request->facility_type)){
            $filter['subscription_periods'] = DB::table('subscription_periods')->where('type', 'LIKE', '%' . $request->facility_type . '%')->orderBy('position','asc')->get();
        }else{
            $filter['subscription_periods'] = DB::table('subscription_periods')->orderBy('position','asc')->get();
        }
        $filter['subscription']= $request->subscription;
        $filter['facility_type'] = DB::table('edu_facilities_types')->where('id',$request->facility_type)->first();

        $filter['facility_types'] = DB::table('edu_facilities_types')->join('facilities_types','facilities_types.facilities_type','=','edu_facilities_types.id')->where('edu_facilities_types.type',1)->select('edu_facilities_types.*',DB::raw('COUNT(facilities_types.id) as subscriptions'))->groupBy('edu_facilities_types.id')->get();

        $q2 = EduFacility::where('edu_facilities.name',"LIKE" , '%'.$request->keyword.'%')->where('edu_facilities.status', 1);
        $q2->orWhere('edu_facilities.name_en',"LIKE" , '%'.$request->keyword.'%');
	$q2->orderBy('edu_facilities.created_at', 'desc');
        if(isset($request->facility_type)) {
            $q2->join('facilities_types','edu_facilities.id','=','facilities_types.facility_id')->where('facilities_types.facilities_type',$request->facility_type);
        }

        if(isset($request->subscription)) {
            $q2->join('facility_prices','edu_facilities.id','=','facility_prices.facility_id')->where('facility_prices.subscription_period',$request->subscription);
        }

        if(isset($request->rate)) {
            $q2->whereBetween('edu_facilities.rate',[$request->rate, $request->rate + 0.99]);
        }
        $data = $q2->where('edu_facilities.status',1)->select('edu_facilities.*')->groupBy('edu_facilities.id')->paginate(9);

        if ($request->map == "true"){
            $map = \Mapper::map(24.381128999999990000, 41.470085000000040000, ['zoom' => 15,'locate'=> true, 'center' => false, 'marker' => true]);
            foreach ($data as $key=> $dt){
                $loc = explode(",",$dt->map_location);
                if (isset($loc[0]) && isset($loc[1])){
                    $map->informationWindow($loc[0] , $loc[1], "<center><a style='text-decoration: none; color: black' href='../facility/$dt->id' <div style='padding: 1px 2px'><span style='font-width: bold; font-size: 12px; color: black'> $dt->name<span><br> <img width='70' src='../$dt->logo'></div></a></center>", ['open' => true, 'maxWidth'=> 200, 'autoClose' => true,'animation' => 'DROP', 'markers' => ['title' => 'Title']]);
                }
                $loc = [];
            }
        } else{
          $map = null;
        }
      
      }else{
        $data = EduFacility::orderBy('id','desc')->take(8)->get();    
         $map = null;      
         $filter['keyword'] = '';
        $filter['rate'] = 0;
        $filter['type'] =null;
        $filter['subscription_periods'] = DB::table('subscription_periods')->orderBy('position','asc')->get();
        $filter['subscription']= null;
        $filter['facility_type'] = null;
        $filter['facility_types'] = DB::table('edu_facilities_types')->join('facilities_types','facilities_types.facilities_type','=','edu_facilities_types.id')->where('edu_facilities_types.type',1)->select('edu_facilities_types.*',DB::raw('COUNT(facilities_types.id) as subscriptions'))->groupBy('edu_facilities_types.id')->get();
        
      }
      
      
       // return Redirect::route('site.index, $id')->with( ['data' => $data] );
       // return redirect('site.index',compact('data','map','filter'));
        return view('site.index',compact('data','map','filter'));
    }

    public function faq(){
        return view('site.faq');

    }


    public function about(){
        $about = About::first();
        return view('site.about',compact('about'));
    }

    public function tamara(){
        $response = Http::withHeaders([
            'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhY2NvdW50SWQiOiJiYjE2MGEyYS00MWEzLTQzMDgtOTg5YS1mNWY3MTJlNDNjZjAiLCJ0eXBlIjoibWVyY2hhbnQiLCJzYWx0IjoiOTBkOWRmYzEyNzcxYzViMzA5YjgzMGRmMTVhNmUzZWYiLCJpYXQiOjE2NjM1MTExMDEsImlzcyI6IlRhbWFyYSJ9.KPD_TfFqMWZdeMiRb5qVEAnB20Z09vSXjZ4iNl8__Pt02JLd2P2wgk36M_bqdtU9QQ1ZTYvHJfZiVK6ZsmyUeSwJUalWVGpjUuag98mAPNprZOx1hy4GUjy-5XO_Z57kBpwHASLwIeeIr1jxvnjOwzJXsguBwcKf1VxyPeD1_hXR6kiwpOI8M4bFZpLZri-mv42i1Z-4RPkaCN9mG-JgM3QqQ2lnZfeRr28TWV-Du2rL93LQAJPVYKZlY7lzAYTPJERwcuA3wsuKugzQCXsYtGCh8e3oky6FY3L2glArlOYr_W_3AsafAaOE3XbhtsMKSU5UXzedIOMEy4_TLer7WA'
        ])->get('https://api-sandbox.tamara.co/checkout/payment-types?country=SA');
        $data = json_decode($response);

        $tamara = Tamaraconfig::first();

        return view('site.tamara', compact('data', 'tamara'));
    }

     public function tabby(){
   

        $tabby = Tabbyconfig::first();

        return view('site.tabby', compact('tabby'));
    }
    public function jeel(){
       
        $jeel = Jeelconfig::first();

        return view('site.jeel', compact('jeel'));
    }

    public function eduFacilities($id,Request $request){
        $filter['keyword'] = $request->keyword;
        $filter['rate'] = $request->rate;

        $filter['type'] = DB::table('edu_facilities_types')->where('id',$id)->first();

        $filter['subscription_periods'] = DB::table('subscription_periods')->get();
        $filter['subscription']= $request->subscription;

        $filter['facility_type'] = DB::table('edu_facilities_types')->where('id',$request->facility_type)->first();

        $filter['facility_types'] = DB::table('edu_facilities_types')->join('facilities_types','facilities_types.facilities_type','=','edu_facilities_types.id')->where('edu_facilities_types.type',$request->type)->select('edu_facilities_types.*',DB::raw('COUNT(facilities_types.id) as subscriptions'))->groupBy('edu_facilities_types.id')->get();

        $q2 = EduFacility::where('edu_facilities.name',"LIKE" , '%'.$request->keyword.'%');

        if(isset($request->facility_type)) {
            $q2->join('facilities_types','edu_facilities.id','=','facilities_types.facility_id')->where('facilities_types.facilities_type',$request->facility_type);
        }

        if(isset($request->subscription)) {
            $q2->join('facility_prices','edu_facilities.id','=','facility_prices.facility_id')->where('facility_prices.subscription_period',$request->subscription);
        }

        if(isset($request->rate)) {
            $q2->whereBetween('edu_facilities.rate',[$request->rate, $request->rate + 0.99]);
        }

        $data = $q2->where('edu_facilities.facility_type',1)->where('edu_facilities.status',1)->select('edu_facilities.*')->groupBy('edu_facilities.id')->get();

        if ($request->map == "true"){
            $map = Mapper::map(['zoom' => 15, 'locate' => true, 'center' => true, 'marker' => true]);
            foreach ($data as $key=> $dt){
                $loc = explode(",",$dt->map_location);
                if (isset($loc[0]) && isset($loc[1])){
                    $map->informationWindow($loc[0] , $loc[1], "<center><a style='text-decoration: none; color: black' href='../facility/$dt->id' <div style='padding: 5px 10px'><span style='font-width: bold; font-size: 17px; color: black'> $dt->name<span><br> <img width='150' src='../$dt->image'></div></a></center>", ['open' => true, 'maxWidth'=> 200, 'autoClose' => true, 'markers' => ['title' => 'Title']]);
                }
                $loc = [];
            }
        } else{
          $map = null;
        }
        return view('site.facilities',compact('data','map','filter'));
    }

    public function facility($id){
        $data = EduFacility::find($id);
        $alts = EduFacility::where('facility_type',$data->facility_type)->where('id','!=',$data->id)->where('edu_facilities.status',1)->take(10)->get();
        $data->visits +=1;
        $gallery = Gallery::where('facility_id',$id)->get();
        $data->update();
        $prices = $data->prices()
            ->JOIN('edu_facilities_types','facility_prices.type','=','edu_facilities_types.id')
            ->JOIN('edu_stages','facility_prices.stage','=','edu_stages.id')
            ->JOIN('subscription_periods','facility_prices.subscription_period','=','subscription_periods.id')
            ->where('facility_id',$id)
            ->select('facility_prices.*','edu_facilities_types.name as type_name','edu_stages.name as stage_name','subscription_periods.name as subscription_period_name')
            ->get();
        $tamara_config = Tamaraconfig::first();
        $tabby_config = Tabbyconfig::first();
        return view('site.facility',compact('data','alts','prices','gallery','tamara_config','tabby_config'));
    }

    public function terms(){
        $data = DB::table('legal_agreements')->where('type', 'general')->first();
	return view('site.terms',compact('data'));
    }

     public function contact(){
        return view('site.contact');
    }

    public function sendMessage(Request $request){
        $message = new Message;
        $message->facility_id = $request->facility_id;
        $message->name = $request->name;
        $message->phone = $request->phone;
        $message->email = $request->email;
        $message->subject = $request->subject;
        $message->text = $request->message;
        $message->save();

        DB::table('notifications')->insert([
            'target'=>'facility',
            'target_id'=>$request->facility_id,
            'title'=>'رسالة جديدة',
            'text'=>"استلام رسالة جديدة برقم $message->id "
        ]);

        $mailsubject = 'شكرا لتواصلك معنا';
        $recipient = $message->email;
        $data = ['message_id'=>$message->id, 'mailsubject'=>$mailsubject , 'recipient'=>$recipient];
        $this->basic_email($data);

        return redirect()->back()->with('toast_success',__('lang.save_success'));
    }

    public function basic_email($data) {
      Mail::send(['html'=>'emails.welcome'], $data, function($message) use ($data) {
         $message->to($data['recipient'], 'Edukey')->subject($data['mailsubject']);
         $message->from('theedukey@gmail.com' , 'Edukey');
      });
      echo "Basic Email Sent. Check your inbox.";
   }

   public function forgetPassword(){
        return view('site.password.forget-password');
    }


}
