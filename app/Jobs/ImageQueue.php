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

class ImageQueue implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Image
     */
    protected $image;

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
     * @param bool $force
     */
    public function __construct(Image $image, bool $force = false)
    {
        $this->queue = QueueEnum::IMAGE_QUEUE;
        $this->image = $image;
        $this->force = $force;
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
            $this->failed();
            return;
        }

        if (!$this->force && $this->image->status === ImageStatusEnum::PROCESSING) {
            Log::info('The image is already in process', $this->image->toArray());
            return;
        }

        $states = [ImageStatusEnum::UPLOADED];
        if (\in_array($this->image->status, $states, true)) {
            $this->image->status = ImageStatusEnum::PROCESSING;
            $this->image->save();
        }

        /**
         * Ставим задачу на получение метаданных
         */
        dispatch(new ImageMetadata($this->image));

        /**
         * Генерируем представления
         */
        foreach ($this->image->views as $view) {
            dispatch(new ImageProcessing($this->image, $view, $this->force));
        }

        /**
         * Завершено
         */
        $this->image->status = ImageStatusEnum::FINISHED;
        $this->image->save();
    }

    /**
     * @return void
     */
    protected function failed(): void
    {
        dispatch(new ImageFailed($this->image));
    }

}
