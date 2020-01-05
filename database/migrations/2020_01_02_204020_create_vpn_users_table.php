<?php

use App\Shared;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVpnUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vpn_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('login');
            $table->string('password_hash');
            $table->string('password_plain');
            $table->string('group_id');
            $table->string('status');
            $table->string('connect_status')->nullable();
            $table->string('comment')->nullable();
            $table->timestamps();
            $table->foreign('group_id')->references('id')->on('vpn_groups')->onDelete('cascade');
        });

        DB::table('vpn_users')->update([
            'connect_status' => Shared::CLIENT_DISCONNECT,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vpn_users');
    }
}
