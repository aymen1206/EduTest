<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTabbyConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tabbyconfigs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('url');
            $table->text('token');
            $table->integer('status');
            $table->integer('instalments');
            $table->integer('min');
            $table->integer('max');
            $table->text('locked_facilities');
            $table->longtext('text');
            $table->longtext('text_en');          
            $table->string('notification');          
            $table->string('merchant_id');          
            $table->string('webhook_id');          
            $table->string('authorization');
            $table->timestamps();
        });

         DB::table('tabbyconfigs')->insert([
        [
        'url' => 'https://api.tabby.ai/api/v2/checkout',
        'token' => 'pk_test_7ce7c632-b878-4573-8e27-521d258968f2', 
        'status' => 1, 
        'instalments' => 4, 
        'min' => 10, 
        'max' => 500, 
        'locked_facilities' => '', 
        'text' => 'تسوق وقسم فاتورتك على دفعات يعني لا تحتاج معاملات طويلة او اوراق تسجيل بل رقم هاتفك وهويتك لتضمن امان عملية الدفع! تقسيم إلى دفعات متعددة. بدون رسوم  ', 
        'text_en' => 'Shop and divide your bill into installments, which means that you do not need long transactions or registration papers, but rather your phone number and identity to ensure the security of the payment process! Split 
        into multiple batches. Without fees

        - Minimum amount: 10 Saudi riyals
        - Maximum limit: 5000 Saudi riyals

        approved installments 
        - Number of installments: 4 
        - Minimum installment: 10 
        - The maximum installment: 5000', 
        'notification' => 'not', 
        'merchant_id' => 'theedukeysau', 
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
        Schema::dropIfExists('tabbyconfigs');
    }
}
