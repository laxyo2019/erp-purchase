<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorsMailSendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors_mail_sends', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email');
            $table->string('quotion_id');
            $table->text('item_list');
            $table->integer('quotion_sent_id');
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
        Schema::dropIfExists('vendors_mail_sends');
    }
}
