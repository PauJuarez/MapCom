<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-info-variant-4 dark:text-gray-200 leading-tight">
            {{ __('Editar Botiga') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('botigues.update', ['id' => $botiga->id]) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="nom" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Nom') }}</label>
                        <input type="text" name="nom" id="nom" value="{{ old('nom', $botiga->nom) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                    </div>

                    <div class="mb-4">
                        <label for="adreca" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Adreça') }}</label>
                        <input type="text" name="adreca" id="adreca" value="{{ old('adreca', $botiga->adreca) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>

                    <div class="mb-4">
                        <label for="descripcio" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Descripció') }}</label>
                        <textarea name="descripcio" id="descripcio" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('descripcio', $botiga->descripcio) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label for="latitud" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Latitud') }}</label>
                        <input type="text" name="latitud" id="latitud" value="{{ old('latitud', $botiga->latitud) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>

                    <div class="mb-4">
                        <label for="longitud" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Longitud') }}</label>
                        <input type="text" name="longitud" id="longitud" value="{{ old('longitud', $botiga->longitud) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-800 dark:text-gray-100 dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>

                    <div class="flex items-center justify-between mt-6">
                        <!-- Botón de Volver -->
                        <a href="{{ route('botigues.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400 transition-colors duration-300">
                            {{ __('Volver') }}
                        </a>
                    
                        <!-- Botón de Guardar Cambios -->
                        <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 transition-colors duration-300">
                            {{ __('Guardar Cambios') }}
                        </button>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
