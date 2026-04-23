@extends('layouts.app')

@section('title', 'United Flow - Editar Transacción de Agencia')
@section('page-title', 'Modificar Registro CASS')
@section('page-breadcrumb', 'Transacciones / Edición')

@section('content')
    <div class="px-10 py-8 max-w-5xl mx-auto">

        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center gap-4">
                <a href="{{ route('agency_transactions.index') }}"
                    class="flex size-10 items-center justify-center rounded-2xl bg-white border border-slate-200 text-slate-400 hover:text-primary hover:border-primary transition-all custom-shadow">
                    <span class="material-symbols-outlined text-lg">arrow_back</span>
                </a>
                <div>
                    <h2 class="text-xl font-black text-slate-900">Editar Registro #{{ $agencyTransaction->id }}</h2>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">ID CASS Interno</p>
                </div>
            </div>
        </div>

        <div class="bg-white border border-slate-200 rounded-[2rem] custom-shadow overflow-hidden">
            <form action="{{ route('agency_transactions.update', $agencyTransaction) }}" method="POST"
                class="p-8 space-y-8">
                @csrf
                @method('PUT')

                {{-- Basic Information --}}
                <div class="space-y-6">
                    <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
                        <span
                            class="material-symbols-outlined text-amber-500 bg-amber-50 p-2 rounded-xl">edit_document</span>
                        <h3 class="text-lg font-black text-slate-800">Información Documental</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div class="md:col-span-2">
                            <label
                                class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-2 mb-2 block">Agencia
                                CASS *</label>
                            <select name="agency_id" required
                                class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-sm font-bold text-slate-600 focus:ring-2 focus:ring-primary focus:border-transparent transition-all cursor-pointer">
                                <option value="">Selecciona una Agencia...</option>
                                @foreach($agencies as $agency)
                                    <option value="{{ $agency->id }}" {{ old('agency_id', $agencyTransaction->agency_id) == $agency->id ? 'selected' : '' }}>
                                        {{ $agency->nombre }} ({{ $agency->codigo_iata }})
                                    </option>
                                @endforeach
                            </select>
                            @error('agency_id') <p class="text-red-500 text-xs font-bold mt-1 pl-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label
                                class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-2 mb-2 block">Fecha
                                *</label>
                            <input type="date" name="fecha_transaccion" required
                                value="{{ old('fecha_transaccion', $agencyTransaction->fecha_transaccion ? $agencyTransaction->fecha_transaccion->format('Y-m-d') : '') }}"
                                class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-sm font-bold text-slate-600 focus:ring-2 focus:ring-primary focus:border-transparent transition-all">
                            @error('fecha_transaccion') <p class="text-red-500 text-xs font-bold mt-1 pl-2">{{ $message }}
                            </p> @enderror
                        </div>

                        <div>
                            <label
                                class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-2 mb-2 block">Periodo
                                de Quincena *</label>
                            <input type="text" name="quincena_periodo" required
                                value="{{ old('quincena_periodo', $agencyTransaction->quincena_periodo) }}"
                                placeholder="Ej: 1S MAR 2026"
                                class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-sm font-bold text-slate-600 focus:ring-2 focus:ring-primary focus:border-transparent transition-all uppercase">
                            @error('quincena_periodo') <p class="text-red-500 text-xs font-bold mt-1 pl-2">{{ $message }}
                            </p> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label
                                class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-2 mb-2 block">Referencia
                                / AWB</label>
                            <input type="text" name="awb_referencia"
                                value="{{ old('awb_referencia', $agencyTransaction->awb_referencia) }}"
                                placeholder="Num. AWB..."
                                class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-primary focus:border-transparent transition-all">
                            @error('awb_referencia') <p class="text-red-500 text-xs font-bold mt-1 pl-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Fletes y Due Agent / Airline --}}
                <div class="space-y-6 pt-4">
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                        <div class="flex items-center gap-3">
                            <span
                                class="material-symbols-outlined text-indigo-500 bg-indigo-50 p-2 rounded-xl">account_balance_wallet</span>
                            <h3 class="text-lg font-black text-slate-800">Conceptos de Flete y Cargos</h3>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div>
                            <label
                                class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-2 mb-2 block">Flete
                                PP</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold">$</span>
                                <input type="number" step="0.01" name="flete_pp" id="flete_pp"
                                    value="{{ old('flete_pp', $agencyTransaction->flete_pp) }}"
                                    class="calc-input w-full bg-slate-50 border border-slate-200 rounded-2xl pl-8 pr-4 py-3.5 text-sm font-black text-slate-600 focus:ring-2 focus:ring-primary transition-all">
                            </div>
                        </div>
                        <div>
                            <label
                                class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-2 mb-2 block">Flete
                                CC</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold">$</span>
                                <input type="number" step="0.01" name="flete_cc" id="flete_cc"
                                    value="{{ old('flete_cc', $agencyTransaction->flete_cc) }}"
                                    class="calc-input w-full bg-slate-50 border border-slate-200 rounded-2xl pl-8 pr-4 py-3.5 text-sm font-black text-slate-600 focus:ring-2 focus:ring-primary transition-all">
                            </div>
                        </div>
                        <div>
                            <label
                                class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-2 mb-2 block">Tax</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold">$</span>
                                <input type="number" step="0.01" name="tax" id="tax"
                                    value="{{ old('tax', $agencyTransaction->tax) }}"
                                    class="calc-input w-full bg-slate-50 border border-slate-200 rounded-2xl pl-8 pr-4 py-3.5 text-sm font-black text-slate-600 focus:ring-2 focus:ring-primary transition-all">
                            </div>
                        </div>
                        <div>
                            <label
                                class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-2 mb-2 block">Due
                                Agent</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold">$</span>
                                <input type="number" step="0.01" name="due_agent" id="due_agent"
                                    value="{{ old('due_agent', $agencyTransaction->due_agent) }}"
                                    class="calc-input w-full bg-slate-50 border border-slate-200 rounded-2xl pl-8 pr-4 py-3.5 text-sm font-black text-slate-600 focus:ring-2 focus:ring-primary transition-all">
                            </div>
                        </div>

                        {{-- Conceptos de Debito y Credito--}}
                        <div>
                            <label
                                class="text-[10px] font-black text-rose-400 uppercase tracking-widest pl-2 mb-2 block">Cargos
                                / Débitos (+)</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-rose-400 font-bold">$</span>
                                <input type="number" step="0.01" name="cargos_debitos" id="cargos_debitos"
                                    value="{{ old('cargos_debitos', $agencyTransaction->cargos_debitos) }}"
                                    class="calc-input w-full bg-rose-50/30 border border-rose-100 rounded-2xl pl-8 pr-4 py-3.5 text-sm font-black text-rose-600 focus:ring-2 focus:ring-rose-400 transition-all">
                            </div>
                        </div>
                        <div>
                            <label
                                class="text-[10px] font-black text-emerald-400 uppercase tracking-widest pl-2 mb-2 block">Abonos
                                / Créditos (-)</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-emerald-400 font-bold">$</span>
                                <input type="number" step="0.01" name="abonos_creditos" id="abonos_creditos"
                                    value="{{ old('abonos_creditos', $agencyTransaction->abonos_creditos) }}"
                                    class="calc-input w-full bg-emerald-50/30 border border-emerald-100 rounded-2xl pl-8 pr-4 py-3.5 text-sm font-black text-emerald-600 focus:ring-2 focus:ring-emerald-400 transition-all">
                            </div>
                        </div>

                        <div
                            class="lg:col-span-2 space-y-2 lg:mt-6 bg-slate-100 rounded-2xl p-4 flex flex-col justify-center">
                            <div class="flex justify-between items-center w-full">
                                <span class="text-xs font-bold text-slate-500 uppercase">Subtotal Crudo:</span>
                                <span class="text-lg font-black text-slate-700">$<span
                                        id="display_subtotal">0.00</span></span>
                                <input type="hidden" name="subtotal" id="input_subtotal"
                                    value="{{ old('subtotal', $agencyTransaction->subtotal) }}">
                            </div>
                            <div class="flex justify-between items-center w-full">
                                <span class="text-xs font-bold text-indigo-500 uppercase">Total Due Airline:</span>
                                <span class="text-lg font-black text-indigo-700">$<span
                                        id="display_total_due_airline">0.00</span></span>
                                <input type="hidden" name="total_due_airline" id="input_total_due_airline"
                                    value="{{ old('total_due_airline', $agencyTransaction->total_due_airline) }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-6 pt-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label
                                class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-2 mb-2 block">Comisión</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold">$</span>
                                <input type="number" step="0.01" name="comision" id="comision"
                                    value="{{ old('comision', $agencyTransaction->comision) }}"
                                    class="calc-input w-full bg-slate-50 border border-slate-200 rounded-2xl pl-8 pr-4 py-3.5 text-sm font-black text-slate-600 focus:ring-2 focus:ring-primary focus:border-transparent transition-all">
                            </div>
                        </div>
                        <div>
                            <label
                                class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-2 mb-2 block">IVA
                                Comisión</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold">$</span>
                                <input type="number" step="0.01" name="iva_comision" id="iva_comision"
                                    value="{{ old('iva_comision', $agencyTransaction->iva_comision) }}"
                                    class="calc-input w-full bg-slate-50 border border-slate-200 rounded-2xl pl-8 pr-4 py-3.5 text-sm font-black text-slate-600 focus:ring-2 focus:ring-primary focus:border-transparent transition-all">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-8 mt-6 bg-slate-800 rounded-3xl grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div>
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2">Total PP
                            Evaluado</span>
                        <div class="text-2xl font-black text-white">$<span id="display_total_pp">0.00</span></div>
                        <input type="hidden" name="total_pp" id="input_total_pp"
                            value="{{ old('total_pp', $agencyTransaction->total_pp) }}">
                    </div>
                    <div>
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2">Total CC
                            Evaluado</span>
                        <div class="text-2xl font-black text-white">$<span id="display_total_cc">0.00</span></div>
                        <input type="hidden" name="total_cc" id="input_total_cc"
                            value="{{ old('total_cc', $agencyTransaction->total_cc) }}">
                    </div>
                    <div class="md:text-right border-t md:border-t-0 md:border-l border-slate-600 pt-6 md:pt-0 md:pl-8">
                        <span class="text-[10px] font-black text-amber-400 uppercase tracking-widest block mb-2">Amount To
                            Pay</span>
                        <div
                            class="text-3xl font-black bg-gradient-to-r from-amber-400 to-amber-200 bg-clip-text text-transparent">
                            $<span id="display_saldo_acumulado">0.00</span></div>
                        <input type="hidden" name="saldo_acumulado" id="input_saldo_acumulado"
                            value="{{ old('saldo_acumulado', $agencyTransaction->saldo_acumulado) }}">
                    </div>
                </div>

                {{-- Submit Buttons --}}
                <div class="pt-6 border-t border-slate-100 flex justify-end gap-4">
                    <button type="submit"
                        class="px-8 py-4 rounded-2xl bg-slate-900 hover:bg-slate-800 text-white text-sm font-black shadow-lg shadow-slate-900/30 transition-all hover:-translate-y-0.5">
                        Actualizar Sistema
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const inputs = document.querySelectorAll('.calc-input');
                const getVal = (id) => parseFloat(document.getElementById(id).value) || 0;

                function calculateTotals() {
                    const flete_pp = getVal('flete_pp');
                    const flete_cc = getVal('flete_cc');
                    const tax = getVal('tax');
                    const due_agent = getVal('due_agent');

                    const cargos = getVal('cargos_debitos');
                    const abonos = getVal('abonos_creditos');

                    const comision = getVal('comision');
                    const iva_comision = getVal('iva_comision');

                    // Lógica Estándar
                    const subtotal = flete_pp + tax;
                    const total_due_airline = due_agent;

                    const total_pp = subtotal + total_due_airline + cargos - abonos;
                    const total_cc = flete_cc;

                    const saldo_acumulado = total_pp - (comision + iva_comision);

                    // Update UI
                    document.getElementById('display_subtotal').innerText = subtotal.toFixed(2);
                    document.getElementById('display_total_due_airline').innerText = total_due_airline.toFixed(2);
                    document.getElementById('display_total_pp').innerText = total_pp.toFixed(2);
                    document.getElementById('display_total_cc').innerText = total_cc.toFixed(2);
                    document.getElementById('display_saldo_acumulado').innerText = saldo_acumulado.toFixed(2);

                    document.getElementById('input_subtotal').value = subtotal.toFixed(2);
                    document.getElementById('input_total_due_airline').value = total_due_airline.toFixed(2);
                    document.getElementById('input_total_pp').value = total_pp.toFixed(2);
                    document.getElementById('input_total_cc').value = total_cc.toFixed(2);
                    document.getElementById('input_saldo_acumulado').value = saldo_acumulado.toFixed(2);
                }

                inputs.forEach(input => {
                    input.addEventListener('input', calculateTotals);
                });

                // Initial calculation onload
                calculateTotals();
            });
        </script>
    @endpush
@endsection