<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $empleados = Empleado::all();
        return view('empleados.index', compact('empleados'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('empleados.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $datos = $request->validate([
        'identidad' => 'required|digits:13|unique:empleados,identidad',
        'nombre' => 'required|string|max:255',
        'apellido' => 'required|string|max:255',
        'codigo_empleado' => 'required|integer|unique:empleados,codigo_empleado',
        'cargo' => 'required|string|max:255',
        'salario' => 'required|numeric|min:0',
        'fecha_ingreso' => 'required|date',
    ]);

    Empleado::create($datos);

    return redirect()->route('empleados.index')
        ->with('success', 'Empleado creado correctamente.');
}

    /**
     * Display the specified resource.
     */
    public function show(Empleado $empleado)
    {
        return view('empleados.show', compact('empleado'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Empleado $empleado)
    {
        return view('empleados.edit', compact('empleado'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Empleado $empleado)
{
    $datos = $request->validate([
        'identidad' => 'required|digits:13|unique:empleados,identidad,' . $empleado->id,
        'nombre' => 'required|string|max:255',
        'apellido' => 'required|string|max:255',
        'codigo_empleado' => 'required|integer|unique:empleados,codigo_empleado,' . $empleado->id,
        'cargo' => 'required|string|max:255',
        'salario' => 'required|numeric|min:0',
        'fecha_ingreso' => 'required|date',
    ]);

    $empleado->update($datos);

    return redirect()->route('empleados.index')
        ->with('success', 'Empleado actualizado correctamente.');
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Empleado $empleado)
    {
        $empleado->delete();

        return redirect()->route('empleados.index')
            ->with('success', 'Empleado eliminado correctamente.');
    }
}