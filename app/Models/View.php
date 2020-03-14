<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\View
 *
 * @property int $id
 * @property int $user_id
 * @property int $bucket_id
 * @property string $name
 * @property string $format
 * @property string $type
 * @property int|null $width
 * @property int|null $height
 * @property string|null $color
 * @property int|null $quality
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\Bucket $bucket
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\View whereBucketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\View whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\View whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\View whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\View whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\View whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\View whereQuality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\View whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\View whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\View whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\View whereWidth($value)
 * @mixin \Eloquent
 * @property int $optimize
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\View whereOptimize($value)
 * @property int $webp
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\View whereWebp($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Image[] $images
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\View newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\View newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\View query()
 */
class View extends Model
{

    /**
     * @param int|null $quality
     *
     * @return int
     */
    public function getQualityAttribute(?int $quality): int
    {
        return $quality ?: 100;
    }

    /**
     * @return BelongsTo
     */
    public function bucket(): BelongsTo
    {
        return $this->belongsTo(Bucket::class);
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasMany
     */
    public function images(): HasMany
    {
        return $this->hasMany(Image::class, 'bucket_id', 'bucket_id');
    }

}
