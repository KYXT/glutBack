<?php


namespace App\Http\Controllers\Api\Dtos\Requests\Admin\ProductsSubcategories;

/**
 * Class UpdateProductSubcategoryRequest
 *
 * @package App\Http\Controllers\Api\Dtos\Requests\Admin\ProductsSubcategories
 *
 * @OA\Schema(
 *      title="UpdateProductSubcategoryRequest",
 *      type="object",
 *      required={"name"}
 * )
 */
class UpdateProductSubcategoryRequest
{
    /**
     * @OA\Property(
     *      title="category_id",
     *      description="Id of products category",
     *      example="1",
     * )
     *
     * @var int
     */
    public int $category_id;

    /**
     * @OA\Property(
     *      title="name",
     *      description="Name of products subcategory",
     *      example="Jogurt",
     *      minLength=2,
     *      maxLength=180,
     * )
     *
     * @var string
     */
    public string $name;
}
