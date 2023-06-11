<?php

namespace App\Http\Controllers;

use App\Models\CarteComanda;
use App\Models\CarteCos;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CarteCosController extends Controller
{
    /**
     * @OA\Post(
     *    path="/cos",
     *    summary="Adauga o carte in cos",
     *    tags={"CarteCos"},
     *    description="Adauga o carte in cos",
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
        if (Auth::check()) {
            $user = User::findOrFail(Auth::user()->id);
        } else {
            return response()->json('User-ul nu este autentificat', Response::HTTP_UNAUTHORIZED);
        }

        $client = $user->client()->get();

        $data = new CarteCos;

        $data->id_carte = $request->get('id_carte');
        $data->id_client = $client->id;
        $data->cantitate = $request->get('cantitate');
        $data->subtotal = $request->get('subtotal');

        $data->save();
        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * @OA\Put(
     *    path="/cos",
     *    summary="Update cantitatea cartii din cos",
     *    tags={"CarteCos"},
     *    description="Update cantitatea cartii din cos",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="cantitate",
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
        if (Auth::check()) {
            $user = User::findOrFail(Auth::user()->id);
        } else {
            return response()->json('User-ul nu este autentificat', Response::HTTP_UNAUTHORIZED);
        }

        $client = $user->client()->get();
        $carteCos = $client->cartiCos()->where('id_carte', '=', $request->input('id_carte'))->first();

        $carteCos->cantitate = $request->get('cantitate');

        $carteCos->save();
        return response()->json("Cantitate schimbata!", Response::HTTP_OK);
    }

    /**
     * @OA\Delete(
     *    path="/cos/{id}",
     *    summary="Sterge carte cu id-ul dat din cos",
     *    tags={"CarteCos"},
     *    description="Sterge carte cu id-ul dat din cos",
     *    @OA\Parameter(
     *        name="id",
     *        description="Id-ul cartii dorite",
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
        if (Auth::check()) {
            $user = User::findOrFail(Auth::user()->id);
        } else {
            return response()->json('User-ul nu este autentificat', Response::HTTP_UNAUTHORIZED);
        }

        $client = $user->client()->get();
        $carteCos = $client->cartiCos()->where('id_carte', '=', $id)->first();

        $carteCos->delete();
        return response()->json("DELETED", Response::HTTP_OK);
    }
}
