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
        // Crear tabla para nuevos títulos académicos
        Schema::create('titulo_academicos', function (Blueprint $table) {
            $table->id();
            $table->string('ci');
            $table->unsignedInteger('nro_documento');
            $table->unsignedInteger('fojas');
            $table->unsignedInteger('libro');
            $table->date('fecha_emision')->nullable();
            $table->string('nro_diploma_academico'); // Campo específico para este tipo de título
            $table->string('observaciones')->nullable();
            $table->foreignId('graduacion_id')->constrained('graduacion_da', 'id')->nullable();
            $table->string('file_dir', 500)->nullable();
            $table->boolean('verificado')->default(false);

            // Campos de trazabilidad
            $table->foreignId('created_by')->constrained('users', 'id');
            $table->foreignId('updated_by')->nullable()->constrained('users', 'id');

            $table->timestamps();

            // Llave foránea para ci con la tabla personas
            $table->foreign('ci')->references('ci')->on('personas');
            $table->unique(['libro', 'fojas', 'nro_documento']);
            $table->unique(['ci', 'nro_diploma_academico']); // Único por persona
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('titulo_academicos');
    }
};
