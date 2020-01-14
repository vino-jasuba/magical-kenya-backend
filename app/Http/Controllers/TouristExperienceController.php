<?php

namespace App\Http\Controllers;

use App\Http\Resources\TouristExperienceResource;
use App\Http\Services\TouristExperienceRepositoryInterface;
use App\TouristExperience;
use Illuminate\Http\Request;

class TouristExperienceController extends Controller
{
    protected $experienceRepository;

    public function __construct(TouristExperienceRepositoryInterface $experienceRepository)
    {
        $this->experienceRepository = $experienceRepository;
        $this->middleware('auth:api')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $experiencesCollection = $this->experienceRepository->getAllTouristExperiences($request);

        return TouristExperienceResource::collection($experiencesCollection);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $experience = $this->experienceRepository->createTouristExperience($request);
        return new TouristExperienceResource($experience);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TouristExperience  $touristExperience
     * @return \Illuminate\Http\Response
     */
    public function show(TouristExperience $touristExperience)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TouristExperience  $touristExperience
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TouristExperience $touristExperience)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TouristExperience  $touristExperience
     * @return \Illuminate\Http\Response
     */
    public function destroy(TouristExperience $touristExperience)
    {
        //
    }
}