<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pubs', function (Blueprint $table) {
            $table->id();

            // Infos principales
            $table->string('titre', 150);                 // Limite raisonnable pour un titre
            $table->string('description', 255)->nullable(); // Description facultative
            $table->string('image', 255);                 // URL ou chemin de l'image

            // Gestion des emplacements
            $table->enum('position', ['banner', 'section1', 'section2'])
                ->comment('Emplacement de la pub sur la page');

            $table->enum('page', ['boutique', 'detail-boutique', 'checkout'])
                ->comment('Page de l’application où afficher la pub');

            // Statut
            $table->boolean('is_active')
                ->default(true)
                ->comment('true = actif, false = désactivé');

            $table->timestamps();

            // Empêche qu’une même position soit utilisée deux fois sur une page
            $table->unique(['position', 'page'], 'unique_position_page');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pubs');
    }
};
