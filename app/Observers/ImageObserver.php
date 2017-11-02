<?php

namespace App\Observes;

use App\Models\Image;

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
        $image->doDeleted();
    }

}
