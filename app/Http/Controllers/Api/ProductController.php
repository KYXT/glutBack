<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

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
     *     @OA\Parameter(
     *          name="category",
     *          description="Product category slug",
     *          required=false,
     *          in="query",
     *          example="molochnyje-produkty",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="subcategory",
     *          description="Product subcategory slug",
     *          required=false,
     *          in="query",
     *          example="moloko",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
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
        $lang = App::getLocale();
    
        $categorySlug = null;
        $subcategorySlug = null;

        if ($request->has('category')) {
            $categorySlug = $request->get('category');
        }

        if ($request->has('subcategory')) {
            $subcategorySlug = $request->get('subcategory');
        }

        $products = Product::orderBy('name')
            ->where('lang', $lang)
            ->with('images', 'subcategory.category');

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

        $products = $products->with('subcategory.category')
            ->paginate(12);

        foreach ($products as $product) {
            unset($product['subcategory_id']);
            foreach ($product->images as $key => $item) {
                if ($item->is_main == true) {
                    $product['main_image'] = $item['link'];
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
            ->with('subcategory.category', 'images', 'map')
            ->first();

        if (!$product) {
            return $this->error([
                __('errors.not-founded')
            ]);
        }

        foreach ($product->images as $key => $item) {
            if ($item->is_main == true) {
                $product['main_image'] = $item['link'];
                unset($product->images[$key]);
                break;
            }
        }

        return $this->success([
            'product'  => $product
        ]);
    }
}
