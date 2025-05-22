<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Municipi;
use App\Models\User;


class MunicipiController extends Controller
{
    public function index(Request $request)
    {
        $query = Municipi::query();

        // Obtener per_page con un valor por defecto
        $perPage = $request->input('per_page', 4);

        // Filtro de búsqueda
        if ($request->filled('search') && strlen($request->search) >= 2) {
            $query->where('nombre', 'like', '%' . $request->search . '%');
        }

        // Paginar usando el valor de per_page
        $municipis = $query->paginate($perPage)->withQueryString();

        return view('municipis.index', compact('municipis'));
    }

    public function create()
    {
        return view('municipis.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'latitud' => 'nullable|numeric',
            'longitud' => 'nullable|numeric',
            'zoom' => 'nullable|numeric'
        ]);

        Municipi::create($request->all());

        return redirect()->route('municipis.index')->with('success', 'Municipio creado correctamente.');
    }

    public function show(Municipi $municipi)
    {
        return view('municipis.show', compact('municipi'));
    }

    public function edit(Municipi $municipi)
    {
        return view('municipis.edit', compact('municipi'));
    }

    public function update(Request $request, Municipi $municipi)
    {
        $request->validate([
            'nombre' => 'required',
            'latitud' => 'nullable|numeric',
            'longitud' => 'nullable|numeric',
            'zoom' => 'nullable|numeric'
        ]);

        $municipi->update($request->all());

        return redirect()->route('municipis.index')->with('success', 'Municipio actualizado correctamente.');
    }

    public function destroy(Municipi $municipi)
    {
        $municipi->delete();

        return redirect()->route('municipis.index')->with('success', 'Municipio eliminado.');
    }
}