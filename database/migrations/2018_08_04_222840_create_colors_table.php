<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColorsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('colors', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dec');
            $table->timestamps();
        });

        Schema::create('color_image', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('color_id')->unsigned();
            $table->integer('image_id')->unsigned();
            $table->integer('count');
            $table->boolean('dominant');
            $table->timestamps();

            $table->foreign('color_id')
                ->references('id')->on('colors')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('image_id')
                ->references('id')->on('images')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('color_image');
        Schema::dropIfExists('colors');
    }

}
