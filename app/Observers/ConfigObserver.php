<?php

namespace App\Observes;

use App\Models\View;
use Bavix\Extra\Gearman;

class ConfigObserver
{

    /**
     * @param View $config
     *
     * @return void
     */
    public function created(View $config)
    {
        $config->doCreated();
    }

    /**
     * @param View $config
     *
     * @return void
     */
    public function updated(View $config)
    {
        $config->doUpdated();
    }

    public function deleted()
    {
        Gearman::reload(['reload']);
    }

    /**
     * @param View $config
     *
     * @return void
     */
    public function deleting(View $config)
    {
        $config->doDeleted();
    }

}
