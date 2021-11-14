<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * RegisterController constructor.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Display a listing of the resource.
     *
     * @OA\Post(
     *     path="/register",
     *     operationId="register",
     *     tags={"Auth"},
     *     summary="Registration",
     *     description="Registration by email and password",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/RegisterRequest")
     *      ),
     *     @OA\Response(
     *          response=422,
     *          description="The given data was invalid",
     *          @OA\JsonContent(example="The given data was invalid")
     *      ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *           @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Successful registration"),
     *              @OA\Property(property="token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiNTcyZmEyMzRjYTQ5ZWRjZTVjMzFkNGNhOTIxODZkOTNkNWI3NGIwNjc3MzhmMzUzNjc5Yzk4ZDJmMTI2OWI3ZmRhZDczOTA2YTY5ZjI0ZjAiLCJpYXQiOjE2Mjk0OTk0MjEuMTY2NTcxLCJuYmYiOjE2Mjk0OTk0MjEuMTY2NTc2LCJleHAiOjE2NjEwMzU0MjAuOTY4MjA4LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.pPrBL_HssMxekBRELwYs_FO7Ovfbq0oVGpH1vX1OXDTHcKzIQeOpAiivB0q5oBjW4rwRB2fcut0Tsy7JNpE3Qde9ChycGvv6UyEQPBTqIASfSCNxf0349uUlF3V5C5MMzdSb0pvSX62ajFbb3wKtlzSK2MZ22MAiuWnU7WpuLZZXBSPseZFoltjEbtXqPjChT5hEFGB_c6eA7LANRNhFs4XjRHGjrGhAW3JMB4AMu6VjDwqfF3KZm5dYMmLiu095p4io1anBYIhiH4y8YWIdSi8dqUNaCpI7CGiG6a30u2ADluvG2M4v6me01AK_tbVTFNYjFw3XHQd1JRG0Xo8_hy5-Lg4c1kWwvkUM-NYojsj5dJQ7T3IF0bMumaPrcOZcyg9pV1XNpHBdb-SBHIqtU4SjqMhQGY5JLXGrq-xJFrC6s_7T-2xZXZ5NGXXqnobfb-FkvtBsDfCfFa_iLIjJ4BTgMl4d3hLyk07pIoqrTFooTfRtejnYPEdJAAohcxBHC3LViRsEgQkX0pzfcLtadMPTTagCbnYqIA0BZQJ0rOdC62fk2yR9t2zSm7_W06nURULfM4bqwYx-PeEOj-5mXGwJktuZvJdau1WewXcawEL8q4_kMtTH9zLphFI8l5Uuq7Bf9vnaHAGfyCRmL7JBSCNM58IqA0QhcSdP8_shx14")
     *          )
     *      )
     * )
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();

        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        return $this->success([
            'message' => __('auth.registration'),
            'token' => $user->createToken('api')->accessToken,
            'user' => $user
        ]);
    }
}
