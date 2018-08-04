<?php

namespace App\Corundum\Kit;

use App\Enums\Image\ImageFormatsEnum;
use App\Enums\Image\ImageStatusEnum;
use App\Models\Bucket;
use App\Models\Fileable;
use App\Models\Image;
use App\Models\File;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\Types\Null_;

class Path
{

    /**
     * @var array
     */
    protected static $types = [
        Image::class => 'image',
        File::class => 'file',
    ];

    /**
     * @var int
     */
    protected const SPLIT_LENGTH = 2;

    /**
     * @param Fileable $model
     * @param null|string $view
     *
     * @return string
     * @throws
     */
    public static function makeDirectory(Fileable $model, ?string $view = null): string
    {
        $path = static::relative($model, $view);
        $directory = \dirname($path);

        return static::disk($model)
            ->makeDirectory($directory);
    }

    /**
     * @param Fileable $model
     * @param null|string $view
     *
     * @return string
     * @throws
     */
    public static function exists(Fileable $model, ?string $view = null): string
    {
        return static::disk($model)
            ->exists(static::relative($model, $view));
    }

    /**
     * @param Fileable $model
     * @param null|string $view
     */
    public static function remove(Fileable $model, ?string $view = null): void
    {
        $disk = static::disk($model);

        $relative = self::relative($model, $view);
        $disk->delete($relative);

        foreach (ImageFormatsEnum::enums() as $enum) {
            echo $relative . '.' . $enum . PHP_EOL;
            $disk->delete($relative . '.' . $enum);
        }

        $directory = self::directory($model, $view);

        do {
            $list = $disk->listContents($directory);

            if (!empty($list)) {
                break;
            }

            $disk->deleteDirectory($directory);
            $directory = \dirname($directory);
        }
        while (true);
    }

    /**
     * @param Fileable $model
     * @param null|string $view
     *
     * @return string
     * @throws
     */
    public static function physical(Fileable $model, ?string $view = null): string
    {
        return static::disk($model)
            ->path(static::relative($model, $view));
    }

    /**
     * @param Fileable $model
     * @param null|string $view
     *
     * @return string
     */
    public static function relative(Fileable $model, ?string $view = null): string
    {
        /**
         * @var Image|File $model
         */
        [$xx, $yy] = static::split($model->name);

        return \implode(
            '/',
            [static::viewPath($model->bucket, $view), $xx, $yy, $model->name]
        );
    }

    /**
     * @param Fileable $model
     * @param null|string $view
     * @return string
     */
    protected static function directory(Fileable $model, ?string $view = null): string
    {
        return \dirname(static::relative($model, $view));
    }

    /**
     * @param string $uuid
     *
     * @return array
     */
    protected static function split(string $uuid): array
    {
        return \str_split(
            \preg_replace('~\W~', '', $uuid),
            static::SPLIT_LENGTH
        );
    }

    /**
     * @param Bucket $bucket
     * @param null|string $view
     *
     * @return string
     */
    protected static function viewPath(Bucket $bucket, ?string $view = null): string
    {
        if ($view === null) {
            return 'sources/' . $bucket->name;
        }

        return 'views/' . $bucket->name . '/' . $view;
    }

    /**
     * @param Fileable $model
     *
     * @return FilesystemAdapter
     */
    protected static function disk(Fileable $model): FilesystemAdapter
    {
        $type = static::$types[\get_class($model)] ?? null;

        if (!$type) {
            throw new \RuntimeException('Type not found');
        }

        return Storage::disk(config('corundum.disk.' . $type));
    }

}
