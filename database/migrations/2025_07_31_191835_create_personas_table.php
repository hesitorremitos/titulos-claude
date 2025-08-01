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
            $table->string('ci')->primary();
            $table->string('nombres');
            $table->string('paterno')->nullable();
            $table->string('materno')->nullable();
            $table->date('fecha_nacimiento')->nullable();

            // Genero de persona, puede ser M (masculino), F (femenino) u O (otro)
            $table->enum('genero', ['M', 'F', 'O'])->nullable();

            $table->string('pais', 50)->nullable();
            $table->string('departamento', 50)->nullable();
            $table->string('provincia', 50)->nullable();
            $table->string('localidad', 50)->nullable();
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
