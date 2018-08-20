<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class DashboardController extends Controller
{

    public function index()
    {
        return view('dashboard', [
            'user' => Auth::user(),
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function routes(): JsonResponse
    {
        $routesByName = Route::getRoutes()->getRoutesByName();
        $routes = [];

        /**
         * @var \Illuminate\Routing\Route $route
         */
        foreach ($routesByName as $name => $route) {
            $routes[$name] = $route->uri();
        }

        return response()->json($routes);
    }

}
