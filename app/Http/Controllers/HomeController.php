<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Models\Image;
use Bavix\App\Http\Controllers\Controller;
use Bavix\Helpers\Str;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return mixed
     */
    public function index(Request $request)
    {

//        foreach (range(1, 5) as $item)
//        {
//            $config = new Config();
//
//            $config->name = Str::random(3);
//            $config->user_id = $request->user()->id;
//            $config->type = random_int(0, 1) ? 'cover' : 'fit';
//            $config->width = random_int(200, 900);
//            $config->height = random_int(200, 900);
//
//            $config->save();
//        }

//        $config = Config::all();
//
//        foreach ($config as $item)
//        {
//            $item->delete();
//        }

        $images = Image::all();

        foreach ($images as $item)
        {
            $item->delete();
        }

        return view('home');
    }

}
