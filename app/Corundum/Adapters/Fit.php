<?php

namespace App\Corundum\Adapters;

use Bavix\Slice\Slice;
use Intervention\Image\Constraint;
use Intervention\Image\Image;

class Fit extends Adapter
{

    /**
     * @param Slice $slice
     *
     * @return Image
     */
    public function apply(Slice $slice): Image
    {
        $image = $this->image();

        $pWidth = $slice->getRequired('width');
        $pHeight = $slice->getRequired('height');

        $width = $pWidth >= $pHeight ? $pHeight : null;
        $height = $pWidth < $pHeight ? $pWidth : null;

        return $image->resize($width, $height, function (Constraint $constraint) {
            $constraint->aspectRatio();
        });
    }

}
