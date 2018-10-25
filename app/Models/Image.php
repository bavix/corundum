<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Image
 *
 * @property int $id
 * @property string $name
 * @property int $bucket_id
 * @property int $user_id
 * @property string $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\Bucket $bucket
 * @property mixed $entity
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\View[] $views
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image hasAttribute($key, $value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereBucketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereUserId($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Color[] $palette
 */
class Image extends Fileable
{

    /**
     * @return HasMany
     */
    public function views(): HasMany
    {
        return $this
            ->hasMany(View::class, 'bucket_id', 'bucket_id')
            ->where('user_id', $this->user_id);
    }

    /**
     * @return BelongsToMany
     */
    public function colors(): BelongsToMany
    {
        return $this->belongsToMany(Color::class);
    }

    /**
     * @return BelongsToMany
     */
    public function palette(): BelongsToMany
    {
        return $this->colors()
            ->wherePivot('dominant', 1);
    }

}
