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
     * Генерация миниатюр
     */
    public const PROCESSING = 'processing';

    /**
     * Конвертирование в разные форматы
     */
    public const CONVERT = 'convert';
}
