<?php

namespace App\Jobs;

use App\Enums\Image\ImageStatusEnum;
use App\Enums\Queue\QueueEnum;
use App\Models\Image;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImageReprocessing implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Builder
     */
    protected $collection;

    /**
     * ImageProcessing constructor.
     *
     * @param Collection $collection
     */
    public function __construct(Collection $collection)
    {
        $this->queue = QueueEnum::REPROCESSING;
        $this->collection = $collection;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->collection->update(['status' => ImageStatusEnum::UPLOADED]);

        /**
         * @var Image $image
         */
        foreach ($this->collection as $image) {
            dispatch(new ImageProcessing($image));
        }
    }

}
