<?php

namespace App\Corundum\Adapters;

use App\Corundum\Adapter;
use App\Corundum\Point;
use Illuminate\Support\Arr;
use Intervention\Image\Facades\Image as ImageManager;
use Intervention\Image\Image;

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

        $width = Arr::get($data, 'width');
        $height = Arr::get($data, 'height');

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

        $color = Arr::get($data, 'color');
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
