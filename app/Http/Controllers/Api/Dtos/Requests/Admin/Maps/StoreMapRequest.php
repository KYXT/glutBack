<?php


namespace App\Http\Controllers\Api\Dtos\Requests\Admin\Maps;

/**
 * Class StoreMapRequest
 *
 * @package App\Http\Controllers\Api\Dtos\Requests\Admin\Maps
 *
 * @OA\Schema(
 *      title="StoreMapRequest",
 *      type="object",
 *      required={"lang", "name", "link"}
 * )
 */
class StoreMapRequest
{
    /**
     * @OA\Property(
     *      title="lang",
     *      description="Map language",
     *      example="pl"
     * )
     *
     * @var string
     */
    public $lang;

    /**
     * @OA\Property(
     *      title="name",
     *      description="Map name",
     *      example="Biedronka i Żabka",
     *      minLength=2,
     *      maxLength=255,
     * )
     *
     * @var string
     */
    public $name;

    /**
     * @OA\Property(
     *      title="link",
     *      description="link",
     *      example="https://www.google.com/maps/d/u/0/embed?mid=1e4Fb2C0P46izoCvA5uLGgUizJsnQ1Gbk",
     *      minLength=2,
     *      maxLength=5000,
     * )
     *
     * @var string
     */
    public $link;
}
