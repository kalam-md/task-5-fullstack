<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ArticleController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);
Route::post('logout', [UserController::class, 'logout'])->middleware('auth:sanctum');

Route::group(['prefix' => 'categories', 'middleware' => 'auth:sanctum'], function () {
  Route::get('/', [CategoryController::class, 'index']);
  Route::post('add', [CategoryController::class, 'add']);
  Route::get('edit/{id}', [CategoryController::class, 'edit']);
  Route::post('update/{id}', [CategoryController::class, 'update']);
  Route::delete('delete/{id}', [CategoryController::class, 'delete']);
});

Route::group(['prefix' => 'articles', 'middleware' => 'auth:sanctum'], function () {
  Route::get('/', [ArticleController::class, 'index']);
  Route::post('add', [ArticleController::class, 'add']);
  Route::get('edit/{id}', [ArticleController::class, 'edit']);
  Route::post('update/{id}', [ArticleController::class, 'update']);
  Route::delete('delete/{id}', [ArticleController::class, 'delete']);
});
