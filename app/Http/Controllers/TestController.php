<?php

namespace App\Http\Controllers;

use App\Corundum\Kit\Path;
use App\Models\Image;

class TestController extends Controller
{

    public function dashboard()
    {
        $image = new Image();
        $image->user_id = 1;
        var_dump(Path::relative($image, 'lg'));
        die;
    }

}
