@props([
    'type' => 'info', // info, success, warning, error
    'icon' => null,
    'dismissible' => false
])

@php
    $classes = match($type) {
        'success' => 'bg-green-50 border-green-200 text-green-800',
        'error' => 'bg-red-50 border-red-200 text-red-800',
        'warning' => 'bg-yellow-50 border-yellow-200 text-yellow-800',
        'info' => 'bg-blue-50 border-blue-200 text-blue-800',
        default => 'bg-blue-50 border-blue-200 text-blue-800'
    };

    $iconClasses = match($type) {
        'success' => 'text-green-600',
        'error' => 'text-red-600',
        'warning' => 'text-yellow-600',
        'info' => 'text-blue-600',
        default => 'text-blue-600'
    };

    $defaultIcon = match($type) {
        'success' => 'mdi--check-circle',
        'error' => 'mdi--alert-circle',
        'warning' => 'mdi--alert',
        'info' => 'mdi--information',
        default => 'mdi--information'
    };

    $iconName = $icon ?? $defaultIcon;
@endphp

<div {{ $attributes->merge(['class' => "p-4 border rounded-lg $classes"]) }}>
    <div class="flex items-center">
        <span class="icon-[{{ $iconName }}] {{ $iconClasses }} mr-2"></span>
        <div class="flex-1">
            {{ $slot }}
        </div>
        @if($dismissible)
            <button type="button" class="self-start ml-4 {{ $iconClasses }} hover:opacity-75" onclick="this.parentElement.parentElement.remove()">
                <span class="icon-[mdi--close] h-4 w-4"></span>
            </button>
        @endif
    </div>
</div>