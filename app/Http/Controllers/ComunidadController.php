<?php

namespace App\Http\Controllers;

use App\Models\Comunidad;
use App\Models\Mesa;
use App\Models\Persona;
use Illuminate\Http\Request;

class ComunidadController extends Controller
{
    public function index()
{
    $comunidades = Comunidad::with('persona', 'mesa')->get();
    $personasSinComunidad = Persona::doesntHave('comunidad')->get();
    $mesas = Mesa::all();

    return view('comunidades.index', compact('comunidades', 'personasSinComunidad', 'mesas'));
}

    public function store(Request $request)
    {
        $request->validate([
            'mesa_id' => 'required|exists:mesas,id',
            'personas' => 'required|array',
            'personas.*' => 'exists:personas,id',
        ]);

        foreach ($request->personas as $personaId) {
            Comunidad::firstOrCreate([
                'mesa_id' => $request->mesa_id,
                'persona_id' => $personaId,
            ]);
        }

        return back()->with('success', 'Personas asignadas correctamente.');
    }

    public function listado()
    {
        $comunidades = Comunidad::with(['persona', 'mesa'])->get();

        return view('comunidades.listado', compact('comunidades'));
    }

    public function destroy($id)
    {
        // Buscar la comunidad por id
        $comunidad = Comunidad::findOrFail($id);

        // Eliminar el registro
        $comunidad->delete();

        // Redirigir con mensaje de éxito
        return redirect()->route('comunidades.listado')
            ->with('success', 'La comunidad fue eliminada correctamente.');
    }
}
