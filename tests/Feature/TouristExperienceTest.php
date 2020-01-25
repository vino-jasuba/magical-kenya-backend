<?php

namespace Tests\Feature;

use App\User;
use App\Activity;
use App\Location;
use App\Tag;
use Tests\TestCase;
use App\TouristExperience;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;

class TouristExperienceTest extends TestCase
{
    use DatabaseMigrations;
    use WithFaker;

    public function testItCreatesTouristExperiences()
    {
        // setup
        $this->withoutExceptionHandling();
        Passport::actingAs(factory(User::class)->create());
        $activity = factory(Activity::class)->create([
            'name' => 'Cycling'
        ]);
        $location = factory(Location::class)->create([
            'name' => 'Kilimambogo'
        ]);

        // act
        $response = $this->postJson('/api/v1/experiences', [
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

    public function testItCreatesTagsForTouristExperiences()
    {
        // setup
        $this->withoutExceptionHandling();
        Passport::actingAs(factory(User::class)->create());
        $activity = factory(Activity::class)->create([
            'name' => 'Cycling'
        ]);
        $location = factory(Location::class)->create([
            'name' => 'Kilimambogo'
        ]);

        // act
        $response = $this->postJson('/api/v1/experiences', [
            'location_id' => $location->id,
            'activity_id' => $activity->id,
            'description' => 'Experience Bliss',
            'tags' => ['cool', 'new', 'stuff']
        ]);

        // assert
        $response->assertStatus(201);
        $this->assertEquals(3, Tag::count());
    }

    public function testCreatingTouristExperiencesWithContactPersonDetailsGeneratesVCardQRCode()
    {
        // setup
        $this->withoutExceptionHandling();
        Passport::actingAs(factory(User::class)->create());
        $activity = factory(Activity::class)->create([
            'name' => 'Cycling'
        ]);
        $location = factory(Location::class)->create([
            'name' => 'Kilimambogo'
        ]);

        $phoneNumber = $this->faker()->phoneNumber;
        $contactName = $this->faker()->name;

        // act
        $response = $this->postJson('/api/v1/experiences', [
            'location_id' => $location->id,
            'activity_id' => $activity->id,
            'description' => 'Experience Bliss',
            'contact_name' => $contactName,
            'contact_phone_number' => $phoneNumber,
        ]);

        // assert
        $experienceLiaison = TouristExperience::first()->liaison;

        $response->assertStatus(201)
            ->assertSee('Kilimambogo Cycling')
            ->assertSee('Experience Bliss')
            ->assertSee(Str::slug($experienceLiaison->name) . '.svg');
        $this->assertDatabaseHas((new TouristExperience)->getTable(), [
            'description' => 'Experience Bliss'
        ]);

        $this->assertEquals($experienceLiaison->phone_number, $phoneNumber);
        $this->assertEquals($experienceLiaison->name, $contactName);
    }

    public function testItCanFetchExperiencesByAppliedFilterQuery()
    {
        $this->withoutExceptionHandling();
        // setup
        // user


        // activities
        $cycling = factory(Activity::class)->create(['name' => 'Cycling']);
        $culturalFest = factory(Activity::class)->create(['name' => 'Cultural Festivals']);
        $beaches = factory(Activity::class)->create(['name' => 'Beaches']);
        $golf = factory(Activity::class)->create(['name' => 'Golf']);

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
        Passport::actingAs(factory(User::class)->create());
        $experience = factory(TouristExperience::class)->create();

        // act
        $response = $this->patchJson('/api/v1/experiences/' . $experience->id, [
            'description' => 'Experience the joy of golf on the sandy beaches of Marakech',
        ]);

        // assert
        $response->assertStatus(200)
            ->assertSee('Experience the joy of golf on the sandy beaches of Marakech');
        $this->assertDatabaseHas((new TouristExperience)->getTable(), [
            'description' => 'Experience the joy of golf on the sandy beaches of Marakech'
        ]);
    }


    public function testCanSoftDeleteTouristExperienceRecords()
    {
        // setup
        Passport::actingAs(factory(User::class)->create());
        $experience = factory(TouristExperience::class)->create();

        // act
        $response = $this->deleteJson('/api/v1/experiences/' . $experience->id);

        // assert
        $response->assertStatus(204);
        $this->assertSoftDeleted((new TouristExperience)->getTable(), [
            'description' => $experience->description,
        ]);
    }
}
