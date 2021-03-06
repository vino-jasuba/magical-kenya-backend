<?php

namespace App\Http\Repositories;

use App\Http\Contracts\TouristExperienceRepositoryContract;
use App\Liaison;
use App\MagicalKenya\Filters\ActivityFilter;
use App\MagicalKenya\Filters\LocationFilter;
use App\MagicalKenya\Filters\TagFilter;
use App\MagicalKenya\Traits\PaginatorLength;
use App\Tag;
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
        $this->updateLiaisonDetailsFromRequest($touristExperience, $request);

        $this->syncTagsFromRequest($touristExperience, $request);

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
                TagFilter::class,
            ])
            ->thenReturn()
            ->latest()
            ->paginate($this->perPage($request));
    }

    /**
     * @inheritDoc
     */
    public function updateTouristExperience(Request $request, TouristExperience $touristExperience): TouristExperience
    {
        $touristExperience->fill($request->input());
        $touristExperience->save();

        $this->updateLiaisonDetailsFromRequest($touristExperience, $request);

        $this->syncTagsFromRequest($touristExperience, $request);

        return $touristExperience;
    }

    /**
     * @inheritDoc
     */
    public function removeTouristExperience(TouristExperience $touristExperience)
    {
        $touristExperience->delete();
    }


    private function syncTagsFromRequest(TouristExperience $touristExperience, Request $request) : void
    {
        if ($request->has('tags')) {
            $tags = collect($request->tags)->map(function ($tagName) {
                $tag = Tag::firstOrCreate([
                    'name' => $tagName,
                ]);

                return $tag->id;
            })
            ->toArray();

            $touristExperience->tags()->sync($tags);
        }
    }

    private function updateLiaisonDetailsFromRequest(TouristExperience $touristExperience, Request $request)
    {
        if ($request->has('contact_name')) {
            $liaison = Liaison::firstOrCreate([
                'phone_number' => $request->contact_phone_number,
                'name' => $request->contact_name,
            ]);

            $liaison->associatedExperiences()->save($touristExperience);
        }
    }
}
