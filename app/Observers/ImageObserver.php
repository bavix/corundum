<?php

namespace App\Observes;

use App\Corundum\Kit\FilePath;
use App\Enums\Image\ImageStatusEnum;
use App\Jobs\ImageProcessing;
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
        if ($image->status === ImageStatusEnum::INITIALIZED && FilePath::exists($image)) {
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
            dispatch(new ImageProcessing($image, $image->bucket));
        }
    }

    /**
     * @param Image $image
     */
    public function deleting(Image $image): void
    {
        $image->status = ImageStatusEnum::DELETING;
        // todo добавить удаление миниатюр
    }

}
