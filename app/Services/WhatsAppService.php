<?php

namespace App\Services;

use App\Models\Commande;

class WhatsappService
{

    public function sendWhatsappMessage($commande)
    {
        try {
            // Récupérer les produits de la commande
            $items = $commande->produits()->with('produit')->get();

            // Construction du message
            $message = "🎉 *Merci pour votre commande chez El Papiro !*\n\n";
            $message .= "📦 *Commande #{$commande->numero_commande}*\n\n";
            $message .= "👤 *Informations client :*\n";
            $message .= "Nom : {$commande->nom_client}\n";
            $message .= "Téléphone : {$commande->telephone_client}\n";
            $message .= "Email : {$commande->email_client}\n\n";
            $message .= "📍 *Adresse de livraison :*\n";
            $message .= "{$commande->adresse}\n";
            $message .= "{$commande->ville}, {$commande->pays}\n\n";

            // Ajout des produits commandés
            $message .= "🛒 *Produits commandés :*\n";
            foreach ($items as $item) {
                $message .= "• {$item->produit->name}\n";
                $message .= "  Quantité : {$item->quantite}\n";
                $message .= "  Prix unitaire : {$item->prix} FCFA\n";
                $message .= "  Sous-total : " . ($item->prix * $item->quantite) . " FCFA\n\n";
            }

            $message .= "💰 *Montant total :* {$commande->montant_total} FCFA\n\n";
            $message .= "📝 *Mode de paiement :* {$commande->mode_paiement}\n\n";

            // Ajout du lien vers le résumé
            $resumeLink = route('checkout.resume', $commande->numero_commande);
            $message .= "🔗 *Consultez le détail de votre commande :*\n";
            $message .= "{$resumeLink}\n\n";

            $message .= "Pour toute question, n'hésitez pas à nous contacter.\n";
            $message .= "Merci de votre confiance en El Papiro ! 🙏";

            // Formatage du numéro de téléphone
            $numeroClient = '228' . ltrim($commande->telephone_client, '0');

            // Encodage du message pour l'URL
            $messageEncoded = urlencode($message);

            // Construction de l'URL WhatsApp
            $url = "https://api.whatsapp.com/send?phone={$numeroClient}&text={$messageEncoded}";

            return [
                'success' => true,
                'url' => $url
            ];

        } catch (\Exception $e) {
            \Log::error('Erreur lors de l\'envoi du message WhatsApp: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
}