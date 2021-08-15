<?php

namespace App\Http\Services;

use App\Models\Category;
use Symfony\Component\HttpFoundation\Request;

class CategoryService
{

    protected $uploaderService;
    public function __construct(UploaderService $uploaderService)
    {
        $this->uploaderService = $uploaderService;
    }

    public function fillFromRequest(Request $request, $category = null)
    {
        if (!$category) {
            $category = new Category();
        }

        $category->fill($request->request->all());

        if (!empty($request->file('image'))) {
            $category->image = $this->uploaderService->upload($request->file('image'), 'categories_image');
        }

        $category->active = $request->request->get('active', 0);

        $category->save();

        return $category;
    }
}
