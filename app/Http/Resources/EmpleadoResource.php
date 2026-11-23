<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmpleadoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'identidad' => $this->identidad,
            'nombre' => $this->nombre,
            'apellido' => $this->apellido,
            'codigo_empleado' => (int) $this->codigo_empleado,
            'cargo' => $this->cargo,
            'salario' => (float) $this->salario,
            'salario_hnl' => 'L.' . number_format($this->salario, 2),
            'fecha_ingreso' => $this->fecha_ingreso ? Carbon::parse($this->fecha_ingreso)->format('d/m/Y') : null,
            'fecha_registro' => $this->created_at ? $this->created_at->format('d/m/Y H:i A') : null,
        ];
    }
}
