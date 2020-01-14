<?php

namespace App\Http\Repositories;

use App\Http\Services\TouristExperienceRepositoryInterface;
use App\MagicalKenya\Filters\ActivityFilter;
use App\MagicalKenya\Filters\LocationFilter;
use App\MagicalKenya\Traits\PaginatorLength;
use App\TouristExperience;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;

class TouristExperienceRepository implements TouristExperienceRepositoryInterface
{
    use PaginatorLength;

    /**
     * @inheritDoc
     */
    public function createTouristExperience(Request $request): TouristExperience
    {
        return TouristExperience::create($request->input());
    }

    /**
     * @inheritDoc
     */
    public function getAllTouristExperiences(Request $request): LengthAwarePaginator
    {
        $queryBuilder = TouristExperience::query();

        return app(Pipeline::class)
            ->send($queryBuilder)
            ->through([
                LocationFilter::class,
                ActivityFilter::class,
            ])
            ->thenReturn()
            ->paginate($this->perPage($request));
    }

    /**
     * @inheritDoc
     */
    public function updateTouristExperience(Request $request, TouristExperience $touristExperience): TouristExperience
    {
        $touristExperience->fill($request->input());
        $touristExperience->save();
        return $touristExperience;
    }

    /**
     * @inheritDoc
     */
    public function removeTouristExperience(TouristExperience $touristExperience)
    {
        // TODO: Implement removeTouristExperience() method.
    }
}
