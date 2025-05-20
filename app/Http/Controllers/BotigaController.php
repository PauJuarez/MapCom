<?php

namespace App\Http\Controllers;

use App\Models\Botiga;
use App\Models\User;
use App\Models\Ressenya;
use App\Models\Caracteristica;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class BotigaController extends Controller
{
public function home(Request $request)
{
    // Verificar si hay un usuario autenticado
    $user = auth()->user();

    if (!$user) {
        return view('home', [
            'botigues' => collect(),
            'caracteristiques' => Caracteristica::all(),
        ]);
    }

    // Obtener las tiendas favoritas del usuario como una consulta (query builder)
    $query = $user->favoritos()->with('caracteristiques');

    // Filtrar por características si se ha enviado el formulario
    if ($filtroIds = $request->input('caracteristiques')) {
        $filtroIds = array_filter($filtroIds); // Limpiar valores vacíos

        if (!empty($filtroIds)) {
            $query->whereHas('caracteristiques', function ($q) use ($filtroIds) {
                $q->whereIn('caracteristiques.id', $filtroIds);
            }, '=', count($filtroIds));
        }
    }

    // Paginación
    $number = $request->input('per_page', 3); // Número de resultados por página
    $botigues = $query->latest()->paginate($number)->appends($request->all());

    // Cargar todas las características para mostrar el filtro
    $caracteristiques = Caracteristica::all();

    return view('home', compact('botigues', 'caracteristiques'));
}
    // Muestra una lista de productos, por ejemplo
    public function index(Request $request)
    {
        $caracteristiques = Caracteristica::all();

        $query = Botiga::query();

        if ($filtroIds = $request->input('caracteristiques')) {
            $filtroIds = array_filter($filtroIds); // limpiar valores vacíos

            if (!empty($filtroIds)) {
                $query->whereHas('caracteristiques', function ($q) use ($filtroIds) {
                    $q->whereIn('caracteristiques.id', $filtroIds);
                }, '=', count($filtroIds));
            }
        }

        $number = $request->input('per_page', 3);
        $botigues = $query->latest()->paginate($number)->appends($request->all());

        return view('botiga.index', compact('botigues', 'caracteristiques'));
    }

    
    public function mapa(): View
    {
        $botigues = Botiga::all();
        
        return view('botiga.mapa', compact('botigues'));
    }

    public function show($id):view
    {
        $botiga = Botiga::findOrFail($id);
        
        // Calcular el promedio de las valoraciones y el total de reseñas
        $totalValoraciones = $botiga->ressenyes->sum('valoracio');  // Sumar todas las valoraciones
        $totalResenyas = $botiga->ressenyes->count();  // Contar las reseñas
        
        // Calcular el promedio de valoraciones (si hay reseñas)
        $promedioValoracion = $totalResenyas > 0 ? $totalValoraciones / $totalResenyas : 0;
        
        return view('botiga.show', compact('botiga', 'promedioValoracion', 'totalResenyas'));
    }

    // Muestra un formulario para crear un nuevo producto
    public function create()
    {
        if (Gate::allows('access-admin') || Gate::allows('access-editor')) {
        $caracteristiques = Caracteristica::all(); // Cargar características
        return view('botiga.crearb', compact('caracteristiques')); // Pasarlas a la vista
        }
        abort(403, 'Unauthorized!');
    }

    public function users(Request $request)
    {
        $number = $request->input('per_page', 4); // Default 3
        $users = User::paginate($number)->appends(['per_page' => $number]);

        return view('botiga.users', compact('users'));
    }


    public function editone($id)
    {
        $botiga = Botiga::findOrFail($id);
        if (Gate::allows('access-admin') || Gate::allows('edit-botiga', $botiga)) {
            $caracteristiques = Caracteristica::all(); // Cargar características
            return view('botiga.editone', compact('botiga', 'caracteristiques'));
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
        'horariObertura' => 'nullable|date_format:H:i',
        'horariTencament' => 'nullable|date_format:H:i',
        'telefono' => 'nullable|digits:9',
        'coreoelectronic' => 'nullable|email|max:255',
        'web' => 'nullable|url|max:255',
        'imatge' => 'nullable|string|max:255',
        'caracteristiques' => 'nullable|array', // validar que sea array
        'caracteristiques.*' => 'exists:caracteristiques,id', // validar ids existentes
    ]);

    $botiga = Botiga::findOrFail($id);
    $botiga->update($validated);

    // Guardar las características seleccionadas (si hay)
    if ($request->has('caracteristiques')) {
        $botiga->caracteristiques()->sync($request->input('caracteristiques'));
    } else {
        $botiga->caracteristiques()->detach();
    }

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
                'horariObertura' => 'nullable|date_format:H:i',
                'horariTencament' => 'nullable|date_format:H:i',
                'telefono' => 'nullable|digits:9',
                'coreoelectronic' => 'nullable|email|max:255',
                'web' => 'nullable|url|max:255',
                'imatge' => 'nullable|string|max:255',
                'caracteristiques' => 'nullable|array', // validar que sea array
                'caracteristiques.*' => 'exists:caracteristiques,id', // validar ids existentes

            ]);

            $validated['user_id'] = auth()->id();

            $botiga = Botiga::create($validated);

            // Guardar las características seleccionadas (si hay)
            if ($request->has('caracteristiques')) {
                $botiga->caracteristiques()->sync($request->input('caracteristiques'));
            }

            return redirect()->route('botigues.index')->with('success', 'Botiga creada correctament.');
        }


            // Método para eliminar una botiga
    public function destroy($id)
    {
        $botiga = Botiga::findOrFail($id);
        if (Gate::allows('access-admin') || Gate::allows('edit-botiga', $botiga)) {
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
    public function guardarRessenya(Request $request, $botiga_id)
    {
        $request->validate([
            'comentari' => 'required|string',
            'valoracio' => 'required|integer|min:1|max:5',
        ]);

        Ressenya::create([
            'botiga_id' => $botiga_id,
            'user_id' => auth()->id(),
            'usuari' => auth()->user()->name,
            'comentari' => $request->comentari,
            'valoracio' => $request->valoracio,
            'dataPublicacio' => now(),
        ]);

        return back()->with('success', 'Ressenya enviada correctament!');
    }


    
}
