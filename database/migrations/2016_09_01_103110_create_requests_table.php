<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('desc');
            $table->text('address');
            $table->date('delivery_date');
            $table->integer('company_id')->unsigned();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->text('addition_emails_raw');
            $table->timestamps();
        });

        Schema::create('request_regions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('region_id')->unsigned();
            $table->foreign('region_id')->references('id')->on('regions')->onDelete('cascade');

            $table->integer('request_id')->unsigned();
            $table->foreign('request_id')->references('id')->on('requests')->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('request_spheres', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sphere_id')->unsigned();
            $table->foreign('sphere_id')->references('id')->on('spheres')->onDelete('cascade');

            $table->integer('request_id')->unsigned();
            $table->foreign('request_id')->references('id')->on('requests')->onDelete('cascade');

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
        Schema::drop('request_spheres');
        Schema::drop('request_regions');
        Schema::drop('requests');
    }
}
