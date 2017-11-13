<?php

namespace App\Observes;

use Bavix\Extra\Gearman;
use App\Models\Config;

class ConfigObserver
{

    /**
     * @param Config $config
     *
     * @return void
     */
    public function created(Config $config)
    {
        $config->doCreated();
    }

    /**
     * @param Config $config
     *
     * @return void
     */
    public function updated(Config $config)
    {
        $config->doUpdated();
    }

    public function deleted()
    {
        Gearman::reload(['reload']);
    }

    /**
     * @param Config $config
     *
     * @return void
     */
    public function deleting(Config $config)
    {
        $config->doDeleted();
    }

}
