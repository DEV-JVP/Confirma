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
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->id();
            $table->string('dni')->unique();
            $table->string('nombre_completo');
            $table->string('fecha_nacimiento');
            $table->boolean('bautizo')->default(false);
            $table->boolean('eucaristia')->default(false);
            $table->string('contacto');
            $table->string('nombre_apoderado');
            $table->string('telefono_apoderado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personas');
    }
};
