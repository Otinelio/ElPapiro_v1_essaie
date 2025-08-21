<?php

    namespace App\Http\Controllers\User;

    use App\Http\Controllers\Controller;
    use App\Mail\EmailCommande;
    use App\Models\Commande;
    use App\Services\WhatsAppService;
    use App\Services\EmailService;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Support\Facades\Mail;

    class CommandeController extends Controller
    {
        protected $whatsAppService;
        protected $emailService;

        public function __construct(WhatsAppService $whatsAppService, EmailService $emailService)
        {
            $this->whatsAppService = $whatsAppService;
            $this->emailService = $emailService;
        }

        public function index()
        {
            try {
                $commandes = Commande::where('user_id', Auth::id())
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);

                return view('user.pages.commandes.index', compact('commandes'));

            } catch (\Exception $e) {
                return redirect()->route('user.index')
                    ->with('error', 'Une erreur est survenue lors de la récupération des commandes.');
            }
        }

        public function show(Commande $commande)
        {
            try {
                if ($commande->user_id !== Auth::id()) {
                    return redirect()->route('user.commandes.index')
                        ->with('error', 'Vous n\'êtes pas autorisé à voir cette commande.');
                }

                $items = $commande->produits()->with('produit')->get();
                $total = $items->sum(function ($item) {
                    return $item->prix * $item->quantite;
                });

                // Générer le lien WhatsApp pour le récapitulatif
                $whatsappLink = $this->whatsAppService->generateWhatsAppLink($commande);

                return view('user.pages.commandes.show', compact('commande', 'items', 'total', 'whatsappLink'));

            } catch (\Exception $e) {
                return redirect()->route('user.commandes.index')
                    ->with('error', 'Une erreur est survenue lors de l\'affichage de la commande.');
            }
        }

        public function store(Request $request)
        {
            try {
                // Validation des données
                $validated = $request->validate([
                    'client_name' => 'required|string|max:255',
                    'client_email' => 'required|email',
                    'client_phone' => 'required|string',
                    'whatsapp_phone' => 'required|string',
                    'adresse' => 'required|string',
                    'ville' => 'required|string',
                    'pays' => 'required|string',
                    'mode_paiement' => 'required|in:especes,orange-money,wave,free-money',
                    'prix_total' => 'required|numeric|min:0'
                ]);

                // Création de la commande
                $commande = Commande::create([
                    'utilisateur_id' => Auth::id(),
                    'numero_commande' => uniqid('CMD-'),
                    'nom_client' => $validated['client_name'],
                    'email_client' => $validated['client_email'],
                    'telephone_client' => $validated['client_phone'],
                    'telephone_whatsapp' => $validated['whatsapp_phone'],
                    'adresse' => $validated['adresse'],
                    'ville' => $validated['ville'],
                    'pays' => $validated['pays'],
                    'mode_paiement' => $validated['mode_paiement'],
                    'montant_total' => $validated['prix_total'],
                    'statut' => 'en_attente',
                    'jeton_acces' => \Str::random(32),
                ]);

                // Génération du lien WhatsApp
                $whatsappLink = $this->whatsAppService->generateWhatsAppLink($commande);


                // Envoi de l'email de confirmation
                Mail::to($validated['client_email'])->send(new EmailCommande($commande));
                // $this->emailService->sendOrderConfirmation($commande);

                // Vider le panier après la commande
                session()->forget('cart');

                return redirect()->route('user.commandes.show', $commande)
                    ->with('success', 'Commande créée avec succès !')
                    ->with('whatsappLink', $whatsappLink);

            } catch (\Exception $e) {
                Log::error('Erreur lors de la création de la commande: ' . $e->getMessage());
                return back()
                    ->with('error', 'Une erreur est survenue lors de la création de la commande.')
                    ->withInput();
            }
        }

        public function adminIndex()
        {
            $commandes = Commande::orderBy('created_at', 'desc')->paginate(15);

            // Détecter si c'est un appel staff ou admin
            if (request()->is('staff/*')) {
                return view("staff.commande.view", compact('commandes'));
            }

            return view("admin.commande.view", compact('commandes'));
        }

        public function adminShow(Commande $commande)
        {
            // Récupère les produits associés à la commande, si besoin
            $items = $commande->produits()->with('produit')->get();

            // Détecter si c'est un appel staff ou admin
            if (request()->is('staff/*')) {
                return view('staff.commande.show', compact('commande', 'items'));
            }

            return view('admin.commande.show', compact('commande', 'items'));
        }

        public function adminEdit(Commande $commande)
        {
            // On ne peut pas éditer une commande terminée ou annulée
            if (in_array($commande->statut, ['terminee', 'annulee'])) {
                $route = request()->is('staff/*') ? 'staff.commande.index' : 'commande.index';
                return redirect()->route($route)->with('error', 'Impossible de modifier une commande validée ou annulée.');
            }

            $commande->load('paiements');
            $paiement = $commande->paiements->first();
            $paiementValide = $paiement && $paiement->statut === 'effectue';

            // Détecter si c'est un appel staff ou admin
            if (request()->is('staff/*')) {
                return view('staff.commande.edit', compact('commande', 'paiement', 'paiementValide'));
            }

            return view('admin.commande.edit', compact('commande', 'paiement', 'paiementValide'));
        }

        public function adminUpdate(Request $request, Commande $commande)
        {
            // Blocage si déjà validée ou annulée
            if (in_array($commande->statut, ['terminee', 'annulee'])) {
                return redirect()->route('commande.index')->with('error', 'Impossible de modifier une commande validée ou annulée.');
            }

            $validated = $request->validate([
                'statut' => 'required|in:en_attente,terminee,annulee',
            ]);

            // Si on veut passer la commande à terminée, vérifier le paiement
            if ($validated['statut'] === 'terminee') {
                $paiement = $commande->paiements()->first();
                if (!$paiement || $paiement->statut !== 'effectue') {
                    return back()->with('error', 'Le paiement doit être validé avant de valider la commande.');
                }
            }

            $commande->update($validated);

            if (request()->is('staff/*')) {
                return redirect()->route('staff.commande.index')->with('success', 'Commande mise à jour avec succès.');
            }
            return redirect()->route('commande.index')->with('success', 'Commande mise à jour avec succès.');
        }

        public function annuler(Commande $commande)
        {
            if (in_array($commande->statut, ['terminee', 'annulee'])) {
                return redirect()->route('commande.index')->with('error', 'Impossible d\'annuler une commande déjà validée ou annulée.');
            }
            $commande->update(['statut' => 'annulee']);
            return redirect()->route('commande.index')->with('success', 'Commande annulée.');
        }

        public function showPaiementForm(Commande $commande)
        {
            // Blocage si déjà validée ou annulée
            if (in_array($commande->statut, ['terminee', 'annulee'])) {
                $route = request()->is('staff/*') ? 'staff.commande.index' : 'commande.index';
                return redirect()->route($route)->with('error', 'Impossible de valider le paiement pour une commande validée ou annulée.');
            }

            // Détecter si c'est un appel staff ou admin
            if (request()->is('staff/*')) {
                return view('staff.commande.paiement', compact('commande'));
            }

            return view('admin.commande.paiement', compact('commande'));
        }

        public function validerPaiement(Request $request, Commande $commande)
        {
            // Blocage si déjà validée ou annulée
            if (in_array($commande->statut, ['terminee', 'annulee'])) {
                return redirect()->route('commande.index')->with('error', 'Impossible de valider le paiement pour une commande validée ou annulée.');
            }

            $data = $request->validate([
                'montant' => 'required|numeric|min:0',
                'methode' => 'required|string',
                'statut' => 'required|in:effectue,en_attente,echoue',
            ]);

            // Empêcher la création de plusieurs paiements validés
            $paiement = $commande->paiements()->first();
            if ($paiement && $paiement->statut === 'effectue') {
                return redirect()->route('commande.index')->with('error', 'Le paiement a déjà été validé.');
            }

            // Création ou mise à jour du paiement
            if ($paiement) {
                $paiement->update($data);
            } else {
                $paiement = \App\Models\Paiement::create([
                    'commande_id' => $commande->id,
                    'montant' => $data['montant'],
                    'methode' => $data['methode'],
                    'statut' => $data['statut'],
                ]);
            }

            // Si le paiement est validé, on valide la commande
            if ($paiement->statut === 'effectue') {
                $commande->update(['statut' => 'terminee']);
            }

            return redirect()->route('commande.index')->with('success', 'Paiement enregistré et commande validée.');
        }
    }
