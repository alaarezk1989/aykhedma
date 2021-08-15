<?php
/**
 * Created by PhpStorm.
 * User: yehia
 * Date: 15/04/19
 * Time: 02:03 م
 */

namespace App\Http\Services;

use App\Models\Product;
use App\Models\ProductImage;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Resources\Products;

use File;

class ProductService
{

    /**
     * @var UploaderService
     */
    private $uploaderService;
    protected $productRepository;

    public function __construct(UploaderService $uploaderService, ProductRepository $productRepository)
    {
        $this->uploaderService = $uploaderService;
        $this->productRepository = $productRepository;
    }

    /**
     * @param Request $request
     * @param null $product
     * @return Product|null
     */
    public function fillFromRequest(Request $request, $product = null)
    {
        if (!$product) {
            $product = new Product() ;
        }

        $product->fill($request->all());

        $product->active = $request->input("active", 0);

        if (count($product->branchProducts)) {
            foreach ($product->branchProducts as $branchProduct) {
                $branchProduct->active = $request->get('active');
                $branchProduct->save();
            }
        }

        $product->bundle = $request->input("bundle", 0);
        if (!empty($request->file('icon'))) {
            $product->icon = $this->uploaderService->upload($request->file('icon'), 'products');
        }

        $product->save() ;

        if ($request->has("images")) {
            $this->saveProductImages($request->file("images"), $product);
        }

        return $product ;
    }

    /**
     * @param UploadedFile [] $images
     * @param Product $product
     * @return void
     */
    private function saveProductImages($images, Product $product)
    {

        $productImages = [] ;

        foreach ($images as $image) {
            $img = $this->uploaderService->upload($image, "products");
            $productImages[] = new ProductImage(["image" => $img]);
        }

        $product->images()->saveMany($productImages);
    }

    /**
     * @param Product $product
     * @param ProductImage $productImage
     * @return bool
     * @throws \Exception
     */
    public function deleteImage(Product $product, ProductImage $productImage)
    {
        if (count($product->images) > 1) {
            $productImage->delete();
            return true ;
        }

        return false;
    }

    public function export()
    {
        $headings = [
            [trans('products_list')],
            [
                '#',
                trans('category'),
                trans('name'),
                trans('description'),
                trans('status')
            ]
        ];

        $list = $this->productRepository->search(request())->get();
        $listObjects = Products::collection($list);

        return Excel::download(new ExportService($listObjects, $headings), 'Products Report.xlsx');
    }
}
