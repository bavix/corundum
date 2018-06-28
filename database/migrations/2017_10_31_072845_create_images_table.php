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
                'name' => 'mime',
                'slug' => 'mime',
                'entities' => [\App\Models\Image::class],
                'group' => 'metadata',
            ],
            [
                'type' => 'integer',
                'name' => 'width',
                'slug' => 'width',
                'entities' => [\App\Models\Image::class],
                'group' => 'metadata',
            ],
            [
                'type' => 'integer',
                'name' => 'height',
                'slug' => 'height',
                'entities' => [\App\Models\Image::class],
                'group' => 'metadata',
            ],
            [
                'type' => 'integer',
                'name' => 'size',
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
        Schema::create('images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('bucket_id');
            $table->integer('user_id');
            $table->boolean('processed')->default(0);
            $table->timestamps();
            $table->unique(['name']);
        });

        foreach ($this->attributes() as $attribute) {
            Attribute::create($attribute);
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
