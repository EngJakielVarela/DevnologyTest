<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\CustomerController;
use App\Http\Controllers\Api\V1\InvoiceController;
use App\Http\Controllers\Api\AuthController;


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

Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'loginUser']);

Route::group(['prefix' => 'v1'], function () {
    route::apiResource('products', ProductController::class);
    route::get('category', [ProductController::class, 'category']);
});

Route::group(['middleware' => ['auth:sanctum'], 'prefix' => 'v1'], function () {
    route::apiResource('customers', CustomerController::class);
    route::apiResource('invoice', InvoiceController::class);
});
