<?php

namespace App\Http\Controllers;

use App\Models\Carte;
use App\Models\Favorit;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class FavoritController extends Controller
{
    /**
     * @OA\Post(
     *    path="/favorite",
     *    summary="Adauga cartea favorita",
     *    tags={"Favorite"},
     *    description="Adauga cartea favorita",
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
        if (!Auth::check()) {
            return response()->json('User-ul nu este autentificat', Response::HTTP_UNAUTHORIZED);
        } else {
            $userLogged = Auth::user();
            $user = User::findOrFail($userLogged->id);
        }

        if (Favorit::where('id_carte', $request->get('id_carte'))
            ->where('id_client', $user->client->id)
            ->exists()) {
            $this->destroy($request->get('id_carte'));
            return response()->json('Cartea a fost stearsa din favorite', Response::HTTP_OK);
        }

        $data = new Favorit;

        $carte = Carte::find($request->get('id_carte'));

        $data->id_carte = $carte->id;
        $data->id_client = $user->client->id;

        $data->save();
        return response()->json($data, Response::HTTP_OK);
    }

    public function index()
    {
        $userLogged = Auth::user();
        $user = User::findOrFail($userLogged->id);

        $data = Favorit::where('id_client', $user->client->id)->get();
        return response()->json($data, Response::HTTP_OK);
    }

    public function show($id_carte): JsonResponse
    {
        $userLogged = Auth::user();
        $user = User::findOrFail($userLogged->id);

        $data = Favorit::where('id_carte', $id_carte)
            ->where('id_client', $user->client->id)
            ->first();
        if (!empty($data)) {
            return response()->json(['data' => true], Response::HTTP_OK);
        } else {
            return response()->json(['data' => false], Response::HTTP_OK);
        }
    }

    /**
     * @OA\Delete(
     *    path="/favorit/{id}",
     *    summary="Sterge cartea cu id-ul dat din favorite",
     *    tags={"CarteCos"},
     *    description="Sterge cartea cu id-ul dat din favorite",
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

        $client = $user->client;
        $favorite = $client->favorite()->where('id_carte', '=', $id)->first();
        $favorite->delete();

        return response()->json("DELETED", Response::HTTP_OK);
    }
}
