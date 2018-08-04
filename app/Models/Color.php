<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Color extends Model
{

    /**
     * @var array
     */
    protected $appends = ['hexadecimal'];

    /**
     * @return string
     */
    public function getHexadecimalAttribute(): string
    {
        return \League\ColorExtractor\Color::fromIntToHex($this->decimal);
    }

    /**
     * @return BelongsTo
     */
    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class);
    }

}
