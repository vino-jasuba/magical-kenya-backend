<?php

namespace App\MagicalKenya\Traits;

trait HasFiles
{
    private function mediaFor(string $useCase)
    {
        return $this->media()->useCase($useCase)->get();
    }
}
