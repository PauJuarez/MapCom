<?php
namespace App\Http\Controllers;
use App\Models\Botiga;
use App\Models\User;
use App\Models\Ressenya;
use App\Models\Caracteristica;
use App\Models\Municipi;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\RedirectResponse;

/**
 * Controlador principal per a la gestió de botigues.
 *
 * Aquest controlador gestiona totes les operacions relacionades amb les botigues,
 * incloent visualització, creació, edició, eliminació i afegir a favorits.
 */
class BotigaController extends Controller
{
    /**
     * Mostra la pàgina principal de l'aplicació amb les botigues preferides pel usuari.
     *
     * @param Request $request Petició HTTP rebuda.
     * @return View Vista 'home' amb les botigues filtrades i característiques disponibles.
     */
    public function home(Request $request): View
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

    /**
     * Mostra una llista paginada de botigues amb possibilitat de filtrar per característiques.
     *
     * @param Request $request Petició HTTP rebuda amb els filtres.
     * @return View Vista amb la llista de botigues.
     */
    public function index(Request $request): View
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

    /**
     * Mostra un mapa interactiva amb la localització de totes les botigues.
     *
     * @param Request $request Petició HTTP que pot incloure filtres de característiques.
     * @return View Vista amb el mapa i dades de botigues i municipis.
     */
    public function mapa(Request $request): View
    {
        $caracteristiques = Caracteristica::all();
        // Crear consulta base
        $query = Botiga::query();
        // Aplicar filtro si hay características seleccionadas
        if ($filtroIds = $request->input('caracteristiques')) {
            $filtroIds = array_filter($filtroIds); // limpiar valores vacíos
            if (!empty($filtroIds)) {
                $query->whereHas('caracteristiques', function ($q) use ($filtroIds) {
                    $q->whereIn('caracteristiques.id', $filtroIds);
                }, '=', count($filtroIds));
            }
        }
        $botigues = $query->get();
        $municipis = Municipi::whereNotNull('latitud')
                            ->whereNotNull('longitud')
                            ->whereNotNull('zoom')
                            ->get();
        // Pasar las variables necesarias a la vista
        return view('botiga.mapa', compact('botigues', 'caracteristiques', 'municipis'));
    }

    /**
     * Mostra els detalls d'una botiga específica.
     *
     * @param int $id Identificador únic de la botiga.
     * @return View Vista amb els detalls de la botiga i resenyes associades.
     */
    public function show($id): View
    {
        $botiga = Botiga::findOrFail($id);
        // Calcular el promedio de las valoraciones y el total de reseñas
        $totalValoraciones = $botiga->ressenyes->sum('valoracio');  // Sumar todas las valoraciones
        $totalResenyas = $botiga->ressenyes->count();  // Contar las reseñas
        $ressenyesPaginades = $botiga->ressenyes()->paginate(4); 
        // Calcular el promedio de valoraciones (si hay reseñas)
        $promedioValoracion = $totalResenyas > 0 ? $totalValoraciones / $totalResenyas : 0;
        return view('botiga.show', compact('botiga', 'promedioValoracion', 'totalResenyas', 'ressenyesPaginades'));
    }

    /**
     * Mostra el formulari per crear una nova botiga.
     *
     * Només els usuaris amb permisos d'administrador o editor poden accedir.
     *
     * @return View Vista amb el formulari de creació de botiga.
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException Si no està autoritzat.
     */
    public function create(): View
    {
        if (Gate::allows('access-admin') || Gate::allows('access-editor')) {
        $caracteristiques = Caracteristica::all(); // Cargar características
        return view('botiga.crearb', compact('caracteristiques')); // Pasarlas a la vista
        }
        abort(403, 'Unauthorized!');
    }

    /**
     * Mostra una llista paginada d'usuaris del sistema.
     *
     * @param Request $request Petició HTTP amb opcional paràmetre de paginació.
     * @return View Vista amb la llista d'usuaris.
     */
    public function users(Request $request): View
    {
        $number = $request->input('per_page', 4); // Default 3
        $users = User::paginate($number)->appends(['per_page' => $number]);
        return view('botiga.users', compact('users'));
    }

    /**
     * Mostra el formulari per editar una botiga existent.
     *
     * Només els administradors o l'autor de la botiga poden accedir-hi.
     *
     * @param int $id Identificador únic de la botiga.
     * @return View Vista amb el formulari d'edició.
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException Si no està autoritzat.
     */
    public function editone($id): View
    {
        $botiga = Botiga::findOrFail($id);
        if (Gate::allows('access-admin') || Gate::allows('edit-botiga', $botiga)) {
            $caracteristiques = Caracteristica::all(); // Cargar características
            return view('botiga.editone', compact('botiga', 'caracteristiques'));
        }
        abort(403, 'Unauthorized!');
    }

    /**
     * Actualitza les dades d'una botiga després d'editar-les.
     *
     * @param Request $request Dades enviades pel formulari.
     * @param int $id Identificador únic de la botiga.
     * @return RedirectResponse Redirecció amb missatge d'èxit.
     */
    public function update(Request $request, $id): RedirectResponse
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

    /**
     * Emmagatzema una nova botiga a la base de dades.
     *
     * @param Request $request Dades enviades pel formulari.
     * @return RedirectResponse Redirecció cap a la llista de botigues amb missatge d'èxit.
     */
    public function store(Request $request): RedirectResponse
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

    /**
     * Elimina una botiga del sistema.
     *
     * Només es pot eliminar si l'usuari és admin o propietari de la botiga.
     *
     * @param int $id Identificador únic de la botiga.
     * @return RedirectResponse Redirecció amb missatge d’èxit o error.
     */
    public function destroy(int $id): RedirectResponse
    {
        $botiga = Botiga::findOrFail($id);
        if (Gate::allows('access-admin') || Gate::allows('edit-botiga', $botiga)) {
            $botiga->delete();
            return redirect()->route('botigues.index')->with('success', 'Botiga eliminada correctamente.');
        }
        abort(403, 'Unauthorized!');
    }

    /**
     * Actualitza el rol d'un usuari del sistema.
     *
     * Només accessible pels administradors.
     *
     * @param Request $request Petició amb nou rol.
     * @param int $id Identificador de l'usuari.
     * @return RedirectResponse Redirecció amb missatge d'èxit.
     */
    public function updateRole(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'role' => 'required|in:user,editor,admin',
        ]);
        $user = User::findOrFail($id);
        $user->role = $request->input('role');
        $user->save();
        return redirect()->route('botigues.users')->with('success', 'Rol actualizado correctamente.');
    }

    /**
     * Afegeix una botiga als favorits de l'usuari autenticat.
     *
     * @param Botiga $botiga Instància de botiga a afegir.
     * @return RedirectResponse Redirecció amb missatge d'èxit.
     */
    public function afegirFavorit(Botiga $botiga): RedirectResponse
    {
        auth()->user()->favoritos()->syncWithoutDetaching([$botiga->id]);
        return back()->with('success', 'Afegida als favorits!');
    }

    /**
     * Treu una botiga dels favorits de l'usuari autenticat.
     *
     * @param Botiga $botiga Instància de botiga a eliminar.
     * @return RedirectResponse Redirecció amb missatge d'èxit.
     */
    public function treureFavorit(Botiga $botiga): RedirectResponse
    {
        auth()->user()->favoritos()->detach($botiga->id);
        return back()->with('success', 'Eliminada dels favorits!');
    }

    /**
     * Desa una nova reseña per a una botiga.
     *
     * @param Request $request Dades de la reseña.
     * @param int $botiga_id Identificador de la botiga.
     * @return RedirectResponse Redirecció amb missatge d'èxit.
     */
    public function guardarRessenya(Request $request, int $botiga_id): RedirectResponse
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

    /**
     * Elimina una reseña específica.
     *
     * Només l'autor o un administrador poden fer-ho.
     *
     * @param Ressenya $ressenya Instància de la reseña.
     * @return RedirectResponse Redirecció amb missatge d'èxit.
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException Si no està autoritzat.
     */
    public function eliminarRessenya(Ressenya $ressenya): RedirectResponse
    {
        if (Auth::id() !== $ressenya->user_id && !Gate::allows('access-admin')) {
            abort(403, 'Unauthorized action.');
        }
        $ressenya->delete();
        return back()->with('success', 'Ressenya eliminada correctament!');
    }
}