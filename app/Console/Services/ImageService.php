<?php

namespace App\Console\Services;

use App\Console\Commands\ServiceCommand;
use App\Models\Image;
use Bavix\Exceptions\Invalid;
use Bavix\Helpers\Arr;
use Bavix\Helpers\Corundum\Corundum;
use Bavix\Helpers\Corundum\Runner;
use Bavix\Helpers\File;
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
        $config = config('corundum');
        $this->slice   = new Slice($config);
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

        if (!File::isFile(Image::realPath($model->user, $model->name)))
        {
            $this->command->error('The file `' . $model->name . '` of the user `' .
                $model->user . '` isn\'t found');

            return;
        }

        $this->runner($model->user)->apply(

            // image->name
            $model->name,

            // command logger
            $this->command,

            // to include check on existence of the file
            $model->getCheckExists()
        );

        $options = [
            'driver' => \config('gearman.services.image.driver')
        ];

        // set information
        $image = (new ImageManager($options))->make(
            Image::realPath($model->user, $model->name)
        );

        $model->status = 1; // status 1 -- gearman is complete
        $model->width  = $image->getWidth();
        $model->height = $image->getHeight();
        $model->size   = $image->filesize();
        $model->save();

        /**
         * @var array $configure
         */
        $configure = \config('corundum');

        foreach ($configure as $key => $props)
        {
            Gearman::client()
                ->doLowBackground(
                    ServiceCommand::PROP_OPTIMIZE,
                    Image::realPath($model->user, $model->name, $key)
                );
        }
    }

}
