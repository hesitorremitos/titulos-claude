@props([
    'icon' => '',
    'type' => 'text',
    'name' => '',
    'placeholder' => '',
    'value' => '',
    'disabled' => false
])

<div class="relative">
    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
        <span class="{{ $icon }} w-5 h-5 text-gray-400" aria-hidden="true"></span>
    </div>
    <input 
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        placeholder="{{ $placeholder }}"
        value="{{ $value }}"
        {{ $disabled ? 'disabled' : '' }}
        {{ $attributes->merge(['class' => 'block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 text-sm']) }}
    >
</div>