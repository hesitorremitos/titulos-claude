@props([
    'label' => '',
    'name' => '',
    'type' => 'text',
    'required' => false,
    'placeholder' => '',
    'value' => '',
    'icon' => null,
    'state' => 'default', // default, success, error
    'helpText' => null,
    'showLabel' => true
])

@php
$baseClasses = 'w-full px-3 py-2 rounded-md shadow-sm focus:outline-none focus:ring-2 transition-colors duration-200 dark:bg-gray-700 dark:text-white placeholder-gray-400 dark:placeholder-gray-500';

$stateClasses = match($state) {
    'success' => 'border border-green-300 dark:border-green-600 focus:ring-green-500 focus:border-green-500',
    'error' => 'border border-red-300 dark:border-red-600 focus:ring-red-500 focus:border-red-500',
    default => 'border border-gray-300 dark:border-gray-600 focus:ring-primary-500 focus:border-primary-500'
};

$iconLeftPadding = $icon ? 'pl-10' : 'pl-3';
$inputClasses = $baseClasses . ' ' . $stateClasses . ' ' . $iconLeftPadding;
@endphp

<div>
    @if($showLabel && $label)
        <x-form-label :for="$name" :required="$required" :icon="$showLabel && !$icon ? null : null">
            {{ $label }}
        </x-form-label>
    @endif
    
    @if($icon)
        <div class="relative">
            <span class="icon-[{{ $icon }}] w-5 h-5 absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400" aria-hidden="true"></span>
            <input 
                type="{{ $type }}"
                id="{{ $name }}"
                name="{{ $name }}"
                value="{{ old($name, $value) }}"
                placeholder="{{ $placeholder }}"
                {{ $required ? 'required' : '' }}
                class="{{ $inputClasses }}"
                {{ $attributes->except(['label', 'name', 'type', 'required', 'placeholder', 'value', 'icon', 'state', 'helpText', 'showLabel']) }}
            >
        </div>
    @else
        <input 
            type="{{ $type }}"
            id="{{ $name }}"
            name="{{ $name }}"
            value="{{ old($name, $value) }}"
            placeholder="{{ $placeholder }}"
            {{ $required ? 'required' : '' }}
            class="{{ $inputClasses }}"
            {{ $attributes->except(['label', 'name', 'type', 'required', 'placeholder', 'value', 'icon', 'state', 'helpText', 'showLabel']) }}
        >
    @endif
    
    @if($helpText && $state === 'default')
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $helpText }}</p>
    @endif
    
    @if($state === 'success')
        <p class="mt-1 text-sm text-green-600 dark:text-green-400">Campo validado correctamente</p>
    @endif
    
    @error($name)
        <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>
