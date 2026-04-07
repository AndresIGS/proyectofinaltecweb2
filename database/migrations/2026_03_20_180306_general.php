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
        Schema::create('aerolineas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->softDeletes();
            $table->timestamps();
        });

// Migración 2: vuelos (Depende de aerolineas)
        Schema::create('vuelos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aerolinea_id')->constrained(); // ¡Llave Foránea Automática!
            $table->string('destino');
            $table->softDeletes(); // Agrega la columna deleted_at
            $table->timestamps();
        });

// Migración 3: pasajeros (Depende de vuelos)
        Schema::create('pasajeros', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vuelo_id')->constrained()->onDelete('cascade');
            $table->string('nombre_completo');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('aerolineas');
        Schema::dropIfExists('vuelos');
        Schema::dropIfExists('pasajeros');
        Schema::enableForeignKeyConstraints();
    }
};
