<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\Produit;
use App\Models\Pub;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    //

    public function index(Request $request)
    {


        $produits = Produit::inRandomOrder()->limit(8)->get();
        $totalProduitPanier = $this->getCartTotal();
        return view('user.index', compact('produits', 'totalProduitPanier'));
    }
    public function boutique(Request $request)
    {

        $query = DB::table('produits')
            ->select('produits.*', 'categories.name as categorie_name')
            ->join('categories', 'categories.id', '=', 'produits.categorie_id')
            ->orderBy('produits.created_at', 'desc');

        $keyWord = $request->input('search');
        if ($keyWord) {
            $query->where(function ($q) use ($keyWord) {
                $q->where('produits.name', 'like', "%{$keyWord}%")
                    ->orWhere('produits.description', 'like', "%{$keyWord}%")
                    ->orWhere('produits.sous_categorie', 'like', "%{$keyWord}%")
                    ->orWhere('categories.name', 'like', "%{$keyWord}%");

                if (is_numeric($keyWord)) {
                    $q->orWhere('produits.prix', '>=', $keyWord);
                }
            });
        }




        $produits = $query->orderByDesc('updated_at')->paginate(8)->appends(['search' => $keyWord]);
        $total_produits = DB::table('produits')->count();
        $categories = Categorie::all();

        $totalProduitPanier = $this->getCartTotal();

        $pubs = Pub::where('is_active', true)
            ->where('page', 'boutique') // ou 'detail-boutique' ou 'checkout'
            ->orderBy('position')
            ->get();
        return view('user.pages.boutique', compact('produits', 'total_produits', 'keyWord', 'categories', 'totalProduitPanier', 'pubs'));


        // $produits = Produit::with('categorie')->orderByDesc('updated_at')->paginate(8);
        // return view('user.pages.boutique', compact('produits'));
    }
    public function detailboutique($slug, request $request)
    {
        $produit = Produit::where("slug", $slug)->firstOrFail();

        $produits = Produit::where('categorie_id', $produit->categorie_id)
            ->whereNot('id', $produit->id)
            ->inRandomOrder()->limit(4)->get();

        // Pour la partie de l'affichage des sous catégories

        $sousCategories = Produit::SOUS_CATEGORIES;
        $nombreProduits = [];
        foreach ($sousCategories as $categorie) {
            $nombreProduits[$categorie] = Produit::where('sous_categorie', $categorie)->count();
        }

        // Pour la partie recherche

        $query = DB::table('produits')
            ->select('produits.*', 'categories.name as categorie_name')
            ->join('categories', 'categories.id', '=', 'produits.categorie_id')
            ->orderBy('produits.created_at', 'desc');

        $keyWord = $request->input('search');
        if ($keyWord) {
            $query->where(function ($q) use ($keyWord) {
                $q->where('produits.name', 'like', "%{$keyWord}%")
                    ->orWhere('produits.description', 'like', "%{$keyWord}%")
                    ->orWhere('produits.sous_categorie', 'like', "%{$keyWord}%")
                    ->orWhere('categories.name', 'like', "%{$keyWord}%");

                if (is_numeric($keyWord)) {
                    $q->orWhere('produits.prix', '>=', $keyWord);
                }
            });
        }

        $totalProduitPanier = $this->getCartTotal();
        // Dans les contrôleurs respectifs (BoutiqueController, etc.)
        $pubs = Pub::where('is_active', true)
            ->where('page', 'detail-boutique') // ou 'detail-boutique' ou 'checkout'
            ->orderBy('position')
            ->get();
        return view('user.pages.detail-boutique', compact('produit', 'produits', 'nombreProduits', 'totalProduitPanier', 'pubs'));
    }

}
