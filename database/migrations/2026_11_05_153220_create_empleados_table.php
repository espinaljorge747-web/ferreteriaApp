<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {   if(Schema::hasTable('empleados')){
            return;
        }
        Schema::create('empleados', function (Blueprint $table) {
            $table->id();
            $table->string('identidad', 13)->unique();
            $table->string('nombre', 255);
            $table->string('apellido', 255);
            $table->integer('codigo_empleado')->unique();
            $table->string('cargo', 255);
            $table->decimal('salario', 10, 2);
            $table->date('fecha_ingreso');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
};