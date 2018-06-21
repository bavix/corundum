<?php

namespace App\Corundum\Adapters;

use Bavix\Slice\Slice;
use Intervention\Image\Image;

class Contain extends Adapter
{

    /**
     * @param Slice $slice
     *
     * @return Image
     */
    public function apply(Slice $slice): Image
    {
        $image = $this->image();
        $sizes = $this->received($image, $slice, false);

        return $this->handler(
            $image,
            $sizes,
            $slice->getRequired('color')
        );
    }

}
