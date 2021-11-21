<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Map;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;

class MapController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/maps",
     *     operationId="maps-get",
     *     tags={"Maps"},
     *     summary="Get all maps",
     *     description="Change Content-Language header to change language from default",
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(example="List of maps.")
     *      )
     * )
     *
     * @return JsonResponse
     */
    public function index()
    {
        $lang = App::getLocale();

        $maps = Map::where('lang', $lang)
            ->orderBy('name')
            ->get();

        return $this->success([
            'maps'  => $maps
        ]);
    }
}
