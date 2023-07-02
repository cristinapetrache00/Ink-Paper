<?php

namespace App\Http\Controllers;

use App\Mail\ConfirmOrder;
use App\Models\Carte;
use App\Models\CarteComanda;
use App\Models\CarteCos;
use App\Models\Comanda;
use App\Models\Discount;
use App\Models\User;
use App\Services\ComandaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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
        if (Auth::check()) {
            $user = User::find(Auth::id());
            $client = $user->client;
        } else {
            return response()->json(['message' => 'Nu sunteti logat'], Response::HTTP_UNAUTHORIZED);
        }

        $data = Comanda::where('id_client', '=', $client->id)->get();
        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * @return JsonResponse
     */
    public function adminIndex()
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
    public function carti(): JsonResponse
    {
        if (Auth::check()) {
            $user = User::find(Auth::id());
            $client = $user->client;
        } else {
            return response()->json(['message' => 'Nu sunteti logat'], Response::HTTP_UNAUTHORIZED);
        }
        $data = Comanda::where('id_client', '=', $client->id)->select('id')->get();
        $cartiComanda = [];

        foreach ($data as $comanda) {
            $cartiComanda[] = CarteComanda::where('id_comanda', '=', $comanda->id)->get();
        }

        $cartiId = [];

        foreach ($cartiComanda as $carteComanda) {
            foreach ($carteComanda as $carte) {
                $cartiId[] = $carte->id_carte;
            }
        }

        $carti = Carte::whereIn('id', $cartiId)->distinct()->get();

        return response()->json($carti, Response::HTTP_OK);
    }

    /**
     * @param int $id_comanda
     * @return JsonResponse
     */
    public function cartiComanda(int $id_comanda): JsonResponse
    {
        if (Auth::check()) {
            $user = User::find(Auth::id());
            $client = $user->client;
        } else {
            return response()->json(['message' => 'Nu sunteti logat'], Response::HTTP_UNAUTHORIZED);
        }

        $cartiComanda = CarteComanda::where('id_comanda', '=', $id_comanda)->get();

        $cartiId = [];

        foreach ($cartiComanda as $carteComanda) {
                $cartiId[] = $carteComanda->id_carte;

        }

        $carti = Carte::whereIn('id', $cartiId)->distinct()->get();

        return response()->json($carti, Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function checkout(Request $request)
    {
        $data = new Comanda;
        $this->comandaService->setProperties($data, $request->all());
        $data->save();

        $discounts = Discount::all();

        foreach ($request->input('carti') as $carte) {
            $carteComanda = new CarteComanda;

            $carteComanda->id_comanda = $data->id;
            $carteComanda->id_carte = $carte['id'];
            $carteComanda->cantitate = $carte['cos'];

            $checkDiscount = 0;
            foreach ($discounts as $discount) {
                if ($discount->id_carte == $carte['id']) {
                    $checkDiscount = 1;
                    $carteComanda->subtotal = ($carte['pret'] * $carte['cos']) - ($carte['pret'] * $carte['cos']) * $discount->discount / 100;
                    break;
                }
            }

            if ($checkDiscount == 0) {
                $carteComanda->subtotal = $carte['pret'] * $carte['cos'];
            }

            $carteComanda->save();

            if ($request->input('id_client') == 0) {
                $carteCos = CarteCos::where('id_carte', '=', $carte['id'])
                    ->first();
                $carteCos->delete();
            } else {
                    $carteCos = CarteCos::where('id_carte', '=', $carte['id'])
                    ->where('id_client', '=', $request->input('id_client'))
                    ->first();
                $carteCos->delete();
            }
        }

        Mail::to($request->input('email'))->send(new ConfirmOrder($data->id));

        return response()->json("DONE", Response::HTTP_OK);
    }
}
