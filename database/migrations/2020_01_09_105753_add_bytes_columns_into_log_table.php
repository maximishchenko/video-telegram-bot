<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBytesColumnsIntoLogTable extends Migration
{

    public function up()
    {
        Schema::table('vpn_logs', function (Blueprint $table) {
            $table->integer('bytes_received')->nullable();
            $table->integer('bytes_sent')->nullable();
        });
    }

    public function down()
    {
        Schema::table('vpn_logs', function (Blueprint $table) {
            $table->dropColumn('bytes_received');
            $table->dropColumn('bytes_sent');
        });
    }
}
