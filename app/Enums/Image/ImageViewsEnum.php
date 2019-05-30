<?php

namespace App\Enums\Image;

use App\Enums\Enum;

class ImageViewsEnum extends Enum
{
    public const FIT = 'fit';
    public const NONE = 'none';
    public const COVER = 'cover';
    public const CONTAIN = 'contain';
    public const RESIZE = 'resize';
}
