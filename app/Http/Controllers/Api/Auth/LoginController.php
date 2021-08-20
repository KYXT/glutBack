<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

/**
 * Class LoginController
 * @package App\Http\Controllers\Api
 */
class LoginController extends Controller
{
    /**
     * LoginController constructor.
     */
    public function __construct()
    {
        $this->middleware('guest')
            ->except('logout');
    }

    /**
     * Display a listing of the resource.
     *
     * @OA\Post(
     *     path="/login",
     *     operationId="login",
     *     tags={"Auth"},
     *     summary="Авторизация",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/LoginRequest")
     *      ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *      )
     * )
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $data = $request->validated();

        $user = User::where('email', $data['email'])
            ->first();

        if (!Hash::check($data['password'], $user->password)) {
            return $this->error(__('auth.password'), 401);
        }

        Auth::login($user);

        return $this->success([
            'token' => $user->createToken('api')->accessToken
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @OA\Post(
     *     path="/logout",
     *     operationId="logout",
     *     tags={"Auth"},
     *     summary="Выход",
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *      )
     * )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        if (!$this->api_guard()->check()) {
            return $this->error('Active user session not founded');
        }

        $request->user('api')->token()->revoke();

        Auth::guard()->logout();

        Session::flush();
        Session::regenerate();

        return $this->success('Success logout');
    }

    /**
     * @return Guard|StatefulGuard
     */
    public function api_guard()
    {
        return Auth::guard('api');
    }
}
