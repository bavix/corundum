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

class ImageReprocessing implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Carbon
     */
    protected $time;

    /**
     * @var string
     */
    protected $status;

    /**
     * ImageProcessing constructor.
     *
     * @param Carbon $time
     * @param string  $status
     */
    public function __construct(Carbon $time, string $status)
    {
        $this->queue = QueueEnum::IMAGE_REPROCESSING;
        $this->time = $time;
        $this->status = $status;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $query = Image::with(['bucket'])
            ->where('updated_at', '<=', $this->time)
            ->where('status', $this->status);

        $query->each(function (Image $image) {
            dispatch(new ImageQueue($image, true));
        });
    }

}
