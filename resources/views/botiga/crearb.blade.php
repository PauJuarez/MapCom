<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Crear Botiga') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form method="POST" action="{{ route('botigues.store') }}">
                    @csrf

                    <!-- Nom -->
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300">Nom</label>
                        <input type="text" name="nom" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 dark:bg-gray-700 dark:text-white" required>
                    </div>

                    <!-- Descripció -->
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300">Descripció</label>
                        <textarea name="descripcio" rows="3" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 dark:bg-gray-700 dark:text-white"></textarea>
                    </div>

                    <!-- Adreça -->
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300">Adreça</label>
                        <input type="text" name="adreca" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 dark:bg-gray-700 dark:text-white">
                    </div>

                    <!-- Latitud -->
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300">Latitud</label>
                        <input type="text" name="latitud" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 dark:bg-gray-700 dark:text-white">
                    </div>

                    <!-- Longitud -->
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300">Longitud</label>
                        <input type="text" name="longitud" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 dark:bg-gray-700 dark:text-white">
                    </div>

                    <!-- Submit -->
                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                            Guardar Botiga
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
