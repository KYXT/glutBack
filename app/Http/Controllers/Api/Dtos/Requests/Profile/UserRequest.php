<?php


namespace App\Http\Controllers\Api\Dtos\Requests\Profile;

/**
 * Class UserRequest
 *
 * @package App\Http\Controllers\Api\Dtos\Requests\Profile
 *
 * @OA\Schema(
 *      title="UserRequest",
 *      type="object",
 * )
 */
class UserRequest
{
    /**
     * @OA\Property(
     *      title="name",
     *      description="name",
     *      example="Peter"
     * )
     *
     * @var string
     */
    public string $name;

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
     *      title="email_verified_at",
     *      description="Time whe email was verified",
     *      example="2021-08-21T00:07:55.000000Z"
     * )
     *
     * @var string
     */
    public string $email_verified_at;

    /**
     * @OA\Property(
     *      title="Role",
     *      description="User's role",
     *      example="1"
     * )
     *
     * @var int
     */
    public int $role;

    /**
     * @OA\Property(
     *      title="created_at",
     *      description="Time whe uese was created",
     *      example="2021-08-21T00:07:55.000000Z"
     * )
     *
     * @var string
     */
    public string $created_at;

    /**
     * @OA\Property(
     *      title="updated_at",
     *      description="Time whe uese was updated",
     *      example="2021-08-21T00:07:55.000000Z"
     * )
     *
     * @var string
     */
    public string $updated_at;
}
