<?php

namespace App\Jobs;

use App\Corundum\Kit\Path;
use App\Enums\Image\ImageFormatsEnum;
use App\Enums\Queue\QueueEnum;
use App\Models\Image;
use App\Models\View;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Intervention\Image\Facades\Image as ImageManager;

class ImageWebp implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Image
     */
    protected $image;

    /**
     * @var View
     */
    protected $view;

    /**
     * Create a new job instance.
     *
     * @param Image $image
     * @param View $view
     */
    public function __construct(Image $image, View $view)
    {
        $this->queue = QueueEnum::IMAGE_WEBP;
        $this->image = $image;
        $this->view = $view;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        if (!$this->view->webp) {
            return;
        }

        $path = Path::physical($this->image, $this->view->name);
        $image = ImageManager::make($path);
        $image->encode(ImageFormatsEnum::WEBP, 100)
            ->save($path . '.' . ImageFormatsEnum::WEBP)
            ->destroy();
    }

}
