<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('agencies', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 150)->comment('Nombre completo o razón social de la agencia (ej. Grupo TLA)');
            $table->string('codigo', 50)->nullable()->unique()->comment('Acrónimo o código corto (ej., CBX, AGD)');
            $table->boolean('cass')->default(false)->comment('Identifica si es una agencia CASS');
            $table->boolean('activo')->default(true)->comment('Indica si la agencia está operativa');
            $table->timestamps();

            // Optimiza búsquedas al mostrar catálogos y selects en vivo
            $table->index('nombre');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agencies');
    }
};
