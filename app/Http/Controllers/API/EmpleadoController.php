<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\EmpleadoResource;
use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EmpleadoController extends Controller
{
    public function index()
    {
        $empleados = Empleado::paginate(10);

        return response()->json([
            'status' => 'success',
            'data'   => EmpleadoResource::collection($empleados),
            'pagination' => [
                'total'        => $empleados->total(),
                'per_page'     => $empleados->perPage(),
                'current_page' => $empleados->currentPage(),
                'last_page'    => $empleados->lastPage(),
            ]
        ], 200);
    }

    public function store(Request $request)
    {
        $validados = $request->validate([
            'identidad'       => 'required|digits:13|unique:empleados,identidad',
            'nombre'          => 'required|string|max:255',
            'apellido'        => 'required|string|max:255',
            'codigo_empleado' => 'required|integer|unique:empleados,codigo_empleado',
            'cargo'           => 'required|string|max:255',
            'salario'         => 'required|numeric|min:0',
            'fecha_ingreso'   => 'required|date',
        ]);

        $empleado = Empleado::create($validados);

        return response()->json([
            'status'  => 'created',
            'message' => 'Empleado registrado correctamente',
            'data'    => new EmpleadoResource($empleado)
        ], 201);
    }

    public function show(string $id)
    {
        $empleado = Empleado::find($id);

        if (!$empleado) {
            return response()->json([
                'status'  => 'error',
                'message' => "El empleado con ID {$id} no existe"
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data'   => new EmpleadoResource($empleado)
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $empleado = Empleado::find($id);

        if (!$empleado) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Empleado no encontrado para actualizar'
            ], 404);
        }

        $validados = $request->validate([
            'identidad'       => ['required', 'digits:13', Rule::unique('empleados', 'identidad')->ignore($empleado->id)],
            'nombre'          => 'required|string|max:255',
            'apellido'        => 'required|string|max:255',
            'codigo_empleado' => ['required', 'integer', Rule::unique('empleados', 'codigo_empleado')->ignore($empleado->id)],
            'cargo'           => 'required|string|max:255',
            'salario'         => 'required|numeric|min:0',
            'fecha_ingreso'   => 'required|date',
        ]);

        $empleado->update($validados);

        return response()->json([
            'status'  => 'updated',
            'message' => 'Empleado actualizado correctamente',
            'data'    => new EmpleadoResource($empleado)
        ], 200);
    }

    public function destroy(string $id)
    {
        $empleado = Empleado::find($id);

        if (!$empleado) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Empleado no encontrado para eliminar'
            ], 404);
        }

        $empleado->delete();

        return response()->json([
            'status'  => 'deleted',
            'message' => 'Empleado eliminado correctamente'
        ], 200);
    }
}