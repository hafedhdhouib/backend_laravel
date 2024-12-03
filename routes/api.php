<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ScategorieController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('api')->group(function () {
    Route::resource('categories', CategorieController::class);
});

Route::middleware('api')->group(function () {
    Route::resource('scategories', ScategorieController::class);
});

Route::get('/scat/{idcat}', [ScategorieController::class, 'showSCategorieByCAT']);

Route::middleware('api')->group(function () {
    Route::resource('articles', ArticleController::class);
});

Route::get('/listarticles/{idscat}', [ArticleController::class, 'showArticlesBySCAT']);

Route::get('/articles/art/articlespaginate', [
    ArticleController::class,
    'articlesPaginate'
]);
Route::get('/articles/art/paginationpaginate', [
    ArticleController::class,
    'paginationPaginate'
]);
