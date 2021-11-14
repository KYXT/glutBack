<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\UrlGeneratorHelper;
use App\Http\Requests\Api\Admin\ProductSubcategories\StoreProductSubcategoryRequest;
use App\Http\Requests\Api\Admin\ProductSubcategories\UpdateProductSubcategoryRequest;
use App\Models\ProductCategory;
use App\Models\ProductSubcategory;

class ProductSubcategoryController extends Controller
{
    /**
     * Store products subcategory
     *
     * @OA\Post(
     *     path="/admin/product-subcategories/store",
     *     operationId="store-product-subcategory",
     *     tags={"Admin-Subcategories-Products"},
     *     summary="Create products subcategory",
     *     description="",
     *     security={
     *          {"bearer": {}}
     *     },
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StoreProductSubcategoryRequest")
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
     * @param StoreProductSubcategoryRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreProductSubcategoryRequest $request)
    {
        $data = $request->validated();

        $productCategory = ProductCategory::where('id', $data['category_id'])
            ->first();

        if (!$productCategory) {
            return $this->error([
                __('errors.not-founded')
            ]);
        }

        $data['slug'] = UrlGeneratorHelper::postUrl($data['name'], ProductSubcategory::class);

        $productSubcategory = $productCategory->subcategories()
            ->create($data);

        return $this->success([
            'product-subcategory' => $productSubcategory
        ]);
    }

    /**
     * Update products subcategory
     *
     * @OA\Post(
     *     path="/admin/product-subcategories/update/{slug}",
     *     operationId="update-product-subcategory",
     *     tags={"Admin-Subcategories-Products"},
     *     summary="Update products subcategory",
     *     description="",
     *     security={
     *          {"bearer": {}}
     *     },
     *     @OA\Parameter(
     *          name="slug",
     *          description="Products-subcategory slug",
     *          required=true,
     *          in="path",
     *          example="jogurt",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UpdateProductSubcategoryRequest")
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
     * @param UpdateProductSubcategoryRequest $request
     * @param $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateProductSubcategoryRequest $request, $slug)
    {
        $productSubcategory = ProductSubcategory::where([
            'slug' => $slug
        ])
            ->first();

        if (!$productSubcategory) {
            return $this->error([
                __('errors.not-founded')
            ]);
        }

        $data = $request->validated();
        $request->validate([
            'name' => 'unique:product_subcategories,name,' . $productSubcategory->id
        ]);

        if (isset($data['category_id'])) {
            $productCategory = ProductCategory::where('id', $data['category_id'])
                ->first();

            if (!$productCategory) {
                return $this->error([
                    __('errors.not-founded')
                ]);
            }
        }

        if ($data['name'] != $productSubcategory->name) {
            $data['slug'] = UrlGeneratorHelper::postUrl($data['name'], ProductCategory::class);
        }

        $productSubcategory->update($data);

        return $this->success([
            'product-subcategory' => $productSubcategory
        ]);
    }
}
