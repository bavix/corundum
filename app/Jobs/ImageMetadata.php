<?php

namespace App\Jobs;

use App\Corundum\Kit\Path;
use App\Enums\Queue\QueueEnum;
use App\Models\Image;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Intervention\Image\Facades\Image as ImageManager;
use Jenssegers\ImageHash\ImageHash;
use Jenssegers\ImageHash\Implementations\DifferenceHash;

class ImageMetadata implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Image
     */
    protected $image;

    /**
     * Create a new job instance.
     *
     * @param Image $image
     */
    public function __construct(Image $image)
    {
        $this->queue = QueueEnum::IMAGE_METADATA;
        $this->image = $image;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $physical = Path::physical($this->image);

        /**
         * @var $imageManager \Intervention\Image\ImageManager
         */
        $imageManager = ImageManager::configure();
        $image = ImageManager::make($physical);

        $hasher = new ImageHash(
            new DifferenceHash(),
            $imageManager
        );

        $hash = $hasher->hash($physical);
        $this->image->fingerprint = $hash->toInt();
        $this->image->width = $image->width();
        $this->image->height = $image->height();
        $this->image->size = $image->filesize();
        $this->image->mime = $image->mime();
        $this->image->save();

        // Free up memory
        $image->destroy();
    }

}
