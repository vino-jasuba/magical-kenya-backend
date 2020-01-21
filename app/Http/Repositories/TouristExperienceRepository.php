<?php

namespace App\Http\Repositories;

use App\Http\Contracts\TouristExperienceRepositoryContract;
use App\Liaison;
use App\MagicalKenya\Filters\ActivityFilter;
use App\MagicalKenya\Filters\LocationFilter;
use App\MagicalKenya\Traits\PaginatorLength;
use App\TouristExperience;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;

class TouristExperienceRepository implements TouristExperienceRepositoryContract
{
    use PaginatorLength;

    /**
     * @inheritDoc
     */
    public function createTouristExperience(Request $request): TouristExperience
    {
        $touristExperience = TouristExperience::create($request->only([
            'activity_id',
            'location_id',
            'description'
        ]));

        /**
         * If the request contains details of a contact person, then we
         * Create an instance of the Liaison model and associate with
         * The Experience being created
         */
        if ($request->has('contact_name')) {
            $liaison = Liaison::create([
                'phone_number' => $request->contact_phone_number,
                'name' => $request->contact_name,
            ]);

            $liaison->associatedExperiences()->save($touristExperience);
        }

        return $touristExperience;
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
        $touristExperience->delete();
    }
}
