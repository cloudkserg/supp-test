<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResponseItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('response_items', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('response_id')->unsigned();
            $table->foreign('response_id')->references('id')->on('responses')->onDelete('cascade');

            $table->integer('demand_item_id')->unsigned();
            $table->foreign('demand_item_id')->references('id')->on('demand_items')->onDelete('cascade');

            $table->integer('price_raw');

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
        Schema::drop('response_items');
    }
}
