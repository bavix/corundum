<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Color
 *
 * @property int $id
 * @property int $dec
 * @property int $count
 * @property int $image_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read string $hexadecimal
 * @property-read \App\Models\Image $image
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Color whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Color whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Color whereDecimal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Color whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Color whereImageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Color whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $dominant
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Color whereDominant($value)
 */
class Color extends Model
{

    /**
     * @var array
     */
    protected $fillable = ['dec'];

    /**
     * @var array
     */
    protected $appends = ['hex'];

    /**
     * @return string
     */
    public function getHexAttribute(): string
    {
        return \League\ColorExtractor\Color::fromIntToHex($this->dec);
    }

    /**
     * @return BelongsTo
     */
    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class);
    }

}
