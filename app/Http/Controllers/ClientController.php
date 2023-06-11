<?php

namespace App\Http\Controllers;

use App\Models\Carte;
use App\Models\Client;
use App\Models\User;
use App\Services\ClientService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    private ClientService $clientService;
    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }

    /**
     * @OA\Get(
     *    path="/clienti",
     *    summary="Returneaza toti clientii",
     *    tags={"Clienti"},
     *    description="Returneaza toti clientii",
     *   @OA\Response(
     *        response=200,
     *        description="Success"
     *    )
     * )
     */
    public function index(): JsonResponse
    {
        $data = Client::all();
        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * @OA\Get(
     *    path="/clienti/{id}",
     *    summary="Returneaza clientul cu id-ul dat",
     *    tags={"Clienti"},
     *    description="Returneaza clientul cu id-ul dat",
     *    @OA\Parameter(
     *        name="id",
     *        description="Id-ul clientului dorit",
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
        $data = Client::where('id', '=', $id)->firstOrFail();

        $data->email = $data->user()->get()->email;

        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * @OA\Put(
     *    path="/clienti",
     *    summary="Update clientul cu id-ul dat",
     *    tags={"Clienti"},
     *    description="Update clientul cu id-ul dat",
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
     *                  property="nume",
     *                  type="string",
     *                  description="",
     *                  example="Petrache",
     *              ),
     *              @OA\Property(
     *                  property="prenume",
     *                  type="string",
     *                  description="",
     *                  example="Cristina",
     *              ),
     *              @OA\Property(
     *                  property="nr_telefon",
     *                  type="string",
     *                  description="",
     *                  example="0755158838",
     *              ),
     *              @OA\Property(
     *                  property="adresa",
     *                  type="string",
     *                  description="",
     *                  example="Str. Padurii, Nr. 85",
     *              ),
     *              @OA\Property(
     *                  property="oras",
     *                  type="string",
     *                  description="",
     *                  example="Sabareni",
     *              ),
     *               @OA\Property(
     *                  property="judet",
     *                  type="string",
     *                  description="",
     *                  example="Giurgiu",
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
        $data = Client::where('id', '=', $request['id'])->firstOrFail();
        $this->clientService->setProperties($data, $request->all());
        $data->save();
        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *    path="/clienti",
     *    summary="Adauga clientul",
     *    tags={"Clienti"},
     *    description="Adauga clientul",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="nume",
     *                  type="string",
     *                  description="",
     *                  example="Petrache",
     *              ),
     *              @OA\Property(
     *                  property="prenume",
     *                  type="string",
     *                  description="",
     *                  example="Cristina",
     *              ),
     *              @OA\Property(
     *                  property="nr_telefon",
     *                  type="string",
     *                  description="",
     *                  example="0755158838",
     *              ),
     *              @OA\Property(
     *                  property="adresa",
     *                  type="string",
     *                  description="",
     *                  example="Str. Padurii, Nr. 85",
     *              ),
     *              @OA\Property(
     *                  property="oras",
     *                  type="string",
     *                  description="",
     *                  example="Sabareni",
     *              ),
     *               @OA\Property(
     *                  property="judet",
     *                  type="string",
     *                  description="",
     *                  example="Giurgiu",
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
        $data = new Client;
        $this->clientService->setProperties($data, $request->all());
        $data->save();
        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * @OA\Delete(
     *    path="/clienti/{id}",
     *    summary="Sterge clientul cu id-ul dat",
     *    tags={"Clienti"},
     *    description="Sterge clientul cu id-ul dat",
     *    @OA\Parameter(
     *        name="id",
     *        description="Id-ul clientului dorit",
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
        $data = Client::where('id', '=', $id)->firstOrFail();
        $data->delete();
        return response()->json("DELETED", Response::HTTP_OK);
    }

    /**
     * @OA\Get(
     *    path="/client-autentificat",
     *    summary="Returneaza clientul autentificat",
     *    tags={"Clienti"},
     *    description="Returneaza clientul autentificat",
     *   @OA\Response(
     *        response=200,
     *        description="Success"
     *    )
     * )
     */
    public function getUserData(): JsonResponse
    {
        $user = auth()->user();
        $client = $user->client()->get();
        return response()->json($client, Response::HTTP_OK);
    }

    public function addFavoriteBook(Request $request)
    {
        if (Auth::check()) {
            $user = User::findOrFail(Auth::user()->id);
        } else {
            return redirect()->intended(route('login'));
        }

        $carte = Carte::where('id', '=', $request->get('id_carte'))
            ->select('titlu', 'autor','imagine','pret')
            ->first();

        $client = $user->client();
        $client->favorite[] = $carte;
        $client->save();

        return response()->json("Carte adaugata", Response::HTTP_OK);
    }

    /**
     * @OA\Get(
     *    path="/clienti/comenzi",
     *    summary="Returneaza comenzile clientului cu id-ul dat",
     *    tags={"Clienti"},
     *    description="Returneaza comenzile clientului cu id-ul dat",
     *    @OA\Parameter(
     *        name="id",
     *        description="Id-ul clientului dorit",
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
    public function comenzi($id): JsonResponse
    {
        if (Auth::check()) {
            $user = User::findOrFail(Auth::user()->id);
        } else {
            return response()->json('User-ul nu este autentificat', Response::HTTP_UNAUTHORIZED);
        }
        $data = $user->client()->comenzi()->get();

        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * @OA\Get(
     *    path="/clienti/favorite",
     *    summary="Returneaza cartile favorite ale clientului cu id-ul dat",
     *    tags={"Clienti"},
     *    description="Returneaza cartile favorite ale clientului cu id-ul dat",
     *    @OA\Parameter(
     *        name="id",
     *        description="Id-ul clientului dorit",
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
    public function favorite($id): JsonResponse
    {
        if (Auth::check()) {
            $user = User::findOrFail(Auth::user()->id);
        } else {
            return response()->json('User-ul nu este autentificat', Response::HTTP_UNAUTHORIZED);
        }
        $data = $user->client()->favorite()->get();

        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * @OA\Get(
     *    path="/clienti/cos",
     *    summary="Returneaza cartile din cos ale clientului cu id-ul dat",
     *    tags={"Clienti"},
     *    description="Returneaza cartile din cos ale clientului cu id-ul dat",
     *    @OA\Parameter(
     *        name="id",
     *        description="Id-ul clientului dorit",
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
    public function cos($id): JsonResponse
    {
        if (Auth::check()) {
            $user = User::findOrFail(Auth::user()->id);
        } else {
            return response()->json('User-ul nu este autentificat', Response::HTTP_UNAUTHORIZED);
        }
        $data = $user->client()->cartiCos()->get();

        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * @OA\Get(
     *    path="/clienti/user",
     *    summary="Returneaza datele clientului autentificat",
     *    tags={"Clienti"},
     *    description="Returneaza datele clientului autentificat",
     *    @OA\Parameter(
     *        name="id",
     *        description="Id-ul clientului dorit",
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
    public function userData(): JsonResponse
    {
        if (Auth::check()) {
            $user = User::findOrFail(Auth::user()->id);
        } else {
            return response()->json('User-ul nu este autentificat', Response::HTTP_UNAUTHORIZED);
        }

        $data = $user->client()->get();

        $data->email = $user->email;

        return response()->json($data, Response::HTTP_OK);
    }
}

