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
        // Crear tabla para títulos de provisión nacional (TPN)
        Schema::create('titulo_provision_nacional', function (Blueprint $table) {
            $table->id();
            $table->string('ci');
            $table->unsignedInteger('nro_documento');
            $table->unsignedInteger('fojas');
            $table->unsignedInteger('libro');
            $table->date('fecha_emision')->nullable();
            $table->string('observaciones')->nullable();
            $table->foreignId('mencion_tpn_id')->constrained('menciones_tpn', 'id')->nullable();
            $table->foreignId('modalidad_tpn_id')->constrained('modalidades_tpn', 'id')->nullable();
            $table->string('file_dir', 500)->nullable();
            $table->boolean('verificado')->default(false);

            // Campos de trazabilidad
            $table->foreignId('created_by')->constrained('users', 'id');
            $table->foreignId('updated_by')->nullable()->constrained('users', 'id');

            $table->timestamps();

            // Llave foránea para ci con la tabla personas
            $table->foreign('ci')->references('ci')->on('personas');
            $table->unique(['libro', 'fojas', 'nro_documento']);
            });

        // Crear tabla para menciones de Título Provisional Nacional
        Schema::create('menciones_tpn', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 200)->unique();
            $table->char('carrera_id', 5);
            $table->foreign('carrera_id')->references('id')->on('carreras');
            $table->text('descripcion')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        // Crear tabla para modalidades de graduación de Título Provisional Nacional
        Schema::create('modalidades_tpn', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100)->unique();
            $table->text('descripcion')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menciones_tpn');
        Schema::dropIfExists('modalidades_tpn');
        Schema::dropIfExists('titulo_provision_nacional');
    }
};