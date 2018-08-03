<?php

namespace App\Jobs;

use App\Corundum\Kit\ImagePath;
use App\Enums\Image\ImageStatusEnum;
use App\Enums\Queue\QueueEnum;
use App\Models\Bucket;
use App\Models\Image;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ImageFailed implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Image
     */
    protected $image;

    /**
     * @var Bucket
     */
    protected $bucket;

    /**
     * ImageFailed constructor.
     *
     * @param Image $image
     * @param Bucket $bucket
     */
    public function __construct(Image $image, Bucket $bucket)
    {
        $this->queue = QueueEnum::FAILED;
        $this->image = $image;
        $this->bucket = $bucket;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        if (!ImagePath::exists($this->image, $this->bucket)) {
            Log::error('The original image was deleted', $this->image->toArray());
            $this->image->update(['status' => ImageStatusEnum::DELETED]);
            return;
        }
    }

}
