<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-8 text-center">
            <h2 class="text-2xl font-black text-slate-900">Registro de Usuario</h2>
            <p class="text-sm text-slate-500 mt-1 font-medium">Crea una cuenta para acceder al sistema</p>
        </div>

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nombre Completo')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-6">
            <x-input-label for="email" :value="__('Correo Electrónico')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-6">
            <x-input-label for="password" :value="__('Contraseña')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-6">
            <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="mt-8">
            <x-primary-button class="w-full">
                {{ __('Crear Cuenta') }}
            </x-primary-button>
        </div>

        <div class="mt-6 text-center">
            <a class="text-sm font-bold text-slate-500 hover:text-primary transition-colors" href="{{ route('login') }}">
                {{ __('¿Ya tienes una cuenta? Iniciar Sesión') }}
            </a>
        </div>
    </form>
</x-guest-layout>
