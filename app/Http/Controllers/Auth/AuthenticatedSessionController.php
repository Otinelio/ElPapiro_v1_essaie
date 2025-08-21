<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Panier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View|RedirectResponse // Modifier le type de retour
    {
        // Vérifier l'accès admin directement ici
        if (!session()->has('admin_access_granted')) {
            session(['intended_url' => route('login')]);
            return redirect()->route('admin.access.check');
        }

        return view('auth.login');
    }

    protected function authenticated(Request $request, $user)
    {
        // Transférer le panier de la session vers la base de données
        if (session()->has('panier')) {
            foreach (session('panier') as $produitId => $item) {
                // Vérifier si le produit est déjà dans le panier de l'utilisateur
                $panier = Panier::where('user_id', $user->id)
                    ->where('produit_id', $produitId)
                    ->first();

                if ($panier) {
                    // Mettre à jour la quantité
                    $panier->update([
                        'quantite' => $panier->quantite + $item['quantite']
                    ]);
                } else {
                    // Ajouter un nouvel article au panier
                    Panier::create([
                        'user_id' => $user->id,
                        'produit_id' => $produitId,
                        'quantite' => $item['quantite']
                    ]);
                }
            }
            // a revoir
            // // Vider le panier de la session
            // session()->forget('panier');
        }
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        //ligne pour appeler la méthode authenticated
        $this->authenticated($request, $user);

        if ($user->role == "admin") {
            return redirect()->route('produit.index');
        } else if ($user->role == "staff") {
            return redirect()->route('staff.produit.index');
        }

        return redirect()->intended(route('user.index', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('accueil');
    }
}
