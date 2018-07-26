<?php

namespace App\Observes;

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
        // todo: создаем миниатюру
    }

    /**
     * @param View $view
     *
     * @return void
     */
    public function updated(View $view): void
    {
        // todo: обновляем миниатюру
    }

    /**
     * @param View $view
     *
     * @return void
     */
    public function deleted(View $view): void
    {
        // todo: удаляем миниатюру
    }

}
