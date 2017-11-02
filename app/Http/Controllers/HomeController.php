<?php

namespace App\Http\Controllers;

use App\Models\Config;
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
//        $config = new Config();
//
//        $config->name = Str::random(3);
//        $config->user_id = $request->user()->id;
//        $config->type = 'contain';
//        $config->width = 600;
//        $config->height = 300;
//
//        $config->save();

//        $config = Config::query()->first();
//
//        if ($config)
//        {
//            $config->delete();
//        }

        return view('home');
    }

}
