<?php

namespace App\Http\Controllers;

use App\Services\ImportService;
use Exception;
use Illuminate\Http\JsonResponse;

class ImportController extends Controller
{
    private ImportService $importService;
    public function __construct(ImportService $importService)
    {
        $this->importService = $importService;
    }

    /**
     * @return JsonResponse
     */
    public function importCategorii(): JsonResponse
    {
        try {
            $this->importService->import('categorii.csv');
            return response()->json(['message' => 'Importul a fost realizat cu succes!']);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    /**
     * @return JsonResponse
     */
    public function importCarti(): JsonResponse
    {
        try {
            $this->importService->import('carti.csv');
            return response()->json(['message' => 'Importul a fost realizat cu succes!']);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    /**
     * @return JsonResponse
     */
    public function importUseri(): JsonResponse
    {
        try {
            $this->importService->import('useri.csv');
            $this->importService->import('clienti.csv');
            return response()->json(['message' => 'Importul a fost realizat cu succes!']);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    /**
     * @return JsonResponse
     */
    public function importReviews(): JsonResponse
    {
        try {
            $this->importService->import('review.csv');
            return response()->json(['message' => 'Importul a fost realizat cu succes!']);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    /**
     * @return JsonResponse
     */
    public function importDiscounts(): JsonResponse
    {
        try {
            $this->importService->import('promotii.csv');
            return response()->json(['message' => 'Importul a fost realizat cu succes!']);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }
}
