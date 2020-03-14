<?php

namespace App\Corundum\Adapters;

use App\Corundum\Adapter;
use Illuminate\Support\Arr;
use Intervention\Image\Image;

class Contain extends Adapter
{

    /**
     * @param array $data
     *
     * @return Image
     */
    public function apply(array $data): Image
    {
        $image = $this->image();
        $sizes = $this->received($image, $data, false);

        return $this->handler(
            $image,
            $sizes,
            Arr::get($data, 'color')
        );
    }

}
