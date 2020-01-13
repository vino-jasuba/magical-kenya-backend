<?php

namespace App\MagicalKenya\Traits;

use Illuminate\Http\Request;

trait PaginatorLength
{
    public function perPage(Request $request) : int
    {
        $maxPerPage = intval(config('app.per_page'));
        $perPage = $request->per_page ?? $maxPerPage;

        if ($perPage > $maxPerPage || $perPage < 1) {
            $perPage = $maxPerPage;
        }

        return $perPage;
    }
}
