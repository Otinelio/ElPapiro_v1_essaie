<?php

use App\Http\Controllers\Admin\AdminPubsController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\Staff\ProduitController;
use App\Http\Controllers\Admin\CategorieController;
use App\Http\Controllers\Staff\StaffLivraisonsController;
use App\Http\Controllers\Staff\StaffPubsController;
use App\Http\Controllers\User\CommandeController;
use Illuminate\Support\Facades\Route;


Route::middleware('isStaff')->group(function () {

    Route::prefix("staff/")->group(function () {

        // Route produit
        Route::resource('produit', ProduitController::class)->names([
            'index' => 'staff.produit.index',
            'create' => 'staff.produit.create',
            'store' => 'staff.produit.store',
            'show' => 'staff.produit.show',
            'edit' => 'staff.produit.edit',
            'update' => 'staff.produit.update',
            'destroy' => 'staff.produit.destroy'
        ])->parameters([
                    'produit' => 'slug'
                ]);


        Route::prefix('commande')->group(function () {
            // Route commande (staff namespaced)
            Route::get('/', [CommandeController::class, 'adminIndex'])->name('staff.commande.index');
            Route::get('/{commande}', [CommandeController::class, 'adminShow'])->name('staff.commande.show');
            Route::get('/{commande}/edit', [CommandeController::class, 'adminEdit'])->name('staff.commande.edit');
            Route::put('/{commande}', [CommandeController::class, 'adminUpdate'])->name('staff.commande.update');
            Route::delete('/{commande}', [CommandeController::class, 'adminDestroy'])->name('staff.commande.destroy');
            Route::get('{commande}/valider-paiement', [CommandeController::class, 'showPaiementForm'])->name('staff.commande.valider.paiement');
            Route::post('{commande}/valider-paiement', [CommandeController::class, 'validerPaiement'])->name('staff.commande.valider.paiement.store');
            Route::put('{commande}/annuler', [CommandeController::class, 'annuler'])->name('staff.commande.annuler');
        });
        Route::prefix('paiement')->group(function () {
            // Route paiement (staff namespaced)
            Route::get('/', [PaiementController::class, 'index'])->name('staff.paiement.index');
            Route::put('/{paiement}/valider', [PaiementController::class, 'valider'])->name('staff.paiement.valider');
        });
        Route::prefix('livraisons')->group(function () {
            // Route livraisons (staff namespaced)
            Route::get('/', [StaffLivraisonsController::class, 'view'])->name('staff.livraisons.view');
        });

        Route::prefix('pubs')->group(function () {
            // Route pubs (admin namespaced)
            Route::get('/', [AdminPubsController::class, 'index'])->name('staff.pubs.view');
            Route::get('/create', [AdminPubsController::class, 'create'])->name('staff.pubs.create');
            Route::post('/', [AdminPubsController::class, 'store'])->name('staff.pubs.store');
            Route::get('/{pub}/edit', [AdminPubsController::class, 'edit'])->name('staff.pubs.edit');
            Route::put('/{pub}', [AdminPubsController::class, 'update'])->name(name: 'staff.pubs.update');
            Route::delete('/{pub}', [AdminPubsController::class, 'destroy'])->name('staff.pubs.destroy');

        });

        // Route de test
        Route::get('test', function () {
            return view('staff.test');
        })->name('staff.test');
    });

});
