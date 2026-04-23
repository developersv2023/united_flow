<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pending_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('factura_num', 50)->unique()->comment('Referencia de cobro DTE/Invoice');
            $table->date('fecha_emision')->nullable()->comment('Fecha en que se reportó la factura');
            $table->string('mes_facturado', 50)->nullable()->comment('Mes al que aplica (Billed Month)');
            $table->decimal('monto', 12, 2)->default(0)->comment('Saldo adeudado (Amount)');
            $table->integer('dias_vencido')->default(0)->comment('Cálculo congelado al momento de importar (Days Expired)');
            $table->enum('estado', ['PENDIENTE', 'PAGADA', 'ANULADA', 'INCOBRABLE'])->default('PENDIENTE');
            $table->timestamps();

            $table->index('estado');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pending_invoices');
    }
};
