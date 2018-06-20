<?php

namespace App\Providers;

use App\Models\Config;
use App\Models\Image;
use App\Observes\ConfigObserver;
use App\Observes\ImageObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
//        Image::observe(ImageObserver::class);
//        Config::observe(ConfigObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

}
