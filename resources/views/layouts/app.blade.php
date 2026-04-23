<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'United Flow - Dashboard')</title>

    {{-- Tailwind CSS CDN with forms plugin & Alpine.js --}}
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Google Fonts: Manrope --}}
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />

    {{-- Material Symbols Outlined --}}
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />

    {{-- Tailwind Config --}}
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#2b96ee",
                        "background-light": "#f8fafc",
                        "background-dark": "#0f172a",
                    },
                    fontFamily: {
                        "display": ["Manrope", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.375rem",
                        "lg": "0.75rem",
                        "xl": "1rem",
                        "2xl": "1.5rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>

    <style type="text/tailwindcss">
        @layer base {
            body {
                @apply bg-background-light text-slate-900 font-display;
                min-height: 100vh;
            }
        }
        .font-variation-fill {
            font-variation-settings: 'FILL' 1;
        }
        .sidebar-scroll::-webkit-scrollbar {
            width: 4px;
        }
        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 10px;
        }
        .custom-shadow {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.04), 0 8px 10px -6px rgba(0, 0, 0, 0.04);
        }
    </style>
    <style>
        body {
            min-height: max(884px, 100dvh);
        }
    </style>

    @stack('styles')
</head>

<body class="overflow-hidden">

    <div x-data="{ sidebarOpen: false }" class="flex h-screen w-full overflow-hidden">

        {{-- Mobile Sidebar Overlay --}}
        <div x-show="sidebarOpen" x-transition.opacity
            class="fixed inset-0 z-40 bg-slate-900/50 backdrop-blur-sm lg:hidden" @click="sidebarOpen = false"></div>

        {{-- ========== SIDEBAR ========== --}}
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="w-72 flex-shrink-0 bg-white border-r border-slate-200 flex flex-col z-50 fixed inset-y-0 left-0 transition-transform duration-300 ease-in-out lg:static lg:translate-x-0">

            {{-- Logo --}}
            <div class="p-8 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div
                        class="flex size-11 shrink-0 items-center justify-center text-white bg-primary rounded-xl shadow-lg shadow-primary/20">
                        <span class="material-symbols-outlined text-3xl">language</span>
                    </div>
                    <span class="text-xl font-extrabold tracking-tight text-slate-900 uppercase">United<span
                            class="text-primary">Cargo</span></span>
                </div>
                {{-- Close button (mobile only) --}}
                <button @click="sidebarOpen = false"
                    class="text-slate-400 hover:text-rose-500 transition-colors lg:hidden">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 px-6 space-y-2 mt-4 sidebar-scroll overflow-y-auto">
                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-4 px-4">Core Menu</div>

                @php
                    $currentRoute = request()->route() ? request()->route()->getName() : '';
                @endphp

                <a class="flex items-center gap-3 px-4 py-3.5 rounded-xl {{ $currentRoute === 'dashboard' || $currentRoute === '' ? 'bg-primary text-white shadow-md shadow-primary/20' : 'text-slate-500 hover:bg-slate-50 hover:text-primary' }} transition-all group"
                    href="{{ route('dashboard') }}">
                    <span class="material-symbols-outlined font-variation-fill">grid_view</span>
                    <span class="font-bold text-sm">Home</span>
                </a>

                <a class="flex items-center gap-3 px-4 py-3.5 rounded-xl {{ request()->routeIs('sales.*') ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-slate-500 hover:bg-slate-50 hover:text-primary transition-all' }}"
                    href="{{ route('sales.index') }}">
                    <span class="material-symbols-outlined font-variation-fill">flight_takeoff</span>
                    <span class="font-bold text-sm">Ventas AWB</span>
                </a>


                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-6 mb-2 px-4">Catálogos
                    CASS</div>

                <a class="flex items-center gap-3 px-4 py-3.5 rounded-xl {{ request()->routeIs('agency_transactions.*') ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-slate-500 hover:bg-slate-50 hover:text-primary transition-all' }}"
                    href="{{ route('agency_transactions.index') }}">
                    <span class="material-symbols-outlined">receipt_long</span>
                    <span class="font-bold text-sm">Transacciones (DB)</span>
                </a>

                <a class="flex items-center gap-3 px-4 py-3.5 rounded-xl {{ request()->routeIs('agencies.*') ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-slate-500 hover:bg-slate-50 hover:text-primary transition-all' }}"
                    href="{{ route('agencies.index') }}">
                    <span class="material-symbols-outlined">corporate_fare</span>
                    <span class="font-bold text-sm">Agencias</span>
                </a>

                <a class="flex items-center gap-3 px-4 py-3.5 rounded-xl {{ request()->routeIs('clients.*') ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-slate-500 hover:bg-slate-50 hover:text-primary transition-all' }}"
                    href="{{ route('clients.index') }}">
                    <span class="material-symbols-outlined">group</span>
                    <span class="font-bold text-sm">Clientes</span>
                </a>

                <a class="flex items-center gap-3 px-4 py-3.5 rounded-xl {{ request()->routeIs('pending_invoices.*') ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-slate-500 hover:bg-slate-50 hover:text-primary transition-all' }}"
                    href="{{ route('pending_invoices.index') }}">
                    <span class="material-symbols-outlined">receipt_long</span>
                    <span class="font-bold text-sm">Facturas</span>
                </a>

                <a class="flex items-center gap-3 px-4 py-3.5 rounded-xl {{ request()->routeIs('reports.*') ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-slate-500 hover:bg-slate-50 hover:text-primary transition-all' }}"
                    href="{{ route('reports.index') }}">
                    <span class="material-symbols-outlined">analytics</span>
                    <span class="font-bold text-sm">Reportes CASS</span>
                </a>


            </nav>

            {{-- User Profile --}}
            <div class="p-6 border-t border-slate-100">
                <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-2xl border border-slate-100">
                    <div
                        class="size-10 rounded-xl bg-primary/10 flex items-center justify-center overflow-hidden shrink-0">
                        <span class="material-symbols-outlined text-primary font-variation-fill">person</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-slate-900 truncate">Admin User</p>
                        <p class="text-[10px] text-primary font-black uppercase tracking-widest">Admin</p>
                    </div>
                    <button class="text-slate-400 hover:text-red-500 transition-colors">
                        <span class="material-symbols-outlined text-xl">logout</span>
                    </button>
                </div>
            </div>
        </aside>

        {{-- ========== MAIN CONTENT ========== --}}
        <main class="flex-1 flex flex-col min-w-0 overflow-y-auto bg-slate-50">

            {{-- Header --}}
            <header
                class="h-20 flex items-center justify-between px-6 lg:justify-end lg:px-10 bg-white/80 backdrop-blur-xl border-b border-slate-200 sticky top-0 z-20 shrink-0">

                {{-- Mobile Hamburger --}}
                <button @click="sidebarOpen = true"
                    class="lg:hidden flex size-12 items-center justify-center rounded-2xl bg-white border border-slate-200 hover:border-primary hover:text-primary transition-all custom-shadow">
                    <span class="material-symbols-outlined text-slate-500 hover:text-primary">menu</span>
                </button>

                {{-- Redundant title and search bar removed as requested --}}
                {{-- Header actions --}}
                <div class="flex items-center gap-4">
                    <button
                        class="relative flex size-12 items-center justify-center rounded-2xl bg-white border border-slate-200 hover:border-primary hover:text-primary transition-all custom-shadow">
                        <span class="material-symbols-outlined text-slate-500 hover:text-primary">notifications</span>
                        <span
                            class="absolute top-3 right-3 size-2.5 bg-red-500 border-2 border-white rounded-full"></span>
                    </button>
                    <button
                        class="flex size-12 items-center justify-center rounded-2xl bg-white border border-slate-200 hover:border-primary hover:text-primary transition-all custom-shadow">
                        <span class="material-symbols-outlined text-slate-500 hover:text-primary">calendar_today</span>
                    </button>
                    <div class="h-8 w-px bg-slate-200 mx-2"></div>

                </div>
            </header>

            {{-- Page Content --}}
            @yield('content')

            {{-- Footer --}}
            <footer
                class="mt-auto px-10 py-8 text-center text-slate-400 text-xs font-semibold tracking-wide border-t border-slate-100 bg-white">
                © {{ date('Y') }} United Flow Dashboard. All rights reserved.
            </footer>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: '¡Operación Exitosa!',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#2b96ee',
                    confirmButtonText: 'Continuar'
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: '¡Oops!',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#2b96ee',
                    confirmButtonText: 'Entendido'
                });
            @endif
        });
    </script>

    @stack('scripts')
</body>

</html>