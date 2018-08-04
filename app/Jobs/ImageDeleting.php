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

class ImageDeleting implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Image
     */
    protected $image;

    /**
     * ImageProcessing constructor.
     *
     * @param Image $image
     */
    public function __construct(Image $image)
    {
        $this->queue = QueueEnum::DELETING;
        $this->image = $image;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        Path::remove($this->image);
        foreach ($this->image->views as $view) {
            Path::remove($this->image, $view->name);
        }

        $this->image->status = ImageStatusEnum::DELETED;
        $this->image->save();
    }

}
