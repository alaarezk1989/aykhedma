<?php

namespace App\Http\Controllers\Api;

use App\Models\Branch;
use App\Repositories\SearchRepository;
use Illuminate\Routing\Controller;
use App\Http\Requests\Api\SearchRequest;

class SearchController extends Controller
{
    protected $searchRepository;
    public function __construct(SearchRepository $searchRepository)
    {
        $this->searchRepository = $searchRepository;
    }

    public function search(SearchRequest $request)
    {

        $branches = $this->searchRepository->searchFromRequest($request);

        return response()->json($branches->get());
    }

    public function searchCategories(SearchRequest $request)
    {
        $branches = $this->searchRepository->searchCategoriesRequest($request);

        return response()->json($branches->get());
    }
}
