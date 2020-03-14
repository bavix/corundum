<?php

namespace App\Http\Controllers;

use App\Corundum\Kit\Path;
use App\Enums\Image\ImageFormatsEnum;
use App\Models\Bucket;
use App\Models\Image;

class StreamController extends Controller
{

    /**
     * @param string $bucket
     * @param string $view
     * @param string $uuid
     * @param string $type
     */
    public function image(string $bucket, string $view, string $uuid, string $type): void
    {
        $modelBucket = new Bucket();
        $modelBucket->name = $bucket;

        $image = new Image();
        $image->name = $uuid;
        $image->setRelation('bucket', $modelBucket);

        $path = Path::relative($image, $view);
        $filepath = $path . $this->ext($type);

        \header('Content-Type: ' . $this->contentType($type));
        \header("X-Accel-Redirect: /stream/$filepath");
        die;
    }

    /**
     * @param string $type
     * @return string
     */
    protected function ext(string $type): string
    {
        if ($type === ImageFormatsEnum::WEBP) {
            return ".$type";
        }

        return '';
    }

    /**
     * @param string $type
     * @return string
     */
    protected function contentType(string $type): string
    {
        switch ($type) {
            case ImageFormatsEnum::WEBP:
                return 'image/webp';
            case ImageFormatsEnum::PNG:
                return 'image/png';
            default:
                return 'image/jpeg';
        }
    }

}
