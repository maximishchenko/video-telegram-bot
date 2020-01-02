<?php

use App\Shared;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserVerificaton extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->nullable()->unique();
            $table->string('status')->nullable();
            $table->string('phone')->nullable();
            $table->string('verify_token')->nullable()->unique();
        });
        DB::table('users')->update([
            'status' => Shared::STATUS_ACTIVE
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('username');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('phone');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('verify_token');
        });
    }
}
