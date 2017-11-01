<?php

namespace App\Observes;

use App\Models\Image;
use Bavix\Extra\Gearman;

class ImageObserver
{

    /**
     * @param Image $image
     *
     * @return void
     */
    public function created(Image $image)
    {
        $image->doBackground();
    }

    /**
     * @param Image $image
     *
     * @return void
     */
    public function deleting(Image $image)
    {
        //
    }

}
