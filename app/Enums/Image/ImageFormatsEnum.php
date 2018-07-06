<?php

namespace App\Enums\Image;

use App\Enums\Enum;

/**
 * Class ImageFormatEnum
 * @package App\Enums\Image
 *
 * @see http://image.intervention.io/getting_started/formats
 */
class ImageFormatsEnum extends Enum
{
    public const PNG = 'png';
    public const JPG = 'jpg';
    public const WEBP = 'webp';
}
