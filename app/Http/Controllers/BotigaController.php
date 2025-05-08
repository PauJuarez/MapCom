<?php

namespace App\Http\Controllers;

use App\Models\Botiga;
use Illuminate\View\View;
use Illuminate\Http\Request;

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
        return view('botiga.crearb');
    }
        // Muestra un formulario para crear un nuevo producto
        public function users()
        {
            return view('botiga.users');
        }
            // Muestra un formulario para crear un nuevo producto
    public function eliminar()
    {
        return view('botiga.eliminar');
    }
        // Muestra un formulario para crear un nuevo producto
        public function edit()
        {
            return view('botiga.edit');
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
        

}
