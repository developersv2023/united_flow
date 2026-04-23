@extends('layouts.app')

@section('title', 'United Flow - Nuevo Cliente')
@section('page-title', 'Nuevo Cliente')
@section('page-breadcrumb', 'Catálogos / Clientes / Nuevo')

@section('content')
    <div class="p-10 space-y-10">
        <div class="bg-white rounded-[2.5rem] p-10 custom-shadow border border-slate-100 max-w-3xl mx-auto">

            <div class="mb-10 text-center">
                <div class="size-16 rounded-2xl bg-primary/10 flex items-center justify-center text-primary mx-auto mb-4">
                    <span class="material-symbols-outlined text-4xl font-variation-fill">corporate_fare</span>
                </div>
                <h2 class="text-2xl font-black text-slate-900 leading-tight">Registrar Nuevo Cliente</h2>
                <p class="text-sm text-slate-400 font-medium mt-1">Completa los campos para añadirlo al directorio</p>
            </div>

            <form action="{{ route('clients.store') }}" method="POST" class="space-y-8">
                @csrf

                {{-- Nombre --}}
                <div>
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-2 mb-2 block">Nombre /
                        Razón Social <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <span
                            class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">badge</span>
                        <input type="text" name="nombre" value="{{ old('nombre') }}" required
                            placeholder="Ej. Grupo TLA Logistics"
                            class="w-full bg-slate-50 border-none rounded-2xl pl-12 pr-4 py-4 text-sm font-bold text-slate-600 focus:ring-2 focus:ring-primary focus:bg-white transition-all">
                    </div>
                    @error('nombre') <span class="text-rose-500 text-xs font-bold pl-2 mt-1">{{ $message }}</span> @enderror
                </div>

                {{-- NIT --}}
                <div>
                    <label
                        class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-2 mb-2 block">NIT</label>
                    <div class="relative">
                        <span
                            class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">qr_code_2</span>
                        <input type="text" name="nit" value="{{ old('nit') }}" placeholder="Ej. 1234567-8"
                            class="w-full bg-slate-50 border-none rounded-2xl pl-12 pr-4 py-4 text-sm font-bold text-slate-600 focus:ring-2 focus:ring-primary focus:bg-white transition-all">
                    </div>
                    @error('nit') <span class="text-rose-500 text-xs font-bold pl-2 mt-1">{{ $message }}</span> @enderror
                </div>

                {{-- Switches (Activo) --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 bg-slate-50 p-6 rounded-3xl border border-slate-100">
                    <label class="flex items-center justify-between cursor-pointer group">
                        <div>
                            <p class="text-sm font-black text-slate-900">Estado Activo</p>
                            <p class="text-xs font-medium text-slate-400">Permite registrar ventas para este cliente</p>
                        </div>
                        <div class="relative">
                            <input type="checkbox" name="activo" value="1" class="sr-only peer" {{ old('activo', true) ? 'checked' : '' }}>
                            <div
                                class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500">
                            </div>
                        </div>
                    </label>
                </div>

                {{-- Actions --}}
                <div class="flex gap-4 pt-6">
                    <a href="{{ route('clients.index') }}"
                        class="flex-1 text-center bg-slate-100 text-slate-500 font-black py-4 rounded-2xl hover:bg-slate-200 transition-colors">
                        Cancelar
                    </a>
                    <button type="submit"
                        class="flex-1 bg-primary text-white font-black py-4 rounded-2xl shadow-lg shadow-primary/30 hover:-translate-y-1 transition-transform">
                        Guardar Cliente
                    </button>
                </div>
            </form>

        </div>
    </div>
@endsection