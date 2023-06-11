<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Services\ReviewService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReviewController extends Controller
{
    private ReviewService $reviewService;
    public function __construct(ReviewService $reviewService)
    {
        $this->reviewService = $reviewService;
    }

    /**
     * @OA\Get(
     *    path="/reviewuri",
     *    summary="Returneaza toate review-urile",
     *    tags={"Review-uri"},
     *    description="Returneaza toate review-urile",
     *    @OA\Response(
     *        response=200,
     *        description="Success"
     *    )
     * )
     */
    public function index(): JsonResponse
    {
        $data = Review::all();
        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * @OA\Get(
     *    path="/reviewuri/{id}",
     *    summary="Returneaza review-ul cu id-ul dat",
     *    tags={"Review-uri"},
     *    description="Returneaza review-ul cu id-ul dat",
     *    @OA\Parameter(
     *        name="id",
     *        description="Id-ul review-ului dorit",
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
        $data = Review::where('id', '=', $id)->firstOrFail();
        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * @OA\Put(
     *    path="/reviewuri",
     *    summary="Update review-ul cu id-ul dat",
     *    tags={"Review-uri"},
     *    description="Update review-ul cu id-ul dat",
     *    @OA\RequestBody(
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
     *                  property="id_carte",
     *                  type="integer",
     *                  description="",
     *                  example=1,
     *              ),
     *              @OA\Property(
     *                  property="comentariu",
     *                  type="string",
     *                  description="",
     *                  example="",
     *              ),
     *              @OA\Property(
     *                  property="rating",
     *                  type="float",
     *                  description="",
     *                  example=1.0,
     *              ),
     *              @OA\Property(
     *                  property="data_review",
     *                  type="date",
     *                  description="",
     *                  example="",
     *              ),
     *              @OA\Property(
     *                  property="titlu",
     *                  type="string",
     *                  description="",
     *                  example="",
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
        $data = Review::where('id', '=', $request['id'])->firstOrFail();
        $this->reviewService->setProperties($data, $request->all());
        $data->save();
        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *    path="/reviewuri",
     *    summary="Adauga review-ul",
     *    tags={"Review-uri"},
     *    description="Adauga review-ul",
     *    @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="id_client",
     *                  type="integer",
     *                  description="",
     *                  example=1,
     *              ),
     *              @OA\Property(
     *                  property="id_carte",
     *                  type="integer",
     *                  description="",
     *                  example=1,
     *              ),
     *              @OA\Property(
     *                  property="comentariu",
     *                  type="string",
     *                  description="",
     *                  example="",
     *              ),
     *              @OA\Property(
     *                  property="rating",
     *                  type="float",
     *                  description="",
     *                  example=1.0,
     *              ),
     *              @OA\Property(
     *                  property="data_review",
     *                  type="date",
     *                  description="",
     *                  example="",
     *              ),
     *              @OA\Property(
     *                  property="titlu",
     *                  type="string",
     *                  description="",
     *                  example="",
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
        $data = new Review;
        $this->reviewService->setProperties($data, $request->all());
        $data->save();
        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * @OA\Delete(
     *    path="/reviewuri/{id}",
     *    summary="Sterge review-ul cu id-ul dat",
     *    tags={"Review-uri"},
     *    description="Sterge review-ul cu id-ul dat",
     *    @OA\Parameter(
     *        name="id",
     *        description="Id-ul review-ului dorit",
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
        $data = Review::where('id', '=', $id)->firstOrFail();
        $data->delete();
        return response()->json("DELETED", Response::HTTP_OK);
    }
}
