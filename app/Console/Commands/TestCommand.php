<?php

namespace App\Console\Commands;

use App\Models\Bucket;
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
        $bucket = Bucket::query()->first();
        if (!$bucket) {
            $bucket = new Bucket();
            $bucket->name = 'test';
            $bucket->save();
        }

        $image = Image::query()->first();

        if (!$image) {
            $image = new Image();
            $image->bucket_id = 1;
            $image->user_id = 1;
            $image->save();
        }

        var_dump($image->toArray());
        die;
    }

}
