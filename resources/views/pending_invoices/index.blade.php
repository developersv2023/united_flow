@extends('layouts.app')

@section('title', 'United Flow - Facturas Pendientes')
@section('page-title', 'Facturas Pendientes')
@section('page-breadcrumb', 'Gestión / Facturas')

@section('content')
    <div class="p-10">

        {{-- Single Container for Everything --}}
        <div class="bg-white rounded-[2.5rem] p-10 custom-shadow border border-slate-100">

            {{-- Header Options --}}
            <div class="flex flex-col lg:flex-row justify-between lg:items-center gap-6 mb-8 border-b border-slate-100 pb-8">
                <div>
                    <h2 class="text-2xl font-black text-slate-900 leading-tight">Facturas Pendientes</h2>
                    <p class="text-sm text-slate-400 font-medium mt-1">Control de Deuda y Pagos CASS</p>
                </div>

                <div class="flex gap-4">
                    <a href="{{ route('pending_invoices.excel', request()->all()) }}" target="_blank" download="Listado_Facturas.csv"
                        class="flex items-center gap-2 text-white text-sm font-black py-3 px-6 rounded-2xl hover:opacity-90 transition-all shadow-lg"
                        style="background-color: #02bf74; box-shadow: 0 10px 15px -3px rgba(2, 191, 116, 0.2);">
                        <span class="material-symbols-outlined text-xl">table_chart</span>
                        Exportar Excel
                    </a>

                    <a href="{{ route('pending_invoices.create') }}"
                        class="flex items-center gap-2 bg-primary text-white text-sm font-black py-3 px-6 rounded-2xl shadow-lg shadow-primary/20 hover:-translate-y-1 transition-all">
                        <span class="material-symbols-outlined text-xl">add</span>
                        Nueva Factura
                    </a>
                </div>
            </div>

            {{-- Filters --}}
            <div class="mb-8 bg-slate-50/50 p-6 rounded-3xl border border-slate-100">
                <form action="{{ route('pending_invoices.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-6"
                    id="filter-form">

                    {{-- Search --}}
                    <div class="md:col-span-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-2 mb-2 block">Buscar Factura</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">search</span>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Num. Factura..."
                                class="w-full bg-white border border-slate-200 rounded-2xl pl-12 pr-4 py-3.5 text-sm font-bold text-slate-600 focus:ring-2 focus:ring-primary focus:border-transparent transition-all"
                                onchange="document.getElementById('filter-form').submit();">
                        </div>
                    </div>

                    {{-- Mes --}}
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-2 mb-2 block">Mes Facturado</label>
                        <select name="month"
                            class="w-full bg-white border border-slate-200 rounded-2xl px-4 py-3.5 text-sm font-bold text-slate-600 focus:ring-2 focus:ring-primary focus:border-transparent transition-all appearance-none cursor-pointer"
                            onchange="document.getElementById('filter-form').submit();">
                            <option value="">Todos</option>
                            @foreach($months as $m)
                                <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>{{ $m }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Estado --}}
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-2 mb-2 block">Estado</label>
                        <select name="status"
                            class="w-full bg-white border border-slate-200 rounded-2xl px-4 py-3.5 text-sm font-bold text-slate-600 focus:ring-2 focus:ring-primary focus:border-transparent transition-all appearance-none cursor-pointer"
                            onchange="document.getElementById('filter-form').submit();">
                            <option value="">Todos</option>
                            <option value="PENDIENTE" {{ request('status') == 'PENDIENTE' ? 'selected' : '' }}>PENDIENTE</option>
                            <option value="PAGADA" {{ request('status') == 'PAGADA' ? 'selected' : '' }}>PAGADA</option>
                            <option value="ANULADA" {{ request('status') == 'ANULADA' ? 'selected' : '' }}>ANULADA</option>
                            <option value="INCOBRABLE" {{ request('status') == 'INCOBRABLE' ? 'selected' : '' }}>INCOBRABLE</option>
                        </select>
                    </div>

                </form>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left border-b border-slate-100">
                            <th class="pb-4 text-[11px] font-black text-slate-400 uppercase tracking-widest pl-4">Factura</th>
                            <th class="pb-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Monto</th>
                            <th class="pb-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Emisión / Mes</th>
                            <th class="pb-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Vencimiento</th>
                            <th class="pb-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Estado</th>
                            <th class="pb-4 text-[11px] font-black text-slate-400 uppercase tracking-widest text-right pr-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse ($invoices as $invoice)
                            <tr class="hover:bg-slate-50/50 transition-colors group">
                                <td class="py-5 pl-4">
                                    <div class="flex items-center gap-4">
                                        <div class="size-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary font-bold text-sm">
                                            <span class="material-symbols-outlined text-[20px]">receipt_long</span>
                                        </div>
                                        <p class="text-sm font-black text-slate-900">{{ $invoice->factura_num }}</p>
                                    </div>
                                </td>
                                <td class="py-5">
                                    <span class="text-sm font-bold text-slate-700">${{ number_format($invoice->monto, 2) }}</span>
                                </td>
                                <td class="py-5">
                                    <div class="flex flex-col">
                                        <span class="text-xs text-slate-900 font-bold object-contain">{{ $invoice->fecha_emision ? $invoice->fecha_emision->format('d/m/Y') : '-' }}</span>
                                        <span class="text-[10px] text-slate-400 font-bold uppercase">{{ $invoice->mes_facturado ?? '-' }}</span>
                                    </div>
                                </td>
                                <td class="py-5">
                                    @if($invoice->estado === 'PAGADA')
                                        <span class="text-xs text-slate-300 font-bold">-</span>
                                    @elseif($invoice->dias_vencido > 0)
                                        <span class="px-3 py-1.5 rounded-xl bg-orange-50 text-orange-600 text-[10px] font-black uppercase tracking-widest border border-orange-100">{{ $invoice->dias_vencido }} Días</span>
                                    @else
                                        <span class="px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase tracking-widest border border-emerald-100">Al Día</span>
                                    @endif
                                </td>
                                <td class="py-5">
                                    @if($invoice->estado == 'PENDIENTE')
                                        <span class="px-3 py-1.5 rounded-xl bg-amber-50 text-amber-600 text-[10px] font-black uppercase tracking-widest">{{ $invoice->estado }}</span>
                                    @elseif($invoice->estado == 'PAGADA')
                                        <span class="px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase tracking-widest">{{ $invoice->estado }}</span>
                                    @elseif($invoice->estado == 'ANULADA')
                                        <span class="px-3 py-1.5 rounded-xl bg-slate-100 text-slate-500 text-[10px] font-black uppercase tracking-widest">{{ $invoice->estado }}</span>
                                    @else
                                        <span class="px-3 py-1.5 rounded-xl bg-red-50 text-red-600 text-[10px] font-black uppercase tracking-widest">{{ $invoice->estado }}</span>
                                    @endif
                                </td>
                                <td class="py-5 pr-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('pending_invoices.edit', $invoice) }}"
                                            class="size-9 flex items-center justify-center rounded-xl bg-amber-50 text-amber-500 hover:bg-amber-100 transition-colors">
                                            <span class="material-symbols-outlined text-[20px]">edit</span>
                                        </a>
                                        <form action="{{ route('pending_invoices.destroy', $invoice) }}" method="POST"
                                            class="inline-block form-eliminar" data-name="Factura #{{ $invoice->factura_num }}">
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
                                <td colspan="6" class="py-10 text-center text-slate-400 font-bold">No se encontraron facturas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-8 border-t border-slate-100 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="text-[11px] font-black text-slate-400 uppercase tracking-widest bg-slate-50 px-4 py-3 rounded-xl border border-slate-100">
                    Mostrando {{ $invoices->firstItem() ?? 0 }} a {{ $invoices->lastItem() ?? 0 }} de <span class="text-slate-900 border-b-2 border-primary">{{ $invoices->total() }}</span> registros
                </div>
                <div class="w-full md:w-auto overflow-x-auto pb-2 md:pb-0">
                    {{ $invoices->links('vendor.pagination.united') }}
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
