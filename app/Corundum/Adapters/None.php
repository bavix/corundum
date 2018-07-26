<?php

namespace App\Corundum\Adapters;

use App\Corundum\Adapter;
use App\Corundum\Point;
use Intervention\Image\Image;
use Intervention\Image\ImageManagerStatic as ImageManager;

class None extends Adapter
{

    /**
     * @param array $data
     *
     * @return Image
     */
    public function apply(array $data): Image
    {
        $image = $this->image();

        $width = \array_get($data, 'width');
        $height = \array_get($data, 'height');

        $widthFit = $image->width() >= $image->height() ? $width : null;
        $heightFit = $image->width() <= $image->height() ? $height : null;

        if ($widthFit === null) {
            // vertical image
            $image->rotate(90)
                ->fit($heightFit, $widthFit)
                ->rotate(-90);
        } else {
            // horizontal image
            $image->fit($widthFit, $heightFit);
        }

        $color = \array_get($data, 'color');
        $fill = ImageManager::canvas($width, $height, $color);

        $image->resizeCanvas(
            $width,
            $height,
            'center',
            false,
            $color
        );

        $point = $this->point($fill, $image);
        $fill->fill($image, $point->getX(), $point->getY());

        return $fill;
    }

    /**
     * @param Image $fill
     * @param Image $image
     *
     * @return Point
     */
    protected function point(Image $fill, Image $image): Point
    {
        return new Point(
            ($fill->width() - $image->width()) / 2,
            ($fill->height() - $image->height()) / 2
        );
    }

}
