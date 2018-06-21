<?php

namespace App\Jobs;

use App\Enums\QueueEnum;
use App\Models\Image;
use Bavix\Helpers\Arr;
use Bavix\Helpers\Corundum\Corundum;
use Bavix\Helpers\Corundum\Runner;
use Bavix\Helpers\File;
use Bavix\Slice\Slice;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;

class ImageProcessing implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Image $image
     */
    protected $image;

    /**
     * @var Slice
     */
    protected $slice;

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
        $config = config('corundum');
        $this->slice   = new Slice($config);
        $this->image = $image;
    }

    /**
     * @param string $user
     *
     * @return Runner
     */
    protected function runner(string $user): Runner
    {
        if (!isset($this->runners[$user]))
        {
            $corundum = new Corundum($this->slice->make(Arr::merge(
                $this->slice->asArray(),
                [
                    'user' => $user
                ]
            )));

            $this->runners[$user] = new Runner($corundum);
        }

        return $this->runners[$user];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {

        if (!File::isFile(Image::realPath($this->image->user, $this->image->name)))
        {
            Log::error('The file `' . $this->image->name . '` of the user `' .
                $this->image->user . '` isn\'t found');
            return;
        }

        $this->runner($this->image->user)->apply(
            $this->image->name,
            null, // fixme: remove v2.0
            // to include check on existence of the file
            $this->image->getCheckExists()
        );

        $options = [
            'driver' => config('config.driver')
        ];

        // set information
        $image = (new ImageManager($options))->make(
            Image::realPath($this->image->user, $this->image->name)
        );

        $this->image->processed = 1;
        $this->image->width = $image->getWidth();
        $this->image->height = $image->getHeight();
        $this->image->size = $image->filesize();
        $this->image->save();

        /**
         * отправляем на оптимизацию
         */
        foreach ($this->image->thumbnails() as $thumbnail)
        {
            ImageOptimization::dispatch($image, $thumbnail)
                ->onQueue(QueueEnum::LOW);
        }
    }

}
