<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ForumCategory;
use App\Models\ForumMessage;
use App\Models\ForumTopic;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;

class ForumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/forum/categories",
     *     operationId="forum-categories",
     *     tags={"Forum-Categories"},
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
    public function indexCategory()
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
     *     path="/forum/categories/{slug}",
     *     operationId="show forum category",
     *     tags={"Forum-Categories"},
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
    public function showCategory($slug)
    {
        $lang = App::getLocale();
    
        $forumCategory = ForumCategory::where([
            ['slug', $slug],
            ['lang', $lang]
        ])
            ->with('topics.user')
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
    
    /**
     * Show forum's topic with messages.
     *
     * @OA\Get(
     *     path="/forum/topics",
     *     operationId="index-forum-topic",
     *     tags={"Forum-Topics"},
     *     summary="Get forum topics",
     *     description="Return forum topic with messages count paginated by 12",
     *     @OA\Parameter(
     *          name="id",
     *          description="Forum topic's id",
     *          required=true,
     *          in="path",
     *          example="1",
     *          @OA\Schema(
     *              type="int"
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(example="Forum topics")
     *      )
     * )
     *
     * @return JsonResponse
     */
    public function indexTopic()
    {
        $lang = App::getLocale();
        
        $forumTopics = ForumTopic::orderBy('created_at', 'desc')
            ->with(['user', 'category' => function ($q) use ($lang) {
                $q->where('lang', $lang);
            }])
            ->withCount('messages')
            ->paginate(12);
    
        return $this->success([
            'forumTopics'  => $forumTopics
        ]);
    }
    
    /**
     * Show forum's topic with messages.
     *
     * @OA\Get(
     *     path="/forum/topics/{id}",
     *     operationId="show-forum-topic",
     *     tags={"Forum-Topics"},
     *     summary="Get forum topic by id",
     *     description="Return forum topic with messages paginated by 12",
     *     @OA\Parameter(
     *          name="id",
     *          description="Forum topic's id",
     *          required=true,
     *          in="path",
     *          example="1",
     *          @OA\Schema(
     *              type="int"
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(example="Forum topic with messages")
     *      ),
     *     @OA\Response(
     *          response=500,
     *          description="Item not founded",
     *          @OA\JsonContent(example="Item not founded")
     *      ),
     * )
     *
     * @param $id
     * @return JsonResponse
     */
    public function showTopic($id)
    {
        $forumTopic = ForumTopic::where('id', $id)
            ->with('user:id,name,email,role')    
            ->first();
    
        if (!$forumTopic) {
            return $this->error([
                __('errors.not-founded')
            ]);
        }
        
        $forumMessages = ForumMessage::where([
            'reply_id' => null,
            'topic_id' => $id
        ])
            ->with('replies', 'user:id,name,email,role')
            ->orderBy('created_at')
            ->paginate(12);
    
        return $this->success([
            'forum-topic'       => $forumTopic,
            'forum-messages'    => $forumMessages    
        ]);
    }
}
