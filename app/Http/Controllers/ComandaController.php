<?php

namespace App\Http\Controllers;

use App\Models\Comanda;
use App\Services\ComandaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ComandaController extends Controller
{
    private ComandaService $comandaService;
    public function __construct(ComandaService $comandaService)
    {
        $this->comandaService = $comandaService;
    }

    /**
     * @OA\Get(
     *    path="/comenzi",
     *    summary="Returneaza toate comenzile",
     *    tags={"Clienti"},
     *    description="Returneaza toate comenzile",
     *   @OA\Response(
     *        response=200,
     *        description="Success"
     *    )
     * )
     */
    public function index(): JsonResponse
    {
        $data = Comanda::all();
        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * @OA\Get(
     *    path="/comenzi/{id}",
     *    summary="Returneaza comanda cu id-ul dat",
     *    tags={"Comenzi"},
     *    description="Returneaza comanda cu id-ul dat",
     *    @OA\Parameter(
     *        name="id",
     *        description="Id-ul comenzii dorite",
     *        required=true,
     *        in="path",
     *        example=3,
     *        @OA\Schema(
     *            type="integer"
     *        )
     *    ),
     *   @OA\Response(
     *        response=200,
     *        description="Success"
     *    )
     * )
     */
    public function show($id): JsonResponse
    {
        $data = Comanda::where('id', '=', $id)->firstOrFail();
        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * @OA\Put(
     *    path="/comenzi",
     *    summary="Update comanda cu id-ul dat",
     *    tags={"Comenzi"},
     *    description="Update comanda cu id-ul dat",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="id",
     *                  type="integer",
     *                  description="",
     *                  example=1,
     *              ),
     *              @OA\Property(
     *                  property="id_client",
     *                  type="integer",
     *                  description="",
     *                  example=1,
     *              ),
     *              @OA\Property(
     *                  property="tip",
     *                  type="string",
     *                  description="",
     *                  example=1,
     *              ),
     *              @OA\Property(
     *                  property="data_plasare",
     *                  type="date",
     *                  description="",
     *                  example="",
     *              ),
     *              @OA\Property(
     *                  property="data_livrare",
     *                  type="date",
     *                  description="",
     *                  example="",
     *              ),
     *              @OA\Property(
     *                  property="data_predare",
     *                  type="date",
     *                  description="",
     *                  example="",
     *              ),
     *              @OA\Property(
     *                  property="pret_comanda",
     *                  type="float",
     *                  description="",
     *                  example=1,
     *              ),
     *              @OA\Property(
     *                  property="adresa_livrare",
     *                  type="string",
     *                  description="",
     *                  example="",
     *              ),
     *              @OA\Property(
     *                  property="oras_livrare",
     *                  type="string",
     *                  description="",
     *                  example="",
     *              ),
     *              @OA\Property(
     *                  property="judet_livrare",
     *                  type="string",
     *                  description="",
     *                  example="",
     *              ),
     *               @OA\Property(
     *                  property="status",
     *                  type="string",
     *                  description="",
     *                  example="",
     *              ),
     *              @OA\Property(
     *                  property="metoda_plata",
     *                  type="string",
     *                  description="",
     *                  example="",
     *              )
     *          )
     *     ),
     *   @OA\Response(
     *        response=200,
     *        description="Success"
     *    )
     * )
     */
    public function update(Request $request): JsonResponse
    {
        $data = Comanda::where('id', '=', $request['id'])->firstOrFail();
        $this->comandaService->setProperties($data, $request->all());
        $data->save();
        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *    path="/comenzi",
     *    summary="Adauga comanda",
     *    tags={"Comenzi"},
     *    description="Adauga comanda",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="id_client",
     *                  type="integer",
     *                  description="",
     *                  example=1,
     *              ),
     *              @OA\Property(
     *                  property="tip",
     *                  type="string",
     *                  description="",
     *                  example=1,
     *              ),
     *              @OA\Property(
     *                  property="data_plasare",
     *                  type="date",
     *                  description="",
     *                  example="",
     *              ),
     *              @OA\Property(
     *                  property="data_livrare",
     *                  type="date",
     *                  description="",
     *                  example="",
     *              ),
     *              @OA\Property(
     *                  property="data_predare",
     *                  type="date",
     *                  description="",
     *                  example="",
     *              ),
     *              @OA\Property(
     *                  property="pret_comanda",
     *                  type="float",
     *                  description="",
     *                  example=1,
     *              ),
     *              @OA\Property(
     *                  property="adresa_livrare",
     *                  type="string",
     *                  description="",
     *                  example="",
     *              ),
     *              @OA\Property(
     *                  property="oras_livrare",
     *                  type="string",
     *                  description="",
     *                  example="",
     *              ),
     *              @OA\Property(
     *                  property="judet_livrare",
     *                  type="string",
     *                  description="",
     *                  example="",
     *              ),
     *               @OA\Property(
     *                  property="status",
     *                  type="string",
     *                  description="",
     *                  example="",
     *              ),
     *              @OA\Property(
     *                  property="metoda_plata",
     *                  type="string",
     *                  description="",
     *                  example="",
     *              )
     *          )
     *     ),
     *   @OA\Response(
     *        response=200,
     *        description="Success"
     *    )
     * )
     */
    public function store(Request $request): JsonResponse
    {
        $data = new Comanda;
        $this->comandaService->setProperties($data, $request->all());
        $data->save();
        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * @OA\Delete(
     *    path="/comenzi/{id}",
     *    summary="Sterge comanda cu id-ul dat",
     *    tags={"Comenzi"},
     *    description="Sterge comanda cu id-ul dat",
     *    @OA\Parameter(
     *        name="id",
     *        description="Id-ul comenzii dorite",
     *        required=true,
     *        in="path",
     *        example=3,
     *        @OA\Schema(
     *            type="integer"
     *        )
     *    ),
     *   @OA\Response(
     *        response=200,
     *        description="Success"
     *    )
     * )
     */
    public function destroy($id): JsonResponse
    {
        $data = Comanda::where('id', '=', $id)->firstOrFail();
        $data->delete();
        return response()->json("DELETED", Response::HTTP_OK);
    }

    /**
     * @OA\Get(
     *    path="/comenzi/carti/{id}",
     *    summary="Returneaza cartile din comanda cu id-ul dat",
     *    tags={"Comenzi"},
     *    description="Returneaza cartile din comanda cu id-ul dat",
     *    @OA\Parameter(
     *        name="id",
     *        description="Id-ul comenzii dorite",
     *        required=true,
     *        in="path",
     *        example=3,
     *        @OA\Schema(
     *            type="integer"
     *        )
     *    ),
     *   @OA\Response(
     *        response=200,
     *        description="Success"
     *    )
     * )
     */
    public function carti($id): JsonResponse
    {
        $data = Comanda::where('id', '=', $id)->firstOrFail();
        $data = $data->carti()->get();

        return response()->json($data, Response::HTTP_OK);
    }
}
