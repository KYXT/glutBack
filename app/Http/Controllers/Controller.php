<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

/**
 * Class Controller
 * @package App\Http\Controllers
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="GlutenFree documentation",
     * )
     *
     * @OA\Server(
     *      url=L5_SWAGGER_CONST_HOST,
     *      description="Demo API Server"
     * )

     *
     * @OA\Tag(
     *     name="Projects",
     *     description="API Endpoints of Projects"
     * )
     */

    /**
     * @param array $data
     * @param int $status_code
     * @return JsonResponse
     */
    public function success($data = [], $status_code = 200): JsonResponse
    {
        return response()->json($data, $status_code);
    }

    /**
     * @param array $message
     * @param int $status_code
     * @return JsonResponse
     */
    public function error($message = [], $status_code = 500): JsonResponse
    {
        !is_array($message) ? $message = [$message] : null;
        return response()->json([
            'errors' => [
                'message' => $message
            ],
            'status_code' => $status_code
        ], $status_code);
    }

}
