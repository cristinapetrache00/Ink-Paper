<?php

namespace App\Http\Controllers;

use App\Models\CarteCategorie;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CarteCategorieController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index()
    {
        $data = CarteCategorie::all();

        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $data = new CarteCategorie;

        $data->id_carte = $request->input('id_carte');
        $data->id_categorie = $request->input('id_categorie');

        $data->save();

        return response()->json($data, Response::HTTP_CREATED);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request)
    {
        $data = CarteCategorie::findOrFail($request->input('id'));

        $data->id_carte = $request->input('id_carte');
        $data->id_categorie = $request->input('id_categorie');

        $data->save();

        return response()->json($data, Response::HTTP_OK);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy(Request $request)
    {
        $data = CarteCategorie::findOrFail($request->input('id_carte'));

        $data->delete();

        return response()->json("DELETED", Response::HTTP_OK);
    }
}
