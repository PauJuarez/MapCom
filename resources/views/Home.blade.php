<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-info-variant-4 leading-tight">
            {{ __('Botigues Preferides') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl p-6 bg-info-variant-1-5">

                <!-- Filtro dinámico por características -->
                <form id="filterForm" method="GET" action="{{ route('botigues.mapa') }}" class="mb-6">
                    <div class="flex flex-col">
                        <div class="flex flex-wrap gap-2" id="caracteristiquesContainer">
                            @foreach($caracteristiques as $carac)
                                @php
                                    $isSelected = is_array(request('caracteristiques')) && in_array($carac->id, request('caracteristiques'));
                                @endphp
                                <button type="button"
                                        data-id="{{ $carac->id }}"
                                        class="caracteristica-btn px-4 py-1 rounded-full text-sm font-medium transition-all duration-200
                                        {{ $isSelected ? 'bg-info-variant-5 text-white' : 'bg-info-variant-2 text-gray-800 hover:bg-info-variant-2' }}">
                                    {{ $carac->nom }}
                                </button>
                            @endforeach
                        </div>
                        <!-- Input oculto con los IDs seleccionados -->
                        <input type="hidden" name="caracteristiques[]" id="selectedCaracteristiques"
                               value="{{ request('caracteristiques') ? implode(',', request('caracteristiques')) : '' }}">
                    </div>
                </form>

                @if($botigues->isEmpty())
                    <p class="text-gray-600">No tens botigues favorites.</p>
                @else
                    <ul class="divide-y divide-gray-200 space-y-6 relative">
                        @foreach($botigues as $botiga)
                            <li class="relative py-6 px-4 bg-info-variant-1 hover:bg-blue-100 rounded-xl shadow-md transition-all duration-300 ease-in-out">
                                
                                <!-- Imagen solo en móvil -->
                                <div class="mb-4 md:hidden">
                                    <img src="{{ $botiga->imatge ?? '/img/Logo.png' }}"
                                         alt="Imatge de la botiga"
                                         class="rounded w-full max-w-xs mx-auto object-cover h-32">
                                </div>

                                <div class="flex items-center justify-left">
                                    <!-- Imagen en pantallas medianas y grandes -->
                                    <div class="d-none d-md-block flex-shrink-0 pr-5">
                                        <img src="{{ $botiga->imatge ?? '/img/Logo.png' }}"
                                             alt="Imatge de la botiga"
                                             class="rounded-md w-32 h-32 object-cover">
                                    </div>

                                    <!-- Botones arriba a la derecha -->
                                    <div class="absolute top-2 right-2 flex space-x-2">
                                        @if(Gate::allows('access-admin') || Gate::allows('edit-botiga', $botiga))
                                            <a href="{{ route('editone', ['id' => $botiga->id]) }}"
                                               class="bg-blue-600 hover:bg-blue-700 text-white rounded-full p-2 shadow"
                                               title="Editar">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"/>
                                                    <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h6a1 1 0 100-2H4a3 3 0 00-3 3v12a3 3 0 003 3h12a3 3 0 003-3v-6a1 1 0 10-2 0v6a1 1 0 01-1 1H4a1 1 0 01-1-1V4z" clip-rule="evenodd"/>
                                                </svg>
                                            </a>
                                        @endif

                                        @php
                                            $user = auth()->user();
                                            $esFavorita = $user && $user->favoritos && $user->favoritos->contains($botiga->id);
                                        @endphp

                                        <form action="{{ $esFavorita ? route('botigues.treureFavorit', $botiga->id) : route('botigues.afegirFavorit', $botiga->id) }}"
                                              method="POST">
                                            @csrf
                                            @if($esFavorita) @method('DELETE') @endif
                                            <button type="submit"
                                                    class="bg-yellow-400 hover:bg-yellow-500 text-white rounded-full p-2 shadow"
                                                    title="{{ $esFavorita ? 'Treure de favorits' : 'Afegir a favorits' }}">
                                                <svg class="w-5 h-5" fill="{{ $esFavorita ? 'currentColor' : 'none' }}"
                                                     stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.518 4.674a1 1 0 00.95.69h4.909c.969 0 1.371 1.24.588 1.81l-3.977 2.89a1 1 0 00-.364 1.118l1.518 4.674c.3.921-.755 1.688-1.54 1.118l-3.977-2.89a1 1 0 00-1.175 0l-3.977 2.89c-.784.57-1.838-.197-1.54-1.118l1.518-4.674a1 1 0 00-.364-1.118L2.98 10.101c-.783-.57-.38-1.81.588-1.81h4.91a1 1 0 00.949-.69l1.518-4.674z"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Información de la tienda -->
                                    <div>
                                        <h3 class="text-xl font-semibold text-gray-900">{{ $botiga->nom }}</h3>
                                        <p class="text-sm text-gray-700">{{ $botiga->adreca }}</p>

                                        @if($botiga->descripcio)
                                            <p class="text-sm text-gray-500 mt-2">
                                                {{ Str::limit($botiga->descripcio, 250, '...') }}
                                            </p>
                                            <a href="{{ route('botiga.show', $botiga->id) }}">
                                                <button class="mt-2 bg-blue-500 text-white px-4 py-2 rounded">
                                                    Veure Detalls
                                                </button>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif

                <!-- Paginación -->
                <div class="mt-6 flex justify-between items-center">
                    <div>
                        <form action="{{ route('Home') }}" method="GET" class="flex items-center">
                            <label for="per_page" class="mr-2">Mostrar:</label>
                            <select name="per_page" id="per_page" class="border rounded py-1 px-4">
                                @foreach([3, 5, 10, 25, 50] as $option)
                                    <option value="{{ $option }}" {{ request('per_page', 3) == $option ? 'selected' : '' }}>
                                        {{ $option }}
                                    </option>
                                @endforeach
                            </select>

                            <!-- Preservar filtros -->
                            @if(request()->has('caracteristiques'))
                                @foreach(request('caracteristiques') as $id)
                                    <input type="hidden" name="caracteristiques[]" value="{{ $id }}">
                                @endforeach
                            @endif
                        </form>
                    </div>
                    <div>
                        {{ $botigues->appends(request()->all())->links('pagination::tailwind') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- JavaScript para paginación -->
<script>
    document.getElementById('per_page').addEventListener('change', function () {
        this.form.submit();
    });
</script>

<!-- JavaScript para filtro dinámico -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const buttons = document.querySelectorAll('.caracteristica-btn');
        const hiddenInput = document.getElementById('selectedCaracteristiques');

        buttons.forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                let selected = [...hiddenInput.value.split(',')].filter(Boolean);
                const index = selected.indexOf(id);

                if (index === -1) {
                    selected.push(id);
                    this.classList.remove('bg-info-variant-2', 'text-gray-800', 'hover:bg-info-variant-2');
                    this.classList.add('bg-info-variant-5', 'text-white');
                } else {
                    selected.splice(index, 1);
                    this.classList.remove('bg-info-variant-5', 'text-white');
                    this.classList.add('bg-info-variant-2', 'text-gray-800', 'hover:bg-info-variant-2');
                }

                hiddenInput.value = selected.join(',');

                const params = new URLSearchParams();
                selected.forEach(id => params.append('caracteristiques[]', id));
                const perPage = new URLSearchParams(window.location.search).get('per_page');
                if (perPage) params.set('per_page', perPage);

                window.location.href = "{{ route('Home') }}?" + params.toString();
            });
        });
    });
</script>
