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
        Schema::create('menciones_doctorado', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 200)->unique();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        Schema::create('modalidades_doctorado', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 150)->unique();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        Schema::create('doctorados', function (Blueprint $table) {
            $table->id();

            $table->string('ci');
            $table->foreign('ci')->references('ci')->on('personas');

            $table->string('nro_tpn', 50);
            $table->foreignId('mencion_tpn_id')->nullable()->constrained('menciones_tpn')->nullOnDelete();

            $table->unsignedInteger('nro_documento');
            $table->unsignedInteger('fojas')->nullable();
            $table->unsignedInteger('libro')->nullable();
            $table->date('fecha_emision')->nullable();

            $table->foreignId('mencion_doctorado_id')->nullable()->constrained('menciones_doctorado')->nullOnDelete();

            $table->unsignedSmallInteger('gestion_inicial')->nullable();
            $table->unsignedSmallInteger('gestion_final')->nullable();
            $table->unsignedTinyInteger('version')->nullable();

            $table->foreignId('modalidad_doctorado_id')->nullable()->constrained('modalidades_doctorado')->nullOnDelete();

            $table->string('horas_creditos', 20)->nullable();

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
        Schema::dropIfExists('doctorados');
        Schema::dropIfExists('modalidades_doctorado');
        Schema::dropIfExists('menciones_doctorado');
    }
};
