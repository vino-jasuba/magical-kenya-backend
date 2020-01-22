<?php

use App\Activity;
use App\Event;
use App\Location;
use App\TouristExperience;

return [
    'model_mappings' => [
        'location' => Location::class,
        'experience' => TouristExperience::class,
        'activity' => Activity::class,
        'event' => Event::class,
    ],
];
