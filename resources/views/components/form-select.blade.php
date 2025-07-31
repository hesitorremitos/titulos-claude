@props(['label', 'name', 'required' => false, 'placeholder' => 'Seleccione una opción...', 'value' => '', 'icon' => null])

<div>
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
        @if($icon)
            <span class="{{ $icon }} w-4 h-4 inline mr-1"></span>
        @endif
        {{ $label }}
        @if($required)
            <span class="text-red-500">*</span>
        @endif
    </label>
    
    <select 
        id="{{ $name }}" 
        name="{{ $name }}" 
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class' => 'w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white']) }}
    >
        <option value="">{{ $placeholder }}</option>
        {{ $slot }}
    </select>
    
    @error($name)
        <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>
