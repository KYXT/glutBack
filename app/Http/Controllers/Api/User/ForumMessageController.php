<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\ForumMessages\StoreForumMessageRequest;
use App\Models\ForumMessage;
use App\Models\ForumTopic;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ForumMessageController extends Controller
{
    /**
     * Store forum message
     *
     * @OA\Post(
     *     path="/user/forum-messages/store/{topicId}",
     *     operationId="store-forum-message",
     *     tags={"User-Forum-Messages"},
     *     summary="Create forum message",
     *     description="Create forum message inside topic",
     *     security={
     *          {"bearer": {}}
     *     },
     *     @OA\Parameter(
     *          name="topicId",
     *          description="Forum's topic Id",
     *          required=true,
     *          in="path",
     *          example="123",
     *          @OA\Schema(
     *              type="int"
     *          )
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StoreForumMessageRequest")
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
     * @param StoreForumMessageRequest $request
     * @param $topicId
     * @return JsonResponse
     */
    public function store(StoreForumMessageRequest $request, $topicId)
    {
        $forumTopic = ForumTopic::where('id', $topicId)
            ->first();
    
        if (!$forumTopic) {
            return $this->error(__('errors.not-founded'));
        }
        
        if (!$forumTopic['is_open']) {
            return $this->error(__('forum.closed-topic'));
        }
        
        $data = $request->validated();
        
        if (isset($data['reply_id'])) {
            $repliedMessage = ForumMessage::where('id', $data['reply_id'])
                ->first();
    
            if (!$repliedMessage) {
                return $this->error(__('errors.not-founded'));
            }
            
            if ($repliedMessage['topic_id'] != $topicId) {
                return $this->error(__('forum.reply-error'));
            }
        }
        
        $data['user_id'] = Auth::id();
        $data['topic_id'] = $topicId;
        
        $forumMessage = ForumMessage::create($data);
        $forumMessage->load('user');
    
        return $this->success([
            'forumMessage' =>  $forumMessage
        ]);
    }
}
