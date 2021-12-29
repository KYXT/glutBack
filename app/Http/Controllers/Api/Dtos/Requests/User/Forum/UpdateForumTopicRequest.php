<?php


namespace App\Http\Controllers\Api\Dtos\Requests\User\Forum;

/**
 * Class UpdateForumTopicRequest
 *
 * @package App\Http\Controllers\Api\Dtos\Requests\User\Forum\UpdateForumTopicRequest
 *
 * @OA\Schema(
 *      title="UpdateForumTopicRequest",
 *      type="object",
 *      required={"title", "text", "is_open"}
 * )
 */
class UpdateForumTopicRequest
{   
    /**
     * @OA\Property(
     *      title="title",
     *      description="Title of user's topic (question)",
     *      example="Ktoś zna gdzie kupić leki?",
     *      minLength=10,
     *      maxLength=255,
     * )
     *
     * @var string
     */
    public string $title;
    
    /**
     * @OA\Property(
     *      title="text",
     *      description="Text of user's topic (question)",
     *      example="Szukam pomocy, nie mogę znaleźć lek xxx, czy ktoś kiedyś go kupował?",
     *      minLength=10,
     *      maxLength=2000,
     * )
     *
     * @var string
     */
    public string $text;
    
    /**
     * @OA\Property(
     *      title="is_open",
     *      description="Open\close topic for edit and add messages. Boolean",
     *      example="1",
     * )
     *
     * @var string
     */
    public bool $is_open;
}
