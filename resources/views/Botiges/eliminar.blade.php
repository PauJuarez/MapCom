<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-info-variant-4 leading-tight">
            {{ __('Eliminar Botigues') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if($botigues->isEmpty())
                    <p class="text-gray-600">No hi ha botigues registrades.</p>
                @else
                    <ul class="divide-y divide-gray-200">
                        @foreach($botigues as $botiga)
                            <li class="py-4 flex justify-between items-center">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $botiga->nom }}</h3>
                                    <p class="text-gray-700">{{ $botiga->adreca }}</p>
                                    @if($botiga->descripcio)
                                        <p class="text-sm text-gray-500 mt-1">{{ $botiga->descripcio }}</p>
                                    @endif
                                </div>

                                <!-- Botón de eliminar -->
                                <form action="{{ route('botigues.index', $botiga->id) }}" method="POST" class="ml-4">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700">
                                        Eliminar
                                    </button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                @endif

                <!-- Aquí se agregan los enlaces de paginación -->
                <div class="mt-4">
                    {{ $botigues->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
