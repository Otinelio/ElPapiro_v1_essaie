<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\EmailCommande;
use App\Models\Pub;
use App\Rules\NumeroTelephoneTogolais;
use Illuminate\Http\Request;
use App\Models\Panier;
use App\Models\Commande;
use App\Models\CommandeProduit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Models\Produit;
use App\Services\WhatsappService;
use Illuminate\Support\Facades\Mail;

class CheckOutController extends Controller
{
    /**
     * Affiche la page de checkout
     */

    protected $whatsappService;

    public function __construct(WhatsappService $whatsappService)
    {
        $this->whatsappService = $whatsappService;
    }

    public function show()
    {
        $items = [];
        $totalPrixPanier = 0;

        if (Auth::check()) {
            $items = Panier::where('user_id', Auth::id())->with('produit')->get();
        } else {
            $sessionId = $this->getOrCreateSessionId();
            $items = Panier::where('session_id', $sessionId)->with('produit')->get();
        }

        $totalPrixPanier = $items->sum(function ($item) {
            return $item->produit->prix * $item->quantite;
        });

        if ($items->isEmpty()) {
            return redirect()->route('panier.index')->with('info', 'Votre panier est vide. Pour pouvoir passer commande, veuillez ajouter des produits à votre panier.');
        }

        $totalProduitPanier = $items->sum('quantite');

        // Récupérer les informations de checkout précédentes si elles existent
        $checkoutInfo = session('checkout_info', []);
        // pub
        // Dans les contrôleurs respectifs (BoutiqueController, etc.)
        $pubs = Pub::where('is_active', true)
            ->where('page', 'checkout') //  'detail-boutique' ou 'checkout'ou 'checkout'
            ->orderBy('position')
            ->get();

        return view('user.pages.check-out', compact('items', 'totalPrixPanier', 'totalProduitPanier', 'checkoutInfo', 'pubs'));
    }

    public function process(Request $request)
    {

        // 1. Récupération cohérente du panier
        $items = [];
        if (Auth::check()) {
            $items = Panier::where('user_id', Auth::id())
                ->with('produit')
                ->get();
        } else {
            $sessionId = $this->getOrCreateSessionId();
            $items = Panier::where('session_id', $sessionId)
                ->with('produit')
                ->get();
        }

        // 2. Vérification du panier
        if ($items->isEmpty()) {
            return redirect()->route('panier.index')
                ->with('error', 'Votre panier est vide. Veuillez ajouter des produits avant de continuer.');
        }

        // Vérification que tous les produits existent encore
        foreach ($items as $item) {
            if (!$item->produit) {
                return redirect()->route('panier.index')
                    ->with('error', 'Un ou plusieurs produits de votre panier ne sont plus disponibles.');
            }
        }


        // 2. Validation des informations du formulaire
        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'client_phone' => [
                'required',
                'string',
                new NumeroTelephoneTogolais(),
            ],
            'client_email' => 'required|email|max:255',
            'adresse' => 'required|string|max:255',
            'ville' => 'required|string|max:255',
            'pays' => 'required|in:TG',
            'payment_mode' => 'required|in:cinetpay,livraison,boutique',
        ], [
            'client_name.required' => 'Le nom complet est requis.',
            'client_name.max' => 'Le nom ne doit pas dépasser 255 caractères.',

            'client_phone.required' => 'Le numéro de téléphone est requis.',
            'client_phone.string' => 'Le numéro de téléphone doit être une chaîne de caractères.',

            'client_email.required' => 'L\'adresse email est requise.',
            'client_email.email' => 'Veuillez entrer une adresse email valide.',
            'client_email.max' => 'L\'adresse email ne doit pas dépasser 255 caractères.',

            'adresse.required' => 'L\'adresse est requise.',
            'adresse.max' => 'L\'adresse ne doit pas dépasser 255 caractères.',

            'ville.required' => 'La ville est requise.',
            'ville.max' => 'Le nom de la ville ne doit pas dépasser 255 caractères.',

            'pays.required' => 'Le pays est requis.',
            'pays.in' => 'Le pays sélectionné n\'est pas valide.',

            'payment_mode.required' => 'Veuillez sélectionner un mode de paiement.',
            'payment_mode.in' => 'Le mode de paiement sélectionné n\'est pas valide.',
        ]);

        // 3. Calcul du total du panier
        $montantTotal = $items->sum(function ($item) {
            return $item->produit->prix * $item->quantite;
        });

        // Création de la commande
        $commande = Commande::create([
            'utilisateur_id' => Auth::id() ?? null,
            'identifiant_transaction' => null,
            'montant_total' => $montantTotal,
            'statut' => 'en_attente',
            'mode_paiement' => $validated['payment_mode'],
            'nom_client' => $validated['client_name'],
            'telephone_client' => $validated['client_phone'],
            'telephone_whatsapp' => $validated['client_phone'],
            'email_client' => $validated['client_email'],
            'adresse' => $validated['adresse'],
            'ville' => $validated['ville'],
            'pays' => $validated['pays'],
            'code_postal' => $validated['code_postal'] ?? null,
            'numero_commande' => 'EP-' . date('Ymd') . '-' . random_int(1000, 9999),  // On garde uniquement celui-ci
            'jeton_acces' => uniqid('access_', true)
        ]);

        foreach ($items as $item) {
            // 1. Création de la ligne de commande
            CommandeProduit::create([
                'commande_id' => $commande->id,
                'produit_id' => $item->produit_id,
                'prix' => $item->produit->prix,
                'quantite' => $item->quantite,
            ]);

            // 2. Décrémenter le stock du produit
            $produit = $item->produit;
            if ($produit) {
                $produit->decrement('quantite_stock', $item->quantite);
            }
        }

        // 3. Vider le panier
        if (Auth::check()) {
            Panier::where('user_id', Auth::id())->delete();
        } else {
            $sessionId = $this->getOrCreateSessionId();
            Panier::where('session_id', $sessionId)->delete();
        }




        // dd($commande);
        // Envoi de l'email de confirmation
        Mail::to($commande["email_client"])->send(new EmailCommande($commande, $items));


        // Redirection selon le mode de paiement
        switch ($validated['payment_mode']) {
            case 'cinetpay':
                return redirect()->route('payement.redirection', $commande->id);

            case 'livraison':
            case 'boutique':
                $message = $validated['payment_mode'] === 'livraison'
                    ? 'Votre commande sera livrée. Paiement à la livraison. Nous vous a envoyé un email avec les informations pour la livraison.'
                    : 'Votre commande est prête pour le retrait en boutique. Nous vous a envoyé un email avec les informations pour le retrait.';

                return redirect()->route('checkout.resume', $commande->numero_commande)
                    ->with('success', $message);
        }

    }


    public function resume($numero_commande)
    {
        try {
            // Rechercher la commande par son numéro unique
            $commande = Commande::where('numero_commande', $numero_commande)->firstOrFail();

            // Vérifier si la commande appartient à l'utilisateur actuel
            if (Auth::check() && $commande->user_id !== Auth::id()) {
                return redirect()->route('user.index')
                    ->with('error', 'Vous n\'êtes pas autorisé à voir cette commande.');
            }

            // Récupérer les produits de la commande
            $items = $commande->produits()->with('produit')->get();

            if ($items->isEmpty()) {
                return redirect()->route('user.index')
                    ->with('error', 'Cette commande ne contient aucun produit.');
            }

            // Calculer le total
            $total = $items->sum(function ($item) {
                return $item->prix * $item->quantite;
            });

            $totalProduitPanier = $items->sum('quantite');

            // Génération du lien WhatsApp
            $whatsappResponse = $this->whatsappService->sendWhatsappMessage($commande);
            $url = $whatsappResponse['success'] ? $whatsappResponse['url'] : null;

            // Retourner la vue avec les informations de la commande
            return view('user.pages.checkout.resume', compact('commande', 'items', 'total', 'totalProduitPanier', 'url'));

        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'affichage du résumé de la commande: ' . $e->getMessage());
            return redirect()->route('user.index')
                ->with('error', 'Une erreur est survenue lors de l\'affichage du résumé de la commande.');
        }
    }
}