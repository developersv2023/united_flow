@extends('layouts.app')

@section('title', 'United Flow - Editar Venta AWB')
@section('page-title', 'Edición Venta AWB')
@section('page-breadcrumb', 'Gestión / Ventas / Editar')

@section('content')
    <div class="p-10 space-y-10">
        <div class="bg-white rounded-[2.5rem] p-10 custom-shadow border border-slate-100 max-w-6xl mx-auto relative">

            <div class="absolute top-10 right-10">
                <span
                    class="px-3 py-1.5 rounded-xl bg-slate-50 text-slate-400 text-[10px] font-black uppercase tracking-widest border border-slate-200">
                    ID #{{ $sale->id }}
                </span>
            </div>

            <div class="mb-10 text-center">
                <div class="size-16 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-500 mx-auto mb-4">
                    <span class="material-symbols-outlined text-4xl font-variation-fill">edit_document</span>
                </div>
                <h2 class="text-2xl font-black text-slate-900 leading-tight">Editar Venta AWB</h2>
                <p class="text-sm text-slate-400 font-medium mt-1">Acualiza los detalles de fletes y cobros reportados</p>
            </div>

            <form action="{{ route('sales.update', $sale) }}" method="POST" class="space-y-12">
                @csrf
                @method('PUT')

                {{-- Sección 1: Información General --}}
                <div class="space-y-6">
                    <h3 class="text-lg font-black text-slate-800 flex items-center gap-2 border-b border-slate-100 pb-3">
                        <span class="material-symbols-outlined text-primary">info</span>
                        Información General
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        {{-- Fecha --}}
                        <div class="md:col-span-1">
                            <label
                                class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-2 mb-2 block">Fecha
                                Emisión <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <span
                                    class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">calendar_month</span>
                                <input type="date" name="fecha"
                                    value="{{ old('fecha', $sale->fecha ? $sale->fecha->format('Y-m-d') : '') }}" required
                                    class="w-full bg-slate-50 border-none rounded-2xl pl-12 pr-4 py-4 text-sm font-bold text-slate-600 focus:ring-2 focus:ring-primary focus:bg-white transition-all">
                            </div>
                            @error('fecha') <span class="text-rose-500 text-xs font-bold pl-2 mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- AWB --}}
                        <div class="md:col-span-1">
                            <label
                                class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-2 mb-2 block">Número
                                AWB <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <span
                                    class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">airplane_ticket</span>
                                <input type="text" name="awb" value="{{ old('awb', $sale->awb) }}" required
                                    placeholder="Ej. 125-12345675"
                                    class="w-full bg-slate-50 border-none rounded-2xl pl-12 pr-4 py-4 text-sm font-bold text-slate-600 focus:ring-2 focus:ring-primary focus:bg-white transition-all">
                            </div>
                            @error('awb') <span class="text-rose-500 text-xs font-bold pl-2 mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Agencia --}}
                        <div class="md:col-span-1">
                            <label
                                class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-2 mb-2 block">Agencia
                                (Opcional)</label>
                            <div class="relative">
                                <span
                                    class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">corporate_fare</span>
                                <select name="agency_id"
                                    class="w-full bg-slate-50 border-none rounded-2xl pl-12 pr-4 py-4 text-sm font-bold text-slate-600 focus:ring-2 focus:ring-primary focus:bg-white transition-all appearance-none cursor-pointer">
                                    <option value="">Seleccione Agencia</option>
                                    @foreach($agencies as $agency)
                                        <option value="{{ $agency->id }}" {{ old('agency_id', $sale->agency_id) == $agency->id ? 'selected' : '' }}>{{ $agency->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('agency_id') <span
                            class="text-rose-500 text-xs font-bold pl-2 mt-1">{{ $message }}</span> @enderror
                        </div>

                        {{-- Cliente --}}
                        <div class="md:col-span-1">
                            <label
                                class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-2 mb-2 block">Cliente
                                (Opcional)</label>
                            <div class="relative">
                                <span
                                    class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">group</span>
                                <select name="client_id"
                                    class="w-full bg-slate-50 border-none rounded-2xl pl-12 pr-4 py-4 text-sm font-bold text-slate-600 focus:ring-2 focus:ring-primary focus:bg-white transition-all appearance-none cursor-pointer">
                                    <option value="">Seleccione Cliente</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}" {{ old('client_id', $sale->client_id) == $client->id ? 'selected' : '' }}>{{ $client->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('client_id') <span
                            class="text-rose-500 text-xs font-bold pl-2 mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                {{-- Sección 2: Operativo y Fletes --}}
                <div class="space-y-6">
                    <h3 class="text-lg font-black text-slate-800 flex items-center gap-2 border-b border-slate-100 pb-3">
                        <span class="material-symbols-outlined text-primary">scale</span>
                        Operativo y Fletes
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
                        {{-- Peso --}}
                        <div class="md:col-span-1">
                            <label
                                class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-2 mb-2 block">Peso
                                Registrado <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <span
                                    class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">weight</span>
                                <input type="number" step="0.01" min="0" name="peso" value="{{ old('peso', $sale->peso) }}"
                                    required placeholder="Kg"
                                    class="w-full bg-slate-50 border-none rounded-2xl pl-12 pr-4 py-4 text-sm font-bold text-slate-600 focus:ring-2 focus:ring-primary focus:bg-white transition-all">
                            </div>
                            @error('peso') <span class="text-rose-500 text-xs font-bold pl-2 mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Tarifa Pública --}}
                        <div class="md:col-span-1">
                            <label
                                class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-2 mb-2 block">Tarifa
                                Púb. (P) <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <span
                                    class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">sell</span>
                                <input type="number" step="0.0001" min="0" name="tarifa_publica"
                                    value="{{ old('tarifa_publica', $sale->tarifa_publica) }}" required
                                    class="w-full bg-slate-50 border-none rounded-2xl pl-12 pr-4 py-4 text-sm font-bold text-slate-600 focus:ring-2 focus:ring-primary focus:bg-white transition-all">
                            </div>
                            @error('tarifa_publica') <span
                            class="text-rose-500 text-xs font-bold pl-2 mt-1">{{ $message }}</span> @enderror
                        </div>

                        {{-- Tarifa Neta --}}
                        <div class="md:col-span-1">
                            <label
                                class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-2 mb-2 block">Tarifa
                                Neta (N) <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <span
                                    class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">local_offer</span>
                                <input type="number" step="0.0001" min="0" name="tarifa_neta"
                                    value="{{ old('tarifa_neta', $sale->tarifa_neta) }}" required
                                    class="w-full bg-slate-50 border-none rounded-2xl pl-12 pr-4 py-4 text-sm font-bold text-slate-600 focus:ring-2 focus:ring-primary focus:bg-white transition-all">
                            </div>
                            @error('tarifa_neta') <span
                            class="text-rose-500 text-xs font-bold pl-2 mt-1">{{ $message }}</span> @enderror
                        </div>

                        {{-- Flete P --}}
                        <div class="md:col-span-1">
                            <label
                                class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-2 mb-2 block">Monto
                                Flete P <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <span
                                    class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">attach_money</span>
                                <input type="number" step="0.01" min="0" name="flete_p"
                                    value="{{ old('flete_p', $sale->flete_p) }}" required
                                    class="w-full bg-slate-50 border-none rounded-2xl pl-12 pr-4 py-4 text-sm font-bold text-slate-600 focus:ring-2 focus:ring-primary focus:bg-white transition-all">
                            </div>
                            @error('flete_p') <span class="text-rose-500 text-xs font-bold pl-2 mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Flete N --}}
                        <div class="md:col-span-1">
                            <label
                                class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-2 mb-2 block">Monto
                                Flete N <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <span
                                    class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">money_off</span>
                                <input type="number" step="0.01" min="0" name="flete_n"
                                    value="{{ old('flete_n', $sale->flete_n) }}" required
                                    class="w-full bg-slate-50 border-none rounded-2xl pl-12 pr-4 py-4 text-sm font-bold text-slate-600 focus:ring-2 focus:ring-primary focus:bg-white transition-all">
                            </div>
                            @error('flete_n') <span class="text-rose-500 text-xs font-bold pl-2 mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Sección 3: Otros Gastos y Ajustes Financieros --}}
                <div class="space-y-6">
                    <h3 class="text-lg font-black text-slate-800 flex items-center gap-2 border-b border-slate-100 pb-3">
                        <span class="material-symbols-outlined text-primary">account_balance_wallet</span>
                        Otros Gastos y Ajustes
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-6 gap-6">
                        {{-- Gastos GC --}}
                        <div class="md:col-span-1">
                            <label
                                class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-2 mb-2 block">Gastos
                                GC <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <input type="number" step="0.01" min="0" name="gastos_gc"
                                    value="{{ old('gastos_gc', $sale->gastos_gc) }}" required
                                    class="w-full bg-slate-50 border-none rounded-2xl px-4 py-4 text-sm font-bold text-slate-600 focus:ring-2 focus:ring-primary focus:bg-white transition-all">
                            </div>
                            @error('gastos_gc') <span
                            class="text-rose-500 text-xs font-bold pl-2 mt-1">{{ $message }}</span> @enderror
                        </div>

                        {{-- Gastos OA --}}
                        <div class="md:col-span-1">
                            <label
                                class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-2 mb-2 block">Gastos
                                OA <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <input type="number" step="0.01" min="0" name="gastos_oa"
                                    value="{{ old('gastos_oa', $sale->gastos_oa) }}" required
                                    class="w-full bg-slate-50 border-none rounded-2xl px-4 py-4 text-sm font-bold text-slate-600 focus:ring-2 focus:ring-primary focus:bg-white transition-all">
                            </div>
                            @error('gastos_oa') <span
                            class="text-rose-500 text-xs font-bold pl-2 mt-1">{{ $message }}</span> @enderror
                        </div>

                        {{-- Incentivo --}}
                        <div class="md:col-span-1">
                            <label
                                class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-2 mb-2 block">Incentivo</label>
                            <div class="relative">
                                <input type="number" step="0.01" name="incentivo"
                                    value="{{ old('incentivo', $sale->incentivo) }}"
                                    class="w-full bg-slate-50 border-none rounded-2xl px-4 py-4 text-sm font-bold text-slate-600 focus:ring-2 focus:ring-primary focus:bg-white transition-all">
                            </div>
                        </div>

                        {{-- Diferencial --}}
                        <div class="md:col-span-1">
                            <label
                                class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-2 mb-2 block">Diferencial</label>
                            <div class="relative">
                                <input type="number" step="0.01" name="diferencial"
                                    value="{{ old('diferencial', $sale->diferencial) }}"
                                    class="w-full bg-slate-50 border-none rounded-2xl px-4 py-4 text-sm font-bold text-slate-600 focus:ring-2 focus:ring-primary focus:bg-white transition-all">
                            </div>
                        </div>

                        {{-- Sobreventa --}}
                        <div class="md:col-span-1">
                            <label
                                class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-2 mb-2 block">Sobreventa</label>
                            <div class="relative">
                                <input type="number" step="0.01" name="sobreventa"
                                    value="{{ old('sobreventa', $sale->sobreventa) }}"
                                    class="w-full bg-slate-50 border-none rounded-2xl px-4 py-4 text-sm font-bold text-slate-600 focus:ring-2 focus:ring-primary focus:bg-white transition-all">
                            </div>
                        </div>

                        {{-- Tarifa Ajuste --}}
                        <div class="md:col-span-1">
                            <label
                                class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-2 mb-2 block">Ajuste
                                Tarifa</label>
                            <div class="relative">
                                <input type="number" step="0.01" name="tarifa_ajuste"
                                    value="{{ old('tarifa_ajuste', $sale->tarifa_ajuste) }}"
                                    class="w-full bg-slate-50 border-none rounded-2xl px-4 py-4 text-sm font-bold text-slate-600 focus:ring-2 focus:ring-primary focus:bg-white transition-all">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Sección 4: Totales Financieros --}}
                <div class="space-y-6 pt-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 bg-slate-50 p-6 rounded-3xl border border-slate-100">
                        {{-- Total PP --}}
                        <div>
                            <label
                                class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-2 mb-2 block">Total
                                Prepaid (PP) <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <span
                                    class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-emerald-500 font-bold">payments</span>
                                <input type="number" step="0.01" name="total_pp"
                                    value="{{ old('total_pp', $sale->total_pp) }}" required
                                    class="w-full bg-white border border-slate-200 rounded-2xl pl-12 pr-4 py-4 text-lg font-black text-emerald-600 focus:ring-2 focus:ring-primary focus:border-transparent transition-all shadow-sm">
                            </div>
                            @error('total_pp') <span class="text-rose-500 text-xs font-bold pl-2 mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Total CC --}}
                        <div>
                            <label
                                class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-2 mb-2 block">Total
                                Collect (CC) <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <span
                                    class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">price_change</span>
                                <input type="number" step="0.01" name="total_cc"
                                    value="{{ old('total_cc', $sale->total_cc) }}" required
                                    class="w-full bg-white border border-slate-200 rounded-2xl pl-12 pr-4 py-4 text-lg font-black text-slate-700 focus:ring-2 focus:ring-primary focus:border-transparent transition-all shadow-sm">
                            </div>
                            @error('total_cc') <span class="text-rose-500 text-xs font-bold pl-2 mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>


                {{-- Actions --}}
                <div class="flex gap-4 pt-6">
                    <a href="{{ route('sales.index') }}"
                        class="flex-1 text-center bg-slate-100 text-slate-500 font-black py-4 rounded-2xl hover:bg-slate-200 transition-colors">
                        Deshacer Cambios
                    </a>
                    <button type="submit"
                        class="flex-1 bg-amber-500 text-white font-black py-4 rounded-2xl shadow-lg shadow-amber-500/30 hover:-translate-y-1 transition-transform">
                        Actualizar AWB Permanentemente
                    </button>
                </div>
            </form>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const pesoInput = document.querySelector('input[name="peso"]');
            const tarifaPInput = document.querySelector('input[name="tarifa_publica"]');
            const tarifaNInput = document.querySelector('input[name="tarifa_neta"]');
            const diferencialInput = document.querySelector('input[name="diferencial"]');

            const fletePInput = document.querySelector('input[name="flete_p"]');
            const fleteNInput = document.querySelector('input[name="flete_n"]');
            const incentivoInput = document.querySelector('input[name="incentivo"]');
            const sobreventaInput = document.querySelector('input[name="sobreventa"]');
            const ajusteTarifaInput = document.querySelector('input[name="tarifa_ajuste"]');

            function calculateFields() {
                const peso = parseFloat(pesoInput.value) || 0;
                const tarifaP = parseFloat(tarifaPInput.value) || 0;
                const tarifaN = parseFloat(tarifaNInput.value) || 0;
                const diferencial = parseFloat(diferencialInput.value) || 0;

                // 4. Monto Flete P = Tarifa Púb. * Peso
                const fleteP = tarifaP * peso;
                fletePInput.value = fleteP.toFixed(2);

                // 5. Monto Flete N = Tarifa Neta * Peso
                const fleteN = tarifaN * peso;
                fleteNInput.value = fleteN.toFixed(2);

                // 3. Incentivo = Monto Flete P - Monto Flete N
                const incentivo = fleteP - fleteN;
                incentivoInput.value = incentivo.toFixed(2);

                // 6. Sobreventa = Diferencial * Peso
                const sobreventa = diferencial * peso;
                sobreventaInput.value = sobreventa.toFixed(2);

                // 7. Ajuste Tarifa = Tarifa Púb. - (Sobreventa / Peso)
                const ajusteTarifa = peso > 0 ? tarifaP - (sobreventa / peso) : 0;
                ajusteTarifaInput.value = ajusteTarifa.toFixed(2);
            }

            pesoInput.addEventListener('input', calculateFields);
            tarifaPInput.addEventListener('input', calculateFields);
            tarifaNInput.addEventListener('input', calculateFields);
            diferencialInput.addEventListener('input', calculateFields);
        });
    </script>
@endpush