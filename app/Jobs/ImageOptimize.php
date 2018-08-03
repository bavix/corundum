<?php

namespace App\Jobs;

use App\Enums\Queue\QueueEnum;
use App\Models\Bucket;
use App\Models\Image;
use App\Models\View;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImageOptimize implements ShouldQueue
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
     * @var View
     */
    protected $view;

    /**
     * Create a new job instance.
     *
     * @param Image $image
     * @param Bucket $bucket
     * @param View $view
     */
    public function __construct(Image $image, Bucket $bucket, View $view)
    {
        $this->queue = QueueEnum::OPTIMIZE;
        $this->image = $image;
        $this->bucket = $bucket;
        $this->view = $view;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        if (!$this->view->optimize) {
            return;
        }

        // todo;
    }

}
