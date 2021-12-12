<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\UrlGeneratorHelper;
use App\Http\Requests\Api\Admin\ForumCategories\StoreForumCategoryRequest;
use App\Http\Requests\Api\Admin\ForumCategories\UpdateForumCategoryRequest;
use App\Models\ForumCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class ForumCategoryController extends Controller
{
    /**
     * Store posts category
     *
     * @OA\Post(
     *     path="/admin/forum/categories/store",
     *     operationId="store-forum-category",
     *     tags={"Admin-Categories-Forum"},
     *     summary="Create forum category",
     *     security={
     *          {"bearer": {}}
     *     },
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StoreForumCategoryRequest")
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
     * @param StoreForumCategoryRequest $request
     * @return JsonResponse
     */
    public function store(StoreForumCategoryRequest $request)
    {
        $lang = App::getLocale();
        
        $data = $request->validated();
        $data['slug'] = UrlGeneratorHelper::postUrl($data['name'], ForumCategory::class);
        $data['lang'] = $lang;
        
        $forumCategory = ForumCategory::create($data);
        
        return $this->success([
            'forum-category' => $forumCategory
        ]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @OA\Post(
     *     path="/admin/forum/categories/update/{slug}",
     *     operationId="update-forum-category",
     *     tags={"Admin-Categories-Forum"},
     *     summary="Update forum category",
     *     security={
     *          {"bearer": {}}
     *     },
     *     @OA\Parameter(
     *          name="slug",
     *          description="Forum category slug",
     *          required=true,
     *          in="path",
     *          example="leki",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StoreForumCategoryRequest")
     *      ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Successfully updated")
     *          )
     *      )
     * )
     *
     * @param UpdateForumCategoryRequest $request
     * @param $slug
     * @return JsonResponse
     */
    public function update(UpdateForumCategoryRequest $request, $slug)
    {
        $lang = App::getLocale();
        
        $forumCategory = ForumCategory::where([
            'lang' => $lang,
            'slug' => $slug
        ])
            ->first();
        
        if (!$forumCategory) {
            return $this->error([
                __('errors.not-founded')
            ]);
        }
        
        $data = $request->validated();
        $request->validate([
            'name' => 'unique:forum_categories,name,' . $forumCategory->id
        ]);
        
        if ($data['name'] != $forumCategory->name) {
            $data['slug'] = UrlGeneratorHelper::postUrl($data['name'], ForumCategory::class);
        }
    
        $forumCategory->update($data);
        
        return $this->success([
            'forum-category' => $forumCategory
        ]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @OA\Post(
     *     path="/admin/forum/categories/delete/{slug}",
     *     operationId="delete-forum-category",
     *     tags={"Admin-Categories-Forum"},
     *     summary="Delete forum categories by slug",
     *     description="Delete forum category. Can be done only when no topics inside",
     *     security={
     *          {"bearer": {}}
     *     },
     *     @OA\Parameter(
     *          name="slug",
     *          description="Forum category slug",
     *          required=true,
     *          in="path",
     *          example="leki",
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
    public function delete($slug)
    {
        $lang = App::getLocale();
        
        $forumCategory = ForumCategory::where([
            'lang' => $lang,
            'slug' => $slug
        ])
            ->withCount('topics')
            ->first();
        
        if (!$forumCategory) {
            return $this->error([
                __('errors.not-founded')
            ]);
        }
        
        if ($forumCategory->topics_count > 0) {
            return $this->error([
                __('forum.topics-count-error')
            ]);
        }
    
        $forumCategory->delete();
        
        return $this->success([
            'message' => __('success.delete')
        ]);
    }
}
