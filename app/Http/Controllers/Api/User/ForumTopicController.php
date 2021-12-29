<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\ForumTopics\StoreForumTopicRequest;
use App\Http\Requests\Api\User\ForumTopics\UpdateForumTopicRequest;
use App\Models\ForumCategory;
use App\Models\ForumTopic;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class ForumTopicController extends Controller
{
    /**
     * Store forum topic
     *
     * @OA\Post(
     *     path="/user/forum-topics/store/{categoryId}",
     *     operationId="store-forum-topic",
     *     tags={"User-Forum-Topics"},
     *     summary="Create forum topic",
     *     security={
     *          {"bearer": {}}
     *     },
     *     @OA\Parameter(
     *          name="categoryId",
     *          description="Forum's category Id",
     *          required=true,
     *          in="path",
     *          example="123",
     *          @OA\Schema(
     *              type="int"
     *          )
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StoreForumTopicRequest")
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
     * @param StoreForumTopicRequest $request
     * @param $categoryId
     * @return JsonResponse
     */
    public function store(StoreForumTopicRequest $request, $categoryId)
    {
        $forumCategory = ForumCategory::where('id', $categoryId)
            ->first();
    
        if (!$forumCategory) {
            return $this->error(__('errors.not-founded'));
        }
        
        $data = $request->validated();
        $lang = App::getLocale();
    
        if ($lang != $forumCategory['lang']) {
            return $this->error(__('forum.topic-category-lang'));
        }
        
        $data['user_id'] = Auth::id();
        $data['category_id'] = $categoryId;

        $forumTopic = ForumTopic::create($data);
        $forumTopic->load('category');
    
        return $this->success([
            'forumTopic' =>  $forumTopic
        ]);
    }
    
    /**
     * Update forum topic
     *
     * @OA\Post(
     *     path="/user/forum-topics/update/{id}",
     *     operationId="update-forum-topic",
     *     tags={"User-Forum-Topics"},
     *     summary="Update forum topic",
     *     security={
     *          {"bearer": {}}
     *     },
     *     @OA\Parameter(
     *          name="id",
     *          description="Forum's topic id",
     *          required=true,
     *          in="path",
     *          example="123",
     *          @OA\Schema(
     *              type="int"
     *          )
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UpdateForumTopicRequest")
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
     * @param UpdateForumTopicRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(UpdateForumTopicRequest $request, $id)
    {
        $forumTopic = ForumTopic::where('id', $id)
            ->with('category')
            ->first();
    
        if (!$forumTopic) {
            return $this->error(__('errors.not-founded'));
        }
        
        $user = Auth::user();
        if (!$user->isAdmin() && !$user->isCreator() && !$user->isModerator() && $user->id != $forumTopic->user_id) {
            return $this->error(__('forum.user'));
        }        
        
        $data = $request->validated();
        $forumTopic->update($data);
    
        return $this->success([
            'forumTopic' =>  $forumTopic
        ]);
    }
    
    /**
     * Update forum topic
     *
     * @OA\Post(
     *     path="/user/forum-topics/delete/{id}",
     *     operationId="delete-forum-topic",
     *     tags={"User-Forum-Topics"},
     *     summary="Delete forum topic",
     *     security={
     *          {"bearer": {}}
     *     },
     *     @OA\Parameter(
     *          name="id",
     *          description="Forum's topic id",
     *          required=true,
     *          in="path",
     *          example="123",
     *          @OA\Schema(
     *              type="int"
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Successfully created")
     *          )
     *      )
     * )
     *
     * @param $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        $forumTopic = ForumTopic::where('id', $id)
            ->withCount('messages')
            ->first();
    
        if (!$forumTopic) {
            return $this->error(__('errors.not-founded'));
        }
    
        $user = Auth::user();
        if (!$user->isAdmin() && !$user->isCreator() && !$user->isModerator() && $user->id != $forumTopic->user_id) {
            return $this->error(__('forum.user'));
        }
        
        if ($user->isUser()) {
            if ($forumTopic->messages_count == 0) {
                $forumTopic->delete();
            }
        } else {
            $forumTopic->messages()->delete();
            $forumTopic->delete();
        }
    
        return $this->success([
            'message' => __('success.delete'),
        ]);
    }
}
