<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/main-page",
     *     operationId="main-page",
     *     tags={"Main page"},
     *     summary="Main page",
     *     description="Return posts with category, paginated by 10",
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

        $posts = Post::where([
            ['lang', $lang],
            ['is_on_main', true]
        ])
            ->with('category')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return $this->success([
            'posts'  => $posts
        ]);
    }
}
