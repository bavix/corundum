<?php

namespace App\Http\Controllers;

use Bavix\App\Http\Controllers\Controller;
use Illuminate\Http\Response;

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
     * @return \Illuminate\Http\Response
     */
    public function index(): Response
    {
        return view('home');
    }

}
