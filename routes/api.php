<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

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
Route::get('/files/{id?}',[LoginController::class, "edit"]);
Route::post('/file',[LoginController::class, "destroy"]);
Route::put('/fileu/{id}',[LoginController::class, "update"]);
Route::delete('/delete/{id}',[LoginController::class, "delete"]);
Route::get('/search/{id}',[LoginController::class, "search"]);
