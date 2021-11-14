<?php


namespace App\Http\Controllers\Api\Dtos\Requests\Admin\ProductsCategories;

/**
 * Class UpdateProductCategoryRequest
 *
 * @package App\Http\Controllers\Api\Dtos\Requests\Admin\ProductsCategories
 *
 * @OA\Schema(
 *      title="UpdateProductCategoryRequest",
 *      type="object",
 *      required={"name"}
 * )
 */
class UpdateProductCategoryRequest
{
    /**
     * @OA\Property(
     *      title="name",
     *      description="Name of products category",
     *      example="Produkty mleczne",
     *      minLength=2,
     *      maxLength=180,
     * )
     *
     * @var string
     */
    public string $name;

    /**
     * @OA\Property(
     *      title="image",
     *      description="image",
     *      example="Image file"
     * )
     *
     * @var string
     */
    public string $image;
}
