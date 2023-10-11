<?php

namespace App\Http\Controllers\EduFacility;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
class HomeController extends Controller
{
    protected $facility;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('edu_facility.auth:edu_facility');
        $this->facility = auth()->guard('edu_facility')->user();
    }

    /**
     * Show the EduFacility dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {



        $orders['total'] = $this->facility->orders()
                                         ->join('facility_prices','orders.price_id','facility_prices.id')
                                         ->select(
                                             'orders.*'
                                             ,DB::raw('COUNT(orders.id) AS total')
                                             ,DB::raw('SUM(facility_prices.price) AS sum_of_prices')
                                             ,DB::raw("SUM(if(orders.status = 'accepted', 1, 0)) AS accepted_orders")
                                             ,DB::raw("SUM(if(orders.status = 'new', 1, 0)) AS new_orders")
                                             ,DB::raw("SUM(if(orders.status = 'under_revision', 1, 0)) AS under_revision_orders")
                                             ,DB::raw("SUM(if(orders.status = 'rejected', 1, 0)) AS rejected_orders")
                                             ,DB::raw("SUM(if(orders.status = 'accepted', 1, 0)) AS accepted_orders")
                                             ,DB::raw("SUM(if(orders.status = 'is_paid', 1, 0)) AS is_paid_orders")
                                            )->where('orders.facility_id',$this->facility->id)
                                         ->first();

        $orders['types'] = $this->facility->orders()
                                ->join('facility_prices','orders.price_id','facility_prices.id')
                                ->join('edu_facilities_types','facility_prices.type','edu_facilities_types.id')
                                ->join('edu_stages','facility_prices.stage','edu_stages.id')
                                ->join('subscription_periods','facility_prices.subscription_period','subscription_periods.id')
                                ->groupBy('facility_prices.type')
                                ->select(
                                    'orders.*',
                                    'edu_facilities_types.name as type_name',
                                    DB::raw('SUM(facility_prices.price) AS sum_of_prices'),
                                    DB::raw('count(orders.id) AS sum_of_orders'),
                                    DB::raw("SUM(if(orders.status = 'accepted', 1, 0)) AS accepted_orders"),
                                    DB::raw("SUM(if(orders.status = 'new', 1, 0)) AS new_orders"),
                                    DB::raw("SUM(if(orders.status = 'under_revision', 1, 0)) AS under_revision_orders"),
                                    DB::raw("SUM(if(orders.status = 'rejected', 1, 0)) AS rejected_orders"),
                                    DB::raw("SUM(if(orders.status = 'accepted', 1, 0)) AS accepted_orders"),
                                    DB::raw("SUM(if(orders.status = 'is_paid', 1, 0)) AS is_paid_orders"))
                                ->get();

        $prices = $this->facility->prices()
            ->JOIN('edu_facilities_types','facility_prices.type','=','edu_facilities_types.id')
            ->JOIN('edu_stages','facility_prices.stage','=','edu_stages.id')
            ->JOIN('subscription_periods','facility_prices.subscription_period','=','subscription_periods.id')
            ->where('facility_id',$this->facility->id)
            ->select('facility_prices.*','edu_facilities_types.name as type_name','edu_stages.name as stage_name','subscription_periods.name as subscription_period_name')
            ->get();

        $financialRecord = $this->facility->financialRecords;
        $total_sucscription = $this->facility->orders()->where('status','is_paid')->count();
        $withdrawas = $this->facility->withdrawas;
        $messages = $this->facility->messages;
        return view('edu-facility.home',compact('orders','prices','financialRecord','total_sucscription','withdrawas','messages'));
    }

    public function getFacilityTypes($id)
    {
        $stages = DB::table("edu_facilities_types")->where("type",$id)->pluck("name","id");
        return json_encode($stages);
    }

    public function getFacilityStages($id)
    {
        $lang = LaravelLocalization::getCurrentLocaleNative();
        if ($lang == 'العربية'){
            $stages = DB::table("edu_stages")->where("type_id",$id)->pluck("name","id");
        }else{
            $stages = DB::table("edu_stages")->where("type_id",$id)->pluck("name_en","id");
        }

        return json_encode($stages);
    }

    public function getPymentMethod($id){
        $lang = LaravelLocalization::getCurrentLocaleNative();
        if ($lang == 'العربية'){
            $stages = DB::table("subscription_periods")->where("type",'LIKE','%'.$id.'%')->pluck("name","id");
        }else{
            $stages = DB::table("subscription_periods")->where("type",'LIKE','%'.$id.'%')->pluck("name_en","id");
        }

        return json_encode($stages);
    }

}
