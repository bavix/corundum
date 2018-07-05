<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\View
 *
 * @property int $id
 * @property int $user_id
 * @property int $bucket_id
 * @property string $name
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
 */
class View extends Model
{

    /**
     * @return BelongsTo
     */
    public function bucket(): BelongsTo
    {
        return $this->belongsTo(Bucket::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
