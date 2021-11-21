<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Uploader;
use App\Http\Helpers\UrlGeneratorHelper;
use App\Http\Requests\Api\Admin\Products\StoreProductRequest;
use App\Models\Map;
use App\Models\Product;
use App\Models\ProductSubcategory;

class ProductController extends Controller
{
    /**
     * Create product.
     *
     * @OA\Post(
     *     path="/admin/products/store",
     *     operationId="store-product",
     *     tags={"Admin-Products"},
     *     summary="Create product",
     *     description="!!! use form-data for api !!!. Example of request: https://drive.google.com/file/d/1lNZPNG8k4ieZeR4Zohj1Ci61s92vZafP/view?usp=sharing",
     *     security={
     *          {"bearer": {}}
     *     },
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StoreProductRequest")
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
     * @param StoreProductRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();

        $map = Map::where('id', $data['map_id'])
            ->first();

        if (!$map) {
            return $this->error(__('errors.not-founded'));
        }
        if ($map['lang'] != $data['lang']) {
            return $this->error(__('products.language'));
        }

        $subcategory = ProductSubcategory::where('id', $data['subcategory_id'])
            ->with('category')
            ->first();

        if (!$subcategory) {
            return $this->error(__('errors.not-founded'));
        }

        if ($subcategory->category->lang != $data['lang']) {
            return $this->error(__('products.language-subcategory'));
        }

        $mainCount = 0;
        foreach ($data['images'] as $item) {
            if ($item['is_main'] == true) {
                $mainCount++;
            }
        }

        if ($mainCount != 1) {
            return $this->error(__('products.is-main-image'));
        }

        $data['slug'] = UrlGeneratorHelper::postUrl($data['name'], Product::class);

        $images = [];
        foreach ($data['images'] as $item) {
            $images[] = [
                'is_main' =>  $item['is_main'],
                'link'    =>  Uploader::upload('images/products', $item['image'])
            ];
        }

        $product = Product::create($data);
        $product['images'] = $product->images()->createMany($images);

        return $this->success([
            'message' => __('success.create'),
            'product' => $product
        ]);
    }
}
