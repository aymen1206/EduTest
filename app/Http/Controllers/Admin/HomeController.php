<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EduFacilities;
use DB;
use App\Models\Order;
use App\Models\FacilityPrice;
use App\Models\FacilityFinancialRecord;
use App\Models\Adminfinanciallog;
use App\Models\FacilityWithdrawalLog;
use App\Models\Commission;

class HomeController extends Controller
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
     * Show the Admin dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {

         $orders['total'] = Order::join('facility_prices','orders.price_id','facility_prices.id')
                                         ->select('orders.*',DB::raw('SUM(facility_prices.price) AS sum_of_prices'))
                                         ->first();

        $orders['types'] = Order::join('facility_prices','orders.price_id','facility_prices.id')
                                ->join('edu_facilities_types','facility_prices.type','edu_facilities_types.id')
                                ->join('edu_stages','facility_prices.stage','edu_stages.id')
                                ->join('subscription_periods','facility_prices.subscription_period','subscription_periods.id')
                                ->groupBy('facility_prices.type')
                                ->select('orders.*','edu_facilities_types.name as type_name',DB::raw('SUM(facility_prices.price) AS sum_of_prices'),DB::raw('count(orders.id) AS sum_of_orders'))
                                ->get();

        $prices = FacilityPrice::JOIN('edu_facilities_types','facility_prices.type','=','edu_facilities_types.id')
            ->JOIN('edu_stages','facility_prices.stage','=','edu_stages.id')
            ->JOIN('subscription_periods','facility_prices.subscription_period','=','subscription_periods.id')
            ->select('facility_prices.*','edu_facilities_types.name as type_name','edu_stages.name as stage_name','subscription_periods.name as subscription_period_name')
            ->groupBy('edu_stages.id')
            ->get(); 
            
        $financialLogs = Adminfinanciallog::all()->last();
        $total_sucscription = Order::where('status', 'is_paid')->count();
        $withdrawas = FacilityWithdrawalLog::all();
        $commission_rate = Commission::first()->commission;
        
    
        $messages =  DB::table('messages')->get();
        return view('admin.home',compact('orders','prices','financialLogs','total_sucscription','withdrawas','commission_rate','messages'));

    }
    
    public function notifications(){
        $data = DB::table('notifications')->orderBy('id','desc')->get();
       
        return view('admin.notifications.index',compact('data'));
    }
    
    public function notification($id){
        $data = DB::table('notifications')->where('id',$id)->first();
          DB::table('notifications')->where('id',$id)->update(['status'=>1]);
        return view('admin.notifications.show',compact('data'));
    }
}
