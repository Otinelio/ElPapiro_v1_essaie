<?php

namespace App\Services;

use App\Models\Commande;
use Illuminate\Support\Facades\Mail;

class EmailService
{
    public function sendOrderConfirmation(Commande $commande)
    {
        try {
            $items = $commande->produits()->with('produit')->get();
            $total = $items->sum(function ($item) {
                return $item->prix * $item->quantite;
            });

            $data = [
                'commande' => $commande,
                'items' => $items,
                'total' => $total,
                'orderLink' => route('checkout.resume', $commande->numero_commande)
            ];

            Mail::send('emails.order-confirmation', $data, function($message) use ($commande) {
                $message->to($commande->email_client)
                        ->subject('Confirmation de commande - El Papiro #' . $commande->numero_commande);
            });

            return true;
        } catch (\Exception $e) {
            \Log::error('Erreur envoi email commande: ' . $e->getMessage());
            return false;
        }
    }
}
