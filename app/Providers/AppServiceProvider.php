<?php

namespace App\Providers;

use App\Models\Image;
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
        \app('rinvex.attributes.entities')->push(Image::class);
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
