<?php

namespace App\Jobs;

use App\Enums\Image\ImageStatusEnum;
use App\Enums\Queue\QueueEnum;
use App\Models\Image;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ImageReprocessing implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Carbon
     */
    protected $time;

    /**
     * ImageProcessing constructor.
     *
     * @param Carbon $time
     */
    public function __construct(Carbon $time)
    {
        $this->queue = QueueEnum::REPROCESSING;
        $this->time = $time;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $query = Image::query()
            ->whereDate('updated_at', '<=', $this->time)
            ->where('status', ImageStatusEnum::PROCESSING);

        $query->each(function (Image $image) {
            dispatch(new ImageProcessing($image, true));
        });
    }

}
