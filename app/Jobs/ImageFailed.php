<?php

namespace App\Jobs;

use App\Corundum\Kit\Path;
use App\Enums\Image\ImageStatusEnum;
use App\Enums\Queue\QueueEnum;
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
     * ImageFailed constructor.
     *
     * @param Image $image
     */
    public function __construct(Image $image)
    {
        $this->queue = QueueEnum::FAILED;
        $this->image = $image;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        if (!Path::exists($this->image)) {
            Log::error('The original image was deleted', $this->image->toArray());
            $this->image->status = ImageStatusEnum::DELETED;
            $this->image->save();
            return;
        }
    }

}
