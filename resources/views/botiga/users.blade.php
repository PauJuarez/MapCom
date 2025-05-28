<x-app-layout>
    <!-- Encapçalat de la pàgina -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-info-variant-4 leading-tight">
            {{ __('Permisos dels Usuaris') }}
        </h2>
    </x-slot>

    <!-- Contingut principal -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-secondary-variant-2 overflow-hidden shadow-xl sm:rounded-xl p-6">

                <!-- Comprovem si no hi ha usuaris -->
                @if($users->isEmpty())
                    <p class="text-gray-600">No hi ha usuaris registrats.</p>
                @else
                    <!-- Llista d'usuaris -->
                    <ul class="divide-y divide-gray-200 space-y-6 relative">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Iteració sobre cada usuari -->
                            @foreach($users as $user)
                                <li class="bg-secondary-variant-1 relative py-6 px-4 bg-[#e9f2fc] hover:bg-blue-100 rounded-xl shadow-md transition-all duration-300 ease-in-out">
                                    <div>
                                        <!-- Mostra el nom i correu de l'usuari -->
                                        <h3 class="text-xl font-semibold text-gray-900">{{ $user->name }}</h3>
                                        <p class="text-sm text-gray-700">{{ $user->email }}</p>

                                        <!-- Formulari per actualitzar el rol de l'usuari -->
                                        <form action="{{ route('users.updateRole', $user->id) }}" method="POST" class="mt-2 flex items-center space-x-2">
                                            @csrf
                                            @method('PUT')
                                            <label for="role_{{ $user->id }}" class="text-sm text-gray-600">Rol:</label>
                                            <!-- Select amb els rols disponibles -->
                                            <select name="role" id="role_{{ $user->id }}" class="form-select rounded">
                                                <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                                                <option value="editor" {{ $user->role === 'editor' ? 'selected' : '' }}>Editor</option>
                                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                            </select>
                                            <!-- Botó per desar els canvis -->
                                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded">Guardar</button>
                                        </form>
                                    </div>
                                </li>
                            @endforeach
                        </div>
                    </ul>
                @endif

                <!-- Paginació -->
                <div class="mt-6 flex justify-between items-center">
                    <!-- Selector de quantitat d'usuaris per pàgina -->
                    <div>
                        <form action="{{ route('botigues.users') }}" method="GET" class="flex items-center">
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

                    <!-- Enllaços de navegació de la paginació -->
                    <div>
                        {{ $users->links('pagination::tailwind') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- Script per enviar automàticament el formulari quan es canvia el nombre d'usuaris per pàgina -->
<script>
    document.getElementById('per_page').addEventListener('change', function() {
        this.form.submit();
    });
</script>