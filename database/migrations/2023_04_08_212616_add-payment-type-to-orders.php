<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentTypeToOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_type')->nullable();
        });

        DB::table('orders')->where('tamara', '1')->where('status', 'is_paid')->update(['payment_type'=>'tamara']);
        DB::table('orders')->whereNotNull('invoiceId')->where('status', 'is_paid')->update(['payment_type'=>'pg']);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('payment_type');
        });
    }
}
