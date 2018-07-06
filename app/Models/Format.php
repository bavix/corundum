<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Format
 *
 * @property int $id
 * @property string $name
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $formatable
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Format whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Format whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Format whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Format whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Format extends Model
{

    /**
     * @var array 
     */
    protected $fillable = ['name'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function formatable(): MorphTo
    {
        return $this->morphTo();
    }

}
