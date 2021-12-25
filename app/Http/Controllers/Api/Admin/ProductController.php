<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Uploader;
use App\Http\Helpers\UrlGeneratorHelper;
use App\Http\Requests\Api\Admin\Products\StoreProductRequest;
use App\Http\Requests\Api\Admin\Products\UpdateProductRequest;
use App\Models\Map;
use App\Models\Product;
use App\Models\ProductImage;
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
        
        if (!isset($subcategory->category)) {
            return $this->error(__('products.subcategory-category-relation'));
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

    /**
     * Update product.
     *
     * @OA\Post(
     *     path="/admin/products/update/{slug}",
     *     operationId="update-product",
     *     tags={"Admin-Products"},
     *     summary="Update product by slug",
     *     description="!!! use form-data for api !!!. Images 'is_main' field is not working. Example of request: https://drive.google.com/file/d/1lNZPNG8k4ieZeR4Zohj1Ci61s92vZafP/view?usp=sharing",
     *     security={
     *          {"bearer": {}}
     *     },
     *     @OA\Parameter(
     *          name="slug",
     *          description="Product slug",
     *          required=true,
     *          in="path",
     *          example="moloko-moloczyj-mir",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Successfully updated")
     *          )
     *      )
     * )
     *
     * @param $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateProductRequest $request, $slug)
    {
        $product = Product::where('slug', $slug)
            ->with('subcategory.category', 'images')
            ->first();

        if (!$product) {
            return $this->error([
                __('errors.not-founded')
            ]);
        }

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

        $product->update($data);

        if (isset($data['images'])) {
            $images = [];
            foreach ($data['images'] as $item) {
                $images[] = [
                    'is_main' =>  $item['is_main'],
                    'link'    =>  Uploader::upload('images/products', $item['image'])
                ];
            }

            $product->images()->createMany($images);
        }

        return $this->success([
            'message' => __('success.update'),
        ]);
    }

    /**
     * Delete product.
     *
     * @OA\Post(
     *     path="/admin/products/delete/{slug}",
     *     operationId="delete-product",
     *     tags={"Admin-Products"},
     *     summary="Delete product",
     *     description="Delete product with images",
     *     security={
     *          {"bearer": {}}
     *     },
     *     @OA\Parameter(
     *          name="slug",
     *          description="Product slug",
     *          required=true,
     *          in="path",
     *          example="moloko-moloczyj-mir",
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
     *      )
     * )
     *
     * @param $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($slug)
    {
        $product = Product::where('slug', $slug)
            ->with('subcategory.category', 'images')
            ->first();

        if (!$product) {
            return $this->error([
                __('errors.not-founded')
            ]);
        }

        foreach ($product->images as $item) {
            Uploader::deleteAttachment($item['link']);
        }

        $product->images()->delete();
        $product->delete();

        return $this->success([
            'message' => __('success.delete'),
        ]);
    }

    /**
     * Delete product image.
     *
     * @OA\Post(
     *     path="/admin/products/delete-image/{id}",
     *     operationId="delete-product-image",
     *     tags={"Admin-Products"},
     *     summary="Delete product image",
     *     description="Delete product image by id",
     *     security={
     *          {"bearer": {}}
     *     },
     *     @OA\Parameter(
     *          name="id",
     *          description="Product image id",
     *          required=true,
     *          in="path",
     *          example="1",
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
     *      )
     * )
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteImage($id)
    {
        $image = ProductImage::where('id', $id)
                        ->first();

        if (!$image) {
            return $this->error([
                __('errors.not-founded')
            ]);
        }

        if ($image['is_main'] == true) {
            return $this->error([
                __('products.delete-main-image')
            ]);
        }

        $images = ProductImage::where('product_id', $image['product_id'])
            ->get();

        if (count($images) <= 1) {
            return $this->error([
                __('products.count-images')
            ]);
        }

        Uploader::deleteAttachment($image['link']);
        $image->delete();

        return $this->success([
            'message' => __('success.delete'),
        ]);
    }

    /**
     * Set main product image.
     *
     * @OA\Post(
     *     path="/admin/products/main-image/{id}",
     *     operationId="set-main-product-image",
     *     tags={"Admin-Products"},
     *     summary="Set main product image",
     *     description="Set main product image by id",
     *     security={
     *          {"bearer": {}}
     *     },
     *     @OA\Parameter(
     *          name="id",
     *          description="Product image id",
     *          required=true,
     *          in="path",
     *          example="1",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Successfully updated")
     *          )
     *      )
     * )
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function setMainImage($id)
    {
        $image = ProductImage::where('id', $id)
            ->first();

        if (!$image) {
            return $this->error([
                __('errors.not-founded')
            ]);
        }

        $images = ProductImage::where('product_id', $image['product_id'])
            ->get();

        foreach ($images as $item) {
            if ($item['is_main'] == true) {
                $item->update([
                    'is_main'   => false
                ]);
            }
        }

        $image->update([
            'is_main' => true
        ]);

        return $this->success([
            'message' => __('success.update'),
        ]);
    }
}
