<?php

namespace App\Enums\Queue;

use App\Enums\Enum;

class QueueEnum extends Enum
{
    /**
     * Получение метаданных
     */
    public const METADATA = 'metadata';

    /**
     * Оптимизация изображений
     */
    public const OPTIMIZE = 'optimize';

    /**
     * Пробуем обработать изображения еще раз
     */
    public const REPROCESSING = 'reprocessing';

    /**
     * Генерация миниатюр
     */
    public const PROCESSING = 'processing';

    /**
     * Обрабока плохих изображений
     */
    public const FAILED = 'failed';
}
