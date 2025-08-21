<?php

namespace App\Mail;

use App\Models\Commande;
use App\Models\Panier;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailCommande extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $commande;
    public $items;
    public $total;

    public function __construct(Commande $commande, $items)
    {
        $this->commande = $commande;
        $this->items = $items->map(function($item) {
            return [
                'produit' => $item->produit->toArray(),
                'quantite' => $item->quantite,
                'prix' => $item->prix
            ];
        })->toArray();

        $this->total = 0;
    foreach ($this->items as $item) {
        $this->total += $item['prix'] * $item['quantite'];
    }
    }


    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Résumé de la commande',
            replyTo: [
                new Address('ecom@elpapiro.com', 'El Papiro')
                ]
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {


        return new Content(
            view: 'emails.order-confirmation',
            with: [
                'commande' => $this->commande,
                'items' => $this->items,
                'total' => $this->total,
                'orderLink' => route('checkout.resume', $this->commande->numero_commande)
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
