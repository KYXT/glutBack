<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/product-categories",
     *     operationId="product-categories",
     *     tags={"Product categories"},
     *     summary="Get all products categories",
     *     description="Return all products categories",
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(example="List of products categories.")
     *      )
     * )
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $lang = App::getLocale();

        $categories = ProductCategory::where('lang', $lang)
                            ->orderBy('name')
                            ->get();

        return $this->success([
            'product-categories'  => $categories
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/product-categories/{slug}",
     *     operationId="show products category",
     *     tags={"Product categories"},
     *     summary="Get products categories by slug",
     *     description="",
     *     @OA\Parameter(
     *          name="slug",
     *          description="Product category slug",
     *          required=true,
     *          in="path",
     *          example="mleczne-produkty",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(example="Products category with subcategories")
     *      ),
     *     @OA\Response(
     *          response=500,
     *          description="Item not founded",
     *          @OA\JsonContent(example="Item not founded")
     *      ),
     * )
     *
     * @param $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($slug)
    {
        $lang = App::getLocale();

        $categories = ProductCategory::where([
            'lang'  => $lang,
            'slug'  => $slug
        ])
            ->with('subcategories')
            ->first();

        if (!$categories) {
            return $this->error([
                __('errors.not-founded')
            ]);
        }

        return $this->success([
            'product-categories'  => $categories
        ]);
    }
}
