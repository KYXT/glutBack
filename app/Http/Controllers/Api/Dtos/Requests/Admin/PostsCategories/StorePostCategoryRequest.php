<?php


namespace App\Http\Controllers\Api\Dtos\Requests\Admin\PostsCategories;

/**
 * Class StorePostCategoryRequest
 *
 * @package App\Http\Controllers\Api\Dtos\Requests\Admin\PostsCategories
 *
 * @OA\Schema(
 *      title="StorePostCategoryRequest",
 *      type="object",
 *      required={"name"}
 * )
 */
class StorePostCategoryRequest
{
    /**
     * @OA\Property(
     *      title="name",
     *      description="Name of posts category",
     *      example="Aktualności"
     * )
     *
     * @var string
     */
    public string $name;
}
