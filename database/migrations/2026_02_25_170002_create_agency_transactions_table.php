<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('agency_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agency_id')->constrained('agencies')->restrictOnDelete()->comment('Agencia dueña del estado de cuenta');

            // Normalización del Periodo
            $table->string('quincena_periodo', 50)->comment('Quincena textual del excel (Ej. 1a q Mar/24)');
            $table->date('fecha_transaccion')->nullable()->comment('Fecha extraída del número serial de excel si existe');

            $table->string('awb_referencia', 100)->nullable()->comment('AWB 005 o Texto Libre ("Nota de cargo", "Sin Movimientos")');

            // Configuración Contable de Estado de cuenta
            $table->decimal('flete_pp', 12, 2)->default(0)->comment('Monto Flete PP');
            $table->decimal('flete_cc', 12, 2)->default(0)->comment('Monto Flete CC');
            $table->decimal('tax', 10, 2)->default(0)->comment('Impuestos / Tax');
            $table->decimal('due_agent', 10, 2)->default(0)->comment('Derechos del Agente');
            $table->decimal('total_due_airline', 12, 2)->default(0)->comment('Adeudo a aerolínea (TOTAL DUE AIRLINE)');
            $table->decimal('subtotal', 12, 2)->default(0)->comment('Subtotal Sumado de Cargos');
            $table->decimal('comision', 10, 2)->default(0)->comment('Comisión (COM 5%)');
            $table->decimal('iva_comision', 10, 2)->default(0)->comment('IVA sobre COM (13%)');

            $table->decimal('total_pp', 12, 2)->default(0)->comment('Total final Prepago');
            $table->decimal('total_cc', 12, 2)->default(0)->comment('Total final Collect');

            // Modelo de Partida Doble
            $table->decimal('cargos_debitos', 12, 2)->default(0)->comment('Total Cargos en factura actual (CARGOS)');
            $table->decimal('abonos_creditos', 12, 2)->default(0)->comment('Pagos o Abonos recibidos (ABONOS)');
            $table->decimal('saldo_acumulado', 12, 2)->default(0)->comment('Cálculo final del corte (TOTAL)');

            $table->timestamps();

            // Índices críticos para carga pesada de estados de cuenta históricos
            $table->index(['agency_id', 'quincena_periodo']);
            $table->index('awb_referencia');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agency_transactions');
    }
};
