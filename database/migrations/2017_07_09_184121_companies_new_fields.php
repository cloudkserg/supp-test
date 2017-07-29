<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CompaniesNewFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('founded')->nullable();
            $table->string('site')->nullable();
            $table->string('address')->nullable();
            $table->string('desc')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('founded');
        });
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('site');
        });
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('address');
        });
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('desc');
        });
    }
}
