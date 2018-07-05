<?php

namespace App\Console\Commands;

use App\Enums\Image\ImageStatusEnum;
use App\Models\Image;
use Illuminate\Console\Command;

class TestCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test Command';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $image = Image::query()->first();

        if (!$image) {
            $image = new Image();
            $image->name = Image::generateName(1, 'png');
            $image->bucket_id = 1;
            $image->user_id = 1;
            $image->save();
        }

        var_dump($image->toArray());
        die;
    }

}
