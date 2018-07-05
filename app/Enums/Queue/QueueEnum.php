<?php

namespace App\Enums\Queue;

use App\Enums\Enum;

class QueueEnum extends Enum
{
    /**
     * Оптимизация + форматы изображений
     */
    public const LOW = 'low';

    /**
     * Ресайз изображений
     */
    public const NORMAL = 'normal';

    /**
     * Для сохранения изображений физически и в СУБД
     */
    public const HIGH = 'high';
}
