<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-black text-slate-900">Recuperar Contraseña</h2>
        <p class="text-sm text-slate-500 mt-2 font-medium">¿Olvidaste tu contraseña? No hay problema. Simplemente dinos tu dirección de correo electrónico y te enviaremos un enlace para restablecerla.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Correo Electrónico')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-8">
            <x-primary-button class="w-full">
                {{ __('Enviar Enlace de Recuperación') }}
            </x-primary-button>
        </div>

        <div class="mt-6 text-center">
            <a class="text-sm font-bold text-slate-500 hover:text-primary transition-colors" href="{{ route('login') }}">
                {{ __('Volver a Iniciar Sesión') }}
            </a>
        </div>
    </form>
</x-guest-layout>
