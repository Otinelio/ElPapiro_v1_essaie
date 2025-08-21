<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Panier;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PanierController extends Controller
{
    // Ajouter un produit au panier
    // Au début de la classe, ajoutons une méthode pour obtenir ou créer un session_id


    public function add(Request $request, Produit $produit)
    {
        $request->validate([
            'quantite' => 'required|integer|min:1',
        ]);

        // Si l'utilisateur est connecté
        if (Auth::check()) {
            $panier = Panier::where('user_id', Auth::id())
                            ->where('produit_id', $produit->id)
                            ->first();

            if ($panier) {
                $panier->update([
                    'quantite' => $panier->quantite + $request->quantite,
                ]);
            } else {
                Panier::create([
                    'user_id' => Auth::id(),
                'produit_id' => $produit->id,
                    'quantite' => $request->quantite,
                ]);
            }
    } else {
        // Au lieu d'utiliser la session, on utilise la table paniers avec session_id
        $sessionId = $this->getOrCreateSessionId();
        $panier = Panier::where('session_id', $sessionId)
                        ->where('produit_id', $produit->id)
                        ->first();

        if ($panier) {
            $panier->update([
                'quantite' => $panier->quantite + $request->quantite,
            ]);
        } else {
            Panier::create([
                'session_id' => $sessionId,
                'produit_id' => $produit->id,
                    'quantite' => $request->quantite,
            ]);
        }
        }

        if ($request->has('redirect_to') && $request->redirect_to === 'panier') {
            return redirect()->route('panier.index');
        }

        return redirect()->back()->with('success', 'Produit ajouté au panier');
    }

    public function index()
    {
        $items = [];
        $totalPrixPanier = 0;

        if (Auth::check()) {
            $items = Panier::where('user_id', Auth::id())->with('produit')->get();
    } else {
        $sessionId = $this->getOrCreateSessionId();
        $items = Panier::where('session_id', $sessionId)->with('produit')->get();
    }

            $totalPrixPanier = $items->sum(function($item) {
                return $item->produit->prix * $item->quantite;
            });

    $totalProduitPanier = $items->sum('quantite');

    // Convertir la collection en array pour pouvoir utiliser count()
    $panier = $items->toArray();

    return view('user.pages.panier', compact('items', 'panier', 'totalPrixPanier', 'totalProduitPanier'));
}

    public function update(Request $request, $produitId)
    {
        $request->validate(['quantite' => 'required|integer|min:1']);

        if (Auth::check()) {
            $panier = Panier::where('user_id', Auth::id())
                                    ->where('produit_id', $produitId)
                                    ->firstOrFail();
        } else {
        $sessionId = $this->getOrCreateSessionId();
        $panier = Panier::where('session_id', $sessionId)
                        ->where('produit_id', $produitId)
                        ->firstOrFail();
    }

    $panier->update(['quantite' => $request->quantite]);
        return redirect()->back()->with('success', 'Quantité mise à jour');
    }

    public function remove($produitId)
    {
        if (Auth::check()) {
        Panier::where('user_id', Auth::id())
                                    ->where('produit_id', $produitId)
              ->delete();
        } else {
        $sessionId = $this->getOrCreateSessionId();
        Panier::where('session_id', $sessionId)
              ->where('produit_id', $produitId)
              ->delete();
        }

        return redirect()->back()->with('success', 'Produit retiré du panier');
    }

    public function clear()
    {
        if (Auth::check()) {
            Panier::where('user_id', Auth::id())->delete();
    } else {
        $sessionId = $this->getOrCreateSessionId();
        Panier::where('session_id', $sessionId)->delete();
        }
        return redirect()->back()->with('success', 'Panier vidé');
    }

    public function indexFavoris()
    {
        // Récupérer les IDs des favoris depuis la session
        $favorisIds = array_keys(Session::get('favoris', []));

        // Récupérer les produits correspondants
        $produits = Produit::whereIn('id', $favorisIds)->get();

        // Debug pour vérifier les données
        \Log::info('Favoris IDs:', ['ids' => $favorisIds]);
        \Log::info('Produits trouvés:', ['count' => $produits->count()]);

        return view('user.pages.favoris', compact('produits'));
    }

    public function toggle(Produit $produit)
{
    $favoris = Session::get('favoris', []);

    if (isset($favoris[$produit->id])) {
        unset($favoris[$produit->id]);
        Session::put('favoris', $favoris);
        Session::save(); // Force la sauvegarde de la session
        return response()->json(['status' => 'removed']);
    } else {
        $favoris[$produit->id] = true;
        Session::put('favoris', $favoris);
        Session::save(); // Force la sauvegarde de la session
        return response()->json(['status' => 'added']);
    }
}

    public function count()
    {
        $favoris = Session::get('favoris', []);
        return response()->json(['count' => count($favoris)]);
    }
}
