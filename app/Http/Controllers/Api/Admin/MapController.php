<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\Maps\StoreMapRequest;
use App\Models\Map;

class MapController extends Controller
{
    /**
     * Create map.
     *
     * @OA\Post(
     *     path="/admin/maps/store",
     *     operationId="maps-store",
     *     tags={"Admin-Maps"},
     *     summary="Create map",
     *     description="",
     *     security={
     *          {"bearer": {}}
     *     },
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StoreMapRequest")
     *      ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Successfully created")
     *          )
     *      )
     * )
     *
     * @param StoreMapRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreMapRequest $request)
    {
        $data = $request->validated();

        $map = Map::create($data);

        return $this->success([
            'message'   => __('success.create'),
            'map'       => $map
        ]);
    }

    /**
     * Update map.
     *
     * @OA\Post(
     *     path="/admin/maps/update/{id}",
     *     operationId="maps-update",
     *     tags={"Admin-Maps"},
     *     summary="Update map",
     *     description="Update map by id",
     *     security={
     *          {"bearer": {}}
     *     },
     *    @OA\Parameter(
     *          name="id",
     *          description="Map id",
     *          required=true,
     *          in="path",
     *          example="1",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StoreMapRequest")
     *      ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Successfully updated")
     *          )
     *      )
     * )
     *
     * @param StoreMapRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(StoreMapRequest $request, $id)
    {
        $map = Map::where('id', $id)
            ->first();

        if (!$map) {
            return $this->error([
                __('errors.not-founded')
            ]);
        }

        $data = $request->validated();
        $map = Map::create($data);

        return $this->success([
            'message'   => __('success.update'),
            'map'       => $map
        ]);
    }
}
