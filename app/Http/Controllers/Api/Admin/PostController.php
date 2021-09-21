<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Uploader;
use App\Http\Requests\Api\Admin\Posts\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Post(
     *     path="/admin/posts/update/{slug}",
     *     operationId="update-post",
     *     tags={"Admin-Posts"},
     *     summary="Update post",
     *     security={
     *          {"bearer": {}}
     *     },
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
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UpdatePostRequest")
     *      ),
     *     @OA\Response(
     *          response=500,
     *          description="The provided slug is incorrect",
     *          @OA\JsonContent(example="Item not founded")
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
     * @param UpdatePostRequest $request
     * @return JsonResponse
     */
    public function update(UpdatePostRequest $request, $slug)
    {
        $data = $request->validated();

        $post = Post::where('slug', $slug)
            ->first();

        if (!$post) {
            return $this->error(__('errors.not-founded'), 500);
        }

        $request->validate([
            'title' => 'required|string|max:255|unique:posts,title,' . $post->id,
        ]);

        if (isset($data['image'])) {
            Uploader::deleteAttachment($post->image);
            $data['image'] = Uploader::upload('posts/images', $data['image']);
        }

        $post->update($data);

        return $this->success([
            'message' => __('success.update'),
            'post'    => $post
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @OA\Post(
     *     path="/admin/posts/delete/{slug}",
     *     operationId="delete post",
     *     tags={"Admin-Posts"},
     *     summary="Delete post by slug",
     *     description="Delete post",
     *     security={
     *          {"bearer": {}}
     *     },
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
        $post = Post::where('slug', $slug)
            ->first();

        if (!$post) {
            return $this->error(__('errors.not-founded'), 500);
        }

        Uploader::deleteAttachment($post->image);
        $post->delete();

        return $this->success([
            'message' => __('success.delete')
        ]);
    }
}
