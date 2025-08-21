<?php
use App\Http\Controllers\Admin\AdminLivraisonsController;
use App\Http\Controllers\Admin\AdminPersonnelsController;
use App\Http\Controllers\Admin\AdminPubsController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\Admin\ProduitController;
use App\Http\Controllers\Admin\CategorieController;
use App\Http\Controllers\User\CommandeController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'isAdmin'])->group(function () {

    Route::prefix("admin/")->group(function () {

        // Route produit
        Route::resource('produit', ProduitController::class)->names([
            'index' => 'produit.index',
            'create' => 'produit.create',
            'store' => 'produit.store',
            'show' => 'produit.show',
            'edit' => 'produit.edit',
            'update' => 'produit.update',
            'destroy' => 'produit.destroy'
        ])->parameters([
                    'produit' => 'slug'
                ]);

        // Route categorie
        Route::get('categorie', [CategorieController::class, 'index'])->name('categorie.index');
        Route::get('categorie/créer', [CategorieController::class, 'create'])->name('categorie.create');
        Route::post('categorie/store', [CategorieController::class, 'store'])->name('categorie.store');
        Route::delete('categorie/delete/{id}', [CategorieController::class, 'destroy'])->name('categorie.destroy');

        Route::prefix("Commande")->group(function () {
            // Route commande
            Route::get('/', [CommandeController::class, 'adminIndex'])->name('commande.index');
            Route::get('/{commande}', [CommandeController::class, 'adminShow'])->name('commande.show');
            Route::get('/{commande}/edit', [CommandeController::class, 'adminEdit'])->name('commande.edit');
            Route::put('/{commande}', [CommandeController::class, 'adminUpdate'])->name('commande.update');
            Route::delete('/{commande}', [CommandeController::class, 'adminDestroy'])->name('commande.destroy');
            Route::get('{commande}/valider-paiement', [CommandeController::class, 'showPaiementForm'])->name('commande.valider.paiement');
            Route::post('{commande}/valider-paiement', [CommandeController::class, 'validerPaiement'])->name('commande.valider.paiement.store');
            Route::put('{commande}/annuler', [CommandeController::class, 'annuler'])->name('commande.annuler');
        });
        Route::prefix("Paiement")->group(function () {
            // Route paiement
            Route::get('/', [PaiementController::class, 'index'])->name('paiement.index');
            Route::put('/{paiement}/valider', [PaiementController::class, 'valider'])->name('paiement.valider');
        });

        Route::prefix('livraisons')->group(function () {
            // Route livraisons (admin namespaced)
            Route::get('/', [AdminLivraisonsController::class, 'view'])->name('admin.livraisons.view');
        });

        Route::prefix('pubs')->group(function () {
            // Route pubs (staff namespaced)
            Route::get('/', [AdminPubsController::class, 'index'])->name('admin.pubs.view');
            Route::get('/create', [AdminPubsController::class, 'create'])->name('admin.pubs.create');
            Route::post('/', [AdminPubsController::class, 'store'])->name('admin.pubs.store');
            Route::get('/{pub}/edit', [AdminPubsController::class, 'edit'])->name('admin.pubs.edit');
            Route::put('/{pub}', [AdminPubsController::class, 'update'])->name('admin.pubs.update');
            Route::delete('/{pub}', [AdminPubsController::class, 'destroy'])->name('admin.pubs.destroy');

        });


        Route::prefix('personnels')->group(
            function () {
                // Route personnels (admin namespaced)
                Route::get('/', [AdminPersonnelsController::class, 'view'])->name('admin.personnels.view');
                Route::post('/', [AdminPersonnelsController::class, 'store'])->name('admin.personnels.store');
                Route::put('/{user}/status', [AdminPersonnelsController::class, 'updateStatus'])->name('admin.personnels.status');
                Route::put('/{user}', [AdminPersonnelsController::class, 'update'])->name('admin.personnels.update');
                Route::delete('/{user}', [AdminPersonnelsController::class, 'destroy'])->name('admin.personnels.destroy');
            }
        );
    });
    Route::put('admin/access-password', [AdminPersonnelsController::class, 'updateAdminPassword'])
        ->name('admin.access.password.update');
});

