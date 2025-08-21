<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pub;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class AdminPubsController extends Controller
{
    //
    public function index(Request $request)
    {
        $pubs = Pub::latest()->get();

        // Calcul du nombre total de positions possibles (3 positions × 3 pages = 9)
        $totalPositionsPossibles = 9;
        $positionsOccupees = Pub::count();
        $peutAjouter = $positionsOccupees < $totalPositionsPossibles;

        if (request()->is('staff/*')) {
            return view('staff.pubs.view', compact('pubs', 'peutAjouter'));
        }
        return view('admin.pubs.view', compact('pubs', 'peutAjouter'));
    }

    public function create()
    {

        // Récupérer les positions déjà utilisées
        // Assurez-vous que les colonnes 'page' et 'position' existent dans la table 'pubs'
        $positions_utilisees = Pub::query()
            ->whereNotNull('page')
            ->whereNotNull('position')
            ->select(DB::raw("CONCAT(`page`, '_', `position`) as pos"))
            ->pluck('pos')
            ->toArray();

        if (request()->is('staff/*')) {
            return view('staff.pubs.create', compact('positions_utilisees'));
        }

        return view('admin.pubs.create', compact('positions_utilisees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'position_page' => 'required|string',
            'is_active' => 'boolean'
        ]);

        // Séparer la page et la position
        [$page, $position] = explode('_', $request->position_page);

        // Vérification plus précise des doublons
        $existingPub = Pub::where([
            'page' => $page,
            'position' => $position
        ])->first();

        if ($existingPub) {
            return back()
                ->withInput()
                ->with('error', "Une publicité existe déjà à cet emplacement ({$position}) sur la page {$page}");
        }

        // Traitement de l'image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->extension();

            // Assurez-vous que le dossier existe
            if (!file_exists(public_path('assets/pubs'))) {
                mkdir(public_path('assets/pubs'), 0777, true);
            }

            $image->move(public_path('assets/pubs'), $imageName);
        }

        // Création de la pub
        $pub = Pub::create([
            'titre' => $validated['titre'],
            'description' => $validated['description'],
            'image' => $imageName,
            'position' => $position,
            'page' => $page,
            'is_active' => $request->boolean('is_active', true)
        ]);

        \Log::info('Pub créée avec succès', [
            'id' => $pub->id,
            'page' => $page,
            'position' => $position
        ]);

        // Redirection selon le contexte
        if (request()->is('staff/*')) {
            return redirect()->route('staff.pubs.view')
                ->with('success', 'Publicité ajoutée avec succès');
        }

        return redirect()->route('admin.pubs.view')
            ->with('success', 'Publicité ajoutée avec succès');

    }

    public function edit(Pub $pub)
    {
        // Récupérer toutes les positions utilisées sauf celle de la pub en cours
        $positions_utilisees = Pub::where('id', '!=', $pub->id)
            ->whereNotNull('page')
            ->whereNotNull('position')
            ->select(DB::raw("CONCAT(page, '_', position) as pos"))
            ->pluck('pos')
            ->toArray();

        // Position actuelle de la pub
        $current_position = $pub->page . '_' . $pub->position;

        if (request()->is('staff/*')) {
            return view('staff.pubs.edite', compact('pub', 'positions_utilisees', 'current_position'));
        }

        return view('admin.pubs.edite', compact('pub', 'positions_utilisees', 'current_position'));
    }

    public function update(Request $request, Pub $pub)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'position_page' => 'required|string',  // Changé de 'position' à 'position_page'
            'is_active' => 'boolean'
        ]);

        // Séparer la page et la position
        [$page, $position] = explode('_', $request->position_page);

        // Vérifier si la nouvelle position est déjà prise par une autre pub
        $existingPub = Pub::where('id', '!=', $pub->id)
            ->where('page', $page)
            ->where('position', $position)
            ->first();

        if ($existingPub) {
            return back()
                ->withInput()
                ->with('error', "Cette position est déjà utilisée sur cette page");
        }

        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image si elle existe
            if (file_exists(public_path('assets/pubs/' . $pub->image))) {
                unlink(public_path('assets/pubs/' . $pub->image));
            }

            // Stocker la nouvelle image
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->extension();
            $image->move(public_path('assets/pubs'), $imageName);
            $validated['image'] = $imageName;
        }

        // Mise à jour avec les bonnes données
        $pub->update([
            'titre' => $validated['titre'],
            'description' => $validated['description'],
            'position' => $position,
            'page' => $page,
            'is_active' => $request->boolean('is_active', true),
            'image' => $validated['image'] ?? $pub->image
        ]);

        \Log::info('Pub mise à jour avec succès', [
            'id' => $pub->id,
            'page' => $page,
            'position' => $position
        ]);

        if (request()->is('staff/*')) {
            return redirect()->route('staff.pubs.view')
                ->with('success', 'Publicité mise à jour avec succès');
        }

        return redirect()->route('admin.pubs.view')
            ->with('success', 'Publicité mise à jour avec succès');
    }

    public function destroy(Pub $pub)
    {
        Storage::delete('public/pubs/' . $pub->image);
        $pub->delete();

        if (request()->is('staff/*')) {
            return redirect()->route('staff.pubs.view')
                ->with('success', 'Publicité supprimée avec succès');
        }

        return redirect()->route('admin.pubs.view')
            ->with('success', 'Publicité supprimée avec succès');
    }
}
