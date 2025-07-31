@extends('layouts.guest')

@section('content')
<div>
    <div class="mb-4 text-center">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
            Iniciar Sesión
        </h2>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
            Ingrese su CI y contraseña para acceder al sistema
        </p>
    </div>

    <form action="{{ route('login') }}" method="POST" class="space-y-6">
        @csrf
        
        <div>
            <label for="ci" class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300">
                <span class="icon-[mdi--card-account-details] inline-block mr-2 text-gray-500 dark:text-gray-400 w-4 h-4" aria-hidden="true"></span>
                Carnet de Identidad (CI)
            </label>
            <input 
                type="text" 
                id="ci" 
                name="ci"
                value="{{ old('ci') }}"
                class="mt-1 block w-full px-3 py-2 border rounded-md shadow-sm 
                       bg-white dark:bg-gray-700 text-gray-900 dark:text-white
                       focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 
                       dark:focus:ring-primary-400 dark:focus:border-primary-400
                       transition-colors duration-200
                       {{ $errors->has('ci') ? 'border-red-500 dark:border-red-400' : 'border-gray-300 dark:border-gray-600' }}"
                placeholder="Ingrese su CI"
                autocomplete="username"
                required
            >
            @error('ci')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400 flex items-center">
                    <span class="icon-[mdi--alert-circle] inline-block mr-1 w-4 h-4" aria-hidden="true"></span>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div>
            <label for="password" class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300">
                <span class="icon-[mdi--lock] inline-block mr-2 text-gray-500 dark:text-gray-400 w-4 h-4" aria-hidden="true"></span>
                Contraseña
            </label>
            <input 
                type="password" 
                id="password" 
                name="password"
                class="mt-1 block w-full px-3 py-2 border rounded-md shadow-sm 
                       bg-white dark:bg-gray-700 text-gray-900 dark:text-white
                       focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 
                       dark:focus:ring-primary-400 dark:focus:border-primary-400
                       transition-colors duration-200
                       {{ $errors->has('password') ? 'border-red-500 dark:border-red-400' : 'border-gray-300 dark:border-gray-600' }}"
                placeholder="Ingrese su contraseña"
                autocomplete="current-password"
                required
            >
            @error('password')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400 flex items-center">
                    <span class="icon-[mdi--alert-circle] inline-block mr-1 w-4 h-4" aria-hidden="true"></span>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div class="flex items-center">
            <input 
                id="remember" 
                name="remember" 
                type="checkbox" 
                value="1"
                {{ old('remember') ? 'checked' : '' }}
                class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 dark:border-gray-600 
                       dark:bg-gray-700 rounded"
            >
            <label for="remember" class="ml-2 flex items-center text-sm text-gray-700 dark:text-gray-300">
                <span class="icon-[mdi--checkbox-marked-circle] inline-block mr-1 text-gray-500 dark:text-gray-400 w-4 h-4" aria-hidden="true"></span>
                Recordar sesión
            </label>
        </div>

        <div>
            <button 
                type="submit" 
                class="w-full flex justify-center items-center py-2 px-4 border border-transparent rounded-md shadow-sm 
                       text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 
                       focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500
                       dark:focus:ring-offset-gray-800 transition-colors duration-200"
            >
                <span class="icon-[mdi--login] inline-block mr-2 w-4 h-4" aria-hidden="true"></span>
                Iniciar Sesión
            </button>
        </div>
    </form>
</div>
@endsection
