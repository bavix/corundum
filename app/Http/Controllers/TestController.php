<?php

namespace App\Http\Controllers;

use App\Corundum\Kit\Path;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{

    public function dashboard()
    {
        $image = new Image();
        $image->user_id = Auth::id();
        var_dump(Path::relative($image, 'lg'), $image->toArray());
        die;
    }

}
