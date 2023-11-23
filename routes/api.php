<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\{AuthenticationController, ArticleController};

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

Route::group(['prefix' => 'user'], function() {
    Route::post('login', [AuthenticationController::class, 'login'])->name('user.login')->middleware('api.logger');
    Route::post('register', [AuthenticationController::class, 'register'])->name('user.store')->middleware('api.logger');
});

Route::group(['middleware' => ['auth', 'api.logger']], function() {
    Route::apiResource('articles', ArticleController::class);
    Route::group(['prefix' => 'articles/{id}'], function() {
        Route::post("comment", [ArticleController::class, "comment"]);
        Route::post("approve", [ArticleController::class, "approve"]);
    });
});


