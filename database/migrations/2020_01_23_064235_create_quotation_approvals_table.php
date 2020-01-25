<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotationApprovalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotation_approvals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('manager_status')->default('0');
            $table->integer('level1_status')->default('0');
            $table->integer('level2_status')->default('0');
            $table->integer('quote_id')->default('0');
            $table->integer('vendor_id')->default('0');
            $table->string('quotation_id');
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
        Schema::dropIfExists('quotation_approvals');
    }
}
