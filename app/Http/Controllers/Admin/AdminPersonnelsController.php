<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminPersonnelsController extends Controller
{
    //
    public function view()
    {
        $personnels = User::where('role', '!=', 'client')->get();
        return view('admin.personnels.view', compact('personnels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|in:admin,staff'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make('password123')
        ]);

        return redirect()->back()->with('success', 'Membre du personnel ajouté avec succès');
    }

    public function update(Request $request, User $user)
    {
        // Vérifier si l'utilisateur est admin ou si c'est son propre compte
        if ($user->role === 'admin' && $user->id !== auth()->id()) {
            return redirect()->back()->with('error', 'Vous ne pouvez pas modifier un autre compte administrateur');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'Informations mises à jour avec succès');
    }

    public function destroy(User $user)
    {
        // Empêcher la suppression des administrateurs sauf son propre compte
        if ($user->role === 'admin' && $user->id !== auth()->id()) {
            return redirect()->back()->with('error', 'Vous ne pouvez pas supprimer un autre compte administrateur');
        }

        // Empêcher la suppression de son propre compte
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte');
        }

        $user->delete();
        return redirect()->back()->with('success', 'Membre supprimé avec succès');
    }

    public function updateAdminPassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
            'new_password_confirmation' => 'required'
        ], [
            'current_password.required' => 'Le mot de passe actuel est requis',
            'new_password.required' => 'Le nouveau mot de passe est requis',
            'new_password.min' => 'Le nouveau mot de passe doit contenir au moins 8 caractères',
            'new_password.confirmed' => 'La confirmation du mot de passe ne correspond pas',
            'new_password_confirmation.required' => 'La confirmation du mot de passe est requise'
        ]);

        try {
            // Vérifier si le mot de passe actuel est correct
            if ($request->current_password !== env('ADMIN_ACCESS_PASSWORD')) {
                return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect']);
            }

            // Mettre à jour le fichier .env
            $envFile = base_path('.env');
            $envContent = file_get_contents($envFile);

            if ($envContent === false) {
                throw new \Exception('Impossible de lire le fichier .env');
            }

            $newEnvContent = preg_replace(
                '/^ADMIN_ACCESS_PASSWORD=.*$/m',
                'ADMIN_ACCESS_PASSWORD=' . $request->new_password,
                $envContent
            );

            if ($newEnvContent === null || $newEnvContent === $envContent) {
                throw new \Exception('Erreur lors de la modification du mot de passe');
            }

            if (file_put_contents($envFile, $newEnvContent) === false) {
                throw new \Exception('Impossible d\'écrire dans le fichier .env');
            }

            // Effacer le cache de configuration
            \Artisan::call('config:clear');

            return redirect()->back()->with('success', 'Mot de passe administrateur mis à jour avec succès.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['update_password_error' => 'Une erreur est survenue : ' . $e->getMessage()]);
        }
    }
}
