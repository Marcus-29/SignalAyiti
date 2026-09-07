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
        Schema::create('signalements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('categorie', ['route', 'eau', 'electricite', 'dechets', 'eclairage', 'securite', 'autre']);
            $table->string('titre');
            $table->text('description');
            $table->string('quartier');
            $table->string('photo_path')->nullable();
            $table->enum('statut', ['nouveau', 'en_cours', 'resolu', 'rejete'])->default('nouveau');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('signalements');
    }
};
