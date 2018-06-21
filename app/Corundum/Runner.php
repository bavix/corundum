<?php

namespace App\Corundum;

use Bavix\Exceptions\Invalid;
use Bavix\Helpers\Dir;
use Bavix\Helpers\File;
use Bavix\Slice\Slice;
use Illuminate\Console\Command;

class Runner
{

    /**
     * @var Corundum
     */
    protected $corundum;

    /**
     * Runner constructor.
     * @param Corundum $corundum
     */
    public function __construct(Corundum $corundum)
    {
        $this->corundum = $corundum;
    }

    /**
     * @param string $name
     * @param Command $command
     * @param bool $checkExists
     *
     * @throws Invalid
     */
    public function apply(string $name, $checkExists = false)
    {
        foreach ($this->config() as $key => $config) {
            $slice = new Slice($config);
            $type = $this->type($slice);
            $thumb = $this->thumbnail(
                $this->corundum->imagePath($name),
                $key
            );

            $updated = File::isFile($thumb);

            if ($checkExists && $updated) {
                continue;
            }

            $this->adapter($type, $name)
                ->apply($slice)
                ->save(
                    $thumb,
                    $slice->getData('quality')
                );

            if ($command) {
                if ($updated) {
                    $command->warn('Thumbnail `' . $key . '` of the file `' . $name . '` is updated!');
                } else {
                    $command->info('Thumbnail `' . $key . '` of the file `' . $name . '` is created!');
                }
            }
        }
    }

    /**
     * @return array
     */
    public function config(): array
    {
        return \config('corundum');
    }

    /**
     * @param Slice $slice
     *
     * @return string
     */
    protected function type(Slice $slice): string
    {
        return $slice->getRequired('type');
    }

    /**
     * @param string $path
     * @param string $thumbnail
     *
     * @return string
     */
    public function thumbnail(string $path, string $thumbnail): string
    {
        // original  = /<user>/original/xx/yy/xxyyzzzz.<format>
        $fullPath = preg_replace(
            '~/' . $this->corundum->type() . '/~',
            '/thumbs/' . $thumbnail . '/',
            $path
        );

        Dir::make(\dirname($fullPath));

        return $fullPath;
    }

    /**
     * @param string $type
     * @param string $path
     *
     * @return DriverInterface
     *
     * @throws Invalid
     */
    protected function adapter(string $type, string $path): DriverInterface
    {
        if (!$this->corundum->exists($type)) {
            throw new Invalid('Unknown type `' . $type . '`');
        }

        return $this->corundum->{$type}($path);
    }

}
