<?php
namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

/**
 * Class UserController
 * @package App\Http\Controllers\Api
 */
class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/user",
     *     operationId="get-user",
     *     tags={"User"},
     *     summary="Get user",
     *     description="Get user by Bearer token.",
     *     security={
     *          {"bearer": {}}
     *     },
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/UserRequest"),
     *         )
     *      )
     * )
     *
     * @return JsonResponse
     */
    public function user(): JsonResponse
    {
        $user = Auth::guard('api')->user();

        if ($user) {
            $user->makeHidden('id');
        }

        return $this->success([
            'user' => Auth::guard('api')->user()
        ]);
    }

}
