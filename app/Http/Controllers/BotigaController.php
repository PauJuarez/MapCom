<?php

namespace App\Http\Controllers;

use App\Models\Botiga;
use App\Models\User;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class BotigaController extends Controller
{
    // Muestra una lista de productos, por ejemplo
    public function index()
    {
        $botigues = Botiga::latest()->paginate(3);
        return view('botiga.index', compact('botigues')); // Asegúrate de que esta vista exista
    }
    
    public function mapa(): View
    {
        $botigues = Botiga::all();
        
        return view('botiga.mapa', compact('botigues'));
    }
    // Muestra un producto específico
    public function show($id):view
    {
        $botiga = Botiga::findOrFail($id); // Busca la botiga por su ID o lanza una excepción 404 si no existe
        return view('botiga.show', compact('botiga'));
    }

    // Muestra un formulario para crear un nuevo producto
    public function create()
    {
        if (Gate::allows('access-admin') || Gate::allows('access-editor')) {
            return view('botiga.crearb');
        }
        abort(403, 'Unauthorized!');
    }


    // Muestra un formulario para crear un nuevo producto
    public function users()
    {
        $users = User::latest()->paginate(3);
        return view('botiga.users', compact('users')); // Asegúrate de que esta vista exista
    }



    public function editone($id)
    {
        if (Gate::allows('access-admin') || Gate::allows('access-editor')) {
            $botiga = Botiga::findOrFail($id); // Encuentra la botiga por su ID
            return view('botiga.editone', compact('botiga')); // Pasamos la tienda a la vista
        }
        abort(403, 'Unauthorized!');
    }

        public function update(Request $request, $id)
        {
            $validated = $request->validate([
                'nom' => 'required|string|max:255',
                'descripcio' => 'nullable|string',
                'adreca' => 'nullable|string|max:255',
                'latitud' => 'nullable|numeric',
                'longitud' => 'nullable|numeric',
                'horariObertura' => 'nullable|date',
                'horariTencament' => 'nullable|date',
                'telefono' => 'nullable|integer',
                'coreoelectronic' => 'nullable|email|max:255',
                'web' => 'nullable|url|max:255',
                'imatge' => 'nullable|string|max:255',
            ]);

        
            $botiga = Botiga::findOrFail($id); // Encuentra la botiga a actualizar
            $botiga->update($validated); // Actualiza los datos
        
            return redirect()->route('botigues.index')->with('success', 'Botiga actualizada correctamente.');
        }
        

        public function store(Request $request)
        {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'descripcio' => 'nullable|string',
            'adreca' => 'nullable|string|max:255',
            'latitud' => 'nullable|numeric',
            'longitud' => 'nullable|numeric',
            'horariObertura' => 'nullable|date',
            'horariTencament' => 'nullable|date',
            'telefono' => 'nullable|integer',
            'coreoelectronic' => 'nullable|email|max:255',
            'web' => 'nullable|url|max:255',
            'imatge' => 'nullable|string|max:255',
        ]);

        
            Botiga::create($validated);
        
            return redirect()->route('botigues.index')->with('success', 'Botiga creada correctament.');
        }
            // Método para eliminar una botiga
    public function destroy($id)
    {
        if (Gate::allows('access-admin') || Gate::allows('access-editor')) {
            $botiga = Botiga::findOrFail($id);
            $botiga->delete();
            return redirect()->route('botigues.index')->with('success', 'Botiga eliminada correctamente.');
        }
        abort(403, 'Unauthorized!');
    }
    
    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:user,editor,admin',
        ]);

        $user = User::findOrFail($id);
        $user->role = $request->input('role');
        $user->save();

        return redirect()->route('botigues.users')->with('success', 'Rol actualizado correctamente.');
    }

    public function afegirFavorit(Botiga $botiga)
    {
        auth()->user()->favoritos()->syncWithoutDetaching([$botiga->id]);
        return back()->with('success', 'Afegida als favorits!');
    }

    public function treureFavorit(Botiga $botiga)
    {
        auth()->user()->favoritos()->detach($botiga->id);
        return back()->with('success', 'Eliminada dels favorits!');
    }


}
