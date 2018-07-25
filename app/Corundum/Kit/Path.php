<?php

namespace App\Corundum\Kit;

use App\Enums\Image\ImageTypesEnum;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class Path
{

    protected const SPLIT_LENGTH = 2;

    /**
     * @param Image $image
     * @param string $type
     *
     * @return string
     * @throws
     */
    public static function physical(Image $image, string $type = ImageTypesEnum::TYPE_ORIGINAL): string
    {
        return Storage::disk(config('corundum.disk'))
            ->path(static::relative($image, $type));
    }

    /**
     * @param Image $image
     * @param string $type
     *
     * @return string
     */
    public static function relative(Image $image, string $type = ImageTypesEnum::TYPE_ORIGINAL): string
    {
        return static::path($image, $type);
    }

    /**
     * @param Image  $image
     * @param string $type
     *
     * @return string
     */
    protected static function path(Image $image, string $type): string
    {
        [$xx, $yy] = static::split($image->name);

        return \implode(
            '/',
            [static::thumbnail($type), $xx, $yy, $image->name]
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
     * @param string $type
     *
     * @return string
     */
    protected static function thumbnail(string $type): string
    {
        if ($type === ImageTypesEnum::TYPE_ORIGINAL) {
            return $type;
        }

        return __FUNCTION__ . '/' . $type;
    }

}
