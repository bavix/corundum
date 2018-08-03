<?php

namespace App\Jobs;

use App\Corundum\Kit\ImagePath;
use App\Enums\Queue\QueueEnum;
use App\Models\Bucket;
use App\Models\Image;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Intervention\Image\Facades\Image as ImageManager;

class ImageMetadata implements ShouldQueue
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
     * Create a new job instance.
     *
     * @param Image $image
     * @param Bucket $bucket
     */
    public function __construct(Image $image, Bucket $bucket)
    {
        $this->queue = QueueEnum::METADATA;
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
        $image = ImageManager::make(ImagePath::physical($this->image, $this->bucket));

        $this->image->width = $image->width();
        $this->image->height = $image->height();
        $this->image->size = $image->filesize();
        $this->image->mime = $image->mime();
        $this->image->save();
    }

}
