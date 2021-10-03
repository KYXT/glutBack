<?php


namespace App\Http\Controllers\Api\Dtos\Requests\Admin\Posts;

/**
 * Class StorePostRequest
 *
 * @package App\Http\Controllers\Api\Dtos\Requests\Admin\Posts
 *
 * @OA\Schema(
 *      title="StorePostRequest",
 *      type="object",
 *      required={"category_id", "lang", "title", "h1", "content", "image"}
 * )
 */
class StorePostRequest
{
    /**
     * @OA\Property(
     *      title="category_id",
     *      description="Posts category ID",
     *      example="1"
     * )
     *
     * @var int
     */
    public int $category_id;

    /**
     * @OA\Property(
     *      title="lang",
     *      description="language of post",
     *      example="pl"
     * )
     *
     * @var string
     */
    public string $lang;

    /**
     * @OA\Property(
     *      title="title",
     *      description="title",
     *      example="post post post",
     *      minLength=10,
     *      maxLength=255,
     * )
     *
     * @var string
     */
    public string $title;

    /**
     * @OA\Property(
     *      title="h1",
     *      description="h1",
     *      example="post post post",
     *      minLength=10,
     *      maxLength=255,
     * )
     *
     * @var string
     */
    public string $h1;

    /**
     * @OA\Property(
     *      title="content",
     *      description="content",
     *      example="this is my content wow",
     *      minLength=10,
     *      maxLength=10000,
     * )
     *
     * @var string
     */
    public string $content;

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

    /**
     * @OA\Property(
     *      title="description",
     *      description="description",
     *      example="this is my description",
     *      minLength=10,
     *      maxLength=1000,
     * )
     *
     * @var string
     */
    public string $description;

    /**
     * @OA\Property(
     *      title="keywords",
     *      description="keywords",
     *      example="test, foo, baz",
     *      minLength=10,
     *      maxLength=1000,
     * )
     *
     * @var string
     */
    public string $keywords;

    /**
     * @OA\Property(
     *      title="is_on_main",
     *      description="is_on_main",
     *      example="1"
     * )
     *
     * @var bool
     */
    public bool $is_on_main;
}
