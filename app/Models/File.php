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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File query()
 */
class File extends Fileable
{
}
