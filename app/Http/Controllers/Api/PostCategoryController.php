<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;

class PostCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/post-categories",
     *     operationId="post-categories",
     *     tags={"Post categories"},
     *     summary="Get all posts categories",
     *     description="Return all posts categories",
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(example="List of posts with category.")
     *      )
     * )
     *
     * @return JsonResponse
     */
    public function index()
    {
        $lang = App::getLocale();

        $postCategories = PostCategory::where('lang', $lang)
            ->orderBy('name')
            ->get();

        return $this->success([
            'post-categories'  => $postCategories
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/post-categories/{slug}",
     *     operationId="show posts category",
     *     tags={"Post categories"},
     *     summary="Get posts category by slug",
     *     description="Return posts category with posts paginated by 12",
     *     @OA\Parameter(
     *          name="slug",
     *          description="Posts category slug",
     *          required=true,
     *          in="path",
     *          example="aktualnosci",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(example="Posts category with posts")
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
    public function show($slug)
    {
        $lang = App::getLocale();

        $postCategory = PostCategory::where([
                'lang' => $lang,
                'slug' => $slug
            ])
            ->first();

        if (!$postCategory) {
            return $this->error([
                __('errors.not-founded')
            ]);
        }

        $posts = Post::where([
            'lang'  => $lang,
            'category_id'   => $postCategory->id
        ])
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return $this->success([
            'post-category'  => $postCategory,
            'posts'          => $posts
        ]);
    }
}
