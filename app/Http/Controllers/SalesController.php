<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

/**
 *
 */
class SalesController extends Controller
{
    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public static function getSallesPerYear(Request $request, $year)
    {
        $salesList = Sale::getSalesListPerYear($year);
        $amountData = Sale::getAmountDataPerYear($year);

        return ['amount_data' => $amountData, 'sales_list' => $salesList];
    }
}
