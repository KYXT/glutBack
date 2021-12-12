<?php


namespace App\Http\Controllers\Api\Dtos\Requests\Admin\ForumCategories;

/**
 * Class StorePostCategoryRequest
 *
 * @package App\Http\Controllers\Api\Dtos\Requests\Admin\ForumCategories
 *
 * @OA\Schema(
 *      title="StoreForumCategoryRequest",
 *      type="object",
 *      required={"name"}
 * )
 */
class StoreForumCategoryRequest
{
    /**
     * @OA\Property(
     *      title="name",
     *      description="Name of forum category",
     *      example="Leki"
     * )
     *
     * @var string
     */
    public string $name;
}
