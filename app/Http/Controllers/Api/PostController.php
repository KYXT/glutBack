<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/posts",
     *     operationId="posts",
     *     tags={"Posts"},
     *     summary="Get all posts",
     *     description="Return all posts with category, paginated by 10",
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(example="List of posts with category. Pagination by 10")
     *      )
     * )
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $lang = App::getLocale();

        $posts = Post::where('lang', $lang)
            ->with('category')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return $this->success([
            'posts'  => $posts
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/posts/{slug}",
     *     operationId="show post",
     *     tags={"Posts"},
     *     summary="Get post by slug",
     *     description="Return post with category",
     *     @OA\Parameter(
     *          name="slug",
     *          description="Posts slug",
     *          required=true,
     *          in="path",
     *          example="co-to-jest-gluten",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(example="Post with category")
     *      ),
     *     @OA\Response(
     *          response=500,
     *          description="Item not founded",
     *          @OA\JsonContent(example="Item not founded")
     *      ),
     * )
     *
     * @return JsonResponse
     */
    public function show($slug): JsonResponse
    {
        $lang = App::getLocale();

        $post = Post::where([
            ['slug', $slug],
            ['lang', $lang],
        ])
            ->with('category')
            ->first();

        if (!$post) {
            return $this->error([
                __('errors.not-founded')
            ]);
        }

        return $this->success([
            'post'  => $post
        ]);
    }
}
