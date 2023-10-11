<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Mail\Sendmail;
use App\Models\EduFacility;
use App\Models\Student;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function mailsend($studentID,$facilityId,$OrderNumber)
    {
        $facility=EduFacility::find($facilityId);
        $student=Student::find($studentID);
        $facilityName=$facility->name;
        $studentName=$student->name;
        $studentPhone=$student->phone;
        $details=[
            'title'=> 'طلب جديد',
            'Graduain'=> $studentName,
            'GraduainPhone'=> $studentPhone,
            'Facility'=> $facilityName,
            'Order'=> $OrderNumber
            ];
        \Mail::to('aymenhashimnoni@gmail.com')->send(new Sendmail($details));
      
    }

}
