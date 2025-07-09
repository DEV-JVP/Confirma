<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AsistenciaController extends Controller
{
    public function resumen()
    {
        // Obtener todas las fechas distintas en orden ascendente
        $fechas = Asistencia::select('fecha')->distinct()->orderBy('fecha')->pluck('fecha');

        // Obtener todas las personas
        $personas = Persona::orderBy('nombre_completo')->get();

        // Obtener todas las asistencias
        $asistencias = Asistencia::all()->groupBy('persona_id');

        // Crear un arreglo con los datos de presencia por persona y fecha
        $resumen = [];

        foreach ($personas as $persona) {
            foreach ($fechas as $fecha) {
                $registro = $asistencias->get($persona->id)?->firstWhere('fecha', $fecha);
                $resumen[$persona->id][$fecha] = $registro ? ($registro->asistio ? '✔️' : '❌') : '—';
            }
        }

        return view('asistencias.resumen', compact('personas', 'fechas', 'resumen'));
    }
    public function index(Request $request)
    {
        // Obtener todas las personas, ordenadas por nombre_completo
        $personas = Persona::orderBy('nombre_completo')->get();

        // Obtener la fecha seleccionada o usar la fecha actual
        $fechaActual = $request->fecha ?? date('Y-m-d');

        // Obtener todas las fechas disponibles para el selector
        $fechasDisponibles = Asistencia::select('fecha')
            ->distinct()
            ->orderBy('fecha', 'desc')
            ->pluck('fecha')
            ->toArray();

        // Si no hay fechas o la fecha actual no está en la lista, añadirla
        if (empty($fechasDisponibles) || !in_array($fechaActual, $fechasDisponibles)) {
            $fechasDisponibles[] = $fechaActual;
        }

        // Obtener las asistencias para la fecha seleccionada
        $asistencias = Asistencia::where('fecha', $fechaActual)
            ->get()
            ->keyBy('persona_id')
            ->map(function ($item) {
                return $item->asistio;
            })
            ->toArray();

        // Calcular estadísticas
        $totalAsistencias = count(array_filter($asistencias));

        return view('asistencias.index', compact(
            'personas',
            'fechaActual',
            'fechasDisponibles',
            'asistencias',
            'totalAsistencias'
        ));
    }

    /**
     * Muestra el formulario para crear una nueva fecha de asistencia.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('asistencias.create');
    }

    /**
     * Almacena una nueva asistencia en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'persona_id' => 'required|exists:personas,id',
            'fecha' => 'required|date',
            'asistio' => 'required|boolean',
        ]);

        // Verificar si ya existe un registro para esta persona y fecha
        $asistencia = Asistencia::where('persona_id', $request->persona_id)
            ->where('fecha', $request->fecha)
            ->first();

        if ($asistencia) {
            // Actualizar el registro existente
            $asistencia->update(['asistio' => $request->asistio]);
        } else {
            // Crear un nuevo registro
            Asistencia::create($request->all());
        }

        return redirect()->route('asistencias.index', ['fecha' => $request->fecha])
            ->with('success', 'Asistencia registrada correctamente.');
    }

    /**
     * Almacena una nueva fecha de asistencia y redirige al index.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeFecha(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
        ]);

        return redirect()->route('asistencias.index', ['fecha' => $request->fecha])
            ->with('success', 'Nueva fecha de asistencia creada. Marque las asistencias a continuación.');
    }

    /**
     * Marca o desmarca una asistencia vía AJAX.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggle(Request $request)
    {
        $request->validate([
            'persona_id' => 'required|exists:personas,id',
            'fecha' => 'required|date',
            'asistio' => 'required|boolean',
        ]);

        // Buscar si ya existe un registro para esta persona y fecha
        $asistencia = Asistencia::where('persona_id', $request->persona_id)
            ->where('fecha', $request->fecha)
            ->first();

        if ($asistencia) {
            // Actualizar el registro existente
            $asistencia->update(['asistio' => $request->asistio]);
        } else {
            // Crear un nuevo registro
            Asistencia::create([
                'persona_id' => $request->persona_id,
                'fecha' => $request->fecha,
                'asistio' => $request->asistio,
            ]);
        }

        // Calcular estadísticas actualizadas
        $totalPersonas = Persona::count();
        $totalAsistencias = Asistencia::where('fecha', $request->fecha)
            ->where('asistio', 1)
            ->count();
        $totalAusencias = $totalPersonas - $totalAsistencias;
        $porcentajeAsistencia = $totalPersonas > 0 ? round(($totalAsistencias / $totalPersonas) * 100) : 0;

        return response()->json([
            'success' => true,
            'totalAsistencias' => $totalAsistencias,
            'totalAusencias' => $totalAusencias,
            'porcentajeAsistencia' => $porcentajeAsistencia
        ]);
    }

    /**
     * Muestra el formulario para editar una asistencia específica.
     *
     * @param  \App\Models\Asistencia  $asistencia
     * @return \Illuminate\View\View
     */
    public function edit(Asistencia $asistencia)
    {
        $personas = Persona::orderBy('nombre_completo')->get();
        return view('asistencias.edit', compact('asistencia', 'personas'));
    }

    /**
     * Actualiza una asistencia específica en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Asistencia  $asistencia
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Asistencia $asistencia)
    {
        $request->validate([
            'persona_id' => 'required|exists:personas,id',
            'fecha' => 'required|date',
            'asistio' => 'required|boolean',
            'observacion' => 'nullable|string|max:255',
        ]);

        $asistencia->update($request->all());

        return redirect()->route('asistencias.index', ['fecha' => $asistencia->fecha])
            ->with('success', 'Asistencia actualizada correctamente.');
    }

    /**
     * Elimina una asistencia específica de la base de datos.
     *
     * @param  \App\Models\Asistencia  $asistencia
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Asistencia $asistencia)
    {
        $fecha = $asistencia->fecha;
        $asistencia->delete();

        return redirect()->route('asistencias.index', ['fecha' => $fecha])
            ->with('success', 'Asistencia eliminada correctamente.');
    }

    /**
     * Marca o desmarca todas las asistencias para una fecha específica.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleAll(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
            'asistio' => 'required|boolean',
        ]);

        $fecha = $request->fecha;
        $asistio = $request->asistio;
        $personas = Persona::all();

        // Usar una transacción para asegurar que todas las operaciones se completen o ninguna
        DB::beginTransaction();

        try {
            foreach ($personas as $persona) {
                // Buscar si ya existe un registro para esta persona y fecha
                $asistencia = Asistencia::where('persona_id', $persona->id)
                    ->where('fecha', $fecha)
                    ->first();

                if ($asistencia) {
                    // Actualizar el registro existente
                    $asistencia->update(['asistio' => $asistio]);
                } else {
                    // Crear un nuevo registro
                    Asistencia::create([
                        'persona_id' => $persona->id,
                        'fecha' => $fecha,
                        'asistio' => $asistio,
                    ]);
                }
            }

            DB::commit();

            // Calcular estadísticas actualizadas
            $totalPersonas = $personas->count();
            $totalAsistencias = $asistio ? $totalPersonas : 0;
            $totalAusencias = $asistio ? 0 : $totalPersonas;
            $porcentajeAsistencia = $asistio ? 100 : 0;

            return response()->json([
                'success' => true,
                'totalAsistencias' => $totalAsistencias,
                'totalAusencias' => $totalAusencias,
                'porcentajeAsistencia' => $porcentajeAsistencia
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar las asistencias: ' . $e->getMessage()
            ], 500);
        }
    }

    public function guardar(Request $request)
{
    $fecha = $request->input('fecha');
    $asistencias = $request->input('asistencias', []); // array de IDs de personas que asistieron

    // Primero eliminamos todas las asistencias de esa fecha
    Asistencia::where('fecha', $fecha)->delete();

    // Luego insertamos las nuevas asistencias
    foreach ($asistencias as $persona_id) {
        Asistencia::create([
            'persona_id' => $persona_id,
            'fecha' => $fecha,
            'asistio' => true,
        ]);
    }

    return redirect()->route('asistencias.index', ['fecha' => $fecha])
                     ->with('success', 'Asistencias guardadas correctamente.');
}

}
