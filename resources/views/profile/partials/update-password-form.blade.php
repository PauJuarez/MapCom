<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Actualitza la contrasenya') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Assegura\'t que el teu compte utilitza una contrasenya llarga i aleatòria per mantenir la seguretat.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Contrasenya actual')" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="bg-info-variant-1 mt-1 block w-full" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('Nova contrasenya')" />
            <x-text-input id="update_password_password" name="password" type="password" class="bg-info-variant-1 mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirma la contrasenya')" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="bg-info-variant-1 mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Desa') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
