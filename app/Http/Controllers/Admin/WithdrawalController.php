<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Adminfinanciallog;
use App\Models\Financiallog;
use Illuminate\Http\Request;
use App\Models\FacilityWithdrawalLog;
use DB;
class WithdrawalController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.auth:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = FacilityWithdrawalLog::all();
        return view('admin.withdrawals.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = FacilityWithdrawalLog::find($id);
        if ($data->status == 'accepted'){
            return redirect()->back()->with('toast_warning',  trans('تمت الموافقة علي هذا الطلب من قبل'));
        }
        $dt = Financiallog::where('facility_id',$data->facility_id)->get()->last();
        return view('admin.withdrawals.edit',compact('data','dt'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $data = FacilityWithdrawalLog::find($id);
        $logs = Financiallog::where('facility_id',$data->facility_id)->get()->last();

        if ($data->status != 'accepted' && $logs->total >= $data->total){

            $data->status = $request->status;
            $data->update();


            // update logs

            $latest_logs = Financiallog::where('facility_id',$data->facility_id)->get()->last();

            if ($latest_logs != null){
                $last_total_commission = $latest_logs->total_commission ;
            }else{
                $last_total_commission = 0;
            }


            $adminlatest_logs = Adminfinanciallog::all()->last();

            if ($adminlatest_logs != null){
                $adminlast_total = $adminlatest_logs->total;
                $adminlast_total_commission = $adminlatest_logs->total_commission ;
                $final_total = $adminlatest_logs->final_total ;
            }else{
                $adminlast_total = 0;
                $adminlast_total_commission = 0;
                $final_total= 0;
            }


            //is log exist
		
		if($data->status == 'accepted'){
                // add logs to facility logs
                $financial_logs = new Financiallog;
                $financial_logs->facility_id = $data->facility_id;
                $financial_logs->InvoiceId = 0;
                $financial_logs->Invoice_value = 0;
                $financial_logs->text = " تم خصم مبلغ".$data->total." بعد طلب سحب الرصيد ";
                $financial_logs->withdraw = $data->total;
                $financial_logs->addition = 0;
                $financial_logs->commission_rate = 0;
                $financial_logs->commission = 0;
                $financial_logs->total = 0;
                $financial_logs->total_commission = $last_total_commission;
                $financial_logs->save();

                // add logs to admin logs
                $adminlog = new Adminfinanciallog;
                $adminlog->facility_id = $data->facility_id;
                $adminlog->InvoiceId = 0;
                $adminlog->Invoice_value = 0;
                $adminlog->text =  " تم خصم مبلغ".$data->total." بعد طلب سحب الرصيد ";
                $adminlog->withdraw = $data->total;
                $adminlog->addition = 0;
                $adminlog->commission_rate = 0;
                $adminlog->commission = 0;
                $adminlog->total = $adminlast_total-$data->total;
                $adminlog->total_commission = $adminlast_total_commission;
                $adminlog->final_total = $final_total-$data->total;
                $adminlog->save();

                DB::table('notifications')->insert([
                    'target'=>'facility',
                    'target_id'=>$data->facility_id,
                    'title'=>'خصم من الرصيد بناء علي طلب السحب',
                    'text'=>" تم خصم مبلغ".$data->total." بعد طلب سحب الرصيد "
                ]);
		}
            return redirect('admin/withdrawal')->with('toast_success',  trans('lang.update_success'));
        }else{
            return redirect()->back()->with('toast_warning',  trans('الرصيد الحالي لا يسمح باجراء عملية السحب'));
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
