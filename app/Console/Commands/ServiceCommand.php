<?php

namespace App\Console\Commands;

use App\Console\Services\ImageService;
use App\Models\Config;
use App\Models\Image;
use App\Models\User;
use Bavix\Commands\WorkerCommand;
use Bavix\Extra\Gearman;
use Bavix\Helpers\Closure;
use Bavix\Helpers\File;

class ServiceCommand extends WorkerCommand
{

    const PROP_SERVICE = 'handle';
    const PROP_CREATED = 'created';
    const PROP_UPDATED = 'updated';
    const PROP_DELETED = 'deleted';

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

        $this->loadQueue();

        $this->map = [
            self::PROP_SERVICE => Closure::fromCallable([
                new ImageService($this), 'handle'
            ]),

            self::PROP_CREATED => Closure::fromCallable([
                $this, 'created'
            ]),

            self::PROP_UPDATED => Closure::fromCallable([
                $this, 'updated'
            ]),

            self::PROP_DELETED => Closure::fromCallable([
                $this, 'deleted'
            ])
        ];
    }

    public function created(\GearmanJob $job)
    {
        $model = \unserialize($job->workload(), []);

        if ($model instanceof Config)
        {
            Gearman::reload(['reload']);

            $this->chunk($model, function ($images) {

                /**
                 * @var Image $image
                 */
                foreach ($images as $image)
                {
                    $image->doRegenerate(true);
                }
            });
        }
    }

    public function updated(\GearmanJob $job)
    {
        $model = \unserialize($job->workload(), []);

        if ($model instanceof Config)
        {
            Gearman::reload(['reload']);

            $this->chunk($model, function ($images) {

                /**
                 * @var Image $image
                 */
                foreach ($images as $image)
                {
                    $image->doRegenerate();
                }
            });
        }
    }

    public function deleted(\GearmanJob $job)
    {
        $model = \unserialize($job->workload(), []);

        if ($model instanceof Config)
        {
            $this->configDeleted($model);
        }

        if ($model instanceof Image)
        {
            $this->imageDeleted($model);
        }
    }

    /**
     * @param Config $config
     */
    protected function configDeleted(Config $config)
    {
        $self = $this;

        $this->chunk($config, function ($images) use ($self, $config) {

            $self->warn('There is a removal of all a configuration `' . $config->name . '` thumbnail');

            /**
             * @var Image $image
             */
            foreach ($images as $image)
            {
                $path = Image::realPath(
                    $image->user,
                    $image->name,
                    $config->name
                );

                if (File::exists($path))
                {
                    $self->error('The thumbnail `' . $config->name .
                        '` of the image `' . $image->name . '` of the user `' . $image->user
                        . '` is removed');

                    File::remove($path);
                }
            }

        });

    }

    /**
     * @param Image $image
     */
    protected function imageDeleted(Image $image)
    {
        $this->warn('There is a removal of the image `' .
            $image->name . '` of the user `' . $image->user . '`');

        /**
         * @var Config $thumbnail
         */
        foreach ($image->thumbnails() as $thumbnail)
        {
            $path = Image::realPath(
                $image->user,
                $image->name,
                $thumbnail->name
            );

            if (File::isFile($path))
            {
                $this->error('The thumbnail `' . $thumbnail->name . '` is removed');

                File::remove($path);
            }
        }

        $path = Image::realPath($image->name, $image->user);

        if (File::isFile($path))
        {
            $this->error('The original image is removed');

            File::remove($path);
        }
    }

    /**
     * @param Config   $config
     * @param callable $callback
     */
    protected function chunk(Config $config, callable $callback)
    {
        /**
         * @var User $user
         */
        $user = $config->user;

        $user->images()->chunk(1000, $callback);
    }

    /**
     * loads all not processed images into turn
     */
    protected function loadQueue()
    {
        $query = Image::query()->where('status', 0);
        $query->chunk(1000, function ($images) {
            /**
             * @var Image[] $images
             */
            foreach ($images as $image)
            {
                $image->doBackground();
            }
        });
    }

}
