<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Donatie;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DonatieController extends Controller
{
    /**
     * @OA\Post(
     *    path="/donatii",
     *    summary="Adauga donatia",
     *    tags={"Donatii"},
     *    description="Adauga donatia",
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
     *                  property="email",
     *                  type="string",
     *                  description="",
     *                  example="cristina.petrache@hotmail.com",
     *              ),
     *              @OA\Property(
     *                  property="nr_telefon",
     *                  type="string",
     *                  description="",
     *                  example="0755158838",
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
     *                  property="isbn",
     *                  type="string",
     *                  description="",
     *                  example="",
     *              ),
     *              @OA\Property(
     *                  property="adresa_ridicare",
     *                  type="string",
     *                  description="",
     *                  example="Str. Padurii, Nr. 85",
     *              ),
     *              @OA\Property(
     *                  property="oras_ridicare",
     *                  type="string",
     *                  description="",
     *                  example="Sabareni",
     *              ),
     *               @OA\Property(
     *                  property="judet_ridicare",
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
        foreach ($request->get('books') as $book) {
            $data = new Donatie;

            $data->nume = $request->get('nume');
            $data->prenume = $request->get('prenume');
            $data->email = $request->get('email');
            $data->nr_telefon = $request->get('nr_telefon');

            $data->titlu = $book['titlu'];
            $data->autor = $book['autor'];
            $data->isbn = $book['isbn'];

            $data->adresa_ridicare = $request->get('adresa_ridicare');
            $data->oras_ridicare = $request->get('oras_ridicare');
            $data->judet_ridicare = $request->get('judet_ridicare');
            $data->save();

        }

        return response()->json("DONE", Response::HTTP_OK);
    }
}
