<?php

namespace App\Observes;

use App\Models\Config;
use App\Models\Image;
use App\Models\User;
use Bavix\Extra\Gearman;
use Bavix\Helpers\File;

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
