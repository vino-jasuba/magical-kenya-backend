<?php

namespace App\Http\Controllers;

use App\Http\Contracts\SearchServiceInterface;
use App\Http\Resources\SearchResultResource;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    protected $searchService;

    public function __construct(SearchServiceInterface $searchService)
    {
        $this->searchService = $searchService;
    }

    public function __invoke(Request $request)
    {
        return SearchResultResource::collection($this->searchService->search($request));
    }
}
