<?php

namespace App\Console\Commands;

use App\Console\Services\ImageService;
use Bavix\Commands\WorkerCommand;
use Bavix\Helpers\Closure;

class ServiceCommand extends WorkerCommand
{

    const PROP_HANDLE = 'handle';

    /**
     * @var string
     */
    protected $name = 'bx:service';

    /**
     * ServiceCommand constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->map = [
            self::PROP_HANDLE => Closure::fromCallable([
                new ImageService($this), 'handle'
            ])
        ];
    }

}
