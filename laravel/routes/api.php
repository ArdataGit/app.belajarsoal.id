<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('callbackduitku', [App\Http\Controllers\PaymentController::class, 'callbackduitku']);
Route::post('callbackipaymu', [App\Http\Controllers\PaymentController::class, 'callbackipaymu']);
Route::post('callbacktripay', [App\Http\Controllers\PaymentController::class, 'callbacktripay']);


