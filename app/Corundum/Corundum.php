<?php

namespace App\Corundum;

use Bavix\Helpers\Arr;
use Bavix\SDK\PathBuilder;
use Bavix\Slice\Slice;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;

class Corundum
{

    /**
     * @var array
     */
    protected static $adapters = [
        'contain',
        'resize',
        'cover',
        'none',
        'fit',
    ];
    /**
     * @var string
     */
    protected $disk;
    /**
     * @var string
     */
    protected $driver;
    /**
     * @var string
     */
    protected $bucket;
    /**
     * @var string
     */
    protected $type;
    /**
     * @var ImageManager
     */
    protected $imageManager;

    /**
     * Corundum constructor.
     *
     * @param Slice $slice
     */
    public function __construct(Slice $slice)
    {
        $this->disk = $slice->getRequired('disk');
        $this->driver = $slice->getData('driver', 'imagick');
        $this->bucket = $slice->getData('bucket', 'default');
        $this->type = $slice->getData('type', 'original');
    }

    /**
     * @return string
     */
    public function driver(): string
    {
        return $this->driver;
    }

    /**
     * @param string $path
     *
     * @return Image
     */
    public function createImage(string $path): Image
    {
        return $this->imageManager()
            ->make($path);
    }

    /**
     * @return ImageManager
     */
    public function imageManager(): ImageManager
    {
        if (!$this->imageManager) {
            $this->imageManager = new ImageManager([
                'driver' => $this->driver
            ]);
        }

        return $this->imageManager;
    }

    /**
     * @param string $basename
     *
     * @return mixed
     */
    public function imagePath(string $basename): string
    {
        // fixme: remove method, use Image:realPath
        $path = 'image/' . PathBuilder::sharedInstance()
                ->generate($this->bucket(), $this->type(), $basename);

        return Storage::disk($this->disk)->path($path);
    }

    /**
     * @return string
     */
    public function bucket(): string
    {
        return $this->bucket;
    }

    /**
     * @return string
     */
    public function type(): string
    {
        return $this->type;
    }

    /**
     * @param string $path
     *
     * @return DriverInterface
     */
    public function contain(string $path): DriverInterface
    {
        return new Adapters\Contain($this, $this->imagePath($path));
    }

    /**
     * @param string $path
     *
     * @return DriverInterface
     */
    public function cover(string $path): DriverInterface
    {
        return new Adapters\Cover($this, $this->imagePath($path));
    }

    /**
     * @param string $path
     *
     * @return DriverInterface
     */
    public function fit(string $path): DriverInterface
    {
        return new Adapters\Fit($this, $this->imagePath($path));
    }

    /**
     * @param string $path
     *
     * @return DriverInterface
     */
    public function resize(string $path): DriverInterface
    {
        return new Adapters\Resize($this, $this->imagePath($path));
    }

    /**
     * @param string $path
     *
     * @return DriverInterface
     */
    public function none(string $path): DriverInterface
    {
        return new Adapters\None($this, $this->imagePath($path));
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function exists($name): bool
    {
        return Arr::in(static::$adapters, $name);
    }

}
