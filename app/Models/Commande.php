<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Commande extends Model
{
    //
    use HasFactory;

    // Laravel est assez intelligent pour deviner le nom de table 'commandes'
    // à partir du nom de modèle 'Commande'. Pas besoin de $table ici.

    protected $fillable = [
        'utilisateur_id',
        'numero_commande',
        'montant_total',
        'statut',
        'mode_paiement',
        'identifiant_transaction',
        'nom_client',
        'email_client',
        'telephone_client',
        'telephone_whatsapp',
        'adresse',
        'ville',
        'pays',
        'code_postal',
        'jeton_acces',
        'notification_whatsapp_envoyee',
        'notification_whatsapp_envoyee_le'
    ];

    /**
     * Relation: La commande appartient à un utilisateur.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class); // Assure-toi que le modèle User est bien App\Models\User
    }
    public function produits()
    {
        return $this->hasMany(CommandeProduit::class);
    }

    public function paiements()
{
    return $this->hasMany(Paiement::class);
}

    protected static function booted()
    {
        static::creating(function ($commande) {
            // Date au format court (mois/année)
            $date = date('ym'); // ex: 2404 pour avril 2024
            // 4 caractères aléatoires
            $random = strtoupper(substr(bin2hex(random_bytes(2)), 0, 4));
            // Résultat : CMD-2404-X9F2
            $commande->numero_commande = 'CMD-' . $date . '-' . $random;
        });
    }

}
