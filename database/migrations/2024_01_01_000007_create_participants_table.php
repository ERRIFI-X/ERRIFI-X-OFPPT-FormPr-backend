<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('theme_id')->constrained('themes')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('role', ['participant', 'inscrit'])->default('participant');
            $table->enum('status', ['en_attente', 'valide', 'annule'])->default('valide');
            $table->timestamp('date_inscription')->nullable();
            $table->timestamps();

            $table->unique(['theme_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('participants');
    }
};
