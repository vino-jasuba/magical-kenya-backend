<?php

namespace App\Http\Services;

use App\TouristExperience;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

interface TouristExperienceRepositoryInterface
{
    /**
     * Create new Tourist experience
     *
     * @param Request $request
     * @return TouristExperience
     */
    public function createTouristExperience(Request $request) : TouristExperience;

    /**
     * Fetch paginated and filtered list of tourist experiences
     * The filters include by location or activity type
     *
     * @return LengthAwarePaginator
     */
    public function getAllTouristExperiences() : LengthAwarePaginator;

    /**
     * Update details of a tourist experience
     *
     * @param Request $request
     * @param TouristExperience $touristExperience
     * @return TouristExperience
     */
    public function updateTouristExperience(Request $request, TouristExperience $touristExperience) : TouristExperience;

    /**
     * Soft delete tourist experience
     *
     * @param TouristExperience $touristExperience
     * @return void
     */
    public function removeTouristExperience(TouristExperience $touristExperience);
}
