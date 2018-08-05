<?php

namespace App\Http\Controllers;

use App\Corundum\Kit\Path;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;
use League\ColorExtractor\Color;
use League\ColorExtractor\ColorExtractor;
use League\ColorExtractor\Palette;

class TestController extends Controller
{

    public function dashboard()
    {
        return view('dashboard', [
            'user' => Auth::user(),
        ]);
        $image = new Image();
        $image->user_id = Auth::id();
        var_dump(Path::relative($image, 'lg'), $image->toArray());
        die;
    }

}
