<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('views', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id');
            $table->integer('bucket_id');
            $table->string('name');

            $table->enum('type', [
                \App\Enums\Image\ImageViewsEnum::FIT,
                \App\Enums\Image\ImageViewsEnum::NONE,
                \App\Enums\Image\ImageViewsEnum::COVER,
                \App\Enums\Image\ImageViewsEnum::CONTAIN,
                \App\Enums\Image\ImageViewsEnum::RESIZE,
            ]);

            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->string('color')->nullable();
            $table->integer('quality')->nullable();

            $table->unique(['user_id', 'bucket_id', 'name']);

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
