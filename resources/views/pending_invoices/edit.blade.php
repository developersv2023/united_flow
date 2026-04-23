@extends('layouts.app')

@section('title', 'United Flow - Editar Factura')
@section('page-title', 'Edición de Factura')
@section('page-breadcrumb', 'Gestión / Facturas / Editar')

@section('content')
    <div class="p-10 space-y-10">
        <div class="bg-white rounded-[2.5rem] p-10 custom-shadow border border-slate-100 max-w-4xl mx-auto relative">

            <div class="absolute top-10 right-10">
                <span
                    class="px-3 py-1.5 rounded-xl bg-slate-50 text-slate-400 text-[10px] font-black uppercase tracking-widest border border-slate-200">
                    #{{ $pending_invoice->id }}
                </span>
            </div>

            <div class="mb-10 text-center">
                <div class="size-16 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-500 mx-auto mb-4">
                    <span class="material-symbols-outlined text-4xl font-variation-fill">edit_square</span>
                </div>
                <h2 class="text-2xl font-black text-slate-900 leading-tight">Actualizar Factura Pendiente</h2>
                <p class="text-sm text-slate-400 font-medium mt-1">Acualiza los detalles y estado del comprobante</p>
            </div>

            <form action="{{ route('pending_invoices.update', $pending_invoice) }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    {{-- Numero Factura --}}
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-2 mb-2 block">Cód /
                            Num Factura <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <span
                                class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">qr_code_2</span>
                            <input type="text" name="factura_num"
                                value="{{ old('factura_num', $pending_invoice->factura_num) }}" required
                                placeholder="Ej. FV-2023-001"
                                class="w-full bg-slate-50 border-none rounded-2xl pl-12 pr-4 py-4 text-sm font-bold text-slate-600 focus:ring-2 focus:ring-primary focus:bg-white transition-all">
                        </div>
                        @error('factura_num') <span class="text-rose-500 text-xs font-bold pl-2 mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Monto --}}
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-2 mb-2 block">Monto
                            Total <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <span
                                class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">payments</span>
                            <input type="number" step="0.01" min="0" name="monto"
                                value="{{ old('monto', $pending_invoice->monto) }}" required placeholder="Ej. 1050.00"
                                class="w-full bg-slate-50 border-none rounded-2xl pl-12 pr-4 py-4 text-sm font-bold text-slate-600 focus:ring-2 focus:ring-primary focus:bg-white transition-all">
                        </div>
                        @error('monto') <span class="text-rose-500 text-xs font-bold pl-2 mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Fecha de Emision --}}
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-2 mb-2 block">Fecha
                            Emisión</label>
                        <div class="relative">
                            <span
                                class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">calendar_month</span>
                            <input type="date" name="fecha_emision"
                                value="{{ old('fecha_emision', $pending_invoice->fecha_emision ? $pending_invoice->fecha_emision->format('Y-m-d') : '') }}"
                                class="w-full bg-slate-50 border-none rounded-2xl pl-12 pr-4 py-4 text-sm font-bold text-slate-600 focus:ring-2 focus:ring-primary focus:bg-white transition-all">
                        </div>
                        @error('fecha_emision') <span
                        class="text-rose-500 text-xs font-bold pl-2 mt-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- Mes Facturado --}}
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-2 mb-2 block">Mes
                            Facturado</label>
                        <div class="relative">
                            <span
                                class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">date_range</span>
                            <input type="text" name="mes_facturado"
                                value="{{ old('mes_facturado', $pending_invoice->mes_facturado) }}"
                                placeholder="Ej. May-2023"
                                class="w-full bg-slate-50 border-none rounded-2xl pl-12 pr-4 py-4 text-sm font-bold text-slate-600 focus:ring-2 focus:ring-primary focus:bg-white transition-all">
                        </div>
                        @error('mes_facturado') <span
                        class="text-rose-500 text-xs font-bold pl-2 mt-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- Dias Vencido --}}
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-2 mb-2 block">Días
                            Vencido <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <span
                                class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">hourglass_bottom</span>
                            <input type="number" name="dias_vencido"
                                value="{{ old('dias_vencido', $pending_invoice->dias_vencido) }}" required min="0"
                                placeholder="Ej. 15"
                                class="w-full bg-slate-50 border-none rounded-2xl pl-12 pr-4 py-4 text-sm font-bold text-slate-600 focus:ring-2 focus:ring-primary focus:bg-white transition-all">
                        </div>
                        @error('dias_vencido') <span class="text-rose-500 text-xs font-bold pl-2 mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Estado --}}
                    <div>
                        <label
                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-2 mb-2 block">Estado
                            <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <span
                                class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">rule</span>
                            <select name="estado" required
                                class="w-full bg-slate-50 border-none rounded-2xl pl-12 pr-4 py-4 text-sm font-bold text-slate-600 focus:ring-2 focus:ring-primary focus:bg-white transition-all appearance-none cursor-pointer">
                                <option value="PENDIENTE" {{ old('estado', $pending_invoice->estado) == 'PENDIENTE' ? 'selected' : '' }}>PENDIENTE</option>
                                <option value="PAGADA" {{ old('estado', $pending_invoice->estado) == 'PAGADA' ? 'selected' : '' }}>PAGADA</option>
                                <option value="ANULADA" {{ old('estado', $pending_invoice->estado) == 'ANULADA' ? 'selected' : '' }}>ANULADA</option>
                                <option value="INCOBRABLE" {{ old('estado', $pending_invoice->estado) == 'INCOBRABLE' ? 'selected' : '' }}>INCOBRABLE</option>
                            </select>
                        </div>
                        @error('estado') <span class="text-rose-500 text-xs font-bold pl-2 mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex gap-4 pt-6">
                    <a href="{{ route('pending_invoices.index') }}"
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