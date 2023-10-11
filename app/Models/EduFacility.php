<?php

namespace App\Models;

use App\Notifications\EduFacility\Auth\ResetPassword;
use App\Notifications\EduFacility\Auth\VerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Actuallymab\LaravelComment\Contracts\Commentable;
use Actuallymab\LaravelComment\HasComments;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Comment;

class EduFacility extends Authenticatable implements Commentable,JWTSubject
{
    use HasFactory, Notifiable, HasComments, SoftDeletes;

    public function canBeRated(): bool
    {
        return true; // default false
    }
    
    public function mustBeApproved(): bool
    {
        return true; // default false
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail);
    }

    public function students()
    {
        return $this->hasManyThrough(
            // required
            'App\Models\Student', // the related model
            'App\Models\Favorite', // the pivot model

            // optional
            'facility_id', // the current model id in the pivot
            'id', // the id of related model
            'id', // the id of current model
            'student_id' // the related model id in the pivot
        );
    }

   public function prices(){
        return $this->hasMany('App\Models\FacilityPrice','facility_id');
    }

    public function orders(){
        return $this->hasMany('App\Models\Order','facility_id');
    }

    public function withdrawas(){
        return $this->hasMany('App\Models\FacilityWithdrawalLog','facility_id');
    }

    public function messages()
    {
        return $this->hasMany('App\Models\Message','facility_id');
    }
    
    public function financialRecords(){
        return $this->hasOne('App\Models\FacilityFinancialRecord','facility_id');
    }

    public function type(){
        return $this->belongsTo('App\Models\Type','facility_type');
    }

    public function setRateAttribute()
    {
        return $this->averageRate();
    }
    
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
    public function averageRate(){
        $totalSum=0;
        $totalcount=0;
        $Comments=Comment::where('commentable_id',$this->id)->get();
        foreach($Comments as $comment){
        $totalSum=$totalSum+$comment->rate; 
        $totalcount=$totalcount+1;           
        }
        if($totalcount!=0){$avreage=$totalSum/$totalcount;}
        else{$avreage=$totalSum/1;}        
        return $avreage;
    }

}
