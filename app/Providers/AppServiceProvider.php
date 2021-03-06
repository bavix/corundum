<?php

namespace App\Providers;

use App\Models\Image;
use App\Models\View;
use App\Observes\ImageObserver;
use App\Observes\ViewObserver;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Rinvex\Attributes\Models\Attribute;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        try {
            \app('rinvex.attributes.entities')->push(Image::class);

            Attribute::typeMap([
                'boolean' => \Rinvex\Attributes\Models\Type\Boolean::class,
                'datetime' => \Rinvex\Attributes\Models\Type\Datetime::class,
                'integer' => \Rinvex\Attributes\Models\Type\Integer::class,
                'text' => \Rinvex\Attributes\Models\Type\Text::class,
                'varchar' => \Rinvex\Attributes\Models\Type\Varchar::class,
            ]);

            Image::observe(ImageObserver::class);
            View::observe(ViewObserver::class);
        } catch (\Throwable $throwable) {

        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

}
