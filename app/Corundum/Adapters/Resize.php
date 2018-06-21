<?php

namespace App\Corundum\Adapters;

use Bavix\Slice\Slice;
use Intervention\Image\Image;

class Resize extends Adapter
{

    public function apply(Slice $slice): Image
    {
        return $this->image()->resize(
            $slice->getRequired('width'),
            $slice->getRequired('height')
        );
    }

}
