<?php

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
            $table->smallInteger('status')->nullable();
            $table->integer('sort')->nullable();
            $table->string('verify_token')->nullable()->unique();
        });
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
            $table->dropColumn('sort');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('verify_token');
        });
    }
}
