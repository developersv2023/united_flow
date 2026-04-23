@extends('layouts.app')

@section('title', 'United Flow - Reportes CASS')
@section('page-title', 'Reportes Financieros CASS')
@section('page-breadcrumb', 'Business Intelligence / Reportes')

@section('content')
    <div class="p-4 md:p-10 space-y-8">

        {{-- Filters Zone --}}
        <div class="bg-white rounded-3xl p-6 md:p-8 custom-shadow border border-slate-100 mb-8">
            <div class="flex flex-col md:flex-row justify-between md:items-center gap-4 mb-6">
                <div>
                    <h2 class="text-xl font-black text-slate-800">Parámetros de Consulta</h2>
                    <p class="text-sm text-slate-400 font-medium">Filtra por período para consolidar la información</p>
                </div>
                <div class="flex items-center gap-3">
                    <span
                        class="px-4 py-2 bg-indigo-50 text-indigo-600 rounded-xl text-xs font-black uppercase tracking-widest border border-indigo-100 flex items-center gap-2">
                        <span class="material-symbols-outlined text-[16px]">info</span>
                        Datos en tiempo real
                    </span>
                </div>
            </div>

            <form action="{{ route('reports.index') }}" method="GET" class="flex flex-col md:flex-row gap-6 items-end"
                id="report-filter-form">
                <div class="w-full md:w-auto flex-1">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-2 mb-2 block">Fecha
                        Inicial</label>
                    <div class="relative">
                        <span
                            class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">calendar_today</span>
                        <input type="date" name="start_date" value="{{ $startDate }}"
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl pl-12 pr-4 py-3.5 text-sm font-bold text-slate-600 focus:ring-2 focus:ring-primary focus:border-transparent transition-all cursor-pointer">
                    </div>
                </div>

                <div class="w-full md:w-auto flex-1">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-2 mb-2 block">Fecha
                        Final</label>
                    <div class="relative">
                        <span
                            class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">event</span>
                        <input type="date" name="end_date" value="{{ $endDate }}"
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl pl-12 pr-4 py-3.5 text-sm font-bold text-slate-600 focus:ring-2 focus:ring-primary focus:border-transparent transition-all cursor-pointer">
                    </div>
                </div>

                <div class="w-full md:w-auto">
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-2 bg-primary text-white text-sm font-black py-4 px-8 rounded-2xl shadow-lg shadow-primary/20 hover:-translate-y-1 transition-all">
                        <span class="material-symbols-outlined">sync</span>
                        Generar Sumario
                    </button>
                </div>
            </form>
        </div>

        {{-- CASS Dashboards (Widgets) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

            {{-- Operaciones Totales --}}
            <div class="bg-white rounded-3xl p-6 custom-shadow border border-slate-100 relative overflow-hidden group">
                <div
                    class="absolute top-0 right-0 -mr-8 -mt-8 size-32 bg-primary/5 rounded-full blur-2xl group-hover:bg-primary/20 transition-all duration-500">
                </div>
                <div class="flex items-start justify-between mb-4">
                    <div class="size-12 rounded-2xl bg-primary/10 flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined font-variation-fill">tag</span>
                    </div>
                    <span
                        class="px-2.5 py-1 bg-green-50 text-green-600 rounded-lg text-[10px] font-black uppercase">Consolidado</span>
                </div>
                <div>
                    <h3 class="text-slate-400 text-xs font-black uppercase tracking-widest mb-1">Total AWBs Emis.</h3>
                    <p class="text-3xl font-black text-slate-800">{{ number_format($resume->total_awbs ?? 0) }}</p>
                </div>
            </div>

            {{-- Peso Movilizado --}}
            <div class="bg-white rounded-3xl p-6 custom-shadow border border-slate-100 relative overflow-hidden group">
                <div
                    class="absolute top-0 right-0 -mr-8 -mt-8 size-32 bg-amber-500/5 rounded-full blur-2xl group-hover:bg-amber-500/20 transition-all duration-500">
                </div>
                <div class="flex items-start justify-between mb-4">
                    <div class="size-12 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-500">
                        <span class="material-symbols-outlined font-variation-fill">weight</span>
                    </div>
                </div>
                <div>
                    <h3 class="text-slate-400 text-xs font-black uppercase tracking-widest mb-1">Volumen Movilizado</h3>
                    <p class="text-3xl font-black text-slate-800">{{ number_format($resume->total_peso ?? 0, 2) }} <span
                            class="text-[14px] text-slate-400 font-bold">Kg</span></p>
                </div>
            </div>

            {{-- Flete Bruto Generado (Flete P) --}}
            <div class="bg-white rounded-3xl p-6 custom-shadow border border-slate-100 relative overflow-hidden group">
                <div
                    class="absolute top-0 right-0 -mr-8 -mt-8 size-32 bg-emerald-500/5 rounded-full blur-2xl group-hover:bg-emerald-500/20 transition-all duration-500">
                </div>
                <div class="flex items-start justify-between mb-4">
                    <div class="size-12 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-500">
                        <span class="material-symbols-outlined font-variation-fill">attach_money</span>
                    </div>
                    <span
                        class="text-[10px] font-black text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-lg">INGRESO</span>
                </div>
                <div>
                    <h3 class="text-slate-400 text-xs font-black uppercase tracking-widest mb-1">Flete Bruto Venta (P)</h3>
                    <p class="text-3xl font-black text-slate-800"><span
                            class="text-xl text-slate-300">$</span>{{ number_format($resume->suma_flete_p ?? 0, 2) }}</p>
                </div>
            </div>

            {{-- Flete Neto Endeudado (Flete N) --}}
            <div class="bg-white rounded-3xl p-6 custom-shadow border border-slate-100 relative overflow-hidden group">
                <div
                    class="absolute top-0 right-0 -mr-8 -mt-8 size-32 bg-rose-500/5 rounded-full blur-2xl group-hover:bg-rose-500/20 transition-all duration-500">
                </div>
                <div class="flex items-start justify-between mb-4">
                    <div class="size-12 rounded-2xl bg-rose-50 flex items-center justify-center text-rose-500">
                        <span class="material-symbols-outlined font-variation-fill">money_off</span>
                    </div>
                    <span class="text-[10px] font-black text-rose-500 bg-rose-50 px-2.5 py-1 rounded-lg">Costo</span>
                </div>
                <div>
                    <h3 class="text-slate-400 text-xs font-black uppercase tracking-widest mb-1">Flete Neto Compra (N)</h3>
                    <p class="text-3xl font-black text-slate-800"><span
                            class="text-xl text-slate-300">$</span>{{ number_format($resume->suma_flete_n ?? 0, 2) }}</p>
                </div>
            </div>

        </div>

        {{-- Profitability Metrics Row --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pb-6 border-b border-slate-200">
            <div
                class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-3xl p-8 custom-shadow relative overflow-hidden text-white flex items-center justify-between">
                <div>
                    <h3 class="text-indigo-200 text-xs font-black uppercase tracking-widest mb-2">Comisión / Incentivo Total
                    </h3>
                    <p class="text-4xl font-black">${{ number_format($resume->suma_incentivo ?? 0, 2) }}</p>
                    <p class="text-xs text-indigo-300 font-bold mt-2"><span class="text-white">+ </span>Ganancias sobre
                        Fletes Base</p>
                </div>
                <div
                    class="size-20 bg-white/10 backdrop-blur rounded-full flex items-center justify-center border border-white/20">
                    <span class="material-symbols-outlined text-4xl">trending_up</span>
                </div>
            </div>

            <div
                class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-3xl p-8 custom-shadow relative overflow-hidden text-white flex items-center justify-between">
                <div>
                    <h3 class="text-slate-400 text-xs font-black uppercase tracking-widest mb-2">Sobreventa Comercial</h3>
                    <p class="text-4xl font-black">${{ number_format($resume->suma_sobreventa ?? 0, 2) }}</p>
                    <p class="text-xs text-slate-400 font-bold mt-2"><span class="text-emerald-400">↑ </span>Rendimiento
                        extra por Diferencial</p>
                </div>
                <div
                    class="size-20 bg-white/5 backdrop-blur rounded-full flex items-center justify-center border border-white/10">
                    <span class="material-symbols-outlined text-4xl text-slate-300">verified</span>
                </div>
            </div>
        </div>

        {{-- Desglose Operativo Table --}}
        <div>
            <div class="flex items-center justify-between mb-6 px-2">
                <h3 class="text-lg font-black text-slate-800">Desglose Documental</h3>
                <a href="{{ route('sales.excel', ['start_date' => $startDate, 'end_date' => $endDate]) }}" target="_blank"
                    class="text-xs font-bold text-primary hover:text-primary/80 flex items-center gap-1 bg-primary/10 px-4 py-2 rounded-xl transition-colors">
                    <span class="material-symbols-outlined text-[16px]">download</span> Exportar Rango a Excel
                </a>
            </div>
            <div class="bg-white rounded-3xl custom-shadow border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead class="bg-slate-50 border-b border-slate-100">
                            <tr class="text-left">
                                <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                    Emisión</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">AWB
                                    Identificador</th>
                                <th
                                    class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">
                                    Incentivo</th>
                                <th
                                    class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">
                                    Sobreventa</th>
                                <th
                                    class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">
                                    Total Prepaid</th>
                                <th
                                    class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">
                                    Total Collect</th>
                                <th
                                    class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">
                                    Detalles</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($sales as $s)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-4 text-xs font-bold text-slate-500">
                                        {{ $s->fecha ? $s->fecha->format('d M Y') : '-' }}</td>
                                    <td class="px-6 py-4">
                                        <span class="text-sm font-black text-slate-800">{{ $s->awb }}</span>
                                        <div class="text-[10px] text-slate-400 font-bold mt-0.5">
                                            {{ $s->agency ? 'A: ' . $s->agency->nombre : '' }}
                                            {{ $s->client ? ' | C: ' . $s->client->nombre : '' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right text-xs font-bold text-indigo-600">
                                        ${{ number_format($s->incentivo, 2) }}</td>
                                    <td class="px-6 py-4 text-right text-xs font-bold text-emerald-600">
                                        ${{ number_format($s->sobreventa, 2) }}</td>
                                    <td class="px-6 py-4 text-right text-sm font-black text-slate-800">
                                        ${{ number_format($s->total_pp, 2) }}</td>
                                    <td class="px-6 py-4 text-right text-sm font-black text-slate-500">
                                        ${{ number_format($s->total_cc, 2) }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('sales.edit', $s) }}"
                                            class="inline-flex size-8 items-center justify-center bg-slate-100 hover:bg-slate-200 text-slate-500 rounded-lg transition-colors">
                                            <span class="material-symbols-outlined text-[18px]">visibility</span>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-10 text-center text-sm font-bold text-slate-400">No hay
                                        movimientos operativos emitidos en este rango.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="p-6 border-t border-slate-50">
                    {{ $sales->links('vendor.pagination.united') }}
                </div>
            </div>
        </div>

    </div>
@endsection