<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 150)->unique()->comment('Nombre del cliente recurrente en base a las cargas de UA');
            $table->string('nit', 20)->nullable()->comment('NIT del cliente para posible futura facturación electrónica');
            $table->boolean('activo')->default(true);
            $table->timestamps();

            $table->index('nombre');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
