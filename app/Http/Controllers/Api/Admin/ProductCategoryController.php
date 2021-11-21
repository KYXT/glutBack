<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Uploader;
use App\Http\Helpers\UrlGeneratorHelper;
use App\Http\Requests\Api\Admin\ProductCategories\StoreProductCategoryRequest;
use App\Http\Requests\Api\Admin\ProductCategories\UpdateProductCategoryRequest;
use App\Models\ProductCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;

class ProductCategoryController extends Controller
{
    /**
     * Store products category
     *
     * @OA\Post(
     *     path="/admin/product-categories/store",
     *     operationId="store-product-category",
     *     tags={"Admin-Categories-Products"},
     *     summary="Create products category",
     *     description="Use form-data request",
     *     security={
     *          {"bearer": {}}
     *     },
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StoreProductCategoryRequest")
     *      ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Successfully created")
     *          )
     *      )
     * )
     *
     * @param StoreProductCategoryRequest $request
     * @return JsonResponse
     */
    public function store(StoreProductCategoryRequest $request)
    {
        $data = $request->validated();

        $data['slug'] = UrlGeneratorHelper::postUrl($data['name'], ProductCategory::class);
        $data['lang'] = App::getLocale();
        $data['image'] = Uploader::upload('images/product-categories', $data['image']);

        $productCategory = ProductCategory::create($data);

        return $this->success([
            'product-category' => $productCategory
        ]);
    }

    /**
     * Update products category
     *
     * @OA\Post(
     *     path="/admin/product-categories/update/{slug}",
     *     operationId="update-product-category",
     *     tags={"Admin-Categories-Products"},
     *     summary="Update products category",
     *     description="Use form-data request",
     *     security={
     *          {"bearer": {}}
     *     },
     *     @OA\Parameter(
     *          name="slug",
     *          description="Products-category slug",
     *          required=true,
     *          in="path",
     *          example="produkty-mleczne",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UpdateProductCategoryRequest")
     *      ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Successfully created")
     *          )
     *      )
     * )
     *
     * @param UpdateProductCategoryRequest $request
     * @param $slug
     * @return JsonResponse
     */
    public function update(UpdateProductCategoryRequest $request, $slug)
    {
        $lang = App::getLocale();

        $productCategory = ProductCategory::where([
            'lang' => $lang,
            'slug' => $slug
        ])
            ->first();

        if (!$productCategory) {
            return $this->error([
                __('errors.not-founded')
            ]);
        }

        $data = $request->validated();
        $request->validate([
            'name' => 'unique:product_categories,name,' . $productCategory->id
        ]);

        if ($data['name'] != $productCategory->name) {
            $data['slug'] = UrlGeneratorHelper::postUrl($data['name'], ProductCategory::class);
        }

        if (isset($data['image'])) {
            Uploader::deleteAttachment($productCategory->image);
            $data['image'] = Uploader::upload('images/product-categories', $data['image']);
        }

        $productCategory->update($data);

        return $this->success([
            'product-category' => $productCategory
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @OA\Post(
     *     path="/admin/product-categories/delete/{slug}",
     *     operationId="delete-product-category",
     *     tags={"Admin-Categories-Products"},
     *     summary="Delete products category by slug",
     *     description="Delete products category",
     *     security={
     *          {"bearer": {}}
     *     },
     *     @OA\Parameter(
     *          name="slug",
     *          description="Products category slug",
     *          required=true,
     *          in="path",
     *          example="produkty-mleczne",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Successfully deleted")
     *          )
     *      ),
     *     @OA\Response(
     *          response=500,
     *          description="Item not founded",
     *          @OA\JsonContent(example="Item not founded")
     *      ),
     * )
     *
     * @param $slug
     * @return JsonResponse
     */
    public function delete($slug)
    {
        $lang = App::getLocale();

        $productCategory = ProductCategory::where([
            'lang' => $lang,
            'slug' => $slug
        ])
            ->withCount('subcategories')
            ->first();

        if (!$productCategory) {
            return $this->error([
                __('errors.not-founded')
            ]);
        }

        if (count($productCategory->subcategories) > 0) {
            return $this->error([
                __('products.subcategories-count-error')
            ]);
        }

        Uploader::deleteAttachment($productCategory->image);
        $productCategory->delete();

        return $this->success([
            'message' => __('success.delete')
        ]);
    }
}
