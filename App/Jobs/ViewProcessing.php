<?php

namespace App\Jobs;

use App\Enums\Queue\QueueEnum;
use App\Models\Image;
use App\Models\View;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ViewProcessing implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var View
     */
    protected $view;

    /**
     * @var bool
     */
    protected $force;

    /**
     * ViewCreated constructor.
     *
     * @param View $view
     * @param bool $force
     */
    public function __construct(View $view, bool $force = false)
    {
        $this->queue = QueueEnum::VIEW_PROCESSING;
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
        $this->view->images()->each(function (Image $image) {
            dispatch(new ImageProcessing($image, $this->view, $this->force));
        });
    }

}
