<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Tamaraconfig;
use App\Models\TabbyPayment;
use App\Models\JeelPayment;
use App\Models\Tabbyconfig;
use App\Models\Jeelconfig;
use Illuminate\Http\Request;
use DB;
use App\Models\EduFacility;
use App\Models\Order;
use App\Models\FacilityPrice;
use App\Models\Adminfinanciallog;
use App\Models\Commission;
use App\Models\Financiallog;

use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
	protected $student;

	public function __construct()
	{
		$this->middleware('student.auth:student');
		$this->student = auth()->guard('student')->user();
		$this->middleware('StudentPhoneVerified');
	}

	public function index()
	{ 
		$Ranting='';
		$data =  $this->student->orders()->orderBy('id','desc')->get();
        $tamara_config = Tamaraconfig::query()->first();
        $tabby_config= Tabbyconfig::query()->first();
        $jeel_config= Jeelconfig::query()->first();
		return view('student.orders',compact('data','tamara_config','tabby_config','jeel_config','Ranting'));
	}
	public function Tabbysuccess($id)
	{ 
		$Ranting='';
		$data =  $this->student->orders()->orderBy('id','desc')->get();
        $tamara_config = Tamaraconfig::query()->first();
        $tabby_config= Tabbyconfig::query()->first();
        $order=Order::find($id);
        $tabbyPayment=TabbyPayment::where('order_id',$id)->first();
        $order->status='is_paid';
        $order->tabby=1;
        $order->save();
        $status='Tabbysuccess';
        $client = auth()->guard('student')->user();
        $payment_id=$_GET['payment_id'];
        $dt = Http::withHeaders([
            'Authorization' => "Bearer sk_test_88ac3224-8de4-4983-a6fc-935ab9820292",
            'Content-Type' => 'application/json' 
        ])->post('https://api.tabby.ai/api/v1/payments/'.$payment_id.'/captures',
        [
        	"amount"=> $order->pricelist->price
        ]
        );

		$response=$dt->json();
		$tabbyPayment->capture_id=$response['id'];
		$tabbyPayment->save();



        $tp = TabbyPayment::query()
            ->where('tabbyOrderId', $id)
            ->first();
        $order = Order::where('id', $id)->first();
     



        $latest_logs = Financiallog::where('facility_id', $order->facility_id)->get()->last();

        if ($latest_logs != null) {
            $last_total = $latest_logs->total;
            $last_total_commission = $latest_logs->total_commission;
        } else {
            $last_total = 0;
            $last_total_commission = 0;
        }


        $adminlatest_logs = Adminfinanciallog::all()->last();

        if ($adminlatest_logs != null) {
            $adminlast_total = $adminlatest_logs->total;
            $adminlast_total_commission = $adminlatest_logs->total_commission;
            $final_total = $adminlatest_logs->final_total;
        } else {
            $adminlast_total = 0;
            $adminlast_total_commission = 0;
            $final_total = 0;
        }


        // Tabby
        $commission_rate = 10;
        $commission = ($commission_rate / 100) * $order->pricelist->price;
        $vat_from_commission = $commission * (15/100);
        $fixed_fee = 1;
        $total_after_commission = $order->pricelist->price - ($commission + $fixed_fee + $vat_from_commission);



        //is log exist
        $flag = Financiallog::where('InvoiceId', $id)->where('facility_id', $order->facility_id)->first();
        if ($flag == null) {
            // add logs to facility logs
            $financial_logs = new Financiallog;
            $financial_logs->facility_id = $order->facility_id;
            $financial_logs->InvoiceId = $id;
            $financial_logs->Invoice_value = $order->pricelist->price;
            $financial_logs->text = " تم اضافة  $total_after_commission   ريال بعد خصم $commission_rate % من المبلغ الاساسي وذلك بقيمة  $commission نظير العمولة المستحقة للمنصة ";
            $financial_logs->withdraw = 0;
            $financial_logs->addition = $total_after_commission;
            $financial_logs->commission_rate = $commission_rate;
            $financial_logs->commission = $commission;
            $financial_logs->total = $last_total + $total_after_commission;
            $financial_logs->total_commission = $last_total_commission + $commission;
            $financial_logs->save();

            // add logs to admin logs
            $adminlog = new Adminfinanciallog;
            $adminlog->facility_id = $order->facility_id;
            $adminlog->InvoiceId = $id;
            $adminlog->Invoice_value = $order->pricelist->price;
            $adminlog->text = " تم اضافة  $total_after_commission   ريال بعد خصم $commission_rate % من المبلغ الاساسي وذلك بقيمة  $commission نظير العمولة المستحقة للمنصة ";
            $adminlog->withdraw = $commission;
            $adminlog->addition = $total_after_commission;
            $adminlog->commission_rate = $commission_rate;
            $adminlog->commission = $commission;
            $adminlog->total = $adminlast_total + $total_after_commission;
            $adminlog->total_commission = $adminlast_total_commission + $commission;
            $adminlog->final_total = $final_total + $order->pricelist->price;
            $adminlog->save();
        }
		return view('student.TabbySuccess',compact('status'));
	}
	public function Tabbycancel()
	{ 
		$status='cancel';
		return view('student.TabbyCancel',compact('status'));
	}
	public function Tabbyfailure()
	{ 
		$status='fail';
		return view('student.Tabbyfail',compact('status'));
	}
	public function JeelResponse($Oid)
	{ 
		$id='';
		$status='';
		
		if (isset($_GET['id'])) {
		$id=$_GET['id'];
		$status=$_GET['status'];
		}
		
		if (isset($_GET['requestId'])) {
		$id=$_GET['requestId'];
		$status="success";

 		$order=Order::find($Oid);
        $order->status='is_paid';
        $order->jeel=1;
        $order->save();


        $tp = JeelPayment::query()
            ->where('JeelOrderId', $Oid)
            ->first();
        $order = Order::where('id', $Oid)->first();
     



        $latest_logs = Financiallog::where('facility_id', $order->facility_id)->get()->last();

        if ($latest_logs != null) {
            $last_total = $latest_logs->total;
            $last_total_commission = $latest_logs->total_commission;
        } else {
            $last_total = 0;
            $last_total_commission = 0;
        }


        $adminlatest_logs = Adminfinanciallog::all()->last();

        if ($adminlatest_logs != null) {
            $adminlast_total = $adminlatest_logs->total;
            $adminlast_total_commission = $adminlatest_logs->total_commission;
            $final_total = $adminlatest_logs->final_total;
        } else {
            $adminlast_total = 0;
            $adminlast_total_commission = 0;
            $final_total = 0;
        }



        // Tabby
        $commission_rate = 10;
        $commission = ($commission_rate / 100) * $order->pricelist->price;
        $vat_from_commission = $commission * (15/100);
        $fixed_fee = 0;
        $total_after_commission = $order->pricelist->price - ($commission + $fixed_fee + $vat_from_commission);



        //is log exist
        $flag = Financiallog::where('InvoiceId', $Oid)->where('facility_id', $order->facility_id)->first();
        if ($flag == null) {
            // add logs to facility logs
            $financial_logs = new Financiallog;
            $financial_logs->facility_id = $order->facility_id;
            $financial_logs->InvoiceId = $Oid;
            $financial_logs->Invoice_value = $order->pricelist->price;
            $financial_logs->text = " تم اضافة  $total_after_commission   ريال بعد خصم $commission_rate % من المبلغ الاساسي وذلك بقيمة  $commission نظير العمولة المستحقة للمنصة ";
            $financial_logs->withdraw = 0;
            $financial_logs->addition = $total_after_commission;
            $financial_logs->commission_rate = $commission_rate;
            $financial_logs->commission = $commission;
            $financial_logs->total = $last_total + $total_after_commission;
            $financial_logs->total_commission = $last_total_commission + $commission;
            $financial_logs->save();

            // add logs to admin logs
            $adminlog = new Adminfinanciallog;
            $adminlog->facility_id = $order->facility_id;
            $adminlog->InvoiceId = $Oid;
            $adminlog->Invoice_value = $order->pricelist->price;
            $adminlog->text = " تم اضافة  $total_after_commission   ريال بعد خصم $commission_rate % من المبلغ الاساسي وذلك بقيمة  $commission نظير العمولة المستحقة للمنصة ";
            $adminlog->withdraw = $commission;
            $adminlog->addition = $total_after_commission;
            $adminlog->commission_rate = $commission_rate;
            $adminlog->commission = $commission;
            $adminlog->total = $adminlast_total + $total_after_commission;
            $adminlog->total_commission = $adminlast_total_commission + $commission;
            $adminlog->final_total = $final_total + $order->pricelist->price;
            $adminlog->save();
        }



		}

		return view('student.JeelResponse',compact('status'));
	}

	public function create($facility_id,$price_list_id)
	{
		$price_list = FacilityPrice::JOIN('edu_facilities_types','facility_prices.type','=','edu_facilities_types.id')
									->JOIN('edu_stages','facility_prices.stage','=','edu_stages.id')
									->JOIN('subscription_periods','facility_prices.subscription_period','=','subscription_periods.id')
									->where('facility_id',$facility_id)
									->where('facility_prices.id',$price_list_id)
									->select('facility_prices.*','edu_facilities_types.name as type_name','edu_stages.name as stage_name','subscription_periods.name as subscription_period_name')
									->first();

		$facility = EduFacility::find($facility_id);
		$student =  auth()->guard('student')->user();
		return view('student.make_order',compact('student','price_list','facility'));
	}

	public function store(Request $request)
	{
		request()->validate([
			'price_id' => ['required', 'string', 'string', 'max:255'],
			'facility_id' => ['required', 'string', 'string', 'max:255'],
		]);

		$order = new Order;
		$order->facility_id = $request->facility_id;
		$order->student = auth()->guard('student')->user()->id;
		$order->price_id = $request->price_id;
		$order->children = $request->children;
		$order->save();
		$orderId=$order->id;
		$facilityId=$order->facility_id;
		$studentId=auth()->guard('student')->user()->id;
		$this->mailsend($studentId,$facilityId,$orderId);

		DB::table('notifications')->insert([
            'target'=>'facility',
            'target_id'=>$order->facility_id,
            'title'=>'طلب جديد',
            'text'=>" تم انشاء طلب جديد برقم$order->id"
        ]);
  		return redirect('/student/orders')->with('toast_success','تم ارسال الطلب بنجاح');
	}
}
