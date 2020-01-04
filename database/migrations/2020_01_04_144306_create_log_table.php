<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vpn_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('common_name');
            $table->string('name');
            $table->string('group');
            $table->string('event');
            $table->string('remote_ip')->nullable();
            $table->string('request_ip')->nullable();
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
        Schema::dropIfExists('vpn_logs');
    }
}
