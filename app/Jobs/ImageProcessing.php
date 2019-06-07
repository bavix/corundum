<?php

namespace App\Jobs;

use App\Corundum\Adapter;
use App\Corundum\Kit\Path;
use App\Enums\Image\ImageStatusEnum;
use App\Enums\Image\ImageViewsEnum;
use App\Enums\Queue\QueueEnum;
use App\Models\Image;
use App\Models\View;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;

class ImageProcessing implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var array
     */
    protected $adapters = [
        ImageViewsEnum::CONTAIN => \App\Corundum\Adapters\Contain::class,
        ImageViewsEnum::COVER => \App\Corundum\Adapters\Cover::class,
        ImageViewsEnum::FIT => \App\Corundum\Adapters\Fit::class,
        ImageViewsEnum::NONE => \App\Corundum\Adapters\None::class,
        ImageViewsEnum::RESIZE => \App\Corundum\Adapters\Resize::class,
    ];

    /**
     * @var Image
     */
    protected $image;

    /**
     * @var View
     */
    protected $view;

    /**
     * Принудительная генерация изображений
     *
     * @var bool
     */
    protected $force;

    /**
     * ImageProcessing constructor.
     *
     * @param Image $image
     * @param View $view
     * @param bool $force
     */
    public function __construct(Image $image, View $view, bool $force = false)
    {
        $this->queue = QueueEnum::IMAGE_PROCESSING;
        $this->image = $image;
        $this->view = $view;
        $this->force = $force;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $physical = Path::physical($this->image);
        $thumbnail = Path::physical($this->image, $this->view->name);

        /**
         * Файл принудительно генерировать не нужно и
         *  он уже существует
         */
        if (!$this->force && File::exists($thumbnail)) {
            /**
             * Файл уже существует
             */
            return;
        }

        /**
         * создаем директорию
         */
        Path::makeDirectory($this->image, $this->view->name);

        /**
         * @var Adapter $adapter
         */
        $adapter = new $this->adapters[$this->view->type]($physical);
        $image = $adapter->apply($this->view->toArray());

        $format = $this->view->format;
        $filepath = "$thumbnail.$format";

        $image->save($filepath, $this->view->quality)
            ->destroy();

        \copy($filepath, $thumbnail);
        \unlink($filepath);

        dispatch(new ImageOptimize($this->image, $this->view));
        dispatch(new ImageWebp($this->image, $this->view));
    }

    /**
     * @return void
     */
    public function failed(): void
    {
        $this->image->status = ImageStatusEnum::PROCESSING;
        $this->image->save();

        dispatch(new ImageFailed($this->image));
    }

}
