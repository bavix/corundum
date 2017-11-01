<?php

namespace App\Models;

use Bavix\Helpers\Str;
use Bavix\SDK\PathBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{

    public $timestamps = false;

    /**
     * @param string $user
     * @param string $name
     *
     * @return Model|null|static
     */
    public static function findByName(string $user, string $name)
    {
        return static::query()
            ->where('user', $user)
            ->where('name', $name)
            ->first();
    }

    /**
     * @param string $user
     * @param string $ext
     *
     * @return string
     */
    public static function generateName(string $user, string $ext): string
    {
        do
        {
            $name = Str::random(6) . '.' . $ext;
        }
        while (static::findByName($user, $name));

        return $name;
    }

    /**
     * @param string $user
     * @param string $name
     * @param string $type
     *
     * @return string
     */
    public static function realPath(string $user, string $name, $type = 'original'): string
    {
        $hash = PathBuilder::sharedInstance()
            ->hash($name);

        $path = $user . '/' . $hash . '/' . $name;

        return Storage::disk('public')
            ->path('image/' . $type . '/' . $path);
    }

    public function thumbnails()
    {
        // return array
    }

    public function regenerate()
    {
        // todo

        return $this;
    }

}
