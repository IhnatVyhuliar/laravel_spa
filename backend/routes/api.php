<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Comment\ShowCommentController;
use App\Http\Controllers\Comment\StoreCommentController;
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
Route::name('v1.')->prefix('v1')->group(function () {
    Route::post('/login', [UserController::class, "submit"]);
    Route::post('/login/authorise', [UserController::class, "authorise"]);
    

    Route::middleware('auth:sanctum')->group(function () {

        Route::get('/user', function (Request $request) {
            return $request->user();
        });
        Route::get('/comments', [ShowCommentController::class, 'index']);
        Route::post('/comments/reverse', [ShowCommentController::class, 'sortByDate']);

        Route::post('/comments/email', [ShowCommentController::class, 'sortByEmail']);
        Route::post('/comments/name', [ShowCommentController::class, 'sortByName']);

        Route::post('/comment/add', [StoreCommentController::class, 'store'])->middleware("XSS");
        
    });


});



