<?php

use App\TouristExperience;
use Illuminate\Database\Seeder;

class TouristExperienceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(TouristExperience::class, 50)->create();
    }
}
