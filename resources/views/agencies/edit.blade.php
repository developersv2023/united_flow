@extends('layouts.app')

@section('title', 'United Flow - Editar Agencia')
@section('page-title', 'Edición de Agencia')
@section('page-breadcrumb', 'Catálogos / Agencias / Editar')

@section('content')
    <div class="p-10 space-y-10">
        <div class="bg-white rounded-[2.5rem] p-10 custom-shadow border border-slate-100 max-w-3xl mx-auto relative">

            <div class="absolute top-10 right-10">
                <span
                    class="px-3 py-1.5 rounded-xl bg-slate-50 text-slate-400 text-[10px] font-black uppercase tracking-widest border border-slate-200">
                    #{{ $agency->id }}
                </span>
            </div>

            <div class="mb-10 text-center">
                <div class="size-16 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-500 mx-auto mb-4">
                    <span class="material-symbols-outlined text-4xl font-variation-fill">edit_square</span>
                </div>
                <h2 class="text-2xl font-black text-slate-900 leading-tight">Actualizar de Agencia</h2>
                <p class="text-sm text-slate-400 font-medium mt-1">Sincroniza los cambios con el sistema CASS</p>
            </div>

            <form action="{{ route('agencies.update', $agency) }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')

                {{-- Nombre --}}
                <div>
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-2 mb-2 block">Nombre /
                        Razón Social <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <span
                            class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">badge</span>
                        <input type="text" name="nombre" value="{{ old('nombre', $agency->nombre) }}" required
                            placeholder="Ej. Grupo TLA Logistics"
                            class="w-full bg-slate-50 border-none rounded-2xl pl-12 pr-4 py-4 text-sm font-bold text-slate-600 focus:ring-2 focus:ring-primary focus:bg-white transition-all">
                    </div>
                    @error('nombre') <span class="text-rose-500 text-xs font-bold pl-2 mt-1">{{ $message }}</span> @enderror
                </div>

                {{-- Código --}}
                <div>
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-2 mb-2 block">Código
                        Referencial</label>
                    <div class="relative">
                        <span
                            class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">qr_code_2</span>
                        <input type="text" name="codigo" value="{{ old('codigo', $agency->codigo) }}" placeholder="Ej. CBX"
                            class="w-full bg-slate-50 border-none rounded-2xl pl-12 pr-4 py-4 text-sm font-bold text-slate-600 focus:ring-2 focus:ring-primary focus:bg-white transition-all">
                    </div>
                    @error('codigo') <span class="text-rose-500 text-xs font-bold pl-2 mt-1">{{ $message }}</span> @enderror
                </div>

                {{-- Switches (Cass, Activo) --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 bg-slate-50 p-6 rounded-3xl border border-slate-100">
                    <label class="flex items-center justify-between cursor-pointer group">
                        <div>
                            <p class="text-sm font-black text-slate-900">Agencia CASS</p>
                            <p class="text-xs font-medium text-slate-400">Genera reporte CASS directo</p>
                        </div>
                        <div class="relative">
                            <input type="checkbox" name="cass" value="1" class="sr-only peer" {{ old('cass', $agency->cass) ? 'checked' : '' }}>
                            <div
                                class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600">
                            </div>
                        </div>
                    </label>

                    <label class="flex items-center justify-between cursor-pointer group">
                        <div>
                            <p class="text-sm font-black text-slate-900">Estado Activo</p>
                            <p class="text-xs font-medium text-slate-400">Permite registrar ventas</p>
                        </div>
                        <div class="relative">
                            <input type="checkbox" name="activo" value="1" class="sr-only peer" {{ old('activo', $agency->activo) ? 'checked' : '' }}>
                            <div
                                class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500">
                            </div>
                        </div>
                    </label>
                </div>

                {{-- Actions --}}
                <div class="flex gap-4 pt-6">
                    <a href="{{ route('agencies.index') }}"
                        class="flex-1 text-center bg-slate-100 text-slate-500 font-black py-4 rounded-2xl hover:bg-slate-200 transition-colors">
                        Descartar Cambios
                    </a>
                    <button type="submit"
                        class="flex-1 bg-amber-500 text-white font-black py-4 rounded-2xl shadow-lg shadow-amber-500/30 hover:-translate-y-1 transition-transform">
                        Actualizar Información
                    </button>
                </div>
            </form>

        </div>
    </div>
@endsection