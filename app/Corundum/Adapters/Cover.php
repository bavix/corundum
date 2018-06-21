<?php

namespace App\Corundum\Adapters;

use Bavix\Slice\Slice;
use Intervention\Image\Image;

class Cover extends Adapter
{

    /**
     * @param Slice $slice
     *
     * @return Image
     */
    public function apply(Slice $slice): Image
    {
        $image = $this->image();
        $sizes = $this->received($image, $slice);

        return $this->handler($image, $sizes);
    }

}
