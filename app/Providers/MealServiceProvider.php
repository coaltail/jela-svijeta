<?php

namespace App\Providers;

use App\Services\MealService;
use Illuminate\Support\ServiceProvider;

class MealServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->app->singleton(MealService::class, function ($app) {
            // Resolve the MealRepository dependency and pass it to the MealService constructor
            $mealRepository = $app->make(MealRepository::class);
            return new MealService($mealRepository);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        //
    }
}
