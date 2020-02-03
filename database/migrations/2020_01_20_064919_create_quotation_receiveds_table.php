<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotationReceivedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotation_receiveds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('items');
            $table->string('quotion_id');
            $table->string('quotion_sends_id');
            $table->string('vender_id');
            $table->text('terms')->nullable();
            $table->integer('status')->default('0');
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
        Schema::dropIfExists('quotation_receiveds');
    }
}
