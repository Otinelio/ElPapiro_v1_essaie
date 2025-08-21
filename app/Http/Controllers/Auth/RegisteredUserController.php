<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Panier;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View|RedirectResponse
    {
        // Vérifier l'accès admin directement ici
        if (!session()->has('admin_access_granted')) {
            session(['intended_url' => route('register')]);
            return redirect()->route('admin.access.check');
        }

        return view('auth.register');
    }

    protected function registered(Request $request, $user)
    {
        // Transférer le panier de la session vers la base de données
        if (session()->has('panier')) {
            foreach (session('panier') as $produitId => $item) {
                Panier::create([
                    'user_id' => $user->id,
                    'produit_id' => $produitId,
                    'quantite' => $item['quantite']
                ]);
            }

            // Vider le panier de la session
            session()->forget('panier');
        }

    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        // Ne pas connecter automatiquement l'utilisateur
        // Auth::login($user);

        // Rediriger vers une page de confirmation
        return redirect()->route('register.confirmation')
            ->with('success', 'Inscription réussie ! Votre compte est en attente de validation par l\'administration.');

        // return redirect(route('dashboard', absolute: false));
        // Appeler la méthode registered() manuellement
        // return $this->registered($request, $user) ?: redirect(route('user.index', absolute: false));

    }

    /**
     * Afficher la page de confirmation après inscription
     */
    public function confirmation(): View
    {
        return view('auth.register-confirmation');
    }
}
