<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->enum('sous_categorie', ['Huiles', 'Pâtes', 'Conserves', 'Produits Laitiers', 'Sucres & Edulcolorants', 'Produits à base de Chocolat', 'Condiments', 'Vins & Boissons', 'Soins du Visage','Hygiène Bucco-Dentaire','Soins Corporels','Nettoyants','Désodorisants'])->nullable(false);
            $table->integer('quantite_stock')->nullable(false);
            $table->decimal('prix', 20, 2);
            $table->string('image');
            $table->foreignId('categorie_id')->constrained('categories')->cascadeOnDelete();
            $table->timestamps();
        }); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produits');
    }
};