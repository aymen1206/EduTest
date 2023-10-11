<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJeelPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Jeel_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->biginteger('student_id')->index()->unsigned();
            $table->biginteger('facility_id')->index()->unsigned();
            $table->biginteger('order_id')->index()->unsigned();
            $table->string('status');
            $table->text('checkout_url');
            $table->text('JeelOrderId');
            $table->json('Jeel_response');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Jeel_payments');
    }
}
