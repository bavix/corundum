<?php

namespace App\Corundum\Kit;

use App\Models\Bucket;
use App\Models\Image;
use App\Models\View;
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
     * @param Bucket|string $bucket
     * @param null|View|string $view
     *
     * @return string
     * @throws
     */
    public static function makeDirectory(Image $image, $bucket, $view = null): string
    {
        $path = static::relative($image, $bucket, $view);
        $directory = \dirname($path);

        return Storage::disk(config('corundum.disk.' . static::$type))
            ->makeDirectory($directory);
    }

    /**
     * @param Image $image
     * @param Bucket|string $bucket
     * @param null|View|string $view
     *
     * @return string
     * @throws
     */
    public static function exists(Image $image, $bucket, $view = null): string
    {
        return Storage::disk(config('corundum.disk.' . static::$type))
            ->exists(static::relative($image, $bucket, $view));
    }

    /**
     * @param Image $image
     * @param Bucket|string $bucket
     * @param null|View|string $view
     *
     * @return string
     */
    public static function relative(Image $image, $bucket, $view = null): string
    {
        return static::path($image, $bucket, $view);
    }

    /**
     * @param Image $image
     * @param Bucket|string $bucket
     * @param null|View|string $view
     *
     * @return string
     */
    protected static function path(Image $image, $bucket, $view = null): string
    {
        [$xx, $yy] = static::split($image->name);
        $bucketName = \is_object($bucket) ? $bucket->name : $bucket;
        $viewName = \is_object($view) ? $view->name : $view;

        return \implode(
            '/',
            [static::viewPath($bucketName, $viewName), $xx, $yy, $image->name]
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
     * @param Bucket|string $bucket
     * @param null|View|string $view
     *
     * @return string
     */
    protected static function viewPath($bucket, $view = null): string
    {
        if ($view === null) {
            return $bucket;
        }

        return 'views/' . $bucket . '/' . $view;
    }

    /**
     * @param Image $image
     * @param Bucket|string $bucket
     * @param null|View|string $view
     *
     * @return string
     * @throws
     */
    public static function physical(Image $image, $bucket, $view = null): string
    {
        return Storage::disk(config('corundum.disk.' . static::$type))
            ->path(static::relative($image, $bucket, $view));
    }

}
