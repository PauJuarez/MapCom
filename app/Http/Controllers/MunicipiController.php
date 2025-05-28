<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Municipi;
use App\Models\User;

/**
 * Controlador per gestionar les operacions relacionades amb els municipis.
 *
 * Aquest controlador permet mostrar una llista de municipis, crear-los, editar-los,
 * eliminar-los i gestionar filtres com ara la cerca per nom.
 */
class MunicipiController extends Controller
{
    /**
     * Mostra una llista paginada de municipis amb opció de filtrar per nom.
     *
     * @param Request $request Petició HTTP que pot contenir paràmetres de cerca i paginació.
     * @return \Illuminate\View\View Vista amb la llista de municipis.
     */
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

    /**
     * Mostra el formulari per crear un nou municipi.
     *
     * @return \Illuminate\View\View Vista amb el formulari de creació.
     */
    public function create()
    {
        return view('municipis.create');
    }

    /**
     * Emmagatzema un nou municipi a la base de dades.
     *
     * @param Request $request Dades enviades pel formulari.
     * @return \Illuminate\Http\RedirectResponse Redirecció amb missatge d’èxit.
     */
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

    /**
     * Mostra els detalls d'un municipi específic.
     *
     * @param Municipi $municipi Instància del model Municipi.
     * @return \Illuminate\View\View Vista amb els detalls del municipi.
     */
    public function show(Municipi $municipi)
    {
        return view('municipis.show', compact('municipi'));
    }

    /**
     * Mostra el formulari per editar un municipi existent.
     *
     * @param Municipi $municipi Instància del model Municipi.
     * @return \Illuminate\View\View Vista amb el formulari d’edició.
     */
    public function edit(Municipi $municipi)
    {
        return view('municipis.edit', compact('municipi'));
    }

    /**
     * Actualitza les dades d’un municipi a la base de dades.
     *
     * @param Request $request Dades enviades pel formulari.
     * @param Municipi $municipi Instància del model Municipi.
     * @return \Illuminate\Http\RedirectResponse Redirecció amb missatge d’èxit.
     */
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

    /**
     * Elimina un municipi de la base de dades.
     *
     * @param Municipi $municipi Instància del model Municipi.
     * @return \Illuminate\Http\RedirectResponse Redirecció amb missatge d’èxit.
     */
    public function destroy(Municipi $municipi)
    {
        $municipi->delete();

        return redirect()->route('municipis.index')->with('success', 'Municipio eliminado.');
    }
}