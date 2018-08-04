<?php

namespace App\Jobs;

use App\Corundum\Kit\Path;
use App\Enums\Queue\QueueEnum;
use App\Models\Image;
use App\Models\View;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ViewDeleting implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var View
     */
    protected $view;

    /**
     * ViewCreated constructor.
     *
     * @param View $view
     */
    public function __construct(View $view)
    {
        $this->queue = QueueEnum::VIEW_PROCESSING;
        $this->view = $view;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->view->images()->each(function (Image $image) {
            Path::remove($image, $this->view->name);
        });
    }

}
