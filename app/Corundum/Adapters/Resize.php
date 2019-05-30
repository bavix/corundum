<?php

namespace App\Corundum\Adapters;

use App\Corundum\Adapter;
use Intervention\Image\Image;

class Resize extends Adapter
{

    /**
     * @param array $data
     * @return Image
     */
    public function apply(array $data): Image
    {
        return $this->image()->resize(
            \array_get($data, 'width'),
            \array_get($data, 'height')
        );
    }

}
