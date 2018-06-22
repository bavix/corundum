<?php

namespace App\Corundum\Adapters;

use Intervention\Image\Constraint;
use Intervention\Image\Image;

class Fit extends Adapter
{

    /**
     * @param array $data
     *
     * @return Image
     */
    public function apply(array $data): Image
    {
        $image = $this->image();

        $pWidth = \array_get($data, 'width');
        $pHeight = \array_get($data, 'height');

        $width = $pWidth >= $pHeight ? $pHeight : null;
        $height = $pWidth < $pHeight ? $pWidth : null;

        return $image->resize($width, $height, function (Constraint $constraint) {
            $constraint->aspectRatio();
        });
    }

}
