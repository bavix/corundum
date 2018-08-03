<?php

namespace App\Http\Controllers;

use App\Corundum\Kit\ImagePath;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{

    public function dashboard()
    {
        return view('dashboard', [
            'user' => Auth::user(),
        ]);
        $image = new Image();
        $image->user_id = Auth::id();
        var_dump(ImagePath::relative($image, 'lg'), $image->toArray());
        die;
    }

}
