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
        Schema::create('traitements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('theme_id')->constrained('themes')->onDelete('cascade');
            $table->string('type')->default('payement'); // e.g., payement, honoraires, etc.
            $table->text('description')->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->enum('status', ['en_attente', 'valide', 'annule'])->default('en_attente');
            $table->date('date_traitement');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('traitements');
    }
};
