<?php

namespace App\Corundum\Adapters;

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
            \array_get($data, 'color')
        );
    }

}
