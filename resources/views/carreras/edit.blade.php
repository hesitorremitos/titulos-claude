@extends('layouts.app')

@section('title', 'Editar Carrera')

@section('header')
    <div class="flex items-center">
        <span class="icon-[mdi--pencil] text-primary-600 dark:text-primary-400 w-6 h-6 mr-3"></span>
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
            Editar Carrera
        </h2>
    </div>
    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
        Modifica la información de la carrera: {{ $carrera->programa }}
    </p>
@endsection

@section('content')
<div class="max-w-2xl">
    <x-card title="Información de la Carrera">
        <form action="{{ route('carreras.update', $carrera) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-form-input
                    label="Código de la Carrera"
                    name="id"
                    icon="icon-[mdi--identifier]"
                    placeholder="Ej: INFR1"
                    maxlength="5"
                    style="text-transform: uppercase;"
                    :value="$carrera->id"
                    required
                />
                
                <x-form-select
                    label="Facultad"
                    name="facultad_id"
                    icon="icon-[mdi--school]"
                    required
                >
                    @foreach($facultades as $facultad)
                        <option value="{{ $facultad->id }}" {{ $carrera->facultad_id == $facultad->id ? 'selected' : '' }}>
                            {{ $facultad->nombre }}
                        </option>
                    @endforeach
                </x-form-select>
            </div>
            
            <x-form-input
                label="Nombre del Programa"
                name="programa"
                icon="icon-[mdi--book-education]"
                placeholder="Ej: Ingeniería Informática"
                :value="$carrera->programa"
                required
            />
            
            <x-form-input
                label="Dirección"
                name="direccion"
                icon="icon-[mdi--map-marker]"
                placeholder="Dirección física de la carrera (opcional)"
                :value="$carrera->direccion"
            />
            
            <div class="flex justify-end space-x-3">
                <x-button 
                    href="{{ route('carreras.index') }}" 
                    variant="outline"
                    icon="icon-[mdi--arrow-left]"
                >
                    Cancelar
                </x-button>
                
                <x-button 
                    type="submit"
                    icon="icon-[mdi--content-save]"
                >
                    Actualizar Carrera
                </x-button>
            </div>
        </form>
    </x-card>
</div>

@push('scripts')
<script>
// Convertir el código a mayúsculas automáticamente
document.getElementById('id').addEventListener('input', function(e) {
    e.target.value = e.target.value.toUpperCase();
});
</script>
@endpush
@endsection
