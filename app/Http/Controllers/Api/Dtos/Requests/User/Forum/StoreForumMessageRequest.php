<?php


namespace App\Http\Controllers\Api\Dtos\Requests\User\Forum;

/**
 * Class StoreForumMessageRequest
 *
 * @package App\Http\Controllers\Api\Dtos\Requests\User\Forum\StoreForumMessageRequest
 *
 * @OA\Schema(
 *      title="StoreForumMessageRequest",
 *      type="object",
 *      required={"text"}
 * )
 */
class StoreForumMessageRequest
{      
    /**
     * @OA\Property(
     *      title="text",
     *      description="Text of user's message (question)",
     *      example="Tak, kupowałem ten lek wczesniej tydzień temu w aptece yyy",
     *      minLength=10,
     *      maxLength=2000,
     * )
     *
     * @var string
     */
    public string $text;
    
    /**
     * @OA\Property(
     *      title="reply_id",
     *      description="Message id replied on",
     *      example="2",
     * )
     *
     * @var string
     */
    public int $reply_id;
}
