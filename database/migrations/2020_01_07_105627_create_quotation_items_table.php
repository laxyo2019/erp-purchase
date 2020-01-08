<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotationItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotation_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('item_name');
            $table->string('item_quantity');
            $table->string('item_price');
            $table->string('item_actual_amount');
            $table->string('item_tax1_rate');
            $table->string('item_tax1_amount');
            $table->string('item_total_amount');
            $table->string('quotation_id');
            $table->string('vendor_regno');
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
        Schema::dropIfExists('quotation_items');
    }
}
