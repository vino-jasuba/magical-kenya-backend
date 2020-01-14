<?php

namespace App\Providers;

use App\Http\Repositories\ActivityRepository;
use App\Http\Repositories\LocationRepository;
use App\Http\Repositories\TouristExperienceRepository;
use App\Http\Services\ActivityRepositoryService;
use App\Http\Services\LocationRepositoryInterface;
use App\Http\Services\TouristExperienceRepositoryInterface;
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
        App::bind(LocationRepositoryInterface::class, LocationRepository::class);
        App::bind(TouristExperienceRepositoryInterface::class, TouristExperienceRepository::class);
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
