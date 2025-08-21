<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\User\PanierController;

Route::prefix('/panier')->group(function () {

    Route::get('/', [PanierController::class, 'index'])->name('panier.index');
    Route::post('/add/{produit}', [PanierController::class, 'add'])->name('panier.add');
    Route::patch('/update/{id}', [PanierController::class, 'update'])->name('panier.update');
    Route::delete('/remove/{id}', [PanierController::class, 'remove'])->name('panier.remove');
    Route::delete('/clear', [PanierController::class, 'clear'])->name('panier.clear');

});
Route::prefix('/favoris')->group(function () {

    Route::get('/favoris', [PanierController::class, 'indexFavoris'])->name('favoris');
    Route::post('/favoris/toggle/{produit}', [PanierController::class, 'toggle'])->name('favoris.toggle');
    Route::get('/favoris/count', [PanierController::class, 'count'])->name('favoris.count');

});

