<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\ForumTopics\StoreForumTopicRequest;
use App\Models\ForumCategory;
use App\Models\ForumTopic;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class ForumTopicController extends Controller
{
    /**
     * Store posts category
     *
     * @OA\Post(
     *     path="/user/forum-topics/store",
     *     operationId="store-forum-topic",
     *     tags={"User-Forum-topics"},
     *     summary="Create forum topic",
     *     security={
     *          {"bearer": {}}
     *     },
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
     * @param StoreForumCategoryRequest $request
     * @return JsonResponse
     */
    public function store(StoreForumTopicRequest $request)
    {
        $data = $request->validated();
        
        $lang = App::getLocale();
        
        $forumCategory = ForumCategory::where('id', $data['category_id'])
            ->first();
    
        if (!$forumCategory) {
            return $this->error(__('errors.not-founded'));
        }
    
        if ($lang != $forumCategory['lang']) {
            return $this->error(__('forum.topic-category-lang'));
        }
        
        $data['user_id'] = Auth::id();
        $forumTopic = ForumTopic::create($data);
    
        return $this->success([
            'forumTopic' =>  $forumTopic
        ]);
    }
}
