<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGeoIntoLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vpn_logs', function (Blueprint $table) {
            $table->string('rdns')->nullable();
            $table->string('asn')->nullable();
            $table->string('isp')->nullable();
            $table->string('country_name')->nullable();
            $table->string('country_code')->nullable();
            $table->string('region_name')->nullable();
            $table->string('region_code')->nullable();
            $table->string('city')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('continent_code')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('metro_code')->nullable();
            $table->string('timezone')->nullable();
            $table->string('datetime')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vpn_logs', function (Blueprint $table) {
            $table->dropColumn('rdns');
        });
        Schema::table('vpn_logs', function (Blueprint $table) {
            $table->dropColumn('asn');
        });
        Schema::table('vpn_logs', function (Blueprint $table) {
            $table->dropColumn('isp');
        });
        Schema::table('vpn_logs', function (Blueprint $table) {
            $table->dropColumn('country_name');
        });
        Schema::table('vpn_logs', function (Blueprint $table) {
            $table->dropColumn('country_code');
        });
        Schema::table('vpn_logs', function (Blueprint $table) {
            $table->dropColumn('region_name');
        });
        Schema::table('vpn_logs', function (Blueprint $table) {
            $table->dropColumn('region_code');
        });
        Schema::table('vpn_logs', function (Blueprint $table) {
            $table->dropColumn('city');
        });
        Schema::table('vpn_logs', function (Blueprint $table) {
            $table->dropColumn('postal_code');
        });
        Schema::table('vpn_logs', function (Blueprint $table) {
            $table->dropColumn('continent_code');
        });
        Schema::table('vpn_logs', function (Blueprint $table) {
            $table->dropColumn('latitude');
        });
        Schema::table('vpn_logs', function (Blueprint $table) {
            $table->dropColumn('longitude');
        });
        Schema::table('vpn_logs', function (Blueprint $table) {
            $table->dropColumn('metro_code');
        });
        Schema::table('vpn_logs', function (Blueprint $table) {
            $table->dropColumn('timezone');
        });
        Schema::table('vpn_logs', function (Blueprint $table) {
            $table->dropColumn('datetime');
        });
    }
}
