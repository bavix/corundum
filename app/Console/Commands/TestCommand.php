<?php

namespace App\Console\Commands;

use App\Jobs\ImageJob;
use App\Models\Image;
use Illuminate\Console\Command;

class TestCommand extends Command
{

    protected $name = 'test';

    public function handle(): void
    {
        $image = new Image();
        $image->user = 'test';
        $image->name = \str_random(6);
        $image->user_id = 1;
        $image->save();

        ImageJob::dispatch($image)
            ->onQueue('low');
    }

}
