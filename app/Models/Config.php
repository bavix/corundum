<?php

namespace App\Models;

use App\Console\Commands\ServiceCommand;
use Bavix\Extra\Gearman;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Config extends Model
{

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function doCreated()
    {
        Gearman::client()
            ->doBackground(
                ServiceCommand::PROP_CREATED,
                \serialize($this)
            );

        return $this;
    }

    public function doUpdated()
    {
        Gearman::client()
            ->doLowBackground(
                ServiceCommand::PROP_UPDATED,
                \serialize($this)
            );

        return $this;
    }

    public function doDeleted()
    {
        Gearman::client()
            ->doHighBackground(
                ServiceCommand::PROP_DELETED,
                \serialize($this)
            );

        return $this;
    }

}
