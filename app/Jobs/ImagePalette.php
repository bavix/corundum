<?php

namespace App\Jobs;

use App\Corundum\Kit\Path;
use App\Enums\Queue\QueueEnum;
use App\Models\Color;
use App\Models\Image;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use League\ColorExtractor\ColorExtractor;
use League\ColorExtractor\Palette;

class ImagePalette implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Image
     */
    protected $image;

    /**
     * ImageProcessing constructor.
     *
     * @param Image $image
     */
    public function __construct(Image $image)
    {
        $this->queue = QueueEnum::IMAGE_PALETTE;
        $this->image = $image;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        if ($this->image->palette()->count()) {
            return;
        }

        $palette = $this->palette();
        $colors = [];

        $extractor = new ColorExtractor($palette);
        $representative = $extractor->extract(100);
        $mostUsedColors = $palette->getMostUsedColors(10000);

        foreach ($mostUsedColors as $decimal => $count) {
            $colors[] = [
                'decimal' => $decimal,
                'count' => $count,
                'image_id' => $this->image->id,
                'dominant' => \in_array($decimal, $representative, true),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Color::insert($colors);
    }

    /**
     * @return Palette
     */
    protected function palette(): Palette
    {
        $physical = Path::physical($this->image);

        /**
         * @var $palette Palette
         */
        return Palette::fromFilename($physical);
    }

}
