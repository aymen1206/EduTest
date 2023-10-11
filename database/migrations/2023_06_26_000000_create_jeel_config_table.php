<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJeelConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jeelconfigs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('Authurl');
            $table->string('url');
            $table->text('client_id');
            $table->text('client_secret');
            $table->text('token');
            $table->integer('status');
            $table->integer('instalments');
            $table->integer('min');
            $table->integer('max');
            $table->text('locked_facilities');
            $table->longtext('text');
            $table->longtext('text_en');          
            $table->string('notification');         
            $table->string('webhook_id');          
            $table->string('authorization');
            $table->timestamps();
        });

         DB::table('jeelconfigs')->insert([
        [
        'Authurl' => 'https://auth-sandbox.jeel.co/oauth2/token',
        'url' => 'https://api-sandbox.jeel.co/v1/installment-requests',
        'client_id' => '8TbJm4PU7NY-lfkL1Z7c49iHaEKDLEwqp-C6PV11IJg', 
        'client_secret' => '_1lp-Qwyhzrbbtxc0qF0LhO4-CsS6qokVImlA1r6fU8-0uYa0OeiRw0Y6mDI74p-', 
        'token' => '', 
        'status' => 1, 
        'instalments' => 12, 
        'min' => 1000, 
        'max' => 50000, 
        'locked_facilities' => '', 
        'text' => 'تقدم  منصة جيل  ميزة تنافسية من خلال توفير خيار التقسيط الفوري لأولياء الأمور وذلك لتسهيل سداد الرسوم الدراسية، حيث يمكن تقسيمها إلى أقساط شهرية تسدّد خلال مدة تصل إلى 12 شهر بطرق دفع إلكترونية', 
        'text_en' => 'Jeel platform offers a competitive feature through instant installment plans for parents to simplify payment of school fees, as it can be split into monthly payments paid through a period of 12 months', 
        'notification' => 'not',  
        'webhook_id' => '', 
        'authorization' => ''
        ]
    ]);


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jeelconfigs');
    }
}
