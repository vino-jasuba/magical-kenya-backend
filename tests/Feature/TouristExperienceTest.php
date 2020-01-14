<?php

namespace Tests\Feature;

use App\Activity;
use App\Location;
use App\TouristExperience;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TouristExperienceTest extends TestCase
{
    use DatabaseMigrations;
    use WithFaker;

    public function testItCreatesTouristExperiences()
    {
        // setup
        $user = factory(User::class)->create();
        $activity = factory(Activity::class)->create([
            'title' => 'Cycling'
        ]);
        $location = factory(Location::class)->create([
            'name' => 'Kilimambogo'
        ]);

        // act
        $response = $this->actingAs($user)->postJson('/api/v1/experiences', [
            'location_id' => $location->id,
            'activity_id' => $activity->id,
            'description' => 'Experience Bliss',
        ]);

        // assert
        $response->assertStatus(201)
            ->assertSee('Kilimambogo Cycling')
            ->assertSee('Experience Bliss');
        $this->assertDatabaseHas((new TouristExperience)->getTable(), [
            'description' => 'Experience Bliss'
        ]);
    }

    public function testItCanFetchExperiencesByAppliedFilterQuery()
    {
        $this->withoutExceptionHandling();
        // setup
        // user
        $user = factory(User::class)->create();

        // activities
        $cycling = factory(Activity::class)->create(['title' => 'Cycling']);
        $culturalFest = factory(Activity::class)->create(['title' => 'Cultural Festivals']);
        $beaches = factory(Activity::class)->create(['title' => 'Beaches']);
        $golf = factory(Activity::class)->create(['title' => 'Golf']);

        // locations
        $kilimambogo = factory(Location::class)->create(['name' => 'Kilimambogo']);
        $agadir = factory(Location::class)->create(['name' => 'Agadir']);
        $casablanca = factory(Location::class)->create(['name' => 'Casablanca']);
        $marakech = factory(Location::class)->create(['name' => 'Marakech']);

        // experiences
        // cycling
        factory(TouristExperience::class)->create([
            'location_id' => $kilimambogo,
            'activity_id' => $cycling,
        ]);

        factory(TouristExperience::class)->create([
            'location_id' => $agadir,
            'activity_id' => $cycling,
        ]);

        // cultural festivals
        factory(TouristExperience::class)->create([
            'location_id' => $casablanca,
            'activity_id' => $culturalFest,
        ]);

        // beaches
        factory(TouristExperience::class)->create([
            'location_id' => $casablanca,
            'activity_id' => $beaches,
        ]);

        // golf
        factory(TouristExperience::class)->create([
            'location_id' => $agadir,
            'activity_id' => $golf,
        ]);

        factory(TouristExperience::class)->create([
            'location_id' => $casablanca,
            'activity_id' => $golf,
        ]);

        factory(TouristExperience::class)->create([
            'location_id' => $marakech,
            'activity_id' => $golf,
        ]);

        // act
        $response = $this->getJson('/api/v1/experiences');
        $locationFilterResponse = $this->getJson('/api/v1/experiences?location=Agadir');
        $activityFilterResponse = $this->getJson('/api/v1/experiences?activity=Golf');
        $combinedFilters = $this->getJson('/api/v1/experiences?activity=Golf&location=Casablanca');

        // assert
        $response->assertStatus(200)->assertJson(['meta' => ['total' => 7]]);
        $locationFilterResponse->assertStatus(200)->assertJson(['meta' => ['total' => 2]]);
        $activityFilterResponse->assertStatus(200)->assertJson(['meta' => ['total' => 3]]);
        $combinedFilters->assertStatus(200)->assertJson(['meta' => ['total' => 1]]);
    }


    public function testAuthenticatedUsersCanUpdateExperienceDetails()
    {
        // setup
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $experience = factory(TouristExperience::class)->create();

        // act
        $response = $this->actingAs($user)->patchJson('/api/v1/experiences/' . $experience->id, [
            'description' => 'Experience the joy of golf on the sandy beaches of Marakech',
        ]);

        // assert
        $response->assertStatus(200)
            ->assertSee('Experience the joy of golf on the sandy beaches of Marakech');
        $this->assertDatabaseHas((new TouristExperience)->getTable(), [
            'description' => 'Experience the joy of golf on the sandy beaches of Marakech'
        ]);
    }
}
