<?php

namespace App\Enums\Image;

use App\Enums\Enum;

class ImageStatusEnum extends Enum
{
    /**
     * Загружено (init)
     *
     *  Получает метаданные и ставит в очередь на генерацию миниатюрок
     *
     * @var string
     */
    public const UPLOADED = 'uploaded';

    /**
     * Поставлено в очередь (генерация миниатюрок)
     *
     * @var string
     */
    public const PROCESSING = 'processing';

    /**
     * получены метаданные + сгенерированы изображения
     *
     * - При обновлении конфигураций,
     *  все изображения должны переходить в статус PROCESSING
     *
     * @var string
     */
    public const FINISHED = 'finished';

    /**
     * изображение удалено
     *
     * @var string
     */
    public const DELETED = 'deleted';

    /**
     * Проблемное изображение
     *
     * @var string
     */
    public const FAILED = 'failed';
}
