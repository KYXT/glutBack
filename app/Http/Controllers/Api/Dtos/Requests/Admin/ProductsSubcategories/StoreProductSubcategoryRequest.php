<?php


namespace App\Http\Controllers\Api\Dtos\Requests\Admin\ProductsSubcategories;

/**
 * Class StoreProductSubcategoryRequest
 *
 * @package App\Http\Controllers\Api\Dtos\Requests\Admin\ProductsSubcategories
 *
 * @OA\Schema(
 *      title="StoreProductSubcategoryRequest",
 *      type="object",
 *      required={"category_id", "name"}
 * )
 */
class StoreProductSubcategoryRequest
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
