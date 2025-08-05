@props([
    'label' => '',
    'name' => '',
    'required' => false,
    'placeholder' => 'Seleccione una opción...',
    'disabled' => false,
    'value' => '',
    'options' => [],
    'showLabel' => true
])

<div>
    @if($showLabel && $label)
        <x-form-label :for="$name" :required="$required">
            {{ $label }}
        </x-form-label>
    @endif
    
    <select 
        name="{{ $name }}"
        id="{{ $name }}"
        {{ $required ? 'required' : '' }}
        {{ $disabled ? 'disabled' : '' }}
        {{ $attributes->merge(['class' => 'w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white']) }}
    >
        <option value="">{{ $placeholder }}</option>
        @if(count($options) > 0)
            @foreach($options as $optionValue => $optionLabel)
                <option value="{{ $optionValue }}" {{ old($name, $value) == $optionValue ? 'selected' : '' }}>
                    {{ $optionLabel }}
                </option>
            @endforeach
        @else
            {{ $slot }}
        @endif
    </select>
    
    @error($name)
        <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>
