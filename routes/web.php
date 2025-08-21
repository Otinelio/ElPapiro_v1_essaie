<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\CommandeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

// Route::get('/test-mail', function () {
//     $commande = \App\Models\Commande::first();

//     $emailService = new \App\Services\EmailService();
//     $result = $emailService->sendOrderConfirmation($commande);

//     dd($result, $commande->email_client);
// });

// Route::get('/', function () {
//     return view('welcome');
// });

Route::redirect('/', '/accueil');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('commandes')->group(function () {
    Route::get('/', [CommandeController::class, 'index'])->name('user.commandes.index');
    Route::get('/{commande}', [CommandeController::class, 'show'])->name('user.commandes.show');
});

require __DIR__.'/auth.php';

// Routes d'accès administrateur
Route::get('/admin-access', [App\Http\Controllers\AdminAccessController::class, 'showAccessForm'])
    ->name('admin.access.check');
Route::post('/admin-access', [App\Http\Controllers\AdminAccessController::class, 'verifyAccess'])
    ->name('admin.access.verify');

// Route de confirmation d'inscription
Route::get('/register/confirmation', [App\Http\Controllers\Auth\RegisteredUserController::class, 'confirmation'])
    ->name('register.confirmation');

// Admin route
require __DIR__.'/admin.php';

// Staff route
require __DIR__.'/staff.php';

// User route
require __DIR__.'/user.php';

// Panier route
require __DIR__.'/panier.php';

// // Checkout route
// require __DIR__.'/check-out.php';

// // Commande route
// require __DIR__.'/commande.php';

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
