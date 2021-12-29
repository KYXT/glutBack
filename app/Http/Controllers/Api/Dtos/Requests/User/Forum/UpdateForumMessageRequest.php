<?php


namespace App\Http\Controllers\Api\Dtos\Requests\User\Forum;

/**
 * Class UpdateForumMessageRequest
 *
 * @package App\Http\Controllers\Api\Dtos\Requests\User\Forum\UpdateForumMessageRequest
 *
 * @OA\Schema(
 *      title="UpdateForumMessageRequest",
 *      type="object",
 *      required={"text"}
 * )
 */
class UpdateForumMessageRequest
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
}
