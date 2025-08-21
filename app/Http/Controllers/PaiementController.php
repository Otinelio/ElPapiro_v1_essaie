<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use Illuminate\Http\Request;

class PaiementController extends Controller
{
    public function index()
    {
        $paiements = Paiement::with('commande')->orderBy('created_at', 'desc')->paginate(15);
        if (request()->is('staff/*')) {
            return view('staff.paiement.index', compact( 'paiements'));
        }
        return view('admin.paiement.index', compact('paiements'));
    }

    public function valider(Paiement $paiement)
    {
        if ($paiement->statut === 'effectue' || in_array($paiement->commande->statut, ['terminee', 'annulee'])) {
            return back()->with('error', 'Impossible de valider ce paiement.');
        }

        $paiement->update(['statut' => 'effectue']);
        $paiement->commande->update(['statut' => 'terminee']);

        return back()->with('success', 'Paiement validé et commande terminée.');
    }
}
