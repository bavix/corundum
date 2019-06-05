<?php

use App\Enums\Image\ImageViewsEnum;
use App\Enums\Image\ImageFormatsEnum;
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

            $table->integer('user_id')->unsigned();
            $table->integer('bucket_id')->unsigned();
            $table->string('name');

            $table->enum('format', ImageFormatsEnum::enums())
                ->default(ImageFormatsEnum::PNG);

            $table->enum('type', ImageViewsEnum::enums());

            $table->integer('width')
                ->unsigned()
                ->nullable();

            $table->integer('height')
                ->unsigned()
                ->nullable();

            $table->string('color')
                ->nullable();

            $table->integer('quality')
                ->unsigned()
                ->nullable();

            $table->boolean('optimize')
                ->default(0);

            $table->boolean('webp')
                ->default(0);

            $table->unique(['user_id', 'bucket_id', 'name']);
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('bucket_id')
                ->references('id')->on('buckets')
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
        Schema::dropIfExists('views');
    }

}
