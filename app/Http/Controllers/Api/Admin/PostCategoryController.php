<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\UrlGeneratorHelper;
use App\Http\Requests\Api\Admin\PostCategories\StorePostCategoryRequest;
use App\Http\Requests\Api\Admin\PostCategories\UpdatePostCategoryRequest;
use App\Models\PostCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

class PostCategoryController extends Controller
{
    /**
     * Store posts category
     *
     * @OA\Post(
     *     path="/admin/post-categories/store",
     *     operationId="store-post-category",
     *     tags={"Admin-Posts-Categories"},
     *     summary="Create posts category",
     *     security={
     *          {"bearer": {}}
     *     },
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StorePostCategoryRequest")
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
     * @param StorePostCategoryRequest $request
     * @return JsonResponse
     */
    public function store(StorePostCategoryRequest $request)
    {
        $lang = App::getLocale();

        $data = $request->validated();
        $data['slug'] = UrlGeneratorHelper::postUrl($data['name'], PostCategory::class);
        $data['lang'] = $lang;

        $postCategory = PostCategory::create($data);

        return $this->success([
            'post-category' => $postCategory
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @OA\Post(
     *     path="/admin/post-categories/update/{slug}",
     *     operationId="update-post",
     *     tags={"Admin-Posts-Categories"},
     *     summary="Update posts category",
     *     security={
     *          {"bearer": {}}
     *     },
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
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StorePostCategoryRequest")
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
     * @param UpdatePostCategoryRequest $request
     * @param $slug
     * @return JsonResponse
     */
    public function update(UpdatePostCategoryRequest $request, $slug)
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

        $data = $request->validated();
        $request->validate([
            'name' => 'unique:post_categories,name,' . $postCategory->id
        ]);

        if ($data['name'] != $postCategory->name) {
            $data['slug'] = UrlGeneratorHelper::postUrl($data['name'], PostCategory::class);
        }

        $postCategory->update($data);

        return $this->success([
            'post-category' => $postCategory
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @OA\Post(
     *     path="/admin/post-categories/delete/{slug}",
     *     operationId="delete-posts-category",
     *     tags={"Admin-Posts-Categories"},
     *     summary="Delete posts categories by slug",
     *     description="Delete posts category",
     *     security={
     *          {"bearer": {}}
     *     },
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

        $postCategory = PostCategory::where([
            'lang' => $lang,
            'slug' => $slug
        ])
            ->withCount('posts')
            ->first();

        if (!$postCategory) {
            return $this->error([
                __('errors.not-founded')
            ]);
        }

        if ($postCategory->posts_count > 0) {
            return $this->error([
                __('posts.posts-count-error')
            ]);
        }

        $postCategory->delete();

        return $this->success([
            'message' => __('success.delete')
        ]);
    }
}
