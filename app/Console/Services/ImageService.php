<?php

namespace App\Console\Services;

use App\Console\Commands\ServiceCommand;
use App\Models\Image;
use App\Models\User;
use Bavix\Exceptions\Invalid;
use Bavix\Helpers\Arr;
use Bavix\Helpers\Corundum\Corundum;
use Bavix\Helpers\Corundum\Runner;
use Bavix\Helpers\JSON;
use Bavix\Slice\Slice;
use Intervention\Image\ImageManager;

class ImageService
{

    /**
     * @var Runner[]
     */
    protected $runners;

    /**
     * @var ServiceCommand
     */
    protected $command;

    /**
     * @var array
     */
    protected $configs = [];

    /**
     * ImageService constructor.
     *
     * @param ServiceCommand $command
     */
    public function __construct(ServiceCommand $command)
    {
        $this->slice   = new Slice(config('gearman.services.image'));
        $this->command = $command;
    }

    /**
     * @param string $user
     *
     * @return Runner
     */
    protected function runner(string $user): Runner
    {
        if (!isset($this->runners[$user]))
        {
            $corundum = new Corundum($this->slice->make(Arr::merge(
                $this->slice->asArray(),
                [
                    'user' => $user
                ]
            )));

            $this->runners[$user] = new Runner($corundum);
        }

        return $this->runners[$user];
    }

    /**
     * @param int $userId
     *
     * @return array
     */
    protected function config($userId): array
    {
        if (\config('reload.corundum'))
        {
            \config([
                'reload.corundum' => false
            ]);

            $this->configs = [];
        }

        if (!isset($this->configs[$userId]))
        {
            $this->configs[$userId] = [];

            $configs = User::with('configs')
                ->find($userId)
                ->configs
                ->toArray();

            foreach ($configs as $config)
            {
                $this->configs[$userId][$config['name']] = $config;
            }
        }

        return $this->configs[$userId];
    }

    /**
     * @param \GearmanJob $job
     *
     * @throws Invalid
     */
    public function handle(\GearmanJob $job)
    {
        /**
         * @var Image $model
         */
        $model = \unserialize($job->workload(), []);
        $this->command->info(
            'The user `' . $model->user . '` has started regeneration of the image: ' .
            $model->name);

        // update config
        \config([
            'corundum' => $this->config($model->user_id)
        ]);

        $this->runner($model->user)->apply(

            // image->name
            $model->name,

            // command logger
            $this->command,

            // to include check on existence of the file
            $model->getCheckExists()
        );

        // set information
        $image = (new ImageManager(['driver' => 'imagick']))->make(
            Image::realPath($model->user, $model->name)
        );

        $model->status = 1; // status 1 -- gearman is complete
        $model->width  = $image->getWidth();
        $model->height = $image->getHeight();
        $model->size   = $image->filesize();
        $model->save();
    }

}
