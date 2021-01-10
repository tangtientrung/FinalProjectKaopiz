<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->Increments('id');
            $table->string('product_name');
            $table->integer('category_id');
            $table->integer('sub_category_id');
            $table->string('slug_product');
            $table->integer('brand_id');
            $table->text('product_desc');
            $table->integer('product_qty');
            $table->text('product_content');
            $table->integer('product_price');
            $table->integer('product_price_km');
            $table->integer('product_import');
            $table->string('product_image');
            $table->integer('product_status');
            $table->integer('product_view');
            $table->timestamps('bdkm');
            $table->timestamps('ktkm');
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
        Schema::dropIfExists('product');
    }
}
