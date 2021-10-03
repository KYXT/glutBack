<?php


namespace App\Http\Controllers\Api\Dtos\Requests\Auth;

/**
 * Class RegisterRequest
 *
 * @package App\Http\Controllers\Api\Dtos\Requests\Auth
 *
 * @OA\Schema(
 *      title="LoginRequest",
 *      type="object",
 *      required={"email", "password"}
 * )
 */
class LoginRequest
{
    /**
     * @OA\Property(
     *      title="email",
     *      description="Email",
     *      example="admin@admin.com",
     *      minLength=5,
     *      maxLength=255,
     * )
     *
     * @var string
     */
    public string $email;

    /**
     * @OA\Property(
     *      title="passsword",
     *      description="Password",
     *      example="adminadmin",
     *      minLength=8,
     *      maxLength=255,
     * )
     *
     * @var string
     */
    public string $password;
}
