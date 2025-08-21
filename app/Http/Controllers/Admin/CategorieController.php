<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategorieController extends Controller
{
    //
    public function index() {

        $categorie = Categorie::all();
        return view("admin.categorie.index", compact("categorie"));
    }
    public function create() {
        return view("admin.categorie.create");
    }
    public function store(Request $request) {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:225'],
            "description" => ['nullable', "string", 'max:225']
        ]);

        $categorie = new Categorie();
        $categorie->name = $data['name'];
        $categorie->description = $data['description'];
        $categorie->save();
        // return redirect()->route('categorie.index');
        return to_route('categorie.index')->with('message', "Catégorie ajoutée avec succès !");
    }

    public function destroy($id) {
        $categorie = Categorie::findOrFail($id);
        $categorie->delete();
        return to_route("categorie.index")->with("message","Catégorie supprimée avec succès.");
    }
}
