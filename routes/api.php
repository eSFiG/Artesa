<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TagController;
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

Route::get('/product/show/{productId}', [ProductController::class, 'show']);
Route::get('/category/show/{categoryId}', [CategoryController::class, 'show']);
Route::get('/tag/show/{tagId}', [TagController::class, 'show']);

Route::group(['middleware' => 'auth.api'], function () {
    Route::post('/product/create', [ProductController::class, 'create']);
    Route::post('/product/update/{productId}', [ProductController::class, 'update']);
    Route::get('/product/delete/{productId}', [ProductController::class, 'delete']);

    Route::get('/product/{productId}/category/add/{categoryId}', [ProductController::class, 'addProductToCategory']);
    Route::get('/product/{productId}/category/remove/{categoryId}', [ProductController::class, 'removeProductFromCategory']);

    Route::get('/product/{productId}/add/tag/{tagId}', [ProductController::class, 'addTagToProduct']);
    Route::get('/product/{productId}/remove/tag/{tagId}', [ProductController::class, 'removeTagFromProduct']);

    Route::post('/category/create', [CategoryController::class, 'create']);
    Route::post('/category/update/{categoryId}', [CategoryController::class, 'update']);
    Route::get('/category/delete/{categoryId}', [CategoryController::class, 'delete']);

    Route::post('/tag/create', [TagController::class, 'create']);
    Route::post('/tag/update/{tagId}', [TagController::class, 'update']);
    Route::get('/tag/delete/{tagId}', [TagController::class, 'delete']);
});
