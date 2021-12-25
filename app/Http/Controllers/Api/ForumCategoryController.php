<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ForumCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;

class ForumCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/forum-categories",
     *     operationId="forum-categories",
     *     tags={"Forum-categories"},
     *     summary="Get all forum categories",
     *     description="Return all forum categories with topics count, paginated by 12",
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(example="List of forum categories. Pagination by 12")
     *      )
     * )
     *
     * @return JsonResponse
     */
    public function index()
    {
        $lang = App::getLocale();
    
        $forumCategories = ForumCategory::where([
            'lang' => $lang,
        ])
            ->orderBy('name')
            ->withCount('topics')
            ->paginate(12);
    
        return $this->success([
            'forum-categories'  => $forumCategories
        ]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/forum-categories/{slug}",
     *     operationId="show forum category",
     *     tags={"Forum-categories"},
     *     summary="Get forum category by slug",
     *     description="Return forum category with topics",
     *     @OA\Parameter(
     *          name="slug",
     *          description="Forum category slug",
     *          required=true,
     *          in="path",
     *          example="gdzie-kupic-leki",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(example="Forum category with topics")
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
    
        $forumCategory = ForumCategory::where([
            ['slug', $slug],
            ['lang', $lang]
        ])
            ->with('topics')
            ->first();
    
        if (!$forumCategory) {
            return $this->error([
                __('errors.not-founded')
            ]);
        }
    
        return $this->success([
            'forum-category'  => $forumCategory
        ]);
    }
}
