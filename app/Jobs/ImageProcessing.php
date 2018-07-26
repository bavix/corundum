<?php

namespace App\Jobs;

use App\Corundum\Adapters\Adapter;
use App\Corundum\Corundum;
use App\Corundum\Kit\Path;
use App\Corundum\Runner;
use App\Enums\Image\ImageViewsEnum;
use App\Enums\Queue\QueueEnum;
use App\Models\Image;
use App\Models\View;
use Bavix\Helpers\File;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

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
     * @var Image $image
     */
    protected $image;

    /**
     * @var Runner[]
     */
    protected $runners;

    /**
     * ImageProcessing constructor.
     *
     * @param Image $image
     */
    public function __construct(Image $image)
    {
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
            Log::error('The file `' . $this->image->name . '` of the user `' .
                $this->image->user . '` isn\'t found');
        }

        foreach ($this->image->views as $view) {
            $this->processing($view);
        }

        $this->runner($this->image->user)->apply(
            $this->image->name,
            $this->image->thumbnails,
            // to include check on existence of the file
            $this->image->getCheckExists()
        );

        $this->image->processed = 1;
        $this->image->save();

//        $options = [
//            'driver' => config('config.driver')
//        ];
//
//        // set information
//        $image = (new ImageManager($options))->make(
//            Image::realPath($this->image->user, $this->image->name)
//        );
//
//        $this->image->processed = 1;
//        $this->image->width = $image->getWidth();
//        $this->image->height = $image->getHeight();
//        $this->image->size = $image->filesize();
//        $this->image->save();

        ImageMetadata::dispatch($this->image)
            ->onQueue(QueueEnum::LOW);

        /**
         * отправляем на оптимизацию
         */
        foreach ($this->image->thumbnails as $thumbnail) {
            ImageOptimization::dispatch($this->image, $thumbnail)
                ->onQueue(QueueEnum::LOW);
        }
    }

    /**
     * @param View $view
     */
    protected function processing(View $view): void
    {
        $physical = Path::physical($this->image);

        /**
         * @var Adapter $adapter
         */
        $adapter = new $this->adapters[$view->type]($physical);
        $adapter->apply($view->toArray())
            ->save(Path::physical($this->image, $view->type), $view->quality);
    }

    /**
     * @param string $user
     *
     * @return Runner
     */
    protected function runner(string $user): Runner
    {
        if (!isset($this->runners[$user])) {
            $array = \array_merge(
                \config('corundum'),
                \compact('user')
            );

            $corundum = new Corundum($array);
            $this->runners[$user] = new Runner($corundum);
        }

        return $this->runners[$user];
    }

}
