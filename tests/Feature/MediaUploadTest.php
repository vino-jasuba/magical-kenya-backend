<?php

namespace Tests\Feature;

use App\Activity;
use App\Location;
use App\Media;
use App\TouristExperience;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MediaUploadTest extends TestCase
{
    use DatabaseMigrations;

    public function testCanUploadImageFiles()
    {
        // setup
        Storage::fake('public');
        factory(Location::class, rand(1, 10))->create();
        factory(Activity::class, rand(1, 10))->create();
        factory(TouristExperience::class, rand(1, 10))->create();
        $locationId = Location::all()->random()->id;
        $activityId = Activity::all()->random()->id;
        $experienceId = TouristExperience::all()->random()->id;
        // act
        // create location media
        $locationMediaResponse = $this->postJson('/api/v1/media', [
            'files' => [UploadedFile::fake()->image('shiro.jpeg')],
            'description' => 'experience beauty and glamor with',
            'use_case' => 'background',
            'target_key' => $locationId,
            'target_type' => 'location'
        ]);

        // create activity media
        $activityMediaResponse = $this->postJson('/api/v1/media', [
            'files' => [UploadedFile::fake()->image('shiro.png')],
            'description' => 'play in the sandy beaches of diani',
            'use_case' => 'background',
            'target_key' => $activityId,
            'target_type' => 'activity'
        ]);

        // create experience media
        $experienceMediaResponse = $this->postJson('/api/v1/media', [
            'files' => [UploadedFile::fake()->image('shiro.jpeg')],
            'description' => 'play couple on the shores of Kalungu',
            'use_case' => 'carousel',
            'target_key' => $experienceId,
            'target_type' => 'experience'
        ]);

        // assert
        // location media
        $locationMediaResponse->assertStatus(201);
        Storage::disk('public')->assertExists($this->filePathFromUrl($locationMediaResponse->json('data')[0]['file_path']));
        $this->assertDatabaseHas('media', [
            'file_type' => 'image/jpeg',
            'description' => 'experience beauty and glamor with',
            'model_type' => Location::class,
            'model_primary_key' => $locationId,
        ]);

        // activity media
        $activityMediaResponse->assertStatus(201);
        Storage::disk('public')->assertExists($this->filePathFromUrl($activityMediaResponse->json('data')[0]['file_path']));
        $this->assertDatabaseHas('media', [
            'file_type' => 'image/png',
            'description' => 'play in the sandy beaches of diani',
            'model_type' => Activity::class,
            'model_primary_key' => $activityId,
        ]);

        // tourist experience media
        $experienceMediaResponse->assertStatus(201);
        Storage::disk('public')->assertExists($this->filePathFromUrl($experienceMediaResponse->json('data')[0]['file_path']));
        $this->assertDatabaseHas('media', [
            'file_type' => 'image/jpeg',
            'use_case' => 'carousel',
            'description' => 'play couple on the shores of Kalungu',
            'model_type' => TouristExperience::class,
            'model_primary_key' => $experienceId,
        ]);
    }

    public function testMimeTypeValidationRule()
    {
        // setup
        Storage::fake('public');
        factory(Location::class, rand(1, 10))->create();
        $locationId = Location::all()->random()->id;

        // act
        // create location media
        $response = $this->postJson('/api/v1/media', [
            'files' => [UploadedFile::fake()->create('shiro.exe')],
            'description' => 'experience beauty and glamor with',
            'use_case' => 'background',
            'target_key' => $locationId,
            'target_type' => 'location'
        ]);

        // assert
        $response->assertStatus(422);
    }

    public function testCanUpdateMediaMetaData()
    {
        // setup
        $this->withoutExceptionHandling();
        $media = Media::create([
            'description' => 'original description',
            'model_type' => 'location',
            'model_primary_key' => 1,
            'use_case' => 'carousel',
            'file_type' => 'image/jpeg',
            'file_path' => 'path/to/file.jpeg'
        ]);

        // act
        $response = $this->patchJson('/api/v1/media/' . $media->id, [
            'use_case' => 'background',
            'description' => 'i can change descriptions'
        ]);

        // assert
        $response->assertStatus(200);
        $this->assertDatabaseHas((new Media)->getTable(), [
            'description' => 'i can change descriptions',
            'use_case' => 'background'
        ]);
    }

    public function testDeletingMediaFiles()
    {
        // setup
        Storage::fake('public');
        $location = factory(Location::class)->create();

        // act
        // create location media
        $response = $this->postJson('/api/v1/media', [
            'files' => [UploadedFile::fake()->create('shiro.png')],
            'description' => 'experience beauty and glamor with',
            'use_case' => 'background',
            'target_key' => $location->id,
            'target_type' => 'location'
        ]);

        $this->assertNotEquals([], Storage::disk('public')->allFiles());

        $media = Media::first();
        $deleteResponse = $this->deleteJson('/api/v1/media/' . $media->id);

        // assert
        $response->assertStatus(201);
        $deleteResponse->assertStatus(204);
        $this->assertEquals([], Storage::disk('public')->allFiles());
    }


    public function testItFetchesLocationsWithAssociatedMediaFiles()
    {
        // setup
        $user = factory(User::class)->create();
        $location = factory(Location::class)->create();
        $media = factory(Media::class, 10)->make();

        $media->each(function ($file) use ($location) {
            $location->media()->save($file);
        });

        // act
        $response = $this->actingAs($user)->getJson('/api/v1/locations/' . $location->id);

        // assert
        $response->assertStatus(200);
        $this->assertEquals($location->media()->useCase('carousel')->count(), sizeof($response->json('data.carousel')));
        $this->assertEquals($location->media()->useCase('background')->count(), sizeof($response->json('data.background')));
    }

    public function testItFetchesActivitiesWithAssociatedMediaFiles()
    {
        // setup
        $user = factory(User::class)->create();
        $activity = factory(Activity::class)->create();
        $media = factory(Media::class, 10)->make();

        $media->each(function ($file) use ($activity) {
            $activity->media()->save($file);
        });

        // act
        $response = $this->actingAs($user)->getJson('/api/v1/activities/' . $activity->id);

        // assert
        $response->assertStatus(200);
        $this->assertEquals($activity->media()->useCase('carousel')->count(), sizeof($response->json('data.carousel')));
        $this->assertEquals($activity->media()->useCase('background')->count(), sizeof($response->json('data.background')));
    }

    /**
     * Remove the app host and leading forward slash on the fileUrl
     *
     * @param string $fileUrl
     * @return void
     */
    private function filePathFromUrl(string $fileUrl)
    {
        return ltrim(str_replace(env('APP_URL') . '/storage', '', $fileUrl), '/');
    }
}
