<?php

namespace App\Enums\Queue;

use App\Enums\Enum;

class QueueEnum extends Enum
{
    /**
     * Генерация миниатюр
     */
    public const QUEUE = 'queue';

    /**
     * Получение метаданных
     */
    public const METADATA = 'metadata';

    /**
     * Конвертируем в webp
     */
    public const WEBP = 'webp';

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
     * Удаление изображений и миниатюр
     */
    public const DELETING = 'deleting';

    /**
     * Обрабока плохих изображений
     */
    public const FAILED = 'failed';
}
