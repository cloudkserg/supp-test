<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDemandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demands', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->text('desc')->nullable();
            $table->text('address')->nullable();
            $table->date('delivery_date')->nullable();
            $table->string('status');
            $table->integer('company_id')->unsigned();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->text('addition_emails_raw')->nullable();
            $table->timestamps();
        });

        Schema::create('demand_regions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('region_id')->unsigned();
            $table->foreign('region_id')->references('id')->on('regions')->onDelete('cascade');

            $table->integer('demand_id')->unsigned();
            $table->foreign('demand_id')->references('id')->on('demands')->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('demand_spheres', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sphere_id')->unsigned();
            $table->foreign('sphere_id')->references('id')->on('spheres')->onDelete('cascade');

            $table->integer('demand_id')->unsigned();
            $table->foreign('demand_id')->references('id')->on('demands')->onDelete('cascade');

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
        Schema::drop('demand_spheres');
        Schema::drop('demand_regions');
        Schema::drop('demands');
    }
}
