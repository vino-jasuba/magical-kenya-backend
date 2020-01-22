<?php

namespace Tests\Feature;

use App\Event;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class EventsTest extends TestCase
{
    use DatabaseMigrations;
    use WithFaker;

    public function testUsersCanCreateEvents()
    {
        // setup
        Passport::actingAs(factory(User::class)->create());

        // act
        $response = $this->postJson('/api/v1/events', [
            'title' => 'MARATHON OF MARRAKECH',
            'due_date' => Carbon::now()->addMonth()->format('Y-m-d'),
            'external_url' => $this->faker()->url,
        ]);

        // assert
        $response->assertStatus(201)
            ->assertSee('MARATHON OF MARRAKECH')
            ->assertSee('marathon-of-marrakech.svg');
    }

    public function testUsersCanUpdateEvents()
    {
        $this->withoutExceptionHandling();
        // setup
        Passport::actingAs(factory(User::class)->create());
        $event = factory(Event::class)->create();

        // act
        $response = $this->patchJson('/api/v1/events/' . $event->id, [
            'title' => 'Marathon',
            'due_date' => Carbon::now()->addMonth()->format('Y-m-d'),
            'external_url' => $this->faker()->url,
        ]);

        // assert
        $response->assertStatus(200)
            ->assertSee('Marathon');
    }

    public function testItFetchesUpcomingEvents()
    {
        $upcomingEvents = factory(Event::class, 12)->create([
            'due_date' => now()->addDays(rand(1, 10)),
        ]);

        $pastEvents = factory(Event::class, 12)->create([
            'due_date' => now()->subDays(rand(1, 10)),
        ]);

        $response = $this->getJson('/api/v1/events');

        $response->assertStatus(200);
        $this->assertEquals(12, $response->json('meta.total'));
        $this->assertEquals(24, Event::count());
    }
}
