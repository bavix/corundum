<?php

namespace App\Enums\Image;

use App\Enums\File\FileStatusEnum;

class ImageStatusEnum extends FileStatusEnum
{
    /**
     * Поставлено в очередь (генерация миниатюрок)
     *
     * @var string
     */
    public const PROCESSING = 'processing';
}
