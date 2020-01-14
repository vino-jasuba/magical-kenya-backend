<?php

namespace App\Http\Repositories;

use App\Http\Services\TouristExperienceRepositoryInterface;
use App\TouristExperience;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class TouristExperienceRepository implements TouristExperienceRepositoryInterface
{

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
    public function getAllTouristExperiences(): LengthAwarePaginator
    {
        // TODO: Implement getAllTouristExperiences() method.
    }

    /**
     * @inheritDoc
     */
    public function updateTouristExperience(Request $request, TouristExperience $touristExperience): TouristExperience
    {
        // TODO: Implement updateTouristExperience() method.
    }

    /**
     * @inheritDoc
     */
    public function removeTouristExperience(TouristExperience $touristExperience)
    {
        // TODO: Implement removeTouristExperience() method.
    }
}
