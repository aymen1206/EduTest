<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Student;
use App\Models\EduFacility;
use App\Mail\NotifyCompletedOrederViaEmail;

class Order extends Model
{
  protected $appends = ['normal_status'];
    use HasFactory;

    public function facility()
    {
      return $this->belongsTo('App\Models\EduFacility','facility_id');
    }

    public function studentdata()
    {
      return $this->belongsTo('App\Models\Student','student');
    }

    public function childrendata()
    {
      return $this->belongsTo('App\Models\Children','children');
    }

    public function pricelist()
    {
      return $this->belongsTo('App\Models\FacilityPrice','price_id');
    }
    
    public function getNormalStatusAttribute()
    {
        $st = '';
      if ($this->status == 'new') {
        $st = 'جديد';
      }elseif ($this->status == 'under_revision') {
        $st = 'قيد المراجعة';
      }elseif ($this->status == 'rejected') {
        $st = 'مرفوض';
      }elseif ($this->status == 'accepted') {
        $st = 'مقبول';
      }elseif ($this->status == 'completed') {
        $st = 'مكتمل';
      }
      return $st;
    }

    public function payment_type()
    {
      $st = '';
      if ($this->payment_type == 'alrajhi_inst') {
        $st = 'تمويل الراجحي';
      }elseif ($this->status == 'pg') {
        $st = 'الدفع بالكامل عن طريق تاب';
      }elseif ($this->status == 'tamara') {
        $st = 'التقسيط عن طريق تمارا';
      }
      return $st;
    }

    /**
     * Get the user associated with the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function invoice()
    {
      return $this->belongsTo('App\Models\BnMyfatoorahPayment','InvoiceId','invoice_id');
    }

    protected static function boot()
    {
      parent::boot();
      static::updated(function (Order $Order) {
        if($Order->status=='is_paid'){
        $orderId=$Order->id;    
        $studentId=$Order->student;
        $facilityId=$Order->facility_id;
        $student=Student::find($studentId);
        $studentEmail=$student->email;
        $studentName=$student->name;
        $studentName_en=$student->name_en;
        $eduFacility=EduFacility::find($facilityId);
        $eduFacilityname=$eduFacility->name;
        $eduFacilityname_en=$eduFacility->name_en;
        $details=[
            'eduFacility'=> $eduFacilityname,
            'eduFacility_en'=> $eduFacilityname_en,
            'studentName'=> $studentName,
            'studentName_en'=> $studentName_en,
            'OrderId'=> $orderId
            ];
        \Mail::to($studentEmail)->send(new NotifyCompletedOrederViaEmail($details)); 
          }
        });
    }
    
}
