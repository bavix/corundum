<?php

namespace App\Corundum\Adapters;

use App\Corundum\Corundum;
use App\Corundum\DriverInterface;
use Bavix\Slice\Slice;
use Intervention\Image\Image;

abstract class Adapter implements DriverInterface
{

    /**
     * @var Corundum
     */
    protected $corundum;

    /**
     * @var Image
     */
    protected $image;

    /**
     * @var string
     */
    protected $path;

    /**
     * Adapter constructor.
     *
     * @param Corundum $corundum
     * @param string $path
     */
    public function __construct(Corundum $corundum, string $path)
    {
        $this->corundum = $corundum;
        $this->path = $path;
    }

    /**
     * @param Image $image
     * @param Slice $config
     * @param bool $minimal
     *
     * @return Slice
     */
    protected function received(Image $image, Slice $config, $minimal = true): Slice
    {
        $width = (int)$config->getRequired('width');
        $height = (int)$config->getRequired('height');

        $shiftWidth = 0;
        $shiftHeight = 0;

        $_width = $width;
        $_height = $height;

        if ($image->height() < $image->width()) {
            $_height = $image->height() * $width / $image->width();
            $shiftHeight = ($_height - $height) / 2;
        } else {
            $_width = $image->width() * $height / $image->height();
            $shiftWidth = ($_width - $width) / 2;
        }

        if ($minimal ^ $_width > $width) {
            $_height = $_height * $width / $_width;
            $_width = $width;
        }

        if ($minimal ^ $_height > $height) {
            $_width = $_width * $height / $_height;
            $_height = $height;
        }

        return new Slice([
            'config' => [
                'width' => $width,
                'height' => $height,
            ],
            'received' => [
                'width' => (int)$_width,
                'height' => (int)$_height,
            ],
            'shifted' => [
                'width' => (int)$shiftWidth,
                'height' => (int)$shiftHeight,
            ]
        ]);
    }

    /**
     * @param Image $image
     * @param Slice $slice
     * @param string $color
     *
     * @return Image
     */
    protected function handler(Image $image, Slice $slice, string $color = null): Image
    {
        $color = $color ?: 'rgba(0, 0, 0, 0)';

        $image->resize(
            $slice->getRequired('received.width'),
            $slice->getRequired('received.height')
        );

        $image->resizeCanvas(
            $width = $slice->getRequired('config.width'),
            $height = $slice->getRequired('config.height'),
            'center',
            false,
            $color
        );

        $fill = $this->corundum
            ->imageManager()
            ->canvas($width, $height, $color);

        if ($this->corundum->driver() === 'gd') {
            $object = $fill;
            $fill = $image;
            $image = $object;
        }

        return $fill->fill(
            $image,
            $slice->getRequired('shifted.width'),
            $slice->getRequired('shifted.height')
        );
    }

    /**
     * @return Image
     */
    protected function image(): Image
    {
        if (!$this->image) {
            $this->image = $this->corundum->createImage($this->path);
        }

        return $this->image;
    }

}
