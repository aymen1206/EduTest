<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Adminfinanciallog;
use App\Models\Commission;
use App\Models\EduFacility;
use App\Models\FacilityWithdrawalLog;
use App\Models\Financiallog;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinancialLogsController extends Controller
{
    public function index()
    {
        $financialLogs = Adminfinanciallog::all()->last();;
        $total_sucscription = Order::where('status', 'is_paid')->count();
        $withdrawas = FacilityWithdrawalLog::all();
        $commission_rate = Commission::first()->commission;
        return view('admin.financial-records.index', compact('total_sucscription', 'commission_rate', 'financialLogs', 'withdrawas'));
    }

    public function logs()
    {
        $data = DB::table('adminfinanciallogs')->orderBy('id', 'desc')->get();
        return view('admin.financial-records.logs', compact('data'));
    }

    protected function facilitieslogs($id)
    {
        $facility = EduFacility::find($id);
        $total_orders =  Financiallog::where('facility_id',$id)->sum('Invoice_value');
        $financialLogs = Financiallog::where('facility_id',$id)->get()->last();;
        $total_sucscription = $facility->orders()->where('status','is_paid')->count();
        $withdrawas = $facility->withdrawas;
        $commission_rate = Commission::first()->commission;
        $data = DB::table('financiallogs')->where('facility_id',$id)->orderBy('id','desc')->get();
        return view('admin.financial-records.facility-logs', compact('facility','data','commission_rate','withdrawas','total_sucscription','financialLogs','total_orders'));
    }
}
