<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
           $table->bigIncrements('id');
            $table->integer('customer_id');
            $table->string('order_code');
            $table->integer('order_total');
            $table->integer('order_payment');
            
            $table->string('order_feeship');
            $table->integer('shipping_id');
            
           
            $table->string('order_status');
         
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
        Schema::dropIfExists('order');
    }
}
