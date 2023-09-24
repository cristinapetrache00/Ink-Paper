<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Illuminate\Http\Response;

class DiscountController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $discounts = Discount::all();

        return response()->json($discounts, Response::HTTP_OK);
    }
}
