<?php

namespace App\Http\Contracts;

use Illuminate\Http\Request;
use Spatie\Searchable\SearchResultCollection;

interface SearchServiceInterface
{
    /**
     * Search through the application database for models that match
     * The search query given in the request object
     *
     * @param Request $request
     * @return SearchResultCollection
     */
    public function search(Request $request) : SearchResultCollection;
}
