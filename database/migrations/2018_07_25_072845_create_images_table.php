<?php

use App\Enums\Image\ImageStatusEnum;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{

    /**
     * @return array
     */
    protected function attributes(): array
    {
        return [
            [
                'type' => 'varchar',
                'name' => 'MIME type',
                'slug' => 'mime',
                'entities' => [\App\Models\Image::class],
                'group' => 'metadata',
            ],
            [
                'type' => 'integer',
                'name' => 'Image width',
                'slug' => 'width',
                'entities' => [\App\Models\Image::class],
                'group' => 'metadata',
            ],
            [
                'type' => 'integer',
                'name' => 'Image height',
                'slug' => 'height',
                'entities' => [\App\Models\Image::class],
                'group' => 'metadata',
            ],
            [
                'type' => 'integer',
                'name' => 'File size',
                'slug' => 'size',
                'entities' => [\App\Models\Image::class],
                'group' => 'metadata',
            ],
            [
                'type' => 'varchar',
                'name' => 'Image fingerprint',
                'slug' => 'fingerprint',
                'entities' => [\App\Models\Image::class],
                'group' => 'metadata',
            ],
            [
                'type' => 'boolean',
                'name' => 'Alpha channel',
                'slug' => 'alpha',
                'entities' => [\App\Models\Image::class],
                'group' => 'metadata',
            ]
        ];
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('name');
            $table->integer('bucket_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->enum('status', ImageStatusEnum::enums());
            $table->timestamps();

            $table->unique(['name', 'bucket_id']);

            $table->foreign('bucket_id')
                ->references('id')->on('buckets')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        foreach ($this->attributes() as $attribute) {
            app('rinvex.attributes.attribute')
                ->create($attribute);
        }
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
