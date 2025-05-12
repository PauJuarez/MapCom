<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-info-variant-4 dark:text-gray-200 leading-tight">
            {{ __('Usuaris') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-xl p-6">
                @if($users->isEmpty())
                    <p class="text-gray-600 dark:text-gray-300">No hi ha usuaris registrats.</p>
                @else
                    <ul class="divide-y divide-gray-200 dark:divide-gray-700 space-y-6 relative">
                        @foreach($users as $user)
                            <li class="relative py-6 px-4 bg-[#e9f2fc] dark:bg-gray-700 hover:bg-blue-100 dark:hover:bg-gray-600 rounded-xl shadow-md transition-all duration-300 ease-in-out">
                                <div>
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $user->name }}</h3>
                                    <p class="text-sm text-gray-700 dark:text-gray-300">{{ $user->email }}</p>

                                    <!-- Formulario para actualizar el rol -->
                                    <form action="{{ route('users.updateRole', $user->id) }}" method="POST" class="mt-2 flex items-center space-x-2">
                                        @csrf
                                        @method('PUT')
                                        <label for="role_{{ $user->id }}" class="text-sm text-gray-600 dark:text-gray-400">Rol:</label>
                                        <select name="role" id="role_{{ $user->id }}" class="form-select rounded">
                                            <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                                            <option value="editor" {{ $user->role === 'editor' ? 'selected' : '' }}>Editor</option>
                                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                        </select>
                                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded">Guardar</button>
                                    </form>
                                </div>
                            </li>
                        @endforeach

                    </ul>
                @endif

                <!-- Paginación -->
                <div class="mt-6">
                    <div class="flex justify-end">
                        {{ $users->links('pagination::tailwind') }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
