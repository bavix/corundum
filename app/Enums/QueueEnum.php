<?php

namespace App\Enums;

class QueueEnum
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
