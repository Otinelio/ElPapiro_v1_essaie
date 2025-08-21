<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    //
    use HasFactory;
    public function categorie() {
        return $this->belongsTo(Categorie::class);
    }
    public function paniers() {
        return $this->hasMany(Panier::class);
    }

    public function commandes()
{
    return $this->hasMany(CommandeProduit::class);
}

    use Sluggable;
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name', // Générer le slug à partir du champ "name"
                'onUpdate' => true, // Met à jour le slug si "name" est modifié
            ],
        ];
    }

    const SOUS_CATEGORIES = [
        'Huiles',
        'Pâtes',
        'Conserves',
        'Produits Laitiers',
        'Sucres & Edulcolorants',
        'Produits à base de Chocolat',
        'Condiments',
        'Vins & Boissons',
        'Soins du Visage',
        'Hygiène Bucco-Dentaire',
        'Soins Corporels',
        'Nettoyants',
        'Désodorisants'
    ];
} 