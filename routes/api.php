<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Snippet\SnippetController;
use App\Http\Controllers\Step\StepController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'auth'], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});


Route::group(['prefix' => 'snippets'], function () {
    Route::get('/', [SnippetController::class, 'index']);
    Route::post('/', [SnippetController::class, 'store'])->middleware('auth:sanctum');
    Route::get('{snippet}', [SnippetController::class, 'show']);
    Route::patch('{snippet}', [SnippetController::class, 'update']);
    Route::delete('{snippet}/steps/{step}', [StepController::class, 'destroy']);
    Route::patch('{snippet}/steps/{step}', [StepController::class, 'update']);
    Route::post('{snippet}/steps', [StepController::class, 'store']);
});
