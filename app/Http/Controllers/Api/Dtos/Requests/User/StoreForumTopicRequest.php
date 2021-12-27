<?php


namespace App\Http\Controllers\Api\Dtos\Requests\User;

/**
 * Class StoreForumTopicRequest
 *
 * @package App\Http\Controllers\Api\Dtos\Requests\User\StoreForumTopicRequest
 *
 * @OA\Schema(
 *      title="StoreForumTopicRequest",
 *      type="object",
 *      required={"category_id", "title", "text"}
 * )
 */
class StoreForumTopicRequest
{
    /**
     * @OA\Property(
     *      title="category_id",
     *      description="Forum category id",
     *      example="1"
     * )
     *
     * @var int
     */
    public int $category_id;
    
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
}
