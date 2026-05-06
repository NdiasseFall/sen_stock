<?php

use Illuminate\Support\Facades\Route;

Route::post('/register', [App\Http\Controllers\AuthController::class, 'register']);
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout']);

    Route::prefix('categories')->group(function () {
        Route::get('/', [App\Http\Controllers\Categorie::class, 'index']);
        Route::post('/create', [App\Http\Controllers\Categorie::class, 'create']);
        Route::post('/filter', [App\Http\Controllers\Categorie::class, 'filterByCategorie']);
        Route::put('/{id}', [App\Http\Controllers\Categorie::class, 'update']);
        Route::delete('/{id}', [App\Http\Controllers\Categorie::class, 'destroy']);
    });

    Route::prefix('produits')->group(function () {
        Route::get('/', [App\Http\Controllers\Produit::class, 'index']);
        Route::post('/create', [App\Http\Controllers\Produit::class, 'create']);
        Route::get('/{id}', [App\Http\Controllers\Produit::class, 'show']);
        Route::put('/{id}', [App\Http\Controllers\Produit::class, 'update']);
        Route::delete('/{id}', [App\Http\Controllers\Produit::class, 'destroy']);
    });

    Route::prefix('ventes')->group(function () {
        Route::get('/', [App\Http\Controllers\vente::class, 'index']);
        Route::post('/create', [App\Http\Controllers\vente::class, 'create']);
    });

    Route::prefix('inventaires')->group(function () {
        Route::get('/', [App\Http\Controllers\Inventaire::class, 'index']);
    });
});
