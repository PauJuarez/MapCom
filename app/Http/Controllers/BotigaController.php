<?php

namespace App\Http\Controllers;

use App\Models\Botiga;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class BotigaController extends Controller
{
    // Muestra una lista de productos, por ejemplo
    public function index()
    {
        $botigues = Botiga::latest()->paginate(5);
        return view('botiga.index', compact('botigues')); // Asegúrate de que esta vista exista
    }
    
    public function mapa(): View
    {
        $botigues = Botiga::all();
        
        return view('botiga.mapa', compact('botigues'));
    }
    // Muestra un producto específico
    public function show($id)
    {
        return view('botiga.show', ['id' => $id]);
    }

    // Muestra un formulario para crear un nuevo producto
    public function create()
    {
        if (Gate::allows('access-admin')) {
            return view('botiga.crearb');
        }
        abort(403, 'Unauthorized!');
    }
        // Muestra un formulario para crear un nuevo producto
        public function users()
        {
            return view('botiga.users');
        }
            // Muestra un formulario para crear un nuevo producto
    public function eliminar()
    {
        $botigues = Botiga::latest()->paginate(5);
        return view('botiga.eliminar', compact('botigues'));
    }
        // Muestra un formulario para crear un nuevo producto
        public function edit()
        {
            $botigues = Botiga::latest()->paginate(5);

            return view('botiga.edit', compact('botigues'));
        }
        public function editone($id)
        {
            $botiga = Botiga::findOrFail($id); // Encuentra la botiga por su ID
            return view('botiga.editone', compact('botiga')); // Pasamos la tienda a la vista
        }

        public function update(Request $request, $id)
        {
            $validated = $request->validate([
                'nom' => 'required|string|max:255',
                'descripcio' => 'nullable|string',
                'adreca' => 'nullable|string',
                'latitud' => 'nullable|numeric',
                'longitud' => 'nullable|numeric',
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
                'adreca' => 'nullable|string',
                'latitud' => 'nullable|numeric',
                'longitud' => 'nullable|numeric',
            ]);
        
            Botiga::create($validated);
        
            return redirect()->route('botigues.index')->with('success', 'Botiga creada correctament.');
        }
            // Método para eliminar una botiga
    public function destroy($id)
    {
        // Buscar la botiga por su ID
        $botiga = Botiga::findOrFail($id);

        // Eliminar la botiga
        $botiga->delete();

        // Redirigir a la página anterior con un mensaje de éxito
        return redirect()->route('botigues.index')->with('success', 'Botiga eliminada correctamente.');
    }

}
