<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-8 text-center">
            <h2 class="text-2xl font-black text-slate-900">Iniciar Sesión</h2>
            <p class="text-sm text-slate-500 mt-1 font-medium">Ingresa tus credenciales para continuar</p>
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Correo Electrónico')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-6">
            <x-input-label for="password" :value="__('Contraseña')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between mt-6">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-primary shadow-sm focus:ring-primary focus:ring-opacity-50 transition-colors cursor-pointer" name="remember">
                <span class="ms-2 text-sm font-bold text-slate-500 group-hover:text-slate-700 transition-colors">{{ __('Recordarme') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-bold text-primary hover:text-blue-600 transition-colors" href="{{ route('password.request') }}">
                    {{ __('¿Olvidaste tu contraseña?') }}
                </a>
            @endif
        </div>

        <div class="mt-8">

            <x-primary-button class="w-full">
                {{ __('Ingresar al Sistema') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
