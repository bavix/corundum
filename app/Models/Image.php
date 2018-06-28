<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Rinvex\Attributes\Traits\Attributable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;
use Bavix\SDK\PathBuilder;
use Ramsey\Uuid\Uuid;

class Image extends Model
{

    use Attributable;

    public const TYPE_ORIGINAL = 'original';

    // Eager loading all the registered attributes
    protected $with = ['eav'];

    /**
     * @param int $bucketId
     * @param string $ext
     *
     * @return string
     */
    public static function generateName(int $bucketId, string $ext): string
    {
        do {
            $name = Uuid::uuid4()->toString() . '.' . $ext;
        } while (static::findByName($bucketId, $name));

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

}
