<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/products",
     *     operationId="products",
     *     tags={"Products"},
     *     summary="Get all products",
     *     description="Return all products with category, subcategory and images, paginated by 12",
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(example="List of products. Pagination by 12")
     *      )
     * )
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $categorySlug = null;
        $subcategorySlug = null;

        if ($request->has('category_slug')) {
            $categorySlug = $request->get('category_slug');
        }

        if ($request->has('subcategory_slug')) {
            $subcategorySlug = $request->get('subcategory_slug');
        }

        $products = Product::orderBy('name')
            ->with('images');

        if ($categorySlug) {
            $products = $products->whereHas('subcategory.category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        if ($subcategorySlug) {
            $products = $products->whereHas('subcategory', function ($q) use ($subcategorySlug) {
                $q->where('slug', $subcategorySlug);
            });
        }

        $products = $products->paginate(12);

        foreach ($products as $product) {
            foreach ($product->images as $key => $item) {
                if ($item->is_main == true) {
                    $product['main-image'] = $item['link'];
                    unset($product->images[$key]);
                    break;
                }
            }
        }

        return $this->success([
            'products'  => $products
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/products/{slug}",
     *     operationId="products-show",
     *     tags={"Products"},
     *     summary="Get one product by slug",
     *     description="Return product with category, subcategory and images, paginated by 12",
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
     *          @OA\JsonContent(example="One product.")
     *      )
     * )
     *
     * @return JsonResponse
     */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->with('subcategory.category', 'images')
            ->first();

        if (!$product) {
            return $this->error([
                __('errors.not-founded')
            ]);
        }

        foreach ($product->images as $key => $item) {
            if ($item->is_main == true) {
                $product['main-image'] = $item['link'];
                unset($product->images[$key]);
                break;
            }
        }

        return $this->success([
            'product'  => $product
        ]);
    }
}
