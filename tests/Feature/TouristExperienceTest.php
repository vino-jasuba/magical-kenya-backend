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
        $this->withoutExceptionHandling();
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
}
