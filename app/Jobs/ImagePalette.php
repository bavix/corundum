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
use Illuminate\Support\Facades\DB;
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
        if ($this->image->colors()->count()) {
            return;
        }

        // get colors
        $palette = $this->palette();
        $extractor = new ColorExtractor($palette);
        $representative = $extractor->extract(10);
        $mostUsedColors = $palette->getMostUsedColors(50);

        // find colors
        $colors = [];

        $query = Color::query()
            ->whereIn('dec', \array_keys($mostUsedColors));

        $query->each(function (Color $color) use (&$colors) {
            $colors[] = $color->dec;
        });

        // insert unique
        $diff = \array_diff(\array_keys($mostUsedColors), $colors);

        $inserts = [];
        foreach ($diff as $dec) {
            $inserts[] = [
                'dec' => $dec,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if (!empty($inserts)) {
            Color::insert($inserts);
        }

        // build $pivot
        $pivot = [];
        $query = Color::query()->whereIn('dec', \array_keys($mostUsedColors));
        $query->each(function (Color $color) use ($mostUsedColors, $representative, &$pivot) {
            $pivot[] = [
                'color_id' => $color->id,
                'image_id' => $this->image->id,
                'count' => $mostUsedColors[$color->dec],
                'dominant' => \in_array($color->dec, $representative, true),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        });

        DB::table('color_image')->insert($pivot);
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
