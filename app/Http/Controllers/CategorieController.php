<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Services\CategorieService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategorieController extends Controller
{
    private CategorieService $categorieService;
    public function __construct(CategorieService $categorieService)
    {
        $this->categorieService = $categorieService;
    }

    /**
     * @OA\Get(
     *    path="/categorii",
     *    summary="Returneaza toate categoriile",
     *    tags={"Categorii"},
     *    description="Returneaza toate categoriile",
     *   @OA\Response(
     *        response=200,
     *        description="Success"
     *    )
     * )
     */
    public function index(): JsonResponse
    {
        $data = Categorie::all();
        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * @OA\Get(
     *    path="/categorii/{id}",
     *    summary="Returneaza categoria cu id-ul dat",
     *    tags={"Categorii"},
     *    description="Returneaza categoria cu id-ul dat",
     *    @OA\Parameter(
     *        name="id",
     *        description="Id-ul categoriei dorite",
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
        $data = Categorie::where('id', '=', $id)->firstOrFail();
        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * @OA\Put(
     *    path="/categorii",
     *    summary="Update categoria cu id-ul dat",
     *    tags={"Categorii"},
     *    description="Update categorii cu id-ul dat",
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
     *                  property="parent_id",
     *                  type="integer",
     *                  description="",
     *                  example=1,
     *              ),
     *              @OA\Property(
     *                  property="nume",
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
        $data = Categorie::where('id', '=', $request['id'])->firstOrFail();
        $this->categorieService->setProperties($data, $request->all());
        $data->save();
        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *    path="/categorii",
     *    summary="Adauga categoria",
     *    tags={"Categorii"},
     *    description="Adauga categorii",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="parent_id",
     *                  type="integer",
     *                  description="",
     *                  example=1,
     *              ),
     *              @OA\Property(
     *                  property="nume",
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
        $data = new Categorie;
        $this->categorieService->setProperties($data, $request->all());
        $data->save();
        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * @OA\Delete(
     *    path="/categorii/{id}",
     *    summary="Sterge categoria cu id-ul dat",
     *    tags={"Categorii"},
     *    description="Sterge categoria cu id-ul dat",
     *    @OA\Parameter(
     *        name="id",
     *        description="Id-ul categoriei dorite",
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
        $data = Categorie::where('id', '=', $id)->firstOrFail();
        $data->delete();
        return response()->json("DELETED", Response::HTTP_OK);
    }

    /**
     * @OA\Get(
     *    path="/categorie/carti/{id}",
     *    summary="Returneaza cartile din categoria cu id-ul dat",
     *    tags={"Categorii"},
     *    description="Returneaza cartile din categoria cu id-ul dat",
     *    @OA\Parameter(
     *        name="id",
     *        description="Id-ul categoriei dorite",
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
        $data = Categorie::where('id', '=', $id)->firstOrFail();
        $data = $data->carti()->get();

        return response()->json($data, Response::HTTP_OK);
    }
}
