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
        Schema::create('commandes', function (Blueprint $table) {
            $table->id();
            $table->string('numero_commande')->unique();

            $table->foreignId('utilisateur_id')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null');

            $table->string('nom_client');
            $table->string('email_client')->nullable();
            $table->string('telephone_client');
            $table->string('telephone_whatsapp');

            $table->string('adresse');
            $table->string('ville');
            $table->string('pays');
            $table->string('code_postal')->nullable();

            $table->decimal('montant_total', 10, 0);
            $table->enum('mode_paiement', ['cinetpay', 'livraison', 'boutique']);
            $table->enum('statut', ['en_attente', 'terminee', 'annulee'])->default('en_attente');
            $table->string('identifiant_transaction')->unique()->nullable();

            $table->string('jeton_acces')->unique();

            $table->boolean('notification_whatsapp_envoyee')->default(false);
            $table->timestamp('notification_whatsapp_envoyee_le')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commandes');
    }
};