<?php

use App\Enums\Image\ImageViewsEnum;
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

            $table->enum('type', ImageViewsEnum::enums());

            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->string('color')->nullable();
            $table->integer('quality')->nullable();
            $table->boolean('optimize')->default(0);
            $table->boolean('webp')->default(0);

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
        Schema::dropIfExists('views');
    }

}
