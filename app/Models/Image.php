<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Bavix\SDK\PathBuilder;
use Ramsey\Uuid\Uuid;

class Image extends Model
{

    public const TYPE_ORIGINAL = 'original';

    /**
     * @var bool
     */
    protected $checkExists = false;

    /**
     * @param string $bucket
     * @param string $ext
     *
     * @return string
     */
    public static function generateName(string $bucket, string $ext): string
    {
        do {
            $name = Uuid::uuid4()->toString() . '.' . $ext;
        } while (static::findByName($bucket, $name));

        return $name;
    }

    /**
     * @param int $bucketId
     * @param string $name
     *
     * @return Model|null|static
     */
    public static function findByName(int $bucketId, string $name)
    {
        return static::query()
            ->where('bucket_id', $bucketId)
            ->where('name', $name)
            ->first();
    }

    /**
     * @param string $bucket
     * @param string $name
     * @param string $type
     *
     * @return string
     */
    public static function realPath(string $bucket, string $name, $type = self::TYPE_ORIGINAL): string
    {
        $storage = Storage::disk(config('corundum.disk'));
        $hash = PathBuilder::sharedInstance()->hash($name);
        $paths = [$bucket, $type, $hash, $name];
        return $storage->path(\implode('/', $paths));
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
     * @return HasMany
     */
    public function thumbnails(): HasMany
    {
        return $this->hasMany(Config::class, 'user_id', 'user_id');
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

}
