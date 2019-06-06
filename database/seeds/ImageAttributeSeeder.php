<?php

use Illuminate\Database\Seeder;

class ImageAttributeSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->attributes() as $attribute) {
            app('rinvex.attributes.attribute')
                ->create($attribute);
        }
    }

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

}
