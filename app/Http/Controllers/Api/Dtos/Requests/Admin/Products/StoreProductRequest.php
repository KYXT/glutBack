<?php


namespace App\Http\Controllers\Api\Dtos\Requests\Admin\Products;

/**
 * Class StorePostRequest
 *
 * @package App\Http\Controllers\Api\Dtos\Requests\Admin\Products
 *
 * @OA\Schema(
 *      title="StorePostRequest",
 *      type="object",
 *      required={"subcategory_id", "map_id", "lang", "name", "images"}
 * )
 */
class StoreProductRequest
{
    /**
     * @OA\Property(
     *      title="subcategory_id",
     *      description="Products subcategory ID",
     *      example="1"
     * )
     *
     * @var int
     */
    public $subcategory_id;

    /**
     * @OA\Property(
     *      title="map_id",
     *      description="Products map ID",
     *      example="1"
     * )
     *
     * @var int
     */
    public $map_id;

    /**
     * @OA\Property(
     *      title="lang",
     *      description="language of post",
     *      example="pl"
     * )
     *
     * @var string
     */
    public $lang;

    /**
     * @OA\Property(
     *      title="name",
     *      description="name",
     *      example="Chleb",
     *      minLength=1,
     *      maxLength=255,
     * )
     *
     * @var string
     */
    public $name;

    /**
     * @OA\Property(
     *      title="description",
     *      description="product description",
     *      example="Вкусный хлеб",
     *      minLength=1,
     *      maxLength=10000,
     * )
     *
     * @var string
     */
    public $description;

    /**
     * @OA\Property(
     *      title="maker",
     *      description="product maker",
     *      example="Гродненский хлебозавод",
     *      minLength=1,
     *      maxLength=255,
     * )
     *
     * @var string
     */
    public $maker;

    /**
     * @OA\Property(
     *      title="images",
     *      description="array of images",
     *      example="['image' => image, 'is_main' => 1]"
     * )
     *
     * @var string
     */
    public $images;
}
