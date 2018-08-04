<?php

namespace App\Enums\Queue;

use App\Enums\Enum;

class QueueEnum extends Enum
{
    /**
     * Генерация миниатюр
     */
    public const IMAGE_QUEUE = 'image_queue';

    /**
     * Получение метаданных
     */
    public const IMAGE_METADATA = 'image_metadata';

    /**
     * Конвертируем в webp
     */
    public const IMAGE_WEBP = 'image_webp';

    /**
     * Оптимизация изображений
     */
    public const IMAGE_OPTIMIZE = 'image_optimize';

    /**
     * Пробуем обработать изображения еще раз
     */
    public const IMAGE_REPROCESSING = 'image_reprocessing';

    /**
     * Генерация миниатюр
     */
    public const IMAGE_PROCESSING = 'image_processing';

    /**
     * Удаление изображений и миниатюр
     */
    public const IMAGE_DELETING = 'image_deleting';

    /**
     * Получаем палитру из изображения
     */
    public const IMAGE_PALETTE = 'image_palette';

    /**
     * Обрабока плохих изображений
     */
    public const IMAGE_FAILED = 'image_failed';

    /**
     * Добавляет генерацию миниатюр
     */
    public const VIEW_PROCESSING = 'view_processing';

    /**
     * Удаляем миниатюры
     */
    public const VIEW_DELETING = 'view_deleting';
}
