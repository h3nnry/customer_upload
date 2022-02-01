<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use Illuminate\Http\Request;

/**
 *
 */
class SellerController extends Controller
{
    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public static function getSellerData(Request $request, $id)
    {
        $seller = Seller::find($id);

        if (empty($seller)) {
            return response()->json("Seller with id: {$id} not found!" , 404);
        }

        return $seller;
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public static function getSellerContacts(Request $request, $id)
    {
        $seller = Seller::find($id);

        if (empty($seller)) {
            return response()->json("Seller with id: {$id} not found!" , 404);
        }

        return $seller->contacts->toArray();
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public static function getSellerSales(Request $request, $id)
    {
        $seller = Seller::find($id);

        if (empty($seller)) {
            return response()->json("Seller with id: {$id} not found!" , 404);
        }

        return  Seller::getSellerAllSales($id);
    }



}
