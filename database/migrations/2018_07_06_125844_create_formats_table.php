<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormatsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formats', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('format_image', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('image_id');
            $table->integer('format_id');
        });

        $values = new \Illuminate\Support\Collection(
            \App\Enums\Image\ImageFormatEnum::enums()
        );
        
        $formats = $values->map(function ($value) {
            return ['name' => $value];
        });

        \Illuminate\Support\Facades\DB::table('formats')
            ->insert($formats->toArray());
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('formats');
        Schema::dropIfExists('format_image');
    }

}
