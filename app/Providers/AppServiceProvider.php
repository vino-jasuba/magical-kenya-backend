<?php

namespace App\Providers;

use App\Http\Repositories\ActivityRepository;
use App\Http\Repositories\LocationRepository;
use App\Http\Repositories\TouristExperienceRepository;
use App\Http\Contracts\ActivityRepositoryContract;
use App\Http\Contracts\InteractsWithMediaContract;
use App\Http\Contracts\LocationRepositoryContract;
use App\Http\Contracts\SearchServiceInterface;
use App\Http\Contracts\TouristExperienceRepositoryContract;
use App\Http\Repositories\EloquentSearchRepository;
use App\Http\Repositories\MediaRepository;
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
        App::bind(ActivityRepositoryContract::class, ActivityRepository::class);
        App::bind(LocationRepositoryContract::class, LocationRepository::class);
        App::bind(TouristExperienceRepositoryContract::class, TouristExperienceRepository::class);
        App::bind(InteractsWithMediaContract::class, MediaRepository::class);
        App::bind(SearchServiceInterface::class, EloquentSearchRepository::class);
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
