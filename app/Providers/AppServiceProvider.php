<?php

namespace App\Providers;

use App\Http\Repositories\ActivityRepository;
use App\Http\Services\ActivityRepositoryService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        App::bind(ActivityRepositoryService::class, ActivityRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
