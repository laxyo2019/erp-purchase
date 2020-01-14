<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RfiManager extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rfi_manager', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('data');
            $table->integer('requested_id');
            $table->integer('approval_id')->default('0');
            $table->integer('level1_status')->default('0');
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
        Schema::dropIfExists('rfi_manager');
    }
}
