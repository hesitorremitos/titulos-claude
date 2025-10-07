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
        Schema::create('menciones_especialidad', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 200)->unique();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        Schema::create('modalidades_especialidad', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 150)->unique();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        Schema::create('especialidades', function (Blueprint $table) {
            $table->id();

            $table->string('ci');
            $table->foreign('ci')->references('ci')->on('personas');

            $table->string('nro_tpn', 50);
            $table->foreignId('mencion_tpn_id')
                ->nullable()
                ->constrained('menciones_tpn')
                ->nullOnDelete();

            $table->string('sexo', 20)->nullable();

            $table->unsignedInteger('nro_documento');
            $table->unsignedInteger('fojas')->nullable();
            $table->unsignedInteger('libro')->nullable();
            $table->date('fecha_emision')->nullable();

            $table->foreignId('mencion_especialidad_id')
                ->nullable()
                ->constrained('menciones_especialidad')
                ->nullOnDelete();

            $table->unsignedSmallInteger('gestion')->nullable();
            $table->unsignedTinyInteger('version')->nullable();

            $table->foreignId('modalidad_especialidad_id')
                ->nullable()
                ->constrained('modalidades_especialidad')
                ->nullOnDelete();

            $table->string('horas_academicas', 50)->nullable();
            $table->boolean('promedio_final')->default(false);

            $table->foreignId('universidad_id')->constrained('universidades');

            $table->string('file_dir', 500)->nullable();
            $table->boolean('verificado')->default(false);

            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');

            $table->timestamps();

            $table->unique('nro_tpn');
            $table->unique(['nro_documento', 'libro', 'fojas']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('especialidades');
        Schema::dropIfExists('modalidades_especialidad');
        Schema::dropIfExists('menciones_especialidad');
    }
};
