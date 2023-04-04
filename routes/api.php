<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AnimalsController;


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

Route::post('login', [UserController::class, 'authenticate']);
Route::post('register', [UserController::class, 'register']);

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('logout', [UserController::class, 'logout']);
    Route::get('all_user', [UserController::class, 'all_user']);
    Route::get('get_user', [UserController::class, 'get_user']);
    Route::get('user_id/{id}', [UserController::class, 'show']);
    Route::put('update/{id}', [UserController::class, 'update']);
    Route::delete('delete/{id}', [UserController::class, 'destroy']);

    Route::get('add', [AnimalsController::class, 'create']);
    Route::get('all_user', [UserController::class, 'all_user']);
    // Route::get('products/{id}', [ProductController::class, 'show']);
    // Route::post('create', [ProductController::class, 'store']);
    // Route::put('update/{product}',  [ProductController::class, 'update']);
    // Route::delete('delete/{product}',  [ProductController::class, 'destroy']);
});

