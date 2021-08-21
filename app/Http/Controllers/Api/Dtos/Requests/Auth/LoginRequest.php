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
     *      example="admin@admin.com"
     * )
     *
     * @var string
     */
    public string $email;

    /**
     * @OA\Property(
     *      title="passsword",
     *      description="Password",
     *      example="adminadmin"
     * )
     *
     * @var string
     */
    public string $password;
}
