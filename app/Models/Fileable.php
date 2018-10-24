<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Enums\Image\ImageStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Rinvex\Attributes\Traits\Attributable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

abstract class Fileable extends Model
{

    use Attributable;

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
        if ($this->status === null) {
            $this->status = ImageStatusEnum::INITIALIZED;
        }
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

}
