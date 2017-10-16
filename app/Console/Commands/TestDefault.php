<?php

namespace App\Console\Commands;

use Bavix\Commands\WorkerCommand;

class TestDefault extends WorkerCommand
{

    /**
     * @var string
     */
    protected $name = 'bx:test';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->worker->addFunction('echo', function () {
            var_dump(config('test'));
        });

        return parent::handle();
    }

}
