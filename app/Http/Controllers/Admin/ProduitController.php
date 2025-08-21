<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\Categorie\Admin;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
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
                    ->orWhere('categories.name', 'like', "%{$keyWord}%");

                if (is_numeric($keyWord)) {
                    $q->orWhere('produits.prix', '>=', $keyWord);
                }
            });
        }

        $produit = $query->paginate(5)->appends(['search' => $keyWord]);
        $total_produits = DB::table('produits')->count();

        return view('admin.produit.index', compact('produit', 'total_produits', 'keyWord'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $categorie = Categorie::all();
        return view('admin.produit.create', compact('categorie'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data = $request->validate([
            'name' => ['required','string','max:225'],
            'categorie_id' => ['required', 'integer'],
            'prix'=> ['required','numeric', 'min:500'], // Ajout de min:0 pour éviter les prix négatifs
            'quantite' => ['required','integer', 'min:1'], // Ajout de min:0 pour éviter les quantités négatives
            'description' => ['required','string','max:1000'],
            'image' => ['required','image','mimes:png,jpg,jpeg,webp'],
            'sous_categorie' => ['required'],
        ]);

        $produit = new Produit();
        $produit->name = $data['name'];
        $produit->categorie_id = $data['categorie_id'];
        $produit->prix = $data['prix'];
        $produit->sous_categorie = $data['sous_categorie'];
        $produit->quantite_stock = $data['quantite'];
        $produit->description = $data['description'];

        // Traitement de l'image
        if ($data['image']) {
            $file = $data['image'];
            // dd($data['image']);
            $imageName = now()->format('Y-m-d_H-i-s') . '_' . $file->getClientOriginalName();
            // dd($imageName);
            $file->move('assets/produits/', $imageName);

            $produit->image = $imageName;
        }

        $produit->save();

        return to_route('produit.index')->with('message', "Produit ajouté avec succès !");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        //
        $produit = Produit::where('slug', $slug)->firstOrFail();
        return view('admin.produit.show', compact('produit'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug)
    {
        //
        $categorie = Categorie::all();
        $produit = Produit::where('slug', $slug)->firstOrFail();
        return view('admin.produit.edit', compact('produit', "categorie"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $produit = Produit::findOrFail($id);
                //
                $data = $request->validate([
                    'name' => ['required','string','max:225'],
                    'categorie_id' => ['required', 'integer'],
                    'prix'=> ['required','numeric', 'min:500'], // Ajout de min:0 pour éviter les prix négatifs
                    'quantite' => ['required','integer', 'min:1'], // Ajout de min:0 pour éviter les quantités négatives
                    'description' => ['required','string','max:1000'],
                    'sous_categorie' => ['required'],
                ]);



                // Traitement de l'image
                // 'image' => ['required','image','mimes:png,jpg,jpeg'],
                if ($request->hasFile('image')) {

                    $data += $request->validate([
                        'image' => ['required','image','mimes:png,jpg,jpeg,webp'],
                    ]);
                    $file = $data['image'];
                    // dd($data['image']);
                    $imageName = now()->format('Y-m-d_H-i-s') . '_' . $file->getClientOriginalName();
                    // dd($imageName);


                    // Supprimer l'image existante
                    $path = 'assets/produits/' . $produit->image;

                    if (file_exists($path)) {
                        unlink($path);
                    }


                    $file->move('assets/produits/', $imageName);

                    $produit->image = $imageName;
                }



                $produit->name = $data['name'];
                $produit->categorie_id = $data['categorie_id'];
                $produit->prix = $data['prix'];
                $produit->sous_categorie = $data['sous_categorie'];
                $produit->quantite_stock = $data['quantite'];
                $produit->description = $data['description'];


                $produit->update();

                return to_route('produit.index')->with('message', "Produit modifié avec succès !");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $produit = Produit::findOrFail($id);
        // Supprimer l'image existante
        $path = 'assets/produits/' . $produit->image;

        if (file_exists($path)) {
            unlink($path);
        }

        $produit->delete();
        return to_route('produit.index')->with('message', "Produit supprimé avec succès !");


    }
}
