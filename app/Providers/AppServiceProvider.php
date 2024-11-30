<?php

namespace App\Providers;

use App\Repositories\ArticlesRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        App::bind(ArticlesRepository::class, function (Application $app) {
            return new ArticlesRepository();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
