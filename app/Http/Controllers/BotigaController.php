<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BotigaController extends Controller
{
    // Muestra una lista de productos, por ejemplo
    public function index()
    {
        return view('botiga.index'); // Asegúrate de que esta vista exista
    }
    public function mapa()
    {
        return view('botiga.mapa'); // Asegúrate de que esta vista exista
    }
    // Muestra un producto específico
    public function show($id)
    {
        return view('botiga.show', ['id' => $id]);
    }

    // Muestra un formulario para crear un nuevo producto
    public function create()
    {
        return view('botiga.create');
    }

    // Guarda el nuevo producto
    public function store(Request $request)
    {
        // Aquí podrías guardar datos usando Eloquent, por ejemplo
        return redirect()->route('botiga.index');
    }
}
