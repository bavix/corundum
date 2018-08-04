<?php

namespace App\Observes;

use App\Corundum\Kit\Path;
use App\Enums\Image\ImageStatusEnum;
use App\Jobs\ImageDeleting;
use App\Jobs\ImageQueue;
use App\Models\Image;

class ImageObserver
{

    /**
     * @param Image $image
     */
    public function created(Image $image): void
    {
        /**
         * Если изображение уже существует, тогда меняем статус на "uploaded"
         */
        if ($image->status === ImageStatusEnum::INITIALIZED && Path::exists($image)) {
            $image->status = ImageStatusEnum::UPLOADED;
            $image->save();
        }
    }

    /**
     * @param Image $image
     */
    public function updated(Image $image): void
    {
        if ($image->status === ImageStatusEnum::UPLOADED) {
            dispatch(new ImageQueue($image));
        }
    }

    /**
     * @param Image $image
     *
     * @return bool
     */
    public function deleting(Image $image): bool
    {
        dispatch(new ImageDeleting($image));

        return false;
    }

}
