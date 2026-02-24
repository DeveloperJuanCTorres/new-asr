<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Taxonomy;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            $view->with('global_categories',
                Taxonomy::where('is_active', 1)->take(8)->get()
            );
        });
    }
}
