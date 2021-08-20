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
     *     summary="Authorization",
     *     description="Authorization using email and password",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/LoginRequest")
     *      ),
     *     @OA\Response(
     *          response=401,
     *          description="The provided password is incorrect",
     *          @OA\JsonContent(example="The provided password is incorrect.")
     *      ),
     *     @OA\Response(
     *          response=422,
     *          description="The selected email is invalid",
     *          @OA\JsonContent(example="The selected email is invalid.")
     *      ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiNTcyZmEyMzRjYTQ5ZWRjZTVjMzFkNGNhOTIxODZkOTNkNWI3NGIwNjc3MzhmMzUzNjc5Yzk4ZDJmMTI2OWI3ZmRhZDczOTA2YTY5ZjI0ZjAiLCJpYXQiOjE2Mjk0OTk0MjEuMTY2NTcxLCJuYmYiOjE2Mjk0OTk0MjEuMTY2NTc2LCJleHAiOjE2NjEwMzU0MjAuOTY4MjA4LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.pPrBL_HssMxekBRELwYs_FO7Ovfbq0oVGpH1vX1OXDTHcKzIQeOpAiivB0q5oBjW4rwRB2fcut0Tsy7JNpE3Qde9ChycGvv6UyEQPBTqIASfSCNxf0349uUlF3V5C5MMzdSb0pvSX62ajFbb3wKtlzSK2MZ22MAiuWnU7WpuLZZXBSPseZFoltjEbtXqPjChT5hEFGB_c6eA7LANRNhFs4XjRHGjrGhAW3JMB4AMu6VjDwqfF3KZm5dYMmLiu095p4io1anBYIhiH4y8YWIdSi8dqUNaCpI7CGiG6a30u2ADluvG2M4v6me01AK_tbVTFNYjFw3XHQd1JRG0Xo8_hy5-Lg4c1kWwvkUM-NYojsj5dJQ7T3IF0bMumaPrcOZcyg9pV1XNpHBdb-SBHIqtU4SjqMhQGY5JLXGrq-xJFrC6s_7T-2xZXZ5NGXXqnobfb-FkvtBsDfCfFa_iLIjJ4BTgMl4d3hLyk07pIoqrTFooTfRtejnYPEdJAAohcxBHC3LViRsEgQkX0pzfcLtadMPTTagCbnYqIA0BZQJ0rOdC62fk2yR9t2zSm7_W06nURULfM4bqwYx-PeEOj-5mXGwJktuZvJdau1WewXcawEL8q4_kMtTH9zLphFI8l5Uuq7Bf9vnaHAGfyCRmL7JBSCNM58IqA0QhcSdP8_shx14")
     *          )
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
     *     summary="Logout",
     *     security={
     *          {"bearer": {}}
     *     },
     *     @OA\Response(
     *          response=500,
     *          description="Active user session not founded",
     *          @OA\JsonContent(example="Active user session not founded")
     *      ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(example="Success logout")
     *      )
     * )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        if (!$this->api_guard()->check()) {
            return $this->error(__('auth.logout-error'));
        }

        $request->user('api')->token()->revoke();

        Auth::guard()->logout();

        Session::flush();
        Session::regenerate();

        return $this->success([
            'message' => __('auth.logout')
        ]);
    }

    /**
     * @return Guard|StatefulGuard
     */
    public function api_guard()
    {
        return Auth::guard('api');
    }
}
