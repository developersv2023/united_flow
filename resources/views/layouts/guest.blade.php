<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'United Flow') }}</title>

        {{-- Tailwind CSS CDN with forms plugin & Alpine.js --}}
        <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        {{-- Google Fonts: Manrope --}}
        <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />

        {{-- Material Symbols Outlined --}}
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />

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
            .custom-shadow {
                box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.04), 0 8px 10px -6px rgba(0, 0, 0, 0.04);
            }
        </style>
    </head>
    <body class="font-display text-slate-900 antialiased overflow-hidden">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-slate-50 relative">

            <!-- Decorative background elements -->
            <div class="absolute top-0 inset-x-0 h-64 bg-gradient-to-b from-primary/10 to-transparent z-0"></div>

            <div class="z-10 mb-8">
                <a href="/" class="flex flex-col items-center gap-4 group">
                    <div class="flex size-16 items-center justify-center text-white bg-primary rounded-2xl shadow-xl shadow-primary/30 group-hover:scale-105 transition-transform duration-300">
                        <span class="material-symbols-outlined text-4xl">language</span>
                    </div>
                    <span class="text-3xl font-extrabold tracking-tight text-slate-900 uppercase">United<span class="text-primary">Cargo</span></span>
                </a>
            </div>

            <div class="w-full sm:max-w-md px-10 py-12 bg-white custom-shadow border border-slate-100 overflow-hidden rounded-[2.5rem] z-10">
                {{ $slot }}
            </div>
            
            <div class="mt-12 text-xs font-bold text-slate-400 tracking-widest uppercase z-10">
                © {{ date('Y') }} United Flow
            </div>
        </div>
    </body>
</html>
