<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Rinvex\Attributes\Traits\Attributable;

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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Format[] $formats
 */
class Image extends Model
{

    use Attributable;

    /**
     * @var array
     */
    protected $with = ['eav'];

    /**
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * Image constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        if (empty($attributes['name'])) {
            $attributes['name'] = Str::uuid()->toString();
        }

        parent::__construct($attributes);
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
    public function views(): HasMany
    {
        return $this->hasMany(View::class, 'bucket_id', 'bucket_id')
            ->where('user_id', $this->user_id);
    }

    /**
     * @return BelongsToMany
     */
    public function formats(): BelongsToMany
    {
        return $this->belongsToMany(Format::class);
    }

}
