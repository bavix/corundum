<?php

namespace App\Corundum\Adapters;

use App\Corundum\Adapter;
use Illuminate\Support\Arr;
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

        $pWidth = Arr::get($data, 'width');
        $pHeight = Arr::get($data, 'height');

        $width = $pWidth >= $pHeight ? $pHeight : null;
        $height = $pWidth < $pHeight ? $pWidth : null;

        return $image->resize($width, $height, function (Constraint $constraint) {
            $constraint->aspectRatio();
        });
    }

}
