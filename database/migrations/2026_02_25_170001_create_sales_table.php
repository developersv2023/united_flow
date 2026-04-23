<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->date('fecha')->comment('Fecha de la operación (ej. emisión de AWB)');
            $table->string('awb', 50)->unique()->comment('Número de guía aérea AWB');

            // Relaciones
            $table->foreignId('agency_id')->nullable()->constrained('agencies')->nullOnDelete()->comment('Agencia asociada si aplica');
            $table->foreignId('client_id')->nullable()->constrained('clients')->nullOnDelete()->comment('Cliente directo o importador');

            $table->decimal('peso', 10, 2)->default(0)->comment('Peso reportado (ej. 131)');

            // Tarifas
            $table->decimal('tarifa_publica', 10, 4)->default(0)->comment('Tarifa cobrada P (ej. 2.55)');
            $table->decimal('tarifa_neta', 10, 4)->default(0)->comment('Tarifa neta o costo N (ej. 2.05)');

            // Fletes
            $table->decimal('flete_p', 12, 2)->default(0)->comment('Monto total flete P');
            $table->decimal('flete_n', 12, 2)->default(0)->comment('Monto total flete N');

            // Gastos
            $table->decimal('gastos_gc', 10, 2)->default(0)->comment('Gastos propios GC');
            $table->decimal('gastos_oa', 10, 2)->default(0)->comment('Otros gastos OA / Manejos');

            // Ajustes / Margen
            $table->decimal('incentivo', 10, 2)->default(0)->comment('Monto en incentivos / descuentos cliente');
            $table->decimal('diferencial', 10, 2)->default(0)->comment('Diferencial cobrado extra (ej. 0.5)');
            $table->decimal('sobreventa', 10, 2)->default(0)->comment('Exceso o sobreventa a favor');
            $table->decimal('tarifa_ajuste', 10, 2)->default(0)->comment('Ajuste extra en Tarifa libre');

            // Totales Finales Globales
            $table->decimal('total_pp', 12, 2)->default(0)->comment('Total Prepaid Sumado');
            $table->decimal('total_cc', 12, 2)->default(0)->comment('Total Collect');

            $table->timestamps();

            // Índices para optimizar reportes financieros (búsquedas por rango de fecha, agencia)
            $table->index('fecha');
            $table->index(['agency_id', 'fecha']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
