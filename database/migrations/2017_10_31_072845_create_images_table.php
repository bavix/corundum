<?php

use Bavix\Illuminate\Support\Facades\Schema;
use Bavix\Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->increments('id');

            $table->string('user');
            $table->string('name');

            $table->integer('user_id');

            $table->string('mime')->nullable();

            $table->boolean('status')
                ->comment('exists thumbnail: 0 -- no, 1 -- yes')
                ->default(0);

            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->integer('size')->nullable();

            $table->timestamps();

            $table->unique(['user', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('images');
    }
}
