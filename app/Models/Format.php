<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Model;

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
