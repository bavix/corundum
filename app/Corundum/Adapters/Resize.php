<?php

namespace App\Corundum\Adapters;

use App\Corundum\Adapter;
use Illuminate\Support\Arr;
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
            Arr::get($data, 'width'),
            Arr::get($data, 'height')
        );
    }

}
