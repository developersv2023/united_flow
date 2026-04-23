@extends('layouts.app')

@section('title', 'United Flow - Agencias')
@section('page-title', 'Agencias CASS')
@section('page-breadcrumb', 'Catálogos / Agencias')

@section('content')
    <div class="p-10">

        {{-- Single Container for Everything --}}
        <div class="bg-white rounded-[2.5rem] p-10 custom-shadow border border-slate-100">

            {{-- Header Options --}}
            <div
                class="flex flex-col lg:flex-row justify-between lg:items-center gap-6 mb-8 border-b border-slate-100 pb-8">
                <div>
                    <h2 class="text-2xl font-black text-slate-900 leading-tight">Directorio de Agencias</h2>
                    <p class="text-sm text-slate-400 font-medium mt-1">Gestión de Cuentas y Aliados CASS</p>
                </div>

                <div class="flex gap-4">
                    <a href="{{ route('agencies.excel', request()->all()) }}" target="_blank"
                        download="Listado_Agencias.csv"
                        class="flex items-center gap-2 text-white text-sm font-black py-3 px-6 rounded-2xl hover:opacity-90 transition-all shadow-lg"
                        style="background-color: #02bf74; box-shadow: 0 10px 15px -3px rgba(2, 191, 116, 0.2);">
                        <span class="material-symbols-outlined text-xl">table_chart</span>
                        Exportar Excel
                    </a>

                    <a href="{{ route('agencies.create') }}"
                        class="flex items-center gap-2 bg-primary text-white text-sm font-black py-3 px-6 rounded-2xl shadow-lg shadow-primary/20 hover:-translate-y-1 transition-all">
                        <span class="material-symbols-outlined text-xl">add</span>
                        Nueva Agencia
                    </a>
                </div>
            </div>

            {{-- Filters --}}
            <div class="mb-8 bg-slate-50/50 p-6 rounded-3xl border border-slate-100">
                <form action="{{ route('agencies.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-6"
                    id="filter-form">

                    {{-- Search --}}
                    <div class="md:col-span-2">
                        <label
                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-2 mb-2 block">Buscar</label>
                        <div class="relative">
                            <span
                                class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">search</span>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Nombre o Código..."
                                class="w-full bg-white border border-slate-200 rounded-2xl pl-12 pr-4 py-3.5 text-sm font-bold text-slate-600 focus:ring-2 focus:ring-primary focus:border-transparent transition-all"
                                onchange="document.getElementById('filter-form').submit();">
                        </div>
                    </div>

                    {{-- Type --}}
                    <div>
                        <label
                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-2 mb-2 block">Tipo</label>
                        <select name="type"
                            class="w-full bg-white border border-slate-200 rounded-2xl px-4 py-3.5 text-sm font-bold text-slate-600 focus:ring-2 focus:ring-primary focus:border-transparent transition-all appearance-none cursor-pointer"
                            onchange="document.getElementById('filter-form').submit();">
                            <option value="">Todos los tipos</option>
                            <option value="cass" {{ request('type') == 'cass' ? 'selected' : '' }}>Es CASS</option>
                            <option value="nocass" {{ request('type') == 'nocass' ? 'selected' : '' }}>NO CASS</option>
                        </select>
                    </div>

                    {{-- Estado --}}
                    <div>
                        <label
                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-2 mb-2 block">Estado</label>
                        <select name="status"
                            class="w-full bg-white border border-slate-200 rounded-2xl px-4 py-3.5 text-sm font-bold text-slate-600 focus:ring-2 focus:ring-primary focus:border-transparent transition-all appearance-none cursor-pointer"
                            onchange="document.getElementById('filter-form').submit();">
                            <option value="">Todos</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Activas</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactivas
                            </option>
                        </select>
                    </div>

                </form>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left border-b border-slate-100">
                            <th class="pb-4 text-[11px] font-black text-slate-400 uppercase tracking-widest pl-4">Agencia
                            </th>
                            <th class="pb-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Código</th>
                            <th class="pb-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Tipo CASS</th>
                            <th class="pb-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Estado</th>
                            <th
                                class="pb-4 text-[11px] font-black text-slate-400 uppercase tracking-widest text-right pr-4">
                                Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse ($agencies as $agency)
                            <tr class="hover:bg-slate-50/50 transition-colors group">
                                <td class="py-5 pl-4">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="size-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary font-bold text-sm">
                                            {{ substr($agency->nombre, 0, 2) }}
                                        </div>
                                        <p class="text-sm font-black text-slate-900">{{ $agency->nombre }}</p>
                                    </div>
                                </td>
                                <td class="py-5">
                                    @if($agency->codigo)
                                        <span
                                            class="px-3 py-1.5 rounded-xl bg-slate-100 text-slate-600 text-[10px] font-black uppercase tracking-widest">{{ $agency->codigo }}</span>
                                    @else
                                        <span class="text-xs text-slate-300 font-bold">-</span>
                                    @endif
                                </td>
                                <td class="py-5">
                                    @if($agency->cass)
                                        <span
                                            class="px-3 py-1.5 rounded-xl bg-indigo-50 text-indigo-600 text-[10px] font-black uppercase tracking-widest"><span
                                                class="material-symbols-outlined text-[12px] align-text-bottom mr-1">check_circle</span>CASS</span>
                                    @else
                                        <span
                                            class="px-3 py-1.5 rounded-xl bg-rose-50 text-rose-500 text-[10px] font-black uppercase tracking-widest">NO
                                            CASS</span>
                                    @endif
                                </td>
                                <td class="py-5">
                                    @if($agency->activo)
                                        <span
                                            class="px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase tracking-widest">Activa</span>
                                    @else
                                        <span
                                            class="px-3 py-1.5 rounded-xl bg-slate-100 text-slate-400 text-[10px] font-black uppercase tracking-widest">Inactiva</span>
                                    @endif
                                </td>
                                <td class="py-5 pr-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('agencies.edit', $agency) }}"
                                            class="size-9 flex items-center justify-center rounded-xl bg-amber-50 text-amber-500 hover:bg-amber-100 transition-colors">
                                            <span class="material-symbols-outlined text-[20px]">edit</span>
                                        </a>
                                        <form action="{{ route('agencies.destroy', $agency) }}" method="POST"
                                            class="inline-block form-eliminar" data-name="{{ $agency->nombre }}">
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
                                <td colspan="5" class="py-10 text-center text-slate-400 font-bold">No se encontraron agencias.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-8 border-t border-slate-100 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <div
                    class="text-[11px] font-black text-slate-400 uppercase tracking-widest bg-slate-50 px-4 py-3 rounded-xl border border-slate-100">
                    Mostrando {{ $agencies->firstItem() ?? 0 }} a {{ $agencies->lastItem() ?? 0 }} de <span
                        class="text-slate-900 border-b-2 border-primary">{{ $agencies->total() }}</span> registros
                </div>
                <div class="w-full md:w-auto overflow-x-auto pb-2 md:pb-0">
                    {{ $agencies->links('vendor.pagination.united') }}
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
                    const agencyName = this.getAttribute('data-name');

                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: `La agencia "${agencyName}" será eliminada de forma permanente.`,
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