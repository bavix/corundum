<?php

namespace App\Corundum\Adapters;

use App\Corundum\Adapter;
use Intervention\Image\Image;

class Cover extends Adapter
{

    /**
     * @param array $data
     *
     * @return Image
     */
    public function apply(array $data): Image
    {
        $image = $this->image();
        $sizes = $this->received($image, $data);

        return $this->handler($image, $sizes);
    }

}
