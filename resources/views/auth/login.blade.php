@extends('layouts.guest')

@section('title', 'Iniciar Sesión - UATF Títulos')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-semibold text-gray-900 text-center">Iniciar Sesión</h2>
    <p class="text-gray-600 text-center mt-2">Ingresa tus credenciales para acceder</p>
</div>

<!-- Session Status -->
@if (session('status'))
    <x-ui.alert type="success" class="mb-4">
        <span class="text-sm">{{ session('status') }}</span>
    </x-ui.alert>
@endif

<form method="POST" action="{{ route('login') }}" x-data="loginForm()">
    @csrf

    <!-- CI Field -->
    <x-form.input 
        name="ci"
        label="Carnet de Identidad"
        icon="mdi--card-account-details-outline"
        placeholder="Ingresa tu CI"
        required
        autofocus
        autocomplete="username"
        x-model="ci"
        @input="clearErrors('ci')"
        ::class="{ 'border-red-500 bg-red-50': errors.ci }"
    />

    <!-- Password Field -->
    <x-form.input 
        name="password"
        type="password"
        label="Contraseña"
        icon="mdi--lock-outline"
        placeholder="Ingresa tu contraseña"
        required
        autocomplete="current-password"
        show-password-toggle
        x-model="password"
        @input="clearErrors('password')"
        ::class="{ 'border-red-500 bg-red-50': errors.password }"
    />

    <!-- Remember Me -->
    <div class="flex items-center justify-between mb-6">
        <label for="remember" class="flex items-center cursor-pointer">
            <input 
                id="remember" 
                name="remember" 
                type="checkbox" 
                x-model="remember"
                class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded"
            />
            <span class="ml-2 text-sm text-gray-600">Recordar sesión</span>
        </label>
    </div>

    <!-- Submit Button -->
    <x-form.button 
        type="submit"
        variant="primary"
        icon="mdi--login"
        full-width
        @click="submitForm()"
        ::disabled="!canSubmit || loading"
        ::loading="loading"
        loading-text="Iniciando sesión..."
        ::class="{ 'opacity-75 cursor-not-allowed': !canSubmit || loading }"
    >
        Iniciar Sesión
    </x-form.button>
</form>
@endsection

@push('scripts')
<script>
    function loginForm() {
        return {
            ci: '{{ old('ci') }}',
            password: '',
            remember: false,
            loading: false,
            errors: {},

            get canSubmit() {
                return this.ci.length >= 6 && this.password.length > 0;
            },

            clearErrors(field) {
                if (this.errors[field]) {
                    delete this.errors[field];
                }
            },

            submitForm() {
                if (this.canSubmit && !this.loading) {
                    this.loading = true;
                    return true;
                }
                return false;
            },

            init() {
                // Asegurar que loading inicie en false
                this.loading = false;
                
                // Handle validation errors from server
                @if ($errors->any())
                    this.errors = @json($errors->messages());
                    // Si hay errores, asegurar que loading esté en false
                    this.loading = false;
                @endif
            }
        }
    }
</script>
@endpush