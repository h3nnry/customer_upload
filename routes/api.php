<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoadController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\SalesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/load', LoadController::class);
Route::get('/load', LoadController::class);
Route::get('/sellers/{id}/contacts', [SellerController::class, 'getSellerContacts']);
Route::get('/sellers/{id}/sales', [SellerController::class, 'getSellerSales']);
Route::get('/sellers/{id}', [SellerController::class, 'getSellerData']);
Route::get('/sales/{year}', [SalesController::class, 'getSallesPerYear']);
