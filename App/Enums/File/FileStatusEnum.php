<?php

namespace App\Enums\File;

use App\Enums\Enum;

class FileStatusEnum extends Enum
{
    /**
     * модель создана
     *
     * @var string
     */
    public const INITIALIZED = 'initialized';

    /**
     * Загружено
     *
     *  Получает метаданные и ставит в очередь на генерацию миниатюрок
     *
     * @var string
     */
    public const UPLOADED = 'uploaded';

    /**
     * получены метаданные
     *
     * @var string
     */
    public const FINISHED = 'finished';

    /**
     * Поставлено на удаление
     *
     * @var string
     */
    public const DELETING = 'deleting';

    /**
     * файл удален
     *
     * @var string
     */
    public const DELETED = 'deleted';

    /**
     * Проблема
     *
     * @var string
     */
    public const FAILED = 'failed';
}
