<?php

namespace App\Observes;

use App\Jobs\ViewDeleting;
use App\Jobs\ViewProcessing;
use App\Models\View;

class ViewObserver
{

    /**
     * @param View $view
     *
     * @return void
     */
    public function created(View $view): void
    {
        dispatch(new ViewProcessing($view));
    }

    /**
     * @param View $view
     *
     * @return void
     */
    public function updated(View $view): void
    {
        dispatch(new ViewProcessing($view, true));
    }

    /**
     * @param View $view
     *
     * @return bool
     */
    public function deleting(View $view): bool
    {
        dispatch(new ViewDeleting($view));

        return false;
    }

}
