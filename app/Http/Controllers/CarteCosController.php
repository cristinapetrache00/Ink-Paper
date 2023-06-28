<?php

namespace App\Http\Controllers;

use App\Models\Carte;
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
        $data = new CarteCos;

        if (Auth::check()) {
            $user = User::findOrFail(Auth::user()->id);
            $client = $user->client;
            $data->id_client = $client->id;
            $carteCos = CarteCos::where('id_carte', '=', $request->input('id_carte'))
                ->where('id_client', '=', $client->id)
                ->first();
        } else {
            $data->id_client = null;
            $carteCos = CarteCos::where('id_carte', '=', $request->input('id_carte'))->first();
        }


        if (!empty($carteCos)) {
            $carteCos->cantitate += $request->get('cantitate');
            $carteCos->subtotal += $request->get('subtotal');
            $carteCos->save();
            return response()->json($carteCos, Response::HTTP_OK);
        }


        $data->id_carte = $request->get('id_carte');
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
            $client = $user->client;
            $carteCos = CarteCos::where('id_carte', '=', $request->input('id_carte'))
                ->where('id_client', '=', $client->id)
                ->first();
        } else {
            $carteCos = CarteCos::where('id_carte', '=', $request->input('id_carte'))
                ->first();
        }

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
            $client = $user->client;
            $carteCos = CarteCos::where('id_carte', '=', $id)
                ->where('id_client', '=', $client->id)
                ->first();
        } else {
            $carteCos = CarteCos::where('id_carte', '=', $id)->first();
        }

        $carteCos->delete();
        return response()->json("DELETED", Response::HTTP_OK);
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $userLogged = Auth::user();
        $data = [];
        if (!empty($userLogged)) {
            $user = User::findOrFail($userLogged->id);
            $client = $user->client;
            $cartiId = CarteCos::where('id_client', '=', $client->id)->get();
            foreach ($cartiId as $carteCos) {
                $carte = Carte::where('id', '=', $carteCos->id_carte)->first();

                $data[] = [
                    'titlu' => $carte->titlu,
                    'imagine' => $carte->imagine,
                    'autor' => $carte->autor,
                    'pret' => $carte->pret,
                    'id' => $carte->id,
                    'cantitate' => $carte->cantitate,
                    'cos' => $carteCos->cantitate,
                ];
            }

        } else {
            $cartiId = CarteCos::where('id_client', '=', null)->get();
            foreach ($cartiId as $carteCos) {
                $carte = Carte::where('id', '=', $carteCos->id_carte)->first();

                $data[] = [
                    'titlu' => $carte->titlu,
                    'imagine' => $carte->imagine,
                    'autor' => $carte->autor,
                    'pret' => $carte->pret,
                    'id' => $carte->id,
                    'cantitate' => $carte->cantitate,
                    'cos' => $carteCos->cantitate,
                ];
            }
        }

        return response()->json($data, Response::HTTP_OK);
    }
}
