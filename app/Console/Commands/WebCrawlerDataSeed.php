<?php

namespace App\Console\Commands;

use App\Activity;
use App\Location;
use App\TouristExperience;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Symfony\Component\DomCrawler\Crawler;
use UnexpectedValueException;
use Illuminate\Support\Str;

class WebCrawlerDataSeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed test data from muchmorocco.com';

    protected $http;

    protected $domCrawler;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Client $client, Crawler $domCrawler)
    {
        parent::__construct();
        $this->http = $client;
        $this->domCrawler = $domCrawler;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            /**
             * Crawl muchmorocco and fetch the available tourist destinations
             * as well as the activities that are available e.g Beaches, Cultural Festivals
             * use these to create corresponding models in the application storage
             */
            collect(['experiences', 'locations'])->each(function ($uriSegment) {
                $this->info('Firing up the engines to fetch ' . $uriSegment);
                $response = $this->http->get('http://www.muchmorocco.com/' . $uriSegment);
                $html = $response->getBody()->getContents();
                $domCrawler = new Crawler($html);

                $progressBar = $this->output->createProgressBar($domCrawler->filter('.carousel-overlay')->count());

                $domCrawler->filter('.carousel-overlay')->each(function (Crawler $nodeCrawler) use ($uriSegment, $progressBar) {
                    $slogan = $nodeCrawler->filter('.carousel-overlay-pre-header')->text();
                    $title = $nodeCrawler->filter('h1')->text();
                    $description = $nodeCrawler->filter('.carousel-overlay-custom-excerpt')->text();

                    factory($this->modelForUriContent($uriSegment))->create([
                        'name' => $title,
                        'catchphrase' => $slogan,
                        'description' => $description,
                    ]);

                    $progressBar->advance();
                });

                $this->info('');
                $progressBar->finish();
            });

            /**
             * With all the activities extracted from above, find all the experiences created from those activities
             * Extract location string from the experience and find matching Location model on local storage.
             * Use this to create TouristExperience
             */
            Activity::all()->map(function ($activity) {
                try {
                    $activitySlug = Str::slug(str_replace('&', 'and', $activity->name));
                    $response = $this->http->get('http://www.muchmorocco.com/experiences/' . $activitySlug);
                    $html = $response->getBody()->getContents();
                    $domCrawler = new Crawler($html);

                    $this->info('Working on: ' . $activity->name . ' : url -> [' . 'http://www.muchmorocco.com/experiences/' . $activitySlug . ']');
                    $progressBar = $this->getOutput()->createProgressBar($domCrawler->filterXPath("//div[contains(@style, 'display: none;')]")->count());

                    $domCrawler->filterXPath("//div[contains(@style, 'display: none;')]")->each(function (Crawler $nodeCrawler) use ($activity, $progressBar) {
                        $title = $nodeCrawler->filter('.standard-content-title')->text();
                        $this->info($title);
                        $description = $nodeCrawler->filter('.content > p')->text();
                        $location = Location::whereName(rtrim(str_replace($activity->name, '', $title)))->firstOrFail();

                        // we don't have matching location so just move on
                        if ($location) {
                            TouristExperience::create([
                                'activity_id' => $activity->id,
                                'location_id' => $location->id,
                                'description' => $description,
                            ]);
                        }

                        $progressBar->advance();
                    });

                    $progressBar->finish();
                } catch (Exception $e) {
                    $this->warn($e->getMessage());
                }
            });
        } catch (Exception $e) {
            $this->warn($e->getMessage());
        }
    }

    private function modelForUriContent(string $uriSegment)
    {
        $mapping = [
            'locations' => Location::class,
            'experiences' => Activity::class,
        ];

        throw_unless(in_array($uriSegment, ['experiences', 'locations']), UnexpectedValueException::class);

        return $mapping[$uriSegment];
    }
}
