<?php


namespace App\Http\Controllers\Api\Dtos\Requests\Auth;

/**
 * Class RegisterRequest
 *
 * @package App\Http\Controllers\Api\Dtos\Requests\Auth
 *
 * @OA\Schema(
 *      title="RegisterRequest",
 *      type="object",
 *      required={"name", "email", "password"}
 * )
 */
class RegisterRequest
{
    /**
     * @OA\Property(
     *      title="name",
     *      description="User's name",
     *      example="KYXT",
     *      minLength=3,
     *      maxLength=255,
     * )
     *
     * @var string
     */
    public string $name;

    /**
     * @OA\Property(
     *      title="email",
     *      description="User's email",
     *      example="user@user.com",
     *      minLength=5,
     *      maxLength=255,
     * )
     *
     * @var string
     */
    public string $email;

    /**
     * @OA\Property(
     *      title="password",
     *      description="User's password",
     *      example="useruser",
     *      minLength=8,
     *      maxLength=255,
     * )
     *
     * @var string
     */
    public string $password;
}
