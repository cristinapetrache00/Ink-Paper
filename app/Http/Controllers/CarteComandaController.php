<?php

namespace App\Http\Controllers;

use App\Models\CarteComanda;
use App\Services\CarteComandaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CarteComandaController extends Controller
{
    private CarteComandaService $cartecomandaService;
    public function __construct(CarteComandaService $cartecomandaService)
    {
        $this->cartecomandaService = $cartecomandaService;
    }

    /**
     * @OA\Get(
     *    path="/carti-comanda",
     *    summary="Returneaza toate cartile comenzii",
     *    tags={"Carti-comanda"},
     *    description="Returneaza toate cartile comenzii",
     *    @OA\Response(
     *        response=200,
     *        description="Success"
     *    )
     * )
     */
    public function index(): JsonResponse
    {
        $data = CarteComanda::all();
        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * @OA\Get(
     *    path="/carti-comanda/{id}",
     *    summary="Returneaza cartea comenzii cu id-ul dat",
     *    tags={"Carti-comanda"},
     *    description="Returneaza cartea comenzii cu id-ul dat",
     *    @OA\Parameter(
     *        name="id",
     *        description="Id-ul cartii comenzii dorite",
     *        required=true,
     *        in="path",
     *        example=3,
     *        @OA\Schema(
     *            type="integer"
     *        )
     *    ),
     *    @OA\Response(
     *        response=200,
     *        description="Success"
     *    )
     * )
     */
    public function show($id): JsonResponse
    {
        $data = CarteComanda::where('id', '=', $id)->firstOrFail();
        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * @OA\Put(
     *    path="/carti-comanda",
     *    summary="Update cartea comenzii cu id-ul dat",
     *    tags={"Carti-comanda"},
     *    description="Update cartea comenzii cu id-ul dat",
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
    public function update(Request $request): JsonResponse
    {
        $data = CarteComanda::where('id', '=', $request['id'])->firstOrFail();
        $this->cartecomandaService->setProperties($data, $request->all());
        $data->save();
        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *    path="/carti-comanda",
     *    summary="Adauga cartea comenzii",
     *    tags={"Carti-comanda"},
     *    description="Adauga cartea comenzii",
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
        $data = new CarteComanda;
        $this->cartecomandaService->setProperties($data, $request->all());
        $data->save();
        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * @OA\Delete(
     *    path="/carti-comanda/{id}",
     *    summary="Sterge cartea comenzii cu id-ul dat",
     *    tags={"Carti-comanda"},
     *    description="Sterge cartea comenzii cu id-ul dat",
     *    @OA\Parameter(
     *        name="id",
     *        description="Id-ul cartii comenzii dorite",
     *        required=true,
     *        in="path",
     *        example=3,
     *        @OA\Schema(
     *            type="integer"
     *        )
     *    ),
     *    @OA\Response(
     *        response=200,
     *        description="Success"
     *    )
     * )
     */
    public function destroy($id): JsonResponse
    {
        $data = CarteComanda::where('id', '=', $id)->firstOrFail();
        $data->delete();
        return response()->json("DELETED", Response::HTTP_OK);
    }
}
