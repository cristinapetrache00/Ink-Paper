<?php

namespace App\Http\Controllers;

use App\Models\Carte;
use App\Services\CarteService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class CarteController extends Controller
{
    private CarteService $carteService;
    public function __construct(CarteService $carteService)
    {
        $this->carteService = $carteService;
    }

    /**
     * @OA\Get(
     *    path="/carti",
     *    summary="Returneaza toate cartile",
     *    tags={"Carti"},
     *    description="Returneaza toate cartile",
     *   @OA\Response(
     *        response=200,
     *        description="Success"
     *    )
     * )
     */
    public function index(): JsonResponse
    {
        $data = Carte::all();
        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * @OA\Get(
     *    path="/carti/{id}",
     *    summary="Returneaza cartea cu id-ul dat",
     *    tags={"Carti"},
     *    description="Returneaza cartea cu id-ul dat",
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
    public function show($id): JsonResponse
    {
        $data = Carte::where('id', '=', $id)->firstOrFail();
        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * @OA\Put(
     *    path="/carti",
     *    summary="Update cartea cu id-ul dat",
     *    tags={"Carti"},
     *    description="Update cartea cu id-ul dat",
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
     *                  property="titlu",
     *                  type="string",
     *                  description="",
     *                  example="",
     *              ),
     *              @OA\Property(
     *                  property="autor",
     *                  type="string",
     *                  description="",
     *                  example="",
     *              ),
     *              @OA\Property(
     *                  property="imagine",
     *                  type="string",
     *                  description="",
     *                  example="",
     *              ),
     *              @OA\Property(
     *                  property="isbn",
     *                  type="string",
     *                  description="",
     *                  example="",
     *              ),
     *              @OA\Property(
     *                  property="editura",
     *                  type="string",
     *                  description="",
     *                  example="",
     *              ),
     *              @OA\Property(
     *                  property="pret",
     *                  type="float",
     *                  description="",
     *                  example=1.0,
     *              ),
     *              @OA\Property(
     *                  property="an_aparitie",
     *                  type="integer",
     *                  description="",
     *                  example=1,
     *              ),
     *              @OA\Property(
     *                  property="nr_pg",
     *                  type="integer",
     *                  description="",
     *                  example=1,
     *              ),
     *               @OA\Property(
     *                  property="tip_coperta",
     *                  type="string",
     *                  description="",
     *                  example="",
     *              ),
     *              @OA\Property(
     *                  property="limba",
     *                  type="string",
     *                  description="",
     *                  example="",
     *              ),
     *               @OA\Property(
     *                  property="dimensiune",
     *                  type="string",
     *                  description="",
     *                  example="",
     *              ),
     *               @OA\Property(
     *                  property="cantitate",
     *                  type="integer",
     *                  description="",
     *                  example=1,
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
        $data = Carte::where('id', '=', $request['id'])->firstOrFail();
        $this->carteService->setProperties($data, $request->all());
        $data->save();
        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *    path="/carti",
     *    summary="Adauga cartea",
     *    tags={"Carti"},
     *    description="Adauga cartea",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="titlu",
     *                  type="string",
     *                  description="",
     *                  example="",
     *              ),
     *              @OA\Property(
     *                  property="autor",
     *                  type="string",
     *                  description="",
     *                  example="",
     *              ),
     *              @OA\Property(
     *                  property="imagine",
     *                  type="string",
     *                  description="",
     *                  example="",
     *              ),
     *              @OA\Property(
     *                  property="isbn",
     *                  type="string",
     *                  description="",
     *                  example="",
     *              ),
     *              @OA\Property(
     *                  property="editura",
     *                  type="string",
     *                  description="",
     *                  example="",
     *              ),
     *              @OA\Property(
     *                  property="pret",
     *                  type="float",
     *                  description="",
     *                  example=1.0,
     *              ),
     *              @OA\Property(
     *                  property="an_aparitie",
     *                  type="integer",
     *                  description="",
     *                  example=1,
     *              ),
     *              @OA\Property(
     *                  property="nr_pg",
     *                  type="integer",
     *                  description="",
     *                  example=1,
     *              ),
     *               @OA\Property(
     *                  property="tip_coperta",
     *                  type="string",
     *                  description="",
     *                  example="",
     *              ),
     *              @OA\Property(
     *                  property="limba",
     *                  type="string",
     *                  description="",
     *                  example="",
     *              ),
     *               @OA\Property(
     *                  property="dimensiune",
     *                  type="string",
     *                  description="",
     *                  example="",
     *              ),
     *               @OA\Property(
     *                  property="cantitate",
     *                  type="integer",
     *                  description="",
     *                  example=1,
     *              ),
     *               @OA\Property(
     *                  property="categorie",
     *                  type="string",
     *                  description="",
     *                  example="Beletristica",
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
        $data = new Carte;
        $this->carteService->setProperties($data, $request->all());
        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * @OA\Delete(
     *    path="/carti/{id}",
     *    summary="Sterge cartea cu id-ul dat",
     *    tags={"Carti"},
     *    description="Sterge cartea cu id-ul dat",
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
        $data = Carte::where('id', '=', $id)->firstOrFail();
        $data->delete();
        return response()->json("DELETED", Response::HTTP_OK);
    }

    /**
     * @OA\Get(
     *    path="/carti/categorii/{id}",
     *    summary="Returneaza categoriile cartii cu id-ul dat",
     *    tags={"Carti"},
     *    description="Returneaza categoriile cartii cu id-ul dat",
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
    public function categorii($id): JsonResponse
    {
        $data = Carte::where('id', '=', $id)->firstOrFail();
        $data = $data->categorii()->get();

        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * @OA\Get(
     *    path="/carti/reviewuri/{id}",
     *    summary="Returneaza reviewurile cartii cu id-ul dat",
     *    tags={"Carti"},
     *    description="Returneaza reviewurile cartii cu id-ul dat",
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
    public function reviewuri($id): JsonResponse
    {
        $data = Carte::where('id', '=', $id)->firstOrFail();
        $data = $data->reviewuri()->get();

        return response()->json($data, Response::HTTP_OK);
    }

    public function search(Request $request)
    {
        $validatedData = $request->validate([
            'titlu' => 'required',
        ]);
        $carti = Carte::where('titlu', 'like', '%' . $validatedData['titlu'] . '%')->get();

        $data = [];
        foreach ($carti as $carte) {
            $data[] = [
                'titlu' => $carte->titlu,
                'autor' => $carte->autor,
            ];
        }
        $data = json_encode($data);
        return route('search', ['data' => $data]);
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function paginaCautare(Request $request)
    {
        $data = $request->input('data');
        return view('pagina-cautare', compact('data'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function queryBuilder(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'autor' => 'nullable',
            'editura' => 'nullable',
            'categorie' => 'nullable',
            'pret' => 'nullable',
            'limba' => 'nullable',
            'ordine' => 'nullable',
        ]);

        $query = DB::table('carte');

        if ($validatedData['autor'] != null) {
            $query->whereIn('autor', $validatedData['autor']);
        }

        if ($validatedData['pret'] != null) {
            $query->whereBetween('pret', $validatedData['pret']);
        }

        if ($validatedData['limba'] != null) {
            $query->whereIn('limba', $validatedData['limba']);
        }

        if ($validatedData['editura'] != null) {
            $query->whereIn('editura', $validatedData['editura']);
        }

        if ($validatedData['categorie'] != null) {
            $query->join('carte_categorie', 'carte.id', '=', 'carte_categorie.id_carte')
                ->join('categorie', 'carte_categorie.id_categorie', '=', 'categorie.id')
                ->whereIn('categorie.nume', $validatedData['categorie']);
        }

        if ($validatedData['ordine'] != null) {
            if ($validatedData['ordine'] === 'pret_crescator') {
                $query->orderBy('pret', 'asc');
            } else {
                if ($validatedData['ordine'] === 'pret_descrescator') {
                    $query->orderBy('pret', 'desc');
                } else {
                    if ($validatedData['ordine'] === 'alfabetic_crescator') {
                        $query->orderBy('nume', 'asc');
                    } else {
                        if ($validatedData['ordine'] === 'alfabetic_descrescator') {
                            $query->orderBy('nume', 'desc');
                        }
                    }
                }
            }
        }

        $results = $query->get();

        return response()->json($results, Response::HTTP_OK);
    }

    /**
     * @return JsonResponse
     */
    public function getFilters()
    {
        $autori = DB::table('carte')->select('autor')->distinct()->get();
        $edituri = DB::table('carte')->select('editura')->distinct()->get();
        $categorii = DB::table('categorie')->select('nume')->distinct()->get();
        $limbi = DB::table('carte')->select('limba')->distinct()->get();

        $data = [
            'autori' => $autori,
            'edituri' => $edituri,
            'categorii' => $categorii,
            'limbi' => $limbi,
        ];

        return response()->json($data, Response::HTTP_OK);
    }
}