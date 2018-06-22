<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configs', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');
            $table->integer('user_id');

            $table->enum('type', [
                'fit',
                'none',
                'cover',
                'contain',
                'resize'
            ]);

            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->string('color')->nullable();
            $table->integer('quality')->nullable();

            $table->unique(['name', 'user_id']);

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
        Schema::dropIfExists('configs');
    }

}
