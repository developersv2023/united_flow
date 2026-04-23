@extends('layouts.app')

@section('title', 'United Flow - Transacciones de Agencia')
@section('page-title', 'Transacciones de Agencia')
@section('page-breadcrumb', 'Transacciones / Listado Global')

@section('content')
    <div class="px-10 py-8">
        
        {{-- Header Actions --}}
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-xl font-black text-slate-900">Directorio de Transacciones CASS</h2>
            <div class="flex gap-4">
                <a href="{{ route('agency_transactions.create') }}" class="group flex items-center gap-2 bg-primary text-white text-sm font-bold py-3 px-6 rounded-2xl hover:bg-primary/90 transition-all custom-shadow hover:-translate-y-0.5">
                    <span class="material-symbols-outlined text-lg group-hover:rotate-90 transition-transform">add</span>
                    Nueva Transacción
                </a>
            </div>
        </div>

        {{-- Main Container --}}
        <div class="bg-white border border-slate-200 rounded-[2rem] custom-shadow overflow-hidden">
            
            {{-- Filters --}}
            <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                <form action="{{ route('agency_transactions.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-6" id="filter-form">
                    
                    {{-- Search AWB --}}
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-2 mb-2 block">Buscar Ref / AWB</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">search</span>
                            <input type="text" name="awb" value="{{ request('awb') }}" placeholder="AWB o Ref..."
                                class="w-full bg-white border border-slate-200 rounded-2xl pl-12 pr-4 py-3 text-sm font-bold text-slate-600 focus:ring-2 focus:ring-primary focus:border-transparent transition-all"
                                onchange="document.getElementById('filter-form').submit();">
                        </div>
                    </div>

                    {{-- Agencia --}}
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-2 mb-2 block">Filtrar Agencia</label>
                        <select name="agency_id" class="w-full bg-white border border-slate-200 rounded-2xl px-4 py-3 text-sm font-bold text-slate-600 focus:ring-2 focus:ring-primary focus:border-transparent cursor-pointer" onchange="document.getElementById('filter-form').submit();">
                            <option value="">Todas las Agencias</option>
                            @foreach($agencies as $agency)
                                <option value="{{ $agency->id }}" {{ request('agency_id') == $agency->id ? 'selected' : '' }}>{{ $agency->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Quincena Periodo --}}
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-2 mb-2 block">Periodo</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">calendar_month</span>
                            <input type="text" name="periodo" value="{{ request('periodo') }}" placeholder="Ej. 1S MAR 2026"
                                class="w-full bg-white border border-slate-200 rounded-2xl pl-12 pr-4 py-3 text-sm font-bold text-slate-600 focus:ring-2 focus:ring-primary transition-all"
                                onchange="document.getElementById('filter-form').submit();">
                        </div>
                    </div>

                    {{-- Botón Exportar --}}
                    <div class="flex items-end">
                        <a href="{{ route('agency_transactions.excel', request()->all()) }}" class="w-full flex items-center justify-center gap-2 bg-emerald-50 text-emerald-600 border border-emerald-100 py-3 px-4 text-sm font-black rounded-2xl hover:bg-emerald-100 transition-colors">
                            <span class="material-symbols-outlined text-[18px]">download</span> Exportar
                        </a>
                    </div>
                </form>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="w-full whitespace-nowrap">
                    <thead>
                        <tr class="text-left border-b border-slate-100 bg-white">
                            <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Fecha</th>
                            <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Agencia</th>
                            <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Periodo / Ref</th>
                            <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Saldo Acumulado</th>
                            <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($transactions as $t)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-6 py-5 text-sm font-bold text-slate-600">
                                {{ $t->fecha_transaccion ? $t->fecha_transaccion->format('d/m/Y') : '-' }}
                            </td>
                            <td class="px-6 py-5">
                                <p class="text-sm font-black text-slate-900">{{ $t->agency ? $t->agency->nombre : 'Indefinida' }}</p>
                                <p class="text-[10px] font-bold text-slate-400 uppercase">{{ $t->agency ? $t->agency->codigo_iata : '' }}</p>
                            </td>
                            <td class="px-6 py-5">
                                <span class="px-2.5 py-1 bg-indigo-50 text-indigo-600 rounded-lg text-[10px] font-black uppercase">{{ $t->quincena_periodo }}</span>
                                <p class="text-xs font-bold text-slate-500 mt-1 uppercase">{{ $t->awb_referencia ?? 'S/R' }}</p>
                            </td>
                            <td class="px-6 py-5 text-right font-black text-emerald-600 text-sm">
                                ${{ number_format($t->saldo_acumulado, 2) }}
                            </td>
                            <td class="px-6 py-5 text-center">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('agency_transactions.edit', $t) }}" class="size-9 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center hover:bg-amber-100 transition-colors" title="Editar">
                                        <span class="material-symbols-outlined text-[18px]">edit</span>
                                    </a>
                                    <form action="{{ route('agency_transactions.destroy', $t) }}" method="POST" class="inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDelete(this)" class="size-9 rounded-xl bg-rose-50 text-rose-500 flex items-center justify-center hover:bg-rose-100 transition-colors" title="Eliminar">
                                            <span class="material-symbols-outlined text-[18px]">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                <span class="material-symbols-outlined text-4xl mb-2 opacity-50">receipt_long</span>
                                <p class="text-sm font-bold">No se encontraron transacciones en esta consulta.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($transactions->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                {{ $transactions->links('vendor.pagination.united') }}
            </div>
            @endif

        </div>
    </div>

    @push('scripts')
    <script>
        function confirmDelete(button) {
            Swal.fire({
                title: '¿Eliminar transacción?',
                text: "Esta acción no se puede deshacer y alterará los históricos CASS.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest('form').submit();
                }
            })
        }
    </script>
    @endpush
@endsection
