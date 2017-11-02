<?php

namespace App\Models;

use App\Console\Commands\ServiceCommand;
use Bavix\Extra\Gearman;
use Bavix\Helpers\Str;
use Bavix\SDK\PathBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{

    public $timestamps = false;

    /**
     * @var bool
     */
    protected $checkExists = false;

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

    /**
     * @param string $name
     *
     * @return Model|Config|null
     */
    public function thumbnail(string $name)
    {
        return Config::query()
            ->where('name', $name)
            ->where('user_id', $this->user_id)
            ->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|Config[]
     */
    public function thumbnails()
    {
        return Config::query()
            ->where('user_id', $this->user_id)
            ->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return bool
     */
    public function getCheckExists(): bool
    {
        return $this->checkExists;
    }

    /**
     * @param bool $checkExists
     *
     * @return $this
     */
    public function doRegenerate($checkExists = false): self
    {
        $this->checkExists = $checkExists;
        return $this->doBackground();
    }

    /**
     * @return $this
     */
    public function doBackground(): self
    {
        Gearman::client()
            ->doBackground(
                ServiceCommand::PROP_SERVICE,
                \serialize($this)
            );

        return $this;
    }

    /**
     * @return $this
     */
    public function doDeleted(): self
    {
        Gearman::client()
            ->doBackground(
                ServiceCommand::PROP_DELETED,
                \serialize($this)
            );

        return $this;
    }

}
