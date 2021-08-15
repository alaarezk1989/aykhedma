<?php

namespace App\Http\Controllers\Admin;

use App\Http\Admin\Requests\CategoryRequest;
use App\Http\Controllers\BaseController;
use App\Http\Services\CategoryService;
use App\Http\Services\UploaderService;
use App\Repositories\CategoryRepository;
use App\Models\Category;
use Illuminate\Http\Request;
use View;

class CategoriesController extends BaseController
{
    protected $categoryService;
    private $categoryRepository;
    private $uploaderService;

    public function __construct(categoryService $categoryService, CategoryRepository $categoryRepository, UploaderService $uploaderService)
    {
        $this->authorizeResource(Category::class, "category");
        $this->categoryService = $categoryService;
        $this->categoryRepository = $categoryRepository;
        $this->uploaderService = $uploaderService;
    }

    public function index(Request $request)
    {
        $this->authorize("index", Category::class);

        $list = $this->categoryRepository->searchFromRequest(request());
        if ($request->query->get('view') == 'tree') {
            return View::make('admin.categories.tree', [
                'all' =>$list->get(),
                'list' => $list->where('parent_id', '=', null)->get()
            ]);
        }
        $list = $list->paginate(10);
        $list->appends(request()->all());

        return View::make('admin.categories.index', ['list' => $list]);
    }

    public function create(Request $request)
    {
        $request->query->set('active', true);
        $request->query->set('parent_id', $request->get('parent_id')) ;
        $categories = $this->categoryRepository->searchFromRequest($request)->get();
        return View::make('admin.categories.new', ['categories' => $categories]);
    }

    public function show(Request $request, Category $category)
    {
        $request->merge(['parent_id'=>$category->id]);
        $subCategories = $this->categoryRepository->searchFromRequest(request())->paginate(10);
        return view('admin.categories.show',['list' => $subCategories, 'category'=>$category]);
    }

    public function store(CategoryRequest $request)
    {
        $this->categoryService->fillFromRequest($request);
        return redirect(route('admin.categories.index'))->with('success', trans('item_added_successfully'));
    }

    public function destroy(Category $category)
    {
        if (count($category->products)) {
            return redirect()->back()->with('danger', trans('cant_delete_this_cat_related_with_products'));
        }

        $this->uploaderService->deleteFile($category->image);
        $category->delete();
        return redirect()->back()->with('delete', trans('item_deleted_successfully'));
    }

    public function edit(Request $request, Category $category)
    {
        $request->query->set('active', true);
        $categories = $this->categoryRepository->searchFromRequest($request)->get();
        return View::make('admin.categories.edit', ['item' => $category, 'categories' => $categories]);
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $this->categoryService->fillFromRequest($request, $category);
        return redirect(route('admin.categories.index'))->with('success', trans('item_updated_successfully'));
    }
}
