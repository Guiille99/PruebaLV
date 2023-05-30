<?php

namespace App\Providers;

use App\Http\Controllers\LibroController;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades;
use Illuminate\View\View;

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
        Paginator::useBootstrapFive();
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        Facades\View::composer('layouts.plantilla', function(View $view){
            $generos = LibroController::getGeneros();
            $view->with(compact('generos'));
        });
    }
}
