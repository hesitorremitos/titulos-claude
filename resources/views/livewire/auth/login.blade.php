<div>
    <div class="mb-4 text-center">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
            Iniciar Sesión
        </h2>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
            Ingrese su CI y contraseña para acceder al sistema
        </p>
    </div>

    <form wire:submit="login" class="space-y-6">
        <div>
            <label for="ci" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Carnet de Identidad (CI)
            </label>
            <input 
                wire:model="ci" 
                type="text" 
                id="ci" 
                name="ci"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm 
                       bg-white dark:bg-gray-700 text-gray-900 dark:text-white
                       focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 
                       dark:focus:ring-primary-400 dark:focus:border-primary-400
                       @error('ci') border-red-500 dark:border-red-400 @enderror"
                placeholder="Ingrese su CI"
                autocomplete="username"
            >
            @error('ci')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Contraseña
            </label>
            <input 
                wire:model="password" 
                type="password" 
                id="password" 
                name="password"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm 
                       bg-white dark:bg-gray-700 text-gray-900 dark:text-white
                       focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 
                       dark:focus:ring-primary-400 dark:focus:border-primary-400
                       @error('password') border-red-500 dark:border-red-400 @enderror"
                placeholder="Ingrese su contraseña"
                autocomplete="current-password"
            >
            @error('password')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center">
            <input 
                wire:model="remember" 
                id="remember" 
                name="remember" 
                type="checkbox" 
                class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 dark:border-gray-600 
                       dark:bg-gray-700 rounded"
            >
            <label for="remember" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                Recordar sesión
            </label>
        </div>

        <div>
            <button 
                type="submit" 
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm 
                       text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 
                       focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500
                       dark:focus:ring-offset-gray-800 disabled:opacity-50 disabled:cursor-not-allowed
                       transition-colors duration-200"
                wire:loading.attr="disabled"
            >
                <span wire:loading.remove>Iniciar Sesión</span>
                <span wire:loading class="flex items-center">
                    <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Iniciando sesión...
                </span>
            </button>
        </div>
    </form>
</div>
