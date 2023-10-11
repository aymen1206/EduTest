<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTabbyPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tabby_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->biginteger('student_id')->index()->unsigned();
            $table->biginteger('facility_id')->index()->unsigned();
            $table->biginteger('order_id')->index()->unsigned();
            $table->string('status');
            $table->text('checkout_url');
            $table->text('tabbyOrderId');
            $table->string('authorised_status')->nullable();
            $table->string('can_authorised')->nullable();
            $table->string('order_expiry_time')->nullable();
            $table->string('auto_captured')->nullable();
            $table->string('capture_id')->nullable();
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
        Schema::dropIfExists('tabby_payments');
    }
}
