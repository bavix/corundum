<?php

namespace App\Corundum\Kit;

use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class FilePath
{

    /**
     * @var string
     */
    protected static $type = 'file';

    /**
     * @var int
     */
    protected const SPLIT_LENGTH = 2;

    /**
     * @param Image $image
     * @param string $bucket
     * @param null|string $view
     *
     * @return string
     * @throws
     */
    public static function makeDirectory(Image $image, string $bucket, ?string $view = null): string
    {
        $path = static::relative($image, $bucket, $view);
        $directory = \dirname($path);

        return Storage::disk(config('corundum.disk.' . static::$type))
            ->makeDirectory($directory);
    }

    /**
     * @param Image $image
     * @param string $bucket
     * @param null|string $view
     *
     * @return string
     * @throws
     */
    public static function exists(Image $image, string $bucket, ?string $view = null): string
    {
        return Storage::disk(config('corundum.disk.' . static::$type))
            ->exists(static::relative($image, $bucket, $view));
    }

    /**
     * @param Image $image
     * @param string $bucket
     * @param null|string $view
     *
     * @return string
     */
    public static function relative(Image $image, string $bucket, ?string $view = null): string
    {
        return static::path($image, $bucket, $view);
    }

    /**
     * @param Image $image
     * @param string $bucket
     * @param null|string $view
     *
     * @return string
     */
    protected static function path(Image $image, string $bucket, ?string $view = null): string
    {
        [$xx, $yy] = static::split($image->name);

        return \implode(
            '/',
            [static::viewPath($bucket, $view), $xx, $yy, $image->name]
        );
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
     * @param string $bucket
     * @param null|string $view
     *
     * @return string
     */
    protected static function viewPath(string $bucket, ?string $view = null): string
    {
        if ($view === null) {
            return static::$type . '/' . $bucket;
        }

        return 'views/' . static::$type . '/' . $bucket . '/' . $view;
    }

    /**
     * @param Image $image
     * @param string $bucket
     * @param string $view
     *
     * @return string
     * @throws
     */
    public static function physical(Image $image, string $bucket, ?string $view = null): string
    {
        return Storage::disk(config('corundum.disk.' . static::$type))
            ->path(static::relative($image, $bucket, $view));
    }

}
