<?php
namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserController
 * @package App\Http\Controllers\Api
 */
class UserController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function user(): JsonResponse
    {
        return $this->success([
            'user' => Auth::guard('api')->user()
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function allUsers(): JsonResponse
    {
        $users = User::all();
        return $this->success([
            'users' => $users
        ]);
    }
}
