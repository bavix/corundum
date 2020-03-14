<?php

namespace App\Console\Commands;

use App\Enums\Image\ImageStatusEnum;
use App\Jobs\ImageReprocessing;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class ReprocessingCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'image:reprocessing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adds images to the queue that are stuck in the processing status.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        dispatch(new ImageReprocessing(
            Carbon::now()->subMinute(15),
            ImageStatusEnum::PROCESSING
        ));

        dispatch(new ImageReprocessing(
            Carbon::now()->subMinute(10),
            ImageStatusEnum::UPLOADED
        ));

        dispatch(new ImageReprocessing(
            Carbon::now()->subMinute(5),
            ImageStatusEnum::INITIALIZED
        ));
    }

}
