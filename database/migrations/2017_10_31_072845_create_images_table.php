<?php

use Illuminate\Support\Facades\Schema;
use Rinvex\Attributes\Models\Attribute;
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
                'name' => 'Image size',
                'slug' => 'size',
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
        $status = [
            \App\Enums\Image\ImageStatusEnum::UPLOADED,
            \App\Enums\Image\ImageStatusEnum::PROCESSING,
            \App\Enums\Image\ImageStatusEnum::FINISHED,
            \App\Enums\Image\ImageStatusEnum::DELETED,
            \App\Enums\Image\ImageStatusEnum::FAILED,
        ];

        Schema::create('images', function (Blueprint $table) use ($status) {
            $table->increments('id');

            $table->string('name');
            $table->integer('bucket_id');
            $table->integer('user_id');

            $table->enum('status', $status)
                ->default(\App\Enums\Image\ImageStatusEnum::UPLOADED);

            $table->timestamps();

            $table->unique(['name', 'bucket_id']);
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
