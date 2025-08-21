<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommandeProduit extends Model
{
    //
    
    use HasFactory;

    // Si tu as besoin de spécifier les champs autorisés pour l'assignation de masse
    protected $fillable = ['commande_id', 'produit_id', 'prix', 'quantite'];

    // Relation avec le modèle Commande
    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }

    // Relation avec le modèle Produit
    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }
}