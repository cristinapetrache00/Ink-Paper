<?php

namespace App\Http\Controllers;

use App\Models\Returnare;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReturnareController extends Controller
{
    /**
     * @OA\Post(
     *    path="/returnari",
     *    summary="Adauga returnarea",
     *    tags={"Returnari"},
     *    description="Adauga returnarea",
     *    @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="id_carte",
     *                  type="integer",
     *                  description="",
     *                  example=1,
     *              ),
     *              @OA\Property(
     *                  property="id_comanda",
     *                  type="integer",
     *                  description="",
     *                  example=1,
     *              ),
     *              @OA\Property(
     *                  property="cantitate",
     *                  type="integer",
     *                  description="",
     *                  example=1,
     *              ),
     *              @OA\Property(
     *                  property="subtotal",
     *                  type="float",
     *                  description="",
     *                  example=1.0,
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *        response=200,
     *        description="Success"
     *     )
     * )
     */
    public function store(Request $request): JsonResponse
    {
        $data = new Returnare;

        $data->id_carte = $request->get('id_carte');
        $data->id_comanda = $request->get('id_comanda');
        $data->cantitate = $request->get('cantitate');
        $data->subtotal = $request->get('subtotal');

        $data->save();
        return response()->json($data, Response::HTTP_OK);
    }
}
