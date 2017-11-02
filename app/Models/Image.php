<?php

namespace App\Models;

use App\Console\Commands\ServiceCommand;
use Bavix\Extra\Gearman;
use Bavix\Helpers\JSON;
use Bavix\Helpers\Str;
use Bavix\SDK\PathBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{

    public $timestamps = false;

    /**
     * @var bool
     */
    protected $regenerate = false;

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

        return Storage::disk(config('gearman.services.image.disk'))
            ->path('image/' . $user . '/' . $type . '/' . $hash . '/' . $name);
    }

    public function thumbnails()
    {
        // return array
    }

    /**
     * @return bool
     */
    public function getRegenerate(): bool
    {
        return $this->regenerate;
    }

    /**
     * @param bool $checkExists
     *
     * @return $this
     */
    public function doRegenerate($checkExists = false): self
    {
        $this->regenerate = !$checkExists;
        return $this->doBackground();
    }

    /**
     * @return $this
     */
    public function doBackground(): self
    {
        Gearman::client()
            ->doBackground(
                ServiceCommand::PROP_HANDLE,
                \serialize($this)
            );

        return $this;
    }

}
