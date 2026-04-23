@extends('layouts.app')

@section('title', 'United Flow - Ventas AWB')
@section('page-title', 'Registro de Ventas AWB')
@section('page-breadcrumb', 'Gestión / Ventas')

@section('content')
    <div class="p-10">

        {{-- Single Container for Everything --}}
        <div class="bg-white rounded-[2.5rem] p-10 custom-shadow border border-slate-100">

            {{-- Header Options --}}
            <div
                class="flex flex-col lg:flex-row justify-between lg:items-center gap-6 mb-8 border-b border-slate-100 pb-8">
                <div>
                    <h2 class="text-2xl font-black text-slate-900 leading-tight">Directorio de Ventas AWB</h2>
                    <p class="text-sm text-slate-400 font-medium mt-1">Gestión operativa y financiera de AWBs</p>
                </div>

                <div class="flex gap-4">
                    <a href="{{ route('sales.excel', request()->all()) }}" target="_blank" download="Listado_Ventas_AWB.csv"
                        class="flex items-center gap-2 text-white text-sm font-black py-3 px-6 rounded-2xl hover:opacity-90 transition-all shadow-lg"
                        style="background-color: #02bf74; box-shadow: 0 10px 15px -3px rgba(2, 191, 116, 0.2);">
                        <span class="material-symbols-outlined text-xl">table_chart</span>
                        Exportar Excel
                    </a>

                    <a href="{{ route('sales.create') }}"
                        class="flex items-center gap-2 bg-primary text-white text-sm font-black py-3 px-6 rounded-2xl shadow-lg shadow-primary/20 hover:-translate-y-1 transition-all">
                        <span class="material-symbols-outlined text-xl">add</span>
                        Nueva Venta
                    </a>
                </div>
            </div>

            {{-- Filters --}}
            <div class="mb-8 bg-slate-50/50 p-6 rounded-3xl border border-slate-100">
                <form action="{{ route('sales.index') }}" method="GET" class="grid grid-cols-1 xl:grid-cols-5 gap-6"
                    id="filter-form">

                    {{-- Search --}}
                    <div>
                        <label
                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-2 mb-2 block">Buscar
                            AWB</label>
                        <div class="relative">
                            <span
                                class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">search</span>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Num. AWB..."
                                class="w-full bg-white border border-slate-200 rounded-2xl pl-12 pr-4 py-3.5 text-sm font-bold text-slate-600 focus:ring-2 focus:ring-primary focus:border-transparent transition-all"
                                onchange="document.getElementById('filter-form').submit();">
                        </div>
                    </div>

                    {{-- Agencia --}}
                    <div>
                        <label
                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-2 mb-2 block">Agencia</label>
                        <select name="agency_id"
                            class="w-full bg-white border border-slate-200 rounded-2xl px-4 py-3.5 text-sm font-bold text-slate-600 focus:ring-2 focus:ring-primary focus:border-transparent transition-all appearance-none cursor-pointer"
                            onchange="document.getElementById('filter-form').submit();">
                            <option value="">Todas</option>
                            @foreach($agencies as $agency)
                                <option value="{{ $agency->id }}" {{ request('agency_id') == $agency->id ? 'selected' : '' }}>
                                    {{ $agency->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Cliente --}}
                    <div>
                        <label
                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-2 mb-2 block">Cliente</label>
                        <select name="client_id"
                            class="w-full bg-white border border-slate-200 rounded-2xl px-4 py-3.5 text-sm font-bold text-slate-600 focus:ring-2 focus:ring-primary focus:border-transparent transition-all appearance-none cursor-pointer"
                            onchange="document.getElementById('filter-form').submit();">
                            <option value="">Todos</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}" {{ request('client_id') == $client->id ? 'selected' : '' }}>
                                    {{ $client->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Fecha Inicial --}}
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-2 mb-2 block">Desde Fecha</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">calendar_today</span>
                            <input type="date" name="start_date" value="{{ request('start_date', $startDate) }}"
                                class="w-full bg-white border border-slate-200 rounded-2xl pl-12 pr-4 py-3.5 text-sm font-bold text-slate-600 focus:ring-2 focus:ring-primary focus:border-transparent transition-all cursor-pointer"
                                onchange="document.getElementById('filter-form').submit();">
                        </div>
                    </div>

                    {{-- Fecha Final --}}
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-2 mb-2 block">Hasta Fecha</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">event</span>
                            <input type="date" name="end_date" value="{{ request('end_date', $endDate) }}"
                                class="w-full bg-white border border-slate-200 rounded-2xl pl-12 pr-4 py-3.5 text-sm font-bold text-slate-600 focus:ring-2 focus:ring-primary focus:border-transparent transition-all cursor-pointer"
                                onchange="document.getElementById('filter-form').submit();">
                        </div>
                    </div>

                </form>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="w-full whitespace-nowrap">
                    <thead>
                        <tr class="text-left border-b border-slate-100">
                            <th class="px-6 pb-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Fecha</th>
                            <th class="px-6 pb-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">AWB</th>
                            <th class="px-6 pb-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Entidad (Agencia/Cliente)</th>
                            <th class="px-6 pb-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Peso</th>
                            <th class="px-6 pb-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Tarifa Púb.</th>
                            <th class="px-6 pb-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Tarifa Neta</th>
                            <th class="px-6 pb-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Flete P</th>
                            <th class="px-6 pb-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Flete N</th>
                            <th class="px-6 pb-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Gastos GC</th>
                            <th class="px-6 pb-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Gastos OA</th>
                            <th class="px-6 pb-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Incentivo</th>
                            <th class="px-6 pb-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Diferencial</th>
                            <th class="px-6 pb-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Sobreventa</th>
                            <th class="px-6 pb-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Ajuste</th>
                            <th class="px-6 pb-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Total PP</th>
                            <th class="px-6 pb-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Total CC</th>
                            <th class="px-6 pb-4 text-[11px] font-black text-slate-400 uppercase tracking-widest text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse ($sales as $sale)
                            <tr class="hover:bg-slate-50/50 transition-colors group">
                                <td class="px-6 py-5 text-xs font-bold text-slate-600">
                                    {{ $sale->fecha ? $sale->fecha->format('d/m/Y') : '-' }}
                                </td>
                                <td class="px-6 py-5 text-sm font-black text-slate-900">
                                    {{ $sale->awb }}
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex flex-col gap-1">
                                        @if($sale->agency)
                                            <span class="px-2 py-0.5 rounded bg-indigo-50 text-indigo-600 text-[10px] font-black uppercase inline-block max-w-[150px] truncate" title="Agencia: {{ $sale->agency->nombre }}">A: {{ $sale->agency->nombre }}</span>
                                        @endif
                                        @if($sale->client)
                                            <span class="px-2 py-0.5 rounded bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase inline-block max-w-[150px] truncate" title="Cliente: {{ $sale->client->nombre }}">C: {{ $sale->client->nombre }}</span>
                                        @endif
                                        @if(!$sale->agency && !$sale->client)
                                            <span class="text-xs text-slate-300 font-bold">-</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-xs font-bold text-slate-600">{{ number_format($sale->peso, 2) }} kg</td>
                                <td class="px-6 py-5 text-xs font-bold text-slate-600">${{ number_format($sale->tarifa_publica, 4) }}</td>
                                <td class="px-6 py-5 text-xs font-bold text-slate-600">${{ number_format($sale->tarifa_neta, 4) }}</td>
                                <td class="px-6 py-5 text-xs font-bold text-slate-600">${{ number_format($sale->flete_p, 2) }}</td>
                                <td class="px-6 py-5 text-xs font-bold text-slate-600">${{ number_format($sale->flete_n, 2) }}</td>
                                <td class="px-6 py-5 text-xs font-bold text-slate-600">${{ number_format($sale->gastos_gc, 2) }}</td>
                                <td class="px-6 py-5 text-xs font-bold text-slate-600">${{ number_format($sale->gastos_oa, 2) }}</td>
                                <td class="px-6 py-5 text-xs font-bold text-slate-600">${{ number_format($sale->incentivo, 2) }}</td>
                                <td class="px-6 py-5 text-xs font-bold text-slate-600">${{ number_format($sale->diferencial, 2) }}</td>
                                <td class="px-6 py-5 text-xs font-bold text-slate-600">${{ number_format($sale->sobreventa, 2) }}</td>
                                <td class="px-6 py-5 text-xs font-bold text-slate-600">${{ number_format($sale->tarifa_ajuste, 2) }}</td>
                                <td class="px-6 py-5 text-sm font-black text-emerald-600">${{ number_format($sale->total_pp, 2) }}</td>
                                <td class="px-6 py-5 text-sm font-black text-slate-700">${{ number_format($sale->total_cc, 2) }}</td>
                                
                                <td class="px-6 py-5 text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('sales.edit', $sale) }}"
                                            class="size-9 flex items-center justify-center rounded-xl bg-amber-50 text-amber-500 hover:bg-amber-100 transition-colors">
                                            <span class="material-symbols-outlined text-[20px]">edit</span>
                                        </a>
                                        <form action="{{ route('sales.destroy', $sale) }}" method="POST"
                                            class="inline-block form-eliminar" data-name="AWB #{{ $sale->awb }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="size-9 flex items-center justify-center rounded-xl bg-rose-50 text-rose-500 hover:bg-rose-100 transition-colors">
                                                <span class="material-symbols-outlined text-[20px]">delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="17" class="py-10 text-center text-slate-400 font-bold">No se encontraron ventas AWB.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-8 border-t border-slate-100 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <div
                    class="text-[11px] font-black text-slate-400 uppercase tracking-widest bg-slate-50 px-4 py-3 rounded-xl border border-slate-100">
                    Mostrando {{ $sales->firstItem() ?? 0 }} a {{ $sales->lastItem() ?? 0 }} de <span
                        class="text-slate-900 border-b-2 border-primary">{{ $sales->total() }}</span> registros
                </div>
                <div class="w-full md:w-auto overflow-x-auto pb-2 md:pb-0">
                    {{ $sales->links('vendor.pagination.united') }}
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const deleteForms = document.querySelectorAll('.form-eliminar');

            deleteForms.forEach(form => {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    const itemName = this.getAttribute('data-name');

                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: `${itemName} será eliminada de forma permanente.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#94a3b8',
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'Cancelar',
                        customClass: {
                            popup: 'rounded-3xl',
                            confirmButton: 'rounded-xl px-6 py-3 font-bold',
                            cancelButton: 'rounded-xl px-6 py-3 font-bold bg-slate-100 text-slate-600 hover:bg-slate-200'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit();
                        }
                    });
                });
            });
        });
    </script>
@endpush