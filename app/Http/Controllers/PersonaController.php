<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Http\Request;

class PersonaController extends Controller
{

    public function index()
    {
     $personas = Persona::paginate(10); // 10 personas por página
return view('personas.index', compact('personas'));
    }


    public function create()
    {
        return view('personas.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'dni' => 'required|string|size:8|unique:personas,dni',
            'nombre_completo' => 'required',
            'fecha_nacimiento' => 'required',
            'bautizo' => 'nullable|boolean',
            'eucaristia' => 'nullable|boolean',
            'contacto' => 'required',
            'nombre_apoderado' => 'required',
            'telefono_apoderado' => 'required',
        ]);

        Persona::create([
            'dni' => $request->dni,
            'nombre_completo' => $request->nombre_completo,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'bautizo' => $request->has('bautizo'), // <- aquí el cambio
            'eucaristia' => $request->has('eucaristia'), // <- aquí también
            'contacto' => $request->contacto,
            'nombre_apoderado' => $request->nombre_apoderado,
            'telefono_apoderado' => $request->telefono_apoderado,
        ]);

        return redirect()->route('personas.index')->with('success', 'Persona registrada correctamente.');
    }


    public function show(Persona $persona) {}


    public function edit(Persona $persona)
    {
        return view('personas.edit', compact('persona'));
    }


    public function update(Request $request, Persona $persona)
    {
        $request->validate([
            'dni' => 'required|string|size:8|unique:personas,dni,' . $persona->id,
            'nombre_completo' => 'required',
            'fecha_nacimiento' => 'required',
            'bautizo' => 'nullable|boolean',
            'eucaristia' => 'nullable|boolean',
            'contacto' => 'required',
            'nombre_apoderado' => 'required',
            'telefono_apoderado' => 'required',
        ]);

        $persona->update([
            'dni' => $request->dni,
            'nombre_completo' => $request->nombre_completo,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'bautizo' => $request->has('bautizo') ? true : false,
            'eucaristia' => $request->has('eucaristia') ? true : false,
            'contacto' => $request->contacto,
            'nombre_apoderado' => $request->nombre_apoderado,
            'telefono_apoderado' => $request->telefono_apoderado,
        ]);



        return redirect()->route('personas.index')->with('success', 'Persona actualizada correctamente.');
    }

    public function destroy(Persona $persona)
    {
        $persona->delete();
        return redirect()->route('personas.index')->with('success', 'Persona eliminada correctamente.');
    }
}
