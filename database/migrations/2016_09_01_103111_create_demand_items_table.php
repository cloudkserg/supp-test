<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDemandItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demand_items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');

            $table->float('count');
            $table->integer('quantity_id')->unsigned();

            $table->integer('demand_id')->unsigned();
            $table->foreign('demand_id')->references('id')->on('demands')->onDelete('cascade');

            $table->integer('response_item_id')->unsigned()->nullable();


            $table->string('status');

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
        Schema::drop('demand_items');
    }
}
