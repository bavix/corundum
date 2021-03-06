<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Bucket
 *
 * @property int $id
 * @property string $name
 * @property int $user_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bucket whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bucket whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bucket whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bucket whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bucket whereUserId($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bucket newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bucket newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bucket query()
 */
class Bucket extends Model
{
    protected $fillable = ['name'];
}
