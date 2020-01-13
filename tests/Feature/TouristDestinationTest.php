<?php

namespace Tests\Feature;

use App\Location;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TouristDestinationTest extends TestCase
{
    use DatabaseMigrations;
    use WithFaker;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testAuthenticatedUsersCanCreateNewTouristDestinations()
    {
        // setup
        $user = factory(User::class)->create();

        // act
        $response = $this->actingAs($user)->postJson('/api/v1/locations', [
            'name' => 'Agadir',
            'description' => 'The place of wonders',
            'icon' => 'path/to/icon/file.ico',
            'catchphrase' => 'Experience wonder In',
            'color_tag' => '#fff',
            'lat' => $this->faker()->latitude,
            'lng' => $this->faker()->longitude,
        ]);

        // assert
        $response->assertStatus(201)->assertSee('Experience wonder In');
        $this->assertDatabaseHas((new Location)->getTable(), [
            'name' => 'Agadir',
            'color_tag' => '#fff'
        ]);
    }


    public function testAuthenticationUsersCanUpdateTouristDestinationDetails()
    {
        // setup
        $user = factory(User::class)->create();
        $destination = factory(Location::class)->create();

        // act
        $response = $this->actingAs($user)->patchJson('/api/v1/locations/' . $destination->id, [
            'name' => 'Marakech',
            'description' => 'Cool desert makes no sense',
        ]);

        // assert
        $response->assertStatus(200);
        $this->assertDatabaseHas((new Location)->getTable(), [
            'name' => 'Marakech',
            'description' => 'Cool desert makes no sense'
        ]);
    }


    public function testItFetchesPaginatedListOfTouristDestinations()
    {
         // setup
         $itemCount = random_int(10, 30);
         factory(Location::class, $itemCount)->create();

         // act
         $per_page = random_int(1, 15);
         $response = $this->getJson('/api/v1/locations?per_page=' . $per_page);

         // assert
         $response->assertStatus(200)
             ->assertJson(['meta' => ['total' => $itemCount, 'per_page' => $per_page]]);
    }
}
