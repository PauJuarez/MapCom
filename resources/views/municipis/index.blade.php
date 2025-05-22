<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-info-variant-4 leading-tight">
            {{ __('Municipis') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl p-6 bg-secondary-variant-2">

                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Filtro de municipios -->
                <div class="flex justify-between items-center mb-6 flex-wrap gap-4">
                    <form id="filterForm" class="mb-6">
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                            placeholder="Buscador" 
                            class="bg-secondary-variant-1 border rounded px-3 py-2 w-full max-w-md">
                    </form>
                    <a href="{{ route('municipis.create') }}" class=" bg-secondary-variant-1 px-4 py-2 rounded hover:bg-blue-600 transition">Agregar Nuevo Municipio</a>
                </div>
                <div id="municipis-list">
                    @if($municipis->count())
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($municipis as $municipi)
                                <div class="relative py-2 px-4 bg-secondary-variant-1 hover:bg-blue-100 rounded-xl shadow-md transition-all duration-300 ease-in-out">
                                    <!-- Botones arriba a la derecha con menos margen superior -->
                                    <div class="absolute top-2 right-2 flex space-x-2 z-10">
                                        <!-- Botón Editar -->
                                        <a href="{{ route('municipis.edit', $municipi->id) }}"
                                            class="bg-blue-600 hover:bg-blue-700 text-white rounded-full p-2 shadow"
                                            title="Editar municipio">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"/>
                                                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h6a1 1 0 100-2H4a3 3 0 00-3 3v12a3 3 0 003 3h12a3 3 0 003-3V4a1 1 0 011 1v12a1 1 0 01-1 1H4a1 1 0 01-1-1V4z" clip-rule="evenodd"/>
                                            </svg>
                                        </a>

                                        <!-- Botón Eliminar -->
                                        <form action="{{ route('municipis.destroy', $municipi->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este municipio?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="bg-red-600 hover:bg-red-700 text-white rounded-full p-2 shadow"
                                                    title="Eliminar municipio">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M6 2a1 1 0 011-1h6a1 1 0 011 1v1h4a1 1 0 110 2h-1v11a2 2 0 01-2 2H5a2 2 0 01-2-2V5H2a1 1 0 110-2h4V2zm2 4a1 1 0 012 0v7a1 1 0 11-2 0V6zm4 0a1 1 0 012 0v7a1 1 0 11-2 0V6z" clip-rule="evenodd"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Contenido del municipio con menos margen superior -->
                                    <div class="mt-2">
                                        <h3 class="text-xl font-semibold text-gray-900">{{ $municipi->nombre }}</h3>
                                        <p>Latitud: {{ $municipi->latitud ?? 'N/A' }}</p>
                                        <p>Longitud: {{ $municipi->longitud ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Paginación -->
                        <div class="mt-6 flex justify-between items-center">
                            <div>
                                <form action="{{ route('municipis.index') }}" method="GET" class="flex items-center">
                                    <label for="per_page" class="mr-2">Mostrar:</label>
                                    <select name="per_page" id="per_page" class="border rounded py-1 px-4">
                                        <option value="4" {{ request('per_page', 4) == 4 ? 'selected' : '' }}>4</option>
                                        <option value="8" {{ request('per_page') == 8 ? 'selected' : '' }}>8</option>
                                        <option value="16" {{ request('per_page') == 16 ? 'selected' : '' }}>16</option>
                                        <option value="32" {{ request('per_page') == 32 ? 'selected' : '' }}>32</option>
                                        <option value="64" {{ request('per_page') == 64 ? 'selected' : '' }}>64</option>
                                    </select>
                                </form>
                            </div>
                            <div>
                                {{ $municipis->links('pagination::tailwind') }}
                            </div>
                        </div>

                    @else
                        <p class="text-gray-600">No se encontraron municipios.</p>
                    @endif
                </div>

            </div>
        </div>
    </div>

<script>
    // Búsqueda en tiempo real
    document.getElementById('search').addEventListener('input', function () {
        const query = this.value;
        const perPage = document.getElementById('per_page')?.value || "{{ request('per_page', 4) }}";

        const url = new URL("{{ route('municipis.index') }}", window.location.origin);

        if (query.length >= 2 || query.length === 0) {
            url.searchParams.set('search', query);
            url.searchParams.set('per_page', perPage); // Añadimos per_page a la URL

            fetch(url)
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const list = doc.getElementById('municipis-list');
                    document.getElementById('municipis-list').innerHTML = list.innerHTML;

                    // Actualizar URL sin recargar
                    window.history.replaceState(null, '', url);
                });
        }
    });

    // Cambiar cantidad de registros por página
    document.getElementById('per_page').addEventListener('change', function () {
        this.form.submit();
    });
</script>
</x-app-layout>