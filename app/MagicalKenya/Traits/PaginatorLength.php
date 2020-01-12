<?php

namespace App\MagicalKenya\Traits;

use Illuminate\Http\Request;

trait PaginatorLength
{
    public function perPage(Request $request) : int
    {
        $perPage = $request->per_page;
        $maxPerPage = 50;

        if ($perPage > $maxPerPage) {
            $perPage = $maxPerPage;
        }

        return $perPage;
    }
}
