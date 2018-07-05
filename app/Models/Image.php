<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Ramsey\Uuid\Uuid;
use Rinvex\Attributes\Traits\Attributable;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{

    use Attributable;

    /**
     * @var array
     */
    protected $with = ['eav'];

    /**
     * Image constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        if (empty($attributes['name'])) {
            $attributes['name'] = Uuid::uuid4();
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

}
