<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RfiUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rfi_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('requested_data');
            $table->integer('user_id');
            $table->integer('manager_status')->default('0');
            $table->integer('level1_status')->default('0');
            $table->integer('level2_status')->default('0');
            $table->string('requested_role')->nullable();
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
        Schema::dropIfExists('rfi_users');
    }
}
