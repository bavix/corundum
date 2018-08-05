<?php

namespace App\Models;

/**
 * App\Models\File
 *
 * @property-read \App\Models\Bucket $bucket
 * @property mixed $entity
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Fileable hasAttribute($key, $value)
 * @mixin \Eloquent
 */
class File extends Fileable
{
}
