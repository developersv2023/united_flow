@extends('layouts.app')

@section('title', 'United Flow - Sales Overview')
@section('page-title', 'Sales Overview')
@section('page-breadcrumb', 'Dashboard / Analytics')

@section('content')
    <div class="p-10 space-y-10">

        {{-- ========== METRIC CARDS ========== --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">

            {{-- Ingreso Bruto Flete P --}}
            <div
                class="group relative flex flex-col gap-4 rounded-[2rem] p-8 bg-white border border-slate-100 custom-shadow hover:-translate-y-1 transition-all duration-300">
                <div class="flex justify-between items-center">
                    <div class="size-14 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-500">
                        <span class="material-symbols-outlined text-3xl font-variation-fill">payments</span>
                    </div>
                    <div class="flex flex-col items-end">
                        @if($salesGrowth >= 0)
                            <span class="text-emerald-500 text-xs font-black bg-emerald-50 px-2 py-1 rounded-lg">+{{ number_format($salesGrowth, 1) }}%</span>
                        @else
                            <span class="text-rose-500 text-xs font-black bg-rose-50 px-2 py-1 rounded-lg">{{ number_format($salesGrowth, 1) }}%</span>
                        @endif
                    </div>
                </div>
                <div>
                    <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">Costo Ventas P (Mes)</p>
                    <p class="text-4xl font-black text-slate-900 leading-tight mt-1"><span class="text-xl text-slate-300">$</span>{{ number_format($salesCurrentMonth, 2) }}</p>
                </div>
                <div class="mt-2 h-16 w-full bg-slate-50 rounded-2xl overflow-hidden relative border border-slate-100">
                    <div class="absolute inset-0 bg-gradient-to-t from-emerald-500/20 to-emerald-500/5 {{ $salesGrowth >= 0 ? '' : 'rotate-180 opacity-50' }}"
                        style="clip-path: polygon(0 80%, 20% 60%, 40% 75%, 60% 40%, 80% 55%, 100% 10%, 100% 100%, 0% 100%);">
                    </div>
                </div>
            </div>

            {{-- Operaciones AWBs --}}
            <div
                class="group relative flex flex-col gap-4 rounded-[2rem] p-8 bg-white border border-slate-100 custom-shadow hover:-translate-y-1 transition-all duration-300">
                <div class="flex justify-between items-center">
                    <div class="size-14 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                        <span class="material-symbols-outlined text-3xl font-variation-fill">flight_takeoff</span>
                    </div>
                    <div class="flex flex-col items-end">
                        @if($awbsGrowth >= 0)
                            <span class="text-emerald-500 text-xs font-black bg-emerald-50 px-2 py-1 rounded-lg">+{{ number_format($awbsGrowth, 1) }}%</span>
                        @else
                            <span class="text-rose-500 text-xs font-black bg-rose-50 px-2 py-1 rounded-lg">{{ number_format($awbsGrowth, 1) }}%</span>
                        @endif
                    </div>
                </div>
                <div>
                    <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">Operaciones (Mes)</p>
                    <p class="text-4xl font-black text-slate-900 leading-tight mt-1">{{ number_format($awbsCurrentMonth) }}</p>
                </div>
                <div class="mt-2 h-16 w-full bg-slate-50 rounded-2xl overflow-hidden relative border border-slate-100">
                    <div class="absolute inset-0 bg-gradient-to-t from-indigo-500/20 to-indigo-500/5 {{ $awbsGrowth >= 0 ? '' : 'rotate-180 opacity-50' }}"
                        style="clip-path: polygon(0 60%, 15% 70%, 30% 50%, 50% 65%, 70% 30%, 85% 45%, 100% 20%, 100% 100%, 0% 100%);">
                    </div>
                </div>
            </div>

            {{-- Clientes Activos --}}
            <div
                class="group relative flex flex-col gap-4 rounded-[2rem] p-8 bg-white border border-slate-100 custom-shadow hover:-translate-y-1 transition-all duration-300">
                <div class="flex justify-between items-center">
                    <div class="size-14 rounded-2xl bg-primary/10 flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined text-3xl font-variation-fill">group</span>
                    </div>
                </div>
                <div>
                    <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">Clientes Registrados</p>
                    <p class="text-4xl font-black text-slate-900 leading-tight mt-1">{{ number_format($totalClients) }}</p>
                </div>
                <div class="mt-2 h-16 w-full bg-slate-50 rounded-2xl overflow-hidden relative border border-slate-100">
                    <div class="absolute inset-0 bg-gradient-to-t from-primary/20 to-primary/5"
                        style="clip-path: polygon(0 90%, 25% 60%, 50% 70%, 75% 30%, 100% 40%, 100% 100%, 0% 100%);"></div>
                </div>
            </div>

            {{-- Agentes Activos --}}
            <div
                class="group relative flex flex-col gap-4 rounded-[2rem] p-8 bg-white border border-slate-100 custom-shadow hover:-translate-y-1 transition-all duration-300">
                <div class="flex justify-between items-center">
                    <div class="size-14 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-600">
                        <span class="material-symbols-outlined text-3xl font-variation-fill">corporate_fare</span>
                    </div>
                </div>
                <div>
                    <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">Agencias CASS</p>
                    <p class="text-4xl font-black text-slate-900 leading-tight mt-1">{{ number_format($totalAgencies) }}</p>
                </div>
                <div class="mt-2 h-16 w-full bg-slate-50 rounded-2xl overflow-hidden relative border border-slate-100">
                    <div class="absolute inset-0 bg-gradient-to-t from-amber-500/20 to-amber-500/5"
                        style="clip-path: polygon(0 50%, 20% 40%, 40% 60%, 60% 50%, 80% 70%, 100% 40%, 100% 100%, 0% 100%);">
                    </div>
                </div>
            </div>

        </div>

        {{-- ========== CHART + ACTIVITY ========== --}}
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-10">

            {{-- Monthly Sales Trends --}}
            <div class="xl:col-span-2 bg-white rounded-[2.5rem] p-10 custom-shadow border border-slate-100">
                <div class="flex items-center justify-between mb-10">
                    <div>
                        <h2 class="text-2xl font-black text-slate-900 leading-tight">Monthly Sales Trends</h2>
                        <p class="text-sm text-slate-400 font-medium">Visual performance tracking for current fiscal year
                        </p>
                    </div>
                    <div class="flex gap-2">
                        <button
                            class="bg-slate-50 border border-slate-200 text-slate-600 text-xs font-black py-2.5 px-5 rounded-xl hover:bg-white transition-all">Last
                            6 Months</button>
                        <button
                            class="bg-primary text-white text-xs font-black py-2.5 px-5 rounded-xl shadow-lg shadow-primary/20">Monthly</button>
                    </div>
                </div>
                <div class="relative h-72 w-full">
                    {{-- Grid lines --}}
                    <div class="absolute inset-0 flex flex-col justify-between pointer-events-none opacity-50">
                        <div class="w-full border-t border-slate-100"></div>
                        <div class="w-full border-t border-slate-100"></div>
                        <div class="w-full border-t border-slate-100"></div>
                        <div class="w-full border-t border-slate-100"></div>
                    </div>
                    {{-- Bars --}}
                    <div class="absolute inset-0 flex items-end justify-between px-8 pb-0">
                        <div
                            class="w-14 bg-slate-100 rounded-t-2xl h-[45%] hover:bg-primary/20 transition-all cursor-pointer group relative">
                            <span
                                class="absolute -top-10 left-1/2 -translate-x-1/2 bg-slate-900 text-white text-[10px] font-bold py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity">$9.2k</span>
                        </div>
                        <div
                            class="w-14 bg-slate-100 rounded-t-2xl h-[65%] hover:bg-primary/20 transition-all cursor-pointer group relative">
                            <span
                                class="absolute -top-10 left-1/2 -translate-x-1/2 bg-slate-900 text-white text-[10px] font-bold py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity">$14.5k</span>
                        </div>
                        <div
                            class="w-14 bg-slate-100 rounded-t-2xl h-[55%] hover:bg-primary/20 transition-all cursor-pointer group relative">
                            <span
                                class="absolute -top-10 left-1/2 -translate-x-1/2 bg-slate-900 text-white text-[10px] font-bold py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity">$12.1k</span>
                        </div>
                        <div
                            class="w-14 bg-primary rounded-t-2xl h-[85%] relative shadow-[0_-10px_20px_-5px_rgba(43,150,238,0.4)] group">
                            <div
                                class="absolute -top-14 left-1/2 -translate-x-1/2 bg-slate-900 text-white text-[11px] py-2 px-4 rounded-xl whitespace-nowrap shadow-xl">
                                <span class="font-bold">Apr:</span> $12.4k
                                <div
                                    class="absolute bottom-[-6px] left-1/2 -translate-x-1/2 border-l-[6px] border-r-[6px] border-t-[6px] border-l-transparent border-r-transparent border-t-slate-900">
                                </div>
                            </div>
                        </div>
                        <div
                            class="w-14 bg-slate-100 rounded-t-2xl h-[70%] hover:bg-primary/20 transition-all cursor-pointer group relative">
                            <span
                                class="absolute -top-10 left-1/2 -translate-x-1/2 bg-slate-900 text-white text-[10px] font-bold py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity">$15.8k</span>
                        </div>
                        <div
                            class="w-14 bg-slate-100 rounded-t-2xl h-[78%] hover:bg-primary/20 transition-all cursor-pointer group relative">
                            <span
                                class="absolute -top-10 left-1/2 -translate-x-1/2 bg-slate-900 text-white text-[10px] font-bold py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity">$17.2k</span>
                        </div>
                    </div>
                </div>
                {{-- Month labels --}}
                <div
                    class="flex justify-between mt-8 px-8 text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">
                    <span>Jan</span>
                    <span>Feb</span>
                    <span>Mar</span>
                    <span class="text-primary">Apr</span>
                    <span>May</span>
                    <span>Jun</span>
                </div>
            </div>

            {{-- Activity Feed --}}
            <div class="bg-white rounded-[2.5rem] p-10 custom-shadow border border-slate-100">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-2xl font-black text-slate-900 leading-tight">Activity</h3>
                    <button
                        class="text-xs font-black text-primary bg-primary/5 px-4 py-2 rounded-xl hover:bg-primary/10 transition-colors">View
                        All</button>
                </div>
                <div
                    class="space-y-8 relative before:absolute before:left-[1.75rem] before:top-4 before:bottom-4 before:w-px before:bg-slate-100">

                    {{-- Activity 1: New Order --}}
                    <div class="relative flex items-start gap-6 group">
                        <div
                            class="size-14 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center shrink-0 z-10 custom-shadow">
                            <span class="material-symbols-outlined font-variation-fill">shopping_cart_checkout</span>
                        </div>
                        <div class="flex-1 min-w-0 pt-1">
                            <div class="flex justify-between items-start">
                                <p class="text-sm font-black text-slate-900">New Order #8492</p>
                                <p class="text-sm font-black text-emerald-600">+$240</p>
                            </div>
                            <p class="text-xs text-slate-400 font-medium mt-1">James Wilson • 2m ago</p>
                        </div>
                    </div>

                    {{-- Activity 2: Customer Registered --}}
                    <div class="relative flex items-start gap-6 group">
                        <div
                            class="size-14 bg-primary/10 text-primary rounded-2xl flex items-center justify-center shrink-0 z-10 custom-shadow">
                            <span class="material-symbols-outlined font-variation-fill">person_add</span>
                        </div>
                        <div class="flex-1 min-w-0 pt-1">
                            <p class="text-sm font-black text-slate-900">Customer Registered</p>
                            <p class="text-xs text-slate-400 font-medium mt-1">Sarah Jenkins joined • 45m ago</p>
                            <div class="mt-3 flex items-center gap-2">
                                <span
                                    class="text-[9px] bg-slate-100 text-slate-500 px-2 py-1 rounded-lg font-black tracking-widest uppercase">Retail</span>
                                <span
                                    class="text-[9px] bg-primary/10 text-primary px-2 py-1 rounded-lg font-black tracking-widest uppercase">Enterprise</span>
                            </div>
                        </div>
                    </div>

                    {{-- Activity 3: Low Stock Alert --}}
                    <div class="relative flex items-start gap-6 group">
                        <div
                            class="size-14 bg-amber-100 text-amber-600 rounded-2xl flex items-center justify-center shrink-0 z-10 custom-shadow">
                            <span class="material-symbols-outlined font-variation-fill">warning</span>
                        </div>
                        <div class="flex-1 min-w-0 pt-1">
                            <div class="flex justify-between items-start">
                                <p class="text-sm font-black text-slate-900">Low Stock Alert</p>
                                <button
                                    class="text-[10px] font-black text-amber-600 px-3 py-1 bg-amber-50 rounded-lg hover:bg-amber-100 transition-colors uppercase tracking-widest">Restock</button>
                            </div>
                            <p class="text-xs text-slate-400 font-medium mt-1">Bose QC45 Headphones • 1h ago</p>
                        </div>
                    </div>

                    {{-- Activity 4: System Report --}}
                    <div class="relative flex items-start gap-6 group">
                        <div
                            class="size-14 bg-slate-100 text-slate-500 rounded-2xl flex items-center justify-center shrink-0 z-10 custom-shadow">
                            <span class="material-symbols-outlined font-variation-fill">description</span>
                        </div>
                        <div class="flex-1 min-w-0 pt-1">
                            <p class="text-sm font-black text-slate-900">System Report</p>
                            <p class="text-xs text-slate-400 font-medium mt-1">Q2 Sales Performance Ready • 3h ago</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ========== LATEST ORDERS + SALES REPS ========== --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

            {{-- Latest Orders Table --}}
            <div class="bg-white rounded-[2.5rem] p-10 custom-shadow border border-slate-100 col-span-1 lg:col-span-2">
                <div class="flex justify-between items-center mb-8">
                    <h3 class="text-2xl font-black text-slate-900">Actividad Reciente</h3>
                    <a href="{{ route('sales.index') }}" class="text-primary font-bold text-sm bg-primary/10 px-4 py-2 rounded-xl">Ver Todo</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="text-left border-b border-slate-100">
                                <th class="pb-4 text-[11px] font-black text-slate-400 uppercase tracking-widest px-4">Entidad</th>
                                <th class="pb-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">AWB</th>
                                <th class="pb-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Fecha</th>
                                <th class="pb-4 text-[11px] font-black text-slate-400 uppercase tracking-widest text-right px-4">
                                    Flete Bruto P</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($recentSales as $sale)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="py-5 px-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="size-9 rounded-xl bg-slate-50 flex items-center justify-center text-slate-500 font-bold text-xs uppercase shadow-sm">
                                            {{ substr($sale->client ? $sale->client->nombre : ($sale->agency ? $sale->agency->nombre : 'NA'), 0, 2) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-black text-slate-900 truncate max-w-[150px] lg:max-w-xs">{{ $sale->client ? $sale->client->nombre : ($sale->agency ? $sale->agency->nombre : 'Sin Entidad') }}</p>
                                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">{{ $sale->client ? 'Cliente' : 'Agencia' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-5 font-black text-slate-700 text-sm">
                                    {{ $sale->awb }}
                                </td>
                                <td class="py-5">
                                    <span class="px-3 py-1.5 rounded-xl bg-slate-100 text-slate-500 text-[10px] font-black uppercase tracking-widest">{{ $sale->fecha ? $sale->fecha->format('d/m/Y') : '-' }}</span>
                                </td>
                                <td class="py-5 px-4 text-right font-black text-emerald-600 text-sm">${{ number_format($sale->flete_p, 2) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-10 text-center font-bold text-slate-400">Aún no hay ventas u operaciones registradas en el sistema.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </div>

    </div>
@endsection