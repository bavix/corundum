<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBucketsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buckets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('bucket_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('bucket_id');
            $table->integer('user_id');
            $table->timestamps();
            $table->unique(['bucket_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buckets');
        Schema::dropIfExists('bucket_user');
    }

}
