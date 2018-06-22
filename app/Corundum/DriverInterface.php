<?php

namespace App\Corundum;

use Intervention\Image\Image;

interface DriverInterface
{

    /**
     * DriverInterface constructor.
     *
     * @param Corundum $corundum
     * @param string $path
     */
    public function __construct(Corundum $corundum, string $path);

    /**
     * @param array $data
     *
     * @return Image
     */
    public function apply(array $data): Image;

}
