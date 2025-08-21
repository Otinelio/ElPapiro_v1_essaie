<?php

use App\Http\Controllers\User\CheckOutController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/accueil', [UserController::class, 'index'])->name('user.index');
Route::get('boutique/', [UserController::class, 'boutique'])->name('user.boutique');
Route::get('detail-boutique/{slug}', [UserController::class, 'detailboutique'])->name('user.detailboutique');
Route::get('panier/', [UserController::class, 'panier'])->name('user.panier');

Route::get('check-out/', [CheckOutController::class, 'show'])->name('user.checkout');
Route::post('check-out/', [CheckOutController::class, 'process'])->name('checkout.process');
Route::get('/checkout/resume/{numero_commande}', [CheckOutController::class, 'resume'])->name('checkout.resume');