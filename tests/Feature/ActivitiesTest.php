<?php

namespace Tests\Feature;

use App\Activity;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ActivitiesTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testAuthenticatedUsersCanCreateActivities()
    {
        // setup
        $user = factory(User::class)->create();

        // act
        $response = $this->actingAs($user)->postJson('/api/v1/activities', [
            'title' => 'Cycling',
            'description' => 'Cycling is a family fun activity',
            'catchphrase' => 'See another Morocco when you go',
        ]);

        // assert
        $response->assertStatus(201)
            ->assertSee("family fun activity");
        $this->assertDatabaseHas('activities', [
            'title' => 'Cycling',
            'catchphrase' => 'See another Morocco when you go'
        ]);
    }

    public function testCannotCreateDuplicateActivity()
    {
        // setup
        $user = factory(User::class)->create();
        $activity = factory(Activity::class)->create([
            'title' => 'Cycling'
        ]);

        // act
        $response = $this->actingAs($user)->postJson('/api/v1/activities', [
            'title' => 'Cycling',
            'description' => 'Cycling is a family fun activity',
            'catchphrase' => 'See another Morocco when you go',
        ]);

        // assert
        $response->assertStatus(422)
            ->assertSee("been taken");
        $this->assertEquals(1, Activity::whereTitle('Cycling')->count());
    }

    public function testUnauthenticatedUsersCannotCreateActivities()
    {
        $response = $this->postJson('/api/v1/activities', []);

        $response->assertStatus(401)
            ->assertSee('Unauthenticated');
    }

    public function testItCanUpdateActivityDetails()
    {
        // setup
        $user = factory(User::class)->create();
        $activity = factory(Activity::class)->create();

        // act
        $response = $this->actingAs($user)->patchJson('/api/v1/activities/' . $activity->id, [
            'description' => 'Cycling is a family fun activity',
        ]);

        // assert
        $response->assertSee('Cycling is a family fun activity');
        $this->assertDatabaseHas('activities', [
            'description' => 'Cycling is a family fun activity'
        ]);
    }

    public function testCanSoftDeleteActivityRecords()
    {
          // setup
          $user = factory(User::class)->create();
          $activity = factory(Activity::class)->create();

          // act
          $response = $this->actingAs($user)->deleteJson('/api/v1/activities/' . $activity->id);

          // assert
          $response->assertStatus(204);
          $this->assertSoftDeleted('activities', [
              'title' => $activity->title,
          ]);
    }

    public function testItCanFetchPaginatedListOfActivities()
    {
        // setup
        factory(Activity::class, 30)->create();

        // act
        $per_page = random_int(1, 15);
        $response = $this->getJson('/api/v1/activities?per_page=' . $per_page);

        // assert
        $response->assertStatus(200)
            ->assertJson(['meta' => ['total' => 30, 'per_page' => $per_page]]);
    }
}
