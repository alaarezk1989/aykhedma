<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Request;

class CategoriesController extends Controller
{
    protected $categoryRepository;
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index(Request $request)
    {
        $list = $this->categoryRepository->searchFromRequest($request)->get();

        return response()->json($list);
    }

    public function show(Category $category)
    {
        return response()->json($category);
    }

}
