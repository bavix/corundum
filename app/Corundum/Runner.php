<?php

namespace App\Corundum;

use App\Models\Config;
use Bavix\Exceptions\Invalid;
use Bavix\Helpers\Dir;
use Bavix\Helpers\File;

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
     * @param array $configs
     * @param bool $checkExists
     *
     * @throws Invalid
     */
    public function apply(string $name, array $configs, $checkExists = false): void
    {
        /**
         * @var Config[] $configs
         */
        foreach ($configs as $key => $config) {
            $thumb = $this->thumbnail(
                $this->corundum->imagePath($name),
                $key
            );

            $updated = File::isFile($thumb);

            if ($checkExists && $updated) {
                continue;
            }

            $this->adapter($config->type, $name)
                ->apply($config->toArray())
                ->save(
                    $thumb,
                    $config->quality
                );
        }
    }

    /**
     * @param string $path
     * @param string $thumbnail
     *
     * @return string
     */
    public function thumbnail(string $path, string $thumbnail): string
    {
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
