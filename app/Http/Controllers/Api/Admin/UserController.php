<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/admin/users",
     *     operationId="get-all-users",
     *     tags={"Admin"},
     *     summary="Get all users",
     *     description="Get all users from system by Bearer token. Only for admins. Paginate by 20.",
     *     security={
     *          {"bearer": {}}
     *     },
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(example="List of users with pagination")
     *      )
     * )
     *
     * @return JsonResponse
     */
    public function all(): JsonResponse
    {
        $users = User::orderBy('created_at')
            ->paginate(20);

        return $this->success([
            'users' => $users
        ]);
    }
}
