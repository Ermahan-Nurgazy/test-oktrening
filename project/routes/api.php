<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\NoteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::post('login', [AuthController::class, 'login']);

Route::middleware('jwt.verify')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('note/get-user-notes', [NoteController::class, 'getUserNotes']);
    Route::post('note/create', [NoteController::class, 'create']);
    Route::get('note/view/{id}', [NoteController::class, 'view']);
    Route::put('note/update', [NoteController::class, 'update']);
    Route::post('note/delete', [NoteController::class, 'delete']);
});
